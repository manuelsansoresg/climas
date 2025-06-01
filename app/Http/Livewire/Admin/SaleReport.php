<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\WareHouse;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\ProductEntry;

class SaleReport extends Component
{
    public $filters = [
        'date_from' => null,
        'date_to' => null,
        'user_id' => null,
    ];
    public $appliedFilters = [
        'date_from' => null,
        'date_to' => null,
        'user_id' => null,
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

    public function render()
    {
        $users = User::all();
        $dateFrom = $this->appliedFilters['date_from'] ? Carbon::parse($this->appliedFilters['date_from'])->startOfDay() : null;
        $dateTo = $this->appliedFilters['date_to'] ? Carbon::parse($this->appliedFilters['date_to'])->endOfDay() : null;
        $userId = $this->appliedFilters['user_id'];

        $salesQuery = Sale::query()
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->with(['user', 'details'])
            ->orderBy('created_at', 'desc');

        $sales = $salesQuery->get();

        $report = [];
        foreach ($sales as $sale) {
            $vendedorId = $sale->user_id;
            $vendedorNombre = $sale->user->name ?? 'Sin usuario';
            if (!isset($report[$vendedorId])) {
                $report[$vendedorId] = [
                    'vendedor' => $vendedorNombre,
                    'monto_venta' => 0,
                    'costo_real' => 0,
                    'ganancia' => 0,
                ];
            }
            foreach ($sale->details as $detail) {
                $monto_venta = $detail->price * $detail->quantity;
                // Buscar la entrada más reciente anterior a la venta para el producto
                $entrada = ProductEntry::where('product_id', $detail->product_id)
                    ->orderByDesc('entry_date')
                    ->first();
                $costo_real = $entrada ? ($entrada->cost_price * $detail->quantity) : 0;
                $ganancia = $monto_venta - $costo_real;
                $report[$vendedorId]['monto_venta'] += $monto_venta;
                $report[$vendedorId]['costo_real'] += $costo_real;
                $report[$vendedorId]['ganancia'] += $ganancia;
            }
        }
        // Reindexar para la vista
        $report = array_values($report);
        return view('livewire.admin.sale-report', [
            'users' => $users,
            'report' => $report,
        ]);
    }
} 