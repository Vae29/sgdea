{{--
  Módulo 5 · Carpetas y expedientes — Detalle.
  Variables del futuro controlador: $carpeta (con 'indice'), $documentosDisponibles (documentos sin carpeta de la misma serie).
  Tablas: carpetas_archivo, documentos_carpeta, documentos_digitales. En la demostración se toma según el parámetro de ruta {id}.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Detalle de carpeta')
@section('subtitle', 'Documentos, orden de incorporación, foliación e índice')
@section('module', 'carpetas')

@php
    $documentos = require resource_path('sgdea/demo/documentos.php');
    $todas = collect((require resource_path('sgdea/presenters/carpetas.php'))(require resource_path('sgdea/demo/carpetas.php'), $documentos));
    $carpeta = $carpeta ?? ($todas->firstWhere('id', (int) ($id ?? 3)) ?? $todas->first());
    $esDemo = $esDemo ?? true;
    $cerrada = $carpeta['estado'] === 'Cerrada';
    $disponibles = $documentosDisponibles ?? collect($documentos)->filter(fn ($d) => $d['carpeta'] === null && $d['serie'] === $carpeta['serie'])->values()->all();
    $siguienteFolio = collect($carpeta['indice'])->max('folio_final') + 1;
    $json = json_encode([$carpeta['rotulo']], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

@section('content')
    <x-sgdea.page-header :title="$carpeta['numero_asignado'] . ' · ' . $carpeta['nombre_carpeta']">
        <x-slot:actions>
            <x-sgdea.button variant="outline" icon="arrow-left" route="sgdea.carpetas.index">Volver al listado</x-sgdea.button>
            <x-sgdea.button variant="secondary" icon="file" data-carpeta-rotulo="0">Rótulo</x-sgdea.button>
            <x-sgdea.button variant="secondary" icon="download" data-demo-toast="Demostración: la descarga consolidada del expediente y su índice técnico estructurado está pendiente del backend." data-toast-type="warning">Descargar expediente</x-sgdea.button>
            <x-sgdea.button variant="secondary" icon="upload" data-modal-open="modal-incorporar" :disabled="$cerrada">Incorporar documento</x-sgdea.button>
            <x-sgdea.button icon="lock" route="sgdea.cierre.show" :params="['id' => $carpeta['id']]">{{ $cerrada ? 'Ver cierre' : 'Ir al cierre' }}</x-sgdea.button>
        </x-slot:actions>
    </x-sgdea.page-header>

    @if ($cerrada)
        <x-sgdea.alert type="success" title="Expediente de Archivo (Cerrado)">Esta carpeta es inalterable: no admite nuevos documentos, cambios de metadatos ni eliminaciones.</x-sgdea.alert>
    @elseif ($esDemo)
        <x-sgdea.alert type="warning">Registro de demostración: ningún dato proviene de la base de datos.</x-sgdea.alert>
    @endif
    @if ($carpeta['hibrida'])
        <x-sgdea.alert type="info" title="Carpeta híbrida">Combina una parte física (con rótulo{{ $carpeta['caja'] ? ' y caja ' . $carpeta['caja'] : '' }}) y una parte electrónica (documentos digitales indexados).</x-sgdea.alert>
    @endif

    <div data-tabs>
        <div class="tabs" role="tablist">
            <button type="button" class="tab-btn is-active" data-tab-target="#carp-tab-docs">Documentos y orden ({{ $carpeta['total_documentos'] }})</button>
            <button type="button" class="tab-btn" data-tab-target="#carp-tab-indice">Índice documental</button>
            <button type="button" class="tab-btn" data-tab-target="#carp-tab-info">Información de la carpeta</button>
        </div>

        <div class="tab-panel is-active" id="carp-tab-docs">
            <x-sgdea.card :flush="true">
                <x-sgdea.table id="tbl-carp-docs" :searchable="false" :cols="6" empty-text="Sin documentos.">
                    <x-slot:head><tr><th>Orden</th><th>Título</th><th>Tipo documental</th><th>Incorporado</th><th>Folios</th><th class="text-right">Detalle</th></tr></x-slot:head>
                    @foreach ($carpeta['indice'] as $r)
                        <tr><td><strong>{{ $r['posicion'] }}</strong></td><td>{{ $r['titulo'] }}</td><td>{{ $r['tipo_documental'] }}</td><td class="nowrap">{{ $r['fecha_incorporacion'] }}</td>
                            <td class="nowrap">{{ $r['folios'] }}</td>
                            <td class="text-right"><x-sgdea.button variant="ghost" size="sm" icon="eye" route="sgdea.documentos.show" :params="['id' => $r['documento_id']]">Ver</x-sgdea.button></td></tr>
                    @endforeach
                    @if (!count($carpeta['indice']))<tr><td colspan="6" class="muted">Esta carpeta no tiene documentos digitales. @if ($carpeta['soporte'] === 'Físico')Es una carpeta física; su contenido se inventaría en el FUID.@endif</td></tr>@endif
                </x-sgdea.table>
            </x-sgdea.card>
            <p class="small muted mt-1">El orden y la foliación consecutiva los asigna el sistema al incorporar cada documento.</p>
            <x-sgdea.card title="Visor de documentos" class="mt-2"><div class="viewer">Visor web integrado (lector PDF) — pendiente de integración con el backend. Use «Ver» en la tabla para abrir el documento.</div></x-sgdea.card>
        </div>

        <div class="tab-panel" id="carp-tab-indice"><x-sgdea.card>@include('sgdea.carpetas.partials.indice', ['carpeta' => $carpeta])</x-sgdea.card></div>

        <div class="tab-panel" id="carp-tab-info">
            <x-sgdea.card>
                <dl class="dl">
                    <dt>Estado</dt><dd><x-sgdea.badge :status="$cerrada ? 'cerrada' : 'abierta'" /></dd>
                    <dt>Unidad administrativa</dt><dd>{{ $carpeta['unidad'] }}</dd>
                    <dt>Oficina productora</dt><dd>{{ $carpeta['oficina'] }}</dd>
                    <dt>Serie documental</dt><dd>{{ $carpeta['serie'] }}</dd>
                    <dt>Subserie documental</dt><dd>{{ $carpeta['subserie'] ?? 'No aplica' }}</dd>
                    <dt>Soporte</dt><dd>{{ $carpeta['soporte'] }}</dd>
                    <dt>Nivel de acceso</dt><dd><x-sgdea.badge :status="$carpeta['nivel_acceso']" /></dd>
                    <dt>Fase del archivo</dt><dd>{{ $carpeta['fase_archivo'] }}</dd>
                    <dt>Caja</dt><dd>{{ $carpeta['caja'] ?? 'Sin caja asignada' }}</dd>
                    <dt>Fecha de apertura</dt><dd>{{ $carpeta['fecha_apertura'] }}</dd>
                    <dt>Fechas extremas</dt><dd>{{ $carpeta['fecha_inicial'] ?? '—' }} → {{ $carpeta['fecha_final'] ?? '—' }}</dd>
                    <dt>Folios</dt><dd>{{ $carpeta['cantidad_folios'] ?? '—' }}</dd>
                    <dt>Retención heredada (TRD)</dt><dd><span class="muted">Sin parametrizar</span></dd>
                    <dt>Creada por</dt><dd>{{ $carpeta['usuario_creador'] }}</dd>
                </dl>
            </x-sgdea.card>
        </div>
    </div>
    <script type="application/json" id="carpeta-data">{!! $json !!}</script>
@endsection

@push('modals')
    @include('sgdea.carpetas.partials.rotulo')
    <x-sgdea.modal id="modal-incorporar" title="Incorporar documento a la carpeta" size="md">
        <form id="form-incorporar" method="POST" action="#" data-demo-form data-demo-message="Demostración: el documento no fue incorporado. El orden y la foliación los asignará el backend." novalidate data-next-folio="{{ $siguienteFolio }}">
            @csrf
            <div class="field">
                <label for="inc-doc">Documento digital disponible <span class="req">*</span></label>
                <select id="inc-doc" name="documento_id" required>
                    <option value="">Seleccione…</option>
                    @foreach ($disponibles as $d)<option value="{{ $d['id'] }}" data-folios="{{ $d['folios'] ?? 0 }}">{{ $d['titulo'] }} ({{ $d['folios'] ?? 0 }} folios)</option>@endforeach
                </select>
                <div class="hint">Solo se listan documentos de la misma serie que todavía no están en una carpeta.</div>
            </div>
            @if (!count($disponibles))<x-sgdea.alert type="info">No hay documentos disponibles de esta serie.</x-sgdea.alert>@endif
            <dl class="dl" style="grid-template-columns:150px 1fr">
                <dt>Posición en el orden</dt><dd>{{ $carpeta['total_documentos'] + 1 }}</dd>
                <dt>Folios asignados (vista previa)</dt><dd id="inc-folios">—</dd>
            </dl>
        </form>
        <x-slot:footer>
            <x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button>
            <x-sgdea.button type="submit" form="form-incorporar" icon="check">Incorporar (demostración)</x-sgdea.button>
        </x-slot:footer>
    </x-sgdea.modal>
@endpush
@push('scripts')<script src="{{ asset('sgdea/js/carpetas.js') }}"></script>@endpush
