<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindermessages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminder_message', function (Blueprint $table) {
            $table->increments('id');
            $table->string('remindermessage_id', 100);
            $table->string('reminder_subject', 250)->nullable();
            $table->text('reminder_message')->nullable();
            $table->dateTime('appointment_datetime')->nullable();
            $table->integer('daysbeforesending')->nullable();
            $table->string('remindermessage_type',60)->nullable();
            $table->string('sent_status', 10)->nullable();
            $table->enum('status', array(1,2,3))->nullable();
            $table->enum('reminder_type',array(1,2,3,4))->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique('remindermessage_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reminder_message');
    }

}
