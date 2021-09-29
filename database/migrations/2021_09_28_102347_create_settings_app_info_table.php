<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsAppInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_app_info', function (Blueprint $table) {
            $table->id();
            $table->text('app_title')->default('Daily Needs');
            $table->text('app_sub_title')->nullable();
            $table->text('app_desc')->nullable();
            $table->text('app_website')->default('https://www.dailyneeds.com.ng');
            $table->text('app_email')->default('ordernow@dailyneeds.com.ng');
            $table->text('app_phone')->default('+234-806-470-9889');
            $table->text('app_address')->nullable();
            $table->text('app_logo')->nullable();
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
        Schema::dropIfExists('settings_app_info');
    }
}
