<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_category', function (Blueprint $table) {
            $table->id();
            $table->string('store_cat_title')->unique();
            $table->string('store_cat_desc')->nullable();
            $table->string('store_cat_image')->nullable();
            $table->timestamps();
            $table->softDeletes();


        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_category');
    }
}
