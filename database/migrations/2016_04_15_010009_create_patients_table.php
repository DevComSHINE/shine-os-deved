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
            $table->string('religion', 30);
            $table->string('religion_others', 30)->nullable();
            $table->string('nationality', 30);
            $table->string('blood_type', 5)->nullable();
            $table->string('birth_order', 10)->nullable();
            $table->boolean('referral_notif');
            $table->boolean('broadcast_notif');
            $table->boolean('nonreferral_notif');
            $table->boolean('patient_consent');
            $table->boolean('myshine_acct');
            $table->integer('age');
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
            $table->integer('zip');
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

        Schema::create('patient_familyinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_familyinfo_id', 60);
            $table->string('patient_id', 60);

            $table->string('father_firstname', 60)->nullable();
            $table->string('father_middlename', 60)->nullable();
            $table->string('suffix', 20)->nullable();
            $table->boolean('father_alive');
            $table->string('mother_firstname', 60)->nullable();
            $table->string('mother_middlename', 60)->nullable();
            $table->string('mother_lastname', 60)->nullable();
            $table->boolean('mother_alive', 60);
            $table->integer('ctr_householdmembers_lt10yrs')->nullable();
            $table->integer('ctr_householdmembers_gt10yrs')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_familyinfo_id');
        });

        Schema::create('patient_family_group', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_familygroup_id', 60);
            $table->string('familygroup_name', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_familygroup_id');
        });

        Schema::create('patient_family_group_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_familygroupmember_id', 60);
            $table->string('patient_familygroup_id', 60);
            $table->string('patient_id', 60);
            $table->integer('patient_relationship');

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_familygroupmember_id');
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

        Schema::create('patient_employmentinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_employmentinfo_id', 60);
            $table->string('patient_id', 60);

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

        Schema::create('patient_fmedicalhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_fmedicalhistory_id', 60);
            $table->string('patient_id', 60);

            $table->string('disease_id', 60);
            $table->text('disease_date');
            $table->string('disease_status', 60)->nullable();
            $table->string('remarks',255)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_fmedicalhistory_id');
        });

        Schema::create('patient_fpcounseling', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_fpcounseling_id', 60);
            $table->string('patient_id', 60);

            $table->string('counseling_date', 60);
            $table->text('counseling_status');
            $table->string('remarks',255);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_fpcounseling_id');
        });

        Schema::create('patient_immunization', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_immunization_id', 60);
            $table->string('patient_id', 60);

            $table->string('immunization_code', 60);
            $table->datetime('scheduled_date');
            $table->datetime('actual_date');
            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_immunization_id');
        });

        Schema::create('patient_immuhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_immuhistory_id', 60);

            $table->string('immunization_id', 60);
            $table->string('immunization_date', 60);
            $table->string('immunization_status', 60);
            $table->string('remarks', 255);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_immuhistory_id');
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
            $table->string('disease_date', 60);
            $table->string('disease_status', 60);
            $table->string('remarks', 60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_medicalhistory_id');
        });

        Schema::create('patient_menstrualhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_menstrualhistory_id', 60);
            $table->string('patient_id', 60);

            $table->string('menarche', 60)->nullable();
            $table->string('last_period_date', 60)->nullable();
            $table->string('last_period_duration', 60)->nullable();
            $table->string('interval', 60)->nullable();
            $table->string('no_of_pads', 60)->nullable();
            $table->string('onset_intercourse', 60)->nullable();
            $table->string('birthcontrol_method', 60)->nullable();
            $table->string('menopause', 60)->nullable();
            $table->string('menopause_age', 60)->nullable();
            $table->string('remarks', 255)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_menstrualhistory_id');
        });

        Schema::create('patient_personalhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_personalhistory_id', 60);
            $table->string('patient_id', 60);

            $table->string('smoking', 60)->nullable();
            $table->string('drinking', 60)->nullable();
            $table->string('taking_drugs', 60)->nullable();
            $table->string('remarks', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_personalhistory_id');
        });

        Schema::create('patient_philhealthinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_philhealthinfo_id', 60);
            $table->string('patient_id', 60);

            $table->string('philhealth_id', 60);
            $table->string('philheath_category', 60)->nullable();
            $table->string('member_type', 60)->nullable();
            $table->string('ccash_transfer', 60)->nullable();
            $table->string('benefit_type', 60)->nullable();
            $table->string('pamilya_pantawid_id', 60)->nullable();
            $table->boolean('indigenous_group');

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_philhealthinfo_id');
        });

        //this table should get from maternal care table not patient -_-
        Schema::create('patient_pregnancyhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_pregnancyhistory_id', 60);
            $table->string('patient_id', 60);

            $table->string('gravidity', 60)->nullable();
            $table->string('parity', 60)->nullable();
            $table->string('type_of_delivery', 60)->nullable();
            $table->string('no_of_term', 60)->nullable();
            $table->string('no_of_premature', 60)->nullable();
            $table->string('no_of_abortion', 60)->nullable();
            $table->string('no_of_children',60)->nullable();
            $table->string('remarks',255)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_pregnancyhistory_id');
        });

        Schema::create('patient_surgicalhistory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_surgicalhistory_id', 60);
            $table->string('patient_id', 60);

            $table->string('surgery', 60)->nullable();
            $table->string('surgery_date', 60)->nullable();
            $table->string('remarks', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('patient_surgicalhistory_id');
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
        Schema::dropIfExists('patient_family_group');
        Schema::dropIfExists('patient_family_group_members');
        Schema::dropIfExists('patient_familyinfo');
        Schema::dropIfExists('patient_emergencyinfo');
        Schema::dropIfExists('patient_employmentinfo');
        Schema::dropIfExists('patient_death_info');
        Schema::dropIfExists('patient_immunization');
        Schema::dropIfExists('patient_philhealthinfo');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('facility_patient_user');
        Schema::dropIfExists('patient_medicalhistory');

        Schema::dropIfExists('patient_menstrualhistory');
        Schema::dropIfExists('patient_pregnancyhistory');
        Schema::dropIfExists('patient_fmedicalhistory');
        Schema::dropIfExists('patient_personalhistory');
        Schema::dropIfExists('patient_surgicalhistory');
        Schema::dropIfExists('patient_fpcounseling');
        Schema::dropIfExists('patient_immuhistory');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
