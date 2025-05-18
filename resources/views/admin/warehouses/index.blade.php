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
                                          
                                            <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="btn btn-info btn-sm">
                                                <em class="icon ni ni-edit"></em>
                                            </a>
                                            @if($warehouse->trashed())
                                            <a href="#" onclick="restoreWarehouse({{ $warehouse->id }})" class="btn btn-success btn-sm">
                                                <em class="icon ni ni-refresh"></em>
                                            </a>
                                            @else
                                                <a href="#" onclick="deleteWarehouse({{ $warehouse->id }})" class="btn btn-danger btn-sm">
                                                    <em class="icon ni ni-trash"></em>
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

@push('scripts')
<script>
function deleteWarehouse(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/warehouses/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Eliminado!',
                        'El registro ha sido eliminado.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    });
}

function restoreWarehouse(id) {
    Swal.fire({
        title: '¿Restaurar registro?',
        text: "¿Deseas restaurar este registro?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/warehouses/${id}/restore`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        '¡Restaurado!',
                        'El registro ha sido restaurado.',
                        'success'
                    ).then(() => {
                        window.location.reload();
                    });
                }
            });
        }
    });
}
</script>
@endpush 