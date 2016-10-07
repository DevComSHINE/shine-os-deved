<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChestxray extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('chest_xray', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chestxray_id', 60);
            $table->string('healthcareservice_id', 60);

            $table->datetime('scheduled_date')->nullable();
            $table->datetime('actual_date')->nullable();
            $table->string('xray_result',60)->nullable();
            $table->string('notes_remarks',60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('chestxray_id');
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
        Schema::drop('chest_xray');
    }
}
