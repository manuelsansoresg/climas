<!DOCTYPE html>
<html lang="es" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Una potente y conceptual plantilla de panel de control de aplicaciones especialmente diseñada para desarrolladores y programadores.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>{{ env('APP_NAME') }}</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=3.2.4') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=3.2.4') }}">
</head>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="/" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/backti_logo.png') }}"
                                    srcset="{{ asset('images/backti_logo2x.png') }} 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg"
                                    src="{{ asset('images/backti_logo.png') }}"
                                    srcset="{{ asset('assets/images/logo-dark2x.png') }} 2x" alt="logo-dark">
                            </a>
                        </div>
                        @yield('content')
                    </div>
                    
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="./assets/js/bundle.js?ver=3.2.4"></script>
    <script src="./assets/js/scripts.js?ver=3.2.4"></script>
    <!-- select region modal -->
    
</body>

</html>