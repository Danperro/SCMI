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
        Schema::create('periferico', function (Blueprint $table) {
            $table->id('IdPef');
            $table->bigInteger('IdTpf')->unsigned();
            $table->bigInteger('IdEqo')->unsigned()->nullable();
            $table->string('CiuPef', 10);
            $table->string('CodigoInventarioPef', 100)->unique();
            $table->unsignedBigInteger('IdMarcaCat'); // catálogo
            $table->unsignedBigInteger('IdColorCat'); // catálogo
            $table->boolean('EstadoPef');
            $table->foreign('IdTpf')->references('IdTpf')->on('tipoperiferico')->onDelete('cascade');
            $table->foreign('IdEqo')->references('IdEqo')->on('equipo')->onDelete('set null');
            $table->foreign('IdMarcaCat')
                ->references('IdCat')
                ->on('catalogo');

            $table->foreign('IdColorCat')
                ->references('IdCat')
                ->on('catalogo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
