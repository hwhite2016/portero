<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConjuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conjuntos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barrioid')->nullable();
            $table->string('conjuntonombre', 100);
            $table->string('conjuntodireccion', 100);
            $table->string('conjuntologo', 30)->nullable()->default('images/yourlogo.png');
            $table->string('conjuntocorreo', 100);
            $table->string('conjuntocelular', 15)->nullable();
            $table->string('conjuntotelefono', 15)->nullable();
            $table->boolean('conjuntoestado')->default(0);
            //$table->enum('conjuntoestado', ['activo','inactivo']);
            $table->foreign('barrioid')->references('id')->on('barrios')->onDelete('set null');
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
        Schema::dropIfExists('conjuntos');
    }
}