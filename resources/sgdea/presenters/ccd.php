<?php
/*
 | Presentador del módulo CCD (SOLO transforma datos para la vista; no consulta la base de datos).
 | Estructura oficial del CCD de la empresa:
 |   Fondo → Unidad administrativa → Oficina productora → Serie → Subserie → Tipo documental
 | Excepción conservada del CCD oficial: algunas series figuran bajo la unidad con el código de oficina productora vacío.
 | Esas series NO se descartan ni se les inventa oficina: se marcan como "Oficina productora no especificada en el CCD".
 | Llaves: unidad 'u:10' · oficina 'o:10:12' · serie 's:10:12:17' (sin oficina: 's:10:-:17') · centinela de "oficina no especificada": 'sin:u:10'.
 | Reglas que NO cambian: las series nuevas se vinculan siempre a una oficina productora (modelo de datos actual).
*/
return function (array $fondo, array $unidades): array {
    $SIN = 'Oficina productora no especificada en el CCD';
    $nodos = [];
    $opc = ['unidades' => [], 'oficinas' => [], 'oficinas_ext' => [], 'series' => [], 'subseries' => [], 'tipos' => []];
    $tablas = ['unidades' => [], 'oficinas' => [], 'series' => [], 'subseries' => [], 'tipos' => []];
    $soportes = [];
    $fk = 'f';
    $ret = fn ($r) => $r ?? ['anios_gestion' => null, 'anios_central' => null, 'disposicion_final' => null, 'procedimiento' => null];
    $deriva = function (?string $s): array {
        $t = mb_strtolower((string) $s);
        $fis = str_contains($t, 'papel') || str_contains($t, 'físic');
        $ele = str_contains($t, 'electr');
        $tipo = ($fis && $ele) ? 'Híbrido' : ($fis ? 'Físico' : ($ele ? 'Electrónico' : null));
        $fmt = preg_match('/\(([^)]+)\)/', (string) $s, $m) ? rtrim(trim($m[1]), '.') : null;
        return [$tipo, $fmt];
    };

    $nodos[$fk] = ['nivel' => 'fondo', 'codigo' => $fondo['codigo'], 'nombre' => $fondo['nombre'], 'activo' => $fondo['activo'], 'ruta' => [],
        'hijos' => count($unidades), 'hijos_label' => 'unidades administrativas', 'ids' => ['fondo' => $fk]];
    $opc['unidades'][$fk] = [];

    /* Construye nodo, filas, opciones y árbol de una serie (con o sin oficina) */
    $fondoNombre = $fondo['nombre'];
    $serie = function (array $u, ?array $o, array $s) use (&$nodos, &$opc, &$tablas, &$soportes, $fk, $ret, $deriva, $SIN, $fondoNombre) {
        $uk = 'u:' . $u['codigo'];
        $ok = $o ? 'o:' . $u['codigo'] . ':' . $o['codigo'] : 'sin:' . $uk;
        $sk = 's:' . $u['codigo'] . ':' . ($o ? $o['codigo'] : '-') . ':' . $s['codigo'];
        $ofLabel = $o ? $o['codigo'] . ' · ' . $o['nombre'] : $SIN;
        $uLabel = $u['codigo'] . ' · ' . $u['nombre'];
        $ruta = $o ? [$u['nombre'], $o['nombre']] : [$u['nombre']];
        $ruta = array_merge([$fondoNombre], $ruta);
        $opc['series'][$ok][] = ['value' => $sk, 'label' => $s['codigo'] . ' · ' . $s['nombre']];
        $opc['subseries'][$sk] = [];
        $opc['tipos'][$sk] = [];
        $idsBase = ['fondo' => $fk, 'unidad' => $uk, 'oficina' => $ok];
        $nodos[$sk] = ['nivel' => 'serie', 'codigo' => $s['codigo'], 'nombre' => $s['nombre'], 'activo' => $s['activo'] ?? true, 'ruta' => $ruta,
            'hijos' => count($s['subseries']), 'hijos_label' => 'subseries documentales', 'retencion' => $ret($s['retencion'] ?? null), 'tipos' => $s['tipos'] ?? [],
            'oficina_no_especificada' => $o === null, 'ids' => $idsBase + ['serie' => $sk]];
        $tablas['series'][] = ['key' => $sk, 'codigo' => $s['codigo'], 'nombre' => $s['nombre'], 'oficina' => $ofLabel, 'unidad' => $uLabel,
            'subseries' => count($s['subseries']), 'activo' => $s['activo'] ?? true, 'sin_oficina' => $o === null];
        $mkTipo = function (string $tk, array $t, array $rutaT, array $ids, ?string $subLabel, ?string $subKey) use (&$nodos, &$opc, &$tablas, &$soportes, $deriva, $sk, $s, $ofLabel, $o) {
            if ($t['soporte'] !== '') { $soportes[$t['soporte']] = $t['soporte']; }
            [$tipoSop, $fmt] = $deriva($t['soporte']);
            $nodos[$tk] = ['nivel' => 'tipo', 'codigo' => null, 'nombre' => $t['nombre'], 'activo' => true, 'soporte' => $t['soporte'], 'soporte_tipo' => $tipoSop, 'formato' => $fmt,
                'ruta' => $rutaT, 'hijos' => 0, 'ids' => $ids, 'oficina_no_especificada' => $o === null];
            $opc['tipos'][$sk][] = ['value' => $tk, 'label' => ($subLabel ? $subLabel . ' · ' : '') . $t['nombre']];
            $tablas['tipos'][] = ['key' => $tk, 'nombre' => $t['nombre'], 'serie' => $s['codigo'] . ' · ' . $s['nombre'], 'subserie' => $subLabel ?? '—',
                'oficina' => $ofLabel, 'soporte' => $t['soporte'], 'activo' => true];
        };
        foreach ($s['tipos'] ?? [] as $i => $t) {
            $mkTipo('t:' . $sk . ':' . $i, $t, array_merge($ruta, [$s['nombre']]), $idsBase + ['serie' => $sk], null, null);
        }
        foreach ($s['subseries'] as $b) {
            $bk = 'b:' . $u['codigo'] . ':' . ($o ? $o['codigo'] : '-') . ':' . $s['codigo'] . ':' . $b['codigo'];
            $opc['subseries'][$sk][] = ['value' => $bk, 'label' => $b['codigo'] . ' · ' . $b['nombre']];
            $rutaB = array_merge($ruta, [$s['nombre']]);
            $nodos[$bk] = ['nivel' => 'subserie', 'codigo' => $b['codigo'], 'nombre' => $b['nombre'], 'activo' => true, 'ruta' => $rutaB,
                'hijos' => count($b['tipos']), 'hijos_label' => 'tipos documentales', 'retencion' => $ret($b['retencion'] ?? null), 'tipos' => $b['tipos'],
                'oficina_no_especificada' => $o === null, 'ids' => $idsBase + ['serie' => $sk, 'subserie' => $bk]];
            $tablas['subseries'][] = ['key' => $bk, 'codigo' => $b['codigo'], 'nombre' => $b['nombre'], 'serie' => $s['codigo'] . ' · ' . $s['nombre'],
                'oficina' => $ofLabel, 'tipos' => count($b['tipos']), 'activo' => true, 'sin_oficina' => $o === null];
            foreach ($b['tipos'] as $i => $t) {
                $mkTipo('t:' . $bk . ':' . $i, $t, array_merge($rutaB, [$b['nombre']]), $idsBase + ['serie' => $sk, 'subserie' => $bk], $b['codigo'], $bk);
            }
        }
        return $sk;
    };

    foreach ($unidades as $u) {
        $uk = 'u:' . $u['codigo'];
        $sinSeries = $u['series_sin_oficina'] ?? [];
        $opc['unidades'][$fk][] = ['value' => $uk, 'label' => $u['codigo'] . ' · ' . $u['nombre']];
        $opc['oficinas'][$uk] = [];
        $opc['oficinas_ext'][$uk] = [];
        $nodos[$uk] = ['nivel' => 'unidad', 'codigo' => $u['codigo'], 'nombre' => $u['nombre'], 'activo' => $u['activo'], 'ruta' => [$fondo['nombre']],
            'hijos' => count($u['oficinas']), 'hijos_label' => 'oficinas productoras', 'sin_oficinas' => count($u['oficinas']) === 0,
            'series_sin_oficina' => count($sinSeries), 'ids' => ['fondo' => $fk, 'unidad' => $uk]];
        $tablas['unidades'][] = ['key' => $uk, 'codigo' => $u['codigo'], 'nombre' => $u['nombre'], 'fondo' => $fondo['nombre'],
            'oficinas' => count($u['oficinas']), 'series_sin_oficina' => count($sinSeries), 'activo' => $u['activo']];

        $arbolOf = [];
        foreach ($u['oficinas'] as $o) {
            $ok = 'o:' . $u['codigo'] . ':' . $o['codigo'];
            $opt = ['value' => $ok, 'label' => $o['codigo'] . ' · ' . $o['nombre']];
            $opc['oficinas'][$uk][] = $opt;
            $opc['oficinas_ext'][$uk][] = $opt;
            $opc['series'][$ok] = [];
            $nodos[$ok] = ['nivel' => 'oficina', 'codigo' => $o['codigo'], 'nombre' => $o['nombre'], 'activo' => $o['activo'], 'ruta' => [$fondo['nombre'], $u['nombre']],
                'hijos' => count($o['series']), 'hijos_label' => 'series documentales', 'ids' => ['fondo' => $fk, 'unidad' => $uk, 'oficina' => $ok]];
            $tablas['oficinas'][] = ['key' => $ok, 'codigo' => $o['codigo'], 'nombre' => $o['nombre'], 'unidad' => $u['codigo'] . ' · ' . $u['nombre'],
                'series' => count($o['series']), 'activo' => $o['activo']];
            $arbolSeries = [];
            foreach ($o['series'] as $s) {
                $arbolSeries[] = ['s' => $s, 'o' => $o];
            }
            $arbolOf[] = ['o' => $o, 'ok' => $ok, 'series' => $arbolSeries];
        }
        if ($sinSeries) {
            $opc['oficinas_ext'][$uk][] = ['value' => 'sin:' . $uk, 'label' => $SIN];
            $opc['series']['sin:' . $uk] = [];
        }

        /* Construcción de series (nodos/tablas/opciones) y árbol anidado */
        $mk = fn ($key, $nivel, $codigo, $nombre, $resumen, $hijos, $extra = []) => ['key' => $key, 'nivel' => $nivel, 'codigo' => $codigo, 'nombre' => $nombre, 'resumen' => $resumen, 'hijos' => $hijos] + $extra;
        $tiposNodos = function (string $pk, array $tipos) use ($mk) {
            $out = [];
            foreach ($tipos as $i => $t) { $out[] = $mk('t:' . $pk . ':' . $i, 'tipo', null, $t['nombre'], '', []); }
            return $out;
        };
        $arbolSerie = function (array $u, ?array $o, array $s, string $sk) use ($mk, $tiposNodos) {
            $pre = 'b:' . $u['codigo'] . ':' . ($o ? $o['codigo'] : '-') . ':' . $s['codigo'] . ':';
            $hijos = [];
            foreach ($s['subseries'] as $b) {
                $hijos[] = $mk($pre . $b['codigo'], 'subserie', $b['codigo'], $b['nombre'], count($b['tipos']) ? count($b['tipos']) . ' tipos' : '', $tiposNodos($pre . $b['codigo'], $b['tipos']));
            }
            $hijos = array_merge($hijos, $tiposNodos($sk, $s['tipos'] ?? []));
            return $mk($sk, 'serie', $s['codigo'], $s['nombre'], count($s['subseries']) ? count($s['subseries']) . ' subseries' : '', $hijos, ['sin_oficina' => $o === null]);
        };
        $ofNodos = [];
        foreach ($arbolOf as $a) {
            $ses = [];
            foreach ($a['series'] as $x) { $sk = $serie($u, $a['o'], $x['s']); $ses[] = $arbolSerie($u, $a['o'], $x['s'], $sk); }
            $ofNodos[] = $mk($a['ok'], 'oficina', $a['o']['codigo'], $a['o']['nombre'], count($ses) . ' series', $ses);
        }
        $sinNodos = [];
        foreach ($sinSeries as $s) { $sk = $serie($u, null, $s); $sinNodos[] = $arbolSerie($u, null, $s, $sk); }
        $unidadNodos[] = $mk($uk, 'unidad', $u['codigo'], $u['nombre'], count($ofNodos) . ' oficinas' . ($sinNodos ? ' · ' . count($sinNodos) . ' series sin oficina' : ''), $ofNodos,
            ['vacio' => count($ofNodos) === 0 ? 'No tiene oficinas productoras asociadas' : null, 'sin_oficina' => $sinNodos]);
    }
    $arbol = ['key' => $fk, 'nivel' => 'fondo', 'codigo' => $fondo['codigo'], 'nombre' => $fondo['nombre'], 'resumen' => count($unidadNodos ?? []) . ' unidades', 'hijos' => $unidadNodos ?? [], 'vacio' => null];

    return ['nodos' => $nodos, 'opciones' => $opc, 'tablas' => $tablas, 'soportes' => array_values($soportes), 'arbol' => $arbol, 'sin_oficina_texto' => $SIN,
        'totales' => ['series_sin_oficina' => array_sum(array_column($tablas['unidades'], 'series_sin_oficina'))]];
};
