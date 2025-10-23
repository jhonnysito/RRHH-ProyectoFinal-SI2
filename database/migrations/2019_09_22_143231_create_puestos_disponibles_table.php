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
     public function up(): void
{
    Schema::create('puestos_disponibles', function (Blueprint $table) {
        $table->id();

        // Datos básicos
        $table->string('nombre'); // Nombre del puesto
        $table->string('area'); // Área o departamento
        $table->text('descripcion'); // Descripción del puesto
        $table->text('requisitos'); // Requisitos del puesto

        // Detalles adicionales
        $table->string('tipo_contrato'); // Tipo de contrato (Tiempo completo, Medio tiempo, etc.)
        $table->string('modalidad')->nullable(); // Modalidad (Presencial, Híbrido, Remoto)
        $table->string('nivel')->nullable(); // Nivel del puesto (Junior, Senior, etc.)
        $table->string('salario')->nullable(); // Salario o rango salarial
        $table->string('ubicacion'); // Ciudad o sucursal

        // Vacantes y fechas
        $table->integer('vacantes')->default(1); // Número de vacantes disponibles
        $table->date('fecha_limite'); // Fecha límite para postular
        $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo'); // Estado del puesto

        // Otros campos informativos
        $table->text('beneficios')->nullable(); // Beneficios ofrecidos

        // Multi-tenant (si estás usando tenancy)
        $table->string('tenant_id');

        $table->timestamps();

        // Relación con la tabla tenants
        $table->foreign('tenant_id')
            ->references('id')
            ->on('tenants')
            ->onUpdate('cascade')
            ->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puestos_disponibles');
    }
};
