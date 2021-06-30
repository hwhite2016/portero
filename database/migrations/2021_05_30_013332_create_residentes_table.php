<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResidentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unidadid');
            $table->foreign('unidadid')->references('id')->on('unidads')->onDelete('cascade');;
            $table->unsignedBigInteger('personaid');
            $table->foreign('personaid')->references('id')->on('personas')->onDelete('cascade');
            $table->unsignedBigInteger('tiporesidenteid')->nullable();
            $table->foreign('tiporesidenteid')->references('id')->on('tipo_residentes')->onDelete('set null');
            $table->unsignedBigInteger('relationid')->nullable();
            $table->foreign('relationid')->references('id')->on('relations')->onDelete('set null');
            $table->timestamps();
            $table->unique(['unidadid', 'personaid'], 'indice_unidad_persona');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residentes');
    }
}
