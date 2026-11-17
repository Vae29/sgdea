<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadAdministrativa extends Model
{
    use Auditable;

    protected $table = 'unidades_administrativas';

    protected $primaryKey = 'unidad_administrativa_id';

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

    public function fondo(): BelongsTo
    {
        return $this->belongsTo(FondoDocumental::class, 'fondo_id', 'fondo_id');
    }

    public function oficinas(): HasMany
    {
        return $this->hasMany(OficinaProductora::class, 'unidad_administrativa_id', 'unidad_administrativa_id');
    }

    #[Scope]
    protected function activos(Builder $query): void
    {
        $query->where('activo', true);
    }
}
