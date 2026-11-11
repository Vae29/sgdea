{{--
  Módulo 2 · Tablas de Retención Documental (TRD) — HU-GDO-02. Módulo GENERAL para todas las unidades y oficinas del CCD.
  Variables del futuro controlador (ver FRONTEND_BACKEND_CONTRACT.md): $fondo, $unidades (con 'retencion' en series/subseries), $esDemo.
  Tablas relacionadas: retencion_documental (+ series_documentales, subseries_documentales, oficinas_productoras).
--}}
@extends('sgdea.layouts.app')
@section('title', 'Tablas de Retención Documental (TRD)')
@section('subtitle', 'Retención en archivo de gestión y central, disposición final y procedimiento')
@section('module', 'trd')

@php
    $demo = require resource_path('sgdea/demo/ccd.php');
    $fondo = $fondo ?? $demo['fondo'];
    $unidades = $unidades ?? $demo['unidades'];
    $esDemo = $esDemo ?? true;
    $ccd = (require resource_path('sgdea/presenters/ccd.php'))($fondo, $unidades);
    $trd = (require resource_path('sgdea/presenters/trd.php'))($unidades);
    $filas = $trd['filas'];
    $unidadOpciones = collect($unidades)->mapWithKeys(fn ($u) => ['u:' . $u['codigo'] => $u['codigo'] . ' · ' . $u['nombre']])->all();
    // Códigos de disposición: HU-GDO-02 (CT, E, S, M) y formato TRD (CT, E, D, S). Se conservan ambos, sin elegir uno.
    $disposiciones = [
        'CT' => 'CT — Conservación total (HU y TRD)', 'E' => 'E — Eliminación (HU y TRD)', 'S' => 'S — Selección (HU y TRD)',
        'M' => 'M — Reprografía (según HU-GDO-02)', 'D' => 'D — Reproducción por medio: M, D, R u O (según formato TRD)',
    ];
    $json = fn ($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    $encadenado = fn ($padre, $fuente, $vacio) => ['data-parent' => $padre, 'data-options-from' => $fuente, 'data-empty-text' => $vacio, 'data-placeholder' => 'Todas'];
@endphp

@section('content')
    @if ($esDemo)
        <x-sgdea.alert type="info" title="Retención tomada del CCD; el resto, sin parametrizar">
            Solo {{ $trd['parametrizadas'] }} registros del CCD entregado traen años y disposición. Los demás se muestran como “Sin parametrizar” y la interfaz está lista para registrar la información cuando la empresa la suministre.
            Este módulo es general: incluye todas las unidades y oficinas del CCD, también las series con oficina productora no especificada. La TRD de Planta de Beneficio Animal (TRD_30) es solo un ejemplo del formato.
        </x-sgdea.alert>
    @endif

    <x-sgdea.card title="Encabezado del formato TRD" class="mb-2">
        <dl class="dl" style="grid-template-columns:170px 1fr 170px 1fr">
            <dt>Entidad productora</dt><dd>Empresas Varias de Caicedonia E.V.C. – E.S.P.</dd>
            <dt>Dependencia</dt><dd id="trd-dep">Todas las dependencias</dd>
            <dt>Elaboración TRD</dt><dd class="small">Según el ejemplo TRD_30: Acuerdo n.º 003 de 29-dic-2020, modificado por Acuerdo 001 de 30-may-2024</dd>
            <dt>Resolución de aprobación</dt><dd class="muted">Información pendiente (no suministrada)</dd>
        </dl>
    </x-sgdea.card>

    <div data-tabs>
        <div class="tabs" role="tablist">
            <button type="button" class="tab-btn is-active" data-tab-target="#trd-tab-consulta">Consulta de TRD</button>
            <button type="button" class="tab-btn" data-tab-target="#trd-tab-convenciones">Convenciones y diferencias HU / TRD</button>
        </div>

        <div class="tab-panel is-active" id="trd-tab-consulta">
            <x-sgdea.card :flush="true">
                <div class="table-toolbar">
                    <strong id="trd-count" class="small"></strong>
                    <div class="flex">
                        <x-sgdea.button variant="outline" size="sm" icon="filter" data-toggle-target="#trd-filtros">Mostrar/ocultar filtros</x-sgdea.button>
                        <x-sgdea.button size="sm" icon="plus" data-trd-nuevo>Parametrizar retención</x-sgdea.button>
                    </div>
                </div>
                <div class="filters" id="trd-filtros">
                    <x-sgdea.field label="Unidad administrativa" name="f_unidad" type="select" id="f-unidad" placeholder="Todas" :options="$unidadOpciones" />
                    <x-sgdea.field label="Oficina productora" name="f_oficina" type="select" id="f-oficina" :options="[]" :attr="$encadenado('f-unidad', 'opt-oficinas-ext', 'No tiene oficinas productoras asociadas')" />
                    <x-sgdea.field label="Serie documental" name="f_serie" type="select" id="f-serie" :options="[]" :attr="$encadenado('f-oficina', 'opt-series', 'Sin series')" />
                    <x-sgdea.field label="Disposición final" name="f_disp" type="select" id="f-disp" placeholder="Todas" :options="$disposiciones" />
                    <x-sgdea.field label="Parametrización" name="f_param" type="select" id="f-param" placeholder="Todas" :options="['1' => 'Parametrizada', '0' => 'Sin parametrizar']" />
                    <div class="field" style="align-self:end"><x-sgdea.button variant="outline" size="sm" data-trd-limpiar>Limpiar filtros</x-sgdea.button></div>
                </div>
                <x-sgdea.table id="tbl-trd" :cols="11" placeholder="Buscar por código, serie, subserie o dependencia…">
                    <x-slot:head>
                        <tr><th>Dependencia</th><th>Código</th><th>Serie</th><th>Subserie</th><th>Tipo de soporte</th><th>Gestión (años)</th><th>Central (años)</th><th>Disposición final</th><th>Procedimiento</th><th>Estado</th><th class="text-right">Detalle</th></tr>
                    </x-slot:head>
                    @foreach ($filas as $i => $f)
                        <tr data-i="{{ $i }}" data-unidad="{{ $f['unidad_key'] }}" data-oficina="{{ $f['oficina_key'] }}" data-serie="{{ $f['serie_key'] }}"
                            data-disp="{{ implode(' ', $f['disposicion_final']) }}" data-param="{{ $f['parametrizada'] ? '1' : '0' }}">
                            <td class="small">{{ $f['unidad'] }}<div @class(['muted' => !$f['sin_oficina'], 'cell-sin' => $f['sin_oficina']])>{{ $f['oficina'] }}</div></td>
                            <td class="mono nowrap">{{ $f['codigo'] }}</td>
                            <td>{{ $f['serie'] }}</td>
                            <td>{{ $f['subserie'] ?? '— (retención en la serie)' }}</td>
                            <td class="small">{{ count($f['soportes']) ? implode('; ', $f['soportes']) : '—' }}</td>
                            <td>{{ $f['anios_gestion'] ?? '—' }}</td>
                            <td>{{ $f['anios_central'] ?? '—' }}</td>
                            <td>{{ count($f['disposicion_final']) ? implode(', ', $f['disposicion_final']) : '—' }}</td>
                            <td class="small">{{ $f['procedimiento'] ?? '—' }}</td>
                            <td><x-sgdea.badge :tone="$f['parametrizada'] ? 'success' : 'neutral'" :label="$f['parametrizada'] ? 'Parametrizada' : 'Sin parametrizar'" /></td>
                            <td class="text-right"><x-sgdea.button variant="ghost" size="sm" icon="eye" data-trd-detalle="{{ $i }}">Ver</x-sgdea.button></td>
                        </tr>
                    @endforeach
                </x-sgdea.table>
            </x-sgdea.card>
        </div>

        <div class="tab-panel" id="trd-tab-convenciones">
            <x-sgdea.alert type="info">Diferencias documentadas entre la HU-GDO-02 y el formato TRD de ejemplo. La interfaz conserva ambas convenciones y no reemplaza una por otra; la empresa debe confirmar cuál aplicar.</x-sgdea.alert>
            <x-sgdea.card :flush="true">
                <div class="table-wrap"><table class="table">
                    <thead><tr><th>Tema</th><th>HU-GDO-02</th><th>Formato TRD (ejemplo TRD_30 y CCD)</th><th>Tratamiento en la interfaz</th></tr></thead>
                    <tbody>
                        <tr><td><strong>Disposición final</strong></td><td>CT, E, S y <strong>M</strong> (Reprografía)</td><td>CT, E, S y <strong>D</strong> (Reproducción por medio: M = microfilmación, D = digitalización, R = reprografía, O = otros)</td><td>Se ofrecen M y D, cada uno rotulado con su fuente</td></tr>
                        <tr><td><strong>Asociación de la retención</strong></td><td>A cada <em>subserie</em></td><td>A una serie (sin subseries) o a una subserie</td><td>Admite serie o subserie</td></tr>
                        <tr><td><strong>Años de retención</strong></td><td>Gestión ≥ 1 y Central ≥ 0 (enteros, no nulos)</td><td>Columnas AG y AC sin restricción visible</td><td>El formulario aplica la regla de la HU; pendiente confirmar</td></tr>
                        <tr><td><strong>Soporte</strong></td><td>Físico, electrónico (incluye audiovisual y fotográfico) o híbrido</td><td>SF (físico) y SE (electrónico, con formato); el CCD escribe textos como «Papel/Electrónico (PDF)»</td><td>Se muestra el texto original del CCD y se discrimina en el formulario</td></tr>
                        <tr><td><strong>Código de serie/subserie</strong></td><td>No define notación</td><td>TRD: <span class="mono">30.08-02</span>; rótulo de carpeta: <span class="mono">30.26.05</span>; rótulo de caja: <span class="mono">51.09-01</span></td><td>Se usa la notación TRD y se conserva cada fuente sin corregir</td></tr>
                        <tr><td><strong>Procedimiento</strong></td><td>Justificación / procedimiento técnico de la disposición</td><td>Columna «Procedimiento»</td><td>Campo de texto</td></tr>
                    </tbody>
                </table></div>
            </x-sgdea.card>
            <x-sgdea.card title="Convenciones del formato TRD" class="mt-2">
                <div class="legend">
                    <div><b>AG</b> — Archivo de gestión (años)</div><div><b>AC</b> — Archivo central (años)</div>
                    <div><b>CT</b> — Conservación total</div><div><b>S</b> — Selección</div><div><b>E</b> — Eliminación</div>
                    <div><b>D</b> — Reproducción por medio: M, D, R u O</div>
                    <div><b>SF</b> — Soporte físico</div><div><b>SE</b> — Soporte electrónico (especificar formato)</div>
                </div>
            </x-sgdea.card>
        </div>
    </div>

    <script type="application/json" id="trd-rows">{!! $json($filas) !!}</script>
    @include('sgdea.partials.json-options', ['opciones' => ['oficinas-ext' => $ccd['opciones']['oficinas_ext'], 'series' => $ccd['opciones']['series'], 'subseries' => $ccd['opciones']['subseries']]])
@endsection

@push('modals')
    <x-sgdea.modal id="modal-trd-detalle" title="Detalle de retención" size="lg">
        <div id="trd-detalle-cuerpo"></div>
        <x-slot:footer>
            <x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button>
            <x-sgdea.button id="trd-detalle-editar" icon="edit" data-trd-editar="0">Editar retención</x-sgdea.button>
        </x-slot:footer>
    </x-sgdea.modal>

    <x-sgdea.modal id="modal-trd-form" title="Parametrizar retención" size="lg">
        <form id="form-trd" method="POST" action="#" data-demo-form novalidate>
            @csrf
            <div class="rule-note">La retención se asocia a una <strong>subserie</strong> (HU-GDO-02) o, cuando la serie no tiene subseries, a la <strong>serie</strong> (formato TRD). Si no elige subserie, se aplica a la serie.</div>
            <div class="form-grid">
                <x-sgdea.field label="Unidad administrativa" name="filtro_unidad_id" type="select" id="trd-form-unidad" :required="true" :options="$unidadOpciones" />
                <x-sgdea.field label="Oficina productora" name="filtro_oficina_id" type="select" id="trd-form-oficina" :required="true" :options="[]"
                    :attr="['data-parent' => 'trd-form-unidad', 'data-options-from' => 'opt-oficinas-ext', 'data-empty-text' => 'No tiene oficinas productoras asociadas']" />
                <x-sgdea.field label="Serie documental" name="serie_id" type="select" id="trd-form-serie" :required="true" :options="[]"
                    :attr="['data-parent' => 'trd-form-oficina', 'data-options-from' => 'opt-series', 'data-empty-text' => 'No tiene series asociadas']" />
                <x-sgdea.field label="Subserie documental (si corresponde)" name="subserie_id" type="select" id="trd-form-subserie" :options="[]"
                    :attr="['data-parent' => 'trd-form-serie', 'data-options-from' => 'opt-subseries', 'data-empty-text' => 'Esta serie no tiene subseries']" />
                <x-sgdea.field label="Años en archivo de gestión" name="anios_gestion" type="number" min="1" :required="true" hint="Entero ≥ 1 (HU-GDO-02)." />
                <x-sgdea.field label="Años en archivo central" name="anios_central" type="number" min="0" :required="true" hint="Entero ≥ 0 (HU-GDO-02)." />
                <x-sgdea.field label="Disposición final" name="disposicion_final" type="select" :required="true" :options="$disposiciones" wrap-class="span-2" hint="La HU usa CT, E, S y M; el formato TRD usa CT, E, S y D. Pendiente de confirmar." />
                <x-sgdea.field label="Procedimiento o justificación técnica" name="procedimiento" type="textarea" wrap-class="span-2" />
            </div>
            <p class="small muted" style="margin:0 0 1rem">Para series con «Oficina productora no especificada en el CCD», el modelo de datos actual exige una oficina para guardar; ese caso queda pendiente de confirmar.</p>
            <label class="check"><input type="checkbox" name="activo" value="1" checked> Registro activo</label>
        </form>
        <x-slot:footer>
            <x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button>
            <x-sgdea.button type="submit" form="form-trd" icon="check" data-demo-message="Demostración: la retención no fue guardada. La integración con el backend está pendiente.">Guardar</x-sgdea.button>
        </x-slot:footer>
    </x-sgdea.modal>
@endpush
@push('scripts')
    <script src="{{ asset('sgdea/js/trd.js') }}"></script>
@endpush
