<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicalorder', function (Blueprint $table) {
            $table->increments('id');
            $table->string('medicalorder_id', 60);
            $table->string('healthcareservice_id', 60);
            $table->string('medicalorder_type', 60);
            $table->binary('user_instructions');
            $table->binary('medicalorder_others')->nullable;
            
            $table->softDeletes();
            $table->timestamps();
            $table->unique('medicalorder_id');
        });

        Schema::create('medicalorder_prescription', function (Blueprint $table) {
            $table->increments('id');
            $table->string('medicalorderprescription_id', 60);
            $table->string('medicalorder_id', 60);
            
            $table->string('generic_name', 60);
            $table->string('brand_name', 60);
            $table->string('dose_quantity', 60);
            $table->string('total_quantity', 60);
            $table->string('dosage_regimen', 60);
            $table->string('dosage_regimen_others', 60);
            $table->string('duration_of_intake', 60);
            $table->date('regimen_startdate');
            $table->date('regimen_enddate');
            $table->binary('prescription_remarks');

            $table->softDeletes();
            $table->timestamps();
            $table->unique('medicalorderprescription_id');
        });

        Schema::create('medicalorder_laboratoryexam', function (Blueprint $table) {
            $table->increments('id');
            $table->string('medicalorderlaboratoryexam_id', 60);
            $table->string('medicalorder_id', 60);
            $table->string('laboratory_test_type', 60);
            $table->string('laboratory_test_type_others', 60);
            $table->datetime('Date_Performed')->nullable();
            $table->date('Date_of_Result')->nullable();
            $table->time('Time_of_Result')->nullable();
            $table->binary('Examination_Result')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('medicalorderlaboratoryexam_id');
        });


        Schema::create('medicalorder_procedure', function (Blueprint $table) {
            $table->increments('id');
            $table->string('medicalorderprocedure_id', 60);
            $table->string('medicalorder_id', 60);
            $table->binary('procedure_order');
            $table->datetime('procedure_date');
          
            $table->softDeletes();
            $table->timestamps();
            $table->unique('medicalorderprocedure_id');
        });
                
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('medicalorder');
        Schema::drop('medicalorder_prescription');
        Schema::drop('medicalorder_laboratoryexam');
        Schema::drop('medicalorder_medicalprocedure');
       
    }
}
