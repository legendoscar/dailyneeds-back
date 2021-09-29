<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversKycTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers_kyc', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('driver_id');
            $table->enum('marital_status', ['single', 'married', 'separated', 'divorced', 'widowed']);
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code')->nullable();
            $table->string('nationality');
            $table->string('state_of_origin');
            $table->string('lga_of_origin');
            $table->date('DOB')->nullable();
            $table->string('profile_picture');
            $table->string('name_next_of_kin');
            $table->string('rxnship_next_of_kin');
            $table->string('address_next_of_kin');
            $table->enum('type_of_proof', ['natiional_ID_card', 'drv_license', 'intl_passport', 'voters_card']);
            $table->string('proof_if_identity');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('driver_id')->references('id')->on('drivers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers_kyc');
    }
}
