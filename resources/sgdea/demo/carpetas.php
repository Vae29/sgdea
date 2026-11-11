<?php
/*
 | DEMOSTRACIÓN — carpetas ficticias. Los nombres de las carpetas 1 y 2 y su caja siguen el rótulo de caja de ejemplo
 | (oficina Contabilidad 51, serie 09, subserie 01, caja 001); los folios, estados y fechas de cierre son de demostración.
 | 'retencion' es null porque la TRD entregada no tiene retención parametrizada: no se inventa ni se calcula.
 | Será reemplazado por los datos del controlador (tablas carpetas_archivo y documentos_carpeta).
*/
$conta = ['unidad' => '50 · Área Administrativa', 'oficina_codigo' => '51', 'oficina_nombre' => 'Contabilidad', 'serie_codigo' => '09', 'serie_nombre' => 'COMPROBANTES CONTABLES',
    'subserie_codigo' => '01', 'subserie_nombre' => 'Comprobantes contables de Egreso'];
$secre = ['unidad' => '10 · Gerencia General', 'oficina_codigo' => '12', 'oficina_nombre' => 'Secretaria'];
return [
    array_merge($conta, ['id' => 1, 'numero_asignado' => 'CP1', 'nombre_carpeta' => 'Comprobantes de egreso enero', 'anio' => 2026, 'caja' => '001', 'soporte' => 'Físico', 'nivel_acceso' => 'clasificada',
        'fase_archivo' => 'Archivo de gestión', 'estado' => 'Cerrada', 'fecha_apertura' => '2026-01-02', 'fecha_inicial' => '2026-01-02', 'fecha_final' => '2026-01-30', 'fecha_cierre' => '2026-02-05',
        'cantidad_folios' => 148, 'indice_sellado' => '2026-02-05 16:40', 'indice_hash' => '9f0a63f785d7b57fe8bc17eee1a29ca9d1e1a90d78e31d8c1e81d5489fba0e28', 'usuario_creador' => 'Usuario demo 2', 'retencion' => null, 'documentos' => []]),
    array_merge($conta, ['id' => 2, 'numero_asignado' => 'CP2', 'nombre_carpeta' => 'Comprobantes de egreso febrero (1-2)', 'anio' => 2026, 'caja' => '001', 'soporte' => 'Físico', 'nivel_acceso' => 'clasificada',
        'fase_archivo' => 'Archivo de gestión', 'estado' => 'Abierta', 'fecha_apertura' => '2026-02-02', 'fecha_inicial' => '2026-02-02', 'fecha_final' => null, 'fecha_cierre' => null,
        'cantidad_folios' => 96, 'indice_sellado' => null, 'indice_hash' => null, 'usuario_creador' => 'Usuario demo 2', 'retencion' => null, 'documentos' => []]),
    array_merge($secre, ['id' => 3, 'numero_asignado' => 'DEMO-CP1', 'nombre_carpeta' => '[DEMO] Derecho de petición 001', 'anio' => 2026, 'caja' => null, 'soporte' => 'Híbrido', 'nivel_acceso' => 'clasificada',
        'serie_codigo' => '17', 'serie_nombre' => 'DERECHOS DE PETICIÓN', 'subserie_codigo' => null, 'subserie_nombre' => null,
        'fase_archivo' => 'Archivo de gestión', 'estado' => 'Abierta', 'fecha_apertura' => '2026-11-03', 'fecha_inicial' => '2026-11-03', 'fecha_final' => null, 'fecha_cierre' => null,
        'cantidad_folios' => 5, 'indice_sellado' => null, 'indice_hash' => null, 'usuario_creador' => 'Usuario demo 1', 'retencion' => null,
        'documentos' => [['documento_id' => 1, 'secuencia' => 1, 'fecha_incorporacion' => '2026-11-03 09:10', 'folio_inicial' => 1, 'folio_final' => 3],
                         ['documento_id' => 2, 'secuencia' => 2, 'fecha_incorporacion' => '2026-11-05 10:30', 'folio_inicial' => 4, 'folio_final' => 5]]]),
    array_merge($secre, ['id' => 4, 'numero_asignado' => 'DEMO-CP2', 'nombre_carpeta' => '[DEMO] Actas del buzón de sugerencias 2026', 'anio' => 2026, 'caja' => null, 'soporte' => 'Electrónico', 'nivel_acceso' => 'publica',
        'serie_codigo' => '02', 'serie_nombre' => 'ACTAS', 'subserie_codigo' => '01', 'subserie_nombre' => 'Actas de Apertura del Buzón de sugerencias',
        'fase_archivo' => 'Archivo de gestión', 'estado' => 'Abierta', 'fecha_apertura' => '2026-10-30', 'fecha_inicial' => '2026-10-30', 'fecha_final' => null, 'fecha_cierre' => null,
        'cantidad_folios' => 1, 'indice_sellado' => null, 'indice_hash' => null, 'usuario_creador' => 'Usuario demo 2', 'retencion' => null,
        'documentos' => [['documento_id' => 3, 'secuencia' => 1, 'fecha_incorporacion' => '2026-10-31 15:10', 'folio_inicial' => 1, 'folio_final' => 1]]]),
    array_merge($secre, ['id' => 5, 'numero_asignado' => 'DEMO-CP3', 'nombre_carpeta' => '[DEMO] Derecho de petición 002 (cerrada)', 'anio' => 2026, 'caja' => null, 'soporte' => 'Híbrido', 'nivel_acceso' => 'reservada',
        'serie_codigo' => '17', 'serie_nombre' => 'DERECHOS DE PETICIÓN', 'subserie_codigo' => null, 'subserie_nombre' => null,
        'fase_archivo' => 'Archivo de gestión', 'estado' => 'Cerrada', 'fecha_apertura' => '2026-10-20', 'fecha_inicial' => '2026-10-20', 'fecha_final' => '2026-11-06', 'fecha_cierre' => '2026-11-06',
        'cantidad_folios' => 1, 'indice_sellado' => '2026-11-06 16:00', 'indice_hash' => '7fff19c52cfcf66656d704c8e1e37ad6a55f63fa40744040324254f7f3280bf1', 'usuario_creador' => 'Usuario demo 1', 'retencion' => null,
        'documentos' => [['documento_id' => 4, 'secuencia' => 1, 'fecha_incorporacion' => '2026-11-06 09:30', 'folio_inicial' => 1, 'folio_final' => 1]]]),
];
