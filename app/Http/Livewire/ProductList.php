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
    ];

    public function mount()
    {
        $this->resetFilters();
    }

    public function resetFilters()
    {
        $this->reset(['selectedCategories', 'selectedSubcategories', 'selectedSubcategories2', 'selectedSubcategories3', 'minPrice', 'maxPrice']);
    }

    public function updatingSearch()
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
        $query = Product::query();

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

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

        if (!empty($this->minPrice)) {
            $query->where('precio_publico', '>=', $this->minPrice);
        }

        if (!empty($this->maxPrice)) {
            $query->where('precio_publico', '<=', $this->maxPrice);
        }

        // Aplicar ordenamiento
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

        return view('livewire.product-list', [
            'products' => $query->paginate(12),
            'categories' => Category::with(['subcategories.subcategories2.subcategories3'])->get()
        ]);
    }
}