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
        Schema::create('producto', function (Blueprint $table) {
            $table->id(); 
            $table->string('producto_nombre', 100); 
            $table->string('marca'); 
            $table->double('precio'); 
            $table->string('imagen')->nullable(); 
            $table->unsignedBigInteger('categoria_id'); 
            $table->text('descripcion')->nullable(); 
            $table->integer('stock'); 
            $table->dateTime('fecha_registro')->useCurrent(); 
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
