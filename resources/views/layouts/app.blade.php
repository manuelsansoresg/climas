<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BackTI Climas') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <!-- App Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
            <div class="container-fluid">
                <button class="btn text-primary me-2 d-lg-none" id="sidebarToggle"><i class="fas fa-bars fa-lg"></i></button>
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="/images/backti_logo.png" alt="BackTI Climas" height="60" class="me-2">
                </a>
                <div class="d-flex align-items-center ms-auto">
                    <a href="/login" class="btn text-primary me-2"><i class="fas fa-user fa-lg"></i></a>
                    <a href="#" class="btn text-primary position-relative">
                        <i class="fas fa-shopping-bag fa-lg"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount">0</span>
                    </a>
                </div>
            </div>
        </nav>
        <!-- Search Overlay -->
        <div id="searchOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" style="background:rgba(255,255,255,0.95);z-index:1050;">
            <div class="d-flex justify-content-center align-items-start pt-5">
                <div class="search-box bg-white rounded-pill shadow p-2 d-flex align-items-center" style="width:90vw;max-width:500px;">
                    <input type="text" class="form-control border-0 bg-transparent" placeholder="Búsqueda" style="font-size:1.2rem;">
                    <button class="btn text-primary"><i class="fas fa-search"></i></button>
                    <button class="btn text-secondary ms-2" id="closeSearch"><i class="fas fa-times fa-lg"></i></button>
                </div>
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="/images/backti_logo.png" alt="BackTI Climas" height="60" class="mb-3">
                    <p class="text-secondary">Soluciones integrales en climatización y ventilación para hogares y empresas.</p>
                </div>
                <div class="col-lg-2 mb-4 mb-lg-0">
                    <h5 class="text-secondary mb-3">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/" class="text-decoration-none text-secondary">Inicio</a></li>
                        <li class="mb-2"><a href="/contacto" class="text-decoration-none text-secondary">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <h5 class="text-secondary mb-3">Contacto</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-phone text-primary me-2"></i> (123) 456-7890</li>
                        <li class="mb-2"><i class="fas fa-envelope text-primary me-2"></i> info@backticlimas.com</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> Dirección Ejemplo #123</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="text-secondary mb-3">Síguenos</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-primary"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-primary"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-primary"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-primary"><i class="fab fa-linkedin fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-3" style="background-color: #003366;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0 text-white">&copy; {{ date('Y') }} BackTI Climas. Todos los derechos reservados.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                        <a href="/privacidad" class="text-white text-decoration-none me-3">Política de Privacidad</a>
                        <a href="/terminos" class="text-white text-decoration-none">Términos y Condiciones</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Footer -->
    <!-- ... tu footer ... -->

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>