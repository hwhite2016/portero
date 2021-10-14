<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePqrOrganosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pqr_organos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pqr_id');
            $table->foreign('pqr_id')->references('id')->on('pqrs')->onDelete('cascade');
            $table->unsignedBigInteger('organo_id');
            $table->foreign('organo_id')->references('id')->on('organos')->onDelete('cascade');
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
        Schema::dropIfExists('pqr_organos');
    }
}
