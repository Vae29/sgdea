{{-- Índice documental de una carpeta. Recibe $carpeta (con 'indice'). Provisional si está abierta; definitivo y sellado si está cerrada. --}}
@php $cerrada = $carpeta['estado'] === 'Cerrada'; @endphp
<div class="flex between flex-wrap mb-2">
    <div>
        @if ($cerrada)
            <x-sgdea.badge tone="dark" label="Índice definitivo sellado" />
            <span class="small muted">Sellado el {{ $carpeta['indice_sellado'] }}</span>
        @else
            <x-sgdea.badge tone="info" label="Índice provisional" />
            <span class="small muted">Se sella de forma definitiva al cerrar la carpeta.</span>
        @endif
    </div>
    <div class="flex">
        <x-sgdea.button variant="outline" size="sm" icon="download" data-demo-toast="Demostración: la exportación a PDF/A está pendiente del backend." data-toast-type="warning">Exportar PDF/A</x-sgdea.button>
        <x-sgdea.button variant="outline" size="sm" icon="download" data-demo-toast="Demostración: la exportación a JSON está pendiente del backend." data-toast-type="warning">Exportar JSON</x-sgdea.button>
    </div>
</div>
<x-sgdea.table :id="'tbl-indice-' . $carpeta['id']" :searchable="false" :cols="6" empty-text="Esta carpeta no tiene documentos digitales en su índice.">
    <x-slot:head><tr><th>Posición</th><th>Tipo documental</th><th>Fecha de incorporación</th><th>Folios</th><th>Tamaño</th><th>Huella SHA-256</th></tr></x-slot:head>
    @foreach ($carpeta['indice'] as $r)
        <tr><td>{{ $r['posicion'] }}</td><td>{{ $r['tipo_documental'] }}<div class="small muted">{{ $r['titulo'] }}</div></td><td class="nowrap">{{ $r['fecha_incorporacion'] }}</td>
            <td class="nowrap">{{ $r['folios'] }}</td><td class="nowrap">{{ $r['tamano'] }}</td><td class="mono small" title="{{ $r['hash_sha256'] }}">{{ substr($r['hash_sha256'], 0, 16) }}…</td></tr>
    @endforeach
    @if (!count($carpeta['indice']))<tr><td colspan="6" class="muted">Esta carpeta no tiene documentos digitales en su índice. @if ($carpeta['soporte'] === 'Físico')Es una carpeta física; su contenido se inventaría en el FUID.@endif</td></tr>@endif
</x-sgdea.table>
