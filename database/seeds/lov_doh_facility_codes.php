<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_doh_facility_codes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
       	// lov_doh_facility_codes
    	$dohs = csv_to_array(base_path('/database/seeds/libraries/facilities.csv' ),';');

    	if(is_array($dohs) || is_object($dohs))
    	{
	    	foreach ($dohs as $key => $doh)
	    	{
	    		DB::table('lov_doh_facility_codes')->insert([
	    			'code' => $doh[1],
	    			'name' => $doh[2],
	    			'address' => $doh[3],
	    			'region' => $doh[4],
	    			'barangay' => $doh[7],
	    			'province' => $doh[5],
	    			'city' => $doh[6],
	    			'zip' => $doh[8],
	    			'landline' => $doh[9],
	    			'cellphone' => $doh[10],
	    			'fax' => $doh[11],
	    			'email' => $doh[12],
	    			'email2' => $doh[13],
	    			'website' => $doh[14],
	    			'ownership' => $doh[15],
	    			'type' => $doh[16],
	    			'status' => $doh[17],
	    		]);
	    	}
	    }
	    Model::reguard();
    }
}
