<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WareHouse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'warehouses';

    protected $fillable = [
        'product_id',
        'factura',
        'idusuarioagrega',
        'fechaingresa',
        'serie',
        'costo_compra',
        'idmov',
        'campo1',
        'campo2',
        'campo3',
        'campo4',
        'campo5',
        'cantidad',
        'provedor_id',
    ];

    /**
     * Get the product that owns the warehouse record.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the user that added the warehouse record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idusuarioagrega');
    }

    /**
     * Get the provider user.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provedor_id');
    }
}
