{{--
  Módulo 5 · Carpetas y expedientes — Listado.
  Variables del futuro controlador: $carpetas (con oficina, serie, subserie y totales), $esDemo.
  Tablas relacionadas: carpetas_archivo, cajas_almacenamiento, documentos_carpeta.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Carpetas y expedientes')
@section('subtitle', 'Organización de las unidades de conservación físicas, electrónicas e híbridas')
@section('module', 'carpetas')

@php
    $esDemo = $esDemo ?? true;
    $carpetas = $carpetas ?? (require resource_path('sgdea/presenters/carpetas.php'))(require resource_path('sgdea/demo/carpetas.php'), require resource_path('sgdea/demo/documentos.php'));
    $col = collect($carpetas);
    $json = json_encode($col->pluck('rotulo')->all(), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    $oficinas = $col->pluck('oficina')->unique()->sort()->values();
    $anios = $col->pluck('anio')->unique()->sort()->values();
@endphp

@section('content')
    <x-sgdea.page-header title="Listado de carpetas" subtitle="Cada carpeta pertenece a una oficina productora, a una serie y, cuando corresponda, a una subserie.">
        <x-slot:actions><x-sgdea.button icon="plus" route="sgdea.carpetas.create">Nueva carpeta</x-sgdea.button></x-slot:actions>
    </x-sgdea.page-header>
    @if ($esDemo)
        <x-sgdea.alert type="warning" title="Datos de demostración">Las carpetas CP1 y CP2 siguen el rótulo de caja de ejemplo (Contabilidad, caja 001); los folios y estados son ficticios.</x-sgdea.alert>
    @endif

    <x-sgdea.card :flush="true">
        <div class="filters" id="carp-filtros">
            <x-sgdea.field label="Estado" name="f_estado" type="select" id="cf-estado" placeholder="Todos" :options="['Abierta' => 'Abierta', 'Cerrada' => 'Cerrada']" />
            <x-sgdea.field label="Soporte" name="f_soporte" type="select" id="cf-soporte" placeholder="Todos" :options="['Físico' => 'Físico', 'Electrónico' => 'Electrónico', 'Híbrido' => 'Híbrido']" />
            <x-sgdea.field label="Oficina productora" name="f_oficina" type="select" id="cf-oficina" placeholder="Todas" :options="$oficinas->combine($oficinas)->all()" />
            <x-sgdea.field label="Año" name="f_anio" type="select" id="cf-anio" placeholder="Todos" :options="$anios->combine($anios)->all()" />
        </div>
        <x-sgdea.table id="tbl-carp" :cols="8" placeholder="Buscar por número, nombre o serie…">
            <x-slot:head>
                <tr><th>Nº</th><th>Nombre o asunto</th><th>Oficina / serie / subserie</th><th>Soporte</th><th>Apertura</th><th>Docs / folios</th><th>Estado</th><th class="text-right">Acciones</th></tr>
            </x-slot:head>
            @foreach ($carpetas as $i => $c)
                <tr data-estado="{{ $c['estado'] }}" data-soporte="{{ $c['soporte'] }}" data-oficina="{{ $c['oficina'] }}" data-anio="{{ $c['anio'] }}">
                    <td class="mono nowrap"><strong>{{ $c['numero_asignado'] }}</strong>@if ($c['caja'])<div class="small muted">Caja {{ $c['caja'] }}</div>@endif</td>
                    <td>{{ $c['nombre_carpeta'] }}</td>
                    <td class="small">{{ $c['oficina'] }}<div class="muted">{{ $c['serie'] }}@if ($c['subserie']) › {{ $c['subserie'] }}@endif</div></td>
                    <td class="nowrap">{{ $c['soporte'] }} @if ($c['hibrida'])<x-sgdea.badge tone="info" label="Híbrida" :dot="false" />@endif</td>
                    <td class="nowrap">{{ $c['fecha_apertura'] }}</td>
                    <td class="nowrap">{{ $c['total_documentos'] }} / {{ $c['cantidad_folios'] ?? '—' }}</td>
                    <td><x-sgdea.badge :status="$c['estado'] === 'Cerrada' ? 'cerrada' : 'abierta'" /></td>
                    <td class="text-right nowrap">
                        <x-sgdea.button variant="ghost" size="sm" icon="eye" route="sgdea.carpetas.show" :params="['id' => $c['id']]">Ver</x-sgdea.button>
                        <x-sgdea.button variant="ghost" size="sm" icon="file" data-carpeta-rotulo="{{ $i }}">Rótulo</x-sgdea.button>
                    </td>
                </tr>
            @endforeach
        </x-sgdea.table>
    </x-sgdea.card>
    <script type="application/json" id="carpeta-data">{!! $json !!}</script>
@endsection

@push('modals')@include('sgdea.carpetas.partials.rotulo')@endpush
@push('scripts')<script src="{{ asset('sgdea/js/carpetas.js') }}"></script>@endpush
