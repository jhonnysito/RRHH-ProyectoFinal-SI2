<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('correo')->unique();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('ci')->nullable();
            $table->foreignId('departamento_id')->constrained()->onDelete('cascade');
            $table->foreignId('cargo_id')->constrained()->onDelete('cascade');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
