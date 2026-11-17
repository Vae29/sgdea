<?php

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

uses(RefreshDatabase::class);

function createUserWithPermissionRole(string $correo, string $nombreRol, bool $activo = true): Usuario
{
    $rol = Rol::create(['nombre' => $nombreRol]);

    $usuario = Usuario::create([
        'nombre_completo' => $nombreRol,
        'correo' => $correo,
        'contrasena' => 'password-segura',
        'activo' => $activo,
    ]);

    $usuario->roles()->attach($rol->getKey());

    return $usuario;
}

test('permission config registers gates and resolves the user role assignments', function () {
    $permisos = array_keys(config('sgdea_permisos.permisos'));
    $radicador = createUserWithPermissionRole('radicador@example.test', 'Radicador');

    expect($permisos)->toHaveCount(23)
        ->and($radicador->tieneRol('Radicador'))->toBeTrue()
        ->and($radicador->tieneRol('Administrador'))->toBeFalse()
        ->and($radicador->tienePermiso('radicacion.crear'))->toBeTrue()
        ->and($radicador->tienePermiso('usuarios.administrar'))->toBeFalse();

    foreach ($permisos as $permiso) {
        expect(Gate::has($permiso))->toBeTrue();
    }

    $inactiveAdministrator = createUserWithPermissionRole(
        'inactivo@example.test',
        'Administrador',
        false,
    );

    expect($inactiveAdministrator->tienePermiso('usuarios.administrar'))->toBeFalse();
});

test('radicador is forbidden from user administration while administrator is allowed', function () {
    $radicador = createUserWithPermissionRole('radicador-route@example.test', 'Radicador');
    $administrador = createUserWithPermissionRole('administrador-route@example.test', 'Administrador');

    $this->actingAs($radicador)
        ->get('/sgdea/usuarios')
        ->assertForbidden();

    $this->actingAs($administrador)
        ->get('/sgdea/usuarios')
        ->assertOk();
});
