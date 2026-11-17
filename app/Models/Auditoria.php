<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auditoria extends Model
{
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

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
}
