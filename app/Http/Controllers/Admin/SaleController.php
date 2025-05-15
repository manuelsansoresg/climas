<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['client', 'user'])->latest()->paginate(10);
        return view('admin.sales.index', compact('sales'));
    }

    public function create()
    {
        $clients = User::role(['Cliente publico en general', 'Cliente mayorista', 'Cliente instalador'])->get();
        return view('admin.sales.create', compact('clients'));
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
            
            // Calculate totals
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Verificar stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stock insuficiente para el producto: {$product->name}");
                }
                
                $price = $this->getPriceByUserRole($product);
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
                'status' => 'completed',
                'payment_status' => 'paid'
            ]);

            // Create sale details
            foreach ($request->products as $item) {
                $product = Product::findOrFail($item['product_id']);
                $price = $this->getPriceByUserRole($product);
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

    private function getPriceByUserRole($product)
    {
        $user = auth()->user();
        if (!$user || !($user instanceof \App\Models\User)) {
            return $product->precio_publico;
        }
        if ($user->hasRole('Cliente mayorista')) {
            return $product->precio_mayorista;
        }
        if ($user->hasRole('Cliente instalador')) {
            return $product->precio_publico * 0.9; // 10% discount for installers
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
