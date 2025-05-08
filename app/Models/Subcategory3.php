<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory3 extends Model
{
    use HasFactory;
    protected $table = 'subcategories3';
    protected $fillable = ['name', 'description', 'subcategory2_id'];

    public function subcategory2()
    {
        return $this->belongsTo(Subcategory2::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class)->nullOnDelete();
    }
}