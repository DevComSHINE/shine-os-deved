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
            $table->string('user_id',60);
            $table->string('healthcareservice_id',60);
            $table->string('urgency',100);
            $table->string('method_transport',100);
            $table->string('management_done',200);
            $table->string('medical_given',200);
            $table->string('referral_remarks',200);
            $table->integer('referral_status');
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