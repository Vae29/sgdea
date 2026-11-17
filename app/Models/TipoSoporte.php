<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSoporte extends Model
{
    protected $table = 'tipos_soportes';

    protected $primaryKey = 'tipo_soporte_id';

    protected $guarded = [];

    public $timestamps = false;
}
