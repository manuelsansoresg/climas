@extends('layouts.admin')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Nueva Venta</h3>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-inner">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('admin.sales.store') }}" method="POST" id="saleForm">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="client-search">*Cliente</label>
                                            <select id="client-search" name="client_id" class="form-control" style="width:100%" required></select>
                                            @error('client_id')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="payment_method">Método de Pago</label>
                                            <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Efectivo</option>
                                                <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Tarjeta de Crédito</option>
                                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transferencia</option>
                                            </select>
                                            @error('payment_method')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_method">Estatus</label>
                                            <select name="status" id="status" class="form-control" required>
                                                @foreach(config('enums.sale_status') as $key => $value)
                                                    <option value="{{ $value }}">{{ $key }}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="file_transfer">Comprobante de Pago</label>
                                            <input type="file" name="file_transfer" id="file_transfer" class="form-control @error('file_transfer') is-invalid @enderror" accept=".jpeg,.jpg,.png,.pdf">
                                            <small class="form-text text-muted">Formatos permitidos: JPG, JPEG, PNG, PDF. Tamaño máximo: 2MB</small>
                                            @error('file_transfer')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <div id="file-preview" class="mt-2" style="display: none;">
                                                <img id="preview-image" src="" alt="Vista previa" style="max-width: 200px; display: none;">
                                                <div id="preview-pdf" style="display: none;">
                                                    <a href="#" target="_blank" class="btn btn-sm btn-info">Ver PDF</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_method">*Almacén</label>
                                            <select class="form-control @error('warehouse_id') is-invalid @enderror" id="warehouse_id" name="warehouse_id" required>
                                                <option value="">Seleccione un almacén</option>
                                                @foreach($warehouses as $warehouse)
                                                  <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4 mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label" for="notes">Notas</label>
                                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                                            @error('notes')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4 mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Agregar Producto</label>
                                            <select id="product-search" class="form-control" style="width:100%"></select>
                                            <button type="button" class="btn btn-primary mt-2" id="add-product">Agregar a la venta</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4 mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">Productos agregados</label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="products-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre</th>
                                                            <th>Cantidad</th>
                                                            <th>Stock</th>
                                                            <th>Costo real</th>
                                                            <th>Precio Unitario</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Productos agregados dinámicamente -->
                                                    </tbody>
                                                </table>
                                                <div id="price-validation-error" class="alert alert-danger mt-2" style="display: none;">
                                                    El precio unitario debe ser mayor que el costo real del producto.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4 mt-2">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Crear Venta</button>
                                        <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">Cancelar</a>
                                    </div>
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

