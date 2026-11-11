{{--
  Módulo 1 · Cuadro de Clasificación Documental (CCD).
  Variables que recibirá del futuro controlador (ver FRONTEND_BACKEND_CONTRACT.md):
    $fondo, $unidades (con sus oficinas, series, subseries y tipos documentales), $esDemo.
  Mientras no existan, se usan los datos extraídos del CCD oficial en resources/sgdea/demo/ccd.php.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Cuadro de Clasificación Documental (CCD)')
@section('subtitle', 'Fondo → Unidad administrativa → Oficina productora → Serie → Subserie → Tipo documental')
@section('module', 'ccd')

@php
    $demo = require resource_path('sgdea/demo/ccd.php');
    $fondo = $fondo ?? $demo['fondo'];
    $unidades = $unidades ?? $demo['unidades'];
    $esDemo = $esDemo ?? true;
    $vm = (require resource_path('sgdea/presenters/ccd.php'))($fondo, $unidades);
    $fondoOpciones = ['f' => $fondo['nombre']];
    $soportes = $vm['soportes'];
    $json = fn ($v) => json_encode($v, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
@endphp

@section('content')
    <x-sgdea.alert type="info" title="Jerarquía documental oficial del CCD de la empresa">
        Fondo → Unidad administrativa → Oficina productora → Serie → Subserie → Tipo documental.
        Las series <strong>nuevas</strong> se vinculan siempre a una oficina productora (modelo de datos actual).
        El CCD oficial también lista <strong>{{ $vm['totales']['series_sin_oficina'] }} series bajo una unidad sin oficina productora especificada</strong>: se conservan y se muestran como “Oficina productora no especificada en el CCD”, sin inventarles oficina.
        @if ($esDemo)<br><small>Datos extraídos del CCD oficial. El estado “Activo” es el valor por defecto de la demostración.</small>@endif
    </x-sgdea.alert>
    <details class="rule-note" style="margin-bottom:1rem">
        <summary style="cursor:pointer;font-weight:600">Diferencia entre HU-GDO-01 y el CCD de la empresa (documentada, sin decidir cuál prevalece)</summary>
        <p style="margin:.5rem 0 0">La HU-GDO-01 describe la jerarquía genérica <em>Fondo, Sección, Subsección, Serie, Subserie y Tipo documental</em> (y selectores «Fondo → Sección → Serie → Subserie»).
        El CCD de la empresa organiza <em>Fondo, Unidad administrativa, Oficina productora, Serie, Subserie y Tipo documental</em>, y esta interfaz representa la estructura real del CCD.
        Además, el CCD no es uniforme: algunas series cuelgan directamente de la unidad. Su tratamiento en el modelo de datos queda pendiente de confirmación.</p>
    </details>

    <div data-tabs>
        <div class="tabs" role="tablist">
            <button type="button" class="tab-btn is-active" data-tab-target="#ccd-tab-arbol">Árbol jerárquico</button>
            <button type="button" class="tab-btn" data-tab-target="#ccd-tab-unidades">Unidades administrativas</button>
            <button type="button" class="tab-btn" data-tab-target="#ccd-tab-oficinas">Oficinas productoras</button>
            <button type="button" class="tab-btn" data-tab-target="#ccd-tab-series">Series</button>
            <button type="button" class="tab-btn" data-tab-target="#ccd-tab-subseries">Subseries</button>
            <button type="button" class="tab-btn" data-tab-target="#ccd-tab-tipos">Tipos documentales</button>
        </div>

        <div class="tab-panel is-active" id="ccd-tab-arbol">
            <div class="split">
                <x-sgdea.card :flush="true">
                    <div class="table-toolbar">
                        <div class="search-box"><x-sgdea.icon name="search" :size="16" /><input type="search" id="ccd-tree-search" placeholder="Buscar en el árbol…" aria-label="Buscar en el árbol"></div>
                        <div class="flex">
                            <x-sgdea.button variant="outline" size="sm" data-tree-expand>Expandir todo</x-sgdea.button>
                            <x-sgdea.button variant="outline" size="sm" data-tree-collapse>Contraer</x-sgdea.button>
                        </div>
                    </div>
                    <div class="tree-scroll">
                        <ul class="tree" id="ccd-tree">@include('sgdea.ccd.partials.tree-node', ['nodo' => $vm['arbol'], 'abierto' => true])</ul>
                    </div>
                </x-sgdea.card>
                <x-sgdea.card title="Detalle del elemento seleccionado"><div id="ccd-detalle"><p class="muted">Seleccione un elemento del árbol.</p></div></x-sgdea.card>
            </div>
        </div>

        <div class="tab-panel" id="ccd-tab-unidades">
            @include('sgdea.ccd.partials.tabla-nivel', ['nivel' => 'unidad', 'titulo' => 'unidades administrativas', 'filas' => $vm['tablas']['unidades'],
                'campos' => ['Código' => 'codigo', 'Nombre' => 'nombre', 'Fondo documental' => 'fondo', 'Oficinas' => 'oficinas', 'Series sin oficina' => 'series_sin_oficina']])
        </div>
        <div class="tab-panel" id="ccd-tab-oficinas">
            @include('sgdea.ccd.partials.tabla-nivel', ['nivel' => 'oficina', 'titulo' => 'oficinas productoras', 'filas' => $vm['tablas']['oficinas'],
                'campos' => ['Código' => 'codigo', 'Nombre' => 'nombre', 'Unidad administrativa' => 'unidad', 'Series' => 'series']])
        </div>
        <div class="tab-panel" id="ccd-tab-series">
            @include('sgdea.ccd.partials.tabla-nivel', ['nivel' => 'serie', 'titulo' => 'series documentales', 'filas' => $vm['tablas']['series'],
                'campos' => ['Código' => 'codigo', 'Nombre' => 'nombre', 'Oficina productora' => 'oficina', 'Unidad administrativa' => 'unidad', 'Subseries' => 'subseries']])
        </div>
        <div class="tab-panel" id="ccd-tab-subseries">
            @include('sgdea.ccd.partials.tabla-nivel', ['nivel' => 'subserie', 'titulo' => 'subseries documentales', 'filas' => $vm['tablas']['subseries'],
                'campos' => ['Código' => 'codigo', 'Nombre' => 'nombre', 'Serie' => 'serie', 'Oficina productora' => 'oficina', 'Tipos documentales' => 'tipos']])
        </div>
        <div class="tab-panel" id="ccd-tab-tipos">
            @include('sgdea.ccd.partials.tabla-nivel', ['nivel' => 'tipo', 'titulo' => 'tipos documentales', 'filas' => $vm['tablas']['tipos'],
                'campos' => ['Nombre' => 'nombre', 'Serie' => 'serie', 'Subserie' => 'subserie', 'Oficina productora' => 'oficina', 'Soporte' => 'soporte']])
        </div>
    </div>

    <script type="application/json" id="ccd-nodes">{!! $json($vm['nodos']) !!}</script>
    <script type="application/json" id="opt-unidades">{!! $json($vm['opciones']['unidades']) !!}</script>
    <script type="application/json" id="opt-oficinas">{!! $json($vm['opciones']['oficinas']) !!}</script>
    <script type="application/json" id="opt-series">{!! $json($vm['opciones']['series']) !!}</script>
    <script type="application/json" id="opt-subseries">{!! $json($vm['opciones']['subseries']) !!}</script>
@endsection

@push('modals')
    @include('sgdea.ccd.partials.modales', ['fondoOpciones' => $fondoOpciones, 'soportes' => $soportes])
@endpush
@push('scripts')
    <script src="{{ asset('sgdea/js/ccd.js') }}"></script>
@endpush
