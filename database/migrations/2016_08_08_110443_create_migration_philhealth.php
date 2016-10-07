<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigrationPhilhealth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_philhealthinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patient_id', 32);
            $table->string('philhealth_id', 32);

            $table->string('philhealth_category', 32)->nullable();
            $table->string('member_type', 32)->nullable();
            $table->string('ccash_transfer', 32)->nullable();
            $table->string('benefit_type', 32)->nullable();
            $table->string('pamilya_pantawid_id', 32)->nullable();
            $table->string('indigenous_group', 32)->nullable();
            $table->string('benefactor_member_id', 32)->nullable();
            $table->string('benefactor_first_name', 32)->nullable();
            $table->string('benefactor_last_name', 32)->nullable();   
            $table->string('benefactor_middle_name', 32)->nullable();
            $table->string('benefactor_name_suffix', 32)->nullable();
            $table->text('application_form')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('philhealth_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('patient_philhealthinfo');
    }

}
