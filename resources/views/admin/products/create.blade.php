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

                            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nombre del Producto <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id">Categoría <span class="text-danger">*</span></label>
                                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                                <option value="">Seleccione una categoría</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
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
                                            <label for="precio_publico">Precio de descuento <span class="text-danger">*</span></label>

                                            <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount') }}" required>
                                            @error('discount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="precio_instalador">Precio instalador</label>
                                            <input type="number" step="0.01" class="form-control @error('precio_instalador') is-invalid @enderror" id="precio_instalador" name="precio_instalador" value="{{ old('precio_instalador') }}">
                                            @error('precio_instalador')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                 {{--    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="stock">Stock <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}" required min="0">
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="iva">IVA (%) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('iva') is-invalid @enderror" id="iva" name="iva" value="{{ old('iva', 16) }}" required min="0" max="100">
                                            @error('iva')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image" class="form-label">Imagen Principal <span class="text-danger">*</span></label>
                                            <div class="d-inline-block position-relative me-2 mb-2" id="main-image-block">
                                                <img id="previewImage" src="" alt="Vista previa" style="max-width: 200px; display: none;">
                                                <button id="mainImageDeleteBtn" type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 btn-remove-preview" style="display:none;right:0;top:0;z-index:2;">×</button>
                                            </div>
                                            <small class="form-text text-muted">Formatos permitidos: jpeg, png, jpg, gif. Máximo 2MB</small>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required>
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="images">Imágenes Adicionales</label>
                                            <div id="additionalImagesPreview" class="mb-2"></div>
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
                                            <label for="active">Estado <span class="text-danger">*</span></label>
                                            <select class="form-control @error('active') is-invalid @enderror" id="active" name="active" required>
                                                <option value="1" {{ old('active') == 1 ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ old('active') == 0 ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('active')
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

@section('scripts')
<script>
function previewMainImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('mainImagePreview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function deleteMainImage() {
    document.getElementById('image').value = '';
    document.getElementById('mainImagePreview').style.display = 'none';
    document.getElementById('previewImage').src = '';
}

function previewAdditionalImages(input) {
    const preview = document.getElementById('additionalImagesPreview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'd-inline-block position-relative me-2 mb-2';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Vista previa" style="max-width: 100px;">
                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0" onclick="removeAdditionalImage(${index})">×</button>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}

function removeAdditionalImage(index) {
    const dt = new DataTransfer();
    const input = document.getElementById('images');
    const { files } = input;
    
    for (let i = 0; i < files.length; i++) {
        if (i !== index) {
            dt.items.add(files[i]);
        }
    }
    
    input.files = dt.files;
    previewAdditionalImages(input);
}
</script>
@endsection 