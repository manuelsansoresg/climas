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
                    'precio_publico' => $product->precio_publico,
                    'precio_mayorista' => $product->precio_mayorista,
                    'precio_distribuidor' => $product->precio_distribuidor,
                    'iva' => $product->iva,
                    'stock' => $stock
                ];
            });

        return response()->json($products);
    }
} 