<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_consultation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('generalconsultation_id', 60);
            $table->string('healthcareservice_id', 60);
            $table->string('medicalcategory_id', 60);
            $table->binary('complaint');
            $table->binary('complaint_history');
            $table->binary('physical_examination');
            $table->binary('remarks');

            $table->softDeletes();
            $table->timestamps();
            $table->unique('generalconsultation_id');
        });

         Schema::create('vital_physical', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vitalphysical_id', 60);
            $table->string('healthcareservice_id', 60);
            $table->string('bloodpressure_systolic', 60);
            $table->string('bloodpressure_diastolic', 60);
            $table->string('bloodpressure_assessment', 60)->nullable();
            $table->string('heart_rate', 60)->nullable();
            $table->string('pulse_rate', 60)->nullable();
            $table->string('respiratory_rate', 60)->nullable();
            $table->string('temperature', 60);
            $table->string('height', 60);
            $table->string('weight', 60);
            $table->string('BMI_category', 60)->nullable();
            $table->string('waist', 60)->nullable();
            $table->boolean('pregnant')->nullable();
            $table->boolean('weight_loss')->nullable();
            $table->boolean('with_intact_uterus')->nullable();
            $table->text('Pain_Scale')->nullable();
            $table->text('Head_abnormal')->nullable();
            $table->text('Eyes_abnormal')->nullable();
            $table->text('Ent_abnormal')->nullable();
            $table->text('Cardiovascular_abnormal')->nullable();
            $table->text('Breasts_abnormal')->nullable();
            $table->text('Chest_abnormal')->nullable();
            $table->text('Back_abnormal')->nullable();
            $table->text('Abdomen_abnormal')->nullable();
            $table->text('Pelvis_abnormal')->nullable();
            $table->text('Rectal_abnormal')->nullable();
            $table->text('Upper_Extremities_abnormal')->nullable();
            $table->text('Lower_Extremities_abnormal')->nullable();
            $table->text('Integumentary_abnormal')->nullable();
            $table->text('Skin_abnormal')->nullable();
            $table->text('Nails_abnormal')->nullable();
            $table->text('Hair_abnormal')->nullable();
            $table->text('physical_examination')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('vitalphysical_id');
        });

        Schema::create('examination', function (Blueprint $table) {
            $table->increments('id');
            $table->string('examination_id', 60);
            $table->string('healthcareservice_id', 60);
            $table->string('Pallor', 5)->nullable();
            $table->string('Rashes', 5)->nullable();
            $table->string('Jaundice', 5)->nullable();
            $table->string('Good_Skin_Turgor', 5)->nullable();
            $table->string('skin_others', 5)->nullable();
            $table->string('Anicteric_Sclerae', 5)->nullable();
            $table->string('Pupils', 5)->nullable();
            $table->string('Aural_Discharge', 5)->nullable();
            $table->string('Intact_Tympanic_Membrane', 5)->nullable();
            $table->string('Nasal_Discharge', 5)->nullable();
            $table->string('Tonsillopharyngeal_Congestion', 5)->nullable();
            $table->string('Hypertrophic_Tonsils', 5)->nullable();
            $table->string('Palpable_Mass_B', 5)->nullable();
            $table->string('Exudates', 5)->nullable();
            $table->string('heent_others', 5)->nullable();
            $table->string('Symmetrical_Chest_Expansion', 5)->nullable();
            $table->string('Clear_Breathsounds', 5)->nullable();
            $table->string('Crackles_Rales', 5)->nullable();
            $table->string('Wheezes', 5)->nullable();
            $table->string('chest_others', 5)->nullable();
            $table->string('Adynamic_Precordium', 5)->nullable();
            $table->string('Rhythm', 5)->nullable();
            $table->string('Heaves', 5)->nullable();
            $table->string('Murmurs', 5)->nullable();
            $table->string('heart_others', 5)->nullable();
            $table->string('anatomy_heart_Others', 5)->nullable();
            $table->string('Flat', 5)->nullable();
            $table->string('Globular', 5)->nullable();
            $table->string('Flabby', 5)->nullable();
            $table->string('Muscle_Guarding', 5)->nullable();
            $table->string('Tenderness', 5)->nullable();
            $table->string('Palpable_Mass', 5)->nullable();
            $table->string('abdomen_others', 5)->nullable();
            $table->string('Normal_Gait', 5)->nullable();
            $table->string('Full_Equal_Pulses', 5)->nullable();
            $table->string('extreme_others', 5)->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('examination_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('general_consultation');
        Schema::drop('vital_physical');
        Schema::drop('examination');
    }
}
