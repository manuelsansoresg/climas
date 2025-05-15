<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'address',
        'rfc',
        'cp',
        'type', // mayorista, distribuidor, instalador, publico
        'status'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
} 