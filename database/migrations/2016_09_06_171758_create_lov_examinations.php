<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLovExaminations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lov_examination', function (Blueprint $table) {
            $table->increments('id');
            $table->string('examination_id', 60);
            $table->string('examination_name', 60);
            $table->string('examination_code', 60);
            $table->string('examination_type', 60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('examination_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lov_examination');
    }
}
