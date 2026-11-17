<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentoDigital extends Model
{
    use Auditable;

    protected $table = 'documentos_digitales';

    protected $primaryKey = 'documento_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'fecha_produccion' => 'date',
            'cantidad_folios' => 'integer',
            'cantidad_paginas' => 'integer',
            'tamano_bytes' => 'integer',
            'metadatos_json' => 'array',
            'hora_carga' => 'datetime',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function radicacion(): BelongsTo
    {
        return $this->belongsTo(Radicacion::class, 'radicacion_id', 'radicacion_id');
    }

    public function tipoDocumental(): BelongsTo
    {
        return $this->belongsTo(TipoDocumental::class, 'tipo_documental_id', 'tipo_documental_id');
    }

    public function carpetas(): BelongsToMany
    {
        return $this->belongsToMany(CarpetaArchivo::class, 'documentos_carpeta', 'documento_id', 'carpeta_id')
            ->withPivot('documento_carpeta_id', 'numero_secuencia', 'folio_inicial', 'folio_final', 'fecha_hora_incorporacion', 'incorporado_por', 'fecha_creacion', 'fecha_modificacion');
    }

    public function documentosCarpeta(): HasMany
    {
        return $this->hasMany(DocumentoCarpeta::class, 'documento_id', 'documento_id');
    }

    public function subidoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'subido_por', 'usuario_id');
    }
}
