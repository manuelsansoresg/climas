<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WareHouse;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WareHouseController extends Controller
{
    public function index()
    {
        $warehouses = WareHouse::withTrashed()
            ->with(['product', 'user', 'provider'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        $products = Product::all();
        $providers = User::role('Proveedor')->get();
        return view('admin.warehouses.create', compact('products', 'providers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'costo_compra' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'fechaingresa' => 'required|date',
        ]);

        $warehouse = new WareHouse();
        $warehouse->product_id = $request->product_id;
        $warehouse->factura = $request->factura;
        $warehouse->idusuarioagrega = auth()->id();
        $warehouse->fechaingresa = $request->fechaingresa;
        $warehouse->serie = $request->serie;
        $warehouse->costo_compra = $request->costo_compra;
        $warehouse->cantidad = $request->cantidad;
        $warehouse->provedor_id = $request->provedor_id;
        $warehouse->save();

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Registro de almacén creado exitosamente.');
    }

    public function edit(WareHouse $warehouse)
    {
        $providers = User::role('Proveedor')->get();
        $products = Product::all();
        return view('admin.warehouses.edit', compact('warehouse', 'providers', 'products'));
    }

    public function update(Request $request, WareHouse $warehouse)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'costo_compra' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:1',
            'fechaingresa' => 'required|date',
        ]);

        $warehouse->update([
            'product_id' => $request->product_id,
            'factura' => $request->factura,
            'serie' => $request->serie,
            'costo_compra' => $request->costo_compra,
            'cantidad' => $request->cantidad,
            'provedor_id' => $request->provedor_id,
            'fechaingresa' => $request->fechaingresa,
        ]);

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Registro de almacén actualizado exitosamente.');
    }

    public function destroy(WareHouse $warehouse)
    {
        $warehouse->delete();
        return response()->json(['success' => true]);
    }

    public function restore($id)
    {
        $warehouse = WareHouse::withTrashed()->findOrFail($id);
        $warehouse->restore();
        return response()->json(['success' => true]);
    }
} 