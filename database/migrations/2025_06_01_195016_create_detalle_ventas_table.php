<?php
// database/migrations/xxxx_xx_xx_create_detalle_ventas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id('ID_Detalle');
            $table->unsignedBigInteger('ID_Venta');
            $table->unsignedBigInteger('ID_Producto');
            $table->integer('Cantidad');
            $table->decimal('Precio', 10, 2);
            $table->timestamps();

            $table->foreign('ID_Venta')->references('ID_Venta')->on('ventas')->onDelete('cascade');
            $table->foreign('ID_Producto')->references('ID_Producto')->on('productos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
};