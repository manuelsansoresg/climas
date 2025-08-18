<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'location'];
    protected $table = 'warehouses';

    public function productEntries()
    {
        return $this->hasMany(ProductEntry::class);
    }

    public function productSales()
    {
        return $this->hasMany(ProductSale::class);
    }

    public function entries()
    {
        return $this->hasMany(ProductEntry::class);
    }

    public function sales()
    {
        return $this->hasMany(ProductSale::class);
    }

    // Stock total en todos los almacenes
    public function totalStock()
    {
        $entries = $this->entries()->sum('quantity');
        $sales = $this->sales()->sum('quantity');
        return $entries - $sales;
    }

    // Stock por almacén
    public function stockByWarehouse($warehouseId)
    {
        $entries = $this->entries()->where('warehouse_id', $warehouseId)->sum('quantity');
        $sales = $this->sales()->where('warehouse_id', $warehouseId)->sum('quantity');
        return $entries - $sales;
    }
    
}
