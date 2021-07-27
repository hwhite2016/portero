<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePqrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pqrs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pqrid');
            $table->foreign('pqrid')->references('id')->on('pqrs')->onDelete('cascade');
            $table->unsignedBigInteger('estadoid');
            $table->foreign('estadoid')->references('id')->on('estado_pqrs')->onDelete('cascade');
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('motivoid')->nullable();
            $table->foreign('motivoid')->references('id')->on('motivos');
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
        Schema::dropIfExists('detalle_pqrs');
    }
}
