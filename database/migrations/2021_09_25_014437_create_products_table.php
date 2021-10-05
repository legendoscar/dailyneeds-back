<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('cat_id');
            $table->string('product_title')->unique();
            $table->string('product_sub_title')->nullable();
            $table->text('product_desc')->nullable();
            $table->enum('availability_status', ['available', 'unavailable', 'out of stock'])->default('available');
            $table->enum('unit', ['plate', 'wrap', 'kg', 'liter', 'morsel'])->default('plate');
            $table->string('product_image')->nullable();
            $table->float('amount', 8, 2)->default('0.00');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('cat_id')->references('id')->on('prod_sub_cat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
