{{-- Mensajes de sesión (preparado para el backend). No ejecuta consultas. --}}
@if (session('success'))<x-sgdea.alert type="success" dismissible>{{ session('success') }}</x-sgdea.alert>@endif
@if (session('warning'))<x-sgdea.alert type="warning" dismissible>{{ session('warning') }}</x-sgdea.alert>@endif
@if (session('error'))<x-sgdea.alert type="error" dismissible>{{ session('error') }}</x-sgdea.alert>@endif
@if (isset($errors) && $errors->any())
    <x-sgdea.alert type="error" title="Revise la información ingresada" dismissible>Hay campos con errores de validación.</x-sgdea.alert>
@endif
