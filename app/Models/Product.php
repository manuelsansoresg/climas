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
        'slug',
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
        'active'
    ];

    public function averageCostByWarehouse($warehouseId)
    {
        $entries = $this->entries()->where('warehouse_id', $warehouseId)->get();

        $totalQuantity = $entries->sum('quantity');
        if ($totalQuantity == 0) {
            return 0;
        }

        $totalCost = $entries->sum(function ($entry) {
            return $entry->quantity * $entry->cost_price;
        });

        return $totalCost / $totalQuantity;
    }

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

    public function entries()
    {
        return $this->hasMany(ProductEntry::class);
    }

    public function sales()
    {
        return $this->hasMany(ProductSale::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
    
    /**
     * Calcula el stock disponible del producto usando el método FIFO
     * @return int
     */
    public function getFifoStockAttribute()
    {
        // Obtener todas las entradas ordenadas por fecha (más antiguas primero)
        $entries = $this->entries()
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Obtener todas las ventas ordenadas por fecha
        $sales = $this->sales()
            ->orderBy('created_at', 'asc')
            ->get();
            
        $remainingStock = 0;
        $currentEntryIndex = 0;
        
        // Procesar cada venta
        foreach ($sales as $sale) {
            $remainingQuantity = $sale->quantity;
            
            // Mientras haya cantidad por procesar y entradas disponibles
            while ($remainingQuantity > 0 && $currentEntryIndex < $entries->count()) {
                $currentEntry = $entries[$currentEntryIndex];
                $availableInEntry = $currentEntry->quantity;
                
                if ($availableInEntry >= $remainingQuantity) {
                    // La entrada actual puede cubrir toda la venta
                    $availableInEntry -= $remainingQuantity;
                    $remainingQuantity = 0;
                    
                    if ($availableInEntry > 0) {
                        // Actualizar la cantidad disponible en esta entrada
                        $currentEntry->quantity = $availableInEntry;
                    } else {
                        // Esta entrada se agotó, pasar a la siguiente
                        $currentEntryIndex++;
                    }
                } else {
                    // La entrada actual no puede cubrir toda la venta
                    $remainingQuantity -= $availableInEntry;
                    $currentEntryIndex++;
                }
            }
        }
        
        // Calcular el stock restante sumando las cantidades de las entradas no procesadas
        for ($i = $currentEntryIndex; $i < $entries->count(); $i++) {
            $remainingStock += $entries[$i]->quantity;
        }
        
        return $remainingStock;
    }

    /**
     * Calcula el stock disponible del producto considerando las ventas
     * @return int
     */
    public function getAvailableStockAttribute()
    {
        return $this->getFifoStockAttribute();
    }
    
    /**
     * Método para calcular stock actual (mantenido por compatibilidad)
     * @return int
     */
    public function stock()
    {
        return $this->getFifoStockAttribute();
    }

    /**
     * Get the latest available entry cost (real cost) for this product.
     * @return float|null
     */
    public function latestEntryCost()
    {
        $entry = $this->entries()->orderByDesc('entry_date')->orderByDesc('id')->first();
        return $entry ? $entry->cost_price : null;
    }
}
