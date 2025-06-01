@extends('layouts.admin')

@section('content')
<div class="nk-content ">
  <div class="container-fluid">
    <div class="nk-content-inner">
      <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
          <div class="nk-block-between">
            <div class="nk-block-head-content">
              <h3 class="nk-block-title page-title">Listado de Ventas / Salidas</h3>
            </div>
            <div class="nk-block-head-content">
              <a href="{{ route('admin.product-sales.create') }}" class="btn btn-primary">Nueva Venta</a>
            </div>
          </div>
        </div>

        <div class="nk-block">
          <div class="card">
            <div class="card-inner">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Producto</th>
                    <th>Almacén</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Fecha Venta</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($productSales as $sale)
                  <tr>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->warehouse->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>${{ number_format($sale->sale_price, 2) }}</td>
                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <div class="mt-3">
                {{ $productSales->links() }}
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection