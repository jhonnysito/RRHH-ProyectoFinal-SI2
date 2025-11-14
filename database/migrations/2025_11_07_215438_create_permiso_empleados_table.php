<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permiso_empleados', function (Blueprint $table) {
            $table->id();

            // Usuario que solicita el permiso
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Tipo de incidencia (vacaciones, enfermedad, etc.)
            $table->foreignId('incidencia_id')->constrained('incidencias')->onDelete('cascade');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('motivo')->nullable();

            // archivo adjunto (ruta en storage)
            $table->string('archivo_adjunto')->nullable();

            // Estado del permiso
            $table->enum('estado', ['solicitado', 'aprobado', 'rechazado'])->default('solicitado');

            // Tenant (si tu proyecto usa tenant en muchas tablas)
            $table->string('tenant_id')->nullable()->index();

            $table->timestamps();

            // FK tenant si existe tabla tenants (siempre opcional)
            // Descomenta si tienes tabla tenants
            // $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permiso_empleados');
    }
};
