<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     * Updates based on
     * @return void
     */
    public function up()
    {
        Schema::create('drivers_status_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->enum('veri_status', ['unverified', 'verified'])->default('unverified');
            $table->enum('avail_status', ['unavailable', 'available', 'suspended'])->default('unavailable');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('driver_id')->references('id')->on('drivers');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers_status_history');
    }
}
