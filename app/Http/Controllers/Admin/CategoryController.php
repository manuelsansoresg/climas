<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Categoría creada exitosamente');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Category $category)
    {
        try {
            // Contar productos y subcategorías antes de eliminar
            $productsCount = $category->products()->count();
            $subcategoriesCount = $category->subcategories()->count();
            
            // Eliminar la categoría (las restricciones de BD manejan automáticamente las relaciones)
            $category->delete();
            
            // Crear mensaje informativo
            $message = 'Categoría eliminada exitosamente';
            if ($productsCount > 0) {
                $message .= ". Se desasignó la categoría de {$productsCount} producto(s)";
            }
            if ($subcategoriesCount > 0) {
                $message .= ". Se eliminaron {$subcategoriesCount} subcategoría(s)";
            }
            $message .= '.';
            
            return redirect()->route('admin.categories.index')->with('success', $message);
            
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Error al eliminar la categoría: ' . $e->getMessage());
        }
    }
}