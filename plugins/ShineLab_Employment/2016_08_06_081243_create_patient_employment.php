<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientEmployment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_employmentinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_employmentinfo_id', 60);
            $table->string('patient_id', 60);
            $table->string('facility_id', 60);
            $table->string('id_number', 30)->nullable();
            $table->string('occupation', 30)->nullable();
            $table->string('company_name', 60)->nullable();
            $table->string('company_phone', 20)->nullable();
            $table->string('company_unitno', 60)->nullable();
            $table->string('company_address', 60)->nullable();
            $table->string('company_region', 60)->nullable();
            $table->string('company_province', 60)->nullable();
            $table->string('company_citymun', 60)->nullable();
            $table->string('company_barangay', 60)->nullable();
            $table->string('company_zip', 60)->nullable();
            $table->string('company_country', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_employmentinfo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('patient_employmentinfo');
    }
}
