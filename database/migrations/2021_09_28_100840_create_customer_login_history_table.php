<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerLoginHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_login_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cust_id');
            $table->ipAddress('ip_address');
            $table->text('browser_info');
            $table->text('login_location');
            $table->dateTime('login_timestamp');
            $table->dateTime('logout_timestamp')->nullable();
            $table->string('sess_duration')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cust_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_login_history');
    }
}
