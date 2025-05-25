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
        'precio_instalador',
        'stock',
        'discount',
        'iva',
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

    public function warehouses()
    {
        return $this->hasMany(WareHouse::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
    
    /**
     * Calcula el stock disponible del producto considerando las ventas
     * @return int
     */
    public function getAvailableStockAttribute()
    {
        // Suma total de stock en almacén
        $totalStock = $this->warehouses()->sum('cantidad');
        
        // Suma total de productos vendidos
        $totalSold = $this->saleDetails()->sum('quantity');
        
        // Stock disponible = total en almacén - total vendido
        return max(0, $totalStock - $totalSold);
    }
}
