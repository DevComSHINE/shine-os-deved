<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facility_id', 60);
            $table->string('facility_name', 60);
            $table->string('DOH_facility_code', 60)->nullable();
            $table->string('phic_accr_id', 60)->nullable();
            $table->date('phic_accr_date', 60)->nullable();
            $table->string('phic_benefit_package', 60)->nullable();
            $table->date('phic_benefit_package_date', 60)->nullable();
            $table->string('ownership_type', 60);
            $table->string('facility_type', 60);
            $table->string('provider_type', 60);
            $table->string('bmonc_cmonc', 5)->nullable();
            $table->string('hospital_license_number', 60)->nullable();
            $table->string('flag_allow_referral', 1)->nullable();
            $table->text('specializations')->nullable();
            $table->text('services')->nullable();
            $table->text('equipment')->nullable();
            $table->text('enabled_modules')->nullable();
            $table->text('enabled_plugins')->nullable();
            $table->string('facility_logo', 150)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('facility_id');
        });


        Schema::create('facility_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facilitycontact_id', 60);
            $table->string('facility_id', 60);
            $table->string('barangay', 60)->nullable();
            $table->string('city', 60)->nullable();
            $table->string('province', 60)->nullable();
            $table->string('region', 60)->nullable();
            $table->string('country', 60)->nullable();
            $table->integer('zip')->nullable();
            $table->string('phone', 60)->nullable();
            $table->string('mobile', 60)->nullable();

            $table->string('house_no', 60)->nullable();
            $table->string('building_name', 60)->nullable();
            $table->string('street_name', 60)->nullable();
            $table->string('village', 60)->nullable();
            $table->string('email_address', 60)->nullable();
            $table->string('website', 60)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('facilitycontact_id');
        });

        Schema::create('facility_workforce', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facility_id', 60);
            $table->string('facilityworkforce_id', 60);
            $table->text('workforce');

            $table->softDeletes();
            $table->timestamps();
            $table->unique('facilityworkforce_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('facilities');
        Schema::drop('facility_contact');
        Schema::drop('facility_workforce');
    }
}
