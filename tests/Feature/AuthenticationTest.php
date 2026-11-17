<?php

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

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticatedAs($usuario);
});

test('dashboard requires authentication and displays the authenticated user', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));

    $usuario = createSgdeaUser();

    $this->actingAs($usuario)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSeeText($usuario->nombre_completo);
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
