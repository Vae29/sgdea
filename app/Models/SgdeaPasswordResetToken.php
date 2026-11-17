<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SgdeaPasswordResetToken extends Model
{
    protected $table = 'sgdea_password_reset_tokens';

    protected $primaryKey = 'pass_reset_tokens_id';

    protected $guarded = [];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used' => 'boolean',
            'created_at' => 'datetime',
        ];
    }
}
