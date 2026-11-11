<?php
/* DEMOSTRACIÓN — datos ficticios del usuario y las notificaciones de la barra superior. */
return [
    'usuario' => [
        'nombre_completo' => 'Usuario de demostración',
        'rol' => 'Administrador',
        'oficina' => 'Gestión Documental (DEMO)',
    ],
    'notificaciones' => [
        ['tono' => 'warning', 'texto' => 'Carpeta de ejemplo próxima a cumplir retención.', 'tiempo' => 'Hace 2 h'],
        ['tono' => 'danger', 'texto' => 'Acceso denegado a documento reservado (ejemplo).', 'tiempo' => 'Ayer'],
        ['tono' => 'info', 'texto' => 'Transferencia de ejemplo pendiente de revisión.', 'tiempo' => 'Hace 3 días'],
    ],
];
