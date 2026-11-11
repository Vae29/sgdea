{{--
  Módulo 9 · Inventario documental FUID — Consulta.
  Variables del futuro controlador: $encabezado, $registros (unidades de conservación), $esDemo.
  Tablas relacionadas: cajas_almacenamiento, carpetas_archivo (+ oficinas_productoras, series_documentales, subseries_documentales).
  Los datos de resources/sgdea/demo/fuid.php provienen del FUID entregado por la empresa.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Inventario documental (FUID)')
@section('subtitle', 'Formato Único de Inventario Documental: cajas, carpetas, fechas extremas y folios')
@section('module', 'fuid')

@php
    $demo = require resource_path('sgdea/demo/fuid.php');
    $vm = (require resource_path('sgdea/presenters/fuid.php'))($encabezado ?? $demo['encabezado'], $registros ?? $demo['registros']);
    $enc = $vm['encabezado'];
    $reg = $vm['registros'];
    $esDemo = $esDemo ?? true;
    $f = fn ($d) => $d ? date('d-m-Y', strtotime($d)) : '—';
    $t = $vm['totales'];
    $json = fn ($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    $anios = collect($reg)->pluck('anio')->unique()->sort()->values();
    // Dependencias del filtro: TODAS las unidades y oficinas del CCD (el inventario es general, no solo de una dependencia).
    $ccdDemo = require resource_path('sgdea/demo/ccd.php');
    $unidadesCcd = $unidades ?? $ccdDemo['unidades'];
    $deps = []; $depUnidad = []; $depEncabezado = [];
    foreach ($unidadesCcd as $u) {
        $deps[$u['codigo']] = $u['codigo'] . ' · ' . $u['nombre'];
        $depUnidad[$u['codigo']] = $u['codigo'];
        $depEncabezado[$u['codigo']] = ['unidad_administrativa' => $u['codigo'] . ' · ' . $u['nombre'], 'oficina_productora' => '—', 'fuente' => 'CCD oficial'];
        foreach ($u['oficinas'] as $o) {
            $deps[$o['codigo']] = '↳ ' . $o['codigo'] . ' · ' . $o['nombre'];
            $depUnidad[$o['codigo']] = $u['codigo'];
            $depEncabezado[$o['codigo']] = ['unidad_administrativa' => $u['codigo'] . ' · ' . $u['nombre'], 'oficina_productora' => $o['codigo'] . ' · ' . $o['nombre'], 'fuente' => 'CCD oficial'];
        }
    }
    foreach (($demo['encabezados_dependencia'] ?? []) as $cod => $h) { $depEncabezado[$cod] = $h; }   // el FUID entregado conserva su encabezado literal
    $cajasOpc = collect($vm['cajas'])->mapWithKeys(fn ($c) => [$c['caja_key'] => $c['caja_key'] ? explode('|', $c['caja_key'])[0] . ' · Caja ' . $c['caja'] : ''])->all();
@endphp

@section('content')
    <x-sgdea.page-header>
        <x-slot:actions>
            <x-sgdea.button variant="outline" icon="filter" data-toggle-target="#fuid-filtros">Filtros</x-sgdea.button>
            <x-sgdea.button icon="download" data-modal-open="modal-fuid-export">Exportar</x-sgdea.button>
        </x-slot:actions>
    </x-sgdea.page-header>

    <x-sgdea.alert type="info" title="Inventario general por dependencia">
        El FUID puede generarse para cualquier unidad administrativa, oficina productora o para el Archivo Central: use los filtros de dependencia y fase.
        Los datos de ejemplo son 106 registros exactos del FUID entregado (dependencia 30, textos tal como están escritos) y 9 carpetas de Contabilidad (51) tomadas del rótulo de caja de ejemplo, marcadas como demostración.
        El encabezado del FUID entregado registra a la Planta de Beneficio Animal como <em>oficina productora</em> del Área Administrativa, mientras que el CCD la lista como unidad administrativa 30; se conserva cada fuente.
    </x-sgdea.alert>

    <x-sgdea.card title="Encabezado del formato" class="mb-2">
        <x-slot:actions><x-sgdea.badge tone="neutral" :label="'Versión ' . $enc['version']" :dot="false" /></x-slot:actions>
        <dl class="dl" style="grid-template-columns:170px 1fr 170px 1fr">
            <dt>Código</dt><dd>{{ $enc['codigo'] }}</dd><dt>Fecha</dt><dd>{{ $enc['fecha'] }}</dd>
            <dt>Entidad remitente</dt><dd>{{ $enc['entidad_remitente'] }}</dd><dt>Referente</dt><dd>{{ $enc['acuerdo'] }}</dd>
            <dt>Unidad administrativa</dt><dd id="fuid-h-unidad">Todas las dependencias</dd><dt>Oficina productora</dt><dd id="fuid-h-oficina">—</dd>
            <dt>Objeto</dt><dd>{{ $enc['objeto'] }}</dd><dt>Registro de entrada (N° T)</dt><dd>{{ $enc['numero_transferencia'] ?? 'Sin transferencia registrada' }}</dd>
        </dl>
    </x-sgdea.card>

    <div class="grid grid-stats mb-2">
        <x-sgdea.stat-card label="Unidades de conservación (carpetas)" :value="$t['carpetas']" icon="folder" data-total="carpetas" />
        <x-sgdea.stat-card label="Cajas" :value="$t['cajas']" icon="archive" data-total="cajas" />
        <x-sgdea.stat-card label="Folios" :value="$t['folios']" icon="file" data-total="folios" />
        <x-sgdea.stat-card label="Fechas extremas" :value="$f($t['fecha_inicial']) . ' → ' . $f($t['fecha_final'])" icon="calendar" :note="'Total general del inventario'" />
        <x-sgdea.stat-card label="Registros con observaciones" :value="$t['con_alertas']" icon="alert-triangle" tone="warning" note="Posibles errores de digitación" />
    </div>

    <div data-tabs>
        <div class="tabs" role="tablist">
            <button type="button" class="tab-btn is-active" id="tab-fuid-inv" data-tab-target="#fuid-tab-inv">Inventario</button>
            <button type="button" class="tab-btn" data-tab-target="#fuid-tab-cajas">Cajas y carpetas</button>
            <button type="button" class="tab-btn" data-tab-target="#fuid-tab-resumen">Resumen por serie y año</button>
        </div>

        <div class="tab-panel is-active" id="fuid-tab-inv">
            <x-sgdea.card :flush="true">
                <div class="filters" id="fuid-filtros">
                    <x-sgdea.field label="Dependencia" name="f_dep" type="select" id="ff-dep" placeholder="Todas" :options="$deps" />
                    <x-sgdea.field label="Año (fecha final)" name="f_anio" type="select" id="ff-anio" placeholder="Todos" :options="$anios->combine($anios)->all()" />
                    <x-sgdea.field label="Serie" name="f_serie" type="select" id="ff-serie" placeholder="Todas" :options="$vm['series']" />
                    <x-sgdea.field label="Subserie" name="f_subserie" type="select" id="ff-subserie" :options="[]"
                        :attr="['data-parent' => 'ff-serie', 'data-options-from' => 'opt-fuid-subseries', 'data-empty-text' => 'Sin subseries', 'data-placeholder' => 'Todas']" />
                    <x-sgdea.field label="Caja" name="f_caja" type="select" id="ff-caja" placeholder="Todas" :options="$cajasOpc" />
                    <x-sgdea.field label="Fase del archivo" name="f_fase" type="select" id="ff-fase" placeholder="Todas" :options="array_combine($vm['fases'], $vm['fases']) + ['sin' => 'No especificada en el FUID']" />
                    <div class="field" style="align-self:end"><x-sgdea.button variant="outline" size="sm" data-fuid-limpiar>Limpiar filtros</x-sgdea.button></div>
                </div>
                <div class="table-toolbar" style="border-top:0">
                    <div class="colchecks">
                        <strong>Columnas del formato:</strong>
                        <label><input type="checkbox" data-fuid-col="otro"> Otro (tipo y cantidad)</label>
                        <label><input type="checkbox" data-fuid-col="elec"> Electrónico (ubicación, documentos, tamaño)</label>
                        <label><input type="checkbox" data-fuid-col="notas" checked> Notas</label>
                    </div>
                    <span class="small muted" id="fuid-visibles"></span>
                </div>
                <x-sgdea.table id="tbl-fuid" class="" :cols="24" empty-text="Esta dependencia o fase aún no tiene registros de inventario en la demostración." placeholder="Buscar por carpeta, serie o subserie…">
                    <x-slot:head>
                        <tr>
                            <th rowspan="2">#</th><th rowspan="2">Número orden</th><th rowspan="2">Código</th><th rowspan="2">Serie</th><th rowspan="2">Subserie</th>
                            <th rowspan="2">Nombre de la unidad de conservación</th>
                            <th class="grp" colspan="2">Fechas extremas</th><th rowspan="2">Año</th><th rowspan="2">Fase del archivo</th>
                            <th class="grp" colspan="2">Soporte o formato</th>
                            <th class="grp" colspan="4">Unidad de conservación · Físico · Papel</th>
                            <th class="grp blk-otro" colspan="2">Otro</th>
                            <th class="grp blk-elec" colspan="3">Electrónico</th>
                            <th class="blk-notas" rowspan="2">Notas</th><th rowspan="2" class="text-right">Detalle</th>
                        </tr>
                        <tr>
                            <th>Inicial</th><th>Final</th><th>Análogo</th><th>Electrónico</th>
                            <th>Caja</th><th>Carpeta</th><th>Correlativo</th><th>Folios</th>
                            <th class="blk-otro">Tipo</th><th class="blk-otro">Cantidad</th>
                            <th class="blk-elec">Ubicación</th><th class="blk-elec">Cant. docs.</th><th class="blk-elec">Tamaño</th>
                        </tr>
                    </x-slot:head>
                    @foreach ($reg as $r)
                        <tr data-anio="{{ $r['anio'] }}" data-dep="{{ $r['codigo_dependencia'] }}" data-unidad="{{ $depUnidad[$r['codigo_dependencia']] ?? $r['codigo_dependencia'] }}" data-serie="{{ $r['serie_codigo'] }}" data-subserie="{{ $r['subserie_codigo'] }}" data-caja="{{ $r['caja_key'] }}" data-fase="{{ $r['fase_archivo'] ?? 'sin' }}" data-folios="{{ $r['folios_total'] ?? 0 }}">
                            <td>{{ $r['id'] }}</td><td>{{ $r['orden'] ?? '—' }}</td><td class="nowrap">{{ $r['codigo_dependencia'] }}.{{ $r['dependencia'] }}</td>
                            <td>{{ $r['serie'] }}</td><td>{{ $r['subserie'] ?? '—' }}</td><td><strong>{{ $r['nombre_unidad'] }}</strong>@if ($r['demo'])<x-sgdea.badge status="demo" :dot="false" />@endif
                                @if (count($r['alertas']))<x-sgdea.icon name="alert-triangle" :size="14" class="icon warn-dot" title="{{ implode(' ', $r['alertas']) }}" />@endif</td>
                            <td class="nowrap">{{ $f($r['fecha_inicial']) }}</td><td class="nowrap">{{ $f($r['fecha_final']) }}</td><td>{{ $r['anio'] ?? '—' }}</td><td class="small">{{ $r['fase_archivo'] ?? 'No especificada' }}</td>
                            <td>{{ $r['soporte_analogo'] ?? '—' }}</td><td>{{ $r['soporte_electronico'] ?? '—' }}</td>
                            <td>{{ $r['caja'] ?? '—' }}</td><td>{{ $r['carpeta'] ?? '—' }}</td><td>{{ $r['correlativo'] ?? '—' }}</td><td class="nowrap">{{ $r['folios'] ?? '—' }}</td>
                            <td class="blk-otro">{{ $r['otro_tipo'] ?? '—' }}</td><td class="blk-otro">{{ $r['otro_cantidad'] ?? '—' }}</td>
                            <td class="blk-elec">{{ $r['elec_ubicacion'] ?? '—' }}</td><td class="blk-elec">{{ $r['elec_cantidad'] ?? '—' }}</td><td class="blk-elec">{{ $r['elec_tamano'] ?? '—' }}</td>
                            <td class="blk-notas small">{{ $r['notas'] ?? '—' }}</td>
                            <td class="text-right nowrap"><x-sgdea.button variant="ghost" size="sm" icon="eye" route="sgdea.fuid.show" :params="['id' => $r['id']]">Ver</x-sgdea.button></td>
                        </tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>

        <div class="tab-panel" id="fuid-tab-cajas">
            <x-sgdea.card :flush="true">
                <x-sgdea.table id="tbl-cajas" :searchable="false" :cols="7">
                    <x-slot:head><tr><th>Caja</th><th>Dependencia</th><th>Carpetas</th><th>Folios</th><th>Fechas extremas</th><th>Series</th><th class="text-right">Acciones</th></tr></x-slot:head>
                    @foreach ($vm['cajas'] as $i => $c)
                        <tr><td><strong>{{ $c['caja'] }}</strong></td><td>{{ $c['dependencia'] }}</td><td>{{ $c['carpetas'] }}</td><td>{{ number_format($c['folios'], 0, ',', '.') }}</td>
                            <td class="nowrap">{{ $f($c['fecha_inicial']) }} → {{ $f($c['fecha_final']) }}</td><td class="small">{{ implode('; ', $c['series']) }}</td>
                            <td class="text-right nowrap">
                                <x-sgdea.button variant="ghost" size="sm" icon="eye" data-fuid-ver-caja="{{ $c['caja_key'] }}">Ver carpetas</x-sgdea.button>
                                <x-sgdea.button variant="ghost" size="sm" icon="file" data-caja-rotulo="{{ $i }}">Rótulo</x-sgdea.button>
                            </td></tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
            <p class="small muted mt-1">Los datos de estante, entrepaño y número de caja en el archivo central no vienen en el inventario; se registrarán al transferir.</p>
        </div>

        <div class="tab-panel" id="fuid-tab-resumen">
            <div class="grid grid-2">
                <x-sgdea.card title="Por serie y subserie" :flush="true">
                    <x-sgdea.table id="tbl-res-serie" :searchable="false" :cols="4">
                        <x-slot:head><tr><th>Serie</th><th>Subserie</th><th>Carpetas</th><th>Folios</th></tr></x-slot:head>
                        @foreach ($vm['resumen_series'] as $s)<tr><td>{{ $s['serie'] }}</td><td class="small">{{ $s['subserie'] }}</td><td>{{ $s['carpetas'] }}</td><td>{{ number_format($s['folios'], 0, ',', '.') }}</td></tr>@endforeach
                    </x-sgdea.table>
                </x-sgdea.card>
                <x-sgdea.card title="Por año (fecha final)" :flush="true">
                    <x-sgdea.table id="tbl-res-anio" :searchable="false" :cols="3">
                        <x-slot:head><tr><th>Año</th><th>Carpetas</th><th>Folios</th></tr></x-slot:head>
                        @foreach ($vm['resumen_anios'] as $a)<tr><td>{{ $a['anio'] }}</td><td>{{ $a['carpetas'] }}</td><td>{{ number_format($a['folios'], 0, ',', '.') }}</td></tr>@endforeach
                    </x-sgdea.table>
                </x-sgdea.card>
            </div>
        </div>
    </div>

    <script type="application/json" id="fuid-deps">{!! $json($depEncabezado) !!}</script>
    <script type="application/json" id="caja-data">{!! $json($vm['cajas']) !!}</script>
    @include('sgdea.partials.json-options', ['opciones' => ['fuid-subseries' => $vm['subseries_por_serie']]])
@endsection

@push('modals')
    @include('sgdea.fuid.partials.rotulo-caja')
    <x-sgdea.modal id="modal-fuid-export" title="Exportar inventario" size="md">
        <p>Se exportarán <strong id="export-count">{{ $t['carpetas'] }}</strong> unidades de conservación con los filtros aplicados.</p>
        <x-sgdea.alert type="warning">Demostración: ningún archivo se genera. La exportación real la implementará el backend.</x-sgdea.alert>
        <div class="export-grid">
            <x-sgdea.button variant="outline" icon="download" data-demo-toast="Demostración: exportación a Excel (.xlsx) pendiente del backend." data-toast-type="warning">Excel (.xlsx)</x-sgdea.button>
            <x-sgdea.button variant="outline" icon="download" data-demo-toast="Demostración: exportación a CSV pendiente del backend." data-toast-type="warning">CSV</x-sgdea.button>
            <x-sgdea.button variant="outline" icon="download" data-demo-toast="Demostración: exportación a PDF pendiente del backend." data-toast-type="warning">PDF</x-sgdea.button>
        </div>
        <x-slot:footer><x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button></x-slot:footer>
    </x-sgdea.modal>
@endpush
@push('scripts')<script src="{{ asset('sgdea/js/fuid.js') }}"></script>@endpush
