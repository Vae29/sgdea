{{--
  Módulo 4 · Documentos digitales — Detalle.
  Variable del futuro controlador: $documento. En la demostración se toma según el parámetro de ruta {id}.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Detalle del documento')
@section('subtitle', 'Metadatos, integridad y estado de validación')
@section('module', 'documentos')

@php
    $todos = collect(require resource_path('sgdea/demo/documentos.php'));
    $documento = $documento ?? ($todos->firstWhere('id', (int) ($id ?? 1)) ?? $todos->first());
    $esDemo = $esDemo ?? true;
    $tam = fn ($b) => $b >= 1048576 ? number_format($b / 1048576, 2, ',', '.') . ' MB' : number_format($b / 1024, 0, ',', '.') . ' KB';
    $validacion = ['validado' => ['success', 'Validado'], 'observaciones' => ['warning', 'Con observaciones']][$documento['estado_validacion']];
@endphp

@section('content')
    <x-sgdea.page-header :title="$documento['titulo']">
        <x-slot:actions>
            <x-sgdea.button variant="outline" icon="arrow-left" route="sgdea.documentos.index">Volver a la consulta</x-sgdea.button>
            <x-sgdea.button variant="secondary" icon="download" data-demo-toast="Demostración: la descarga se conectará con el almacenamiento privado del backend." data-toast-type="warning">Descargar</x-sgdea.button>
        </x-slot:actions>
    </x-sgdea.page-header>
    @if ($esDemo)<x-sgdea.alert type="warning">Registro de demostración: el archivo y el hash no existen realmente.</x-sgdea.alert>@endif

    <div class="grid grid-main">
        <div class="grid">
            <x-sgdea.card title="Vista del documento"><div class="viewer">Visor del documento (pendiente de integración con el backend)</div></x-sgdea.card>

            <x-sgdea.card title="Metadatos documentales">
                <dl class="dl">
                    <dt>Tipo documental</dt><dd>{{ $documento['tipo_documental'] }}</dd>
                    <dt>Serie</dt><dd>{{ $documento['serie'] }}</dd>
                    <dt>Subserie</dt><dd>{{ $documento['subserie'] ?? 'No aplica' }}</dd>
                    <dt>Oficina productora</dt><dd>{{ $documento['oficina'] }}</dd>
                    <dt>Fecha de producción</dt><dd>{{ $documento['fecha_produccion'] }}</dd>
                    <dt>Folios / páginas</dt><dd>{{ $documento['folios'] ?? '—' }} / {{ $documento['paginas'] ?? '—' }}</dd>
                    <dt>Soporte de origen</dt><dd>{{ $documento['soporte_origen'] }}</dd>
                    <dt>Nivel de acceso</dt><dd><x-sgdea.badge :status="$documento['nivel_acceso']" /></dd>
                    <dt>Radicación asociada</dt><dd class="mono">{{ $documento['radicado'] ?? '—' }}</dd>
                    <dt>Expediente / carpeta</dt><dd>{{ $documento['carpeta'] ?? 'Aún no incorporado a una carpeta' }}</dd>
                </dl>
            </x-sgdea.card>
        </div>

        <div class="grid" style="align-content:start">
            <x-sgdea.card title="Estado de validación">
                <x-slot:actions><x-sgdea.badge :tone="$validacion[0]" :label="$validacion[1]" /></x-slot:actions>
                <ul class="check-list">
                    @foreach ($documento['validacion'] as $v)
                        <li><x-sgdea.icon :name="$v['ok'] ? 'check-circle' : 'alert-circle'" class="icon {{ $v['ok'] ? 'ok' : 'bad' }}" />{{ $v['etiqueta'] }}</li>
                    @endforeach
                </ul>
            </x-sgdea.card>

            <x-sgdea.card title="Integridad (SHA-256)">
                <div class="hash" id="hash-doc">{{ $documento['hash_sha256'] }}</div>
                <div class="flex mt-1">
                    <x-sgdea.button variant="outline" size="sm" icon="check" data-copy-hash="#hash-doc">Copiar huella</x-sgdea.button>
                    <x-sgdea.button variant="secondary" size="sm" icon="shield" data-demo-toast="Demostración: la verificación de integridad la hará el backend recalculando el hash del archivo almacenado." data-toast-type="warning">Verificar integridad</x-sgdea.button>
                </div>
            </x-sgdea.card>

            <x-sgdea.card title="Información del archivo">
                <dl class="dl" style="grid-template-columns:110px 1fr">
                    <dt>Nombre original</dt><dd class="mono small">{{ $documento['nombre_original_archivo'] }}</dd>
                    <dt>Tipo MIME</dt><dd>{{ $documento['tipo_mime'] }}</dd>
                    <dt>Tamaño</dt><dd>{{ $tam($documento['tamano_bytes']) }}</dd>
                    <dt>Almacenamiento</dt><dd>Disco privado del servidor</dd>
                </dl>
            </x-sgdea.card>

            <x-sgdea.card title="Contexto de la carga">
                <dl class="dl" style="grid-template-columns:110px 1fr">
                    <dt>Cargado por</dt><dd>{{ $documento['subido_por'] }}</dd>
                    <dt>Dirección IP</dt><dd>{{ $documento['ip'] }}</dd>
                    <dt>Fecha y hora</dt><dd>{{ $documento['hora_carga'] }}</dd>
                </dl>
            </x-sgdea.card>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('sgdea/js/documentos.js') }}"></script>
@endpush
