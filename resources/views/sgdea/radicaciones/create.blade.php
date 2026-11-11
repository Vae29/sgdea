{{--
  Módulo 3 · Radicación — Formulario (SOLO VISUAL).
  Variables del futuro controlador: $unidades (para los selectores dependientes) y $radicadosPadre (opcional).
  Campos coherentes con la tabla radicaciones. El número, el año, el consecutivo, la fecha y hora y el usuario los asigna el backend.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Nueva radicación')
@section('subtitle', 'Registro de una comunicación recibida, enviada o interna')
@section('module', 'radicaciones')

@php
    $demoCcd = require resource_path('sgdea/demo/ccd.php');
    $unidades = $unidades ?? $demoCcd['unidades'];
    $ccd = (require resource_path('sgdea/presenters/ccd.php'))($demoCcd['fondo'], $unidades);
    $unidadOpciones = collect($unidades)->mapWithKeys(fn ($u) => ['u:' . $u['codigo'] => $u['codigo'] . ' · ' . $u['nombre']])->all();
    $radicadosPadre = $radicadosPadre ?? collect(require resource_path('sgdea/demo/radicaciones.php'))->mapWithKeys(fn ($r) => [$r['id'] => $r['numero_radicado'] . ' — ' . $r['asunto']])->all();
    $esDemo = $esDemo ?? true;
@endphp

@section('content')
    <x-sgdea.page-header>
        <x-slot:actions><x-sgdea.button variant="outline" icon="arrow-left" route="sgdea.radicaciones.index">Volver al listado</x-sgdea.button></x-slot:actions>
    </x-sgdea.page-header>

    <form id="form-radicacion" method="POST" action="#" enctype="multipart/form-data" data-demo-form data-demo-message="Demostración: la comunicación no fue radicada. El consecutivo y el registro se generarán en el backend." novalidate>
        @csrf
        <div class="grid">
            <x-sgdea.card title="1. Tipo de comunicación">
                <div class="choice-cards">
                    <label class="choice"><input type="radio" name="tipo" value="entrada" checked><span><b>Entrada</b><small>Documento recibido por la empresa</small></span></label>
                    <label class="choice"><input type="radio" name="tipo" value="salida"><span><b>Salida</b><small>Documento enviado por la empresa</small></span></label>
                    <label class="choice"><input type="radio" name="tipo" value="interna"><span><b>Interna</b><small>Comunicación entre dependencias</small></span></label>
                </div>
                <x-sgdea.alert type="info" class="mt-2" title="Solicitudes PQRSDF">Las solicitudes PQRSDF se radican por este mismo formulario, normalmente como comunicaciones de <strong>entrada</strong>, e incluyen el correo del solicitante. La historia HU-GDO-03 no define tipos, plazos ni estados propios de PQRSDF: pendiente de definición.</x-sgdea.alert>
            </x-sgdea.card>

            <x-sgdea.card title="2. Número de radicado">
                <div class="radicado-box" id="rad-preview">DEMO-___-2026-E</div>
                <p class="small muted mt-1" style="margin-bottom:0">El sistema asigna el consecutivo anual al radicar y sella la fecha y hora. Estos datos no se pueden editar después. Valor mostrado solo como ejemplo.</p>
            </x-sgdea.card>

            <div class="grid grid-2">
                <x-sgdea.card title="3. Remitente">
                    <x-sgdea.field label="Nombre o razón social" name="datos_remitente[nombre]" id="rem-nombre" :required="true" />
                    <x-sgdea.field label="Documento de identificación" name="datos_remitente[identificacion]" id="rem-ident" />
                    <x-sgdea.field label="Correo o teléfono de contacto" name="datos_remitente[contacto]" id="rem-contacto" />
                </x-sgdea.card>
                <x-sgdea.card title="4. Destinatario">
                    <x-sgdea.field label="Nombre o razón social" name="datos_destinatario[nombre]" id="des-nombre" :required="true" />
                    <x-sgdea.field label="Documento de identificación" name="datos_destinatario[identificacion]" id="des-ident" />
                    <x-sgdea.field label="Correo o teléfono de contacto" name="datos_destinatario[contacto]" id="des-contacto" />
                </x-sgdea.card>
            </div>

            <x-sgdea.card title="5. Dependencia remitente o receptora">
                <div class="rule-note">La dependencia es una <strong>oficina productora</strong>: <span id="rad-dep-rol">receptora</span> de la comunicación. Se asocia automáticamente al usuario que radica (Radicado por: usuario con sesión iniciada) y puede ajustarse. Elija primero su unidad administrativa.</div>
                <div class="form-grid">
                    <x-sgdea.field label="Unidad administrativa" name="filtro_unidad_id" type="select" id="rad-unidad" :required="true" :options="$unidadOpciones" />
                    <x-sgdea.field label="Oficina productora" name="oficina_productora_id" type="select" id="rad-oficina" :required="true" :options="[]"
                        :attr="['data-parent' => 'rad-unidad', 'data-options-from' => 'opt-oficinas', 'data-empty-text' => 'No tiene oficinas productoras asociadas', 'data-guard' => '1']" />
                </div>
                <x-sgdea.alert type="info" data-guard-alert="rad-oficina" hidden>La unidad seleccionada no tiene oficinas productoras asociadas; no es posible radicar para ella hasta que se registre una oficina.</x-sgdea.alert>
            </x-sgdea.card>

            <x-sgdea.card title="6. Datos del documento">
                <div class="form-grid">
                    <x-sgdea.field label="Asunto" name="asunto" :required="true" wrap-class="span-2" />
                    <x-sgdea.field label="Fecha del documento" name="fecha_documento" type="date" :required="true" hint="Se conserva como fecha de producción del documento adjunto." />
                    <x-sgdea.field label="Radicado padre (si es una respuesta)" name="radicado_padre_id" type="select" :options="$radicadosPadre" placeholder="No aplica" />
                    <x-sgdea.field label="Cantidad de folios" name="cantidad_folios" type="number" min="0" />
                    <x-sgdea.field label="Cantidad de anexos" name="cantidad_anexos" type="number" min="0" />
                    <x-sgdea.field label="Correo del solicitante" name="correo_solicitante" type="email" wrap-class="span-2" hint="Correo de contacto de quien presenta la solicitud (por ejemplo, una PQRSDF)." />
                </div>
            </x-sgdea.card>

            <x-sgdea.card title="7. Archivo adjunto">
                <div class="dropzone">
                    <x-sgdea.icon name="upload" :size="28" />
                    <p style="margin:.4rem 0">Seleccione el documento radicado (vista previa visual, no se guarda).</p>
                    <input type="file" name="archivo" accept=".pdf,.tif,.tiff,.jpg,.jpeg,.png" data-file-preview="#rad-archivos" aria-label="Seleccionar archivo">
                    <p class="small muted" style="margin:.4rem 0 0">Formatos admitidos: PDF/A, TIFF, JPG y PNG.</p>
                </div>
                <ul class="file-list" id="rad-archivos"></ul>
            </x-sgdea.card>

            <div class="flex" style="justify-content:flex-end">
                <x-sgdea.button variant="outline" route="sgdea.radicaciones.index">Cancelar</x-sgdea.button>
                <x-sgdea.button type="submit" icon="check">Radicar (demostración)</x-sgdea.button>
            </div>
        </div>
    </form>

    @include('sgdea.partials.json-options', ['opciones' => ['oficinas' => $ccd['opciones']['oficinas']]])
@endsection

@push('scripts')
    <script src="{{ asset('sgdea/js/radicaciones.js') }}"></script>
@endpush
