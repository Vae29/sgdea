<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemTransferenciaDocumental extends Model
{
    use Auditable;

    protected $table = 'items_transferencia_documental';

    protected $primaryKey = 'item_tranferencia_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function transferencia(): BelongsTo
    {
        return $this->belongsTo(TransferenciaDocumental::class, 'transferencia_id', 'transferencia_id');
    }

    public function carpeta(): BelongsTo
    {
        return $this->belongsTo(CarpetaArchivo::class, 'carpeta_id', 'carpeta_id');
    }
}
