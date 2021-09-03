<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zonas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conjuntoid');
            $table->foreign('conjuntoid')->references('id')->on('conjuntos')->onDelete('cascade');
            $table->string('zonanombre', 50);
            $table->string('zonaimagen', 30)->nullable()->default('images/zonacomun.png');
            $table->string('zonadescripcion', 300)->nullable();
            $table->string('zonahoraapertura', 5)->nullable();;
            $table->string('zonahoracierre', 5)->nullable();;
            $table->string('zonaterminos', 1800)->nullable();
            $table->boolean('zonareservable')->default(0);
            $table->boolean('zonacompartida')->default(1);
            $table->string('zonafranjatiempo', 8)->comment('franjas de tiempo para la reserva en minutos');
            $table->tinyInteger('zonaaforomax')->nulable()->default(0)->comment('Aforo maximo por franja');
            $table->tinyInteger('zonacuporeservamax')->nullable()->comment('Cupo maximo de personas por reserva');
            $table->tinyInteger('zonatiemporeservamax')->comment('Tiempo de antelacion para reservar en dias');
            $table->tinyInteger('zonareservadiariamax')->nullable()->comment('Numero maximo de reservas de una misma unidad por dia');
            $table->integer('zonaprecio')->nullable();
            $table->boolean('zonamorosos')->default(0)->comment('Si los morosos pueden reservar o no');
            $table->timestamps();
            $table->unique(['conjuntoid', 'zonanombre'], 'indice_conjunto_zona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zonas');
    }
}
