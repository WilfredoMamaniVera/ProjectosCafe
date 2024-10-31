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
        Schema::create('carrito_compra', function (Blueprint $table) {
            $table->id(); // ID del carrito
            $table->unsignedBigInteger('user_id'); // Relación con el usuario
            $table->boolean('is_deleted')->default(false); // Indicador de carrito eliminado
            $table->timestamps();

            // Relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_compra');
    }
};
