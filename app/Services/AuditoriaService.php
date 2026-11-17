<?php

namespace App\Services;

use App\Models\Auditoria;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class AuditoriaService
{
    public function registrar(
        string $accion,
        string $tabla,
        ?int $id = null,
        ?array $antes = null,
        ?array $despues = null,
        ?string $referencia = null,
    ): Auditoria {
        $usuario = Auth::user();

        return Auditoria::query()->create([
            'usuario_id' => $usuario instanceof Usuario ? $usuario->getKey() : null,
            'accion' => $accion,
            'tabla_afectada' => $tabla,
            'id_campo_afectado' => $id,
            'direccion_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'datos_antes' => $antes,
            'datos_despues' => $despues,
            'referencia' => $referencia,
            'fecha_hora_evento' => now(),
        ]);
    }
}
