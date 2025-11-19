<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('permiso_empleados', function (Blueprint $table) {
            $table->id();

            // ID del usuario que solicita el permiso
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Tipo de incidencia convertida a atributo
            $table->enum('incidencia', ['vacaciones', 'enfermedad', 'otros']);

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->string('motivo')->nullable();

            // Imagen adjunta del permiso (certificado médico, carta, etc.)
            $table->string('imagen')->nullable(); // Guardarás el path de la imagen aquí

            // Estado del permiso
            $table->enum('estado', ['solicitado', 'aprobado', 'rechazado'])->default('solicitado');
             // Relación con el tenant (empresa) - string
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
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
        Schema::dropIfExists('permiso_empleados');
    }
};
