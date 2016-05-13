<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 60);
            $table->string('password', 60);
            $table->string('salt', 60);
            $table->string('email', 60);
            $table->string('activation_code', 60);
            $table->string('first_name', 60);
            $table->string('middle_name', 60)->nullable;
            $table->string('last_name', 60);
            $table->string('suffix', 60);

            $table->string('civil_status', 60);
            $table->enum('gender', array('F', 'M', 'U'));
            $table->date('birth_date');
            $table->string('user_type', 60);

            $table->string('remember_token');
            $table->string('profile_picture', 200)->nullable;
            $table->text('prescription_header')->nullable;
            $table->string('qrcode', 1)->nullable;

            $table->string('status', 60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('user_id');
        });

        Schema::create('user_md', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usermd_id', 60);
            $table->string('user_id', 60);
            $table->string('profession', 60)->nullable;
            $table->string('professional_type_id', 60)->nullable;
            $table->string('professional_license_number', 60)->nullable;
            $table->string('med_school', 60)->nullable;
            $table->string('med_school_grad_yr', 60)->nullable;
            $table->string('residency_trn_inst', 60)->nullable;
            $table->string('residency_grad_yr', 60)->nullable;

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('user_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usercontact_id', 60);
            $table->string('user_id', 60);
            $table->string('house_no', 60)->nullable;
            $table->string('building_name', 150)->nullable;
            $table->string('street_name', 60)->nullable;
            $table->string('village', 60)->nullable;
            $table->string('street_address', 60)->nullable;
            $table->string('barangay', 60)->nullable;
            $table->string('city', 60)->nullable;
            $table->string('province', 60)->nullable;
            $table->string('region', 60)->nullable;
            $table->string('country', 60)->nullable;
            $table->integer('zip')->nullable;
            $table->string('phone', 60)->nullable;
            $table->string('mobile', 60)->nullable;

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('user_usage_stat', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userusagestat_id', 60);
            $table->string('user_id', 60);
            $table->datetime('login_datetime');
            $table->datetime('logout_datetime');
            $table->string('device');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('facility_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facilityuser_id', 60);
            $table->string('user_id', 60);
            $table->string('facility_id', 60);
            $table->string('featureroleuser_id', 60);

            $table->softDeletes();
            $table->timestamps();
            $table->unique('facilityuser_id');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_id', 60);
            $table->string('role_name', 60);
            $table->text('core_access', 60);
            $table->tinyInteger('access_level');
            $table->tinyInteger('role_create');
            $table->tinyInteger('role_read');
            $table->tinyInteger('role_update');
            $table->tinyInteger('role_delete');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('roles_access', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_id', 60);
            $table->string('facilityuser_id', 60);

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
        Schema::drop('user_md');
        Schema::drop('user_contact');
        Schema::drop('user_usage_stat');
        Schema::drop('users');
        Schema::drop('facility_user');
        Schema::drop('roles');
        Schema::drop('roles_access');
    }
}
