<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Obtener o crear carrito del usuario
    protected function getUserCart()
    {
        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        return $cart;
    }

    // Agregar producto al carrito
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $cart = $this->getUserCart();
        $quantity = $request->input('quantity', 1);
        $productId = $request->product_id;

        $product = Product::findOrFail($productId);
        $availableStock = $product->getAvailableStockAttribute();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        $currentQuantity = $cartItem ? $cartItem->quantity : 0;
        $newTotal = $currentQuantity + $quantity;

        if ($availableStock <= 0) {
            return response()->json(['message' => 'No hay stock disponible para este producto.'], 400);
        }
        if ($newTotal > $availableStock) {
            return response()->json(['message' => 'No puedes agregar más de ' . $availableStock . ' unidades al carrito.'], 400);
        }

        if ($cartItem) {
            // Si ya está en el carrito, solo mostrar mensaje
            return response()->json(['message' => 'El producto ya fue agregado al carrito. Puedes actualizar la cantidad desde el carrito.'], 200);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return response()->json(['message' => 'Producto agregado al carrito']);
    }

    // Mostrar carrito
    public function showCart()
    {
        $cart = $this->getUserCart()->load('items.product');
        return view('cart.index', compact('cart'));
    }

    // Actualizar cantidad de un item
    public function updateItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getUserCart();

        $item = CartItem::where('cart_id', $cart->id)->where('id', $itemId)->firstOrFail();
        $item->quantity = $request->quantity;
        $item->save();

        return redirect()->back()->with('success', 'Cantidad actualizada');
    }

    // Eliminar item del carrito
    public function removeItem($itemId)
    {
        $cart = $this->getUserCart();

        $item = CartItem::where('cart_id', $cart->id)->where('id', $itemId)->firstOrFail();
        $item->delete();

        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }

    // Realizar la venta
    public function checkout()
    {
        $cart = $this->getUserCart()->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors('El carrito está vacío');
        }

        // Validar stock antes de proceder
        foreach ($cart->items as $item) {
            $availableStock = $item->product->stock(); // Usamos el método stock()
            if ($item->quantity > $availableStock) {
                return redirect()->route('cart.index')->withErrors("No hay suficiente stock para el producto {$item->product->name}. Stock disponible: {$availableStock}");
            }
        }

        DB::beginTransaction();

        try {
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'client_id' => Auth::id(),
                'total' => 0, // se calculará abajo
            ]);

            $total = 0;

            foreach ($cart->items as $item) {
                $price = $item->product->price; // Asumo que el producto tiene campo price
                $subtotal = $price * $item->quantity;

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $sale->total = $total;
            $sale->save();

            // Vaciar carrito
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('sales.show', $sale->id)->with('success', 'Venta realizada con éxito');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->withErrors('Error al realizar la venta: ' . $e->getMessage());
        }
    }

    // Validar stock de todos los productos del carrito (AJAX)
    public function validateCartStock(Request $request)
    {
        $cart = $this->getUserCart()->load('items.product');
        $errors = [];
        $stockUpdates = [];

        foreach ($cart->items as $item) {
            $stock = $item->product->stock();
            $stockUpdates[$item->id] = $stock;
            if ($item->quantity > $stock) {
                $errors[] = [
                    'item_id' => $item->id,
                    'product_name' => $item->product->name,
                    'requested' => $item->quantity,
                    'available' => $stock
                ];
            }
        }

        if (count($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
                'stockUpdates' => $stockUpdates
            ], 400);
        }

        return response()->json(['success' => true, 'stockUpdates' => $stockUpdates]);
    }
}
