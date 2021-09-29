<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rest_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rest_id');
            $table->unsignedBigInteger('product_id');
            $table->string('discount_title')->nullable();
            $table->text('discount_body')->nullable();
            $table->enum('discount_type', ['price', 'quantity'])->default('price');
            $table->enum('discount_condition', ['lteq', 'lt', 'eq', 'gt', 'gteq'])->default('gt');
            $table->float('discount_threshold');
            $table->enum('discount_cat', ['commission', 'amount'])->default('amount');
            $table->float('discount_deduction')->default('0.00');
            // $table->float('discount_amount')->default('0.00');
            $table->dateTime('start_time');
            $table->dateTime('stop_time');
            $table->enum('discount_status', ['active', 'closed', 'suspended']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rest_id')->references('id')->on('restaurants');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rest_discounts');
    }
}
