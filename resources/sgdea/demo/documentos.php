<?php
/*
 | DEMOSTRACIÓN — documentos digitales ficticios. No existen archivos reales; los hashes SHA-256 son de ejemplo.
 | Los tipos documentales y series provienen del CCD oficial (serie 17 Derechos de Petición y serie 02 Actas, oficina Secretaria).
 | Nivel de acceso: publica | clasificada | reservada.  Validación: criterios de aceptación de HU-GDO-04.
 | Será reemplazado por los datos del controlador (tabla documentos_digitales).
*/
$val = fn ($formato, $meta, $hash, $vinculo) => [
    ['etiqueta' => 'Formato permitido (PDF/A, TIFF, JPG, PNG)', 'ok' => $formato],
    ['etiqueta' => 'Metadatos mínimos completos', 'ok' => $meta],
    ['etiqueta' => 'Huella SHA-256 calculada', 'ok' => $hash],
    ['etiqueta' => 'Vinculado a una radicación o serie (no huérfano)', 'ok' => $vinculo],
];
return [
    ['id' => 1, 'titulo' => '[DEMO] Derecho de petición recibido', 'tipo_documental' => 'Derecho de Petición.', 'serie' => '17 · DERECHOS DE PETICIÓN', 'subserie' => null,
        'oficina' => '12 · Secretaria', 'radicado' => 'DEMO-001-2026-E', 'fecha_produccion' => '2026-11-02', 'folios' => 3, 'paginas' => 3, 'soporte_origen' => 'Papel', 'nivel_acceso' => 'clasificada',
        'nombre_original_archivo' => 'DEMO_peticion.pdf', 'tipo_mime' => 'application/pdf', 'tamano_bytes' => 482133, 'hash_sha256' => '9d22d4c1a4a337cb387cd60185fe944e853f4bc9aa7de77ac4f7f6fa52551000',
        'subido_por' => 'Usuario demo 1', 'ip' => '192.0.2.10', 'hora_carga' => '2026-11-03 08:50', 'estado_validacion' => 'validado', 'validacion' => $val(true, true, true, true), 'carpeta' => 'DEMO-CP1 · [DEMO] Derecho de petición 001'],
    ['id' => 2, 'titulo' => '[DEMO] Respuesta a derecho de petición', 'tipo_documental' => 'Respuesta a Derecho de Petición', 'serie' => '17 · DERECHOS DE PETICIÓN', 'subserie' => null,
        'oficina' => '12 · Secretaria', 'radicado' => 'DEMO-001-2026-S', 'fecha_produccion' => '2026-11-05', 'folios' => 2, 'paginas' => 2, 'soporte_origen' => 'Electrónico', 'nivel_acceso' => 'clasificada',
        'nombre_original_archivo' => 'DEMO_respuesta.pdf', 'tipo_mime' => 'application/pdf', 'tamano_bytes' => 215908, 'hash_sha256' => '18bbad029ac9d2fc6a4f773e0f0bc29d4628cc620506864a73ce0614d563bea6',
        'subido_por' => 'Usuario demo 1', 'ip' => '192.0.2.10', 'hora_carga' => '2026-11-05 10:20', 'estado_validacion' => 'validado', 'validacion' => $val(true, true, true, true), 'carpeta' => 'DEMO-CP1 · [DEMO] Derecho de petición 001'],
    ['id' => 3, 'titulo' => '[DEMO] Acta de apertura del buzón de sugerencias', 'tipo_documental' => 'Acta', 'serie' => '02 · ACTAS', 'subserie' => '01 · Actas de Apertura del Buzón de sugerencias',
        'oficina' => '12 · Secretaria', 'radicado' => null, 'fecha_produccion' => '2026-10-30', 'folios' => 1, 'paginas' => 2, 'soporte_origen' => 'Papel/Electrónico', 'nivel_acceso' => 'publica',
        'nombre_original_archivo' => 'DEMO_acta.tiff', 'tipo_mime' => 'image/tiff', 'tamano_bytes' => 3190421, 'hash_sha256' => '78608204f0c24e0606063a8bc6a493f4ff25cd0b87df7c893ce299479ed6aba4',
        'subido_por' => 'Usuario demo 2', 'ip' => '192.0.2.11', 'hora_carga' => '2026-10-31 15:02', 'estado_validacion' => 'observaciones', 'validacion' => $val(true, false, true, true), 'carpeta' => 'DEMO-CP2 · [DEMO] Actas del buzón de sugerencias 2026'],
    ['id' => 4, 'titulo' => '[DEMO] Planilla escaneada', 'tipo_documental' => 'Derecho de Petición.', 'serie' => '17 · DERECHOS DE PETICIÓN', 'subserie' => null,
        'oficina' => '12 · Secretaria', 'radicado' => 'DEMO-002-2026-E', 'fecha_produccion' => '2026-11-05', 'folios' => 1, 'paginas' => 1, 'soporte_origen' => 'Papel', 'nivel_acceso' => 'reservada',
        'nombre_original_archivo' => 'DEMO_planilla.jpg', 'tipo_mime' => 'image/jpeg', 'tamano_bytes' => 902114, 'hash_sha256' => 'cd509043c4c099824654fc2a0d4b0a5a22633d01492dd8e5702c6e343f3da968',
        'subido_por' => 'Usuario demo 1', 'ip' => '192.0.2.10', 'hora_carga' => '2026-11-06 09:20', 'estado_validacion' => 'validado', 'validacion' => $val(true, true, true, true), 'carpeta' => 'DEMO-CP3 · [DEMO] Derecho de petición 002 (cerrada)'],
    ['id' => 5, 'titulo' => '[DEMO] Anexo adicional de derecho de petición', 'tipo_documental' => 'Derecho de Petición.', 'serie' => '17 · DERECHOS DE PETICIÓN', 'subserie' => null,
        'oficina' => '12 · Secretaria', 'radicado' => null, 'fecha_produccion' => '2026-11-06', 'folios' => 4, 'paginas' => 4, 'soporte_origen' => 'Papel', 'nivel_acceso' => 'clasificada',
        'nombre_original_archivo' => 'DEMO_anexo.pdf', 'tipo_mime' => 'application/pdf', 'tamano_bytes' => 640221, 'hash_sha256' => '877ffa4c7a7c1d292c98615997c3620e61fab2050e563c49a0edfc421118c1d4',
        'subido_por' => 'Usuario demo 2', 'ip' => '192.0.2.11', 'hora_carga' => '2026-11-06 12:10', 'estado_validacion' => 'validado', 'validacion' => $val(true, true, true, true), 'carpeta' => null],
];
