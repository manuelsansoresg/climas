<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSucursal extends Model
{
    use HasFactory;
    protected $table = 'product_sucursal';
    protected $fillable = ['product_id', 'sucursal_id', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursales::class);
    }
}
