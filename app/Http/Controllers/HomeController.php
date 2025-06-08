<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function contact()
    {
        return view('contact');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        
        // Obtener 3 productos al azar con stock disponible, excluyendo el producto actual
        $relatedProductsCollection = Product::all()
        ->filter(function($p) use ($product) {
            return $p->getAvailableStockAttribute() > 0 && $p->id != $product->id;
        });

        $relatedProducts = $relatedProductsCollection->count() > 3 
            ? $relatedProductsCollection->random(3) 
            : $relatedProductsCollection;

        return view('producto', ['product' => $product, 'relatedProducts' => $relatedProducts]);
    }
    
    public function home()
    {
        
        return view('home');
    }
}
