<?php

namespace App\Http\Controllers;

use App\Models\AccessRequest;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'rfc' => 'required|string|max:13',
        ]);

        AccessRequest::create($validated);

        return redirect()->back()->with('success', 'Tus datos han sido enviados correctamente. En breve nos pondremos en contacto contigo por el telefono que nos proporcionaste.');
    }
}
