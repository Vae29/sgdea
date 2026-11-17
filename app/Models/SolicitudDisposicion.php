<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolicitudDisposicion extends Model
{
    protected $table = 'solicitudes_disposicion';

    protected $primaryKey = 'solicitud_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'fecha_hora_solicitud' => 'datetime',
            'completado_en' => 'datetime',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function aprobaciones(): HasMany
    {
        return $this->hasMany(AprobacionDisposicion::class, 'solicitud_id', 'solicitud_id');
    }
}
