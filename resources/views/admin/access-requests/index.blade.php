@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Solicitudes de Acceso</h3>
                        </div><!-- .nk-block-head-content -->
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

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>RFC</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($accessRequests as $request)
                                        <tr>
                                            <td>{{ $request->name }} {{ $request->last_name }}</td>
                                            <td>{{ $request->email }}</td>
                                            <td>{{ $request->phone }}</td>
                                            <td>{{ $request->rfc }}</td>
                                            <td>
                                                <span class="badge bg-warning">Pendiente</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.access-requests.edit', $request) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('admin.access-requests.move-to-user', $request) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Está seguro de mover esta solicitud a usuario?')">
                                                        <i class="fas fa-user-plus"></i> Mover a Usuario
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">
                                {{ $accessRequests->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection