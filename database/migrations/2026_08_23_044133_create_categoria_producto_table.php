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
        Schema::create('categoria_producto', function (Blueprint $table) {
            $table->id();
            // Claves foráneas vinculadas a sus respectivas tablas
            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->cascadeOnDelete(); // Si se elimina una categoría, se limpia la relación en la pivote

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->cascadeOnDelete(); // Si se elimina un producto, se limpia la relación en la pivote

            // Evita que un mismo producto se vincule dos veces a la misma categoría
            $table->unique(['categoria_id', 'producto_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_producto');
    }
};
