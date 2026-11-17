<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;

class ConsecutivoRadicacion extends Model
{
    use Auditable;

    protected $table = 'consecutivos_radicacion';

    protected $primaryKey = 'consecutivo_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'anio' => 'integer',
            'ultimo_consecutivo' => 'integer',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }
}
