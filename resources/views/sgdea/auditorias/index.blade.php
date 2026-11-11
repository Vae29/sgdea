{{--
  Módulo 8 · Auditorías (bitácora de solo lectura; sin registros reales).
  Variables del futuro controlador: $auditorias, $esDemo. Tabla relacionada: auditorias (+ usuarios).
  La bitácora es inmutable: no existen acciones de edición ni de borrado.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Auditorías')
@section('subtitle', 'Trazabilidad y cadena de custodia')
@section('module', 'auditorias')

@php
    $auditorias = $auditorias ?? require resource_path('sgdea/demo/auditorias.php');
    $esDemo = $esDemo ?? true;
    $col = collect($auditorias);
    $acciones = ['creacion' => ['Creación', 'info'], 'consulta' => ['Consulta', 'neutral'], 'modificacion' => ['Modificación', 'info'], 'cierre' => ['Cierre de carpeta', 'dark'],
        'transferencia' => ['Transferencia', 'dark'], 'intento_fallido' => ['Intento fallido', 'warning'], 'acceso_denegado' => ['Acceso denegado', 'danger']];
    $usuarios = $col->pluck('usuario')->map(fn ($u) => $u ?? 'Sin sesión')->unique()->sort()->values();
    $tablas = $col->pluck('tabla_afectada')->unique()->sort()->values();
    $json = json_encode($col->map(fn ($a) => $a + ['accion_label' => $acciones[$a['accion']][0]])->values()->all(), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_PRETTY_PRINT);
@endphp

@section('content')
    <x-sgdea.page-header>
        <x-slot:actions>
            <x-sgdea.button variant="outline" icon="filter" data-toggle-target="#aud-filtros">Filtros</x-sgdea.button>
            <x-sgdea.button icon="download" data-demo-toast="Demostración: la exportación a CSV para auditorías externas está pendiente del backend." data-toast-type="warning">Exportar CSV</x-sgdea.button>
        </x-slot:actions>
    </x-sgdea.page-header>
    <x-sgdea.alert type="info" title="Bitácora de solo lectura">Los registros de auditoría no se pueden editar ni eliminar. @if ($esDemo)<strong>Los eventos mostrados son de demostración.</strong>@endif</x-sgdea.alert>

    <div class="grid grid-stats mb-2">
        <x-sgdea.stat-card label="Eventos registrados" :value="$col->count()" icon="list" />
        <x-sgdea.stat-card label="Intentos fallidos de acceso" :value="$col->where('accion', 'intento_fallido')->count()" icon="alert-triangle" tone="warning" />
        <x-sgdea.stat-card label="Accesos denegados" :value="$col->where('accion', 'acceso_denegado')->count()" icon="lock" tone="danger" />
    </div>

    <x-sgdea.card :flush="true">
        <div class="filters" id="aud-filtros">
            <x-sgdea.field label="Usuario" name="f_usuario" type="select" id="af-usuario" placeholder="Todos" :options="$usuarios->combine($usuarios)->all()" />
            <x-sgdea.field label="Tipo de evento" name="f_accion" type="select" id="af-accion" placeholder="Todos" :options="collect($acciones)->map(fn ($a) => $a[0])->all()" />
            <x-sgdea.field label="Tipo de recurso" name="f_tabla" type="select" id="af-tabla" placeholder="Todos" :options="$tablas->combine($tablas)->all()" />
            <x-sgdea.field label="N.º de radicado o expediente" name="f_ref" id="af-ref" placeholder="Ej. DEMO-002-2026-E" />
            <x-sgdea.field label="Desde" name="f_desde" type="date" id="af-desde" />
            <x-sgdea.field label="Hasta" name="f_hasta" type="date" id="af-hasta" />
            <div class="field" style="align-self:end"><x-sgdea.button variant="outline" size="sm" data-aud-limpiar>Limpiar filtros</x-sgdea.button></div>
        </div>
        <x-sgdea.table id="tbl-aud" :cols="8" placeholder="Buscar por recurso, identificador o IP…">
            <x-slot:head><tr><th>Fecha y hora</th><th>Usuario</th><th>Acción</th><th>Tipo de recurso</th><th>Identificador</th><th>Radicado / expediente</th><th>Dirección IP</th><th class="text-right">Detalle</th></tr></x-slot:head>
            @foreach ($auditorias as $i => $a)
                <tr class="{{ $a['accion'] === 'acceso_denegado' ? 'row-danger' : ($a['accion'] === 'intento_fallido' ? 'row-warn' : '') }}"
                    data-usuario="{{ $a['usuario'] ?? 'Sin sesión' }}" data-accion="{{ $a['accion'] }}" data-tabla="{{ $a['tabla_afectada'] }}" data-ref="{{ $a['referencia'] ?? '' }}" data-fecha="{{ substr($a['fecha_hora'], 0, 10) }}">
                    <td class="nowrap">{{ $a['fecha_hora'] }}</td><td>{{ $a['usuario'] ?? '— (sin sesión)' }}</td>
                    <td><x-sgdea.badge :tone="$acciones[$a['accion']][1]" :label="$acciones[$a['accion']][0]" /></td>
                    <td class="mono small">{{ $a['tabla_afectada'] }}</td><td class="mono small">{{ $a['id_afectado'] ?? '—' }}</td><td class="mono small">{{ $a['referencia'] ?? '—' }}</td><td class="mono small">{{ $a['ip'] }}</td>
                    <td class="text-right"><x-sgdea.button variant="ghost" size="sm" icon="eye" data-aud-ver="{{ $i }}">Ver</x-sgdea.button></td>
                </tr>
            @endforeach
        </x-sgdea.table>
    </x-sgdea.card>
    <script type="application/json" id="aud-data">{!! $json !!}</script>
@endsection

@push('modals')
    <x-sgdea.modal id="modal-aud-detalle" title="Detalle del evento de auditoría" size="lg">
        <div id="aud-alerta"></div>
        <dl class="dl" style="grid-template-columns:150px 1fr">
            <dt>Fecha y hora</dt><dd data-a="fecha_hora"></dd><dt>Usuario</dt><dd data-a="usuario"></dd><dt>Acción</dt><dd data-a="accion_label"></dd>
            <dt>Tipo de recurso</dt><dd class="mono" data-a="tabla_afectada"></dd><dt>Identificador</dt><dd class="mono" data-a="id_afectado"></dd><dt>Dirección IP</dt><dd class="mono" data-a="ip"></dd><dt>Radicado / expediente</dt><dd class="mono" data-a="referencia"></dd><dt>Agente de usuario</dt><dd class="small" data-a="user_agent"></dd>
        </dl>
        <div class="grid grid-2 mt-2">
            <div><h4 class="small mb-2" style="margin-bottom:.4rem">Información anterior</h4><pre class="json-box" id="aud-antes"></pre></div>
            <div><h4 class="small" style="margin-bottom:.4rem">Información posterior</h4><pre class="json-box" id="aud-despues"></pre></div>
        </div>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>
@endpush
@push('scripts')<script src="{{ asset('sgdea/js/auditorias.js') }}"></script>@endpush
