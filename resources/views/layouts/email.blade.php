<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MNOTAS') }}</title>
    @vite(['resources/sass/app.scss'])

</head>

<body class="bg-back-primary">

    <div id="email-layout" class="container py-5">
        @yield('content')
    </div>
   

</body>

</html>
