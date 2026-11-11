<?php
/*
 | DEMOSTRACIÓN — usuarios y roles ficticios. Los 5 roles son los establecidos en HU-GDO-07; su descripción es orientativa
 | (tomada de los actores de las historias de usuario) y los permisos exactos están por definir con la empresa.
 | Las oficinas provienen del CCD oficial. Los correos usan el dominio reservado .invalid.
 | Será reemplazado por los datos del controlador (tablas usuarios, roles, rol_usuario).
*/
return [
    'roles' => [
        ['nombre' => 'Administrador', 'descripcion' => 'Gestiona roles, permisos y niveles de confidencialidad (HU-GDO-07).'],
        ['nombre' => 'Radicador', 'descripcion' => 'Radica las comunicaciones recibidas, enviadas e internas (HU-GDO-03).'],
        ['nombre' => 'Funcionario', 'descripcion' => 'Conforma y gestiona los expedientes de su dependencia (HU-GDO-05).'],
        ['nombre' => 'Consulta Pública', 'descripcion' => 'Consulta información de acceso público.'],
        ['nombre' => 'Control Interno', 'descripcion' => 'Consulta la bitácora de auditoría y la trazabilidad (HU-GDO-08).'],
    ],
    'usuarios' => [
        ['id' => 1, 'nombre_completo' => 'Usuario demo 1', 'correo' => 'usuario1@ejemplo.invalid', 'oficina' => '12.1 · Gestión Documental', 'oficina_key' => 'o:10:12.1', 'unidad_key' => 'u:10', 'roles' => ['Administrador'], 'activo' => true, 'fecha_creacion' => '2026-09-01'],
        ['id' => 2, 'nombre_completo' => 'Usuario demo 2', 'correo' => 'usuario2@ejemplo.invalid', 'oficina' => '51 · Contabilidad', 'oficina_key' => 'o:50:51', 'unidad_key' => 'u:50', 'roles' => ['Funcionario'], 'activo' => true, 'fecha_creacion' => '2026-09-01'],
        ['id' => 3, 'nombre_completo' => 'Usuario demo 3', 'correo' => 'usuario3@ejemplo.invalid', 'oficina' => '13 · Control Interno', 'oficina_key' => 'o:10:13', 'unidad_key' => 'u:10', 'roles' => ['Control Interno'], 'activo' => true, 'fecha_creacion' => '2026-09-02'],
        ['id' => 4, 'nombre_completo' => 'Usuario demo 4', 'correo' => 'usuario4@ejemplo.invalid', 'oficina' => '12 · Secretaria', 'oficina_key' => 'o:10:12', 'unidad_key' => 'u:10', 'roles' => ['Radicador', 'Funcionario'], 'activo' => true, 'fecha_creacion' => '2026-09-02'],
        ['id' => 5, 'nombre_completo' => 'Usuario demo 5', 'correo' => 'usuario5@ejemplo.invalid', 'oficina' => null, 'oficina_key' => null, 'unidad_key' => null, 'roles' => ['Consulta Pública'], 'activo' => true, 'fecha_creacion' => '2026-09-10'],
        ['id' => 6, 'nombre_completo' => 'Usuario demo 6', 'correo' => 'usuario6@ejemplo.invalid', 'oficina' => '53 · Tesorería', 'oficina_key' => 'o:50:53', 'unidad_key' => 'u:50', 'roles' => ['Funcionario'], 'activo' => false, 'fecha_creacion' => '2026-09-10'],
    ],
];
