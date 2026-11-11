<?php
/*
 | Presentador del Inventario FUID (solo transforma datos para la vista; sin consultas).
 | Recibe el encabezado y los registros tal como están en el formato FUID y devuelve:
 | registros enriquecidos (total de folios, observaciones de calidad), agrupación por cajas, resúmenes y totales.
 | Cada registro del FUID es una unidad de conservación (carpeta) dentro de una caja.
*/
return function (array $encabezado, array $registros): array {
    $folios = function (?string $t): array {
        if ($t === null || $t === '') { return [null, null]; }
        if (preg_match('/^\s*(\d+)\s*$/', $t, $m)) { return [(int) $m[1], null]; }
        if (preg_match('/^\s*(\d+)\s*-\s*(\d+)\s*(?:\((\d+)\))?\s*$/', $t, $m)) {
            $rango = (int) $m[2] - (int) $m[1] + 1;
            $declarado = isset($m[3]) && $m[3] !== '' ? (int) $m[3] : null;
            $aviso = ($declarado !== null && $declarado !== $rango) ? "El total declarado ($declarado) no coincide con el rango {$m[1]}-{$m[2]}, que tiene $rango folios." : null;
            return [$declarado ?? $rango, $aviso];
        }
        return [null, "No se pudo interpretar el número de folios «$t»."];
    };
    $out = [];
    $cajas = [];
    $porSerie = [];
    $porAnio = [];
    $series = [];
    $subseries = [];
    foreach ($registros as $i => $r) {
        $r['id'] = $i + 1;
        [$r['folios_total'], $aviso] = $folios($r['folios']);
        $r['alertas'] = [];
        if ($aviso) { $r['alertas'][] = $aviso; }
        if ($r['fecha_inicial'] && $r['fecha_final'] && $r['fecha_final'] < $r['fecha_inicial']) { $r['alertas'][] = 'La fecha final es anterior a la fecha inicial.'; }
        if (($r['folios_total'] ?? 0) > 200) { $r['alertas'][] = 'Supera el máximo de 200 folios por carpeta indicado en el formato.'; }
        $r['serie'] = $r['serie_codigo'] . '. ' . $r['serie_nombre'];
        $r['subserie'] = $r['subserie_codigo'] ? $r['subserie_codigo'] . '. ' . $r['subserie_nombre'] : null;
        $nombreRotulo = $r['nombre_unidad'] . ($r['correlativo'] && str_contains($r['correlativo'], '/') ? ' ' . $r['correlativo'] : '');
        $r['rotulo'] = [
            'carpeta' => $r['carpeta'], 'caja' => $r['caja'], 'folios' => $r['folios_total'] ?? '—',
            'codigo_dependencia' => $r['codigo_dependencia'], 'dependencia' => $r['dependencia'],
            'serie' => $r['codigo_dependencia'] . '.' . $r['serie_codigo'] . ' - ' . $r['serie_nombre'],
            'subserie' => $r['subserie_codigo'] ? $r['codigo_dependencia'] . '.' . $r['serie_codigo'] . '.' . $r['subserie_codigo'] . ' - ' . $r['subserie_nombre'] : '—',
            'nombre_carpeta' => $nombreRotulo, 'desde' => $r['fecha_inicial'], 'hasta' => $r['fecha_final'],
        ];
        $out[] = $r;

        $r['caja_key'] = $r['codigo_dependencia'] . '|' . ($r['caja'] ?? '—');
        $out[count($out) - 1]['caja_key'] = $r['caja_key'];
        $c = $r['caja_key'];
        $cajas[$c]['caja'] = $r['caja'] ?? '—';
        $cajas[$c]['caja_key'] = $c;
        $cajas[$c]['dependencia'] = $r['codigo_dependencia'] . ' · ' . $r['dependencia'];
        $cajas[$c]['codigo_dependencia'] = $r['codigo_dependencia'];
        $cajas[$c]['nombre_dependencia'] = $r['dependencia'];
        $cajas[$c]['carpetas'] = ($cajas[$c]['carpetas'] ?? 0) + 1;
        $cajas[$c]['folios'] = ($cajas[$c]['folios'] ?? 0) + ($r['folios_total'] ?? 0);
        if ($r['fecha_inicial']) { $cajas[$c]['fecha_inicial'] = isset($cajas[$c]['fecha_inicial']) ? min($cajas[$c]['fecha_inicial'], $r['fecha_inicial']) : $r['fecha_inicial']; }
        if ($r['fecha_final']) { $cajas[$c]['fecha_final'] = isset($cajas[$c]['fecha_final']) ? max($cajas[$c]['fecha_final'], $r['fecha_final']) : $r['fecha_final']; }
        $cajas[$c]['fecha_inicial'] = $cajas[$c]['fecha_inicial'] ?? null;
        $cajas[$c]['fecha_final'] = $cajas[$c]['fecha_final'] ?? null;
        $cajas[$c]['series'][$r['serie']] = $r['serie'];
        $cajas[$c]['contenido'][] = ['serie' => $r['serie'], 'subserie' => $r['subserie_codigo'] ? $r['codigo_dependencia'] . '.' . $r['serie_codigo'] . '-' . $r['subserie_codigo'] . ' ' . $r['subserie_nombre'] : '—',
            'carpeta' => 'CP' . $r['carpeta'], 'nombre' => $nombreRotulo];

        $k = $r['serie'] . '|' . ($r['subserie'] ?? '—');
        $porSerie[$k] = ['serie' => $r['serie'], 'subserie' => $r['subserie'] ?? '—', 'carpetas' => ($porSerie[$k]['carpetas'] ?? 0) + 1, 'folios' => ($porSerie[$k]['folios'] ?? 0) + ($r['folios_total'] ?? 0)];
        $a = (string) ($r['anio'] ?? 'Sin año');
        $porAnio[$a] = ['anio' => $a, 'carpetas' => ($porAnio[$a]['carpetas'] ?? 0) + 1, 'folios' => ($porAnio[$a]['folios'] ?? 0) + ($r['folios_total'] ?? 0)];
        $series[$r['serie_codigo']] = $r['serie'];
        if ($r['subserie_codigo']) { $subseries[$r['serie_codigo']][$r['subserie_codigo']] = ['value' => $r['subserie_codigo'], 'label' => $r['subserie']]; }
    }
    ksort($cajas); ksort($porAnio); ksort($series);
    foreach ($subseries as $k => $v) { $subseries[$k] = array_values($v); }
    $cajas = array_values(array_map(function ($c) { $c['series'] = array_values($c['series']); return $c; }, $cajas));
    $fi = array_filter(array_column($out, 'fecha_inicial')); $ff = array_filter(array_column($out, 'fecha_final'));
    return [
        'encabezado' => $encabezado, 'registros' => $out, 'cajas' => $cajas,
        'resumen_series' => array_values($porSerie), 'resumen_anios' => array_values($porAnio),
        'series' => $series, 'subseries_por_serie' => $subseries, 'fases' => ['Gestión', 'Central', 'Histórico'],
        'totales' => ['registros' => count($out), 'cajas' => count($cajas), 'carpetas' => count($out), 'folios' => array_sum(array_column($out, 'folios_total')),
            'fecha_inicial' => $fi ? min($fi) : null, 'fecha_final' => $ff ? max($ff) : null,
            'con_alertas' => count(array_filter($out, fn ($r) => count($r['alertas'])))],
    ];
};
