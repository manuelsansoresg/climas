<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Subcategory2;
use Illuminate\Http\Request;

class Subcategory2Controller extends Controller
{
    public function index()
    {
        $subcategories2 = Subcategory2::with(['subcategory', 'subcategories3'])->get();
        return view('admin.subcategories2.index', compact('subcategories2'));
    }

    public function create()
    {
        $subcategories = Subcategory::all();
        return view('admin.subcategories2.create', compact('subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);

        Subcategory2::create($request->all());
        return redirect()->route('admin.subcategories2.index')->with('success', 'Subcategoría 2 creada exitosamente');
    }

    public function edit(Subcategory2 $subcategory2)
    {
        $subcategories = Subcategory::all();
        return view('admin.subcategories2.edit', compact('subcategory2', 'subcategories'));
    }

    public function update(Request $request, Subcategory2 $subcategory2)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);

        $subcategory2->update($request->all());
        return redirect()->route('admin.subcategories2.index')->with('success', 'Subcategoría 2 actualizada exitosamente');
    }

    public function destroy(Subcategory2 $subcategory2)
    {
        $subcategory2->delete();
        return redirect()->route('admin.subcategories2.index')->with('success', 'Subcategoría 2 eliminada exitosamente');
    }
} 