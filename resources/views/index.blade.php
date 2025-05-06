@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Carousel -->
    <div class="col-12">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/banner/1.png') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/banner/2.png') }}" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<div class="container mt-5">
    <!-- Barra de búsqueda y ordenamiento -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar productos..." aria-label="Buscar productos">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="col-md-4">
            <select class="form-select" id="orderBy">
                <option selected>Ordenar por</option>
                <option value="price_asc">Precio: Menor a Mayor</option>
                <option value="price_desc">Precio: Mayor a Menor</option>
                <option value="name_asc">Nombre: A-Z</option>
                <option value="name_desc">Nombre: Z-A</option>
            </select>
        </div>
    </div>

    <!-- Filtros activos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-primary p-2">Aires Acondicionados <i class="fas fa-times ms-1"></i></span>
                <span class="badge bg-primary p-2">Split <i class="fas fa-times ms-1"></i></span>
                <span class="badge bg-primary p-2">LG <i class="fas fa-times ms-1"></i></span>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar de filtros -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h6 class="card-title fw-bold mb-3">Categorías</h6>
                    <div class="categories-list">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="aires" id="aires">
                            <label class="form-check-label" for="aires">
                                Aires Acondicionados
                            </label>
                            <div class="ms-3">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="split" id="split">
                                    <label class="form-check-label" for="split">Split</label>
                                </div>
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="ventana" id="ventana">
                                    <label class="form-check-label" for="ventana">Ventana</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="portatil" id="portatil">
                                    <label class="form-check-label" for="portatil">Portátil</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="ventilacion" id="ventilacion">
                            <label class="form-check-label" for="ventilacion">
                                Ventilación
                            </label>
                            <div class="ms-3">
                                <div class="form-check mb-1">
                                    <input class="form-check-input" type="checkbox" value="ventiladores" id="ventiladores">
                                    <label class="form-check-label" for="ventiladores">Ventiladores</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="extractores" id="extractores">
                                    <label class="form-check-label" for="extractores">Extractores</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="card-title fw-bold mb-3 mt-4">Marcas</h6>
                    <div class="brands-list">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="lg" id="lg">
                            <label class="form-check-label" for="lg">LG</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="samsung" id="samsung">
                            <label class="form-check-label" for="samsung">Samsung</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" value="mabe" id="mabe">
                            <label class="form-check-label" for="mabe">Mabe</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="daewoo" id="daewoo">
                            <label class="form-check-label" for="daewoo">Daewoo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid de productos -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold" style="color:#003366;">Productos</h3>
                <span class="text-muted">12 productos encontrados</span>
            </div>
            
            <div class="row g-4">
                <!-- Producto 1 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">OFERTA</span>
                        </div>
                        <img src="{{ asset('images/productos/producto1.png')}}" class="card-img-top p-3" alt="Aire Mabe">
                        <div class="card-body text-center">
                            <div class="text-muted small mb-1">MABE</div>
                            <h5 class="card-title mb-2">Aire Acondicionado Mabe 12K BTUS 110 V Frio</h5>
                            <div class="mb-2">
                                <span class="fw-bold fs-5 text-primary">$ 4,590.00</span>
                                <span class="text-decoration-line-through text-muted ms-2">$ 6,332.00</span>
                            </div>
                            <a href="/productos/prueba" class="btn btn-primary w-100">Ver Detalles</a>
                        </div>
                    </div>
                </div>
                <!-- Producto 2 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">OFERTA</span>
                        </div>
                        <img src="{{ asset('images/productos/producto2.png')}}" class="card-img-top p-3" alt="Aire LG">
                        <div class="card-body text-center">
                            <div class="text-muted small mb-1">LG</div>
                            <h5 class="card-title mb-2">Aire Acondicionado LG 12K BTUS 110V</h5>
                            <div class="mb-2">
                                <span class="fw-bold fs-5 text-primary">$ 4,890.00</span>
                                <span class="text-decoration-line-through text-muted ms-2">$ 7,412.00</span>
                            </div>
                            <a href="/productos/prueba" class="btn btn-primary w-100">Ver Detalles</a>
                        </div>
                    </div>
                </div>
                <!-- Producto 3 -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">OFERTA</span>
                        </div>
                        <img src="{{ asset('images/productos/producto1.png')}}" class="card-img-top p-3" alt="Aire Daewoo">
                        <div class="card-body text-center">
                            <div class="text-muted small mb-1">DAEWOO</div>
                            <h5 class="card-title mb-2">Aire Acondicionado Daewoo 12K BTUS 110V</h5>
                            <div class="mb-2">
                                <span class="fw-bold fs-5 text-primary">$ 5,085.00</span>
                                <span class="text-decoration-line-through text-muted ms-2">$ 6,365.00</span>
                            </div>
                            <a href="/productos/prueba" class="btn btn-primary w-100">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-5px);
}

.sticky-top {
    z-index: 1000;
}

.badge {
    cursor: pointer;
}

.badge i {
    opacity: 0.7;
}

.badge:hover i {
    opacity: 1;
}
</style>
@endsection