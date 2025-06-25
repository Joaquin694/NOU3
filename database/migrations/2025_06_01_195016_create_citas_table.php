<?php
// database/migrations/xxxx_xx_xx_create_citas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id('ID_Cita');
            $table->unsignedBigInteger('ID_Cliente');
            $table->unsignedBigInteger('ID_Servicio');
            $table->unsignedBigInteger('ID_Trabajador');
            $table->dateTime('Fecha_Hora');
            $table->enum('Estado', ['Pendiente', 'Confirmada', 'Completada', 'Cancelada'])->default('Pendiente');
            $table->timestamps();

            $table->foreign('ID_Cliente')->references('ID_Cliente')->on('clientes')->onDelete('cascade');
            $table->foreign('ID_Servicio')->references('ID_Servicio')->on('servicios')->onDelete('cascade');
            $table->foreign('ID_Trabajador')->references('ID_Trabajador')->on('trabajadors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('citas');
    }
};