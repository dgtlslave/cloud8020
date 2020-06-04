<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParkVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('park_vehicle', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedInteger('park_id')->index();
            $table->foreign('park_id')->references('id')->on('parks')->onDelete('cascade');

            $table->unsignedInteger('vehicle_id')->index();
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');

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
        Schema::dropIfExists('park_vehicle');
    }
}
