{{--
  Módulo 4 · Documentos digitales — Consulta.
  Variables del futuro controlador: $documentos, $esDemo. Tabla relacionada: documentos_digitales.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Documentos digitales')
@section('subtitle', 'Digitalización, metadatos e integridad documental')
@section('module', 'documentos')

@php
    $documentos = $documentos ?? require resource_path('sgdea/demo/documentos.php');
    $esDemo = $esDemo ?? true;
    $tam = fn ($b) => $b >= 1048576 ? number_format($b / 1048576, 2, ',', '.') . ' MB' : number_format($b / 1024, 0, ',', '.') . ' KB';
    $validacion = ['validado' => ['success', 'Validado'], 'observaciones' => ['warning', 'Con observaciones']];
@endphp

@section('content')
    <x-sgdea.page-header title="Consulta de documentos" subtitle="Cada documento debe vincularse a un tipo documental de una serie y, cuando corresponda, a una radicación.">
        <x-slot:actions><x-sgdea.button icon="upload" route="sgdea.documentos.create">Registrar documento</x-sgdea.button></x-slot:actions>
    </x-sgdea.page-header>

    @if ($esDemo)
        <x-sgdea.alert type="warning" title="Datos de demostración">Los archivos y las huellas SHA-256 son ficticios. Los tipos documentales y series provienen del CCD oficial.</x-sgdea.alert>
    @endif

    <x-sgdea.card :flush="true">
        <div class="filters" id="doc-filtros">
            <x-sgdea.field label="Nivel de acceso" name="f_acceso" type="select" id="df-acceso" placeholder="Todos" :options="['publica' => 'Pública', 'clasificada' => 'Clasificada', 'reservada' => 'Reservada']" />
            <x-sgdea.field label="Estado de validación" name="f_valid" type="select" id="df-valid" placeholder="Todos" :options="['validado' => 'Validado', 'observaciones' => 'Con observaciones']" />
            <x-sgdea.field label="Producido desde" name="f_desde" type="date" id="df-desde" />
            <x-sgdea.field label="Producido hasta" name="f_hasta" type="date" id="df-hasta" />
        </div>
        <x-sgdea.table id="tbl-doc" :cols="8" placeholder="Buscar por título, tipo documental o archivo…">
            <x-slot:head>
                <tr><th>Título</th><th>Tipo documental</th><th>Oficina / serie</th><th>Producción</th><th>Acceso</th><th>Archivo</th><th>Validación</th><th class="text-right">Detalle</th></tr>
            </x-slot:head>
            @foreach ($documentos as $d)
                <tr data-acceso="{{ $d['nivel_acceso'] }}" data-valid="{{ $d['estado_validacion'] }}" data-fecha="{{ $d['fecha_produccion'] }}">
                    <td><strong>{{ $d['titulo'] }}</strong>@if ($d['radicado'])<div class="small muted mono">{{ $d['radicado'] }}</div>@endif</td>
                    <td>{{ $d['tipo_documental'] }}</td>
                    <td class="small">{{ $d['oficina'] }}<div class="muted">{{ $d['serie'] }}</div></td>
                    <td class="nowrap">{{ $d['fecha_produccion'] }}</td>
                    <td><x-sgdea.badge :status="$d['nivel_acceso']" /></td>
                    <td class="small"><span class="mono">{{ $d['nombre_original_archivo'] }}</span><div class="muted">{{ $tam($d['tamano_bytes']) }}</div></td>
                    <td><x-sgdea.badge :tone="$validacion[$d['estado_validacion']][0]" :label="$validacion[$d['estado_validacion']][1]" /></td>
                    <td class="text-right"><x-sgdea.button variant="ghost" size="sm" icon="eye" route="sgdea.documentos.show" :params="['id' => $d['id']]">Ver</x-sgdea.button></td>
                </tr>
            @endforeach
        </x-sgdea.table>
    </x-sgdea.card>
@endsection

@push('scripts')
    <script src="{{ asset('sgdea/js/documentos.js') }}"></script>
@endpush
