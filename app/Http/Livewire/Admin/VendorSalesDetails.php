<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Carbon;
use App\Models\ProductEntry;
use Illuminate\Support\Facades\Log;

class VendorSalesDetails extends Component
{
    public $userId;
    public $dateFrom;
    public $dateTo;
    public $vendor;
    public $sales = [];
    public $totalAmount = 0;
    public $totalCost = 0;
    public $totalProfit = 0;

    public function mount($userId, $dateFrom = null, $dateTo = null)
    {
        $this->userId = $userId;
        $this->dateFrom = $dateFrom ?: null;
        $this->dateTo = $dateTo ?: null;
        
        // Buscar el vendedor
        $this->vendor = User::findOrFail($userId);
        
        // Cargar las ventas
        $this->loadSales();
    }

    public function loadSales()
    {
        $dateFrom = $this->dateFrom ? Carbon::parse($this->dateFrom)->startOfDay() : null;
        $dateTo = $this->dateTo ? Carbon::parse($this->dateTo)->endOfDay() : null;

        $salesQuery = Sale::query()
            ->where('user_id', $this->userId)
            ->when($dateFrom, fn($q) => $q->where('created_at', '>=', $dateFrom))
            ->when($dateTo, fn($q) => $q->where('created_at', '<=', $dateTo))
            ->with(['details.product', 'user'])
            ->orderBy('created_at', 'desc');

        $this->sales = $salesQuery->get();
        
        // Debugging: Check if sales are found
        if ($this->sales->isEmpty()) {
            Log::info('No sales found for vendor ID: ' . $this->userId . ' in date range: ' . $dateFrom . ' to ' . $dateTo);
        }
        
        // Reiniciar los totales
        $this->totalAmount = 0;
        $this->totalCost = 0;
        $this->totalProfit = 0;
        
        foreach ($this->sales as $sale) {
            foreach ($sale->details as $detail) {
                $monto_venta = $detail->price * $detail->quantity;
                
                // Obtener la entrada más reciente del producto
                $entradaReciente = ProductEntry::where('product_id', $detail->product_id)
                    ->orderBy('entry_date', 'desc')
                    ->first();

                // Calcular el costo real usando el costo más reciente
                $costoReal = $entradaReciente ? $entradaReciente->cost_price * $detail->quantity : 0;

                $this->totalAmount += $monto_venta;
                $this->totalCost += $costoReal;
                $this->totalProfit += ($monto_venta - $costoReal);
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.vendor-sales-details');
    }
} 