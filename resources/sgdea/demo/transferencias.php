<?php
/*
 | DEMOSTRACIÓN — alertas, transferencias y solicitudes de disposición ficticias. Los estados y semáforos son SOLO una
 | representación visual: la TRD entregada no tiene retención parametrizada, por lo que no se calcula ninguna fecha límite.
 | Los nombres de carpetas provienen del módulo de carpetas de demostración y del FUID entregado.
 | Será reemplazado por los datos del controlador (transferencias_documentales, items_transferencia_documental,
 | solicitudes_disposicion y aprobaciones_disposicion).
*/
return [
    'alertas' => [
        ['carpeta' => 'CP1 · Comprobantes de egreso enero', 'oficina' => '51 · Contabilidad', 'ubicacion' => 'Caja 001', 'fecha_cierre' => '2026-02-05', 'semaforo' => 'rojo', 'estado' => 'vencido', 'origen' => 'Carpeta de demostración'],
        ['carpeta' => '[DEMO] Derecho de petición 002 (cerrada)', 'oficina' => '12 · Secretaria', 'ubicacion' => 'Sin caja', 'fecha_cierre' => '2026-11-06', 'semaforo' => 'amarillo', 'estado' => 'proximo', 'origen' => 'Carpeta de demostración'],
        ['carpeta' => 'SACRIFICIO BOVINOS ENERO 2020', 'oficina' => '30 · PLANTA DE BENEFICIO ANIMAL', 'ubicacion' => 'Caja 1 · Carpeta 1', 'fecha_cierre' => '2020-01-28', 'semaforo' => 'rojo', 'estado' => 'vencido', 'origen' => 'Inventario FUID'],
        ['carpeta' => 'SACRIFICIO PORCINOS VIGENCIA 2023', 'oficina' => '30 · PLANTA DE BENEFICIO ANIMAL', 'ubicacion' => 'Caja 3 · Carpeta 7', 'fecha_cierre' => '2023-08-30', 'semaforo' => 'amarillo', 'estado' => 'proximo', 'origen' => 'Inventario FUID'],
        ['carpeta' => 'BOVINOS Y PORCINOS 2022', 'oficina' => '30 · PLANTA DE BENEFICIO ANIMAL', 'ubicacion' => 'Caja 2', 'fecha_cierre' => '2022-12-29', 'semaforo' => 'verde', 'estado' => 'pendiente', 'origen' => 'Inventario FUID'],
    ],
    'transferencias' => [
        ['id' => 1, 'codigo_transferencia' => 'DEMO-TR-001', 'tipo_transferencia' => 'Transferencia primaria', 'fase_origen' => 'Archivo de gestión', 'fase_destino' => 'Archivo central',
            'fecha_transferencia' => '2026-10-15', 'estado' => 'transferido', 'numero_acta' => 'DEMO-ACTA-001', 'creado_por' => 'Usuario demo 1', 'aprobado_por' => 'Usuario demo 3',
            'items' => [['carpeta' => 'CP1 · Comprobantes de egreso enero', 'notas' => 'Carpeta de demostración']]],
        ['id' => 2, 'codigo_transferencia' => 'DEMO-TR-002', 'tipo_transferencia' => 'Transferencia primaria', 'fase_origen' => 'Archivo de gestión', 'fase_destino' => 'Archivo central',
            'fecha_transferencia' => null, 'estado' => 'revision', 'numero_acta' => null, 'creado_por' => 'Usuario demo 2', 'aprobado_por' => null,
            'items' => [['carpeta' => 'CP2 · Comprobantes de egreso febrero (1-2)', 'notas' => null], ['carpeta' => '[DEMO] Derecho de petición 002 (cerrada)', 'notas' => null]]],
        ['id' => 3, 'codigo_transferencia' => 'DEMO-TR-003', 'tipo_transferencia' => 'Transferencia primaria', 'fase_origen' => 'Archivo de gestión', 'fase_destino' => 'Archivo central',
            'fecha_transferencia' => null, 'estado' => 'pendiente', 'numero_acta' => null, 'creado_por' => 'Usuario demo 4', 'aprobado_por' => null,
            'items' => [['carpeta' => 'SACRIFICIO BOVINOS ENERO 2020', 'notas' => 'Carpeta del inventario FUID']]],
        ['id' => 4, 'codigo_transferencia' => 'DEMO-TR-004', 'tipo_transferencia' => 'Transferencia primaria', 'fase_origen' => 'Archivo de gestión', 'fase_destino' => 'Archivo central',
            'fecha_transferencia' => null, 'estado' => 'rechazado', 'numero_acta' => null, 'creado_por' => 'Usuario demo 2', 'aprobado_por' => null,
            'items' => [['carpeta' => 'SACRIFICIO PORCINOS VIGENCIA 2023', 'notas' => 'Rechazada por observaciones de demostración']]],
    ],
    'solicitudes' => [
        ['id' => 1, 'carpeta' => '[DEMO] Derecho de petición 002 (cerrada)', 'tipo_disposicion' => 'Eliminación', 'numero_acta' => 'DEMO-MIPG-001', 'referencia_acta' => 'Acta del Comité de MIPG (demostración)',
            'estado' => 'revision', 'solicitado_por' => 'Usuario demo 1', 'fecha_hora_solicitud' => '2026-11-06 17:00', 'completado_en' => null,
            'aprobaciones' => [['aprobado_por' => 'Usuario demo 3', 'estado' => 'aprobado', 'comentarios' => 'Primer visto bueno (demostración).', 'fecha_hora' => '2026-11-06 17:30'],
                               ['aprobado_por' => null, 'estado' => 'pendiente', 'comentarios' => null, 'fecha_hora' => null]]],
        ['id' => 2, 'carpeta' => 'SACRIFICIO BOVINOS ENERO 2020', 'tipo_disposicion' => 'Selección', 'numero_acta' => null, 'referencia_acta' => null,
            'estado' => 'aprobado', 'solicitado_por' => 'Usuario demo 4', 'fecha_hora_solicitud' => '2026-10-20 09:00', 'completado_en' => '2026-10-22 11:00',
            'aprobaciones' => [['aprobado_por' => 'Usuario demo 3', 'estado' => 'aprobado', 'comentarios' => 'Aprobada (demostración).', 'fecha_hora' => '2026-10-22 11:00']]],
        ['id' => 3, 'carpeta' => 'CP1 · Comprobantes de egreso enero', 'tipo_disposicion' => 'Eliminación', 'numero_acta' => 'DEMO-MIPG-002', 'referencia_acta' => 'Acta del Comité de MIPG (demostración)',
            'estado' => 'rechazado', 'solicitado_por' => 'Usuario demo 2', 'fecha_hora_solicitud' => '2026-10-10 15:00', 'completado_en' => null,
            'aprobaciones' => [['aprobado_por' => 'Usuario demo 3', 'estado' => 'rechazado', 'comentarios' => 'Rechazada por observaciones de demostración.', 'fecha_hora' => '2026-10-11 08:40']]],
        ['id' => 5, 'carpeta' => 'BOVINOS Y PORCINOS 2022', 'tipo_disposicion' => 'Eliminación', 'numero_acta' => 'DEMO-MIPG-003', 'referencia_acta' => 'Acta del Comité de MIPG (demostración)',
            'estado' => 'aprobado', 'disposicion_aplicada' => 'Eliminado', 'solicitado_por' => 'Usuario demo 4', 'fecha_hora_solicitud' => '2026-09-15 09:00', 'completado_en' => '2026-09-18 16:00',
            'aprobaciones' => [['aprobado_por' => 'Usuario demo 3', 'estado' => 'aprobado', 'comentarios' => 'Primer visto bueno (demostración).', 'fecha_hora' => '2026-09-16 10:00'],
                               ['aprobado_por' => 'Usuario demo 1', 'estado' => 'aprobado', 'comentarios' => 'Segundo visto bueno (demostración).', 'fecha_hora' => '2026-09-18 15:30']]],
        ['id' => 4, 'carpeta' => 'BOVINOS Y PORCINOS 2022', 'tipo_disposicion' => 'Conservación total', 'numero_acta' => null, 'referencia_acta' => null,
            'estado' => 'pendiente', 'solicitado_por' => 'Usuario demo 4', 'fecha_hora_solicitud' => '2026-11-05 10:00', 'completado_en' => null, 'aprobaciones' => []],
    ],
];
