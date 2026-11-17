<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Radicacion extends Model
{
    protected $table = 'radicaciones';

    protected $primaryKey = 'radicacion_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'anio_radicado' => 'integer',
            'numero_consecutivo' => 'integer',
            'datos_remitente' => 'array',
            'datos_destinatario' => 'array',
            'fecha_hora_radicacion' => 'datetime',
            'cantidad_folios' => 'integer',
            'cantidad_anexos' => 'integer',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function padre(): BelongsTo
    {
        return $this->belongsTo(self::class, 'radicado_padre_id', 'radicacion_id');
    }

    public function hijos(): HasMany
    {
        return $this->hasMany(self::class, 'radicado_padre_id', 'radicacion_id');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(DocumentoDigital::class, 'radicacion_id', 'radicacion_id');
    }

    public function oficina(): BelongsTo
    {
        return $this->belongsTo(OficinaProductora::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'usuario_id');
    }
}
