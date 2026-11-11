<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('login.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::view('/dashboard', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::get('/', function () {
    return view('welcome');
});

// ===== TEMPORAL: solo para revisar el diseño del SGDEA. Retirar al integrar el backend. =====
Route::prefix('sgdea')->name('sgdea.')->group(function () {
    // Acceso
    Route::view('/login', 'sgdea.auth.login')->name('login');
    Route::view('/recuperar-contrasena', 'sgdea.auth.forgot-password')->name('password.request');
    Route::view('/dashboard', 'sgdea.dashboard.index')->name('dashboard');

    // Instrumentos archivísticos
    Route::view('/ccd', 'sgdea.ccd.index')->name('ccd.index');
    Route::view('/trd', 'sgdea.trd.index')->name('trd.index');

    // Radicación (las rutas «nueva» van ANTES de las que llevan {id})
    Route::view('/radicaciones', 'sgdea.radicaciones.index')->name('radicaciones.index');
    Route::view('/radicaciones/nueva', 'sgdea.radicaciones.create')->name('radicaciones.create');
    Route::view('/radicaciones/{id}', 'sgdea.radicaciones.show')->name('radicaciones.show');

    // Documentos digitales
    Route::view('/documentos', 'sgdea.documentos.index')->name('documentos.index');
    Route::view('/documentos/nuevo', 'sgdea.documentos.create')->name('documentos.create');
    Route::view('/documentos/{id}', 'sgdea.documentos.show')->name('documentos.show');

    // Carpetas y cierre
    Route::view('/carpetas', 'sgdea.carpetas.index')->name('carpetas.index');
    Route::view('/carpetas/nueva', 'sgdea.carpetas.create')->name('carpetas.create');
    Route::view('/carpetas/{id}', 'sgdea.carpetas.show')->name('carpetas.show');
    Route::view('/cierre', 'sgdea.cierre.index')->name('cierre.index');
    Route::view('/cierre/{id}', 'sgdea.cierre.show')->name('cierre.show');

    // Inventario, transferencias, usuarios y auditoría
    Route::view('/fuid', 'sgdea.fuid.index')->name('fuid.index');
    Route::view('/fuid/{id}', 'sgdea.fuid.show')->name('fuid.show');
    Route::view('/transferencias', 'sgdea.transferencias.index')->name('transferencias.index');
    Route::view('/usuarios', 'sgdea.usuarios.index')->name('usuarios.index');
    Route::view('/auditorias', 'sgdea.auditorias.index')->name('auditorias.index');
});
// ===== FIN TEMPORAL =====
