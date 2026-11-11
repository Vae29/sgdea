<?php
/*
 | Estructura del menú lateral del SGDEA.
 | 'route' es el nombre de ruta SUGERIDO para la futura etapa de backend.
 | Mientras la ruta no exista, el menú muestra el enlace como "pendiente" (sin error).
*/
return [
    ['label' => 'Inicio', 'items' => [
        ['key' => 'dashboard', 'label' => 'Panel principal', 'icon' => 'home', 'route' => 'sgdea.dashboard'],
    ]],
    ['label' => 'Instrumentos archivísticos', 'items' => [
        ['key' => 'ccd', 'label' => 'Cuadro de Clasificación (CCD)', 'icon' => 'sitemap', 'route' => 'sgdea.ccd.index'],
        ['key' => 'trd', 'label' => 'Tablas de Retención (TRD)', 'icon' => 'clock', 'route' => 'sgdea.trd.index'],
    ]],
    ['label' => 'Gestión documental', 'items' => [
        ['key' => 'radicaciones', 'label' => 'Radicación', 'icon' => 'inbox', 'route' => 'sgdea.radicaciones.index'],
        ['key' => 'documentos', 'label' => 'Documentos digitales', 'icon' => 'layers', 'route' => 'sgdea.documentos.index'],
        ['key' => 'carpetas', 'label' => 'Carpetas y expedientes', 'icon' => 'folder', 'route' => 'sgdea.carpetas.index'],
        ['key' => 'cierre', 'label' => 'Cierre de carpetas', 'icon' => 'lock', 'route' => 'sgdea.cierre.index'],
    ]],
    ['label' => 'Archivo e inventario', 'items' => [
        ['key' => 'fuid', 'label' => 'Inventario FUID', 'icon' => 'clipboard', 'route' => 'sgdea.fuid.index'],
        ['key' => 'transferencias', 'label' => 'Transferencias y disposición', 'icon' => 'truck', 'route' => 'sgdea.transferencias.index'],
    ]],
    ['label' => 'Administración y control', 'items' => [
        ['key' => 'usuarios', 'label' => 'Usuarios y accesos', 'icon' => 'users', 'route' => 'sgdea.usuarios.index'],
        ['key' => 'auditorias', 'label' => 'Auditorías', 'icon' => 'list', 'route' => 'sgdea.auditorias.index'],
    ]],
];
