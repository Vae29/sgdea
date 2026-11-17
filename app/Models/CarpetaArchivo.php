<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarpetaArchivo extends Model
{
    use Auditable;

    protected $table = 'carpetas_archivo';

    protected $primaryKey = 'carpeta_id';

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
            'fecha_apertura' => 'date',
            'fecha_cierre' => 'date',
            'cantidad_folios' => 'integer',
            'indice_sellado' => 'datetime',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function caja(): BelongsTo
    {
        return $this->belongsTo(CajaAlmacenamiento::class, 'caja_almacenamiento_id', 'caja_almacenamiento_id');
    }

    public function documentosCarpeta(): HasMany
    {
        return $this->hasMany(DocumentoCarpeta::class, 'carpeta_id', 'carpeta_id');
    }

    public function documentos(): BelongsToMany
    {
        return $this->belongsToMany(DocumentoDigital::class, 'documentos_carpeta', 'carpeta_id', 'documento_id')
            ->withPivot('documento_carpeta_id', 'numero_secuencia', 'folio_inicial', 'folio_final', 'fecha_hora_incorporacion', 'incorporado_por', 'fecha_creacion', 'fecha_modificacion');
    }

    public function oficina(): BelongsTo
    {
        return $this->belongsTo(OficinaProductora::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    public function serie(): BelongsTo
    {
        return $this->belongsTo(SerieDocumental::class, 'serie_id', 'serie_id');
    }

    public function subserie(): BelongsTo
    {
        return $this->belongsTo(SubserieDocumental::class, 'subserie_id', 'subserie_id');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuario_creador', 'usuario_id');
    }

    #[Scope]
    protected function abiertas(Builder $query): void
    {
        $query->where('estado', 'Abierta');
    }

    #[Scope]
    protected function cerradas(Builder $query): void
    {
        $query->where('estado', 'Cerrada');
    }
}
