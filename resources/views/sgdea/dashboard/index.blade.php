{{--
  Panel principal. Variables que recibirá del futuro controlador (ver FRONTEND_BACKEND_CONTRACT.md):
  $indicadores, $radicacionesPorTipo, $semaforo, $alertas, $actividad, $esDemo.
  Mientras no existan, se usan datos ficticios de resources/sgdea/demo/dashboard.php.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Panel principal')
@section('subtitle', 'Visión general del SGDEA')
@section('module', 'dashboard')

@php
    $demo = require resource_path('sgdea/demo/dashboard.php');
    $indicadores = $indicadores ?? $demo['indicadores'];
    $radicacionesPorTipo = $radicacionesPorTipo ?? $demo['radicaciones_por_tipo'];
    $semaforo = $semaforo ?? $demo['semaforo'];
    $alertas = $alertas ?? $demo['alertas'];
    $actividad = $actividad ?? $demo['actividad'];
    $esDemo = $esDemo ?? true;
    $maxRad = max(1, collect($radicacionesPorTipo)->max('total'));
@endphp

@section('content')
    <div class="grid grid-stats mb-2">
        @foreach ($indicadores as $i)
            <x-sgdea.stat-card :label="$i['etiqueta']" :value="$i['valor']" :icon="$i['icono']" :tone="$i['tono']" :note="$esDemo ? 'DEMOSTRACIÓN' : null" />
        @endforeach
    </div>

    <div class="grid grid-main mb-2">
        <x-sgdea.card title="Actividad reciente" :flush="true">
            <x-slot:actions>@if ($esDemo)<x-sgdea.badge status="demo" :dot="false" />@endif</x-slot:actions>
            <x-sgdea.table id="tbl-actividad" :searchable="false" :cols="5">
                <x-slot:head><tr><th>Fecha y hora</th><th>Usuario</th><th>Acción</th><th>Recurso</th><th>Identificador</th></tr></x-slot:head>
                @foreach ($actividad as $a)
                    <tr>
                        <td class="nowrap">{{ $a['fecha'] }}</td><td>{{ $a['usuario'] }}</td>
                        <td><x-sgdea.badge :tone="$a['tono']" :label="$a['accion']" /></td>
                        <td class="mono small">{{ $a['recurso'] }}</td><td class="mono small">{{ $a['id'] }}</td>
                    </tr>
                @endforeach
            </x-sgdea.table>
        </x-sgdea.card>

        <x-sgdea.card title="Radicaciones por tipo">
            <x-slot:actions>@if ($esDemo)<x-sgdea.badge status="demo" :dot="false" />@endif</x-slot:actions>
            @foreach ($radicacionesPorTipo as $r)
                <div class="bar-row">
                    <div class="bar-label"><span>{{ $r['tipo'] }}</span><strong>{{ $r['total'] }}</strong></div>
                    <div class="bar"><span style="width: {{ round($r['total'] / $maxRad * 100) }}%"></span></div>
                </div>
            @endforeach
        </x-sgdea.card>
    </div>

    <div class="grid grid-2">
        <x-sgdea.card title="Semáforo de retención documental">
            <x-slot:actions>@if ($esDemo)<x-sgdea.badge status="demo" :dot="false" />@endif</x-slot:actions>
            <div class="semaforo">
                @foreach ($semaforo as $s)
                    <div class="semaforo-item {{ $s['clase'] }}"><b>{{ $s['total'] }}</b><span class="small muted">{{ $s['etiqueta'] }}</span></div>
                @endforeach
            </div>
            <p class="small muted mt-1" style="margin-bottom:0">Representación visual. Los cálculos de retención los realizará el backend con la TRD aprobada.</p>
        </x-sgdea.card>

        <x-sgdea.card title="Alertas documentales">
            <x-slot:actions>@if ($esDemo)<x-sgdea.badge status="demo" :dot="false" />@endif</x-slot:actions>
            <ul class="list-plain">
                @foreach ($alertas as $al)
                    <li><x-sgdea.badge :status="$al['estado']" /><div>{{ $al['texto'] }}<div class="small muted">{{ $al['detalle'] }}</div></div></li>
                @endforeach
            </ul>
            <div class="mt-1">
                <x-sgdea.button variant="secondary" size="sm" icon="eye" data-modal-open="modal-demo-alertas">Ver detalle (demostración)</x-sgdea.button>
            </div>
        </x-sgdea.card>
    </div>
@endsection

@push('modals')
    <x-sgdea.modal id="modal-demo-alertas" title="Detalle de alertas (demostración)" size="sm">
        <p>Aquí se mostrará el listado completo de alertas del módulo de Transferencias, alertas y disposición final.</p>
        <x-sgdea.alert type="warning">Los estados son solo una representación visual.</x-sgdea.alert>
        <x-slot:footer>
            <x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button>
            <x-sgdea.button data-demo-toast="Demostración: la pantalla de alertas se entrega en la Etapa 6." data-toast-type="info">Ir a alertas</x-sgdea.button>
        </x-slot:footer>
    </x-sgdea.modal>
@endpush
