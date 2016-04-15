<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vital_physical', function(Blueprint $table)
        {
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
        });
    }

}
