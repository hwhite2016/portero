<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidadid');
            $table->foreign('unidadid')->references('id')->on('unidads');
            $table->unsignedBigInteger('tipoentregaid');
            $table->foreign('tipoentregaid')->references('id')->on('tipo_entregas');
            $table->string('entregaempresa', 30)->nullable();
            $table->string('entregareceptor', 30)->nullable();
            $table->unsignedBigInteger('entregadestinatario');
            $table->foreign('entregadestinatario')->references('id')->on('residentes');
            $table->string('entregaobservacion', 180)->nullable();
            $table->dateTime('entregafechaentrega')->nullable();
            $table->boolean('entregaestado')->default(0);
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
        Schema::dropIfExists('entregas');
    }
}
