<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();

            // Relación con el tenant (empresa) - string
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            
            // Relación con empleado
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');

            // Día y horas de trabajo
            $table->string('dia_semana'); // Ej: Lunes, Martes, etc.
            $table->time('hora_entrada');
            $table->time('hora_salida');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
