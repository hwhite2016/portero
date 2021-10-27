<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidadid')->unique();
            $table->foreign('unidadid')->references('id')->on('unidads')->onDelete('cascade');
            $table->unsignedBigInteger('personaid');
            $table->foreign('personaid')->references('id')->on('personas')->onDelete('cascade');
            $table->boolean('registroestado')->default(0);
            $table->unsignedBigInteger('estado_id')->default(2);
            $table->foreign('estado_id')->references('id')->on('estado_registros');
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
        Schema::dropIfExists('registros');
    }
}
