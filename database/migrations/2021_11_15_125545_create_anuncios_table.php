<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnunciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipoanuncioid');
            $table->foreign('tipoanuncioid')->references('id')->on('tipo_anuncios');
            $table->unsignedBigInteger('conjuntoid');
            $table->foreign('conjuntoid')->references('id')->on('conjuntos')->onDelete('cascade');
            $table->unsignedBigInteger('bloqueid')->nullable();
            $table->foreign('bloqueid')->references('id')->on('bloques');
            $table->string('unidadid', 300)->nullable();
            $table->string('anuncionombre', 150)->nullable();
            $table->string('anunciodescripcion', 1500)->nullable();
            $table->string('anuncioadjunto', 20)->nullable();
            $table->dateTime('anunciofechaentrega')->nullable();
            $table->boolean('anuncioestado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anuncios');
    }
}
