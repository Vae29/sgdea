<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['oficina_productora_id', 'nombre_completo', 'correo', 'contrasena', 'activo'])]
#[Hidden(['contrasena'])]
class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'usuario_id';

    protected $guarded = [];

    protected $rememberTokenName = '';

    public $timestamps = true;

    public const CREATED_AT = 'fecha_creacion';

    public const UPDATED_AT = 'fecha_modificacion';

    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
            'activo' => 'boolean',
            'fecha_creacion' => 'datetime',
            'fecha_modificacion' => 'datetime',
        ];
    }

    public function oficina(): BelongsTo
    {
        return $this->belongsTo(OficinaProductora::class, 'oficina_productora_id', 'oficina_productora_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario', 'usuario_id', 'rol_id')
            ->withPivot('rol_usuario_id', 'fecha_creacion', 'fecha_modificacion');
    }

    #[Scope]
    protected function activos(Builder $query): void
    {
        $query->where('activo', true);
    }

    public function getAuthPasswordName(): string
    {
        return 'contrasena';
    }

    public function getAuthIdentifierName(): string
    {
        return 'correo';
    }
}
