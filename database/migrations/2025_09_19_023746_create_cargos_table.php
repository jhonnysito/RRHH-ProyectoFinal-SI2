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
    Schema::create('cargos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('departamento_id'); // relación con departamentos
        $table->string('nombre')->unique();
        $table->string('descripcion')->nullable();
        $table->timestamps();

        // llave foránea
        $table->foreign('departamento_id')
              ->references('id')->on('departamentos')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
