<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = auth()->user()->sales()->with(['details.product'])->latest()->get();
        return view('sales.index', compact('sales'));
    }

    public function show(Sale $sale)
    {
        // Ensure user can only view their own sales
        if ($sale->client_id !== auth()->id()) {
            abort(403);
        }

        $sale->load(['details.product']);
        return view('sales.show', compact('sale'));
    }
} 