<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_drugs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        // lov_drugs
    	$drugs = csv_to_array(base_path('/database/seeds/libraries/r_drugs.csv' ),',');

    	if(is_array($drugs) || is_object($drugs))
    	{
	    	foreach ($drugs as $key => $drug)
	    	{
	    		DB::table('lov_drugs')->insert([
	    			'drugs_id' => $key + 1,
	    			'product_id' => $drug[0],
	    			'drug_specification' => $drug[1],
	    		]);
	    	}
	    }
		Model::reguard();
    }
}
