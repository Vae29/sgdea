{{-- Rótulo de caja (SOLO VISUAL), según el formato institucional. Se llena por JS con los datos de #caja-data. --}}
<x-sgdea.modal id="modal-caja-rotulo" title="Rótulo de caja" size="lg">
    <div class="rotulo-caja">
        <div class="rc-head" style="grid-template-columns:130px 1fr 150px">
            <div><img src="{{ asset('sgdea/img/logo-evc.png') }}" alt="EVC E.S.P." style="height:40px"></div>
            <div style="text-align:center"><strong>PROCESO: GESTIÓN DOCUMENTAL Y ARCHIVO</strong><br><strong>FORMATO: RÓTULO DE CAJA</strong></div>
            <div style="font-size:.74rem">VERSIÓN: <b>3</b><br>PÁGINA: <b>1 de 1</b><br>VIGENTE DESDE: <b>2/02/2026</b></div>
        </div>
        <div class="rc-band" style="font-size:1rem">CAJA N°: <span data-rc="caja"></span></div>
        <div class="rc-row"><span><b>DEPENDENCIA:</b> <span data-rc="nombre_dependencia"></span></span><span><b>CÓDIGO:</b> <span data-rc="codigo_dependencia"></span></span></div>
        <div class="rc-band">CONTENIDO</div>
        <div style="max-height:260px;overflow:auto">
            <table><thead><tr><th>COD Y NOMBRE SERIE</th><th>COD Y NOMBRE SUBSERIE</th><th># CARP</th><th>NOMBRE DE LA CARPETA</th></tr></thead><tbody id="rc-filas"></tbody></table>
        </div>
        <div class="rc-band">FECHAS EXTREMAS</div>
        <div class="rc-row"><span>Inicial: <b data-rc="fecha_inicial"></b></span><span>Final: <b data-rc="fecha_final"></b></span></div>
        <div class="rc-row"><span><b>TOTAL DE UNIDADES ALMACENADAS:</b> <span data-rc="carpetas"></span> CARPETAS</span></div>
        <div class="rc-band">UBICACIÓN TOPOGRÁFICA EN EL ARCHIVO CENTRAL</div>
        <div class="rc-row"><span>NÚMERO CONSECUTIVO DE CAJA ARCHIVO CENTRAL: <span class="line"></span></span><span>ESTANTE: <span class="line"></span></span><span>ENTREPAÑO: <span class="line"></span></span></div>
    </div>
    <p class="small muted mt-1" style="margin-bottom:0">La ubicación topográfica se diligencia al transferir la caja; el inventario actual no trae esos datos.</p>
    <x-slot:footer>
        <x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button>
        <x-sgdea.button icon="download" data-demo-toast="Demostración: la impresión del rótulo en PDF está pendiente del backend." data-toast-type="warning">Imprimir / PDF</x-sgdea.button>
    </x-slot:footer>
</x-sgdea.modal>
