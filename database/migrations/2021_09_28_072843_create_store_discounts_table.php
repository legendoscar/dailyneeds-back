<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_discounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('product_id');
            $table->string('discount_title')->nullable();
            $table->text('discount_body')->nullable();
            $table->enum('discount_type', ['price', 'quantity'])->default('price');
            $table->enum('discount_condition', ['lteq', 'lt', 'eq', 'gt', 'gteq'])->default('gt')->nullable();
            $table->float('discount_threshold')->nullable();
            $table->enum('discount_cat', ['percentage', 'amount'])->default('percentage');
            $table->float('discount_off')->default('0.00');
            // $table->float('discount_amount')->default('0.00');
            $table->dateTime('start_time');
            $table->dateTime('stop_time');
            $table->enum('discount_status', ['active', 'closed', 'suspended']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_id')->references('id')->on('stores');
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
        Schema::dropIfExists('store_discounts');
    }
}
