<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudEmpleosTable extends Migration
{
    public function up()
    {
        Schema::create('solicitud_empleos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('postulante_id')->constrained()->onDelete('cascade'); // Relación con postulante
            $table->string('puesto'); // Puesto solicitado
            $table->text('mensaje'); // Mensaje de la solicitud
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado'])->default('pendiente'); // Estado de la solicitud
            $table->string('tenant_id');

            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitud_empleos');
    }
}
