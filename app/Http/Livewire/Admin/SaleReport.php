<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\WareHouse;
use App\Models\User;
use Illuminate\Support\Carbon;

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
            ->with(['user', 'client', 'details.product'])
            ->orderBy('created_at', 'desc');

        $sales = $salesQuery->get();

        $report = [];
        foreach ($sales as $sale) {
            $venta = [
                'id' => $sale->id,
                'fecha' => $sale->created_at,
                'vendedor' => $sale->user->name ?? 'Sin usuario',
                'cliente' => $sale->client->name ?? 'Sin cliente',
                'total_venta' => $sale->total,
                'detalles' => [],
                'costo_real_total' => 0,
                'ganancia_total' => 0,
            ];
            foreach ($sale->details as $detail) {
                $quantity = $detail->quantity;
                $precio_venta_unitario = $detail->price;
                $subtotal_venta = $detail->quantity * $detail->price;
                $costo_real_unitario = 0;
                $costo_real_total = 0;
                $restante = $quantity;
                $warehouses = WareHouse::where('product_id', $detail->product_id)
                    ->orderBy('fechaingresa')
                    ->get();
                foreach ($warehouses as $warehouse) {
                    if ($warehouse->cantidad >= $restante) {
                        $costo_real_unitario = $warehouse->costo_compra; // El último costo unitario usado
                        $costo_real_total += $restante * $warehouse->costo_compra;
                        break;
                    } else {
                        $costo_real_total += $warehouse->cantidad * $warehouse->costo_compra;
                        $costo_real_unitario = $warehouse->costo_compra;
                        $restante -= $warehouse->cantidad;
                    }
                    if ($restante <= 0) break;
                }
                $ganancia = $subtotal_venta - $costo_real_total;
                $venta['detalles'][] = [
                    'producto' => $detail->product->name ?? 'Sin nombre',
                    'cantidad' => $quantity,
                    'precio_venta_unitario' => $precio_venta_unitario,
                    'subtotal_venta' => $subtotal_venta,
                    'costo_real_unitario' => $costo_real_unitario,
                    'costo_real_total' => $costo_real_total,
                    'ganancia' => $ganancia,
                ];
                $venta['costo_real_total'] += $costo_real_total;
                $venta['ganancia_total'] += $ganancia;
            }
            $report[] = $venta;
        }

        return view('livewire.admin.sale-report', [
            'users' => $users,
            'report' => $report,
        ]);
    }
} 