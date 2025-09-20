@extends('layouts.admin')

@section('content')
<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Banner Principal</h3>
                <div class="nk-block-des text-soft">
                    <p>Gestiona los banners principales del sitio web.</p>
                    <small> dimension recomendada 1909px  × 422 px</small>
                </div>
            </div>
        </div>
    </div>

    <div class="nk-block">
        <div class="row g-gs">
            <!-- Upload Form -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">Subir Nuevo Banner</h5>
                        </div>
                        
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

                        <form action="{{ route('admin.banner-principal.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="form-label" for="image">Imagen del Banner</label>
                                <div class="form-control-wrap">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*" required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-note">
                                    Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <em class="icon ni ni-upload"></em>
                                    <span>Subir Banner</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Banners Display -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">Banners Actuales</h5>
                        </div>
                        
                        @if($banners->count() > 0)
                            <div class="row g-3">
                                @foreach($banners as $banner)
                                    <div class="col-sm-6 col-lg-4">
                                        <div class="gallery-item">
                                            <div class="gallery-image">
                                                <img src="{{ asset('images/banner/' . $banner->image) }}" 
                                                     alt="Banner" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                            </div>
                                            <div class="gallery-body">
                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <small class="text-muted">
                                                        {{ $banner->created_at->format('d/m/Y H:i') }}
                                                    </small>
                                                    <form action="{{ route('admin.banner-principal.destroy', $banner->id) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este banner?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <em class="icon ni ni-trash"></em>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="nk-block-image">
                                    <em class="icon ni ni-img" style="font-size: 3rem; color: #c4c4c4;"></em>
                                </div>
                                <div class="nk-block-content">
                                    <h6>No hay banners disponibles</h6>
                                    <p class="text-soft">Sube tu primer banner usando el formulario de la izquierda.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection