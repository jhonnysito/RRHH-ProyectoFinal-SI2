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
        Schema::create('vacaciones_empleado', function (Blueprint $table) {
        $table->id();
        $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        $table->unsignedBigInteger('empleado_id');

        $table->date('fecha_inicio');
        $table->date('fecha_fin');

        $table->integer('dias')->default(0);
        $table->enum('tipo', ['pagadas'])->default('pagadas');

        $table->timestamps();

        $table->foreign('empleado_id')->references('id')->on('users');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacaciones_empleado');
    }
};
