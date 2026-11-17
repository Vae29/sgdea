<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'active'])
    ->prefix('sgdea')
    ->name('sgdea.')
    ->group(function (): void {
        Route::view('/dashboard', 'sgdea.dashboard.index')
            ->middleware('can:dashboard.ver')
            ->name('dashboard');

        Route::view('/ccd', 'sgdea.ccd.index')
            ->middleware('can:ccd.ver')
            ->name('ccd.index');

        Route::view('/trd', 'sgdea.trd.index')
            ->middleware('can:trd.ver')
            ->name('trd.index');

        Route::view('/radicaciones', 'sgdea.radicaciones.index')
            ->middleware('can:radicacion.ver')
            ->name('radicaciones.index');
        Route::view('/radicaciones/nueva', 'sgdea.radicaciones.create')
            ->middleware('can:radicacion.crear')
            ->name('radicaciones.create');
        Route::view('/radicaciones/{id}', 'sgdea.radicaciones.show')
            ->middleware('can:radicacion.ver')
            ->name('radicaciones.show');

        Route::view('/documentos', 'sgdea.documentos.index')
            ->middleware('can:documento.ver')
            ->name('documentos.index');
        Route::view('/documentos/nuevo', 'sgdea.documentos.create')
            ->middleware('can:documento.crear')
            ->name('documentos.create');
        Route::view('/documentos/{id}', 'sgdea.documentos.show')
            ->middleware('can:documento.ver')
            ->name('documentos.show');

        Route::view('/carpetas', 'sgdea.carpetas.index')
            ->middleware('can:carpeta.ver')
            ->name('carpetas.index');
        Route::view('/carpetas/nueva', 'sgdea.carpetas.create')
            ->middleware('can:carpeta.crear')
            ->name('carpetas.create');
        Route::view('/carpetas/{id}', 'sgdea.carpetas.show')
            ->middleware('can:carpeta.ver')
            ->name('carpetas.show');
        Route::view('/cierre', 'sgdea.cierre.index')
            ->middleware('can:carpeta.cerrar')
            ->name('cierre.index');
        Route::view('/cierre/{id}', 'sgdea.cierre.show')
            ->middleware('can:carpeta.cerrar')
            ->name('cierre.show');

        Route::view('/fuid', 'sgdea.fuid.index')
            ->middleware('can:fuid.ver')
            ->name('fuid.index');
        Route::view('/fuid/{id}', 'sgdea.fuid.show')
            ->middleware('can:fuid.ver')
            ->name('fuid.show');
        Route::view('/transferencias', 'sgdea.transferencias.index')
            ->middleware('can:transferencia.ver')
            ->name('transferencias.index');
        Route::view('/usuarios', 'sgdea.usuarios.index')
            ->middleware('can:usuarios.administrar')
            ->name('usuarios.index');
        Route::view('/auditorias', 'sgdea.auditorias.index')
            ->middleware('can:auditoria.ver')
            ->name('auditorias.index');
    });
