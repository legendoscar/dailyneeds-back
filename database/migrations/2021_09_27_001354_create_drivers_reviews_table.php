<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reviewed_by');
            $table->unsignedBigInteger('driver_id');
            $table->enum('ratings', [1,2,3,4,5]);
            $table->string('review_title');
            $table->text('review_text');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reviewed_by')->references('id')->on('customers');
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
        Schema::dropIfExists('drivers_reviews');
    }
}
