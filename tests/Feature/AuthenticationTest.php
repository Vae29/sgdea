<?php

use App\Models\FondoDocumental;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

function createSgdeaUser(array $attributes = []): Usuario
{
    return Usuario::query()->create(array_merge([
        'nombre_completo' => 'Usuario de prueba',
        'correo' => 'usuario@example.test',
        'contrasena' => Hash::make('password-segura'),
        'activo' => true,
    ], $attributes));
}

test('login page displays the email and password form', function () {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('name="correo"', false)
        ->assertSee('name="password"', false);
});

test('login authenticates with an active account from usuarios', function () {
    $usuario = createSgdeaUser();

    $response = $this->post(route('login.store'), [
        'correo' => $usuario->correo,
        'password' => 'password-segura',
    ]);

    $response->assertRedirect(route('sgdea.dashboard'));
    $this->assertAuthenticatedAs($usuario);
});

test('protected SGDEA routes redirect guests to login', function () {
    $this->get(route('sgdea.dashboard'))->assertRedirect(route('login'));
    $this->get(route('sgdea.usuarios.index'))->assertRedirect(route('login'));
});

test('the SGDEA panel shows the authenticated user role and office without demo data', function () {
    $fondo = FondoDocumental::create([
        'codigo' => 'F-AUTH-TEST',
        'nombre' => 'Fondo de autenticación',
        'activo' => true,
    ]);
    $unidad = $fondo->unidades()->create([
        'codigo' => 'U-AUTH-TEST',
        'nombre' => 'Unidad de autenticación',
        'activo' => true,
    ]);
    $oficina = $unidad->oficinas()->create([
        'codigo' => 'O-AUTH-TEST',
        'nombre' => 'Oficina real',
        'activo' => true,
    ]);
    $usuario = createSgdeaUser(['oficina_productora_id' => $oficina->getKey()]);
    $rol = Rol::create(['nombre' => 'Administrador']);
    $usuario->roles()->attach($rol->getKey(), [
        'fecha_creacion' => now(),
        'fecha_modificacion' => now(),
    ]);

    $this->actingAs($usuario)
        ->get(route('sgdea.dashboard'))
        ->assertOk()
        ->assertSeeText($usuario->nombre_completo)
        ->assertSeeText('Administrador')
        ->assertSeeText('Oficina real')
        ->assertSeeText('Sin notificaciones.')
        ->assertDontSee('MODO DEMOSTRACIÓN DEL FRONTEND')
        ->assertDontSee('Usuario de demostración');
});

test('an authenticated inactive account is logged out from SGDEA', function () {
    $usuario = createSgdeaUser(['activo' => false]);

    $this->actingAs($usuario)
        ->get(route('sgdea.dashboard'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('login rejects an inactive account', function () {
    $usuario = createSgdeaUser(['activo' => false]);

    $response = $this->from(route('login'))->post(route('login.store'), [
        'correo' => $usuario->correo,
        'password' => 'password-segura',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('correo');
    $this->assertGuest();
});

test('Auth attempt identifies active users by email and rejects inactive users', function () {
    $activeUsuario = createSgdeaUser(['correo' => 'activo@example.test']);
    $inactiveUsuario = createSgdeaUser([
        'correo' => 'inactivo@example.test',
        'activo' => false,
    ]);

    expect(config('auth.providers.users.model'))->toBe(Usuario::class)
        ->and(Auth::attempt([
            'correo' => $activeUsuario->correo,
            'password' => 'password-segura',
            'activo' => 1,
        ]))->toBeTrue()
        ->and(Auth::id())->toBe($activeUsuario->correo);

    Auth::logout();

    expect(Auth::attempt([
        'correo' => $inactiveUsuario->correo,
        'password' => 'password-segura',
        'activo' => 1,
    ]))->toBeFalse()
        ->and(Auth::guest())->toBeTrue();
});

test('remember tokens are disabled because usuarios has no remember token column', function () {
    $usuario = createSgdeaUser();

    expect(Schema::hasColumn('usuarios', 'remember_token'))->toBeFalse()
        ->and($usuario->getRememberTokenName())->toBe('')
        ->and($usuario->getRememberToken())->toBeNull();
});

test('login rejects an incorrect password', function () {
    $usuario = createSgdeaUser();

    $response = $this->from(route('login'))->post(route('login.store'), [
        'correo' => $usuario->correo,
        'password' => 'incorrecta',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors('correo');
    $this->assertGuest();
});

test('logout ends the authenticated session', function () {
    $usuario = createSgdeaUser();

    $response = $this->actingAs($usuario)->post(route('logout'));

    $response->assertRedirect(route('login'));
    $this->assertGuest();
});

test('laravel sessions is the only web session table', function () {
    expect(Schema::hasTable('sessions'))->toBeTrue()
        ->and(Schema::hasTable('sesiones'))->toBeFalse();
});
