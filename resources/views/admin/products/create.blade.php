@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Nuevo Producto</h3>
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

                            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nombre del Producto <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id">Categoría <span class="text-danger">*</span></label>
                                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                                <option value="">Seleccione una categoría</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcategory_id">Subcategoría</label>
                                            <select class="form-control @error('subcategory_id') is-invalid @enderror" id="subcategory_id" name="subcategory_id">
                                                <option value="">Seleccione una subcategoría</option>
                                            </select>
                                            @error('subcategory_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcategory2_id">Subcategoría 2</label>
                                            <select class="form-control @error('subcategory2_id') is-invalid @enderror" id="subcategory2_id" name="subcategory2_id">
                                                <option value="">Seleccione una subcategoría 2</option>
                                            </select>
                                            @error('subcategory2_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcategory3_id">Subcategoría 3</label>
                                            <select class="form-control @error('subcategory3_id') is-invalid @enderror" id="subcategory3_id" name="subcategory3_id">
                                                <option value="">Seleccione una subcategoría 3</option>
                                            </select>
                                            @error('subcategory3_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Descripción</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_mayorista">Precio Mayorista</label>
                                            <input type="number" step="0.01" class="form-control @error('precio_mayorista') is-invalid @enderror" id="precio_mayorista" name="precio_mayorista" value="{{ old('precio_mayorista') }}">
                                            @error('precio_mayorista')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_distribuidor">Precio Distribuidor</label>
                                            <input type="number" step="0.01" class="form-control @error('precio_distribuidor') is-invalid @enderror" id="precio_distribuidor" name="precio_distribuidor" value="{{ old('precio_distribuidor') }}">
                                            @error('precio_distribuidor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_publico">Precio Público <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('precio_publico') is-invalid @enderror" id="precio_publico" name="precio_publico" value="{{ old('precio_publico') }}" required>
                                            @error('precio_publico')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="costo_compra">Costo de Compra</label>
                                            <input type="number" step="0.01" class="form-control @error('costo_compra') is-invalid @enderror" id="costo_compra" name="costo_compra" value="{{ old('costo_compra') }}">
                                            @error('costo_compra')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Imagen Principal <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required>
                                            <small class="form-text text-muted">Formatos permitidos: jpeg, png, jpg, gif. Máximo 2MB</small>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="images">Imágenes Adicionales</label>
                                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple>
                                            <small class="form-text text-muted">Formatos permitidos: jpeg, png, jpg, gif. Máximo 2MB por imagen</small>
                                            @error('images.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Sucursales <span class="text-danger">*</span></label>
                                            <div class="row">
                                                @foreach($sucursales as $sucursal)
                                                    <div class="col-md-4">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input @error('sucursales') is-invalid @enderror" 
                                                                id="sucursal_{{ $sucursal->id }}" 
                                                                name="sucursales[]" 
                                                                value="{{ $sucursal->id }}"
                                                                {{ in_array($sucursal->id, old('sucursales', [])) ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="sucursal_{{ $sucursal->id }}">{{ $sucursal->name }}</label>
                                                        </div>
                                                        <input type="number" 
                                                            class="form-control mt-2 @error('stock_sucursal.'.$sucursal->id) is-invalid @enderror" 
                                                            name="stock_sucursal[{{ $sucursal->id }}]" 
                                                            placeholder="Stock" 
                                                            min="0"
                                                            value="{{ old('stock_sucursal.'.$sucursal->id, 0) }}">
                                                        @error('stock_sucursal.'.$sucursal->id)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('sucursales')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pdf">PDF (Opcional)</label>
                                            <input type="file" class="form-control @error('pdf') is-invalid @enderror" id="pdf" name="pdf" accept=".pdf">
                                            <small class="form-text text-muted">Máximo 10MB</small>
                                            @error('pdf')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Estado <span class="text-danger">*</span></label>
                                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Guardar Producto</button>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
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