<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('rest_name');
            $table->string('rest_address');
            $table->string('rest_phone');
            $table->string('rest_email');
            $table->string('rest_admin_username');
            $table->string('rest_admin_password');
            $table->enum('veri_status', ['unverified', 'verified'])->default('unverified');
            $table->enum('status', ['active', 'suspended', 'deactivated'])->default('active');
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
        Schema::dropIfExists('restaurants');
    }
}
