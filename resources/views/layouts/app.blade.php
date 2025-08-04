<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4A90E2">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MNOTAS') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('mnotasLogo.svg') }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


</head>

<body class="bg-back-primary d-flex flex-column min-vh-100" x-data="{
    larguraTela: window.innerWidth,
    responsivo: {
        'xl': 1200,
        'lg': 992,
        'md': 768,
        'sm': 576
    }
}">

    <div class="d-sm-block d-none">
        <x-menu.menuPrincipal></x-menu.menuPrincipal>
    </div>

    <div class="d-sm-none d-block">{{-- MENU MOBILE --}}
        <x-menu.menuMobile></x-menu.menuMobile>
    </div>

    <!-- Conteúdo Principal -->
    <div id="app" class="p-3 container flex-grow-1 mb-sm-0 mb-5">
        <div class="mb-sm-0 mb-3">{{-- Pra compensar o menu mobile --}}
            @yield('content')
        </div>
    </div>

    <!-- Div para a versão -->
    <div class="text-end d-sm-block d-none opacity-25 pb-1 pe-1">
        <small>{{ config('app.version') }}</small>
    </div>
</body>


</html>
