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
       Schema::create('descuentos_empleado', function (Blueprint $table) {
        $table->id();
        $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        $table->unsignedBigInteger('empleado_id');
        $table->unsignedBigInteger('pago_id')->nullable();

        $table->string('tipo'); // seguro, AFP, prestamo, anticipo, etc.
        $table->decimal('monto', 10, 2);
        $table->string('corresponde_a_mes')->nullable(); // "2025-11"

        $table->timestamps();

        $table->foreign('empleado_id')->references('id')->on('users');
        $table->foreign('pago_id')->references('id')->on('pagos_empleados');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos_empleado');
    }
};
