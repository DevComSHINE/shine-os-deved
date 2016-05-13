<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        //health care services
         Schema::table('healthcare_services', function (Blueprint $table) {
            $table->foreign('facilitypatientuser_id')
                  ->references('facilitypatientuser_id')
                  ->on('facility_patient_user')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        //facilities
        Schema::table('facility_contact', function (Blueprint $table) {
            $table->foreign('facility_id')
                  ->references('facility_id')
                  ->on('facilities')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::table('facility_user', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('facility_id')
                  ->references('facility_id')
                  ->on('facilities')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::table('facility_patient_user', function (Blueprint $table) {
            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('facilityuser_id')
                  ->references('facilityuser_id')
                  ->on('facility_user')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        //users
        Schema::table('user_md', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::table('user_contact', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::table('user_usage_stat', function (Blueprint $table) {
            $table->foreign('user_id')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        //roles
        /*Schema::table('feature_role', function (Blueprint $table) {
            $table->foreign('role_id')
                  ->references('role_id')
                  ->on('roles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('feature_id')
                  ->references('feature_id')
                  ->on('features')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });*/

        //patients
        Schema::table('patient_contact', function (Blueprint $table) {
            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('patient_alert', function (Blueprint $table) {
            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('allergy_patient', function (Blueprint $table) {
            $table->foreign('patient_alert_id')
                  ->references('patient_alert_id')
                  ->on('patient_alert')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('disability_patient', function (Blueprint $table) {
            $table->foreign('patient_alert_id')
                  ->references('patient_alert_id')
                  ->on('patient_alert')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('patient_familyinfo', function (Blueprint $table) {
            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('patient_family_group_members', function (Blueprint $table) {
            $table->foreign('patient_familygroup_id')
                  ->references('patient_familygroup_id')
                  ->on('patient_family_group')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('patient_emergencyinfo', function (Blueprint $table) {
            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('patient_death_info', function (Blueprint $table) {
            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        Schema::table('patient_immunization', function (Blueprint $table) {
            $table->foreign('patient_id')
                  ->references('patient_id')
                  ->on('patients')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });

        //medical order
        Schema::table('medicalorder', function (Blueprint $table) {
            $table->foreign('healthcareservice_id')
                  ->references('healthcareservice_id')
                  ->on('healthcare_services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::table('medicalorder_prescription', function (Blueprint $table) {
            $table->foreign('medicalorder_id')
                  ->references('medicalorder_id')
                  ->on('medicalorder')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::table('medicalorder_laboratoryexam', function (Blueprint $table) {
            $table->foreign('medicalorder_id')
                  ->references('medicalorder_id')
                  ->on('medicalorder')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::table('medicalorder_procedure', function (Blueprint $table) {
            $table->foreign('medicalorder_id')
                  ->references('medicalorder_id')
                  ->on('medicalorder')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        //consultation
        Schema::table('general_consultation', function (Blueprint $table) {
            $table->foreign('healthcareservice_id')
                  ->references('healthcareservice_id')
                  ->on('healthcare_services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            /*$table->foreign('medicalcategory_id')
                  ->references('medicalcategory_id')
                  ->on('lov_medicalcategory')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');*/
        });

        Schema::table('vital_physical', function (Blueprint $table) {
            $table->foreign('healthcareservice_id')
                  ->references('healthcareservice_id')
                  ->on('healthcare_services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        Schema::table('examination', function (Blueprint $table) {
            $table->foreign('healthcareservice_id')
                  ->references('healthcareservice_id')
                  ->on('healthcare_services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        //diagnosis
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->foreign('healthcareservice_id')
                  ->references('healthcareservice_id')
                  ->on('healthcare_services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });


        //chest xray

        Schema::table('chest_xray', function (Blueprint $table) {
             $table->foreign('healthcareservice_id')
                  ->references('healthcareservice_id')
                  ->on('healthcare_services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
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
    }
}
