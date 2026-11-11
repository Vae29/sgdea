{{--
  Recuperación de contraseña (SOLO DISEÑO), en dos pasos según la tabla de restablecimiento (código y vencimiento).
  Integración pendiente: solicitud de código, validación de código y cambio de contraseña.
--}}
@extends('sgdea.layouts.auth')
@section('title', 'Recuperar contraseña')

@section('content')
    <h2>Recuperar contraseña</h2>

    <section data-step id="paso-1">
        <p class="muted mb-2">Ingrese su correo electrónico para solicitar un código de recuperación.</p>
        <form method="POST" action="#" data-demo-form data-demo-after="next-step" data-next-step="paso-2" data-demo-message="Demostración: no se envió ningún código. La recuperación se conectará en la etapa de backend." novalidate>
            @csrf
            <x-sgdea.field label="Correo electrónico" name="correo" type="email" :required="true" placeholder="usuario@empresa.gov.co" />
            <x-sgdea.button type="submit" class="btn-block" icon="mail">Solicitar código</x-sgdea.button>
        </form>
    </section>

    <section data-step id="paso-2" hidden>
        <x-sgdea.alert type="info">Pantalla visual del paso 2: aquí se ingresará el código recibido y la nueva contraseña.</x-sgdea.alert>
        <form method="POST" action="#" data-demo-form data-demo-message="Demostración: la contraseña no fue cambiada. La recuperación se conectará en la etapa de backend." novalidate>
            @csrf
            <x-sgdea.field label="Código de recuperación" name="code" :required="true" placeholder="Código recibido por correo" />
            <x-sgdea.field label="Nueva contraseña" name="contrasena" type="password" :required="true" />
            <x-sgdea.field label="Confirmar nueva contraseña" name="contrasena_confirmation" type="password" :required="true" data-match="#f-contrasena" />
            <x-sgdea.button type="submit" class="btn-block" icon="check">Cambiar contraseña</x-sgdea.button>
        </form>
    </section>

    <p class="mt-2 small" style="text-align:center">
        @php $login = \Illuminate\Support\Facades\Route::has('sgdea.login') ? route('sgdea.login') : null; @endphp
        <a href="{{ $login ?? '#' }}" @unless ($login) data-pending-route="sgdea.login" @endunless>← Volver al inicio de sesión</a>
    </p>
@endsection
