<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SerieDocumental extends Model
{
    protected $table = 'series_documentales';

    protected $primaryKey = 'serie_id';

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

    public function oficina(): BelongsTo
    {
        return $this->belongsTo(OficinaProductora::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    public function subseries(): HasMany
    {
        return $this->hasMany(SubserieDocumental::class, 'serie_id', 'serie_id');
    }

    public function tiposDocumentales(): HasMany
    {
        return $this->hasMany(TipoDocumental::class, 'serie_id', 'serie_id');
    }

    public function retenciones(): HasMany
    {
        return $this->hasMany(RetencionDocumental::class, 'serie_id', 'serie_id');
    }

    #[Scope]
    protected function activos(Builder $query): void
    {
        $query->where('activo', true);
    }
}
