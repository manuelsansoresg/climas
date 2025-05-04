@extends('layouts.app')

@section('content')
<div class="container">
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
<div class="container">

    <!-- Sección de Aires Acondicionados -->
    <div class="d-flex justify-content-between align-items-center mb-3 mt-5">
        <h3 class="fw-bold" style="color:#003366;"> Ofertas exclusivas en línea </h3>
        <a href="#" class="text-primary fw-semibold">Ver Todo</a>
    </div>
    <div class="row g-4">
        <!-- Producto 1 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 shadow-sm border-0">
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
                </div>
            </div>
        </div>
        <!-- Producto 2 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 shadow-sm border-0">
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
                </div>
            </div>
        </div>
        <!-- Producto 3 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 shadow-sm border-0">
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
                </div>
            </div>
        </div>
        <!-- Producto 4 -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card h-100 shadow-sm border-0">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
