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
                        @php
                            $images = $product->images;
                        @endphp
                        @foreach ($images as $image)
                            <img src="{{ asset($image->image)}}" class="img-thumbnail mb-2 gallery-thumb" data-index="0" style="cursor:pointer; width:70px; height:70px; object-fit:cover;" alt="Miniatura 1">
                        @endforeach
                    </div>
                    <button class="btn btn-link p-0 mt-2" id="gallery-down" style="color: #888;">&#9660;</button>
                </div>
                <!-- Imagen principal -->
                <div class="flex-grow-1 d-flex align-items-center justify-content-center">
                    <img id="main-img" src="{{ asset($product->image) }}" class="img-fluid rounded" style="max-height:350px; object-fit:contain;" alt="Imagen principal">
                </div>
            </div>
        </div>
        <!-- Detalles del producto -->
        <div class="col-12 col-lg-5 mt-4 mt-lg-0">
            <h5 class="text-uppercase text-muted mb-1">{{ $product->name }}</h5>
            <h2 class="fw-bold mb-3"> {{ $product->description }} </h2>
            <div class="mb-2">
                <span class="fs-3 fw-bold text-primary">$2,821.00</span>
                <span class="text-decoration-line-through text-muted ms-2">${{ number_format($product->precio_publico, 2) }}</span>
                <span class="badge bg-danger ms-2">OFERTA</span>
            </div>
            <p class="mb-2">Los <a href="#">gastos de envío</a> se calculan en la pantalla de pago.</p>
            <p class="mb-2">Paga hasta en <b>5 plazos</b> con <span class="badge bg-primary">mercado pago</span> </p>
            @php
                $getStock = $product->getAvailableStockAttribute();
            @endphp
            <p class="mb-2 {{ $getStock < 5 ? 'text-warning' : 'text-primary' }}"><i class="bi bi-exclamation-circle"></i>
                {{ $getStock < 5 ? 'Bajas existencias' : 'Existencias' }}: quedan {{ $getStock }}
            
            </p>
            <div class="d-flex gap-2 mb-3">
                @auth
                <button class="btn btn-danger flex-grow-1" id="add-to-cart-btn"
                data-product-id="{{ $product->id }}"
                data-url="{{ route('cart.add') }}"
                data-csrf="{{ csrf_token() }}"
            >Agregar al carrito</button>
                @else
                    @php
                        $whatsappNumber = '+529991575581';
                        $currentUrl = url()->current();
                        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text=" . urlencode("Hola, quiero información sobre este producto: {$currentUrl}");
                    @endphp
                    <a href="{{ $whatsappUrl }}" target="_blank" class="btn btn-primary">Contactar por WhatsApp</a>
                @endauth
                {{-- <button class="btn btn-danger flex-grow-1">Agregar Al Carrito</button>
                <button class="btn btn-outline-danger flex-grow-1">Comprar Ahora</button> --}}
            </div>
            {{-- <div class="mt-4">
                <p>Producto a un super precio.</p>
               <a href="#" class="btn btn-primary">Ver más</a>
            </div> --}}
        </div>
    </div>
    <!-- Productos relacionados -->
    <div class="mt-5">
        <h4 class="fw-bold mb-4">También te pueden interesar</h4>
        <div class="row g-3">
            @foreach ($relatedProducts as $related)
                <!-- Producto 1 -->
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="card h-100 position-relative shadow-sm">
                        {{-- <span class="badge bg-primary position-absolute m-2" style="z-index:2;">OFERTA</span> --}}
                        <img src="{{ asset($related->image) }}" class="card-img-top p-3" style="height:120px;object-fit:contain;" alt="{{ $related->name }}">


                        <div class="card-body text-center">
                            <div class="text-muted small mb-1"> {{ $related->name }} </div>
                            <h6 class="card-title mb-2">{{ $related->description }}</h6>
                            <div class="mb-2">
                                <span class="fw-bold text-primary fs-4">${{ number_format($related->precio_publico, 2) }}</span>
                                {{-- <span class="text-decoration-line-through text-muted ms-2">$ 6,332.00</span> --}}
                            </div>
                            <a href="#" class="btn btn-primary w-100">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection 