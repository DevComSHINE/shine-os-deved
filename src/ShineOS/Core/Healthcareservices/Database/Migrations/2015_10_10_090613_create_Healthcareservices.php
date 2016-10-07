<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthcareservices extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() { 
        Schema::create('healthcare_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('healthcareservice_id', 60);
            $table->string('facilitypatientuser_id', 60);
            $table->string('healthcareservicetype_id', 60);
            $table->string('consultation_type', 60)->nullable();
            $table->string('encounter_type', 60)->nullable();
            $table->string('parent_service_id', 60)->nullable();
            $table->string('source_referrer_type', 60);
            $table->string('source_referrer', 60)->nullable();
            $table->datetime('encounter_datetime');
            $table->string('seen_by',60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('healthcareservice_id');
        });

        Schema::create('disposition', function (Blueprint $table) {
            $table->increments('id');
            $table->string('disposition_id');
            $table->string('healthcareservice_id', 60);
            $table->string('disposition', 60);
            $table->string('discharge_condition', 60);
            $table->datetime('discharge_datetime');
            $table->binary('discharge_notes');
          
            $table->softDeletes();
            $table->timestamps();
            $table->unique('disposition_id');
        });

        Schema::create('healthcare_addendum', function (Blueprint $table) {
            $table->increments('id');
            $table->string('addendum_id');
            $table->string('healthcareservice_id', 60);
            $table->binary('addendum_notes');
          
            $table->softDeletes();
            $table->timestamps();
            $table->unique('addendum_id');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('healthcare_services');
        Schema::drop('disposition');
    }

}
