<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\WareHouse;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\ProductEntry;
use App\Models\ProductSale;

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
        //dd($sales);

        $report = [];
        foreach ($sales as $sale) {
            $saleId = $sale->id;
            $vendedorId = $sale->user_id;
            $vendedorNombre = $sale->user->name.' '.$sale->user->last_name ?? 'Sin usuario';
            if (!isset($report[$vendedorId])) {
                $report[$vendedorId] = [
                    'id' => $saleId,
                    'user_id' => $vendedorId,
                    'vendedor' => $vendedorNombre,
                    'monto_venta' => 0,
                    'costo_real' => 0,
                    'ganancia' => 0,
                ];
            }
            foreach ($sale->details as $detail) {
                $monto_venta = $detail->price * $detail->quantity;
                
                // Obtener la entrada más reciente del producto
                $entradaReciente = ProductEntry::where('product_id', $detail->product_id)
                    ->orderBy('entry_date', 'desc')
                    ->first();

                // Calcular el costo real usando el costo más reciente
                $costoReal = $entradaReciente ? $entradaReciente->cost_price * $detail->quantity : 0;

                $ganancia = $monto_venta - $costoReal;
                //$report[$vendedorId]['id'] += $saleId;
                $report[$vendedorId]['monto_venta'] += $monto_venta;
                $report[$vendedorId]['costo_real'] += $costoReal;
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