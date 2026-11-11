<?php
/*
 | DEMOSTRACIÓN — eventos de auditoría ficticios. Los nombres de acciones siguen los eventos citados en HU-GDO-08
 | (creación, consulta, modificación, cierre de carpeta, transferencias, intentos fallidos y accesos denegados);
 | el catálogo definitivo de acciones lo definirá el backend. Las IP usan el rango reservado 192.0.2.0/24.
 | 'referencia' = número de radicado o de expediente/carpeta relacionado (filtro pedido en HU-GDO-08). 'user_agent' lo pide la HU y el modelo aún no tiene esa columna.
 | Las tablas afectadas son las del modelo de datos. Será reemplazado por el controlador (tabla auditorias).
*/
return [
    ['id' => 1, 'referencia' => 'DEMO-CP3', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-06 16:00:12', 'usuario' => 'Usuario demo 1', 'accion' => 'cierre', 'tabla_afectada' => 'carpetas_archivo', 'id_afectado' => 5, 'ip' => '192.0.2.10',
        'antes' => ['estado' => 'Abierta', 'fecha_cierre' => null, 'indice_sellado' => null], 'despues' => ['estado' => 'Cerrada', 'fecha_cierre' => '2026-11-06', 'indice_sellado' => '2026-11-06 16:00']],
    ['id' => 2, 'referencia' => 'DEMO-002-2026-E', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-06 11:30:41', 'usuario' => 'Usuario demo 5', 'accion' => 'acceso_denegado', 'tabla_afectada' => 'documentos_digitales', 'id_afectado' => 4, 'ip' => '192.0.2.31',
        'antes' => null, 'despues' => ['motivo' => 'El usuario no tiene autorización para el nivel de acceso Reservado']],
    ['id' => 3, 'referencia' => 'DEMO-002-2026-E', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-06 09:20:03', 'usuario' => 'Usuario demo 1', 'accion' => 'creacion', 'tabla_afectada' => 'documentos_digitales', 'id_afectado' => 4, 'ip' => '192.0.2.10',
        'antes' => null, 'despues' => ['titulo' => '[DEMO] Planilla escaneada', 'nivel_acceso' => 'reservada', 'tipo_mime' => 'image/jpeg']],
    ['id' => 4, 'referencia' => 'DEMO-002-2026-E', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-06 09:05:55', 'usuario' => 'Usuario demo 4', 'accion' => 'creacion', 'tabla_afectada' => 'radicaciones', 'id_afectado' => 4, 'ip' => '192.0.2.12',
        'antes' => null, 'despues' => ['numero_radicado' => 'DEMO-002-2026-E', 'tipo' => 'entrada', 'asunto' => '[DEMO] Petición de un usuario del servicio']],
    ['id' => 5, 'referencia' => null, 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-05 14:48:20', 'usuario' => 'Usuario demo 3', 'accion' => 'consulta', 'tabla_afectada' => 'auditorias', 'id_afectado' => null, 'ip' => '192.0.2.14',
        'antes' => null, 'despues' => null],
    ['id' => 6, 'referencia' => 'DEMO-CP2', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-05 10:30:09', 'usuario' => 'Usuario demo 2', 'accion' => 'modificacion', 'tabla_afectada' => 'documentos_digitales', 'id_afectado' => 3, 'ip' => '192.0.2.11',
        'antes' => ['nivel_acceso' => 'clasificada', 'cantidad_paginas' => 1], 'despues' => ['nivel_acceso' => 'publica', 'cantidad_paginas' => 2]],
    ['id' => 7, 'referencia' => null, 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-04 08:02:44', 'usuario' => null, 'accion' => 'intento_fallido', 'tabla_afectada' => 'usuarios', 'id_afectado' => null, 'ip' => '192.0.2.77',
        'antes' => null, 'despues' => ['correo' => 'desconocido@ejemplo.invalid', 'motivo' => 'Credenciales inválidas']],
    ['id' => 8, 'referencia' => null, 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-04 07:59:10', 'usuario' => null, 'accion' => 'intento_fallido', 'tabla_afectada' => 'usuarios', 'id_afectado' => null, 'ip' => '192.0.2.77',
        'antes' => null, 'despues' => ['correo' => 'desconocido@ejemplo.invalid', 'motivo' => 'Credenciales inválidas']],
    ['id' => 9, 'referencia' => 'DEMO-TR-001', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-10-15 15:10:30', 'usuario' => 'Usuario demo 1', 'accion' => 'transferencia', 'tabla_afectada' => 'transferencias_documentales', 'id_afectado' => 1, 'ip' => '192.0.2.10',
        'antes' => ['estado' => 'revision'], 'despues' => ['estado' => 'transferido', 'numero_acta' => 'DEMO-ACTA-001']],
    ['id' => 10, 'referencia' => 'DEMO-CP1', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-03 09:10:00', 'usuario' => 'Usuario demo 1', 'accion' => 'modificacion', 'tabla_afectada' => 'documentos_carpeta', 'id_afectado' => 1, 'ip' => '192.0.2.10',
        'antes' => null, 'despues' => ['carpeta_id' => 3, 'documento_id' => 1, 'numero_secuencia' => 1, 'folio_inicial' => 1, 'folio_final' => 3]],
    ['id' => 11, 'referencia' => 'CP1', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-11-02 17:21:36', 'usuario' => 'Usuario demo 2', 'accion' => 'consulta', 'tabla_afectada' => 'carpetas_archivo', 'id_afectado' => 1, 'ip' => '192.0.2.11',
        'antes' => null, 'despues' => null],
    ['id' => 12, 'referencia' => 'DEMO-CP3', 'user_agent' => 'Navegador de demostración (ejemplo)', 'fecha_hora' => '2026-10-30 12:00:05', 'usuario' => 'Usuario demo 5', 'accion' => 'acceso_denegado', 'tabla_afectada' => 'carpetas_archivo', 'id_afectado' => 5, 'ip' => '192.0.2.31',
        'antes' => null, 'despues' => ['motivo' => 'El usuario no tiene autorización para el nivel de acceso Reservado']],
];
