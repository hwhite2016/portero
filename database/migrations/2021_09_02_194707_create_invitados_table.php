<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservaid');
            $table->foreign('reservaid')->references('id')->on('reservas')->onDelete('cascade');;
            $table->string('invitadodocumento', 30);
            $table->string('invitadonombre', 60);
            $table->string('invitadoedad', 10);
            $table->string('invitadocelular', 30)->nullable();
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
        Schema::dropIfExists('invitados');
    }
}
