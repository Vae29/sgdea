<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('login.store');

    Route::get('/sgdea/login', [AuthenticatedSessionController::class, 'create'])
        ->name('sgdea.login');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['auth', 'active'])
    ->name('logout');

Route::get('/dashboard', fn () => redirect()->route('sgdea.dashboard'))
    ->middleware(['auth', 'active'])
    ->name('dashboard');

Route::get('/', fn () => redirect()->route('sgdea.dashboard'));

require __DIR__.'/sgdea.php';
