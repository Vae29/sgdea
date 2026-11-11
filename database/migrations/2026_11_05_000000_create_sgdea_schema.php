<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fondos_documentales', function (Blueprint $table) {
            $table->id('fondo_id');
            $table->text('codigo')->unique();
            $table->text('nombre');
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('unidades_administrativas', function (Blueprint $table) {
            $table->id('unidad_administrativa_id');
            $table->foreignId('fondo_id')->constrained('fondos_documentales', 'fondo_id');
            $table->text('codigo');
            $table->text('nombre');
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('oficinas_productoras', function (Blueprint $table) {
            $table->id('oficina_productora_id');
            $table->foreignId('unidad_administrativa_id')
                ->nullable()
                ->constrained('unidades_administrativas', 'unidad_administrativa_id');
            $table->text('codigo');
            $table->text('nombre');
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('series_documentales', function (Blueprint $table) {
            $table->id('serie_id');
            $table->foreignId('oficina_productora_id')
                ->constrained('oficinas_productoras', 'oficina_productora_id');
            $table->text('codigo');
            $table->text('nombre');
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('subseries_documentales', function (Blueprint $table) {
            $table->id('subserie_id');
            $table->foreignId('serie_id')->constrained('series_documentales', 'serie_id');
            $table->text('codigo');
            $table->text('nombre');
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('tipos_soportes', function (Blueprint $table) {
            $table->id('tipo_soporte_id');
            $table->text('nombre');
        });

        Schema::create('tipos_documentales', function (Blueprint $table) {
            $table->id('tipo_documental_id');
            $table->foreignId('serie_id')->constrained('series_documentales', 'serie_id');
            $table->foreignId('subserie_id')
                ->nullable()
                ->constrained('subseries_documentales', 'subserie_id');
            $table->text('nombre');
            $table->foreignId('tipo_soporte_id')->constrained('tipos_soportes', 'tipo_soporte_id');
            $table->text('especificacion_formato')->nullable();
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('retencion_documental', function (Blueprint $table) {
            $table->id('retencion_id');
            $table->foreignId('serie_id')->constrained('series_documentales', 'serie_id');
            $table->foreignId('subserie_id')
                ->nullable()
                ->constrained('subseries_documentales', 'subserie_id');
            $table->integer('anios_gestion')->nullable();
            $table->integer('anios_central')->nullable();
            $table->text('disposicion_final')->nullable();
            $table->text('procedimiento')->nullable();
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('cajas_almacenamiento', function (Blueprint $table) {
            $table->id('caja_almacenamiento_id');
            $table->foreignId('oficina_productora_id')
                ->constrained('oficinas_productoras', 'oficina_productora_id');
            $table->text('numero_caja');
            $table->integer('anio');
            $table->text('codigo_dependencia')->nullable();
            $table->text('nombre_dependencia')->nullable();
            $table->date('fecha_inicial')->nullable();
            $table->date('fecha_final')->nullable();
            $table->integer('total_carpetas')->default(0);
            $table->text('numero_caja_central')->nullable();
            $table->text('estante')->nullable();
            $table->text('entrepano')->nullable();
            $table->text('ubicacion_fisica')->nullable();
            $table->text('estado')->default('Activa');
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->foreignId('oficina_productora_id')
                ->nullable()
                ->constrained('oficinas_productoras', 'oficina_productora_id');
            $table->text('nombre_completo');
            $table->text('correo')->unique();
            $table->text('contrasena');
            $table->boolean('activo')->default(true);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id('rol_id');
            $table->text('nombre')->unique();
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('rol_usuario', function (Blueprint $table) {
            $table->id('rol_usuario_id');
            $table->foreignId('usuario_id')->constrained('usuarios', 'usuario_id');
            $table->foreignId('rol_id')->constrained('roles', 'rol_id');
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('carpetas_archivo', function (Blueprint $table) {
            $table->id('carpeta_id');
            $table->foreignId('caja_almacenamiento_id')
                ->nullable()
                ->constrained('cajas_almacenamiento', 'caja_almacenamiento_id');
            $table->foreignId('oficina_productora_id')
                ->constrained('oficinas_productoras', 'oficina_productora_id');
            $table->foreignId('serie_id')->constrained('series_documentales', 'serie_id');
            $table->foreignId('subserie_id')
                ->nullable()
                ->constrained('subseries_documentales', 'subserie_id');
            $table->text('numero_asignado');
            $table->text('nombre_carpeta');
            $table->integer('anio');
            $table->date('fecha_inicial')->nullable();
            $table->date('fecha_final')->nullable();
            $table->date('fecha_apertura')->nullable();
            $table->date('fecha_cierre')->nullable();
            $table->integer('cantidad_folios')->nullable();
            $table->foreignId('tipo_soporte_id')->constrained('tipos_soportes', 'tipo_soporte_id');
            $table->text('nivel_acceso');
            $table->text('fase_archivo');
            $table->text('estado')->default('Abierta');
            $table->dateTime('indice_sellado')->nullable();
            $table->foreignId('usuario_creador')
                ->nullable()
                ->constrained('usuarios', 'usuario_id');
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('radicaciones', function (Blueprint $table) {
            $table->id('radicacion_id');
            $table->text('numero_radicado')->unique();
            $table->integer('anio_radicado');
            $table->integer('numero_consecutivo');
            $table->text('tipo');
            $table->foreignId('radicado_padre_id')
                ->nullable()
                ->constrained('radicaciones', 'radicacion_id');
            $table->text('asunto');
            $table->text('datos_remitente')->nullable();
            $table->text('datos_destinatario')->nullable();
            $table->text('correo_solicitante')->nullable();
            $table->foreignId('oficina_productora_id')
                ->constrained('oficinas_productoras', 'oficina_productora_id');
            $table->foreignId('usuario_id')->constrained('usuarios', 'usuario_id');
            $table->dateTime('fecha_hora_radicacion');
            $table->integer('cantidad_folios')->nullable();
            $table->integer('cantidad_anexos')->nullable();
            $table->text('estado');
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('documentos_digitales', function (Blueprint $table) {
            $table->id('documento_id');
            $table->foreignId('radicacion_id')
                ->nullable()
                ->constrained('radicaciones', 'radicacion_id');
            $table->foreignId('tipo_documental_id')
                ->constrained('tipos_documentales', 'tipo_documental_id');
            $table->text('titulo');
            $table->date('fecha_produccion');
            $table->integer('cantidad_folios')->nullable();
            $table->integer('cantidad_paginas')->nullable();
            $table->text('soporte_origen');
            $table->text('nivel_acceso');
            $table->text('nombre_original_archivo');
            $table->text('ruta_archivo');
            $table->text('tipo_mime');
            $table->bigInteger('tamano_bytes');
            $table->text('hash_sha256');
            $table->text('metadatos_json')->nullable();
            $table->foreignId('subido_por')->constrained('usuarios', 'usuario_id');
            $table->dateTime('hora_carga');
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('documentos_carpeta', function (Blueprint $table) {
            $table->id('documento_carpeta_id');
            $table->foreignId('carpeta_id')->constrained('carpetas_archivo', 'carpeta_id');
            $table->foreignId('documento_id')->constrained('documentos_digitales', 'documento_id');
            $table->integer('numero_secuencia');
            $table->integer('folio_inicial')->nullable();
            $table->integer('folio_final')->nullable();
            $table->dateTime('fecha_hora_incorporacion');
            $table->foreignId('incorporado_por')->constrained('usuarios', 'usuario_id');
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('consecutivos_radicacion', function (Blueprint $table) {
            $table->id('consecutivo_id');
            $table->integer('anio');
            $table->text('tipo_mime');
            $table->integer('ultimo_consecutivo')->default(0);
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('auditorias', function (Blueprint $table) {
            $table->id('auditoria_id');
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios', 'usuario_id');
            $table->text('accion');
            $table->text('tabla_afectada');
            $table->integer('id_campo_afectado')->nullable();
            $table->text('direccion_ip')->nullable();
            $table->text('datos_antes')->nullable();
            $table->text('datos_despues')->nullable();
            $table->dateTime('fecha_hora_evento');
        });

        Schema::create('transferencias_documentales', function (Blueprint $table) {
            $table->id('transferencia_id');
            $table->text('codigo_transferencia')->unique();
            $table->text('tipo_transferencia');
            $table->text('fase_origen');
            $table->text('fase_destino');
            $table->date('fecha_transferencia')->nullable();
            $table->text('estado');
            $table->text('numero_acta')->nullable();
            $table->foreignId('creado_por')->constrained('usuarios', 'usuario_id');
            $table->foreignId('aprobado_por')->nullable()->constrained('usuarios', 'usuario_id');
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('items_transferencia_documental', function (Blueprint $table) {
            $table->id('item_tranferencia_id');
            $table->foreignId('transferencia_id')
                ->constrained('transferencias_documentales', 'transferencia_id');
            $table->foreignId('carpeta_id')->constrained('carpetas_archivo', 'carpeta_id');
            $table->text('notas')->nullable();
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('solicitudes_disposicion', function (Blueprint $table) {
            $table->id('solicitud_id');
            $table->foreignId('carpeta_id')->constrained('carpetas_archivo', 'carpeta_id');
            $table->text('tipo_disposicion');
            $table->text('numero_acta')->nullable();
            $table->text('referencia_acta')->nullable();
            $table->text('estado');
            $table->foreignId('solicitado_por')->constrained('usuarios', 'usuario_id');
            $table->dateTime('fecha_hora_solicitud');
            $table->dateTime('completado_en')->nullable();
            $table->dateTime('fecha_creacion')->nullable();
            $table->dateTime('fecha_modificacion')->nullable();
        });

        Schema::create('aprobaciones_disposicion', function (Blueprint $table) {
            $table->id('aprobacion_id');
            $table->foreignId('solicitud_id')
                ->constrained('solicitudes_disposicion', 'solicitud_id');
            $table->foreignId('aprobado_por')->constrained('usuarios', 'usuario_id');
            $table->text('estado');
            $table->text('comentarios')->nullable();
            $table->dateTime('fecha_hora_aprobacion')->nullable();
            $table->dateTime('fecha_creacion')->nullable();
        });

        Schema::create('sesiones', function (Blueprint $table) {
            $table->id('sesion_id');
            $table->foreignId('usuario_id')->constrained('usuarios', 'usuario_id');
            $table->text('refresh_token_hash');
            $table->text('dispositivo')->nullable();
            $table->text('ip_address')->nullable();
            $table->boolean('activa')->default(true);
            $table->dateTime('fecha_creacion')->useCurrent();
            $table->dateTime('fecha_expiracion');
            $table->dateTime('fecha_cierre')->useCurrent();
        });

        Schema::create('sgdea_password_reset_tokens', function (Blueprint $table) {
            $table->id('pass_reset_tokens_id');
            $table->foreignId('usuario_id')->constrained('usuarios', 'usuario_id');
            $table->text('code');
            $table->dateTime('expires_at')->useCurrent();
            $table->boolean('used')->default(false);
            $table->dateTime('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sgdea_password_reset_tokens');
        Schema::dropIfExists('sesiones');
        Schema::dropIfExists('aprobaciones_disposicion');
        Schema::dropIfExists('solicitudes_disposicion');
        Schema::dropIfExists('items_transferencia_documental');
        Schema::dropIfExists('transferencias_documentales');
        Schema::dropIfExists('auditorias');
        Schema::dropIfExists('consecutivos_radicacion');
        Schema::dropIfExists('documentos_carpeta');
        Schema::dropIfExists('documentos_digitales');
        Schema::dropIfExists('radicaciones');
        Schema::dropIfExists('carpetas_archivo');
        Schema::dropIfExists('rol_usuario');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('cajas_almacenamiento');
        Schema::dropIfExists('retencion_documental');
        Schema::dropIfExists('tipos_documentales');
        Schema::dropIfExists('tipos_soportes');
        Schema::dropIfExists('subseries_documentales');
        Schema::dropIfExists('series_documentales');
        Schema::dropIfExists('oficinas_productoras');
        Schema::dropIfExists('unidades_administrativas');
        Schema::dropIfExists('fondos_documentales');
    }
};
