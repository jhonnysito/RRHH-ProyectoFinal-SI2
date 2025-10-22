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
        Schema::create('postulantes', function (Blueprint $table) {
            $table->id(); // ID del postulante
            $table->string('nombres'); // Nombres del postulante
            $table->string('apellidos'); // Apellidos del postulante
            $table->string('email')->unique(); // Email único
            $table->string('telefono'); // Teléfono
            $table->string('cv')->nullable(); // URL del CV (puede ser nulo si no se sube un archivo)
            $table->json('skills')->nullable(); // Habilidades en formato JSON
            $table->integer('experiencia_anios')->default(0); // Años de experiencia

            $table->text('ai_skills')->nullable();          // Habilidades extraídas por IA
            $table->string('ai_suggested_job')->nullable(); // Puesto sugerido por IA

            $table->string('tenant_id');

            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postulantes');
    }
};
