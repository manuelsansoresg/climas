@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12 col-lg-7 mb-4 mb-lg-0">
            <div class="d-flex flex-row h-100 rounded-4 shadow bg-white p-3" style="min-height:400px;">
                <!-- Galería vertical -->
                <div class="d-flex flex-column align-items-center justify-content-center me-3" style="gap: 10px;" id="gallery-vertical">
                    <button class="btn btn-link p-0 mb-2" id="gallery-up" style="color: #888;">&#9650;</button>
                    <div id="gallery-thumbs" class="d-flex flex-column align-items-center" style="gap: 10px;">
                        <img src="/images/productos/producto1.png" class="img-thumbnail mb-2 gallery-thumb" data-index="0" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 1">
                        <img src="/images/productos/producto1_2.png" class="img-thumbnail mb-2 gallery-thumb" data-index="1" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 2">
                        <img src="/images/productos/producto1_3.png" class="img-thumbnail mb-2 gallery-thumb" data-index="2" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 3">
                        <img src="/images/productos/producto2.png" class="img-thumbnail mb-2 gallery-thumb" data-index="3" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 4">
                        <img src="/images/productos/producto2_2.png" class="img-thumbnail mb-2 gallery-thumb" data-index="4" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 5">
                        <img src="/images/productos/producto2_3.png" class="img-thumbnail mb-2 gallery-thumb" data-index="5" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 6">
                        <img src="/images/productos/producto1.png" class="img-thumbnail mb-2 gallery-thumb" data-index="6" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 7">
                        <img src="/images/productos/producto1_2.png" class="img-thumbnail mb-2 gallery-thumb" data-index="7" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 8">
                    </div>
                    <button class="btn btn-link p-0 mt-2" id="gallery-down" style="color: #888;">&#9660;</button>
                </div>
                <!-- Imagen principal -->
                <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                    <img id="main-img" src="/images/productos/producto1.png" class="img-fluid rounded" style="max-height:350px; object-fit:contain;" alt="Imagen principal">
                </div>
            </div>
        </div>
        <!-- Detalles del producto -->
        <div class="col-12 col-lg-5 mt-4 mt-lg-0">
            <h5 class="text-uppercase text-muted mb-1">DEMO</h5>
            <h2 class="fw-bold mb-3">Colchón Spring Air Baggio Individual</h2>
            <div class="mb-2">
                <span class="fs-3 fw-bold text-primary">$2,821.00</span>
                <span class="text-decoration-line-through text-muted ms-2">$3,761.00</span>
                <span class="badge bg-danger ms-2">OFERTA</span>
            </div>
            <p class="mb-2">Los <a href="#">gastos de envío</a> se calculan en la pantalla de pago.</p>
            <p class="mb-2">Hasta <b>15% de descuento</b> con <span class="badge bg-primary">kueskipay</span>. <b>Sin pago inicial.</b> Cupón: <b>KUESKINUEVO</b> <a href="#">¡Conócenos!</a></p>
            <p class="mb-2">Paga en <b>5 plazos</b> con <span class="badge bg-info">aplazo</span> <a href="#">Conoce más.</a></p>
            <p class="mb-2 text-warning"><i class="bi bi-exclamation-circle"></i> Bajas existencias: quedan 9</p>
            <div class="d-flex gap-2 mb-3">
                <button class="btn btn-danger flex-grow-1">Agregar Al Carrito</button>
                <button class="btn btn-outline-danger flex-grow-1">Comprar Ahora</button>
            </div>
            <div class="mt-4">
                <p>Las características que ofrece el Colchón Spring Air Baggio, permiten tener una comodidad y soporte especial al dormir, ya que gracias a la tecnología Combipad Orthorelax mejor conocido como aislante, evita que los resortes tengan contacto con el individuo e interrumpa su sueño, y si a esto le aumentamos la colchoneta Pillow Top y la Tela Piqué importada, este colchón sin duda se vuelve toda una experiencia en suavidad, frescura, ligereza y por supuesto de mucho confort.</p>
                <ul>
                    <li><b>Dimensiones (Ancho x Alto x Largo):</b> 25cm x 100 cm x 190 cm</li>
                    <li><b>Peso aproximado:</b> 25 kg</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Productos relacionados -->
    <div class="mt-5">
        <h4 class="fw-bold mb-4">También te pueden interesar</h4>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <span class="badge bg-danger position-absolute m-2">OFERTA</span>
                    <img src="{{ asset('images/productos/producto1.png') }}" class="card-img-top" alt="Relacionado 1">
                    <div class="card-body text-center">
                        <div class="text-muted small mb-1">AMERICA</div>
                        <h6 class="card-title">Colchón America Harmony Matrimonial</h6>
                        <div>
                            <span class="fw-bold text-primary">$5,124.00</span>
                            <span class="text-decoration-line-through text-muted ms-2">$7,599.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <span class="badge bg-danger position-absolute m-2">OFERTA</span>
                    <img src="{{ asset('images/productos/producto1_2.png') }}" class="card-img-top" alt="Relacionado 2">
                    <div class="card-body text-center">
                        <div class="text-muted small mb-1">SPRING AIR</div>
                        <h6 class="card-title">Colchón Spring Air Baggio King Size</h6>
                        <div>
                            <span class="fw-bold text-primary">$4,872.00</span>
                            <span class="text-decoration-line-through text-muted ms-2">$6,496.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <span class="badge bg-danger position-absolute m-2">OFERTA</span>
                    <img src="{{ asset('images/productos/producto1.png') }}" class="card-img-top" alt="Relacionado 3">
                    <div class="card-body text-center">
                        <div class="text-muted small mb-1">ZMARTECH</div>
                        <h6 class="card-title">Aire Acondicionado Zmartech 12K BTUS 110V Blanco</h6>
                        <div>
                            <span class="fw-bold text-primary">$4,390.00</span>
                            <span class="text-decoration-line-through text-muted ms-2">$5,929.00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <span class="badge bg-danger position-absolute m-2">OFERTA</span>
                    <img src="{{ asset('images/productos/producto2.png') }}" class="card-img-top" alt="Relacionado 4">
                    <div class="card-body text-center">
                        <div class="text-muted small mb-1">SPRING AIR</div>
                        <h6 class="card-title">Colchón Spring Air Baggio Matrimonial</h6>
                        <div>
                            <span class="fw-bold text-primary">$2,990.00</span>
                            <span class="text-decoration-line-through text-muted ms-2">$4,536.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 