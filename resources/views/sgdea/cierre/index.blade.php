{{--
  Módulo 6 · Cierre de carpetas y expedientes — Consulta.
  Variables del futuro controlador: $carpetas, $esDemo. Tabla: carpetas_archivo (estado, fecha_cierre, indice_sellado).
--}}
@extends('sgdea.layouts.app')
@section('title', 'Cierre de carpetas y expedientes')
@section('subtitle', 'Carpetas abiertas, estado de cierre e índice definitivo')
@section('module', 'cierre')

@php
    $esDemo = $esDemo ?? true;
    $carpetas = $carpetas ?? (require resource_path('sgdea/presenters/carpetas.php'))(require resource_path('sgdea/demo/carpetas.php'), require resource_path('sgdea/demo/documentos.php'));
    $col = collect($carpetas);
@endphp

@section('content')
    @if ($esDemo)
        <x-sgdea.alert type="warning" title="Fecha estimada de transferencia">
            Se muestra “No calculable” porque la TRD entregada no tiene años de retención parametrizados. El cálculo lo hará el backend con la TRD vigente.
        </x-sgdea.alert>
    @endif
    <x-sgdea.card :flush="true">
        <div class="tabs" style="padding:0 1rem;margin:0" role="tablist">
            <button type="button" class="tab-btn is-active" data-cierre-filter="Abierta">Abiertas ({{ $col->where('estado', 'Abierta')->count() }})</button>
            <button type="button" class="tab-btn" data-cierre-filter="Cerrada">Cerradas ({{ $col->where('estado', 'Cerrada')->count() }})</button>
            <button type="button" class="tab-btn" data-cierre-filter="">Todas ({{ $col->count() }})</button>
        </div>
        <x-sgdea.table id="tbl-cierre" :cols="8" placeholder="Buscar carpeta…">
            <x-slot:head>
                <tr><th>Carpeta</th><th>Oficina / serie</th><th>Docs / folios</th><th>Apertura</th><th>Estado</th><th>Fecha de cierre</th><th>Transferencia estimada</th><th class="text-right">Acciones</th></tr>
            </x-slot:head>
            @foreach ($carpetas as $c)
                <tr data-estado="{{ $c['estado'] }}">
                    <td><strong class="mono">{{ $c['numero_asignado'] }}</strong><div class="small">{{ $c['nombre_carpeta'] }}</div></td>
                    <td class="small">{{ $c['oficina'] }}<div class="muted">{{ $c['serie'] }}</div></td>
                    <td class="nowrap">{{ $c['total_documentos'] }} / {{ $c['cantidad_folios'] ?? '—' }}</td>
                    <td class="nowrap">{{ $c['fecha_apertura'] }}</td>
                    <td><x-sgdea.badge :status="$c['estado'] === 'Cerrada' ? 'cerrada' : 'abierta'" /></td>
                    <td class="nowrap">{{ $c['fecha_cierre'] ?? '—' }}</td>
                    <td class="small muted">{{ $c['transferencia_estimada'] ?? 'No calculable (TRD sin retención)' }}</td>
                    <td class="text-right nowrap">
                        <x-sgdea.button variant="ghost" size="sm" icon="eye" route="sgdea.cierre.show" :params="['id' => $c['id']]">{{ $c['estado'] === 'Cerrada' ? 'Índice definitivo' : 'Ver' }}</x-sgdea.button>
                        @if ($c['estado'] === 'Abierta')
                            <x-sgdea.button variant="secondary" size="sm" icon="lock" data-cierre-abrir="{{ $c['numero_asignado'] }} · {{ $c['nombre_carpeta'] }}">Cerrar</x-sgdea.button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-sgdea.table>
    </x-sgdea.card>
@endsection

@push('modals')@include('sgdea.cierre.partials.modal-cierre')@endpush
@push('scripts')<script src="{{ asset('sgdea/js/carpetas.js') }}"></script>@endpush
