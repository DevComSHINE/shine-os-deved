<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaboratoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratory_result', function (Blueprint $table) {
            $table->increments('id');
            $table->string('laboratoryresult_id',60);

            $table->string('medicalorderlaboratoryexam_id',60);
            $table->string('filename', 250);
            $table->longText('lab_data');

            $table->softDeletes();
            $table->timestamps();
            $table->unique('laboratoryresult_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('laboratory_result');
    }

}
