<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_modules extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('lov_modules')->insert(array(
  array('id' => '1','module_name' => 'dashboard','icon' => 'fa-dashboard','menu_show' => '1','menu_order' => '0','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '2','module_name' => 'facilities','icon' => 'fa-hospital-o','menu_show' => '1','menu_order' => '10001','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '3','module_name' => 'healthcareservices','icon' => '','menu_show' => '0','menu_order' => '0','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '4','module_name' => 'patients','icon' => '','menu_show' => '0','menu_order' => '0','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '5','module_name' => 'records','icon' => 'fa-archive','menu_show' => '1','menu_order' => '1','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '6','module_name' => 'referrals','icon' => 'fa-paper-plane-o','menu_show' => '1','menu_order' => '2','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '7','module_name' => 'reminders','icon' => 'fa-calendar-check-o','menu_show' => '1','menu_order' => '3','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '8','module_name' => 'reports','icon' => 'fa-clipboard','menu_show' => '1','menu_order' => '4','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '9','module_name' => 'roles','icon' => 'fa-user-md','menu_show' => '0','menu_order' => '0','status' => '0','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '10','module_name' => 'users','icon' => 'fa-group','menu_show' => '1','menu_order' => '10000','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '11','module_name' => 'settings','icon' => 'fa-gears','menu_show' => '1','menu_order' => '10003','status' => '0','deleted_at' => '2016-04-11 07:44:12','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '12','module_name' => 'calendar','icon' => 'fa-calendar','menu_show' => '1','menu_order' => '11','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00'),
  array('id' => '13','module_name' => 'extensions','icon' => 'fa-plug','menu_show' => '1','menu_order' => '10002','status' => '1','deleted_at' => '2016-04-04 02:28:48','created_at' => '0000-00-00 00:00:00','updated_at' => '0000-00-00 00:00:00')
));

        Model::reguard();
    }
}

