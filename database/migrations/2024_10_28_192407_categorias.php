<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' autoincremental
            $table->string('nombre'); // Columna para el nombre de la categoría
            $table->text('descripcion')->nullable(); // Columna para la descripción de la categoría (opcional)
            $table->timestamps(); // Crea las columnas 'created_at' y 'updated_at'
        });
    }
    /**
     * Reverse the migrations.
    */
    public function down()
    {
        Schema::dropIfExists('categorias');
    }
};
