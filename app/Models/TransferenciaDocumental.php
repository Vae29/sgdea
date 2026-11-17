<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransferenciaDocumental extends Model
{
    use Auditable;

    protected $table = 'transferencias_documentales';

    protected $primaryKey = 'transferencia_id';

    protected $guarded = [];

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'fecha_transferencia' => 'date',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(ItemTransferenciaDocumental::class, 'transferencia_id', 'transferencia_id');
    }
}
