<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'pdf',
        'image',
        'precio_mayorista',
        'precio_distribuidor',
        'precio_publico',
        'costo_compra',
        'stock',
        'discount',
        'category_id',
        'subcategory_id',
        'subcategory2_id',
        'subcategory3_id',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function subcategory2()
    {
        return $this->belongsTo(Subcategory2::class);
    }

    public function subcategory3()
    {
        return $this->belongsTo(Subcategory3::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sucursales()
    {
        return $this->belongsToMany(Sucursal::class, 'product_sucursal')
            ->withPivot('stock')
            ->withTimestamps();
    }

    public function productSucursales()
    {
        return $this->hasMany(ProductSucursal::class);
    }
}
