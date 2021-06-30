<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipodocumentoid');
            $table->foreign('tipodocumentoid')->references('id')->on('tipo_documentos')->onDelete('cascade');
            $table->string('personadocumento', 20)->unique();
            $table->string('personanombre', 50);
            $table->string('personafechanacimiento', 8)->nullable();
            $table->string('personacelular', 15)->nullable();
            $table->string('personacorreo', 50)->nullable();
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
        Schema::dropIfExists('personas');
    }
}
