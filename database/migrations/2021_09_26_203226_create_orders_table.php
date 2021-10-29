<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cust_id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('driver_id')->nullable();

            $table->float('total_amount', 8, 2)->unsigned();

            $table->unsignedBigInteger('destination_address');
            $table->enum('payment_mode', ['cash', 'transfer', 'card', 'pos'])->default('card');
            $table->enum('payment_status', ['processing', 'confirmed', 'declined', 'cancelled', 'returned'])->default('processing');

            $table->enum('delivery_mode', ['pick-up', 'delivery'])->default('delivery');
            $table->text('driver_decline_cancel_reason')->nullable();

            $table->dateTime('store_schedule_order_time')->nullable(); #expected delivery time
            $table->text('store_schedule_order_reason')->nullable(); #reasons
            $table->dateTime('customer_schedule_order_time')->nullable(); #for future delivery
            $table->text('customer_schedule_order_reason')->nullable(); #reasons
            $table->dateTime('time_order_accepted')->nullable();
            $table->dateTime('time_order_declined')->nullable();
            $table->dateTime('time_order_cancelled')->nullable();
            $table->dateTime('time_order_processing')->nullable();
            $table->dateTime('time_order_in_transit')->nullable();
            $table->dateTime('time_order_delivered')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cust_id')->references('id')->on('customers');
            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('driver_id')->references('id')->on('drivers');
            $table->foreign('destination_address')->references('id')->on('cust_address');
        });


        Schema::create('order_items', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('quantity')->default(1);
            $table->float('amount', 8, 2)->unsigned();
            $table->longText('kitchen_instructions')->nullable();

            $table->enum('order_status', ['new', 'accepted', 'declined', 'cancelled', 'processing', 'in-transit', 'delivered', 'returned'])->default('new');
            $table->text('customer_cancel_reason')->nullable();
            $table->text('store_decline_cancel_reason')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
    }
}
