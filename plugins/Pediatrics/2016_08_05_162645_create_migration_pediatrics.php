<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigrationPediatrics extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pediatrics_service', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pediatrics_id', 60);
            $table->string('healthcareservice_id', 60);
            $table->string('pediatricscase_id', 60)->nullable();

            $table->date('newborn_screening_referral_date')->nullable();
            $table->date('newborn_screening_actual_date')->nullable();
            $table->date('child_protection_date')->nullable();
            $table->string('tt_status', 32)->nullable();
            $table->double('birth_weight')->nullable();
            $table->date('vit_a_supp_first_date')->nullable();
            $table->integer('vit_a_first_age')->nullable();
            $table->date('vit_a_supp_second_date')->nullable();
            $table->integer('vit_a_second_age')->nullable();
            $table->date('iron_supp_start_date')->nullable();
            $table->date('iron_supp_end_date')->nullable();
            $table->date('bcg_recommended_date')->nullable();
            $table->date('bcg_actual_date')->nullable();
            $table->date('dpt1_recommended_date')->nullable();
            $table->date('dpt1_actual_date')->nullable();
            $table->date('dpt2_recommended_date')->nullable();
            $table->date('dpt2_actual_date')->nullable();
            $table->date('dpt3_recommended_date')->nullable();
            $table->date('dpt3_actual_date')->nullable();
            $table->date('hepa_b1_recommended_date')->nullable();
            $table->date('hepa_b1_actual_date')->nullable();
            $table->date('hepa_b2_recommended_date')->nullable();
            $table->date('hepa_b2_actual_date')->nullable();
            $table->date('hepa_b3_recommended_date')->nullable();
            $table->date('hepa_b3_actual_date')->nullable();
            $table->date('measles_recommended_date')->nullable();
            $table->date('measles_actual_date')->nullable();
            $table->date('opv1_recommended_date')->nullable();
            $table->date('opv1_actual_date')->nullable();
            $table->date('opv2_recommended_date')->nullable();
            $table->date('opv2_actual_date')->nullable();
            $table->date('opv3_recommended_date')->nullable();
            $table->date('opv3_actual_date')->nullable();
            $table->date('penta1_recommended_date')->nullable();
            $table->date('penta1_actual_date')->nullable();
            $table->date('penta2_recommended_date')->nullable();
            $table->date('penta2_actual_date')->nullable();
            $table->date('penta3_recommended_date')->nullable();
            $table->date('penta3_actual_date')->nullable();
            $table->date('rota1_recommended_date')->nullable();
            $table->date('rota1_actual_date')->nullable();
            $table->date('rota2_recommended_date')->nullable();
            $table->date('rota2_actual_date')->nullable();
            $table->date('rota3_recommended_date')->nullable();
            $table->date('rota3_actual_date')->nullable();
            $table->date('pcv1_recommended_date')->nullable();
            $table->date('pcv1_actual_date')->nullable();
            $table->date('pcv2_recommended_date')->nullable();
            $table->date('pcv2_actual_date')->nullable();
            $table->date('pcv3_recommended_date')->nullable();
            $table->date('pcv3_actual_date')->nullable();
            $table->date('mcv1_recommended_date')->nullable();
            $table->date('mcv1_actual_date')->nullable();
            $table->date('mcv2_recommended_date')->nullable();
            $table->date('mcv2_actual_date')->nullable();

            $table->tinyInteger('is_breastfed_first_month')->nullable();
            $table->tinyInteger('is_breastfed_second_month')->nullable();
            $table->tinyInteger('is_breastfed_third_month')->nullable();
            $table->tinyInteger('is_breastfed_fourth_month')->nullable();
            $table->tinyInteger('is_breastfed_fifth_month')->nullable();
            $table->tinyInteger('is_breastfed_sixth_month')->nullable();
            $table->tinyInteger('breastfeed_sixth_month')->nullable();

            $table->softDeletes();
            $table->timestamps();
            $table->unique('healthcareservice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pediatrics_service');
    }

}
