<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('audit_pgsql')->create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');             // tenant_id como string
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('accion');               // create, update, delete
            $table->string('modelo');               // nombre del modelo afectado
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('audit_pgsql')->dropIfExists('audit_logs');
    }
};
