<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'warehouse_id',
        'subtotal',
        'iva',
        'total',
        'payment_method',
        'notes',
        'status',
        'file_transfer',
        'payment_status',
        'folio',
    ];

    public static function getUserRole()
    {
        $user = auth()->user();
        if (!$user || !($user instanceof \App\Models\User)) return 'publico';
        if ($user->hasRole('Cliente mayorista')) return 'mayorista';
        if ($user->hasRole('Cliente instalador')) return 'instalador';
        return 'publico';
    }


    public static function generateUniqueFolio()
    {
        do {
            // Genera un folio, por ejemplo: "FOLIO-20250607-XXXX" donde XXXX es un número aleatorio
            $folio = 'CLI-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 4));
        } while (self::where('folio', $folio)->exists());

        return $folio;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
} 