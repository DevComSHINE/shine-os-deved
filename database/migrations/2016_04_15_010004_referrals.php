<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Referrals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('referrals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referral_id',60);

            $table->string('facility_id',60);
            $table->string('user_id',60)->nullable();
            $table->string('healthcareservice_id',60);
            $table->string('urgency',100)->nullable();
            $table->string('method_transport',100)->nullable();
            $table->string('transport_other',250)->nullable();
            $table->string('management_done',200)->nullable();
            $table->string('medical_given',200)->nullable();
            $table->string('referral_remarks',200)->nullable();
            $table->integer('referral_status')->nullable();
            $table->dateTime('accept_date')->nullable();
            $table->dateTime('decline_date')->nullable();
            $table->text('decline_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique('referral_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('referrals');
    }
}
