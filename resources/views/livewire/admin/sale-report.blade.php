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
                                <table class="table table-bordered table-striped mb-1">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Vendedor</th>
                                            <th>Monto de venta</th>
                                            <th>Costo Real</th>
                                            <th>Ganancias</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($report as $row)
                                            <tr>
                                                <td>{{ $row['vendedor'] }}</td>
                                                <td>${{ number_format($row['monto_venta'], 2) }}</td>
                                                <td>${{ number_format($row['costo_real'], 2) }}</td>
                                                <td>${{ number_format($row['ganancia'], 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No hay ventas para mostrar.</td>
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