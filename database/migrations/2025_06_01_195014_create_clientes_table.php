<?php
// database/migrations/xxxx_xx_xx_create_clientes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('ID_Cliente');
            $table->string('Nombres');
            $table->string('Apellidos');
            $table->string('DNI', 15)->unique();
            $table->string('Telefono', 15);
            $table->string('Correo', 100);
            $table->date('Fecha_Registro');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clientes');
    }
};