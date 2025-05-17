<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Subcategory2;
use App\Models\Subcategory3;
use App\Models\SaleDetail;
use Illuminate\Support\Carbon;

class ProductReport extends Component
{
    public $filters = [
        'category_id' => null,
        'subcategory_id' => null,
        'subcategory2_id' => null,
        'subcategory3_id' => null,
        'date_from' => null,
        'date_to' => null,
        'name' => '',
    ];
    public $appliedFilters = [
        'category_id' => null,
        'subcategory_id' => null,
        'subcategory2_id' => null,
        'subcategory3_id' => null,
        'date_from' => null,
        'date_to' => null,
        'name' => '',
    ];
    public $loading = false;

    public function mount()
    {
        $this->filters = $this->appliedFilters;
    }

    public function applyFilters()
    {
        $this->loading = true;
        $this->appliedFilters = $this->filters;
        $this->loading = false;
    }

    public function updatedFilters($value, $key)
    {
        // Limpiar hijos si cambia padre
        if ($key === 'category_id') {
            $this->filters['subcategory_id'] = null;
            $this->filters['subcategory2_id'] = null;
            $this->filters['subcategory3_id'] = null;
        }
        if ($key === 'subcategory_id') {
            $this->filters['subcategory2_id'] = null;
            $this->filters['subcategory3_id'] = null;
        }
        if ($key === 'subcategory2_id') {
            $this->filters['subcategory3_id'] = null;
        }
    }

    public function render()
    {
        $categories = Category::all();
        $subcategories = $this->filters['category_id'] ? Subcategory::where('category_id', $this->filters['category_id'])->get() : collect();
        $subcategories2 = $this->filters['subcategory_id'] ? Subcategory2::where('subcategory_id', $this->filters['subcategory_id'])->get() : collect();
        $subcategories3 = $this->filters['subcategory2_id'] ? Subcategory3::where('subcategory2_id', $this->filters['subcategory2_id'])->get() : collect();

        $products = Product::query()
            ->when($this->appliedFilters['category_id'], fn($q) => $q->where('category_id', $this->appliedFilters['category_id']))
            ->when($this->appliedFilters['subcategory_id'] && $this->appliedFilters['category_id'], fn($q) => $q->where('subcategory_id', $this->appliedFilters['subcategory_id']))
            ->when($this->appliedFilters['subcategory2_id'] && $this->appliedFilters['subcategory_id'], fn($q) => $q->where('subcategory2_id', $this->appliedFilters['subcategory2_id']))
            ->when($this->appliedFilters['subcategory3_id'] && $this->appliedFilters['subcategory2_id'], fn($q) => $q->where('subcategory3_id', $this->appliedFilters['subcategory3_id']))
            ->when($this->appliedFilters['name'], fn($q) => $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->appliedFilters['name']) . '%']))
            ->when($this->appliedFilters['date_from'], fn($q) => $q->whereDate('created_at', '>=', $this->appliedFilters['date_from']))
            ->when($this->appliedFilters['date_to'], fn($q) => $q->whereDate('created_at', '<=', $this->appliedFilters['date_to']))
            ->with(['category', 'subcategory', 'subcategory2', 'subcategory3'])
            ->get();

        // Calcular vendidos y existencia
        $dateFrom = $this->appliedFilters['date_from'] ? Carbon::parse($this->appliedFilters['date_from'])->startOfDay() : null;
        $dateTo = $this->appliedFilters['date_to'] ? Carbon::parse($this->appliedFilters['date_to'])->endOfDay() : null;
        $products = $products->map(function($product) use ($dateFrom, $dateTo) {
            $query = SaleDetail::where('product_id', $product->id);
            if ($dateFrom) $query->whereHas('sale', fn($q) => $q->where('created_at', '>=', $dateFrom));
            if ($dateTo) $query->whereHas('sale', fn($q) => $q->where('created_at', '<=', $dateTo));
            $vendidos = $query->sum('quantity');
            $product->vendidos = $vendidos;
            $product->existencia = $product->stock;
            return $product;
        });

        return view('livewire.admin.product-report', compact('categories', 'subcategories', 'subcategories2', 'subcategories3', 'products'));
    }
}
