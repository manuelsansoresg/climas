@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Configuración del Sistema</h3>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>¡Por favor corrige los siguientes errores!</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <form action="{{ route('admin.config.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email de Contacto</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" 
                                                   value="{{ old('email', $config->email ?? '') }}">
                                            @error('email')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Teléfono</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" 
                                                   value="{{ old('phone', $config->phone ?? '') }}">
                                            @error('phone')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Dirección</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      id="address" name="address" rows="3">{{ old('address', $config->address ?? '') }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fb">Facebook URL</label>
                                            <input type="url" class="form-control @error('fb') is-invalid @enderror" 
                                                   id="fb" name="fb" 
                                                   value="{{ old('fb', $config->fb ?? '') }}"
                                                   placeholder="https://facebook.com/tu-pagina">
                                            @error('fb')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="instagram">Instagram URL</label>
                                            <input type="url" class="form-control @error('instagram') is-invalid @enderror" 
                                                   id="instagram" name="instagram" 
                                                   value="{{ old('instagram', $config->instagram ?? '') }}"
                                                   placeholder="https://instagram.com/tu-cuenta">
                                            @error('instagram')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="x">X (Twitter) URL</label>
                                            <input type="url" class="form-control @error('x') is-invalid @enderror" 
                                                   id="x" name="x" 
                                                   value="{{ old('x', $config->x ?? '') }}"
                                                   placeholder="https://x.com/tu-cuenta">
                                            @error('x')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_construction">Modo Construcción</label>
                                            <select class="form-control @error('is_construction') is-invalid @enderror" 
                                                    id="is_construction" name="is_construction">
                                                <option value="0" {{ old('is_construction', $config->is_construction ?? 0) == 0 ? 'selected' : '' }}>
                                                    Desactivado
                                                </option>
                                                <option value="1" {{ old('is_construction', $config->is_construction ?? 0) == 1 ? 'selected' : '' }}>
                                                    Activado
                                                </option>
                                            </select>
                                            <small class="form-text text-muted">
                                                Cuando está activado, el sitio mostrará una página de "En construcción"
                                            </small>
                                            @error('is_construction')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $config ? 'Actualizar Configuración' : 'Guardar Configuración' }}
                                    </button>
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