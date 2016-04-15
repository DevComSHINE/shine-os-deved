<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ReferralMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('referral_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('referralmessage_id',60);

            $table->string('referral_id',60);
            $table->string('referral_subject',100);
            $table->string('referral_message',250);
            $table->dateTime('referral_datetime');
            $table->integer('referral_message_status');
            $table->integer('referrer');

            $table->softDeletes();
            $table->timestamps();
            $table->unique('referralmessage_id');

            $table->foreign('referral_id')
                  ->references('referral_id')
                  ->on('referrals')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
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
        Schema::drop('referral_messages');
    }
}
