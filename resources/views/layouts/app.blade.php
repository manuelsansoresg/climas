<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'BackTI Climas') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome 5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <!-- App Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/principal.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png" />

    @livewireStyles

   
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: white;">
    <div id="app" class="flex-grow-1 d-flex flex-column">
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
            <div class="container-fluid">
                <!-- Botón hamburguesa para móvil -->
                <button class="btn text-primary me-2 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                    <i class="fas fa-bars fa-lg"></i>
                </button>

                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="/images/backti_logo.png" alt="BackTI Climas" height="60" class="me-2" />
                </a>

                <!-- Enlaces visibles en escritorio centrados con animación -->
                <div class="collapse navbar-collapse d-none d-lg-flex justify-content-center">
                    <ul class="navbar-nav mb-2 mb-lg-0 custom-animated-links">
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="/">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="/contacto">Contacto</a>
                        </li>
                    </ul>
                </div>

                <!-- Zona derecha escritorio -->
                <div class="d-none d-lg-flex align-items-center ms-auto">
                    @guest
                        <a href="/login" class="btn btn-outline-primary me-3">Iniciar Sesión</a>
                    @endguest

                    @auth
                        <ul class="navbar-nav align-items-center me-3">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                    <i class="fas fa-user fa-lg me-2 text-primary"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('sales.index') }}">Mis compras</a></li>
                                    <li><a class="dropdown-item" href="/cart">Carrito de compras</a></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Salir</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endauth

                    <livewire:cart-count />
                </div>
            </div>
        </nav>

        <!-- Offcanvas menú móvil -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menú</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Cerrar"></button>
            </div>
            <div class="offcanvas-body">
                @auth
                    <div class="mb-3 d-flex align-items-center">
                        <i class="fas fa-user fa-lg me-2 text-primary"></i>
                        <span class="fw-semibold">{{ Auth::user()->name }}</span>
                    </div>
                @endauth

                <ul class="list-unstyled">
                    <li><a href="/" class="text-decoration-none d-block py-2">Inicio</a></li>
                    <li><a href="/contacto" class="text-decoration-none d-block py-2">Contacto</a></li>
                </ul>

                @guest
                    <a href="/login" class="btn btn-primary w-100 mb-3">Iniciar Sesión</a>
                @endguest

                @auth
                   <hr>
                    <ul class="list-unstyled">
                        <li><a href="/mis-compras" class="text-decoration-none d-block py-2">Mis compras</a></li>
                        <li><a href="/cart" class="text-decoration-none d-block py-2">Carrito de compras</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logoutFormMobile">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 text-danger">Salir</button>
                            </form>
                        </li>
                    </ul>
                @endauth
            </div>
        </div>

        <main class="py-4 flex-grow-1 d-flex flex-column justify-content-center">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-auto">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="/images/backti_logo.png" alt="BackTI Climas" height="60" class="mb-3" />
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
                        <li class="mb-2"><i class="fas fa-phone text-primary me-2"></i> {{ $config->phone ?? '(123) 456-7890' }}</li>
                        <li class="mb-2"><i class="fas fa-envelope text-primary me-2"></i> {{ $config->email ?? 'info@backticlimas.com' }}</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt text-primary me-2"></i> {{ $config->address ?? 'Dirección Ejemplo #123' }}</li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5 class="text-secondary mb-3">Síguenos</h5>
                    <div class="d-flex gap-3">
                        @if($config->fb)
                            <a href="{{ $config->fb }}" class="text-primary" target="_blank"><i class="fab fa-facebook fa-2x"></i></a>
                        @endif
                        @if($config->instagram)
                            <a href="{{ $config->instagram }}" class="text-primary" target="_blank"><i class="fab fa-instagram fa-2x"></i></a>
                        @endif
                        @if($config->x)
                            <a href="{{ $config->x }}" class="text-primary" target="_blank"><i class="fab fa-twitter fa-2x"></i></a>
                        @endif
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

    <!-- Bootstrap Bundle JS (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <!-- Tu JS personalizado -->
    <script src="{{ asset('js/principal.js') }}"></script>

    @livewireScripts
</body>
</html>