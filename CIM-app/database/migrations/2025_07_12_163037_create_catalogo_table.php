<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalogo', function (Blueprint $table) {
            $table->id('IdCat');
            $table->string('NombreCat', 100);

            // FK autorreferenciada (padre)
            $table->unsignedBigInteger('IdPadre')->nullable();

            $table->boolean('EstadoCat')->default(true);
            $table->timestamps();

            // CORREGIDO: catalogo (no catologo)
            $table->foreign('IdPadre')
                ->references('IdCat')
                ->on('catalogo')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalogo');
    }
};
