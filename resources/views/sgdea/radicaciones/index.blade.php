{{--
  Módulo 3 · Radicación — Listado.
  Variables del futuro controlador (ver FRONTEND_BACKEND_CONTRACT.md): $radicaciones, $esDemo.
  Tabla relacionada: radicaciones (+ oficinas_productoras, usuarios).
--}}
@extends('sgdea.layouts.app')
@section('title', 'Radicación de comunicaciones')
@section('subtitle', 'Documentos recibidos, enviados e internos, y solicitudes PQRSDF')
@section('module', 'radicaciones')

@php
    $radicaciones = $radicaciones ?? require resource_path('sgdea/demo/radicaciones.php');
    $esDemo = $esDemo ?? true;
    $col = collect($radicaciones);
    $anios = $col->pluck('anio_radicado')->unique()->sort()->values();
    $oficinas = $col->pluck('oficina')->unique()->sort()->values();
    $etiquetaTipo = ['entrada' => 'Entrada', 'salida' => 'Salida', 'interna' => 'Interna'];
    $toneTipo = ['entrada' => 'info', 'salida' => 'dark', 'interna' => 'neutral'];
    $nombre = fn ($d) => is_array($d) ? ($d['nombre'] ?? '—') : ($d ?: '—');
    $json = json_encode($col->map(fn ($r) => [
        'numero_radicado' => $r['numero_radicado'], 'fecha_hora' => $r['fecha_hora'], 'folios' => $r['folios'], 'anexos' => $r['anexos'],
        'remitente' => $nombre($r['datos_remitente']), 'asunto' => $r['asunto'],
    ])->values()->all(), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

@section('content')
    <x-sgdea.page-header title="Listado de radicaciones" subtitle="El número de radicado y la fecha y hora los asigna el sistema y no se pueden modificar.">
        <x-slot:actions>
            <x-sgdea.button icon="plus" route="sgdea.radicaciones.create">Nueva radicación</x-sgdea.button>
        </x-slot:actions>
    </x-sgdea.page-header>

    @if ($esDemo)
        <x-sgdea.alert type="warning" title="Datos de demostración">
            Los números de radicado (DEMO-…) no son consecutivos reales. Las solicitudes PQRSDF se radican por este mismo flujo como comunicaciones de entrada (HU-GDO-03).
        </x-sgdea.alert>
    @endif

    <x-sgdea.card :flush="true">
        <div class="tabs" style="padding:0 1rem;margin:0" role="tablist" id="rad-tabs">
            <button type="button" class="tab-btn is-active" data-rad-filter="">Todas ({{ $col->count() }})</button>
            @foreach ($etiquetaTipo as $k => $l)
                <button type="button" class="tab-btn" data-rad-filter="{{ $k }}">
                    {{ ['entrada' => 'Recibidas', 'salida' => 'Enviadas', 'interna' => 'Internas'][$k] }} ({{ $col->where('tipo', $k)->count() }})
                </button>
            @endforeach
        </div>

        <div class="filters" id="rad-filtros">
            <x-sgdea.field label="Año" name="f_anio" type="select" id="rf-anio" placeholder="Todos" :options="$anios->combine($anios)->all()" />
            <x-sgdea.field label="Dependencia" name="f_oficina" type="select" id="rf-oficina" placeholder="Todas" :options="$oficinas->combine($oficinas)->all()" />
            <x-sgdea.field label="Fecha desde" name="f_desde" type="date" id="rf-desde" />
            <x-sgdea.field label="Fecha hasta" name="f_hasta" type="date" id="rf-hasta" />
        </div>

        <x-sgdea.table id="tbl-rad" :cols="9" placeholder="Buscar por radicado, asunto o remitente…">
            <x-slot:head>
                <tr><th>Radicado</th><th>Tipo</th><th>Asunto</th><th>Remitente → Destinatario</th><th>Dependencia</th><th>Fecha y hora</th><th>Folios / anexos</th><th>Estado</th><th class="text-right">Acciones</th></tr>
            </x-slot:head>
            @foreach ($radicaciones as $i => $r)
                <tr data-tipo="{{ $r['tipo'] }}" data-anio="{{ $r['anio_radicado'] }}" data-oficina="{{ $r['oficina'] }}" data-fecha="{{ substr($r['fecha_hora'], 0, 10) }}">
                    <td class="mono nowrap"><strong>{{ $r['numero_radicado'] }}</strong></td>
                    <td class="nowrap"><x-sgdea.badge :tone="$toneTipo[$r['tipo']]" :label="$etiquetaTipo[$r['tipo']]" :dot="false" /></td>
                    <td>{{ $r['asunto'] }}</td>
                    <td class="small">{{ $nombre($r['datos_remitente']) }} → {{ $nombre($r['datos_destinatario']) }}</td>
                    <td class="small">{{ $r['oficina'] }}</td>
                    <td class="nowrap">{{ $r['fecha_hora'] }}</td>
                    <td class="nowrap">{{ $r['folios'] ?? '—' }} / {{ $r['anexos'] ?? '—' }}</td>
                    <td><x-sgdea.badge tone="info" :label="$r['estado']" /></td>
                    <td class="text-right nowrap">
                        <x-sgdea.button variant="ghost" size="sm" icon="eye" route="sgdea.radicaciones.show" :params="['id' => $r['id']]">Ver</x-sgdea.button>
                        <x-sgdea.button variant="ghost" size="sm" icon="file" data-rad-comprobante="{{ $i }}">Rótulo</x-sgdea.button>
                    </td>
                </tr>
            @endforeach
        </x-sgdea.table>
    </x-sgdea.card>
    <script type="application/json" id="rad-data">{!! $json !!}</script>
@endsection

@push('modals')
    @include('sgdea.radicaciones.partials.comprobante')
@endpush
@push('scripts')
    <script src="{{ asset('sgdea/js/radicaciones.js') }}"></script>
@endpush
