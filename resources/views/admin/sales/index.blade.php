@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Listado de Ventas</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">Nueva Venta</a>
                        </div>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="nk-block">
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
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sales as $sale)
                                            <tr>
                                                <td>{{ $sale->id }}</td>
                                                <td>{{ $sale->client ? $sale->client->name . ' ' . $sale->client->last_name : '-' }}</td>
                                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                                <td>${{ number_format($sale->total, 2) }}</td>
                                                <td>
                                                    <a href="{{ route('admin.sales.show', $sale) }}" class="btn btn-sm btn-info">Ver</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No hay ventas registradas aún.</td>
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