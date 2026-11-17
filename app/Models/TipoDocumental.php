<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoDocumental extends Model
{
    use Auditable;

    protected $table = 'tipos_documentales';

    protected $primaryKey = 'tipo_documental_id';

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

    public function subserie(): BelongsTo
    {
        return $this->belongsTo(SubserieDocumental::class, 'subserie_id', 'subserie_id');
    }

    public function tipoSoporte(): BelongsTo
    {
        return $this->belongsTo(TipoSoporte::class, 'tipo_soporte_id', 'tipo_soporte_id');
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(DocumentoDigital::class, 'tipo_documental_id', 'tipo_documental_id');
    }

    #[Scope]
    protected function activos(Builder $query): void
    {
        $query->where('activo', true);
    }
}
