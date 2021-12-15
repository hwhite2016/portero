<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zonaid');
            $table->foreign('zonaid')->references('id')->on('zonas');
            $table->unsignedBigInteger('unidadid');
            $table->foreign('unidadid')->references('id')->on('unidads');
            $table->string('reservacodigo', 12);
            $table->tinyInteger('reservacupos');
            $table->dateTime('reservafechaini');
            $table->dateTime('reservafechafin');
            $table->integer('valor')->nullable();
            $table->boolean('reservaestado')->default(1);
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
        Schema::dropIfExists('books');
    }
}
