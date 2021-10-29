<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('cat_title')->unique();
            $table->string('cat_desc')->nullable();
            $table->enum('cat_type', [1, 2]);   #1=>store  # 2=>product
            $table->string('cat_image')->nullable();
            // $table->enum('cat_status', [1, 2]);   #1=>available  # 2=>unavailable
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
        Schema::dropIfExists('categories');
    }
}
