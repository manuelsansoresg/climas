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
        
        $products = Product::whereHas('warehouses', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('status', true)
            ->take(10)
            ->get()
            ->map(function ($product) {
                $warehouseQuantity = $product->warehouses()
                    ->whereNull('deleted_at')
                    ->sum('cantidad');
                $salesQuantity = $product->saleDetails()->sum('quantity');
                $availableStock = $warehouseQuantity - $salesQuantity;
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'precio_publico' => $product->precio_publico,
                    'precio_mayorista' => $product->precio_mayorista,
                    'precio_distribuidor' => $product->precio_distribuidor,
                    'iva' => $product->iva,
                    'stock' => $availableStock
                ];
            });

        return response()->json($products);
    }

    public function searchAll(Request $request)
    {
        $query = $request->get('q');
        $products = Product::where(function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        })
        ->where('active', true)
        ->take(10)
        ->get();

        return response()->json($products);
        
    }
} 