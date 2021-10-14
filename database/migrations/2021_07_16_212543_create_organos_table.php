<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conjuntoid');
            $table->foreign('conjuntoid')->references('id')->on('conjuntos')->onDelete('cascade');
            $table->string('organonombre', 100);
            $table->string('organocorreo', 80)->nullable();
            $table->string('organocelular', 30)->nullable();
            $table->string('organotelefono', 30)->nullable();
            $table->tinyInteger('organonivel')->default(1)->nullable();
            $table->boolean('organopqr')->default(0);
            $table->boolean('organoestado')->default(1);
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
        Schema::dropIfExists('organos');
    }
}
