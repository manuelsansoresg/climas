@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detalles de la Venta #{{ $sale->id }}</h5>
                    <div>
                        <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">Volver</a>
                        <button onclick="window.print()" class="btn btn-primary ms-2">Imprimir</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Información del Cliente</h6>
                            <p><strong>Nombre:</strong> {{ $sale->client->name }} {{ $sale->client->last_name }}</p>
                            <p><strong>Email:</strong> {{ $sale->client->email }}</p>
                            <p><strong>Teléfono:</strong> {{ $sale->client->phone }}</p>
                            <p><strong>RFC:</strong> {{ $sale->client->rfc }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Información de la Venta</h6>
                            <p><strong>Fecha:</strong> {{ $sale->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Vendedor:</strong> {{ $sale->user->name }}</p>
                            <p><strong>Método de Pago:</strong> {{ ucfirst($sale->payment_method) }}</p>
                            <p><strong>Estado:</strong> 
                                <span class="badge bg-{{ $sale->status === 'completed' ? 'success' : ($sale->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

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
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Totales:</strong></td>
                                    <td><strong>${{ number_format($sale->subtotal, 2) }}</strong></td>
                                    <td><strong>${{ number_format($sale->iva, 2) }}</strong></td>
                                    <td><strong>${{ number_format($sale->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($sale->notes)
                        <div class="mt-4">
                            <h6>Notas</h6>
                            <p>{{ $sale->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .btn {
        display: none;
    }
    .card {
        border: none !important;
    }
    .card-body {
        padding: 0 !important;
    }
}
</style>
@endpush
@endsection 