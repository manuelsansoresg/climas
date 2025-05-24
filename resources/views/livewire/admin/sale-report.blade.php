<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Reporte de Ventas</h3>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            <form class="row g-3 mb-4" wire:submit.prevent="applyFilters">
                                <div class="col-md-3">
                                    <label>Desde</label>
                                    <input type="date" class="form-control" wire:model.defer="filters.date_from">
                                </div>
                                <div class="col-md-3">
                                    <label>Hasta</label>
                                    <input type="date" class="form-control" wire:model.defer="filters.date_to">
                                </div>
                                <div class="col-md-3">
                                    <label>Vendedor</label>
                                    <select class="form-control" wire:model="filters.user_id">
                                        <option value="">Todos</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 mt-4 align-self-end">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </div>
                            </form>
                            <div class="table-responsive position-relative">
                                @forelse($report as $venta)
                                    <div class="mb-4">
                                        <table class="table table-bordered table-striped mb-1">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>ID Venta</th>
                                                    <th>Fecha</th>
                                                    <th>Vendedor</th>
                                                    <th>Cliente</th>
                                                    <th>Monto Venta</th>
                                                    <th>Costo Real Total</th>
                                                    <th>Ganancia Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $venta['id'] }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($venta['fecha'])->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $venta['vendedor'] }}</td>
                                                    <td>{{ $venta['cliente'] }}</td>
                                                    <td>${{ number_format($venta['total_venta'], 2) }}</td>
                                                    <td>${{ number_format($venta['costo_real_total'], 2) }}</td>
                                                    <td>${{ number_format($venta['ganancia_total'], 2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="ms-2 me-2 mb-4">
                                            <table class="table table-sm table-bordered table-hover">
                                                <thead class="table-secondary">
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio Venta Unitario</th>
                                                        <th>Subtotal Venta</th>
                                                        <th>Costo Real Unitario</th>
                                                        <th>Costo Real Total</th>
                                                        <th>Ganancia</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($venta['detalles'] as $detalle)
                                                        <tr>
                                                            <td>{{ $detalle['producto'] }}</td>
                                                            <td>{{ $detalle['cantidad'] }}</td>
                                                            <td>${{ number_format($detalle['precio_venta_unitario'], 2) }}</td>
                                                            <td>${{ number_format($detalle['subtotal_venta'], 2) }}</td>
                                                            <td>${{ number_format($detalle['costo_real_unitario'], 2) }}</td>
                                                            <td>${{ number_format($detalle['costo_real_total'], 2) }}</td>
                                                            <td>${{ number_format($detalle['ganancia'], 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info">No hay ventas para mostrar.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 