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
        Schema::create('pagos_empleados', function (Blueprint $table) {
        $table->id();
        $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
        $table->unsignedBigInteger('empleado_id');

        $table->decimal('salario_base', 10, 2)->default(0);
        $table->decimal('total_bonos', 10, 2)->default(0);
        $table->decimal('total_descuentos', 10, 2)->default(0);
        $table->decimal('total_neto', 10, 2)->default(0);

        $table->date('periodo_inicio');
        $table->date('periodo_fin');
        $table->date('fecha_pago');

        $table->enum('estado', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');

        $table->timestamps();

        $table->foreign('empleado_id')->references('id')->on('users');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_empleados');
    }
};
