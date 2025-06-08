@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detalles de la Compra</h4>
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Información de la Compra</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th class="text-muted">Folio:</th>
                                    <td>{{ $sale->folio }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Fecha:</th>
                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Estado:</th>
                                    <td>
                                        <span class="badge bg-{{ $sale->status === 'completed' ? 'success' : ($sale->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($sale->status) }}
                                        </span>
                                        @if($sale->status === 'pending')
                                            <div class="mt-2 text-warning">
                                                <small>El pago está en proceso de verificación. Por favor, espere.</small>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Método de Pago:</th>
                                    <td>{{ ucfirst($sale->payment_method) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Resumen de Pagos</h5>
                            <table class="table table-sm">
                                <tr>
                                    <th class="text-muted">Subtotal:</th>
                                    <td>${{ number_format($sale->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">IVA:</th>
                                    <td>${{ number_format($sale->iva, 2) }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Total:</th>
                                    <td class="fw-bold">${{ number_format($sale->total, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h5 class="text-muted mb-3">Productos Comprados</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                    <th>IVA</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->details as $detail)
                                    <tr>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>${{ number_format($detail->price, 2) }}</td>
                                        <td>${{ number_format($detail->subtotal, 2) }}</td>
                                        <td>${{ number_format($detail->iva, 2) }}</td>
                                        <td>${{ number_format($detail->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($sale->notes)
                        <div class="mt-4">
                            <h5 class="text-muted mb-3">Notas</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    {{ $sale->notes }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection