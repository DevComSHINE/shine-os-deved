<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendar extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('calendar_id',60);

            $table->datetime('start');
            $table->datetime('end');
            $table->string('title',200);
            $table->string('description',200);
            $table->string('facility_id',60);
            $table->string('user_id',60);
            $table->string('color',60);
            $table->string('textColor',60);
            $table->varchar('allday',1);
            $table->softDeletes();
            $table->timestamps();
            $table->unique('calendar_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('calendar');
    }

}
