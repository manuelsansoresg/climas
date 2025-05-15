@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Reporte de Ventas</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">Volver al listado</a>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6 class="mb-1">Total de Ventas</h6>
                                <h3 class="mb-0">{{ $totalSales }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6 class="mb-1">Total Recaudado</h6>
                                <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <h6 class="mb-1">Venta Promedio</h6>
                                <h3 class="mb-0">${{ number_format($averageSale, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block mt-4">
                    <div class="card">
                        <div class="card-inner">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sales as $sale)
                                            <tr>
                                                <td>{{ $sale->id }}</td>
                                                <td>{{ $sale->client ? $sale->client->name . ' ' . $sale->client->last_name : '-' }}</td>
                                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                                <td>${{ number_format($sale->total, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No hay ventas registradas aún.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @if(method_exists($sales, 'links'))
                                    {{ $sales->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 