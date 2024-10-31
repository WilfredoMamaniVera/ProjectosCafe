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
        Schema::create('carrito_detalles', function (Blueprint $table) {
            $table->id(); // ID del detalle del carrito
            $table->unsignedBigInteger('carrito_compra_id'); // Relación con el carrito
            $table->unsignedBigInteger('producto_id'); // Relación con el producto
            $table->integer('cantidad'); // Cantidad de productos en el carrito
            $table->double('precio_unico'); // Precio por unidad del producto
            $table->timestamps();

            // Relaciones con las tablas carrito_compra y productos
            $table->foreign('carrito_compra_id')->references('id')->on('carrito_compra')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_detalles');
    }
};
