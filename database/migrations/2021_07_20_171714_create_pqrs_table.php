<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePqrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pqrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conjuntoid');
            $table->foreign('conjuntoid')->references('id')->on('conjuntos')->onDelete('cascade');
            $table->unsignedBigInteger('tipopqrid');
            $table->foreign('tipopqrid')->references('id')->on('tipo_pqrs')->onDelete('cascade');
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('asuntoid');
            $table->foreign('asuntoid')->references('id')->on('asuntos')->onDelete('cascade');
            $table->string('mensaje', 3000);
            $table->string('radicado', 20);
            $table->unsignedBigInteger('estadoid');
            $table->foreign('estadoid')->references('id')->on('estado_pqrs')->onDelete('cascade');
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
        Schema::dropIfExists('pqrs');
    }
}
