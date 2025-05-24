<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::all();
        return view('admin.sucursales.index', compact('sucursales'));
    }

    public function create()
    {
        return view('admin.sucursales.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'description' => 'nullable|string',
                'opening_hours' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric'
            ], [
                'name.required' => 'El nombre de la sucursal es obligatorio',
                'name.max' => 'El nombre no puede tener más de 255 caracteres',
                'status.required' => 'El estado es obligatorio',
                'latitude.numeric' => 'La latitud debe ser un número',
                'longitude.numeric' => 'La longitud debe ser un número',
                'email.email' => 'El correo electrónico debe ser válido',
                'email.max' => 'El correo electrónico no puede tener más de 255 caracteres',
                'phone.max' => 'El teléfono no puede tener más de 20 caracteres',
                'address.max' => 'La dirección no puede tener más de 255 caracteres',
            ]);

            $sucursal = Sucursal::create($validated);

            DB::commit();
            return redirect()->route('admin.sucursales.index')
                ->with('success', 'Sucursal creada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al crear la sucursal: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $sucursal = Sucursal::find($id);
        if ($sucursal == null) {
            return redirect()->route('admin.sucursales.index')->with('error', 'Sucursal no encontrada');
        }
        return view('admin.sucursales.edit', compact('sucursal'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|boolean',
                'address' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'description' => 'nullable|string',
                'opening_hours' => 'nullable|string',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric'
            ], [
                'name.required' => 'El nombre de la sucursal es obligatorio',
                'name.max' => 'El nombre no puede tener más de 255 caracteres',
                'status.required' => 'El estado es obligatorio',
                'latitude.numeric' => 'La latitud debe ser un número',
                'longitude.numeric' => 'La longitud debe ser un número',
                'email.email' => 'El correo electrónico debe ser válido',
                'email.max' => 'El correo electrónico no puede tener más de 255 caracteres',
                'phone.max' => 'El teléfono no puede tener más de 20 caracteres',
                'address.max' => 'La dirección no puede tener más de 255 caracteres',
            ]);

            Sucursal::where('id', $id)->update($validated);

            DB::commit();
            return redirect()->route('admin.sucursales.index')
                ->with('success', 'Sucursal actualizada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar la sucursal: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Sucursal $sucursal)
    {
        try {
            DB::beginTransaction();

            // Verificar si la sucursal tiene productos asociados
            if ($sucursal->products()->count() > 0) {
                throw new \Exception('No se puede eliminar la sucursal porque tiene productos asociados');
            }

            $sucursal->delete();

            DB::commit();
            return redirect()->route('admin.sucursales.index')
                ->with('success', 'Sucursal eliminada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar la sucursal: ' . $e->getMessage());
        }
    }
} 