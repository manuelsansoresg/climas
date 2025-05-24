@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Sucursales</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{ route('admin.sucursales.create') }}" class="btn btn-primary">
                                    <em class="icon ni ni-plus"></em>
                                    <span>Nueva Sucursal</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Dirección</th>
                                            <th>Teléfono</th>
                                            <th>Email</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sucursales as $sucursal)
                                            <tr>
                                                <td>{{ $sucursal->name }}</td>
                                                <td>{{ $sucursal->address }}</td>
                                                <td>{{ $sucursal->phone }}</td>
                                                <td>{{ $sucursal->email }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $sucursal->status ? 'success' : 'danger' }}">
                                                        {{ $sucursal->status ? 'Activo' : 'Inactivo' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.sucursales.edit', $sucursal) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.sucursales.destroy', $sucursal) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta sucursal?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No hay sucursales registradas</td>
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
@endsection 