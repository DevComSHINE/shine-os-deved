<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_roles_access extends Seeder
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
    	DB::table('lov_roles_access')->insert(array(
			array('role_id' => '1', 'module_id' => '1', 'module_access' => '1'),
			array('role_id' => '1', 'module_id' => '1', 'module_access' => '2'),
			array('role_id' => '1', 'module_id' => '1', 'module_access' => '3'),
			array('role_id' => '1', 'module_id' => '1', 'module_access' => '4'),

			array('role_id' => '1', 'module_id' => '4', 'module_access' => '1'),
			array('role_id' => '1', 'module_id' => '4', 'module_access' => '2'),
			array('role_id' => '1', 'module_id' => '4', 'module_access' => '3'),
			array('role_id' => '1', 'module_id' => '4', 'module_access' => '4'),

			array('role_id' => '2', 'module_id' => '1', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '1', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '1', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '1', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '1', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '1', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '1', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '1', 'module_access' => '4'),

			array('role_id' => '4', 'module_id' => '1', 'module_access' => '1'),
			array('role_id' => '4', 'module_id' => '1', 'module_access' => '2'),
			array('role_id' => '4', 'module_id' => '1', 'module_access' => '3'),
			array('role_id' => '4', 'module_id' => '1', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '1', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '1', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '1', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '1', 'module_access' => '4'),



			array('role_id' => '1', 'module_id' => '2', 'module_access' => '1'),
			array('role_id' => '1', 'module_id' => '2', 'module_access' => '2'),
			array('role_id' => '1', 'module_id' => '2', 'module_access' => '3'),
			array('role_id' => '1', 'module_id' => '2', 'module_access' => '4'),

			array('role_id' => '2', 'module_id' => '2', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '2', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '2', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '2', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '2', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '2', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '2', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '2', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '2', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '2', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '2', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '2', 'module_access' => '4'),



			array('role_id' => '2', 'module_id' => '3', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '3', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '3', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '3', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '3', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '3', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '3', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '3', 'module_access' => '4'),

			array('role_id' => '4', 'module_id' => '3', 'module_access' => '1'),
			array('role_id' => '4', 'module_id' => '3', 'module_access' => '2'),
			array('role_id' => '4', 'module_id' => '3', 'module_access' => '3'),
			array('role_id' => '4', 'module_id' => '3', 'module_access' => '4'),

			array('role_id' => '5', 'module_id' => '3', 'module_access' => '1'),
			array('role_id' => '5', 'module_id' => '3', 'module_access' => '2'),
			array('role_id' => '5', 'module_id' => '3', 'module_access' => '3'),
			array('role_id' => '5', 'module_id' => '3', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '3', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '3', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '3', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '3', 'module_access' => '4'),



			array('role_id' => '2', 'module_id' => '4', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '4', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '4', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '4', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '4', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '4', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '4', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '4', 'module_access' => '4'),

			array('role_id' => '4', 'module_id' => '4', 'module_access' => '1'),
			array('role_id' => '4', 'module_id' => '4', 'module_access' => '2'),
			array('role_id' => '4', 'module_id' => '4', 'module_access' => '3'),
			array('role_id' => '4', 'module_id' => '4', 'module_access' => '4'),

			array('role_id' => '5', 'module_id' => '4', 'module_access' => '1'),
			array('role_id' => '5', 'module_id' => '4', 'module_access' => '2'),
			array('role_id' => '5', 'module_id' => '4', 'module_access' => '3'),
			array('role_id' => '5', 'module_id' => '4', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '4', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '4', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '4', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '4', 'module_access' => '4'),



			array('role_id' => '2', 'module_id' => '5', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '5', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '5', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '5', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '5', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '5', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '5', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '5', 'module_access' => '4'),

			array('role_id' => '4', 'module_id' => '5', 'module_access' => '1'),
			array('role_id' => '4', 'module_id' => '5', 'module_access' => '2'),
			array('role_id' => '4', 'module_id' => '5', 'module_access' => '3'),
			array('role_id' => '4', 'module_id' => '5', 'module_access' => '4'),

			array('role_id' => '5', 'module_id' => '5', 'module_access' => '1'),
			array('role_id' => '5', 'module_id' => '5', 'module_access' => '2'),
			array('role_id' => '5', 'module_id' => '5', 'module_access' => '3'),
			array('role_id' => '5', 'module_id' => '5', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '5', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '5', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '5', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '5', 'module_access' => '4'),



			array('role_id' => '2', 'module_id' => '6', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '6', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '6', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '6', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '6', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '6', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '6', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '6', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '6', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '6', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '6', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '6', 'module_access' => '4'),



			array('role_id' => '2', 'module_id' => '7', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '7', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '7', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '7', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '7', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '7', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '7', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '7', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '7', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '7', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '7', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '7', 'module_access' => '4'),



			array('role_id' => '2', 'module_id' => '8', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '8', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '8', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '8', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '8', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '8', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '8', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '8', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '8', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '8', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '8', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '8', 'module_access' => '4'),



			array('role_id' => '1', 'module_id' => '9', 'module_access' => '1'),
			array('role_id' => '1', 'module_id' => '9', 'module_access' => '2'),
			array('role_id' => '1', 'module_id' => '9', 'module_access' => '3'),
			array('role_id' => '1', 'module_id' => '9', 'module_access' => '4'),

			array('role_id' => '2', 'module_id' => '9', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '9', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '9', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '9', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '9', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '9', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '9', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '9', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '9', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '9', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '9', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '9', 'module_access' => '4'),



			array('role_id' => '1', 'module_id' => '10', 'module_access' => '1'),
			array('role_id' => '1', 'module_id' => '10', 'module_access' => '2'),
			array('role_id' => '1', 'module_id' => '10', 'module_access' => '3'),
			array('role_id' => '1', 'module_id' => '10', 'module_access' => '4'),

			array('role_id' => '2', 'module_id' => '10', 'module_access' => '1'),
			array('role_id' => '2', 'module_id' => '10', 'module_access' => '2'),
			array('role_id' => '2', 'module_id' => '10', 'module_access' => '3'),
			array('role_id' => '2', 'module_id' => '10', 'module_access' => '4'),

			array('role_id' => '3', 'module_id' => '10', 'module_access' => '1'),
			array('role_id' => '3', 'module_id' => '10', 'module_access' => '2'),
			array('role_id' => '3', 'module_id' => '10', 'module_access' => '3'),
			array('role_id' => '3', 'module_id' => '10', 'module_access' => '4'),

			array('role_id' => '0', 'module_id' => '10', 'module_access' => '1'),
			array('role_id' => '0', 'module_id' => '10', 'module_access' => '2'),
			array('role_id' => '0', 'module_id' => '10', 'module_access' => '3'),
			array('role_id' => '0', 'module_id' => '10', 'module_access' => '4')
		));

        Model::reguard();
    }
}
