<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Acceso') · SGDEA · EVC E.S.P.</title>
    <link rel="icon" type="image/png" href="{{ asset('sgdea/img/logo-evc.png') }}">
    <link rel="stylesheet" href="{{ asset('sgdea/css/sgdea.css') }}">
    @stack('styles')
</head>
<body>
    <div class="auth">
        <aside class="auth-aside">
            <div class="logo-box"><img src="{{ asset('sgdea/img/logo-evc.png') }}" alt="Logotipo de Empresas Varias de Caicedonia EVC E.S.P."></div>
            <div>
                <h1>Sistema de Gestión Documental Electrónica de Archivo (SGDEA)</h1>
            </div>
            <p>Empresas Varias de Caicedonia E.V.C. – E.S.P.<br>NIT 821.001.448-9</p>
        </aside>
        <main class="auth-main">
            <div class="auth-card">
                <div class="auth-mobile-logo"><img src="{{ asset('sgdea/img/logo-evc.png') }}" alt="Logotipo EVC E.S.P."></div>
                @yield('content')
                <p class="small muted mt-2" style="margin-bottom:0">Pantalla de demostración visual: no inicia sesión ni se conecta con la base de datos.</p>
            </div>
        </main>
    </div>
    <div class="toast-stack" id="toast-stack" aria-live="polite"></div>
    <script src="{{ asset('sgdea/js/sgdea.js') }}"></script>
    @stack('scripts')
</body>
</html>
