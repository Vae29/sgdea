<?php

use App\Models\Auditoria;
use App\Models\FondoDocumental;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

function createAuditTestUsuario(string $correo): Usuario
{
    return Usuario::create([
        'nombre_completo' => 'Usuario de auditoría',
        'correo' => $correo,
        'contrasena' => 'password-segura',
        'activo' => true,
    ]);
}

test('auditable models record create update and delete snapshots without credentials', function () {
    $usuario = createAuditTestUsuario('auditoria@example.test');

    Route::middleware('web')->get('/testing/auditable-record', function () {
        $fondo = FondoDocumental::create([
            'codigo' => 'AUD-TEST',
            'nombre' => 'Nombre anterior',
            'activo' => true,
        ]);
        $fondo->update(['nombre' => 'Nombre posterior']);
        $fondo->delete();

        return response()->json(['id' => $fondo->getKey()]);
    });

    $response = $this->actingAs($usuario)
        ->withServerVariables(['REMOTE_ADDR' => '192.0.2.25'])
        ->withHeader('User-Agent', 'AuditoriaTest/1.0')
        ->get('/testing/auditable-record')
        ->assertOk();

    $eventos = Auditoria::query()
        ->where('tabla_afectada', 'fondos_documentales')
        ->orderBy('auditoria_id')
        ->get();
    $creacion = $eventos[0];
    $modificacion = $eventos[1];
    $eliminacion = $eventos[2];
    $auditoriaUsuario = Auditoria::query()
        ->where('tabla_afectada', 'usuarios')
        ->where('id_campo_afectado', $usuario->getKey())
        ->firstOrFail();

    expect($eventos)->toHaveCount(3)
        ->and($creacion->accion)->toBe(Auditoria::ACCION_CREACION)
        ->and($creacion->datos_antes)->toBeNull()
        ->and($creacion->datos_despues['nombre'])->toBe('Nombre anterior')
        ->and($modificacion->accion)->toBe(Auditoria::ACCION_MODIFICACION)
        ->and($modificacion->datos_antes['nombre'])->toBe('Nombre anterior')
        ->and($modificacion->datos_despues['nombre'])->toBe('Nombre posterior')
        ->and($eliminacion->accion)->toBe(Auditoria::ACCION_ELIMINACION)
        ->and($eliminacion->datos_antes['nombre'])->toBe('Nombre posterior')
        ->and($eliminacion->datos_despues)->toBeNull()
        ->and($creacion->usuario_id)->toBe($usuario->getKey())
        ->and($creacion->direccion_ip)->toBe('192.0.2.25')
        ->and($creacion->user_agent)->toBe('AuditoriaTest/1.0')
        ->and($creacion->referencia)->toBe((string) $response->json('id'))
        ->and($creacion->fecha_hora_evento)->not->toBeNull()
        ->and(array_key_exists('contrasena', $auditoriaUsuario->datos_despues))->toBeFalse();
});

test('audit records cannot be updated or deleted', function () {
    $auditoria = Auditoria::create([
        'accion' => Auditoria::ACCION_CONSULTA,
        'tabla_afectada' => 'auditorias',
        'fecha_hora_evento' => now(),
    ]);

    expect(fn () => $auditoria->update(['accion' => Auditoria::ACCION_MODIFICACION]))
        ->toThrow(LogicException::class);
    expect(fn () => $auditoria->delete())->toThrow(LogicException::class);

    $this->assertModelExists($auditoria);
});

test('forbidden routes are recorded as denied access', function () {
    $usuario = createAuditTestUsuario('radicador-auditoria@example.test');
    $rol = Rol::create(['nombre' => 'Radicador']);
    $usuario->roles()->attach($rol->getKey());

    $this->actingAs($usuario)
        ->withHeader('User-Agent', 'AuditoriaDeniedTest/1.0')
        ->get('/sgdea/usuarios')
        ->assertForbidden();

    $evento = Auditoria::query()
        ->where('accion', Auditoria::ACCION_ACCESO_DENEGADO)
        ->firstOrFail();

    expect($evento->tabla_afectada)->toBe('rutas')
        ->and($evento->referencia)->toBe('sgdea.usuarios.index')
        ->and($evento->usuario_id)->toBe($usuario->getKey())
        ->and($evento->user_agent)->toBe('AuditoriaDeniedTest/1.0')
        ->and($evento->datos_despues)->toBe([
            'metodo' => 'GET',
            'estado_http' => 403,
        ]);
});
