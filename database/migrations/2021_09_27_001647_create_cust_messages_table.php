<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('msg_by');
            $table->string('msg_title');
            $table->text('msg_body');
            $table->enum('msg_type', ['order', 'billings']);
            $table->enum('msg_priority', [1,2,3,4,5])->default(3);
            $table->enum('msg_status', ['open', 'replied', 'closed'])->default('open');
            $table->dateTime('msg_status_closed');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('msg_by')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cust_messages');
    }
}
