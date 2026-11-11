{{-- Imprime las opciones de selectores dependientes como JSON (ids opt-*). Recibe $opciones (nombre => datos). --}}
@foreach ($opciones as $nombre => $datos)
    <script type="application/json" id="opt-{{ $nombre }}">{!! json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endforeach
