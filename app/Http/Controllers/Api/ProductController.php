<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('status', true)
            ->take(10)
            ->get()
            ->map(function ($product) {
                $stock = $product->stock;
                if (is_null($stock)) {
                    $stock = $product->productSucursales->sum('stock');
                }
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'precio_publico' => $this->getPriceByUserRole($product),
                    'iva' => $product->iva,
                    'stock' => $stock
                ];
            });

        return response()->json($products);
    }

    private function getPriceByUserRole($product)
    {
        $user = auth()->user();
        if (!$user) {
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
} 