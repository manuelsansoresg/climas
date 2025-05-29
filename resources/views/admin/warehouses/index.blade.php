@extends('layouts.admin')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Almacén</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary">
                                    <em class="icon ni ni-plus"></em>
                                    <span>Nuevo Registro</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Factura</th>
                                        <th>Serie</th>
                                        <th>Costo Compra</th>
                                        <th>Cantidad</th>
                                        <th>Proveedor</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($warehouses as $warehouse)
                                    <tr>
                                        <td>{{ $warehouse->id }}</td>
                                        <td>{{ $warehouse->product->name }}</td>
                                        <td>{{ $warehouse->factura }}</td>
                                        <td>{{ $warehouse->serie }}</td>
                                        <td>${{ number_format($warehouse->costo_compra, 2) }}</td>
                                        <td>{{ $warehouse->cantidad }}</td>
                                        <td>{{ $warehouse->provider->name ?? 'N/A' }}</td>
                                        <td>{{ $warehouse->fechaingresa }}</td>
                                        <td>
                                          
                                            <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-info uniform-icon-size">
                                                <i class="fas fa-edit"></i>

                                            </a>
                                            @if($warehouse->trashed())
                                            <a href="#" onclick="restoreWarehouse({{ $warehouse->id }})" class="btn btn-success uniform-icon-size">
                                                <i class="fas fa-sync-alt"></i>
                                            </a>
                                            @else
                                                <a href="#" onclick="deleteWarehouse({{ $warehouse->id }})" class="btn btn-danger uniform-icon-size">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
