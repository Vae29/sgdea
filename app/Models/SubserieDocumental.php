<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubserieDocumental extends Model
{
    use Auditable;

    protected $table = 'subseries_documentales';

    protected $primaryKey = 'subserie_id';

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

    public function serie(): BelongsTo
    {
        return $this->belongsTo(SerieDocumental::class, 'serie_id', 'serie_id');
    }

    public function tiposDocumentales(): HasMany
    {
        return $this->hasMany(TipoDocumental::class, 'subserie_id', 'subserie_id');
    }

    public function retenciones(): HasMany
    {
        return $this->hasMany(RetencionDocumental::class, 'subserie_id', 'subserie_id');
    }

    #[Scope]
    protected function activos(Builder $query): void
    {
        $query->where('activo', true);
    }
}
