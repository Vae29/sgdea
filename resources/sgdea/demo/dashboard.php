<?php
/*
 | DEMOSTRACIÓN — TODOS los valores de este archivo son ficticios.
 | No corresponden a datos reales de la empresa ni a consecutivos oficiales.
 | Los nombres de oficinas y series provienen del CCD oficial (CCD_12) y del rótulo de caja de ejemplo.
 | Se reemplazará por la información que entregue el controlador del dashboard.
*/
return [
    'indicadores' => [
        ['etiqueta' => 'Documentos digitales', 'valor' => 1248, 'icono' => 'layers', 'tono' => 'primary', 'nota' => 'Tabla documentos_digitales'],
        ['etiqueta' => 'Carpetas', 'valor' => 312, 'icono' => 'folder', 'tono' => 'primary', 'nota' => 'Tabla carpetas_archivo'],
        ['etiqueta' => 'Cajas', 'valor' => 38, 'icono' => 'archive', 'tono' => 'primary', 'nota' => 'Tabla cajas_almacenamiento'],
        ['etiqueta' => 'Radicaciones del año', 'valor' => 181, 'icono' => 'inbox', 'tono' => 'primary', 'nota' => 'Tabla radicaciones'],
        ['etiqueta' => 'Transferencias pendientes', 'valor' => 4, 'icono' => 'truck', 'tono' => 'warning', 'nota' => 'Tabla transferencias_documentales'],
        ['etiqueta' => 'Alertas documentales', 'valor' => 9, 'icono' => 'bell', 'tono' => 'danger', 'nota' => 'Semáforo de retención'],
    ],
    'radicaciones_por_tipo' => [
        ['tipo' => 'Entrada', 'total' => 96],
        ['tipo' => 'Salida', 'total' => 54],
        ['tipo' => 'Interna', 'total' => 31],
    ],
    'semaforo' => [
        ['clase' => 'sem-verde', 'etiqueta' => 'Vigente', 'total' => 270],
        ['clase' => 'sem-amarillo', 'etiqueta' => 'Próximo a cumplir retención', 'total' => 33],
        ['clase' => 'sem-rojo', 'etiqueta' => 'Tiempo cumplido', 'total' => 9],
    ],
    'alertas' => [
        ['estado' => 'proximo', 'texto' => 'Carpeta CP1 · Comprobantes de egreso enero — Contabilidad (51), Caja 001', 'detalle' => 'Ejemplo de alerta (estado ficticio)'],
        ['estado' => 'vencido', 'texto' => 'Carpeta de demostración · Planta de Beneficio Animal (30)', 'detalle' => 'Ejemplo de alerta (estado ficticio)'],
        ['estado' => 'proximo', 'texto' => 'Carpeta de demostración · Contabilidad (51)', 'detalle' => 'Ejemplo de alerta (estado ficticio)'],
    ],
    'actividad' => [
        ['usuario' => 'Usuario demo 1', 'accion' => 'Radicación creada', 'tono' => 'info', 'recurso' => 'radicaciones', 'id' => 'DEMO-001-2026-E', 'fecha' => '2026-11-06 09:12'],
        ['usuario' => 'Usuario demo 2', 'accion' => 'Documento cargado', 'tono' => 'info', 'recurso' => 'documentos_digitales', 'id' => 'DEMO-17', 'fecha' => '2026-11-06 09:40'],
        ['usuario' => 'Usuario demo 3', 'accion' => 'Carpeta cerrada', 'tono' => 'success', 'recurso' => 'carpetas_archivo', 'id' => 'DEMO-5', 'fecha' => '2026-11-05 16:05'],
        ['usuario' => 'Usuario demo 4', 'accion' => 'Acceso denegado', 'tono' => 'danger', 'recurso' => 'documentos_digitales', 'id' => 'DEMO-9', 'fecha' => '2026-11-05 11:30'],
        ['usuario' => '— (sin sesión)', 'accion' => 'Intento de inicio de sesión fallido', 'tono' => 'warning', 'recurso' => 'usuarios', 'id' => '—', 'fecha' => '2026-11-04 08:02'],
    ],
];
