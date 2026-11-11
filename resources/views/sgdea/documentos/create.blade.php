{{--
  Módulo 4 · Documentos digitales — Registro (SOLO VISUAL).
  Variables del futuro controlador: $unidades, $radicaciones (opcional).
  Campos coherentes con documentos_digitales. Los datos del archivo (nombre, MIME, tamaño, hash, ruta), el usuario, la IP
  y la hora de carga los calcula y registra el backend. No se almacena nada.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Registrar documento digital')
@section('subtitle', 'Carga del archivo y metadatos mínimos')
@section('module', 'documentos')

@php
    $demoCcd = require resource_path('sgdea/demo/ccd.php');
    $unidades = $unidades ?? $demoCcd['unidades'];
    $ccd = (require resource_path('sgdea/presenters/ccd.php'))($demoCcd['fondo'], $unidades);
    $unidadOpciones = collect($unidades)->mapWithKeys(fn ($u) => ['u:' . $u['codigo'] => $u['codigo'] . ' · ' . $u['nombre']])->all();
    $radicaciones = $radicaciones ?? collect(require resource_path('sgdea/demo/radicaciones.php'))->mapWithKeys(fn ($r) => [$r['id'] => $r['numero_radicado'] . ' — ' . $r['asunto']])->all();
@endphp

@section('content')
    <x-sgdea.page-header>
        <x-slot:actions><x-sgdea.button variant="outline" icon="arrow-left" route="sgdea.documentos.index">Volver a la consulta</x-sgdea.button></x-slot:actions>
    </x-sgdea.page-header>

    <form id="form-documento" method="POST" action="#" enctype="multipart/form-data" data-demo-form data-demo-message="Demostración: el documento no fue almacenado. El guardado del archivo y el cálculo del hash los hará el backend." novalidate>
        @csrf
        <div class="grid">
            <x-sgdea.card title="1. Archivo digital">
                <div class="dropzone">
                    <x-sgdea.icon name="upload" :size="28" />
                    <p style="margin:.4rem 0">Seleccione el archivo a digitalizar.</p>
                    <input type="file" id="doc-archivo" name="archivo" accept=".pdf,.tif,.tiff,.jpg,.jpeg,.png" data-file-preview="#doc-archivos" aria-label="Seleccionar archivo">
                    <p class="small muted" style="margin:.4rem 0 0">Formatos admitidos: PDF/A, TIFF, JPG y PNG. El peso máximo lo definirá el backend.</p>
                </div>
                <ul class="file-list" id="doc-archivos"></ul>
                <div id="doc-info" hidden class="mt-2">
                    <x-sgdea.alert type="success" id="doc-formato-ok" hidden>Formato admitido. La verificación de PDF/A la realizará el backend.</x-sgdea.alert>
                    <x-sgdea.alert type="error" id="doc-formato-error" hidden>El formato no está admitido. Use PDF/A, TIFF, JPG o PNG.</x-sgdea.alert>
                    <dl class="dl">
                        <dt>Tipo MIME</dt><dd id="doc-mime">—</dd>
                        <dt>Tamaño</dt><dd id="doc-tam">—</dd>
                        <dt>Huella SHA-256 (vista previa)</dt><dd><div class="hash" id="doc-hash">—</div>
                            <span class="small muted">Calculada en su navegador solo para mostrarla. La huella oficial la calcula y guarda el servidor.</span></dd>
                    </dl>
                </div>
            </x-sgdea.card>

            <x-sgdea.card title="2. Vinculación documental">
                <div class="rule-note">Un documento no puede quedar huérfano: debe tener un tipo documental (que pertenece a una serie) y, si corresponde, una radicación.</div>
                <div class="form-grid">
                    <x-sgdea.field label="Unidad administrativa" name="filtro_unidad_id" type="select" id="doc-unidad" :required="true" :options="$unidadOpciones" />
                    <x-sgdea.field label="Oficina productora" name="filtro_oficina_id" type="select" id="doc-oficina" :required="true" :options="[]"
                        :attr="['data-parent' => 'doc-unidad', 'data-options-from' => 'opt-oficinas-ext', 'data-empty-text' => 'No tiene oficinas productoras asociadas', 'data-guard' => '1']" />
                    <x-sgdea.field label="Serie documental" name="filtro_serie_id" type="select" id="doc-serie" :required="true" :options="[]"
                        :attr="['data-parent' => 'doc-oficina', 'data-options-from' => 'opt-series', 'data-empty-text' => 'No tiene series documentales asociadas', 'data-guard' => '1']" />
                    <x-sgdea.field label="Tipo documental" name="tipo_documental_id" type="select" id="doc-tipo" :required="true" :options="[]"
                        :attr="['data-parent' => 'doc-serie', 'data-options-from' => 'opt-tipos', 'data-empty-text' => 'Sin tipos documentales registrados', 'data-guard' => '1']" />
                    <x-sgdea.field label="Radicación asociada (opcional)" name="radicacion_id" type="select" :options="$radicaciones" placeholder="Sin radicación" wrap-class="span-2" />
                </div>
                <p class="small muted" style="margin:.5rem 0 0">Las series con «Oficina productora no especificada en el CCD» se conservan del CCD oficial. Como el modelo de datos actual exige una oficina productora para guardar, ese caso queda pendiente de confirmar.</p>
                <x-sgdea.alert type="info" data-guard-alert="doc-oficina" hidden>La unidad seleccionada no tiene oficinas productoras asociadas.</x-sgdea.alert>
                <x-sgdea.alert type="info" data-guard-alert="doc-serie" hidden>La oficina seleccionada no tiene series documentales asociadas.</x-sgdea.alert>
                <x-sgdea.alert type="info" data-guard-alert="doc-tipo" hidden>La serie seleccionada no tiene tipos documentales registrados en el CCD. Deben crearse en el módulo CCD antes de registrar documentos.</x-sgdea.alert>
            </x-sgdea.card>

            <x-sgdea.card title="3. Metadatos mínimos">
                <div class="form-grid">
                    <x-sgdea.field label="Título o nombre del documento" name="titulo" :required="true" wrap-class="span-2" />
                    <x-sgdea.field label="Fecha de producción" name="fecha_produccion" type="date" :required="true" />
                    <x-sgdea.field label="Soporte de origen" name="soporte_origen" type="select" :required="true" :options="['Papel' => 'Papel', 'Electrónico' => 'Electrónico', 'Papel/Electrónico' => 'Papel/Electrónico']" />
                    <x-sgdea.field label="Número de folios" name="cantidad_folios" type="number" min="0" :required="true" />
                    <x-sgdea.field label="Número de páginas" name="cantidad_paginas" type="number" min="0" :required="true" />
                    <x-sgdea.field label="Nivel de acceso" name="nivel_acceso" type="select" :required="true" :options="['publica' => 'Pública', 'clasificada' => 'Clasificada', 'reservada' => 'Reservada']" wrap-class="span-2" />
                </div>
            </x-sgdea.card>

            <x-sgdea.card title="4. Metadatos de contexto (automáticos)">
                <p class="small muted" style="margin-top:0">Los registra el sistema al guardar; no se diligencian.</p>
                <dl class="dl"><dt>Usuario que carga</dt><dd>Usuario con sesión iniciada</dd><dt>Dirección IP</dt><dd>Se registra al cargar</dd><dt>Fecha y hora de carga</dt><dd>Sello del servidor</dd></dl>
            </x-sgdea.card>

            <div class="flex" style="justify-content:flex-end">
                <x-sgdea.button variant="outline" route="sgdea.documentos.index">Cancelar</x-sgdea.button>
                <x-sgdea.button type="submit" icon="check">Registrar documento (demostración)</x-sgdea.button>
            </div>
        </div>
    </form>

    @include('sgdea.partials.json-options', ['opciones' => ['oficinas-ext' => $ccd['opciones']['oficinas_ext'], 'series' => $ccd['opciones']['series'], 'tipos' => $ccd['opciones']['tipos']]])
@endsection

@push('scripts')
    <script src="{{ asset('sgdea/js/documentos.js') }}"></script>
@endpush
