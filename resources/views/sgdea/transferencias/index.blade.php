{{--
  Módulo 10 · Transferencias, alertas y disposición final (SOLO VISUAL; no calcula retención ni ejecuta procesos).
  Variables del futuro controlador: $alertas, $transferencias, $solicitudes, $esDemo.
  Tablas relacionadas: transferencias_documentales, items_transferencia_documental, solicitudes_disposicion, aprobaciones_disposicion, carpetas_archivo, retencion_documental.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Transferencias y disposición final')
@section('subtitle', 'Alertas de retención, transferencias primarias, actas y disposición documental')
@section('module', 'transferencias')

@php
    $demo = require resource_path('sgdea/demo/transferencias.php');
    $alertas = $alertas ?? $demo['alertas'];
    $transferencias = $transferencias ?? $demo['transferencias'];
    $solicitudes = $solicitudes ?? $demo['solicitudes'];
    $esDemo = $esDemo ?? true;
    $ta = collect($transferencias);
    $carpetaOpc = collect($alertas)->pluck('carpeta')->unique()->mapWithKeys(fn ($c) => [$c => $c])->all();
    $tiposDisp = ['Conservación total' => 'CT — Conservación total', 'Eliminación' => 'E — Eliminación', 'Selección' => 'S — Selección', 'Reproducción por medio' => 'D — Reproducción por medio'];
    $semNombre = ['verde' => 'Vigente', 'amarillo' => 'Próximo a cumplir retención', 'rojo' => 'Tiempo cumplido'];
    $json = fn ($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

@section('content')
    @if ($esDemo)
        <x-sgdea.alert type="warning" title="Estados de demostración">
            Los semáforos y estados son solo una representación visual. La TRD entregada no tiene retención parametrizada, por eso no se calcula ninguna fecha límite ni se ejecuta ninguna transferencia o eliminación.
        </x-sgdea.alert>
    @endif

    <div data-tabs>
        <div class="tabs" role="tablist">
            <button type="button" class="tab-btn is-active" data-tab-target="#trf-tab-panel">Panel y alertas</button>
            <button type="button" class="tab-btn" data-tab-target="#trf-tab-trf">Transferencias ({{ $ta->count() }})</button>
            <button type="button" class="tab-btn" data-tab-target="#trf-tab-actas">Actas de transferencia</button>
            <button type="button" class="tab-btn" data-tab-target="#trf-tab-disp">Disposición final ({{ count($solicitudes) }})</button>
        </div>

        {{-- Panel y alertas --}}
        <div class="tab-panel is-active" id="trf-tab-panel">
            <div class="grid grid-stats mb-2">
                <x-sgdea.stat-card label="Transferidas" :value="$ta->where('estado', 'transferido')->count()" icon="truck" tone="success" />
                <x-sgdea.stat-card label="En revisión" :value="$ta->where('estado', 'revision')->count()" icon="clock" />
                <x-sgdea.stat-card label="Pendientes" :value="$ta->where('estado', 'pendiente')->count()" icon="inbox" tone="warning" />
                <x-sgdea.stat-card label="Rechazadas" :value="$ta->where('estado', 'rechazado')->count()" icon="alert-circle" tone="danger" />
            </div>
            <div class="semaforo mb-2">
                @foreach (['verde', 'amarillo', 'rojo'] as $s)
                    <div class="semaforo-item sem-{{ $s }}"><b>{{ collect($alertas)->where('semaforo', $s)->count() }}</b><span class="small muted">{{ $semNombre[$s] }}</span></div>
                @endforeach
            </div>
            <x-sgdea.card title="Carpetas con alerta de retención" :flush="true">
                <x-slot:actions>
                    <button type="button" class="btn btn-sm btn-secondary is-chip" data-sem-filter="">Todas</button>
                    <button type="button" class="btn btn-sm btn-outline" data-sem-filter="verde"><span class="sem-dot verde"></span>Vigente</button>
                    <button type="button" class="btn btn-sm btn-outline" data-sem-filter="amarillo"><span class="sem-dot amarillo"></span>Próximo</button>
                    <button type="button" class="btn btn-sm btn-outline" data-sem-filter="rojo"><span class="sem-dot rojo"></span>Vencido</button>
                </x-slot:actions>
                <x-sgdea.table id="tbl-alertas" :searchable="false" :cols="7">
                    <x-slot:head><tr><th>Semáforo</th><th>Carpeta</th><th>Oficina productora</th><th>Ubicación</th><th>Fecha de cierre</th><th>Fecha límite (TRD)</th><th>Estado</th></tr></x-slot:head>
                    @foreach ($alertas as $a)
                        <tr data-sem="{{ $a['semaforo'] }}">
                            <td class="nowrap"><span class="sem-dot {{ $a['semaforo'] }}"></span><span class="small">{{ $semNombre[$a['semaforo']] }}</span></td>
                            <td><strong>{{ $a['carpeta'] }}</strong><div class="small muted">{{ $a['origen'] }}</div></td><td class="small">{{ $a['oficina'] }}</td><td class="small">{{ $a['ubicacion'] }}</td>
                            <td class="nowrap">{{ $a['fecha_cierre'] }}</td><td class="small muted">No calculable (TRD sin retención)</td><td><x-sgdea.badge :status="$a['estado']" /></td>
                        </tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>

        {{-- Transferencias --}}
        <div class="tab-panel" id="trf-tab-trf">
            <x-sgdea.card :flush="true">
                <x-sgdea.table id="tbl-trf" :cols="7" placeholder="Buscar transferencia…">
                    <x-slot:toolbar><x-sgdea.button size="sm" icon="plus" data-modal-open="modal-trf-form">Nueva transferencia</x-sgdea.button></x-slot:toolbar>
                    <x-slot:head><tr><th>Código</th><th>Tipo</th><th>Origen → destino</th><th>Fecha</th><th>Carpetas</th><th>Estado</th><th class="text-right">Acciones</th></tr></x-slot:head>
                    @foreach ($transferencias as $i => $t)
                        <tr><td class="mono"><strong>{{ $t['codigo_transferencia'] }}</strong></td><td class="small">{{ $t['tipo_transferencia'] }}</td><td class="small">{{ $t['fase_origen'] }} → {{ $t['fase_destino'] }}</td>
                            <td class="nowrap">{{ $t['fecha_transferencia'] ?? '—' }}</td><td>{{ count($t['items']) }}</td><td><x-sgdea.badge :status="$t['estado']" /></td>
                            <td class="text-right"><x-sgdea.button variant="ghost" size="sm" icon="eye" data-trf-ver="{{ $i }}">Ver</x-sgdea.button></td></tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>

        {{-- Actas --}}
        <div class="tab-panel" id="trf-tab-actas">
            <x-sgdea.alert type="info">El acta y el FUID de transferencia se generan al aprobar la transferencia (pendiente del backend). El formato del acta debe definirse con la empresa.</x-sgdea.alert>
            <x-sgdea.card :flush="true">
                <x-sgdea.table id="tbl-actas" :searchable="false" :cols="6" empty-text="Aún no hay actas.">
                    <x-slot:head><tr><th>Acta</th><th>Transferencia</th><th>Fecha</th><th>Carpetas</th><th>Aprobada por</th><th class="text-right">Acciones</th></tr></x-slot:head>
                    @foreach ($transferencias as $i => $t)
                        @if ($t['numero_acta'])
                            <tr><td class="mono"><strong>{{ $t['numero_acta'] }}</strong></td><td class="mono">{{ $t['codigo_transferencia'] }}</td><td class="nowrap">{{ $t['fecha_transferencia'] }}</td><td>{{ count($t['items']) }}</td><td>{{ $t['aprobado_por'] ?? '—' }}</td>
                                <td class="text-right nowrap"><x-sgdea.button variant="ghost" size="sm" icon="eye" data-acta-ver="{{ $i }}">Ver acta</x-sgdea.button>
                                    <x-sgdea.button variant="ghost" size="sm" icon="download" data-demo-toast="Demostración: la descarga en bloque del paquete de transferencia está pendiente del backend." data-toast-type="warning">Paquete</x-sgdea.button></td></tr>
                        @endif
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>

        {{-- Disposición final --}}
        <div class="tab-panel" id="trf-tab-disp">
            <x-sgdea.alert type="info">La eliminación exige el número y el acta del Comité de MIPG, y la aprobación con doble visto bueno. El registro de la baja se conserva como histórico.</x-sgdea.alert>
            <x-sgdea.card :flush="true">
                <x-sgdea.table id="tbl-disp" :cols="8" placeholder="Buscar solicitud…">
                    <x-slot:toolbar><x-sgdea.button size="sm" icon="plus" data-modal-open="modal-disp-form">Nueva solicitud</x-sgdea.button></x-slot:toolbar>
                    <x-slot:head><tr><th>Carpeta</th><th>Disposición</th><th>Acta (MIPG)</th><th>Solicitada por</th><th>Fecha</th><th>Estado</th><th>Disposición aplicada</th><th class="text-right">Acciones</th></tr></x-slot:head>
                    @foreach ($solicitudes as $i => $s)
                        <tr><td><strong>{{ $s['carpeta'] }}</strong></td><td>{{ $s['tipo_disposicion'] }}</td><td class="mono small">{{ $s['numero_acta'] ?? '—' }}</td><td>{{ $s['solicitado_por'] }}</td>
                            <td class="nowrap">{{ $s['fecha_hora_solicitud'] }}</td><td><x-sgdea.badge :status="$s['estado']" /></td>
                            <td>@if (($s['disposicion_aplicada'] ?? null) === 'Eliminado')<x-sgdea.badge tone="dark" label="Eliminado (registro histórico)" />@else<span class="muted">—</span>@endif</td>
                            <td class="text-right"><x-sgdea.button variant="ghost" size="sm" icon="eye" data-sol-ver="{{ $i }}">Ver</x-sgdea.button></td></tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>
    </div>
    <script type="application/json" id="trf-data">{!! $json($transferencias) !!}</script>
    <script type="application/json" id="sol-data">{!! $json($solicitudes) !!}</script>
@endsection

@push('modals')
    <x-sgdea.modal id="modal-trf-detalle" title="Detalle de la transferencia" size="md">
        <dl class="dl" style="grid-template-columns:140px 1fr">
            <dt>Código</dt><dd class="mono" data-t="codigo_transferencia"></dd><dt>Tipo</dt><dd data-t="tipo_transferencia"></dd><dt>Origen → destino</dt><dd data-t="ruta"></dd>
            <dt>Fecha</dt><dd data-t="fecha_transferencia"></dd><dt>Estado</dt><dd data-t="estado_label"></dd><dt>Acta</dt><dd data-t="numero_acta"></dd>
            <dt>Creada por</dt><dd data-t="creado_por"></dd><dt>Aprobada por</dt><dd data-t="aprobado_por"></dd>
        </dl>
        <h4 class="small mt-2" style="margin-bottom:.3rem">Carpetas incluidas</h4><ul class="list-plain" id="trf-items"></ul>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button>
            <x-sgdea.button variant="secondary" icon="clipboard" data-demo-toast="Demostración: el FUID de transferencia se genera automáticamente en el backend." data-toast-type="warning">FUID de transferencia</x-sgdea.button>
            <x-sgdea.button icon="download" data-demo-toast="Demostración: la descarga del paquete de transferencia está pendiente del backend." data-toast-type="warning">Descargar paquete</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>

    <x-sgdea.modal id="modal-acta" title="Acta de transferencia" size="md">
        <x-sgdea.alert type="warning">Vista informativa: el formato oficial del acta está pendiente de definir con la empresa.</x-sgdea.alert>
        <div class="rotulo" style="max-width:none">
            <h4>ACTA DE TRANSFERENCIA DOCUMENTAL <span class="mono" data-ac="numero_acta"></span></h4>
            <p class="small" style="text-align:center;margin:0 0 .6rem">Empresas Varias de Caicedonia E.V.C. – E.S.P.</p>
            <dl class="dl" style="grid-template-columns:130px 1fr"><dt>Transferencia</dt><dd class="mono" data-ac="codigo_transferencia"></dd><dt>Fecha</dt><dd data-ac="fecha_transferencia"></dd><dt>Origen → destino</dt><dd data-ac="ruta"></dd></dl>
            <ul class="list-plain" id="acta-items"></ul>
            <div class="grid grid-2 mt-2"><div style="border-top:1px solid var(--text);padding-top:.3rem;text-align:center" class="small">Entrega</div><div style="border-top:1px solid var(--text);padding-top:.3rem;text-align:center" class="small">Recibe</div></div>
        </div>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>

    <x-sgdea.modal id="modal-trf-form" title="Nueva transferencia primaria" size="md">
        <form id="form-trf" method="POST" action="#" data-demo-form data-demo-message="Demostración: la transferencia no fue creada. El flujo se implementará en el backend." novalidate>
            @csrf
            <div class="form-grid">
                <x-sgdea.field label="Tipo de transferencia" name="tipo_transferencia" type="select" :required="true" :options="['Transferencia primaria' => 'Transferencia primaria']" />
                <x-sgdea.field label="Fase de origen" name="fase_origen" type="select" :required="true" :options="['Archivo de gestión' => 'Archivo de gestión']" />
                <x-sgdea.field label="Fase de destino" name="fase_destino" type="select" :required="true" :options="['Archivo central' => 'Archivo central']" />
            </div>
            <fieldset style="border:0;padding:0;margin:0 0 1rem"><legend class="small" style="font-weight:600;margin-bottom:.3rem">Carpetas a transferir <span class="req">*</span></legend>
                @foreach ($carpetaOpc as $c)<label class="check" style="margin-bottom:.3rem"><input type="checkbox" name="carpetas[]" value="{{ $c }}"> {{ $c }}</label>@endforeach
            </fieldset>
            <x-sgdea.field label="Notas" name="notas" type="textarea" />
        </form>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button><x-sgdea.button type="submit" form="form-trf" icon="check">Crear (demostración)</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>

    <x-sgdea.modal id="modal-sol-detalle" title="Solicitud de disposición final" size="md">
        <dl class="dl" style="grid-template-columns:140px 1fr">
            <dt>Carpeta</dt><dd data-s="carpeta"></dd><dt>Disposición</dt><dd data-s="tipo_disposicion"></dd><dt>Número de acta</dt><dd data-s="numero_acta"></dd>
            <dt>Referencia del acta</dt><dd data-s="referencia_acta"></dd><dt>Estado</dt><dd data-s="estado_label"></dd><dt>Disposición aplicada</dt><dd data-s="disposicion_aplicada"></dd><dt>Solicitada por</dt><dd data-s="solicitado_por"></dd><dt>Fecha</dt><dd data-s="fecha_hora_solicitud"></dd>
        </dl>
        <p class="small muted" id="sol-historico" hidden>Los binarios se eliminan, pero el registro se conserva como histórico de baja, con sus metadatos e índice.</p>
        <h4 class="small mt-2" style="margin-bottom:.3rem">Aprobaciones</h4><ul class="timeline" id="sol-aprobaciones"></ul>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>

    <x-sgdea.modal id="modal-disp-form" title="Nueva solicitud de disposición final" size="md">
        <form id="form-disp" method="POST" action="#" data-demo-form data-demo-message="Demostración: la solicitud no fue creada. El flujo de aprobación se implementará en el backend." novalidate>
            @csrf
            <x-sgdea.field label="Carpeta" name="carpeta_id" type="select" :required="true" :options="$carpetaOpc" />
            <x-sgdea.field label="Tipo de disposición" name="tipo_disposicion" type="select" id="disp-tipo" :required="true" :options="$tiposDisp" />
            <div id="disp-acta" hidden>
                <x-sgdea.alert type="warning">La eliminación exige el número y el acta del Comité de MIPG y doble visto bueno.</x-sgdea.alert>
                <x-sgdea.field label="Número de acta del Comité de MIPG" name="numero_acta" id="disp-num" />
                <x-sgdea.field label="Referencia del acta" name="referencia_acta" id="disp-ref" />
                <div class="field"><label for="disp-file">Acta (adjunto visual)</label><input type="file" id="disp-file" name="acta_archivo" data-file-preview="#disp-files"><ul class="file-list" id="disp-files"></ul></div>
            </div>
        </form>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button><x-sgdea.button type="submit" form="form-disp" icon="check">Solicitar (demostración)</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>
@endpush
@push('scripts')<script src="{{ asset('sgdea/js/transferencias.js') }}"></script>@endpush
