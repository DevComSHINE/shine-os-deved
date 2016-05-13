<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLovTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lov_diagnosis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('diagnosis_id', 60);
            $table->string('diagnosis_name', 60);
            $table->text('diagnosis_desc');
            $table->string('sequence_num', 60);
            $table->string('diagnosis_type', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('diagnosis_id');
        });

        Schema::create('lov_allergy_reaction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('allergyreaction_id', 60);
            $table->string('allergyreaction_name', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('allergyreaction_id');
        });

        Schema::create('lov_diseases', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('disease_id');
            $table->string('disease_category');
            $table->string('disease_code', 60);
            $table->string('disease_name',255);
            $table->string('phie_name');
            $table->string('disease_input_type');
            $table->string('disease_radio_values');
            $table->char('sex_limit',1);
            $table->integer('min_age_limit',11);
            $table->integer('max_age_limit',11);
            $table->smallInteger('block_width',6);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('disease_id');
        });

        Schema::create('lov_disabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('disability_id', 60);
            $table->string('disability_name', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('disability_id');
        });

        Schema::create('lov_immunizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('immunization_code', 60);
            $table->string('immunization_short_desc', 60);
            $table->text('immunization_desc');
            $table->string('cvx_code', 30);
            $table->softDeletes();
            $table->timestamps();

            //$table->unique('immunization_code');
        });


        Schema::create('lov_medicalcategory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('medicalcategory_id', 60);
            $table->string('medicalcategory_group', 60);
            $table->string('medicalcategory_code', 60);
            $table->string('medicalcategory_name', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('medicalcategory_id');
        });

        Schema::create('lov_icd10', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icd10_id', 60);
            $table->string('icd10_code', 60);
            $table->string('icd10_category', 60);
            $table->string('icd10_subcategory', 60);
            $table->string('icd10_tricategory', 60);
            $table->text('icd10_title');
            $table->softDeletes();
            $table->timestamps();

            $table->unique('icd10_id');
        });

        Schema::create('lov_barangays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barangay_id', 60);
            $table->string('region_code', 60);
            $table->string('province_code', 60);
            $table->string('city_code', 60);
            $table->string('barangay_code', 60);
            $table->string('barangay_name', 60);
            $table->string('nscb_barangaycode', 60);
            $table->string('nscb_barangayname', 60);
            $table->string('barangay_long', 60);
            $table->string('barangay_lat', 60);
            $table->string('userLevel_id', 60);
            $table->string('barangay_status', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('barangay_id');
        });

        Schema::create('lov_drugs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('drugs_id', 60);
            $table->string('product_id', 60);
            $table->text('drug_specification');
            $table->softDeletes();
            $table->timestamps();

            $table->unique('drugs_id');
        });


        Schema::create('lov_region', function (Blueprint $table) {
            $table->increments('id');
            $table->string('region_id', 60);
            $table->string('region_code', 60);
            $table->string('region_short', 60);
            $table->string('region_name', 60);
            $table->string('region_abbreviation', 60);
            $table->string('nscb_regioncode', 60);
            $table->string('nscb_regionname', 60);
            $table->string('userLevel_id', 60);
            $table->string('region_status', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('region_id');
        });


         Schema::create('lov_province', function (Blueprint $table) {
            $table->increments('id');
            $table->string('region_code', 60);
            $table->string('province_id', 60);
            $table->string('province_code', 60);
            $table->string('province_name', 60);
            $table->string('nscb_provincecode', 60);
            $table->string('nscb_provincename', 60);
            $table->string('userLevel_id', 60);
            $table->string('province_status', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('province_id');
        });

         Schema::create('lov_citymunicipalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('citymunicipality_id', 60);
            $table->string('region_code', 60);
            $table->string('province_code', 60);
            $table->string('city_code', 60);
            $table->string('city_name', 60);
            $table->string('nscb_citycode', 60);
            $table->string('nscb_cityname', 60);
            $table->string('userLevel_id', 60);
            $table->string('citymun_status', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('citymunicipality_id');
        });

         Schema::create('lov_medicalprocedures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('medicalprocedure_id', 60);
            $table->string('procedure_code', 60);
            $table->text('procedure_description');
            $table->softDeletes();
            $table->timestamps();

            $table->unique('procedure_code');
        });

        Schema::create('lov_loincs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('loinc_id', 60);
            $table->string('test_id', 60);
            $table->string('test_name', 120);
            $table->string('result_id', 60);
            $table->string('result', 60);
            $table->string('loinc_code', 60);
            $table->text('loinc_attribute');
            $table->date('updated', 60);
            $table->string('method', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('loinc_id');
        });

        Schema::create('lov_laboratories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('laboratory_id', 60);
            $table->string('laboratorycode', 60);
            $table->string('laboratorydescription', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('laboratory_id');
        });

        Schema::create('lov_doh_facility_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 60);
            $table->string('name', 60);
            $table->string('address', 150);
            $table->string('region', 150);
            $table->string('barangay', 150);
            $table->string('province', 150);
            $table->string('city', 150);
            $table->string('zip', 5);
            $table->string('landline', 10);
            $table->string('cellphone', 30);
            $table->string('fax', 30);
            $table->string('email', 60);
            $table->string('email2', 60);
            $table->string('website', 60);
            $table->string('ownership', 30);
            $table->string('type', 30);
            $table->string('status', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('code');

        });

        Schema::create('lov_enumerations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('enum_id', 60);
            $table->string('code', 60);
            $table->string('description', 60);
            $table->string('sequence_number', 10);
            $table->string('enum_type_id', 60);
            $table->softDeletes();
            $table->timestamps();

            $table->unique('enum_id');

        });

        Schema::create('lov_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('module_name', 60);
            $table->string('icon', 60);
            $table->tinyInteger('menu_show');
            $table->integer('menu_order', 11);
            $table->integer('status', 11);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('lov_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('form_name', 60);
            $table->string('facility_id', 60);
            $table->string('status', 60);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('lov_roles_access', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('module_id');
            $table->enum('module_access', ['1','2','3','4']);
            $table->integer('form_id',50);
            $table->enum('form_access', ['1','2','3','4']);
            $table->tinyInteger('status');
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
       Schema::drop('lov_diagnosis');
       Schema::drop('lov_allergy_reaction');
       Schema::drop('lov_disabilities');
       Schema::drop('lov_medicalcategory');
       Schema::drop('lov_icd10');
       Schema::drop('lov_barangays');
       Schema::drop('lov_drugs');
       Schema::drop('lov_region');
       Schema::drop('lov_province');
       Schema::drop('lov_citymunicipalities');
       Schema::drop('lov_medicalprocedures');
       Schema::drop('lov_immunizations');
       Schema::drop('lov_loincs');
       Schema::drop('lov_laboratories');
       Schema::drop('lov_doh_facility_codes');
       Schema::drop('lov_enumerations');
       Schema::drop('lov_modules');
       Schema::drop('lov_forms');
       Schema::drop('lov_roles_access');
       Schema::drop('lov_roles');
    }
}
