<?php
/*
 | DEMOSTRACIÓN — registros ficticios de radicación. Los números NO son consecutivos reales.
 | Las comunicaciones PQRSDF se radican por este mismo flujo (HU-GDO-03); la HU no define una marca ni tipos propios, por eso no se incluye.
 | Las oficinas provienen del CCD oficial. Los valores de 'estado' y los sufijos de los números
 | de salida/interna son supuestos de demostración (el único formato dado en los requerimientos es "291-2026-E").
 | Será reemplazado por los datos del controlador (tabla radicaciones).
*/
$u = 'Usuario demo';
return [
    ['id' => 1, 'numero_radicado' => 'DEMO-001-2026-E', 'anio_radicado' => 2026, 'numero_consecutivo' => 1, 'tipo' => 'entrada', 'asunto' => '[DEMO] Solicitud de información de un ciudadano',
        'datos_remitente' => ['nombre' => 'Remitente de demostración 1', 'identificacion' => 'DEMO-0001', 'contacto' => 'remitente1@ejemplo.invalid'],
        'datos_destinatario' => ['nombre' => 'Secretaria', 'identificacion' => '', 'contacto' => ''],
        'correo_solicitante' => 'solicitante1@ejemplo.invalid', 'oficina' => '12 · Secretaria', 'oficina_key' => 'o:10:12', 'unidad' => '10 · Gerencia General',
        'usuario' => $u . ' 1', 'fecha_hora' => '2026-11-03 08:41', 'fecha_documento' => '2026-11-02', 'folios' => 3, 'anexos' => 1, 'estado' => 'Radicado', 'padre' => null, 'documentos' => [1]],
    ['id' => 2, 'numero_radicado' => 'DEMO-001-2026-S', 'anio_radicado' => 2026, 'numero_consecutivo' => 1, 'tipo' => 'salida', 'asunto' => '[DEMO] Respuesta a la solicitud DEMO-001-2026-E',
        'datos_remitente' => ['nombre' => 'Secretaria', 'identificacion' => '', 'contacto' => ''],
        'datos_destinatario' => ['nombre' => 'Remitente de demostración 1', 'identificacion' => 'DEMO-0001', 'contacto' => 'remitente1@ejemplo.invalid'],
        'correo_solicitante' => null, 'oficina' => '12 · Secretaria', 'oficina_key' => 'o:10:12', 'unidad' => '10 · Gerencia General',
        'usuario' => $u . ' 1', 'fecha_hora' => '2026-11-05 10:15', 'fecha_documento' => '2026-11-05', 'folios' => 2, 'anexos' => 0, 'estado' => 'Radicado', 'padre' => 'DEMO-001-2026-E', 'documentos' => [2]],
    ['id' => 3, 'numero_radicado' => 'DEMO-001-2026-I', 'anio_radicado' => 2026, 'numero_consecutivo' => 1, 'tipo' => 'interna', 'asunto' => '[DEMO] Traslado de comprobantes para archivo',
        'datos_remitente' => ['nombre' => 'Contabilidad', 'identificacion' => '', 'contacto' => ''],
        'datos_destinatario' => ['nombre' => 'Gestión Documental', 'identificacion' => '', 'contacto' => ''],
        'correo_solicitante' => null, 'oficina' => '51 · Contabilidad', 'oficina_key' => 'o:50:51', 'unidad' => '50 · Área Administrativa',
        'usuario' => $u . ' 2', 'fecha_hora' => '2026-11-04 14:20', 'fecha_documento' => '2026-11-04', 'folios' => 12, 'anexos' => 2, 'estado' => 'Radicado', 'padre' => null, 'documentos' => []],
    ['id' => 4, 'numero_radicado' => 'DEMO-002-2026-E', 'anio_radicado' => 2026, 'numero_consecutivo' => 2, 'tipo' => 'entrada', 'asunto' => '[DEMO] Petición de un usuario del servicio',
        'datos_remitente' => ['nombre' => 'Remitente de demostración 2', 'identificacion' => 'DEMO-0002', 'contacto' => 'remitente2@ejemplo.invalid'],
        'datos_destinatario' => ['nombre' => 'Secretaria', 'identificacion' => '', 'contacto' => ''],
        'correo_solicitante' => 'solicitante2@ejemplo.invalid', 'oficina' => '12 · Secretaria', 'oficina_key' => 'o:10:12', 'unidad' => '10 · Gerencia General',
        'usuario' => $u . ' 1', 'fecha_hora' => '2026-11-06 09:05', 'fecha_documento' => '2026-11-05', 'folios' => 1, 'anexos' => 0, 'estado' => 'Radicado', 'padre' => null, 'documentos' => []],
    ['id' => 5, 'numero_radicado' => 'DEMO-003-2026-E', 'anio_radicado' => 2026, 'numero_consecutivo' => 3, 'tipo' => 'entrada', 'asunto' => '[DEMO] Oficio de una entidad externa',
        'datos_remitente' => ['nombre' => 'Entidad de demostración', 'identificacion' => 'DEMO-NIT', 'contacto' => 'entidad@ejemplo.invalid'],
        'datos_destinatario' => ['nombre' => 'Tesorería', 'identificacion' => '', 'contacto' => ''],
        'correo_solicitante' => null, 'oficina' => '53 · Tesorería', 'oficina_key' => 'o:50:53', 'unidad' => '50 · Área Administrativa',
        'usuario' => $u . ' 2', 'fecha_hora' => '2026-11-06 11:30', 'fecha_documento' => '2026-11-06', 'folios' => 5, 'anexos' => 1, 'estado' => 'Radicado', 'padre' => null, 'documentos' => []],
];
