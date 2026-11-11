{{--
  Módulo 9 · Inventario FUID — Detalle de una unidad de conservación (registro del inventario).
  Variable del futuro controlador: $registro (con 'alertas'). En la demostración se toma según el parámetro de ruta {id}.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Detalle del inventario (FUID)')
@section('subtitle', 'Unidad de conservación y sus datos según el formato')
@section('module', 'fuid')

@php
    $demo = require resource_path('sgdea/demo/fuid.php');
    $vm = (require resource_path('sgdea/presenters/fuid.php'))($demo['encabezado'], $demo['registros']);
    $todos = collect($vm['registros']);
    $registro = $registro ?? ($todos->firstWhere('id', (int) ($id ?? 1)) ?? $todos->first());
    $f = fn ($d) => $d ? date('d-m-Y', strtotime($d)) : '—';
    $v = fn ($x) => ($x === null || $x === '') ? '—' : $x;
    $anterior = $todos->firstWhere('id', $registro['id'] - 1);
    $siguiente = $todos->firstWhere('id', $registro['id'] + 1);
    $json = json_encode([$registro['rotulo']], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

@section('content')
    <x-sgdea.page-header :title="$registro['nombre_unidad']" :subtitle="'Registro ' . $registro['id'] . ' de ' . $todos->count() . ' · Caja ' . $v($registro['caja']) . ' · Carpeta ' . $v($registro['carpeta'])">
        <x-slot:actions>
            <x-sgdea.button variant="outline" icon="arrow-left" route="sgdea.fuid.index">Volver al inventario</x-sgdea.button>
            @if ($anterior)<x-sgdea.button variant="outline" route="sgdea.fuid.show" :params="['id' => $anterior['id']]">← Anterior</x-sgdea.button>@endif
            @if ($siguiente)<x-sgdea.button variant="outline" route="sgdea.fuid.show" :params="['id' => $siguiente['id']]">Siguiente →</x-sgdea.button>@endif
            <x-sgdea.button variant="secondary" icon="file" data-carpeta-rotulo="0">Rótulo de carpeta</x-sgdea.button>
        </x-slot:actions>
    </x-sgdea.page-header>

    @if (count($registro['alertas']))
        <x-sgdea.alert type="warning" title="Observaciones sobre los datos del inventario">
            <ul style="margin:.3rem 0 0 1rem;padding:0">@foreach ($registro['alertas'] as $a)<li>{{ $a }}</li>@endforeach</ul>
            Se muestran tal como están en el FUID entregado; deben revisarse con la dependencia.
        </x-sgdea.alert>
    @endif

    <div class="grid grid-2">
        <x-sgdea.card title="Identificación">
            <dl class="dl" style="grid-template-columns:140px 1fr">
                <dt>Número orden</dt><dd>{{ $v($registro['orden']) }}</dd>
                <dt>Código y dependencia</dt><dd>{{ $registro['codigo_dependencia'] }} · {{ $registro['dependencia'] }}</dd>
                <dt>Serie</dt><dd>{{ $registro['serie'] }}</dd>
                <dt>Subserie</dt><dd>{{ $v($registro['subserie']) }}</dd>
                <dt>Unidad de conservación</dt><dd>{{ $registro['nombre_unidad'] }}</dd>
                <dt>Fase del archivo</dt><dd>{{ $registro['fase_archivo'] ?? 'No especificada en el FUID' }}</dd>
                <dt>Origen del registro</dt><dd class="small">{{ $registro['origen'] }} @if ($registro['demo'])<x-sgdea.badge status="demo" :dot="false" />@endif</dd>
            </dl>
        </x-sgdea.card>
        <x-sgdea.card title="Fechas extremas">
            <dl class="dl" style="grid-template-columns:140px 1fr">
                <dt>Inicial (DD-MM-AAAA)</dt><dd>{{ $f($registro['fecha_inicial']) }}</dd>
                <dt>Final (DD-MM-AAAA)</dt><dd>{{ $f($registro['fecha_final']) }}</dd>
                <dt>Año</dt><dd>{{ $v($registro['anio']) }}</dd>
            </dl>
        </x-sgdea.card>
        <x-sgdea.card title="Soporte o formato">
            <dl class="dl" style="grid-template-columns:140px 1fr">
                <dt>Análogo</dt><dd>{{ $v($registro['soporte_analogo']) }}</dd>
                <dt>Electrónico</dt><dd>{{ $v($registro['soporte_electronico']) }}</dd>
            </dl>
        </x-sgdea.card>
        <x-sgdea.card title="Unidad de conservación · Físico · Papel">
            <dl class="dl" style="grid-template-columns:140px 1fr">
                <dt>Caja</dt><dd>{{ $v($registro['caja']) }}</dd>
                <dt>Carpeta</dt><dd>{{ $v($registro['carpeta']) }}</dd>
                <dt>Correlativo</dt><dd>{{ $v($registro['correlativo']) }}</dd>
                <dt>Número de folios</dt><dd>{{ $v($registro['folios']) }} <span class="muted small">(total: {{ $v($registro['folios_total']) }})</span></dd>
            </dl>
        </x-sgdea.card>
        <x-sgdea.card title="Otro">
            <dl class="dl" style="grid-template-columns:140px 1fr"><dt>Tipo</dt><dd>{{ $v($registro['otro_tipo']) }}</dd><dt>Cantidad</dt><dd>{{ $v($registro['otro_cantidad']) }}</dd></dl>
        </x-sgdea.card>
        <x-sgdea.card title="Electrónico">
            <dl class="dl" style="grid-template-columns:140px 1fr"><dt>Ubicación</dt><dd>{{ $v($registro['elec_ubicacion']) }}</dd><dt>Cantidad de documentos</dt><dd>{{ $v($registro['elec_cantidad']) }}</dd><dt>Tamaño</dt><dd>{{ $v($registro['elec_tamano']) }}</dd></dl>
        </x-sgdea.card>
        <x-sgdea.card title="Notas" class="span-all"><p style="margin:0">{{ $v($registro['notas']) }}</p></x-sgdea.card>
    </div>
    <script type="application/json" id="carpeta-data">{!! $json !!}</script>
@endsection

@push('modals')@include('sgdea.carpetas.partials.rotulo')@endpush
@push('scripts')<script src="{{ asset('sgdea/js/carpetas.js') }}"></script>@endpush
