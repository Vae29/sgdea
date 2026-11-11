# Previsualización temporal del frontend (OPCIONAL)

Este paquete NO crea ni modifica rutas. Para ver las pantallas en el navegador usted debe decidir si agrega, de forma
temporal, las rutas de abajo en `routes/web.php`, y retirarlas cuando el backend defina las rutas reales.

```php
// TEMPORAL — solo para revisar el diseño. Retirar al integrar el backend.
Route::prefix('sgdea')->name('sgdea.')->group(function () {
    Route::view('/login', 'sgdea.auth.login')->name('login');
    Route::view('/recuperar-contrasena', 'sgdea.auth.forgot-password')->name('password.request');
    Route::view('/dashboard', 'sgdea.dashboard.index')->name('dashboard');
    Route::view('/ccd', 'sgdea.ccd.index')->name('ccd.index');
    Route::view('/trd', 'sgdea.trd.index')->name('trd.index');
    Route::view('/radicaciones', 'sgdea.radicaciones.index')->name('radicaciones.index');
    Route::view('/radicaciones/nueva', 'sgdea.radicaciones.create')->name('radicaciones.create');
    Route::view('/radicaciones/{id}', 'sgdea.radicaciones.show')->name('radicaciones.show');
    Route::view('/carpetas', 'sgdea.carpetas.index')->name('carpetas.index');
    Route::view('/carpetas/nueva', 'sgdea.carpetas.create')->name('carpetas.create');
    Route::view('/carpetas/{id}', 'sgdea.carpetas.show')->name('carpetas.show');
    Route::view('/cierre', 'sgdea.cierre.index')->name('cierre.index');
    Route::view('/cierre/{id}', 'sgdea.cierre.show')->name('cierre.show');
    Route::view('/fuid', 'sgdea.fuid.index')->name('fuid.index');
    Route::view('/fuid/{id}', 'sgdea.fuid.show')->name('fuid.show');
    Route::view('/usuarios', 'sgdea.usuarios.index')->name('usuarios.index');
    Route::view('/auditorias', 'sgdea.auditorias.index')->name('auditorias.index');
    Route::view('/transferencias', 'sgdea.transferencias.index')->name('transferencias.index');
    Route::view('/documentos', 'sgdea.documentos.index')->name('documentos.index');
    Route::view('/documentos/nuevo', 'sgdea.documentos.create')->name('documentos.create');
    Route::view('/documentos/{id}', 'sgdea.documentos.show')->name('documentos.show');
});
```

URLs resultantes: `/sgdea/login`, `/sgdea/recuperar-contrasena`, `/sgdea/dashboard`, `/sgdea/ccd`, `/sgdea/trd`, `/sgdea/radicaciones` y `/sgdea/documentos`, `/sgdea/carpetas`, `/sgdea/cierre`, `/sgdea/fuid`, `/sgdea/usuarios`, `/sgdea/auditorias` y `/sgdea/transferencias` (con sus pantallas de registro y detalle; ej. `/sgdea/carpetas/5` es una carpeta cerrada y `/sgdea/carpetas/3` una híbrida abierta).
Importante: declare `/radicaciones/nueva`, `/documentos/nuevo` y `/carpetas/nueva` antes de las rutas con `{id}`, como está arriba.
Los enlaces del menú lateral hacia pantallas aún no entregadas se muestran como "pendientes" y no producen error.
Si cambia el nombre de las rutas, el menú las detecta automáticamente (usa `Route::has`).
