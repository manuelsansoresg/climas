@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Editar Usuario</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">*Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="last_name">*Apellido</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                    @error('last_name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña (opcional)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>

                                <div class="form-group">
                                    <label for="phone">*Teléfono</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                    @error('phone')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone">CP</label>
                                    <input type="text" class="form-control @error('cp') is-invalid @enderror" id="cp" name="cp" value="{{ old('cp', $user->cp) }}">
                                    @error('cp')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="rfc">RFC</label>
                                    <input type="text" class="form-control @error('rfc') is-invalid @enderror" id="rfc" name="rfc" value="{{ old('rfc', $user->rfc) }}" >
                                    @error('rfc')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="address">Dirección</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" >{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                @if(auth()->user()->hasRole('Admin'))
                                <div class="form-group">
                                    <label for="client_type">Tipo de usuario</label>
                                    <select class="form-control @error('client_type') is-invalid @enderror" id="client_type" name="client_type" required>
                                        <option value="">Seleccione un tipo</option>
                                        <option value="Vendedor" {{ (old('client_type', $user->roles->first()->name ?? '') == 'Vendedor') ? 'selected' : '' }}>Vendedor</option>
                                        <option value="Almacen" {{ (old('client_type', $user->roles->first()->name ?? '') == 'Almacen') ? 'selected' : '' }}>Almacén</option>
                                        <option value="Cliente publico en general" {{ (old('client_type', $user->roles->first()->name ?? '') == 'Cliente publico en general') ? 'selected' : '' }}>Cliente público en general</option>
                                        <option value="Cliente mayorista" {{ (old('client_type', $user->roles->first()->name ?? '') == 'Cliente mayorista') ? 'selected' : '' }}>Cliente mayorista</option>
                                        <option value="Cliente instalador" {{ (old('client_type', $user->roles->first()->name ?? '') == 'Cliente instalador') ? 'selected' : '' }}>Cliente instalador</option>
                                    </select>
                                    @error('client_type')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                @endif

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
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