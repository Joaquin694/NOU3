<?php
// database/migrations/xxxx_xx_xx_create_trabajadors_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trabajadors', function (Blueprint $table) {
            $table->id('ID_Trabajador');
            $table->string('Nombres');
            $table->string('Apellidos');
            $table->string('Cargo', 50);
            $table->enum('Estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trabajadors');
    }
};