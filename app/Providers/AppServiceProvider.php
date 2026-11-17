<?php

namespace App\Providers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewInstance;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('esDemo', false);

        View::composer('sgdea.partials.topbar', function (ViewInstance $view): void {
            $usuario = Auth::user();

            if ($usuario instanceof Usuario) {
                $usuario->loadMissing(['roles', 'oficina']);
            }

            $view->with('usuarioActual', [
                'nombre_completo' => $usuario instanceof Usuario ? $usuario->nombre_completo : 'Usuario',
                'rol' => $usuario instanceof Usuario
                    ? ($usuario->roles->pluck('nombre')->implode(', ') ?: 'Sin rol')
                    : 'Sin rol',
                'oficina' => $usuario instanceof Usuario
                    ? ($usuario->oficina?->nombre ?? 'Sin oficina')
                    : 'Sin oficina',
            ]);
            $view->with('notificaciones', []);
        });

        foreach (array_keys(config('sgdea_permisos.permisos', [])) as $permiso) {
            Gate::define(
                $permiso,
                fn (Usuario $usuario): bool => $usuario->tienePermiso($permiso),
            );
        }
    }
}
