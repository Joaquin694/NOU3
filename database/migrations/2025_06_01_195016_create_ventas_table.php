<?php
// database/migrations/xxxx_xx_xx_create_ventas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id('ID_Venta');
            $table->unsignedBigInteger('ID_Cliente');
            $table->dateTime('Fecha');
            $table->decimal('Total', 10, 2);
            $table->timestamps();

            $table->foreign('ID_Cliente')->references('ID_Cliente')->on('clientes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }
};