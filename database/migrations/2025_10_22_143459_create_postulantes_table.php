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
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('email')->unique();
            $table->string('telefono');
            $table->string('cv')->nullable();
            $table->json('skills')->nullable();
            $table->integer('experiencia_anios')->default(0);
            $table->text('ai_skills')->nullable();
            $table->string('tenant_id');
            $table->decimal('puntuacion', 5, 2)->nullable()->comment('Puntuación del postulante generada por IA');

            // 🔹 Campo de relación con puestos
            $table->foreignId('puesto_disponible_id')
                ->constrained('puestos_disponibles')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();

            // Relación con tenant
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
