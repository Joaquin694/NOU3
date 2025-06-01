<?php
// database/migrations/xxxx_xx_xx_create_servicios_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id('ID_Servicio');
            $table->string('Nombre');
            $table->decimal('Precio', 10, 2);
            $table->integer('Duracion'); // en minutos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servicios');
    }
};