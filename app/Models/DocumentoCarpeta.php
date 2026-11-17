<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentoCarpeta extends Model
{
    use Auditable;

    protected $table = 'documentos_carpeta';

    protected $primaryKey = 'documento_carpeta_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'numero_secuencia' => 'integer',
            'folio_inicial' => 'integer',
            'folio_final' => 'integer',
            'fecha_hora_incorporacion' => 'datetime',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function carpeta(): BelongsTo
    {
        return $this->belongsTo(CarpetaArchivo::class, 'carpeta_id', 'carpeta_id');
    }

    public function documento(): BelongsTo
    {
        return $this->belongsTo(DocumentoDigital::class, 'documento_id', 'documento_id');
    }

    public function incorporadoPor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'incorporado_por', 'usuario_id');
    }
}
