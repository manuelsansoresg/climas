<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
       $users = User::role(['Cliente mayorista', 'Cliente publico en general', 'Cliente instalador', 'Almacen', 'Vendedor'])->get();
       return view('admin.users.index', compact('users'));
   }

   /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function create()
   {
       return view('admin.users.create');
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
           'email' => 'nullable|string|email|max:255|unique:users',
           'phone' => 'required|string|max:20',
           'rfc' => 'nullable|string|max:13',
           'address' => 'nullable|string',
           'cp' => 'nullable|string|max:5',
           'client_type' => 'required_if:is_admin,true|string|in:Cliente mayorista,Cliente publico en general,Cliente instalador,Almacen,Vendedor',
           'password' => 'nullable|string|min:8|confirmed',
       ]);

       $userData = [
           'name' => $validated['name'],
           'last_name' => $validated['last_name'],
           'email' => $validated['email'] ?? null,
           'phone' => $validated['phone'],
           'rfc' => $validated['rfc'] ?? null,
           'address' => $validated['address'] ?? null,
           'cp' => $validated['cp'] ?? null,
       ];

       if (!empty($validated['password'])) {
           $userData['password'] = Hash::make($validated['password']);
       }

       $user = User::create($userData);
       
       // Asignar el rol según el tipo de cliente
       if ($request->user()->roles()->where('name', 'Admin')->exists() && isset($validated['client_type'])) {
           $clientRole = Role::firstOrCreate(['name' => $validated['client_type']]);
           $user->assignRole($clientRole);
       } else {
           // Si no es admin o no se especificó tipo, asignar rol por defecto
           $clientRole = Role::firstOrCreate(['name' => 'Cliente publico en general']);
           $user->assignRole($clientRole);
       }

       return redirect()->route('admin.users.index')
           ->with('success', 'Usuario creado exitosamente.');
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
   public function edit(User $user)
   {
       return view('admin.users.edit', compact('user'));
   }

   /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
   public function update(Request $request, User $user)
   {
       $validated = $request->validate([
           'name' => 'required|string|max:255',
           'last_name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
           'phone' => 'required|string|max:20',
           'rfc' => 'nullable|string|max:13',
           'address' => 'nullable|string',
           'cp' => 'nullable|string|max:5',
           'client_type' => 'required_if:is_admin,true|string|in:Cliente mayorista,Cliente publico en general,Cliente instalador,Almacen,Vendedor',
           'password' => 'nullable|string|min:8|confirmed',
       ]);

       $updateData = [
           'name' => $validated['name'],
           'last_name' => $validated['last_name'],
           'email' => $validated['email'],
           'phone' => $validated['phone'],
           'rfc' => $validated['rfc'] ?? null,
           'address' => $validated['address'] ?? null,
           'cp' => $validated['cp'] ?? null,
       ];

       if (!empty($validated['password'])) {
           $updateData['password'] = Hash::make($validated['password']);
       }

       $user->update($updateData);

       // Actualizar el rol si el usuario es admin
       if ($request->user()->roles()->where('name', 'Admin')->exists() && isset($validated['client_type'])) {
           // Remover todos los roles actuales
           $user->roles()->detach();
           
           // Asignar el nuevo rol
           $userRole = Role::firstOrCreate(['name' => $validated['client_type']]);
           $user->assignRole($userRole);
       }

       return redirect()->route('admin.users.index')
           ->with('success', 'Usuario actualizado exitosamente.');
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

       return redirect()->route('admin.users.index')
           ->with('success', 'Usuario eliminado exitosamente.');
   }

   /**
   * Búsqueda AJAX para Select2 en ventas
   */
   public function search(Request $request)
   {
       $q = $request->get('q');
       $clients = User::role(['Cliente mayorista', 'Cliente publico en general', 'Cliente instalador'])
           ->where(function($query) use ($q) {
               $query->where('name', 'like', "%$q%")
                   ->orWhere('email', 'like', "%$q%")
                   ->orWhere('rfc', 'like', "%$q%") ;
           })
           ->take(10)
           ->get(['id', 'name', 'last_name', 'email', 'rfc']);
       // Adjuntar el rol principal a cada cliente
       $clients = $clients->map(function($client) {
           $client->role = $client->roles->first()->name ?? 'Cliente publico en general';
           return $client;
       });
       return response()->json($clients);
   }
}
