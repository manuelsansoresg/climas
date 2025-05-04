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
                    <button class="btn text-primary me-2" id="searchToggle"><i class="fas fa-search fa-lg"></i></button>
                    <a href="#" class="btn text-primary me-2"><i class="fas fa-user fa-lg"></i></a>
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
</body>
</html>
