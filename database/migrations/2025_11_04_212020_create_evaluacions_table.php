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
            $table->foreignId('entrevista_id')->constrained()->onDelete('cascade'); // referencia a la entrevista
            $table->foreignId('evaluador_id')->nullable()->constrained('users')->onDelete('set null'); // quien evalúa
            $table->integer('puntaje_comunicacion')->nullable();
            $table->integer('puntaje_conocimiento')->nullable();
            $table->integer('puntaje_actitud')->nullable();
            $table->integer('puntaje_trabajo_equipo')->nullable();
            $table->integer('puntaje_total')->nullable();
            $table->string('resultado_final')->nullable(); // aprobado, rechazado, pendiente
            $table->text('comentarios')->nullable();
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
        Schema::dropIfExists('evaluacions');
    }
};
