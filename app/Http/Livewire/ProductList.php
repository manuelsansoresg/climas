<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $orderBy = 'name_asc';
    public $selectedCategories = [];
    public $selectedSubcategories = [];
    public $selectedSubcategories2 = [];
    public $selectedSubcategories3 = [];
    public $minPrice;
    public $maxPrice;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderBy' => ['except' => 'name_asc'],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function applySearch()
    {
        $this->resetPage();
    }

    public function updatingOrderBy()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with(['category', 'warehouses', 'saleDetails']);

        // Filtro por nombre
        if (!empty(trim($this->search))) {
            $searchTerm = trim($this->search);
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchTerm) . '%']);
        }

        // Filtros de categorías
        if (!empty($this->selectedCategories)) {
            $query->whereIn('category_id', $this->selectedCategories);
        }
        if (!empty($this->selectedSubcategories)) {
            $query->whereIn('subcategory_id', $this->selectedSubcategories);
        }
        if (!empty($this->selectedSubcategories2)) {
            $query->whereIn('subcategory2_id', $this->selectedSubcategories2);
        }
        if (!empty($this->selectedSubcategories3)) {
            $query->whereIn('subcategory3_id', $this->selectedSubcategories3);
        }

        // Filtros de precio
        if (!empty($this->minPrice)) {
            $query->where('precio_publico', '>=', $this->minPrice);
        }
        if (!empty($this->maxPrice)) {
            $query->where('precio_publico', '<=', $this->maxPrice);
        }

        // Filtro de stock disponible
        $query->whereHas('warehouses', function($q) {
            $q->where('stock', '>', 0);
        });

        // Ordenamiento
        switch($this->orderBy) {
            case 'price_asc':
                $query->orderBy('precio_publico', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('precio_publico', 'desc'); 
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'name_asc':
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $perPage = 12;
        $products = $query->paginate($perPage);

        return view('livewire.product-list', [
            'products' => $products,
            'categories' => Category::with(['subcategories.subcategories2.subcategories3'])->get()
        ]);
    }
}