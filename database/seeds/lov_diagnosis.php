<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_diagnosis extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      	Model::unguard();

        // lov_diagnosis
    	$diagnosis = csv_to_array(base_path('/database/seeds/libraries/diagnosis.csv' ),',');
    	
    	if(is_array($diagnosis) || is_object($diagnosis))
    	{
	    	foreach ($diagnosis as $key => $value)
	    	{
	    		DB::table('lov_diagnosis')->insert([
	    			'diagnosis_id' => $value[0],
	    			'diagnosis_name' => $value[1],
	    			'diagnosis_desc' => $value[2],
	    			'sequence_num' => $value[3],
	    			'diagnosis_type' => $value[4], 
	    		]);
	    	}
	    } 
	    
		Model::reguard();
    }
}
