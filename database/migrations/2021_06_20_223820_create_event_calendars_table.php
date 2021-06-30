<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_calendars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zonaid');
            $table->foreign('zonaid')->references('id')->on('zonas')->onDelete('cascade');
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('backgroundColor', 8)->default('#217524');
            $table->tinyInteger('reservas')->default(0);
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
        Schema::dropIfExists('event_calendars');
    }
}
