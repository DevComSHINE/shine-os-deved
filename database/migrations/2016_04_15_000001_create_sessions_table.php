<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id',255)->unique();
            $table->text('payload');
            $table->integer('last_activity');
        });

        Schema::create('tracker', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',60);
            $table->string('facility_id',60);
            $table->text('json');
            $table->datetime('datetime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sessions');
        Schema::drop('tracker');
    }
}
