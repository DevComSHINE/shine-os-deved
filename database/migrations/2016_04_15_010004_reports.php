<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('fhsis_m2', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('age');
            $table->string('gender',5);
            $table->string('diagnosislist_id',250);
            $table->string('icd10_code',50)->nullable();
            $table->integer('diagnosisMonth')->nullable();
            $table->integer('diagnosisYear')->nullable();
            $table->integer('deathYear')->nullable();
            $table->string('facility_id',60)->nullable();
            $table->integer('count')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        Schema::drop('fhsis_m2');
    }
}
