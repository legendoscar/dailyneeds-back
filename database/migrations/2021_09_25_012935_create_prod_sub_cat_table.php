<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdSubCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_sub_cat', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('cat_id');
            $table->string('sub_cat_title')->unique();
            $table->string('sub_cat_desc')->nullable();
            $table->string('sub_cat_image')->nullable();
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('cat_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_sub_cat');
    }
}
