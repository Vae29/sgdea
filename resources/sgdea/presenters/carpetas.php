<?php
/*
 | Presentador de carpetas y expedientes (solo transforma datos para la vista; sin consultas).
 | Une cada carpeta con sus documentos (documentos_carpeta + documentos_digitales) y arma el índice documental.
 | No calcula retención: 'transferencia_estimada' queda null mientras la TRD no tenga retención parametrizada.
*/
return function (array $carpetas, array $documentos): array {
    $porId = array_column($documentos, null, 'id');
    $tam = fn ($b) => $b >= 1048576 ? number_format($b / 1048576, 2, ',', '.') . ' MB' : number_format($b / 1024, 0, ',', '.') . ' KB';
    $out = [];
    foreach ($carpetas as $c) {
        $indice = [];
        foreach ($c['documentos'] as $d) {
            $doc = $porId[$d['documento_id']] ?? null;
            if (!$doc) { continue; }
            $indice[] = ['posicion' => $d['secuencia'], 'documento_id' => $doc['id'], 'titulo' => $doc['titulo'], 'tipo_documental' => $doc['tipo_documental'],
                'fecha_incorporacion' => $d['fecha_incorporacion'], 'folios' => $d['folio_inicial'] . '–' . $d['folio_final'],
                'folio_inicial' => $d['folio_inicial'], 'folio_final' => $d['folio_final'], 'tamano' => $tam($doc['tamano_bytes']), 'hash_sha256' => $doc['hash_sha256']];
        }
        $c['indice'] = $indice;
        $c['total_documentos'] = count($indice);
        $c['oficina'] = $c['oficina_codigo'] . ' · ' . $c['oficina_nombre'];
        $c['serie'] = $c['serie_codigo'] . ' · ' . $c['serie_nombre'];
        $c['subserie'] = $c['subserie_codigo'] ? $c['subserie_codigo'] . ' · ' . $c['subserie_nombre'] : null;
        $c['hibrida'] = $c['soporte'] === 'Híbrido';
        $c['transferencia_estimada'] = null;
        $c['rotulo'] = [
            'carpeta' => $c['numero_asignado'], 'caja' => $c['caja'] ?? '—', 'folios' => $c['cantidad_folios'] ?? '—',
            'codigo_dependencia' => $c['oficina_codigo'], 'dependencia' => $c['oficina_nombre'],
            'serie' => $c['oficina_codigo'] . '.' . $c['serie_codigo'] . ' - ' . $c['serie_nombre'],
            'subserie' => $c['subserie_codigo'] ? $c['oficina_codigo'] . '.' . $c['serie_codigo'] . '.' . $c['subserie_codigo'] . ' - ' . $c['subserie_nombre'] : '—',
            'nombre_carpeta' => $c['nombre_carpeta'], 'desde' => $c['fecha_inicial'], 'hasta' => $c['fecha_final'] ?? '—',
        ];
        $out[] = $c;
    }
    return $out;
};
