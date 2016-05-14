<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_icd10 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        // lov_icd10
    	$icds = csv_to_array(base_path( '/database/seeds/libraries/icds.csv' ),';');

    	if(is_array($icds) || is_object($icds))
    	{
	    	foreach ($icds as $key => $icd)
	    	{
	    		DB::table('lov_icd10')->insert([
	    			'icd10_id' => $icd[0],
	    			'icd10_code' => $icd[1],
	    			'icd10_category' => $icd[2],
	    			'icd10_subcategory' => $icd[3],
	    			'icd10_tricategory' => $icd[4],
	    			'icd10_title' => $icd[5],
	    		]);
	    	}
	    }
	    
		Model::reguard();
    }
}
