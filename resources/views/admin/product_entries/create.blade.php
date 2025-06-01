@extends('layouts.admin')

@section('content')
<div class="nk-content ">
  <div class="container-fluid">
    <div class="nk-content-inner">
      <div class="nk-content-body">
        <div class="nk-block-head nk-block-head-sm">
          <div class="nk-block-between">
            <div class="nk-block-head-content">
              <h3 class="nk-block-title page-title">Registrar Entrada de Producto</h3>
            </div>
          </div>
        </div>
        <div class="nk-block">
          <div class="card">
            <div class="card-body">
              <form action="{{ route('admin.product-entries.store') }}" method="POST">
                @csrf

                <div class="form-group">
                  <label for="product_id">*Producto</label>
                  <select class="form-control @error('product_id') is-invalid @enderror" id="warehouse_product_id" name="product_id" required>
                    <option value="">Seleccione un producto</option>
                    @foreach($products as $product)
                      <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                  </select>
                  @error('product_id')
                  <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="warehouse_id">*Almacén</label>
                  <select class="form-control @error('warehouse_id') is-invalid @enderror" id="warehouse_id" name="warehouse_id" required>
                    <option value="">Seleccione un almacén</option>
                    @foreach($warehouses as $warehouse)
                      <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>{{ $warehouse->name }}</option>
                    @endforeach
                  </select>
                  @error('warehouse_id')
                  <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="quantity">*Cantidad</label>
                  <input type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                  @error('quantity')
                  <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="cost_price">*Costo de Compra por Unidad</label>
                  <input type="number" step="0.01" min="0" class="form-control @error('cost_price') is-invalid @enderror" id="cost_price" name="cost_price" value="{{ old('cost_price') }}" required>
                  @error('cost_price')
                  <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="entry_date">*Fecha de Entrada</label>
                  <input type="date" class="form-control @error('entry_date') is-invalid @enderror" id="entry_date" name="entry_date" value="{{ old('entry_date', date('Y-m-d')) }}" required>
                  @error('entry_date')
                  <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Registrar Entrada</button>
                  <a href="{{ route('admin.product-entries.index') }}" class="btn btn-secondary">Cancelar</a>
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