<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUnlockKey;

class AdminUnlockKeyController extends Controller
{
    public function validateKey(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
        ]);
        $isValid = AdminUnlockKey::validateKey($request->key);
        return response()->json(['valid' => $isValid]);
    }
} 