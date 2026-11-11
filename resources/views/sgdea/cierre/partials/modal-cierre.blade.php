{{-- Confirmación visual de cierre de carpeta. El texto de la carpeta se completa por JS. --}}
<x-sgdea.modal id="modal-cierre" title="Cerrar carpeta y declarar documento electrónico de archivo" size="md">
    <p>Va a cerrar la carpeta <strong id="cierre-nombre">—</strong>.</p>
    <x-sgdea.alert type="warning" title="Advertencia: acción inalterable">
        Después del cierre nadie, ni siquiera un administrador, podrá subir documentos, editar metadatos ni eliminar registros de esta carpeta.
    </x-sgdea.alert>
    <p class="small">Al confirmar, el sistema cambiará el estado a «Expediente de Archivo (Cerrado)», registrará la fecha de cierre (fecha extrema final), calculará la fecha límite de transferencia según la TRD (inicio del conteo de retención), sellará el índice electrónico definitivo con su huella SHA-256 y dejará constancia automática en la bitácora de auditoría.</p>
    <label class="check"><input type="checkbox" id="cierre-ack"> Entiendo que el cierre no se puede deshacer.</label>
    <x-slot:footer>
        <x-sgdea.button variant="outline" data-modal-close>Cancelar</x-sgdea.button>
        <x-sgdea.button variant="danger" id="cierre-ok" icon="lock" disabled data-demo-toast="Demostración: la carpeta no fue cerrada. El cierre y el sellado del índice se harán en el backend." data-toast-type="warning">Confirmar cierre</x-sgdea.button>
    </x-slot:footer>
</x-sgdea.modal>
