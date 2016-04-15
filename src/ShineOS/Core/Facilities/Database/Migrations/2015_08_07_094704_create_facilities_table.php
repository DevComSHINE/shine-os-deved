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
            $table->string('DOH_facility_code', 60);
            $table->string('phic_accr_id', 60);
            $table->date('phic_accr_date', 60);
            $table->string('phic_benefit_package', 60);
            $table->date('phic_benefit_package_date', 60);
            $table->string('ownership_type', 60);
            $table->string('facility_type', 60);
            $table->string('provider_type', 60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('facility_id');
        });


        Schema::create('facility_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facilitycontact_id', 60);
            $table->string('facility_id', 60);
            $table->string('address', 60);
            $table->string('barangay', 60);
            $table->string('city', 60);
            $table->string('province', 60);
            $table->string('region', 60);
            $table->string('country', 60);
            $table->integer('zip');
            $table->string('phone', 60);
            $table->string('mobile', 60);
            
            $table->softDeletes();
            $table->timestamps();
            $table->unique('facilitycontact_id');
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
    }
}
