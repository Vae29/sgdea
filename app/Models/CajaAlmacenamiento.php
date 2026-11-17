<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CajaAlmacenamiento extends Model
{
    protected $table = 'cajas_almacenamiento';

    protected $primaryKey = 'caja_almacenamiento_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'anio' => 'integer',
            'fecha_inicial' => 'date',
            'fecha_final' => 'date',
            'total_carpetas' => 'integer',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function oficina(): BelongsTo
    {
        return $this->belongsTo(OficinaProductora::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    public function carpetas(): HasMany
    {
        return $this->hasMany(CarpetaArchivo::class, 'caja_almacenamiento_id', 'caja_almacenamiento_id');
    }

    #[Scope]
    protected function activos(Builder $query): void
    {
        $query->where('estado', 'Activa');
    }
}
