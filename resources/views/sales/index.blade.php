@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Mis Compras</h4>
                </div>
                <div class="card-body">
                    @if($sales->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No tienes compras registradas.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Estado</th>
                                        <th>Método de Pago</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->folio }}</td>
                                            <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                            <td>${{ number_format($sale->total, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $sale->status === 'completed' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($sale->status) }}
                                                </span>
                                            </td>
                                            <td>{{ ucfirst($sale->payment_method) }}</td>
                                            <td>
                                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Ver Detalles
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 