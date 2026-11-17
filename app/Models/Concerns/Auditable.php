<?php

namespace App\Models\Concerns;

use App\Models\Auditoria as RegistroAuditoria;
use App\Services\AuditoriaService;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    private const AUDIT_EXCLUDED_ATTRIBUTES = [
        'contrasena',
        'password',
        'password_confirmation',
        'remember_token',
        'token',
        'code',
        'refresh_token_hash',
    ];

    protected static function bootAuditable(): void
    {
        static::created(function (Model $model): void {
            $model->registrarEventoAuditoria(
                RegistroAuditoria::ACCION_CREACION,
                null,
                $model->getAttributes(),
            );
        });

        static::updated(function (Model $model): void {
            $model->registrarEventoAuditoria(
                RegistroAuditoria::ACCION_MODIFICACION,
                $model->getOriginal(),
                $model->getAttributes(),
            );
        });

        static::deleted(function (Model $model): void {
            $model->registrarEventoAuditoria(
                RegistroAuditoria::ACCION_ELIMINACION,
                $model->getOriginal(),
                null,
            );
        });
    }

    protected function registrarEventoAuditoria(
        string $accion,
        ?array $antes,
        ?array $despues,
    ): void {
        app(AuditoriaService::class)->registrar(
            $accion,
            $this->getTable(),
            (int) $this->getKey(),
            $this->filtrarCamposSensibles($antes),
            $this->filtrarCamposSensibles($despues),
            (string) $this->getKey(),
        );
    }

    private function filtrarCamposSensibles(?array $atributos): ?array
    {
        if ($atributos === null) {
            return null;
        }

        return array_diff_key($atributos, array_flip(self::AUDIT_EXCLUDED_ATTRIBUTES));
    }
}
