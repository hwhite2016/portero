<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidadid');
            $table->foreign('unidadid')->references('id')->on('unidads');
            $table->unsignedBigInteger('personaid');
            $table->foreign('personaid')->references('id')->on('personas');
            $table->unsignedBigInteger('parqueaderoid')->nullable();
            $table->foreign('parqueaderoid')->references('id')->on('parqueaderos');
            $table->string('visitanteplaca', 12)->nullable();
            $table->dateTime('visitanteingreso');
            $table->dateTime('visitantesalida')->nullable();
            $table->string('visitanteobservacion', 120)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('visitantes');
    }
}
