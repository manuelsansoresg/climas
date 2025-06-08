<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\SaleDetail;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['client', 'user'])->latest()->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $clients = User::role(['Cliente publico en general', 'Cliente mayorista', 'Cliente instalador'])->get();
        return view('admin.sales.create', compact('clients', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,credit_card,transfer',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $iva = 0;
            $total = 0;
            
            // Agrupar cantidades por producto
            $productQuantities = [];
            foreach ($request->products as $item) {
                if (!isset($productQuantities[$item['product_id']])) {
                    $productQuantities[$item['product_id']] = 0;
                }
                $productQuantities[$item['product_id']] += $item['quantity'];
            }

            // Validar stock por producto
            foreach ($productQuantities as $productId => $totalQuantity) {
                $product = Product::findOrFail($productId);
                if ($product->stock() < $totalQuantity) {
                    throw new \Exception("Stock insuficiente para el producto: {$product->name}");
                }
            }

            // Validar precio unitario vs costo real para usuarios no admin
            $user = auth()->user();
            $isAdmin = false;
            if ($user && method_exists($user, 'hasAnyRole')) {
                $isAdmin = $user->hasAnyRole(['Admin']);
            }
            Log::info('Venta: usuario autenticado', ['user_id' => $user ? $user->id : null, 'is_admin' => $isAdmin]);
            
            $needsAuthorization = false;
            $authorizationKey = $request->input('admin_unlock_key');
            $invalidProducts = [];
            
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);
                $realCost = $product->latestEntryCost();
                $unitPrice = isset($item['price']) ? $item['price'] : $this->getPriceByUserRole($product, $request->client_id);
                
                if ($realCost !== null && $unitPrice <= $realCost) {
                    $invalidProducts[] = [
                        'name' => $product->name,
                        'real_cost' => $realCost,
                        'unit_price' => $unitPrice
                    ];
                    $needsAuthorization = true;
                }
            }
            
            if ($needsAuthorization) {
                if (!$authorizationKey || !\App\Models\AdminUnlockKey::validateKey($authorizationKey)) {
                    return response()->json([
                        'success' => false,
                        'authorization_required' => true,
                        'invalid_products' => $invalidProducts,
                        'message' => 'Se requiere autorización para vender por debajo del costo real. Clave incorrecta o no proporcionada.'
                    ], 422);
                }
            }

            // Calcular totales
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = isset($item['price']) ? $item['price'] : $this->getPriceByUserRole($product, $request->client_id);
                $itemSubtotal = $price * $item['quantity'];
                $itemIva = $itemSubtotal * ($product->iva / 100);
                $subtotal += $itemSubtotal;
                $iva += $itemIva;
            }
            $total = $subtotal + $iva;
            
            // Create sale
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'client_id' => $request->client_id,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'status' => $request->status,
                'payment_status' => 'paid'
            ]);
            // Create sale details
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = isset($item['price']) ? $item['price'] : $this->getPriceByUserRole($product, $request->client_id);
                $itemSubtotal = $price * $item['quantity'];
                $itemIva = $itemSubtotal * ($product->iva / 100);

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                    'iva' => $itemIva,
                    'total' => $itemSubtotal + $itemIva,
                    'price_type' => $this->getUserRole()
                ]);

                // Update product stock
                $product->decrement('stock', $item['quantity']);

                if ($request->status == 2) { //pagado
                    // Crear salida en inventario
                    ProductSale::create([
                        'product_id' => $item['product_id'],
                        'warehouse_id' => $request->warehouse_id, // si usas almacenes
                        'quantity' => $item['quantity'],
                        'sale_price' => $price,
                        'sale_date' => now(),
                    ]);
                }

            }
           
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Venta creada exitosamente',
                'redirect' => route('admin.sales.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la venta: ' . $e->getMessage()
            ], 422);
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['client', 'user', 'details.product']);
        return view('admin.sales.show', compact('sale'));
    }

    public function reports()
    {
        $sales = Sale::with(['client', 'user', 'details.product'])
            ->latest()
            ->paginate(10);
            
        $totalSales = Sale::count();
        $totalRevenue = Sale::sum('total');
        $averageSale = Sale::avg('total');
        
        return view('admin.sales.reports', compact('sales', 'totalSales', 'totalRevenue', 'averageSale'));
    }

    private function getPriceByUserRole($product, $userId = null)
    {
        $user = $userId == null ? auth()->user() : User::find($userId);
        if (!$user || !($user instanceof \App\Models\User)) {
            return $product->precio_publico;
        }
        if ($user->hasRole('Cliente mayorista')) {
            return $product->precio_mayorista;
        }
        if ($user->hasRole('Cliente instalador')) {
            return $product->precio_instalador * 0.9; // 10% discount for installers
        }
        return $product->precio_publico;
    }

    private function getUserRole()
    {
        $user = auth()->user();
        if (!$user || !($user instanceof \App\Models\User)) return 'publico';
        if ($user->hasRole('Cliente mayorista')) return 'mayorista';
        if ($user->hasRole('Cliente instalador')) return 'instalador';
        return 'publico';
    }
}