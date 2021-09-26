<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conjuntoid');
            $table->foreign('conjuntoid')->references('id')->on('conjuntos')->onDelete('cascade');
            $table->unsignedBigInteger('personaid');
            $table->foreign('personaid')->references('id')->on('personas')->onDelete('cascade');
            $table->unsignedBigInteger('organo_id')->nullable();
            $table->foreign('organo_id')->references('id')->on('organos')->onDelete('set null');
            $table->unsignedBigInteger('cargo_id');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->boolean('empleadoestado')->default(0);
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
        Schema::dropIfExists('empleados');
    }
}
