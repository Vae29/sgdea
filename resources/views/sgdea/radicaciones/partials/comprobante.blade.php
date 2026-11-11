{{-- Rótulo digital de radicación (SOLO VISUAL). Se llena por JS con los datos de #rad-data. --}}
<x-sgdea.modal id="modal-rad-comprobante" title="Rótulo de radicación" size="md">
    <div class="rotulo">
        <div class="flex between">
            <img src="{{ asset('sgdea/img/logo-evc.png') }}" alt="EVC E.S.P." style="height:42px">
            <span class="badge badge-demo no-dot">DEMOSTRACIÓN</span>
        </div>
        <h4 class="mt-1">COMPROBANTE DE RADICACIÓN</h4>
        <div class="flex" style="align-items:flex-start">
            <dl class="dl" style="grid-template-columns:110px 1fr;flex:1">
                <dt>Radicado</dt><dd><strong class="mono" data-rot="numero_radicado"></strong></dd>
                <dt>Fecha y hora</dt><dd data-rot="fecha_hora"></dd>
                <dt>Folios / anexos</dt><dd><span data-rot="folios"></span> / <span data-rot="anexos"></span></dd>
                <dt>Remitente</dt><dd data-rot="remitente"></dd>
                <dt>Asunto</dt><dd data-rot="asunto"></dd>
            </dl>
            <div class="qr">QR / código de barras (demo)</div>
        </div>
    </div>
    <x-slot:footer>
        <x-sgdea.button variant="outline" data-modal-close>Cerrar</x-sgdea.button>
        <x-sgdea.button icon="download" data-demo-toast="Demostración: la generación del PDF imprimible está pendiente del backend." data-toast-type="warning">Descargar PDF</x-sgdea.button>
    </x-slot:footer>
</x-sgdea.modal>
