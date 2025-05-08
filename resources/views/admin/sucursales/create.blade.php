@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Nueva Sucursal</h3>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.sucursales.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nombre de la Sucursal <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                id="name" name="name" value="{{ old('name') }}" 
                                                placeholder="Ej: Sucursal Centro" required>
                                            <small class="form-text text-muted">Ingrese el nombre completo de la sucursal</small>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Teléfono</label>
                                            <label for="phone">Teléfono <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                id="phone" name="phone" value="{{ old('phone') }}" 
                                                placeholder="Ej: (123) 456-7890" required>
                                            <small class="form-text text-muted">Ingrese el número de teléfono con código de área</small>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                id="email" name="email" value="{{ old('email') }}" 
                                                placeholder="Ej: sucursal@empresa.com" required>
                                            <small class="form-text text-muted">Ingrese un correo electrónico válido</small>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Estado <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            <small class="form-text text-muted">Seleccione si la sucursal está activa o inactiva</small>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Dirección </label>
                                            <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                                id="address" name="address" value="{{ old('address') }}" 
                                                placeholder="Ej: Av. Principal #123, Ciudad" required>
                                            <small class="form-text text-muted">Ingrese la dirección completa de la sucursal</small>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="latitude">Latitud</label>
                                            <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" 
                                                id="latitude" name="latitude" value="{{ old('latitude') }}" 
                                                placeholder="Ej: 19.4326">
                                            <small class="form-text text-muted">Ingrese la latitud para ubicación en mapas (opcional)</small>
                                            @error('latitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="longitude">Longitud</label>
                                            <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" 
                                                id="longitude" name="longitude" value="{{ old('longitude') }}" 
                                                placeholder="Ej: -99.1332">
                                            <small class="form-text text-muted">Ingrese la longitud para ubicación en mapas (opcional)</small>
                                            @error('longitude')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Descripción</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                id="description" name="description" rows="3" 
                                                placeholder="Ingrese una descripción detallada de la sucursal">{{ old('description') }}</textarea>
                                            <small class="form-text text-muted">Describa características especiales o información adicional de la sucursal</small>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="opening_hours">Horario de Atención</label>
                                            <textarea class="form-control @error('opening_hours') is-invalid @enderror" 
                                                id="opening_hours" name="opening_hours" rows="3" 
                                                placeholder="Ej: Lunes a Viernes: 9:00 AM - 6:00 PM">{{ old('opening_hours') }}</textarea>
                                            <small class="form-text text-muted">Especifique los horarios de atención de la sucursal</small>
                                            @error('opening_hours')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Guardar Sucursal</button>
                                    <a href="{{ route('admin.sucursales.index') }}" class="btn btn-secondary">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 