{{-- Nodo recursivo del árbol del CCD. Recibe $nodo (ver resources/sgdea/presenters/ccd.php) y $abierto. --}}
@php
    $iconos = ['fondo' => 'archive', 'unidad' => 'sitemap', 'oficina' => 'home', 'serie' => 'folder', 'subserie' => 'layers', 'tipo' => 'file'];
    $sinOficina = $nodo['sin_oficina'] ?? [];
    $sinOficinaTexto = 'Oficina productora no especificada en el CCD';
    $esUnidad = $nodo['nivel'] === 'unidad';
    $tieneHijos = count($nodo['hijos']) > 0 || ($esUnidad && is_array($sinOficina) && count($sinOficina) > 0);
    $expandible = $tieneHijos || !empty($nodo['vacio']);
@endphp
<li data-level="{{ $nodo['nivel'] }}">
    <div class="tree-row">
        @if ($expandible)
            <button type="button" class="tree-toggle" aria-expanded="{{ $abierto ? 'true' : 'false' }}" aria-label="Expandir o contraer"><x-sgdea.icon name="chevron-right" :size="14" /></button>
        @else
            <span class="tree-spacer"></span>
        @endif
        <button type="button" class="tree-btn" data-node-key="{{ $nodo['key'] }}">
            <x-sgdea.icon :name="$iconos[$nodo['nivel']]" :size="16" />
            @if ($nodo['codigo'])<span class="code">{{ $nodo['codigo'] }}</span>@endif
            <span class="name">{{ $nodo['nombre'] }}</span>
            @if ($nodo['nivel'] === 'serie' && ($nodo['sin_oficina'] ?? false))<span class="tree-flag" title="{{ $sinOficinaTexto }}">Oficina no especificada</span>@endif
            @if ($nodo['resumen'])<span class="count">{{ $nodo['resumen'] }}</span>@endif
        </button>
    </div>
    @if ($expandible)
        <ul @unless ($abierto) hidden @endunless>
            @foreach ($nodo['hijos'] as $hijo)
                @include('sgdea.ccd.partials.tree-node', ['nodo' => $hijo, 'abierto' => false])
            @endforeach
            @if (!empty($nodo['vacio']))
                <li class="tree-empty"><x-sgdea.icon name="info" :size="15" />{{ $nodo['vacio'] }}</li>
            @endif
            @if ($esUnidad && is_array($sinOficina) && count($sinOficina))
                <li class="tree-note"><x-sgdea.icon name="info" :size="14" />{{ $sinOficinaTexto }} · {{ count($sinOficina) }} serie(s) del CCD oficial</li>
                @foreach ($sinOficina as $s)
                    @include('sgdea.ccd.partials.tree-node', ['nodo' => $s, 'abierto' => false])
                @endforeach
            @endif
        </ul>
    @endif
</li>
