<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Detalle de Ventas - {{ $vendor->name }} {{ $vendor->last_name }}</h3>
                            <div class="nk-block-des text-soft">
                                <p>Período: {{ $dateFrom ? Carbon\Carbon::parse($dateFrom)->format('d/m/Y') : 'Todo' }} - {{ $dateTo ? Carbon\Carbon::parse($dateTo)->format('d/m/Y') : 'Todo' }}</p>
                            </div>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-primary">
                                <em class="icon ni ni-arrow-left"></em>
                                <span>Volver al Reporte</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Ventas</h6>
                                            <h3 class="card-text">${{ number_format($totalAmount, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Costo</h6>
                                            <h3 class="card-text">${{ number_format($totalCost, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Ganancia</h6>
                                            <h3 class="card-text">${{ number_format($totalProfit, 2) }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Monto Venta</th>
                                            <th>Costo Real</th>
                                            <th>Ganancia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sales as $sale)
                                            @foreach($sale->details as $detail)
                                                <tr>
                                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $detail->product->name }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    <td>${{ number_format($detail->price, 2) }}</td>
                                                    <td>${{ number_format($detail->price * $detail->quantity, 2) }}</td>
                                                    @php
                                                        $entradaReciente = \App\Models\ProductEntry::where('product_id', $detail->product_id)
                                                            ->orderBy('entry_date', 'desc')
                                                            ->first();
                                                        $costoReal = $entradaReciente ? $entradaReciente->cost_price * $detail->quantity : 0;
                                                    @endphp
                                                    <td>${{ number_format($costoReal, 2) }}</td>
                                                    <td>${{ number_format(($detail->price * $detail->quantity) - $costoReal, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No hay ventas para mostrar en este período.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 