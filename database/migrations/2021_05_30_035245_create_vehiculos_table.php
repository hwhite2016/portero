<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidadid');
            $table->foreign('unidadid')->references('id')->on('unidads');
            $table->unsignedBigInteger('tipovehiculoid');
            $table->foreign('tipovehiculoid')->references('id')->on('tipo_vehiculos');
            $table->string('vehiculoplaca', 10)->unique();
            $table->string('vehiculomarca', 30);
            $table->timestamps();
            //$table->unique(['unidadid', 'vehiculoplaca'], 'indice_unidad_vehiculo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
