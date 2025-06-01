<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductEntry;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductEntryController extends Controller
{
    public function index()
    {
        $productEntries = ProductEntry::with(['product', 'warehouse'])->orderBy('entry_date', 'desc')->paginate(15);
        return view('admin.product_entries.index', compact('productEntries'));
    }

    public function create()
    {
        $products = Product::where('active', true)->orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        return view('admin.product_entries.create', compact('products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
            'entry_date' => 'required|date',
        ]);

        ProductEntry::create($request->all());

        return redirect()->route('admin.product-entries.index')->with('success', 'Entrada registrada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductEntry  $productEntry
     * @return \Illuminate\Http\Response
     */
    public function show(ProductEntry $productEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductEntry  $productEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductEntry $productEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductEntry  $productEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductEntry $productEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductEntry  $productEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductEntry $productEntry)
    {
        //
    }
}
