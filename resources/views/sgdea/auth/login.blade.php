{{--
  Pantalla de inicio de sesión (SOLO DISEÑO).
  Integración pendiente: POST a la futura ruta de login (sugerida: sgdea.login.store).
  Campos coherentes con la tabla usuarios: correo, contrasena.
--}}
@extends('sgdea.layouts.auth')
@section('title', 'Iniciar sesión')

@section('content')
    <h2>Iniciar sesión</h2>
    <p class="muted mb-2">Ingrese con su usuario institucional para acceder al SGDEA.</p>

    <form method="POST" action="#" data-demo-form data-demo-message="Demostración: no se inició sesión. La autenticación se conectará en la etapa de backend." novalidate>
        @csrf
        <x-sgdea.field label="Correo electrónico" name="correo" type="email" :required="true" placeholder="usuario@empresa.gov.co" autocomplete="username" />
        <x-sgdea.field label="Contraseña" name="contrasena" type="password" :required="true" placeholder="Ingrese su contraseña" autocomplete="current-password" />
        <x-sgdea.button type="submit" class="btn-block" icon="lock">Iniciar sesión</x-sgdea.button>
    </form>

    <p class="mt-2 small" style="text-align:center">
        @php $rec = \Illuminate\Support\Facades\Route::has('sgdea.password.request') ? route('sgdea.password.request') : null; @endphp
        <a href="{{ $rec ?? '#' }}" @unless ($rec) data-pending-route="sgdea.password.request" @endunless>¿Olvidó su contraseña?</a>
    </p>
@endsection
