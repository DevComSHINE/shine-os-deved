<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralreasons extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('referral_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referralreason_id',60);

            $table->string('referral_id',60);
            $table->string('lovreferralreason_id',60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('referralreason_id');

            $table->foreign('referral_id')
                  ->references('referral_id')
                  ->on('referrals')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::create('lov_referral_reasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lovreferralreason_id',60);

            $table->string('referral_reason',60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('lovreferralreason_id');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('referral_reasons');
        Schema::drop('lov_referral_reasons');

    }

}
