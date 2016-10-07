<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_disabilities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();
     	// lov_disabilities
		DB::table('lov_disabilities')->insert(array(
			array('disability_id' => '1', 'disability_name' => 'Psychosocial Disability'),
			array('disability_id' => '2', 'disability_name' => 'Chronic Illness'),
			array('disability_id' => '3', 'disability_name' => 'Learning Disability'),
			array('disability_id' => '4', 'disability_name' => 'Mental Disability'),
			array('disability_id' => '5', 'disability_name' => 'Visual Disability'),
			array('disability_id' => '6', 'disability_name' => 'Orthopedic (Musculoskeletal) Disability'),
			array('disability_id' => '7', 'disability_name' => 'Hearing Disability'),
			array('disability_id' => '8', 'disability_name' => 'Speech Disability'),
			array('disability_id' => '9', 'disability_name' => 'Multiple Disability'),
			array('disability_id' => '10', 'disability_name' => 'Others'),
			));
   		Model::reguard();
    }
}
