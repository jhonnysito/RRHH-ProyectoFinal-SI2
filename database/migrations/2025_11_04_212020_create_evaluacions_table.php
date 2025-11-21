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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();

            // Relación con entrevista y evaluador
            $table->foreignId('entrevista_id')->constrained()->onDelete('cascade');
            $table->foreignId('evaluador_id')->nullable()->constrained('users')->onDelete('set null');

            // Tenant
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');

            // Características personales (puntuación sobre 10)
            $table->unsignedTinyInteger('apariencia_profesional')->default(0);
            $table->unsignedTinyInteger('actitud')->default(0);
            $table->unsignedTinyInteger('conversacion')->default(0);
            $table->unsignedTinyInteger('cooperacion_entrevistador')->default(0);
            $table->unsignedTinyInteger('relaciones_interpersonales')->default(0);

            // Características relacionadas con el puesto (sobre 10)
            $table->unsignedTinyInteger('experiencia_puesto')->default(0);
            $table->unsignedTinyInteger('conocimiento_cargo')->default(0);
            $table->unsignedTinyInteger('perfil_puesto')->default(0);
            $table->unsignedTinyInteger('valoracion_curricular')->default(0);
            $table->unsignedTinyInteger('adecuacion_puesto')->default(0);

            // Total sobre 100
            $table->unsignedTinyInteger('total_puntuacion')->default(0);

            // Candidato (solo puede ser una de estas opciones)
            $table->enum('candidato', ['Malo', 'Regular', 'Bueno', 'Muy Bueno'])->default('Regular');

            // Comentario final
            $table->text('comentario_final')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacions');
    }
};
