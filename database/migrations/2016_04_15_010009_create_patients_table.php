<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('patients', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('patient_id', 60);

            $table->string('first_name', 60);
            $table->string('last_name', 60);
            $table->string('middle_name', 60);
            $table->string('maiden_lastname', 60)->nullable();
            $table->string('maiden_middlename', 60)->nullable();
            $table->string('name_suffix', 15)->nullable();
            $table->enum('gender', array('F', 'M', 'U'));
            $table->string('civil_status', 30);
            $table->date('birthdate');
            $table->time('birthtime');
            $table->string('birthplace', 150)->nullable();
            $table->string('highest_education', 150)->nullable();
            $table->string('highesteducation_others', 150)->nullable();
            $table->string('religion', 30)->nullable();
            $table->string('religion_others', 30)->nullable();
            $table->string('nationality', 30)->nullable();
            $table->string('blood_type', 5)->nullable();
            $table->string('birth_order', 10)->nullable();
            $table->boolean('referral_notif')->nullable();
            $table->boolean('broadcast_notif')->nullable();
            $table->boolean('nonreferral_notif')->nullable();
            $table->boolean('patient_consent')->nullable();
            $table->boolean('myshine_acct')->nullable();
            $table->integer('age')->nullable();
            $table->string('email', 60)->nullable();
            $table->string('password', 60)->nullable();
            $table->string('salt', 10)->nullable();
            $table->string('photo_url', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_id');
        });

        Schema::create('patient_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_contact_id', 60);
            $table->string('patient_id', 60);

            $table->string('street_address', 60)->nullable();
            $table->string('barangay', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('province', 60)->nullable();
            $table->string('region', 60)->nullable();
            $table->string('country', 30)->nullable();
            $table->integer('zip')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone_ext', 10)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('email', 150)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_contact_id');
        });

        Schema::create('patient_alert', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_alert_id', 60);
            $table->string('patient_id', 60);

            $table->string('alert_type', 30)->nullable();
            $table->string('alert_type_other', 30)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_alert_id');
        });

        Schema::create('allergy_patient', function (Blueprint $table) {
            $table->increments('id');
            $table->string('allergy_patient_id', 60);
            $table->string('patient_alert_id', 60);

            $table->string('allergy_id', 30);
            $table->string('allergy_reaction_id', 30);
            $table->string('allergy_severity', 30)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('allergy_patient_id');
        });

        Schema::create('disability_patient', function (Blueprint $table) {
            $table->increments('id');
            $table->string('disability_patient_id', 60);
            $table->string('patient_alert_id', 60);
            $table->string('disability_id', 60);

            $table->string('disability_others', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('disability_patient_id');
        });

        Schema::create('patient_emergencyinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_emergencyinfo_id', 60);
            $table->string('patient_id', 60);

            $table->string('emergency_name', 60)->nullable();
            $table->string('emergency_relationship', 60)->nullable();
            $table->string('emergency_phone', 60)->nullable();
            $table->string('emergency_mobile', 60)->nullable();
            $table->string('emergency_address', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_emergencyinfo_id');
        });

        Schema::create('patient_death_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_deathinfo_id', 60);
            $table->string('patient_id', 60);

            $table->string('DeathCertificate_Filename', 60)->nullable();
            $table->string('DeathCertificateNo', 60)->nullable();
            $table->datetime('datetime_death');
            $table->string('PlaceDeath', 60)->nullable();
            $table->string('PlaceDeath_FacilityBased', 60)->nullable();
            $table->string('PlaceDeath_NID', 60)->nullable();
            $table->string('PlaceDeath_NID_Others_Specify', 60)->nullable();
            $table->string('mStageDeath', 60)->nullable();
            $table->string('Immediate_Cause_of_Death', 60)->nullable();
            $table->string('Antecedent_Cause_of_Death', 60)->nullable();
            $table->string('Underlying_Cause_of_Death', 60)->nullable();
            $table->string('Type_of_Death', 60)->nullable();
            $table->text('Remarks')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_deathinfo_id');
        });

        Schema::create('patient_immunization', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_immunization_id', 60);
            $table->string('patient_id', 60);

            $table->string('healthcareservice_id', 60);
            $table->string('subservice_id', 60);
            $table->string('plugin_id', 60)->nullable();
            $table->string('plugin', 60)->nullable();
            $table->string('immunization_code', 60)->nullable();
            $table->string('immun_type', 60)->nullable();
            $table->datetime('scheduled_date')->nullable();
            $table->datetime('actual_date')->nullable();
            $table->string('other_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_immunization_id');
        });

        Schema::create('facility_patient_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facilitypatientuser_id', 60);
            $table->string('patient_id', 60);
            $table->string('facilityuser_id', 60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('facilitypatientuser_id');
        });

        Schema::create('patient_medicalhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_medicalhistory_id', 60);
            $table->string('patient_id', 60);

            $table->string('disease_id', 60);
            $table->string('disease_code', 60)->nullable();
            $table->text('disease_status')->nullable();
            $table->string('remarks', 60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_medicalhistory_id');
        });

        Schema::create('patient_familyinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_familyinfo_id', 60);
            $table->string('patient_id', 60);

            $table->string('father_firstname', 60)->nullable();
            $table->string('father_middlename', 60)->nullable();
            $table->string('father_lastname', 60)->nullable();
            $table->string('suffix', 20)->nullable();
            $table->tinyInteger('father_alive')->nullable();
            $table->string('mother_firstname', 60)->nullable();
            $table->string('mother_middlename', 60)->nullable();
            $table->string('mother_lastname', 60)->nullable();
            $table->tinyInteger('mother_alive')->nullable();
            $table->integer('ctr_householdmembers_lt10yrs')->nullable();
            $table->integer('ctr_householdmembers_gt10yrs')->nullable();
            $table->string('family_folder_name', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_familyinfo_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('patient_contact');
        Schema::dropIfExists('patient_alert');
        Schema::dropIfExists('allergy_patient');
        Schema::dropIfExists('disability_patient');
        Schema::dropIfExists('patient_emergencyinfo');
        Schema::dropIfExists('patient_death_info');
        Schema::dropIfExists('patient_immunization');
        Schema::dropIfExists('patient_philhealthinfo');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('facility_patient_user');
        Schema::dropIfExists('patient_medicalhistory');
        Schema::dropIfExists('patient_familyinfo');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
