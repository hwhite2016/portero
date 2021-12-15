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
            $table->unsignedBigInteger('tipoparqueaderoid')->nullable();
            $table->foreign('tipoparqueaderoid')->references('id')->on('tipo_parqueaderos')->onDelete('set null');
            $table->unsignedBigInteger('estadoparqueaderoid');
            $table->foreign('estadoparqueaderoid')->references('id')->on('estado_parqueaderos');
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
