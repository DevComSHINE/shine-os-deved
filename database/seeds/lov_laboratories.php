<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_laboratories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        // lov_laboratories
    	$labs = csv_to_array(base_path('/database/seeds/libraries/laboratories.csv' ),',');

    	if(is_array($labs) || is_object($labs))
    	{
	    	foreach ($labs as $key => $lab)
	    	{
	    		DB::table('lov_laboratories')->insert([
	    			'laboratory_id' => $lab[0],
	    			'laboratorycode' => $lab[1],
	    			'laboratorydescription' => $lab[2],
	    		]);
	    	}
	    } 
	    
		Model::reguard();
    }
}
