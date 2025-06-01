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
                
                // Obtener todas las entradas del producto ordenadas por fecha ascendente
                $entradas = ProductEntry::where('product_id', $detail->product_id)
                    ->orderBy('entry_date', 'asc')
                    ->get();

                // Obtener todas las ventas anteriores a esta venta
                $ventasAnteriores = ProductSale::where('product_id', $detail->product_id)
                    ->where('sale_date', '<', $sale->created_at)
                    ->orderBy('sale_date', 'asc')
                    ->get();

                // Calcular el stock disponible hasta el momento de la venta
                $stockDisponible = [];
                foreach ($entradas as $entrada) {
                    $cantidadDisponible = $entrada->quantity;
                    // Restar las ventas anteriores que afectan a esta entrada
                    foreach ($ventasAnteriores as $ventaAnterior) {
                        if ($cantidadDisponible > 0) {
                            $cantidadAReducir = min($cantidadDisponible, $ventaAnterior->quantity);
                            $cantidadDisponible -= $cantidadAReducir;
                        }
                    }
                    if ($cantidadDisponible > 0) {
                        $stockDisponible[] = [
                            'cantidad' => $cantidadDisponible,
                            'costo' => $entrada->cost_price
                        ];
                    }
                }

                // Calcular el costo real usando FIFO
                $cantidadRestante = $detail->quantity;
                $costoReal = 0;
                foreach ($stockDisponible as $stock) {
                    if ($cantidadRestante <= 0) break;
                    
                    $cantidadAUsar = min($cantidadRestante, $stock['cantidad']);
                    $costoReal += $cantidadAUsar * $stock['costo'];
                    $cantidadRestante -= $cantidadAUsar;
                }

                $ganancia = $monto_venta - $costoReal;
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