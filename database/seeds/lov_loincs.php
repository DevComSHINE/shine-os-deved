<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_loincs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        // lov_loincs
    	$loincs = csv_to_array(base_path('/database/seeds/libraries/loincs.csv' ),';');

    	if(is_array($loincs) || is_object($loincs))
    	{
	    	foreach ($loincs as $key => $loinc)
	    	{
	    		DB::table('lov_loincs')->insert([
	    			'loinc_id' => $loinc[0],
	    			'test_id' => $loinc[1],
	    			'test_name' => $loinc[2],
	    			'result_id' => $loinc[3],
	    			'result' => $loinc[4],
	    			'loinc_code' => $loinc[5],
	    			'loinc_attribute' => $loinc[6],
	    			'updated' => $loinc[7],
	    			'method' => $loinc[8],
	    		]);
	    	}
	    } 
	    
		Model::reguard();
    }
}
