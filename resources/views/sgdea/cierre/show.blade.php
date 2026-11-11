{{--
  Módulo 6 · Cierre de carpetas — Detalle (índice provisional o definitivo).
  Variable del futuro controlador: $carpeta (con 'indice'). En la demostración se toma según el parámetro de ruta {id}.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Cierre de carpeta')
@section('subtitle', 'Estado de cierre, índice documental y transferencia estimada')
@section('module', 'cierre')

@php
    $todas = collect((require resource_path('sgdea/presenters/carpetas.php'))(require resource_path('sgdea/demo/carpetas.php'), require resource_path('sgdea/demo/documentos.php')));
    $carpeta = $carpeta ?? ($todas->firstWhere('id', (int) ($id ?? 3)) ?? $todas->first());
    $esDemo = $esDemo ?? true;
    $cerrada = $carpeta['estado'] === 'Cerrada';
@endphp

@section('content')
    <x-sgdea.page-header :title="$carpeta['numero_asignado'] . ' · ' . $carpeta['nombre_carpeta']">
        <x-slot:actions>
            <x-sgdea.button variant="outline" icon="arrow-left" route="sgdea.cierre.index">Volver</x-sgdea.button>
            <x-sgdea.button variant="outline" icon="folder" route="sgdea.carpetas.show" :params="['id' => $carpeta['id']]">Ver carpeta</x-sgdea.button>
            @unless ($cerrada)<x-sgdea.button variant="danger" icon="lock" data-cierre-abrir="{{ $carpeta['numero_asignado'] }} · {{ $carpeta['nombre_carpeta'] }}">Cerrar carpeta</x-sgdea.button>@endunless
        </x-slot:actions>
    </x-sgdea.page-header>

    @if ($cerrada)
        <x-sgdea.alert type="success" title="Expediente de Archivo (Cerrado)">Cierre declarado. La carpeta no admite modificaciones, adiciones ni eliminaciones.</x-sgdea.alert>
    @else
        <x-sgdea.alert type="info" title="Carpeta abierta">Puede revisar el índice provisional antes de cerrarla. El cierre es inalterable.</x-sgdea.alert>
    @endif
    @if ($esDemo)<x-sgdea.alert type="warning">Registro de demostración: el cierre no modifica ningún dato.</x-sgdea.alert>@endif

    <div class="grid grid-main">
        <x-sgdea.card title="Índice documental">@include('sgdea.carpetas.partials.indice', ['carpeta' => $carpeta])</x-sgdea.card>
        <div class="grid" style="align-content:start">
            <x-sgdea.card title="Estado de cierre">
                <x-slot:actions><x-sgdea.badge :status="$cerrada ? 'cerrada' : 'abierta'" /></x-slot:actions>
                <dl class="dl" style="grid-template-columns:120px 1fr">
                    <dt>Fecha de apertura</dt><dd>{{ $carpeta['fecha_apertura'] }}</dd>
                    <dt>Fecha de cierre</dt><dd>{{ $carpeta['fecha_cierre'] ?? 'Pendiente' }}</dd>
                    <dt>Índice sellado</dt><dd>{{ $carpeta['indice_sellado'] ?? 'Pendiente' }}</dd>
                    <dt>Transferencia estimada</dt><dd><span class="muted">{{ $carpeta['transferencia_estimada'] ?? 'No calculable: la TRD no tiene retención parametrizada' }}</span></dd>
                </dl>
                @if ($cerrada && $carpeta['indice_hash'])
                    <h4 class="small mt-2">Huella SHA-256 del índice definitivo</h4>
                    <div class="hash">{{ $carpeta['indice_hash'] }}</div>
                @endif
            </x-sgdea.card>
            <x-sgdea.card title="Clasificación">
                <dl class="dl" style="grid-template-columns:120px 1fr">
                    <dt>Oficina</dt><dd>{{ $carpeta['oficina'] }}</dd><dt>Serie</dt><dd>{{ $carpeta['serie'] }}</dd><dt>Subserie</dt><dd>{{ $carpeta['subserie'] ?? 'No aplica' }}</dd>
                    <dt>Soporte</dt><dd>{{ $carpeta['soporte'] }}</dd>
                </dl>
            </x-sgdea.card>
        </div>
    </div>
@endsection

@push('modals')@include('sgdea.cierre.partials.modal-cierre')@endpush
@push('scripts')<script src="{{ asset('sgdea/js/carpetas.js') }}"></script>@endpush
