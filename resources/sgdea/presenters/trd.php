<?php
/*
 | Presentador del módulo TRD (solo transforma datos para la vista; sin consultas). Módulo GENERAL: recorre todas las
 | unidades administrativas y oficinas productoras del CCD (TRD_30 es solo un ejemplo del formato, no un alcance).
 | La retención se asocia a una SERIE (si no tiene subseries) o a una SUBSERIE. Incluye las series cuyo CCD no especifica oficina.
 | Los valores no definidos se muestran como "Sin parametrizar". Los códigos siguen la notación del formato TRD: 30.08 (serie) y 30.08-02 (subserie).
*/
return function (array $unidades): array {
    $SIN = 'Oficina productora no especificada en el CCD';
    $filas = [];
    $agregar = function (array $u, ?array $o, array $s) use (&$filas, $SIN) {
        $uk = 'u:' . $u['codigo'];
        $ok = $o ? 'o:' . $u['codigo'] . ':' . $o['codigo'] : 'sin:' . $uk;
        $sk = 's:' . $u['codigo'] . ':' . ($o ? $o['codigo'] : '-') . ':' . $s['codigo'];
        $prefijo = $o ? $o['codigo'] : $u['codigo'];
        $base = ['unidad_key' => $uk, 'oficina_key' => $ok, 'serie_key' => $sk, 'sin_oficina' => $o === null,
            'unidad' => $u['codigo'] . ' · ' . $u['nombre'], 'oficina' => $o ? $o['codigo'] . ' · ' . $o['nombre'] : $SIN,
            'serie' => $s['codigo'] . ' · ' . $s['nombre']];
        $items = [];
        if (count($s['subseries'])) {
            foreach ($s['subseries'] as $b) {
                $items[] = ['aplica' => 'Subserie', 'codigo' => $prefijo . '.' . $s['codigo'] . '-' . $b['codigo'], 'subserie_key' => 'b:' . $u['codigo'] . ':' . ($o ? $o['codigo'] : '-') . ':' . $s['codigo'] . ':' . $b['codigo'],
                    'subserie' => $b['codigo'] . ' · ' . $b['nombre'], 'retencion' => $b['retencion'] ?? [], 'tipos' => $b['tipos']];
            }
        } else {
            $items[] = ['aplica' => 'Serie', 'codigo' => $prefijo . '.' . $s['codigo'], 'subserie_key' => null, 'subserie' => null, 'retencion' => $s['retencion'] ?? [], 'tipos' => $s['tipos'] ?? []];
        }
        foreach ($items as $it) {
            $r = $it['retencion'];
            $disp = $r['disposicion_final'] ?? null;
            $param = ($r['anios_gestion'] ?? null) !== null || ($r['anios_central'] ?? null) !== null || !empty($disp);
            $soportes = array_values(array_unique(array_filter(array_column($it['tipos'], 'soporte'))));
            $filas[] = array_merge($base, [
                'aplica' => $it['aplica'], 'codigo' => $it['codigo'], 'subserie_key' => $it['subserie_key'], 'subserie' => $it['subserie'],
                'tipos' => array_column($it['tipos'], 'nombre'), 'soportes' => $soportes,
                'anios_gestion' => $r['anios_gestion'] ?? null, 'anios_central' => $r['anios_central'] ?? null,
                'disposicion_final' => $disp ?: [], 'procedimiento' => $r['procedimiento'] ?? null, 'parametrizada' => $param,
                'fuente' => $param ? 'CCD oficial' : null,
            ]);
        }
    };
    foreach ($unidades as $u) {
        foreach ($u['oficinas'] as $o) { foreach ($o['series'] as $s) { $agregar($u, $o, $s); } }
        foreach ($u['series_sin_oficina'] ?? [] as $s) { $agregar($u, null, $s); }
    }
    return ['filas' => $filas, 'parametrizadas' => count(array_filter($filas, fn ($f) => $f['parametrizada']))];
};
