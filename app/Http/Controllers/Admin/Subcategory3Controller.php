<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory2;
use App\Models\Subcategory3;
use Illuminate\Http\Request;

class Subcategory3Controller extends Controller
{
    public function index()
    {
        $subcategories3 = Subcategory3::with('subcategory2')->get();
        return view('admin.subcategories3.index', compact('subcategories3'));
    }

    public function create()
    {
        $subcategories2 = Subcategory2::all();
        return view('admin.subcategories3.create', compact('subcategories2'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subcategory2_id' => 'required|exists:subcategories2,id'
        ]);

        Subcategory3::create($request->all());
        return redirect()->route('admin.subcategories3.index')->with('success', 'Subcategoría 3 creada exitosamente');
    }

    public function edit(Subcategory3 $subcategory3)
    {
        $subcategories2 = Subcategory2::all();
        return view('admin.subcategories3.edit', compact('subcategory3', 'subcategories2'));
    }

    public function update(Request $request, Subcategory3 $subcategory3)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subcategory2_id' => 'required|exists:subcategories2,id'
        ]);

        $subcategory3->update($request->all());
        return redirect()->route('admin.subcategories3.index')->with('success', 'Subcategoría 3 actualizada exitosamente');
    }

    public function destroy(Subcategory3 $subcategory3)
    {
        $subcategory3->delete();
        return redirect()->route('admin.subcategories3.index')->with('success', 'Subcategoría 3 eliminada exitosamente');
    }
} 