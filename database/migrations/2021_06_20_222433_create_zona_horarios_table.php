<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonaHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zona_horarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zonaid');
            $table->foreign('zonaid')->references('id')->on('zonas')->onDelete('cascade');
            $table->tinyInteger('dia');
            $table->string('horaapertura', 5);
            $table->string('horacierre', 5);
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
        Schema::dropIfExists('zona_horarios');
    }
}
