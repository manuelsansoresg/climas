<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminUnlockKey extends Model
{
    use HasFactory;
    protected $fillable = ['key_hash', 'description'];

    // Verifica si la clave es válida (comparando hash)
    public static function validateKey($key)
    {
        $keys = self::all();
        foreach ($keys as $k) {
            if (password_verify($key, $k->key_hash)) {
                return true;
            }
        }
        return false;
    }
}
