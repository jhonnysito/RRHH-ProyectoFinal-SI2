<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            // ID del usuario que solicita el permiso
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // ID del tipo de incidencia (e.g., Vacaciones, Enfermedad)
            // Asumiendo que ya tiene una tabla 'incidencias'
            $table->foreignId('incidencia_id')->constrained('incidencias')->onDelete('cascade'); 
            
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('motivo')->nullable();
            
            // Estado: solicitado (default), aprobado, rechazado
            $table->enum('estado', ['solicitado', 'aprobado', 'rechazado'])->default('solicitado');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
};