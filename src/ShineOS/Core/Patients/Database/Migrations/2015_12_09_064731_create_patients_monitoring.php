<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsMonitoring extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_monitoring', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('monitoring_id', 60);
            $table->string('patient_id', 60);
            $table->string('bloodpressure_systolic', 60);
            $table->string('bloodpressure_diastolic', 60);
            $table->string('bloodpressure_assessment', 60);
            $table->softDeletes();
            $table->timestamps();
            $table->unique('monitoring_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('patients_monitoring');
    }

}
