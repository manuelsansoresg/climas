<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Subcategory2;
use App\Models\Subcategory3;
use App\Models\ProductEntry;
use App\Models\ProductSale;
use App\Models\SaleDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StockReport extends Component
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

        $dateFrom = $this->appliedFilters['date_from'] ? Carbon::parse($this->appliedFilters['date_from'])->startOfDay() : null;
        $dateTo = $this->appliedFilters['date_to'] ? Carbon::parse($this->appliedFilters['date_to'])->endOfDay() : null;

        $productEntries = ProductEntry::query()
            ->with(['product.category', 'product.subcategory', 'product.subcategory2', 'product.subcategory3', 'warehouse'])
            ->when($this->appliedFilters['category_id'], function($q) {
                $q->whereHas('product', fn($q) => $q->where('category_id', $this->appliedFilters['category_id']));
            })
            ->when($this->appliedFilters['subcategory_id'], function($q) {
                $q->whereHas('product', fn($q) => $q->where('subcategory_id', $this->appliedFilters['subcategory_id']));
            })
            ->when($this->appliedFilters['subcategory2_id'], function($q) {
                $q->whereHas('product', fn($q) => $q->where('subcategory2_id', $this->appliedFilters['subcategory2_id']));
            })
            ->when($this->appliedFilters['subcategory3_id'], function($q) {
                $q->whereHas('product', fn($q) => $q->where('subcategory3_id', $this->appliedFilters['subcategory3_id']));
            })
            ->when($this->appliedFilters['name'], function($q) {
                $q->whereHas('product', fn($q) => $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->appliedFilters['name']) . '%']));
            })
            ->when($dateFrom, function($q) use ($dateFrom) {
                $q->where('entry_date', '>=', $dateFrom);
            })
            ->when($dateTo, function($q) use ($dateTo) {
                $q->where('entry_date', '<=', $dateTo);
            })
            ->orderBy('entry_date', 'asc')
            ->get()
            ->groupBy('product_id')
            ->map(function($productEntries, $productId) {
                // Obtener el total vendido para este producto
                $totalVendidos = SaleDetail::where('product_id', $productId)->sum('quantity');
                $vendidosRestantes = $totalVendidos;
                $processedEntries = collect();
                
                foreach ($productEntries as $entry) {
                    $entryStock = $entry->quantity;
                    $entryVendidos = min($vendidosRestantes, $entryStock);
                    $entry->vendidos = $entryVendidos;
                    $entry->stock_restante = $entryStock - $entryVendidos;
                    $vendidosRestantes -= $entryVendidos;
                    $processedEntries->push($entry);
                }
                return $processedEntries;
            })
            ->flatten();

        return view('livewire.admin.stock-report', compact('categories', 'subcategories', 'subcategories2', 'subcategories3', 'productEntries'));
    }
}
