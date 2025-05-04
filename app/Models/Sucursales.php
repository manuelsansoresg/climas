<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    use HasFactory;
    protected $table = 'sucursales';
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(ProductSucursal::class);
    }
}
