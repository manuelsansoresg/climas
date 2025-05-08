@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Crear Nueva Subcategoría Nivel 3</h3>
                            
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        
                                        <li class="nk-block-tools-opt">
                                            {{-- <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus"></i> Nueva Subcategoría
                                            </a> --}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.subcategories3.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div class="form-group">
                                    <label for="description">Descripción</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div class="form-group">
                                    <label for="subcategory2_id">Subcategoría Nivel 2</label>
                                    <select class="form-control @error('subcategory2_id') is-invalid @enderror" id="subcategory2_id" name="subcategory2_id" required>
                                        <option value="">Seleccione una subcategoría nivel 2</option>
                                        @foreach($subcategories2 as $subcategory2)
                                            <option value="{{ $subcategory2->id }}" {{ old('subcategory2_id') == $subcategory2->id ? 'selected' : '' }}>
                                                {{ $subcategory2->name }} ({{ $subcategory2->subcategory->name }} - {{ $subcategory2->subcategory->category->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subcategory2_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a href="{{ route('admin.subcategories3.index') }}" class="btn btn-secondary">Cancelar</a>
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