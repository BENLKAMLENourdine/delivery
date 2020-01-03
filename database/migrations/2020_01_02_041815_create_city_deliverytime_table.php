<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityDeliverytimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_deliverytime', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('city_id');
            $table->unsignedInteger('deliverytime_id');
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
        Schema::dropIfExists('city_deliverytime');
    }
}
