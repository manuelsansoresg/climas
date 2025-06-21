<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sucursal;
use App\Models\ProductImage;
use App\Models\Subcategory;
use App\Models\Subcategory2;
use App\Models\Subcategory3;
use App\Models\ProductSucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $sucursales = Sucursal::all();
        return view('admin.products.create', compact('categories', 'sucursales'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validación de datos con mensajes personalizados
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'nullable|exists:categories,id',
                'subcategory_id' => 'nullable|exists:subcategories,id',
                'subcategory2_id' => 'nullable|exists:subcategories2,id',
                'subcategory3_id' => 'nullable|exists:subcategories3,id',
                'precio_mayorista' => 'nullable|numeric|min:0',
                'precio_distribuidor' => 'nullable|numeric|min:0',
                'precio_publico' => 'required|numeric|min:0',
                'precio_instalador' => 'nullable|numeric|min:0',
                //'stock' => 'null|integer|min:0',
                'iva' => 'required|numeric|min:0|max:100',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'pdf' => 'nullable|mimes:pdf|max:10240',
                'active' => 'required|boolean',
                'sucursales' => 'required|array',
                'sucursales.*' => 'exists:sucursales,id'
            ], [
                'name.required' => 'El nombre del producto es obligatorio',
                'name.max' => 'El nombre no puede tener más de 255 caracteres',
                'category_id.exists' => 'La categoría seleccionada no es válida',
                'subcategory_id.exists' => 'La subcategoría seleccionada no es válida',
                'subcategory2_id.exists' => 'La subcategoría 2 seleccionada no es válida',
                'subcategory3_id.exists' => 'La subcategoría 3 seleccionada no es válida',
                'precio_mayorista.numeric' => 'El precio mayorista debe ser un número',
                'precio_mayorista.min' => 'El precio mayorista no puede ser negativo',
                'precio_distribuidor.numeric' => 'El precio distribuidor debe ser un número',
                'precio_distribuidor.min' => 'El precio distribuidor no puede ser negativo',
                'precio_publico.required' => 'El precio público es obligatorio',
                'precio_publico.numeric' => 'El precio público debe ser un número',
                'precio_publico.min' => 'El precio público no puede ser negativo',
                'precio_instalador.numeric' => 'El precio instalador debe ser un número',
                'precio_instalador.min' => 'El precio instalador no puede ser negativo',
                'iva.required' => 'El IVA es obligatorio',
                'iva.numeric' => 'El IVA debe ser un número',
                'iva.min' => 'El IVA no puede ser negativo',
                'iva.max' => 'El IVA no puede ser mayor que 100',
                'image.required' => 'La imagen principal es obligatoria',
                'image.image' => 'El archivo debe ser una imagen',
                'image.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg, gif',
                'image.max' => 'La imagen no puede pesar más de 2MB',
                'images.*.image' => 'Los archivos adicionales deben ser imágenes',
                'images.*.mimes' => 'Las imágenes adicionales deben ser de tipo: jpeg, png, jpg, gif',
                'images.*.max' => 'Las imágenes adicionales no pueden pesar más de 2MB',
                'pdf.mimes' => 'El archivo PDF debe ser de tipo PDF',
                'pdf.max' => 'El archivo PDF no puede pesar más de 10MB',
                'active.required' => 'Debe seleccionar un estado',
                'sucursales.required' => 'Debe seleccionar al menos una sucursal',
                'sucursales.*.exists' => 'Una de las sucursales seleccionadas no es válida'
            ]);
            // Crear el producto
            $product = new Product();
            $product->name = $request->name;
            $product->slug = \Str::slug($request->name);
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->subcategory2_id = $request->subcategory2_id;
            $product->subcategory3_id = $request->subcategory3_id;
            $product->precio_mayorista = $request->precio_mayorista;
            $product->precio_distribuidor = $request->precio_distribuidor;
            $product->precio_publico = $request->precio_publico;
            $product->precio_instalador = $request->precio_instalador;
            //$product->stock = $request->stock;
            $product->iva = $request->iva;
            $product->active = $request->active;

            // Guardar imagen principal
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $imageName);
                $product->image = 'uploads/products/' . $imageName;
            }

            // Guardar PDF si existe
            if ($request->hasFile('pdf')) {
                $pdf = $request->file('pdf');
                $pdfName = time() . '_' . $pdf->getClientOriginalName();
                $pdf->move(public_path('uploads/pdfs'), $pdfName);
                $product->pdf = 'uploads/pdfs/' . $pdfName;
            }

            $product->save();

            // Guardar imágenes adicionales
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/products'), $imageName);
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'uploads/products/' . $imageName
                    ]);
                }
            }

            // Guardar sucursales sin stock
            $product->sucursales()->attach($request->sucursales);

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear el producto: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::all();
        $sucursales = Sucursal::all();
        $selectedSucursales = $product->productSucursales->pluck('sucursal_id')->toArray();
        $stockSucursales = $product->productSucursales->pluck('stock', 'sucursal_id')->toArray();

        // Cargar subcategorías si existen
        $subcategories = [];
        $subcategories2 = [];
        $subcategories3 = [];

        if ($product->category_id) {
            $subcategories = Category::find($product->category_id)->subcategories;
        }

        if ($product->subcategory_id) {
            $subcategories2 = Subcategory::find($product->subcategory_id)->subcategories2;
        }

        if ($product->subcategory2_id) {
            $subcategories3 = Subcategory2::find($product->subcategory2_id)->subcategories3;
        }
        
        return view('admin.products.edit', compact(
            'product',
            'categories',
            'sucursales',
            'selectedSucursales',
            'stockSucursales',
            'subcategories',
            'subcategories2',
            'subcategories3'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'subcategory2_id' => 'nullable|exists:subcategories2,id',
            'subcategory3_id' => 'nullable|exists:subcategories3,id',
            'precio_mayorista' => 'nullable|numeric|min:0',
            'precio_distribuidor' => 'nullable|numeric|min:0',
            'precio_publico' => 'required|numeric|min:0',
            'precio_instalador' => 'nullable|numeric|min:0',
            //'stock' => 'null|integer|min:0',
            'iva' => 'required|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf' => 'nullable|mimes:pdf|max:10240',
            'active' => 'required|boolean',
            'sucursales' => 'required|array',
            'sucursales.*' => 'exists:sucursales,id'
        ]);

        try {
            DB::beginTransaction();

            $product->name = $request->name;
            $product->slug = \Str::slug($request->name);
            $product->description = $request->description;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->subcategory2_id = $request->subcategory2_id;
            $product->subcategory3_id = $request->subcategory3_id;
            $product->precio_mayorista = $request->precio_mayorista;
            $product->precio_distribuidor = $request->precio_distribuidor;
            $product->precio_publico = $request->precio_publico;
            $product->precio_instalador = $request->precio_instalador;
            //$product->stock = $request->stock;
            $product->iva = $request->iva;
            $product->active = $request->active;

            // Actualizar imagen principal si se proporciona una nueva
            if ($request->hasFile('image')) {
                // Eliminar imagen anterior si existe
                if ($product->image && file_exists(public_path($product->image))) {
                    unlink(public_path($product->image));
                }

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/products'), $imageName);
                $product->image = 'uploads/products/' . $imageName;
            }

            // Actualizar PDF si se proporciona uno nuevo
            if ($request->hasFile('pdf')) {
                // Eliminar PDF anterior si existe
                if ($product->pdf && file_exists(public_path($product->pdf))) {
                    unlink(public_path($product->pdf));
                }

                $pdf = $request->file('pdf');
                $pdfName = time() . '_' . $pdf->getClientOriginalName();
                $pdf->move(public_path('uploads/pdfs'), $pdfName);
                $product->pdf = 'uploads/pdfs/' . $pdfName;
            }

            $product->save();

            // Guardar imágenes adicionales
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/products'), $imageName);
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'uploads/products/' . $imageName
                    ]);
                }
            }

            // Actualizar sucursales sin stock
            $product->sucursales()->sync($request->sucursales);

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Producto actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar el producto: ' . $e->getMessage());
        }
    }

    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            // Eliminar imágenes
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            if ($product->pdf) {
                Storage::disk('public')->delete($product->pdf);
            }

            // Eliminar imágenes adicionales
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }

            // Eliminar relaciones con sucursales
            $product->sucursales()->detach();

            // Eliminar el producto
            $product->delete();

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Producto eliminado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        
        if (Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }
        
        $image->delete();
        
        return response()->json(['success' => true]);
    }

    public function deleteMainImage(Product $product)
    {
        if ($product->image) {
            // Borra el archivo físico si existe
            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->image = null;
            $product->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
} 