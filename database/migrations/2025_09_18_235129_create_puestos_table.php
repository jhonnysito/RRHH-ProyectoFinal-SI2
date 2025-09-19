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
    Schema::create('puestos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // Nombre del puesto
        $table->text('descripcion')->nullable(); // Descripción del puesto
        $table->integer('vacantes')->default(1); // Número de vacantes
        $table->string('ubicacion')->nullable(); // Ubicación del puesto
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puestos');
    }
};
