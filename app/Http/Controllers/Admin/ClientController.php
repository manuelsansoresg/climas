<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = User::role(['Cliente mayorista', 'Cliente publico en general', 'Cliente instalador'])->get();
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'rfc' => 'required|string|max:13',
            'address' => 'required|string',
            'cp' => 'string|max:5',
            'client_type' => 'required_if:is_admin,true|string|in:Cliente mayorista,Cliente publico en general,Cliente instalador',
        ]);

        $user = User::create($validated);
        
        // Asignar el rol según el tipo de cliente
        if ($request->user()->roles()->where('name', 'Admin')->exists() && isset($validated['client_type'])) {
            $clientRole = Role::firstOrCreate(['name' => $validated['client_type']]);
            $user->assignRole($clientRole);
        } else {
            // Si no es admin o no se especificó tipo, asignar rol por defecto
            $clientRole = Role::firstOrCreate(['name' => 'Cliente publico en general']);
            $user->assignRole($clientRole);
        }

        return redirect()->route('admin.clients.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $client->id,
            'phone' => 'required|string|max:20',
            'rfc' => 'required|string|max:13',
            'address' => 'required|string',
            'cp' => 'string|max:5',
            'client_type' => 'required_if:is_admin,true|string|in:Cliente mayorista,Cliente publico en general,Cliente instalador',
        ]);

        $client->update($validated);

        // Actualizar el rol si el usuario es admin
        if ($request->user()->roles()->where('name', 'Admin')->exists() && isset($validated['client_type'])) {
            // Remover todos los roles actuales
            $client->roles()->detach();
            
            // Asignar el nuevo rol
            $clientRole = Role::firstOrCreate(['name' => $validated['client_type']]);
            $client->assignRole($clientRole);
        }

        return redirect()->route('admin.clients.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $client)
    {
        // Remover el rol de Cliente antes de eliminar
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
