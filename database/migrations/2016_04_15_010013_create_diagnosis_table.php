<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosisTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('diagnosis_id', 60);
            $table->string('healthcareservice_id', 60);
            $table->string('diagnosislist_id', 60);
            $table->string('diagnosis_type', 60);
            $table->binary('diagnosis_notes');
 
            $table->softDeletes();
            $table->timestamps();
            $table->unique('diagnosis_id');
        });

         Schema::create('diagnosis_icd10', function (Blueprint $table) {
            $table->increments('id');
            $table->string('diagnosisicd10_id', 60);
            $table->string('diagnosis_id', 60);
            $table->string('icd10_classifications', 60);
            $table->string('icd10_subClassifications', 60);
            $table->string('icd10_type', 60);
            $table->string('icd10_code', 60);
 
            $table->softDeletes();
            $table->timestamps();
            $table->unique('diagnosisicd10_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('diagnosis');
        Schema::drop('diagnosis_icd10');
    }
}
