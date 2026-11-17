<?php

use App\Http\Middleware\EnsureUsuarioActivo;
use App\Models\Auditoria;
use App\Services\AuditoriaService;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'active' => EnsureUsuarioActivo::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (HttpExceptionInterface $exception, Request $request) {
            if ($exception->getStatusCode() !== 403) {
                return null;
            }

            app(AuditoriaService::class)->registrar(
                Auditoria::ACCION_ACCESO_DENEGADO,
                'rutas',
                antes: null,
                despues: [
                    'metodo' => $request->method(),
                    'estado_http' => 403,
                ],
                referencia: $request->route()?->getName() ?? $request->path(),
            );

            return null;
        });
    })->create();
