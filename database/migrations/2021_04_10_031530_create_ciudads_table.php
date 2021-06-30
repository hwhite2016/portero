<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCiudadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciudads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paisid')->nullable();
            $table->foreign('paisid')->references('id')->on('pais')->onDelete('set null');
            $table->string('ciudadnombre', 30);
            $table->integer('ciudadcodigo');
            $table->string('ciudadabreviatura', 5);
            //$table->softDeletes();
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
        Schema::dropIfExists('ciudads');
    }
}
