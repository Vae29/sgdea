<?php

namespace App\Models;

use App\Models\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;

class TipoSoporte extends Model
{
    use Auditable;

    protected $table = 'tipos_soportes';

    protected $primaryKey = 'tipo_soporte_id';

    protected $guarded = [];

    public $timestamps = false;
}
