<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,credit_card,transfer',
            'notes' => 'nullable|string',
            'file_transfer' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $subtotal = 0;
            $iva = 0;
            $total = 0;
            
            // Procesar el archivo de comprobante si existe
            $fileName = null;
            if ($request->hasFile('file_transfer')) {
                $file = $request->file('file_transfer');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/comprobante_pago'), $fileName);
            }
            
            // Agrupar cantidades por producto
            $products = $request->products;
            foreach ($products as $product) {
                $subtotal += $product['quantity'] * $product['product_id'];
                $iva += $product['quantity'] * $product['product_id'] * 0.16;
                $total += $product['quantity'] * $product['product_id'] * 1.16;
            }
            
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'client_id' => $request->client_id,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'status' => $request->status,
                'payment_status' => 'paid',
                'file_transfer' => $fileName
            ]);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Venta creada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear la venta: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cash,credit_card,transfer',
            'notes' => 'nullable|string',
            'file_transfer' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Procesar el archivo de comprobante si existe
            $fileName = $sale->file_transfer;
            if ($request->hasFile('file_transfer')) {
                // Eliminar archivo anterior si existe
                if ($sale->file_transfer) {
                    $oldFile = public_path('images/comprobante_pago/' . $sale->file_transfer);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                
                $file = $request->file('file_transfer');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/comprobante_pago'), $fileName);
            }

            $subtotal = 0;
            $iva = 0;
            $total = 0;
            
            // Agrupar cantidades por producto
            $products = $request->products;
            foreach ($products as $product) {
                $subtotal += $product['quantity'] * $product['product_id'];
                $iva += $product['quantity'] * $product['product_id'] * 0.16;
                $total += $product['quantity'] * $product['product_id'] * 1.16;
            }
            
            $sale->update([
                'client_id' => $request->client_id,
                'subtotal' => $subtotal,
                'iva' => $iva,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'notes' => $request->notes,
                'status' => $request->status,
                'file_transfer' => $fileName
            ]);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar la venta: ' . $e->getMessage());
        }
    }
} 