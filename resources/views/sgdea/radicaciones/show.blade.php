{{--
  Módulo 3 · Radicación — Detalle.
  Variables del futuro controlador: $radicacion (con radicado padre e hijos) y $documentos (documentos_digitales asociados).
  En la demostración se toma el registro según el parámetro de ruta {id}.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Detalle de radicación')
@section('subtitle', 'Consulta de una comunicación radicada')
@section('module', 'radicaciones')

@php
    $todas = collect(require resource_path('sgdea/demo/radicaciones.php'));
    $radicacion = $radicacion ?? ($todas->firstWhere('id', (int) ($id ?? 1)) ?? $todas->first());
    $documentos = $documentos ?? collect(require resource_path('sgdea/demo/documentos.php'))->where('radicado', $radicacion['numero_radicado'])->values()->all();
    $hijos = $hijos ?? $todas->where('padre', $radicacion['numero_radicado'])->values()->all();
    $esDemo = $esDemo ?? true;
    $etiquetaTipo = ['entrada' => 'Entrada (recibida)', 'salida' => 'Salida (enviada)', 'interna' => 'Interna'];
    $parte = fn ($d) => is_array($d) ? $d : ['nombre' => $d, 'identificacion' => '', 'contacto' => ''];
    $rem = $parte($radicacion['datos_remitente']);
    $des = $parte($radicacion['datos_destinatario']);
    $json = json_encode([[
        'numero_radicado' => $radicacion['numero_radicado'], 'fecha_hora' => $radicacion['fecha_hora'], 'folios' => $radicacion['folios'],
        'anexos' => $radicacion['anexos'], 'remitente' => $rem['nombre'], 'asunto' => $radicacion['asunto'],
    ]], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

@section('content')
    <x-sgdea.page-header>
        <x-slot:actions>
            <x-sgdea.button variant="outline" icon="arrow-left" route="sgdea.radicaciones.index">Volver al listado</x-sgdea.button>
            <x-sgdea.button variant="secondary" icon="file" data-rad-comprobante="0">Ver rótulo</x-sgdea.button>
            <x-sgdea.button icon="upload" route="sgdea.documentos.create">Adjuntar documento digital</x-sgdea.button>
        </x-slot:actions>
    </x-sgdea.page-header>

    @if ($esDemo)<x-sgdea.alert type="warning">Registro de demostración: ningún dato proviene de la base de datos.</x-sgdea.alert>@endif

    <div class="grid grid-main">
        <div class="grid">
            <x-sgdea.card title="Datos de la radicación">
                <x-slot:actions><x-sgdea.badge tone="info" :label="$radicacion['estado']" /></x-slot:actions>
                <div class="radicado-box mb-2">{{ $radicacion['numero_radicado'] }}</div>
                <dl class="dl">
                    <dt>Tipo de comunicación</dt><dd>{{ $etiquetaTipo[$radicacion['tipo']] }}</dd>
                    <dt>Asunto</dt><dd>{{ $radicacion['asunto'] }}</dd>
                    <dt>Dependencia relacionada</dt><dd>{{ $radicacion['oficina'] }} <span class="muted small">({{ $radicacion['unidad'] }})</span></dd>
                    <dt>Fecha y hora de radicación</dt><dd>{{ $radicacion['fecha_hora'] }} <span class="muted small">(sellada por el servidor)</span></dd>
                    <dt>Fecha del documento</dt><dd>{{ $radicacion['fecha_documento'] ?? '—' }}</dd>
                    <dt>Folios / anexos</dt><dd>{{ $radicacion['folios'] ?? '—' }} / {{ $radicacion['anexos'] ?? '—' }}</dd>
                    <dt>Radicado por</dt><dd>{{ $radicacion['usuario'] }}</dd>
                    @if ($radicacion['correo_solicitante'])<dt>Correo del solicitante</dt><dd>{{ $radicacion['correo_solicitante'] }}</dd>@endif
                </dl>
            </x-sgdea.card>

            <div class="grid grid-2">
                @foreach ([['Remitente', $rem], ['Destinatario', $des]] as [$titulo, $p])
                    <x-sgdea.card :title="$titulo">
                        <dl class="dl" style="grid-template-columns:110px 1fr">
                            <dt>Nombre</dt><dd>{{ $p['nombre'] ?: '—' }}</dd>
                            <dt>Identificación</dt><dd>{{ $p['identificacion'] ?: '—' }}</dd>
                            <dt>Contacto</dt><dd>{{ $p['contacto'] ?: '—' }}</dd>
                        </dl>
                    </x-sgdea.card>
                @endforeach
            </div>

            <x-sgdea.card title="Documentos digitales asociados" :flush="true">
                <x-sgdea.table id="tbl-rad-docs" :searchable="false" :cols="4" empty-text="Esta radicación aún no tiene documentos digitales.">
                    <x-slot:head><tr><th>Título</th><th>Tipo documental</th><th>Archivo</th><th class="text-right">Detalle</th></tr></x-slot:head>
                    @foreach ($documentos as $d)
                        <tr><td>{{ $d['titulo'] }}</td><td>{{ $d['tipo_documental'] }}</td><td class="mono small">{{ $d['nombre_original_archivo'] }}</td>
                            <td class="text-right"><x-sgdea.button variant="ghost" size="sm" icon="eye" route="sgdea.documentos.show" :params="['id' => $d['id']]">Ver</x-sgdea.button></td></tr>
                    @endforeach
                    @if (!count($documentos))<tr><td colspan="4" class="muted">Esta radicación aún no tiene documentos digitales.</td></tr>@endif
                </x-sgdea.table>
            </x-sgdea.card>
        </div>

        <div class="grid" style="align-content:start">
            <x-sgdea.card title="Radicados relacionados">
                <p class="small muted">Vínculo padre / hijo para respuestas a peticiones.</p>
                <dl class="dl" style="grid-template-columns:90px 1fr">
                    <dt>Radicado padre</dt><dd class="mono">{{ $radicacion['padre'] ?? '—' }}</dd>
                    <dt>Radicados hijos</dt><dd class="mono">{{ count($hijos) ? collect($hijos)->pluck('numero_radicado')->implode(', ') : '—' }}</dd>
                </dl>
            </x-sgdea.card>
            <x-sgdea.alert type="info" title="Registro inalterable">El número de radicado y la fecha y hora no se editan después de radicar.</x-sgdea.alert>
        </div>
    </div>
    <script type="application/json" id="rad-data">{!! $json !!}</script>
@endsection

@push('modals')
    @include('sgdea.radicaciones.partials.comprobante')
@endpush
@push('scripts')
    <script src="{{ asset('sgdea/js/radicaciones.js') }}"></script>
@endpush
