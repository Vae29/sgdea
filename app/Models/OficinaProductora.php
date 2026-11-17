<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OficinaProductora extends Model
{
    protected $table = 'oficinas_productoras';

    protected $primaryKey = 'oficina_productora_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function unidad(): BelongsTo
    {
        return $this->belongsTo(UnidadAdministrativa::class, 'unidad_administrativa_id', 'unidad_administrativa_id');
    }

    public function series(): HasMany
    {
        return $this->hasMany(SerieDocumental::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    public function radicaciones(): HasMany
    {
        return $this->hasMany(Radicacion::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    public function cajas(): HasMany
    {
        return $this->hasMany(CajaAlmacenamiento::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    #[Scope]
    protected function activos(Builder $query): void
    {
        $query->where('activo', true);
    }
}
