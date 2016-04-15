<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reminder_id', 100);
            $table->string('facilityuser_id', 100);
            $table->string('patient_id', 100);
            $table->string('user_id', 100);
            
            $table->string('remindermessage_id', 100);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('reminder_id');


            $table->foreign('remindermessage_id')
                  ->references('remindermessage_id')
                  ->on('reminder_message')
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
        Schema::drop('reminders');
    }
}
