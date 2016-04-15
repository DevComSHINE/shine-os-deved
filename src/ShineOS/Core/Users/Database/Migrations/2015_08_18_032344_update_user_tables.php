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
        Schema::table('user_contact', function(Blueprint $table)
        {
			$table->string('house_no', 60);
			$table->string('building_name', 150);
			$table->string('street_name', 60);
			$table->string('village');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        Schema::table('user_contact', function(Blueprint $table)
        {
			$table->dropColumn(['house_no', 'building_name', 'street_name', 'village']);
        });
    }

}
