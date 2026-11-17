<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use LogicException;

class Auditoria extends Model
{
    public const ACCION_CREACION = 'creacion';

    public const ACCION_CONSULTA = 'consulta';

    public const ACCION_MODIFICACION = 'modificacion';

    public const ACCION_CIERRE = 'cierre';

    public const ACCION_TRANSFERENCIA = 'transferencia';

    public const ACCION_INTENTO_FALLIDO = 'intento_fallido';

    public const ACCION_ACCESO_DENEGADO = 'acceso_denegado';

    public const ACCION_ELIMINACION = 'eliminacion';

    protected $table = 'auditorias';

    protected $primaryKey = 'auditoria_id';

    protected $guarded = [];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'id_campo_afectado' => 'integer',
            'datos_antes' => 'array',
            'datos_despues' => 'array',
            'fecha_hora_evento' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::updating(static function (): never {
            throw new LogicException('Audit records cannot be updated.');
        });

        static::deleting(static function (): never {
            throw new LogicException('Audit records cannot be deleted.');
        });
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
}
