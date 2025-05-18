@extends('layouts.admin')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Nuevo Registro de Almacén</h3>
                        </div>
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{ route('admin.warehouses.index') }}" class="btn btn-primary">
                                    <em class="icon ni ni-arrow-left"></em>
                                    <span>Volver</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="card-inner">
                            <form action="{{ route('admin.warehouses.store') }}" method="POST">
                                @csrf
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="product_id">Producto <span class="text-danger">*</span></label>
                                            <select class="form-select js-select2" id="product_id" name="product_id" required style="width:100%">
                                                <option value="">Buscar producto...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="provedor_id">Proveedor</label>
                                            <select class="form-select" id="provedor_id" name="provedor_id">
                                                <option value="">Seleccione un proveedor</option>
                                                @foreach($providers as $provider)
                                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="factura">Factura</label>
                                            <input type="text" class="form-control" id="factura" name="factura">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="serie">Serie</label>
                                            <input type="text" class="form-control" id="serie" name="serie">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="costo_compra">Costo de Compra <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control" id="costo_compra" name="costo_compra" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="cantidad">Cantidad<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="fechaingresa">Fecha de Ingreso<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="fechaingresa" name="fechaingresa" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="campo1">Campo1</label>
                                            <input type="text" class="form-control" id="campo1" name="campo1">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="campo2">Campo2</label>
                                            <input type="text" class="form-control" id="campo2" name="campo2">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="campo3">Campo3</label>
                                            <input type="text" class="form-control" id="campo3" name="campo3">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="campo4">Campo4</label>
                                            <input type="text" class="form-control" id="campo4" name="campo4">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="campo5">Campo5</label>
                                            <input type="text" class="form-control" id="campo5" name="campo5">
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
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

@push('scripts')
<script>
$(document).ready(function() {
    $('#product_id').select2({
        placeholder: 'Buscar producto...',
        allowClear: true,
        ajax: {
            url: '/api/products/search',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(item) {
                        return {
                            id: item.id,
                            text: item.name
                        };
                    })
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });
});
</script>
@endpush 