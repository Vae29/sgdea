{{-- Rótulo de carpeta (SOLO VISUAL), según el formato institucional. Se llena por JS con los datos de #carpeta-data. --}}
<x-sgdea.modal id="modal-carpeta-rotulo" title="Rótulo de carpeta" size="md">
    <div class="rotulo" style="text-align:center">
        <div class="flex between" style="align-items:flex-start">
            <img src="{{ asset('sgdea/img/logo-evc.png') }}" alt="EVC E.S.P." style="height:46px">
            <dl class="dl" style="grid-template-columns:90px 1fr;text-align:left;font-weight:700;font-size:.8rem">
                <dt>CARPETA Nº</dt><dd data-rot="carpeta"></dd><dt>CAJA Nº</dt><dd data-rot="caja"></dd><dt>FOLIOS Nº</dt><dd data-rot="folios"></dd>
            </dl>
        </div>
        <p class="small" style="font-weight:700;margin:.8rem 0 0">EMPRESAS VARIAS DE CAICEDONIA VALLE EVC-ESP<br>CAICEDONIA - VALLE<br>NIT: 821.001.448-9<br>CREADO POR ACUERDO 031/98 DEL CONCEJO MUNICIPAL</p>
        <h4 style="margin:.8rem 0">ARCHIVO</h4>
        <dl class="dl" style="grid-template-columns:150px 1fr;text-align:left;font-size:.82rem">
            <dt><b>CÓDIGO DE DEPENDENCIA</b></dt><dd data-rot="codigo_dependencia"></dd>
            <dt><b>DEPENDENCIA</b></dt><dd data-rot="dependencia"></dd>
            <dt><b>SERIE DOCUMENTAL</b></dt><dd data-rot="serie"></dd>
            <dt><b>SUBSERIE DOCUMENTAL</b></dt><dd data-rot="subserie"></dd>
            <dt><b>NOMBRE CARPETA</b></dt><dd data-rot="nombre_carpeta"></dd>
            <dt><b>DESDE</b></dt><dd data-rot="desde"></dd>
            <dt><b>HASTA</b></dt><dd data-rot="hasta"></dd>
        </dl>
    </div>
    <x-slot:footer>
        <x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button>
        <x-sgdea.button icon="download" data-demo-toast="Demostración: la impresión del rótulo en PDF está pendiente del backend." data-toast-type="warning">Imprimir / PDF</x-sgdea.button>
    </x-slot:footer>
</x-sgdea.modal>
