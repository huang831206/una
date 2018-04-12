<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('device')->nullable();
            $table->string('time')->nullable();
            $table->boolean('duplicate')->nullable();
            $table->string('snr')->nullable();
            $table->string('rssi')->nullable();
            $table->string('station')->nullable();
            $table->string('avgSnr')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->integer('radius')->nullable();
            $table->string('geolocSource')->nullable();
            $table->integer('seqNumber')->nullable();

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
        Schema::dropIfExists('messages');
    }
}
