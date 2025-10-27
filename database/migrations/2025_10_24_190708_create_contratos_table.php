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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();

            // Relación con empleados
            $table->foreignId('empleado_id')->constrained('empleados')->onDelete('cascade');
            $table->decimal('sueldo', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable(); // si es indefinido, puede ser null
            $table->enum('tipo', ['indefinido', 'anual'])->default('indefinido');
            $table->text('observaciones')->nullable();

            // Tenant
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};

