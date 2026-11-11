<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SGDEA') · SGDEA · EVC E.S.P.</title>
    <link rel="icon" type="image/png" href="{{ asset('sgdea/img/logo-evc.png') }}">
    <link rel="stylesheet" href="{{ asset('sgdea/css/sgdea.css') }}">
    @stack('styles')
</head>
<body>
    <x-sgdea.demo-banner />
    <div class="app">
        @include('sgdea.partials.sidebar', ['activeModule' => trim($__env->yieldContent('module'))])
        <div class="sidebar-overlay" data-sidebar-close></div>
        <div class="main">
            @include('sgdea.partials.topbar')
            <main class="content">
                @include('sgdea.partials.flash')
                @yield('content')
            </main>
            <footer class="footer">Empresas Varias de Caicedonia E.V.C. – E.S.P. · Sistema de Gestión Documental Electrónica de Archivo (SGDEA)</footer>
        </div>
    </div>
    <div class="toast-stack" id="toast-stack" aria-live="polite"></div>
    @stack('modals')
    <script src="{{ asset('sgdea/js/sgdea.js') }}"></script>
    @stack('scripts')
</body>
</html>
