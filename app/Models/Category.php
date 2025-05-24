<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class)->nullOnDelete();
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
