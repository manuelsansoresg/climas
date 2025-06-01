@extends('layouts.admin')

@section('content')
<div class="nk-content ">
  <div class="container-fluid">
    <div class="nk-content-inner">
      <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
          <div class="nk-block-between">
            <div class="nk-block-head-content">
              <h3 class="nk-block-title page-title">Listado de Entradas de Productos</h3>
            </div>
            <div class="nk-block-head-content">
              <a href="{{ route('admin.product-entries.create') }}" class="btn btn-primary">Nueva Entrada</a>
            </div>
          </div>
        </div>

        <div class="nk-block">
          <div class="card">
            <div class="card-inner">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Almacén</th>
                    <th>Cantidad</th>
                    <th>Costo Unitario</th>
                    <th>Fecha Entrada</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($productEntries as $entry)
                  <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->product->name }}</td>
                    <td>{{ $entry->warehouse->name }}</td>
                    <td>{{ $entry->quantity }}</td>
                    <td>${{ number_format($entry->cost_price, 2) }}</td>
                    <td>{{ $entry->entry_date->format('d/m/Y') }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <div class="mt-3">
                {{ $productEntries->links() }}
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection