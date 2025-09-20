@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="parallax-banner">
                <h1><i class="fas fa-envelope"></i> Contáctanos</h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-primary"><i class="fas fa-envelope"></i> Contacto</h2>
            <p class="lead">Si tienes alguna duda o comentario, no dudes en contactarnos. Estamos aquí para ayudarte.</p>
            <div class="bg-light p-4 rounded shadow-sm mb-5">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <i class="fas fa-envelope fa-fw text-primary me-2"></i>
                        <strong>Email:</strong> <a href="mailto:{{ $config->email ?? 'contacto@ejemplo.com' }}">{{ $config->email ?? 'contacto@ejemplo.com' }}</a>
                    </li>
                    <li class="mb-3">
                        <i class="fas fa-phone fa-fw text-primary me-2"></i>
                        <strong>Teléfono:</strong> <a href="tel:{{ $config->phone ?? '+525512345678' }}">{{ $config->phone ?? '+52 55 1234 5678' }}</a>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw text-primary me-2"></i>
                        <strong>Dirección:</strong> {{ $config->address ?? 'Calle Falsa 123, Ciudad, País' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-primary"><i class="fas fa-user-lock"></i> Acceso al Sistema</h2>
            <p class="mb-4">Si deseas acceder al sistema, por favor envía tus datos a continuación:</p>
    
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif
    
            <form action="{{ route('access.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label"><i class="fas fa-user"></i> Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <div class="invalid-feedback">Por favor ingresa tu nombre.</div>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label"><i class="fas fa-user"></i> Apellido</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                    <div class="invalid-feedback">Por favor ingresa tu apellido.</div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
                    <input type="tel" name="phone" id="phone" class="form-control" required pattern="^\+?[0-9\s\-]{7,15}$">
                    <div class="invalid-feedback">Por favor ingresa un teléfono válido.</div>
                </div>
                <div class="mb-3">
                    <label for="rfc" class="form-label"><i class="fas fa-id-card"></i> RFC</label>
                    <input type="text" name="rfc" id="rfc" class="form-control" required pattern="^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$" maxlength="13" minlength="12" style="text-transform:uppercase;">
                    <div class="invalid-feedback">Por favor ingresa un RFC válido.</div>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-paper-plane"></i> Enviar Datos
                </button>
            </form>
        </div>
    </div>
</div>


<script>
// Bootstrap 5 form validation

</script>
@endsection