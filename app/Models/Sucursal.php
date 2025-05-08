<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table = 'sucursales';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'status',
        'description',
        'opening_hours',
        'latitude',
        'longitude'
    ];
    protected $casts = [
        'status' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];
    public function products()
    {
        return $this->hasMany(ProductSucursal::class);
    }
} 