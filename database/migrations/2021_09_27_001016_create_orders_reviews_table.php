<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reviewed_by');
            $table->unsignedBigInteger('order_id');
            $table->enum('ratings', [1,2,3,4,5]);
            $table->string('review_title');
            $table->text('review_text');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reviewed_by')->references('id')->on('customers');
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_reviews');
    }
}
