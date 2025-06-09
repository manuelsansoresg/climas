<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AccessRequestController extends Controller
{
    public function index()
    {
        $accessRequests = AccessRequest::where('status', 'pending')->paginate(10);
        return view('admin.access-requests.index', compact('accessRequests'));
    }

    public function edit(AccessRequest $accessRequest)
    {
        return view('admin.access-requests.edit', compact('accessRequest'));
    }

    public function update(Request $request, AccessRequest $accessRequest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'rfc' => 'required|string|max:13',
            'cp' => 'required|string|max:5',
            'address' => 'required|string|max:255',
        ]);

        $accessRequest->update($validated);

        return redirect()->route('admin.access-requests.index')
            ->with('success', 'Solicitud actualizada exitosamente');
    }

    public function moveToUser(AccessRequest $accessRequest)
    {
        // Create new user from access request data
        $user = new User();
        $user->name = $accessRequest->name;
        $user->last_name = $accessRequest->last_name;
        $user->phone = $accessRequest->phone;
        $user->email = $accessRequest->email;
        $user->cp = $accessRequest->cp;
        $user->rfc = $accessRequest->rfc;
        $user->address = $accessRequest->address;
        $user->password = bcrypt(Str::random(10)); // Generate random password
        $user->save();

        // Update access request status
        $accessRequest->status = 'approved';
        $accessRequest->save();

        return redirect()->route('admin.access-requests.index')
            ->with('success', 'Usuario creado exitosamente');
    }
} 