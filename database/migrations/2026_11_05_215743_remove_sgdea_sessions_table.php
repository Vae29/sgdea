<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('sesiones');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
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
    }
};
