@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Editar Producto</h3>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nombre del Producto</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id">Categoría</label>
                                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                                <option value="">Seleccione una categoría</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
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
                                                @foreach($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                        {{ $subcategory->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subcategory_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="subcategory2_id">Subcategoría 2</label>
                                            <select class="form-control @error('subcategory2_id') is-invalid @enderror" id="subcategory2_id" name="subcategory2_id">
                                                <option value="">Seleccione una subcategoría 2</option>
                                                @foreach($subcategories2 as $subcategory2)
                                                    <option value="{{ $subcategory2->id }}" {{ old('subcategory2_id', $product->subcategory2_id) == $subcategory2->id ? 'selected' : '' }}>
                                                        {{ $subcategory2->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subcategory2_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
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
                                                @foreach($subcategories3 as $subcategory3)
                                                    <option value="{{ $subcategory3->id }}" {{ old('subcategory3_id', $product->subcategory3_id) == $subcategory3->id ? 'selected' : '' }}>
                                                        {{ $subcategory3->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subcategory3_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Descripción</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_mayorista">Precio Mayorista</label>
                                            <input type="number" step="0.01" class="form-control @error('precio_mayorista') is-invalid @enderror" id="precio_mayorista" name="precio_mayorista" value="{{ old('precio_mayorista', $product->precio_mayorista) }}">
                                            @error('precio_mayorista')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_distribuidor">Precio Distribuidor</label>
                                            <input type="number" step="0.01" class="form-control @error('precio_distribuidor') is-invalid @enderror" id="precio_distribuidor" name="precio_distribuidor" value="{{ old('precio_distribuidor', $product->precio_distribuidor) }}">
                                            @error('precio_distribuidor')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_publico">Precio Público</label>
                                            <input type="number" step="0.01" class="form-control @error('precio_publico') is-invalid @enderror" id="precio_publico" name="precio_publico" value="{{ old('precio_publico', $product->precio_publico) }}" required>
                                            @error('precio_publico')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_instalador">Precio instalador</label>
                                            <input type="number" step="0.01" class="form-control @error('precio_instalador') is-invalid @enderror" id="precio_instalador" name="precio_instalador" value="{{ old('precio_instalador', $product->precio_instalador) }}">
                                            @error('precio_instalador')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                   {{--  <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="stock">Stock <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0">
                                            @error('stock')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="iva">IVA (%) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('iva') is-invalid @enderror" id="iva" name="iva" value="{{ old('iva', $product->iva) }}" required min="0" max="100">
                                            @error('iva')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image" class=" d-block">Imagen Principal</label>
                                            <div class="d-inline-block position-relative me-2 mb-2" id="main-image-block">
                                                @if($product->image)
                                                    <img id="previewImage" src="{{ asset($product->image) }}" alt="Imagen actual" style="max-width: 200px; display: block;">
                                                    <button id="mainImageDeleteBtn" type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" style="right:0;top:0;z-index:2;" onclick="deleteMainProductImage({{ $product->id }})">×</button>
                                                @else
                                                    <img id="previewImage" src="" alt="Vista previa" style="max-width: 200px; display: none;">
                                                    <button id="mainImageDeleteBtn" type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" style="display:none;right:0;top:0;z-index:2;" onclick="deleteMainProductImage({{ $product->id }})">×</button>
                                                @endif
                                            </div>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewMainImage(this)">
                                            @error('image')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="images">Imágenes Adicionales</label>
                                            <div id="additionalImagesPreview" class="mb-2">
                                                @if($product->images->count() > 0)
                                                    @foreach($product->images as $image)
                                                        {{-- dump($image->id) --}}
                                                        <div class="d-inline-block position-relative me-2 mb-2" id="product-image-{{ $image->id }}">
                                                            <img src="{{ asset($image->image) }}" alt="Imagen adicional" style="max-width: 100px;">
                                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 btn-delete-adicional" data-id="{{ $image->id }}">×</button>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple onchange="previewAdditionalImages(this)">
                                            @error('images.*')
                                                <span class="invalid-feedback">{{ $message }}</span>
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
                                                            <input type="checkbox" class="custom-control-input" 
                                                                id="sucursal_{{ $sucursal->id }}" 
                                                                name="sucursales[]" 
                                                                value="{{ $sucursal->id }}" 
                                                                {{ in_array($sucursal->id, $selectedSucursales) ? 'checked' : '' }}>
                                                            <label class="custom-control-label" for="sucursal_{{ $sucursal->id }}">{{ $sucursal->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pdf">PDF (Opcional)</label>
                                            @if($product->pdf)
                                                <div class="mb-2">
                                                    <a href="{{ asset($product->pdf) }}" target="_blank" class="btn btn-info btn-sm">Ver PDF actual</a>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control @error('pdf') is-invalid @enderror" id="pdf" name="pdf" accept=".pdf">
                                            @error('pdf')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="active">Estado</label>
                                            <select class="form-control @error('active') is-invalid @enderror" id="active" name="active">
                                                <option value="1" {{ old('active', $product->active) == 1 ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ old('active', $product->active) == 0 ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('active')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Actualizar Producto</button>
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

@section('scripts')
{{-- El JS para este formulario está en resources/js/app.js --}}
@endsection
    
@endsection

