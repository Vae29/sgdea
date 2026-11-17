<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AprobacionDisposicion extends Model
{
    protected $table = 'aprobaciones_disposicion';

    protected $primaryKey = 'aprobacion_id';

    protected $guarded = [];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'fecha_hora_aprobacion' => 'datetime',
            'fecha_creacion' => 'datetime',
        ];
    }

    public function solicitud(): BelongsTo
    {
        return $this->belongsTo(SolicitudDisposicion::class, 'solicitud_id', 'solicitud_id');
    }

    public function aprobador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'aprobado_por', 'usuario_id');
    }
}
