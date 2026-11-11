{{--
  Módulo 5 · Carpetas y expedientes — Apertura (SOLO VISUAL).
  Variables del futuro controlador: $unidades, $cajas (opcional). Campos coherentes con carpetas_archivo.
  El número de folios, el índice y el usuario creador los calcula/registra el backend.
--}}
@extends('sgdea.layouts.app')
@section('title', 'Nueva carpeta o expediente')
@section('subtitle', 'Apertura vinculada a la oficina productora, la serie y la subserie')
@section('module', 'carpetas')

@php
    $demoCcd = require resource_path('sgdea/demo/ccd.php');
    $unidades = $unidades ?? $demoCcd['unidades'];
    $ccd = (require resource_path('sgdea/presenters/ccd.php'))($demoCcd['fondo'], $unidades);
    $unidadOpciones = collect($unidades)->mapWithKeys(fn ($u) => ['u:' . $u['codigo'] => $u['codigo'] . ' · ' . $u['nombre']])->all();
    $cajas = $cajas ?? ['001' => 'Caja 001 — Contabilidad (2026)'];
@endphp

@section('content')
    <x-sgdea.page-header><x-slot:actions><x-sgdea.button variant="outline" icon="arrow-left" route="sgdea.carpetas.index">Volver al listado</x-sgdea.button></x-slot:actions></x-sgdea.page-header>

    <form id="form-carpeta" method="POST" action="#" data-demo-form data-demo-message="Demostración: la carpeta no fue creada. La apertura se registrará en el backend." novalidate>
        @csrf
        <div class="grid">
            <x-sgdea.card title="1. Clasificación documental">
                <div class="rule-note">La carpeta se vincula a una <strong>oficina productora</strong> y a una <strong>serie</strong> (y subserie si corresponde). Hereda la retención de la TRD vigente.</div>
                <div class="form-grid">
                    <x-sgdea.field label="Unidad administrativa" name="filtro_unidad_id" type="select" id="car-unidad" :required="true" :options="$unidadOpciones" />
                    <x-sgdea.field label="Oficina productora" name="oficina_productora_id" type="select" id="car-oficina" :required="true" :options="[]"
                        :attr="['data-parent' => 'car-unidad', 'data-options-from' => 'opt-oficinas-ext', 'data-empty-text' => 'No tiene oficinas productoras asociadas', 'data-guard' => '1']" />
                    <x-sgdea.field label="Serie documental" name="serie_id" type="select" id="car-serie" :required="true" :options="[]"
                        :attr="['data-parent' => 'car-oficina', 'data-options-from' => 'opt-series', 'data-empty-text' => 'No tiene series documentales asociadas', 'data-guard' => '1']" />
                    <x-sgdea.field label="Subserie documental (si corresponde)" name="subserie_id" type="select" id="car-subserie" :options="[]"
                        :attr="['data-parent' => 'car-serie', 'data-options-from' => 'opt-subseries', 'data-empty-text' => 'Esta serie no tiene subseries']" />
                </div>
                <p class="small muted" style="margin:.5rem 0 0">Las series con «Oficina productora no especificada en el CCD» se conservan del CCD oficial. Como el modelo de datos actual exige una oficina productora para guardar, ese caso queda pendiente de confirmar.</p>
                <x-sgdea.alert type="info" data-guard-alert="car-oficina" hidden>La unidad seleccionada no tiene oficinas productoras asociadas.</x-sgdea.alert>
                <x-sgdea.alert type="info" data-guard-alert="car-serie" hidden>La oficina seleccionada no tiene series documentales asociadas.</x-sgdea.alert>
                <p class="small muted" style="margin:0">Retención heredada: <strong>sin parametrizar</strong> mientras la TRD no tenga años de retención ni disposición final.</p>
            </x-sgdea.card>

            <x-sgdea.card title="2. Identificación de la carpeta">
                <div class="form-grid">
                    <x-sgdea.field label="Número de carpeta" name="numero_asignado" :required="true" hint="Identificador único, como aparece en el rótulo (ejemplo: CP1)." />
                    <x-sgdea.field label="Año" name="anio" type="number" min="2000" :required="true" />
                    <x-sgdea.field label="Nombre o asunto del trámite" name="nombre_carpeta" :required="true" wrap-class="span-2" />
                    <x-sgdea.field label="Fecha de apertura" name="fecha_apertura" type="date" :required="true" />
                    <x-sgdea.field label="Fecha inicial (desde)" name="fecha_inicial" type="date" />
                    <x-sgdea.field label="Soporte" name="tipo_soporte_id" type="select" :required="true" :options="['Físico' => 'Físico', 'Electrónico' => 'Electrónico', 'Híbrido' => 'Híbrido (parte física y parte electrónica)']" />
                    <x-sgdea.field label="Nivel de acceso" name="nivel_acceso" type="select" :required="true" :options="['publica' => 'Pública', 'clasificada' => 'Clasificada', 'reservada' => 'Reservada']" />
                    <x-sgdea.field label="Fase del archivo" name="fase_archivo" type="select" :required="true" :options="['Archivo de gestión' => 'Archivo de gestión', 'Archivo central' => 'Archivo central']" />
                    <x-sgdea.field label="Caja de almacenamiento (opcional)" name="caja_almacenamiento_id" type="select" :options="$cajas" placeholder="Sin caja asignada" />
                </div>
            </x-sgdea.card>

            <div class="flex" style="justify-content:flex-end">
                <x-sgdea.button variant="outline" route="sgdea.carpetas.index">Cancelar</x-sgdea.button>
                <x-sgdea.button type="submit" icon="check">Abrir carpeta (demostración)</x-sgdea.button>
            </div>
        </div>
    </form>
    @include('sgdea.partials.json-options', ['opciones' => ['oficinas-ext' => $ccd['opciones']['oficinas_ext'], 'series' => $ccd['opciones']['series'], 'subseries' => $ccd['opciones']['subseries']]])
@endsection
