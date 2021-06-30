<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParqueaderosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parqueaderos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conjuntoid');
            $table->foreign('conjuntoid')->references('id')->on('conjuntos')->onDelete('cascade');
            $table->string('parqueaderonumero', 10);
            $table->tinyInteger('parqueaderopiso');
            $table->enum('parqueaderotipo', ['Asignado', 'Visitante', 'Discapacitado']);
            $table->boolean('parqueaderoestado')->default(0);
            $table->timestamps();
            $table->unique(['conjuntoid', 'parqueaderonumero'], 'indice_conjunto_parqueadero');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parqueaderos');
    }
}
