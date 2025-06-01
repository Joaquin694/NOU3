<?php
// database/migrations/xxxx_xx_xx_create_movimiento_inventarios_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimiento_inventarios', function (Blueprint $table) {
            $table->id('ID_Movimiento');
            $table->unsignedBigInteger('ID_Producto');
            $table->enum('Tipo', ['Entrada', 'Salida']);
            $table->integer('Cantidad');
            $table->dateTime('Fecha');
            $table->timestamps();

            $table->foreign('ID_Producto')->references('ID_Producto')->on('productos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimiento_inventarios');
    }
};