<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // lov_referral_reasons
        DB::table('roles')->insert(array(
          array('id' => '1','role_id' => '1','role_name' => 'Admin','core_access' => '{"Records":[1,2,3,4],"Patients":[1,2,3,4],"Healthcareservices":[1,2,3,4],"Reports":[1,2,3,4],"Referrals":[1,2,3,4],"Reminders":[1,2,3,4],"Users":[1,2,3,4],"Facilities":[1,2,3,4],"Extensions":[1,2,3,4]}','access_level' => '0','role_create' => '0','role_read' => '0','role_update' => '0','role_delete' => '0','deleted_at' => NULL,'created_at' => '2015-12-08 21:00:00','updated_at' => '2015-12-08 22:22:00'),
          array('id' => '2','role_id' => '2','role_name' => 'Doctor','core_access' => '{"Records":[1,2,3,4],"Patients":[1,2,3,4],"Healthcareservices":[1,2,3,4],"Reports":[1,2,3,4],"Reminders":[1,2,3,4],"Referrals":[1,2,3,4],"Users":[1,2,3,4],"Facilities":[1,2,3,4]}','access_level' => '0','role_create' => '0','role_read' => '0','role_update' => '0','role_delete' => '0','deleted_at' => NULL,'created_at' => '2015-12-08 16:00:00','updated_at' => '2015-12-08 22:22:00'),
          array('id' => '3','role_id' => '3','role_name' => 'Midwife','core_access' => '{"Records":[1,2,3,4],"Patients":[1,2,3,4],"Healthcareservices":[1,2,3,4],"Reminders":[1,2,3,4],"Referrals":[1,2,3,4]}','access_level' => '0','role_create' => '0','role_read' => '0','role_update' => '0','role_delete' => '0','deleted_at' => NULL,'created_at' => '2015-12-08 22:00:00','updated_at' => '2015-12-08 22:22:00'),
          array('id' => '4','role_id' => '4','role_name' => 'Nurse','core_access' => '{"Records":[1,2,3,4],"Patients":[1,2,3,4],"Healthcareservices":[1,2,3,4],"Reminders":[1,2,3,4],"Referrals":[1,2,3,4]}','access_level' => '0','role_create' => '0','role_read' => '0','role_update' => '0','role_delete' => '0','deleted_at' => NULL,'created_at' => '2015-12-09 01:25:00','updated_at' => '2015-12-08 22:22:00'),
          array('id' => '5','role_id' => '5','role_name' => 'Encoder','core_access' => '{"Records":[1,2,3,4],"Patients":[1,2,3,4],"Healthcareservices":[1,2,3,4]}','access_level' => '0','role_create' => '0','role_read' => '0','role_update' => '0','role_delete' => '0','deleted_at' => NULL,'created_at' => '2015-12-08 19:15:00','updated_at' => '2015-12-08 22:22:00'),
          array('id' => '6','role_id' => '0','role_name' => 'Developer','core_access' => '{"Records":[1,2,3,4],"Patients":[1,2,3,4],"Healthcareservices":[1,2,3,4],"Reports":[1,2,3,4],"Users":[1,2,3,4],"Facilities":[1,2,3,4]}','access_level' => '0','role_create' => '0','role_read' => '0','role_update' => '0','role_delete' => '0','deleted_at' => NULL,'created_at' => '2015-12-08 22:22:00','updated_at' => '2015-12-08 22:22:00')
        ));

        Model::reguard();
    }
}
