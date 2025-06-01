<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class ProductSaleController extends Controller
{
    public function index()
    {
        $productSales = ProductSale::with(['product', 'warehouse'])->orderBy('sale_date', 'desc')->paginate(15);
        return view('admin.product_sales.index', compact('productSales'));
    }

    public function create()
    {
        $products = Product::where('active', true)->orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        return view('admin.product_sales.create', compact('products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'sale_price' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'admin_unlock_key' => 'nullable|string', // Nueva clave opcional

        ]);

        $product = Product::findOrFail($request->product_id);

        // Validar que el precio de venta no sea menor al mínimo salvo con clave admin
        if ($request->sale_price < $product->min_sale_price) {
            // Aquí puedes implementar la lógica para pedir clave admin, por ejemplo:
            // $request->validate(['admin_key' => 'required|some_rule']);
            // Por simplicidad, rechazamos la venta si no se cumple
            return back()->withErrors(['sale_price' => 'El precio de venta es menor al precio mínimo permitido.'])->withInput();
        }

        // Validar stock disponible en el almacén
        $stock = $product->stockByWarehouse($request->warehouse_id);
        if ($request->quantity > $stock) {
            return back()->withErrors(['quantity' => 'No hay suficiente stock en el almacén seleccionado.'])->withInput();
        }

        ProductSale::create($request->all());

        return redirect()->route('admin.product-sales.index')->with('success', 'Venta registrada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductSale  $productSale
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSale $productSale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductSale  $productSale
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSale $productSale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductSale  $productSale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductSale $productSale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductSale  $productSale
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductSale $productSale)
    {
        //
    }
}
