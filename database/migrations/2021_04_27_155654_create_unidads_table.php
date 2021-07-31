<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bloqueid');
            $table->foreign('bloqueid')->references('id')->on('bloques')->onDelete('cascade');
            $table->unsignedBigInteger('claseunidadid')->nullable();
            $table->foreign('claseunidadid')->references('id')->on('clase_unidads')->onDelete('set null');
            $table->string('unidadnombre', 50);
            $table->unsignedBigInteger('propietarioid')->nullable();
            $table->foreign('propietarioid')->references('id')->on('personas')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['bloqueid', 'unidadnombre'], 'indice_bloque_unidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidads');
    }
}
