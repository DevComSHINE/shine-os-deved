<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_address extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();
    	
        // lov_barangays
    	$brgys = csv_to_array(base_path( '/database/seeds/libraries/rbrgy.csv' ),',');

    	if(is_array($brgys) || is_object($brgys))
    	{
	    	foreach ($brgys as $key => $brgy)
	    	{
	    		DB::table('lov_barangays')->insert([
	    			'barangay_id' => $key + 1,
	    			'region_code' => $brgy[0],
	    			'province_code' => $brgy[1],
	    			'city_code' => $brgy[2],
	    			'barangay_code' => $brgy[3],
	    			'barangay_name' => $brgy[4],
	    			'nscb_barangaycode' => $brgy[5],
	    			'nscb_barangayname' => $brgy[6],
	    			'barangay_long' => $brgy[7],
	    			'barangay_lat' => $brgy[8],
	    			'userLevel_id' => $brgy[10],
	    			'barangay_status' => $brgy[12],
	    		]);
	    	}
	    } 

		//lov_region
    	$rgns = csv_to_array(base_path('/database/seeds/libraries/rregion.csv' ),',');

    	if(is_array($rgns) || is_object($rgns))
    	{
	    	foreach ($rgns as $key => $rgn)
	    	{
	    		DB::table('lov_region')->insert([
	    			'region_id' => $key + 1,
	    			'region_code' => $rgn[0],
	    			'region_short' => $rgn[1],
	    			'region_name' => $rgn[2],
	    			'region_abbreviation' => $rgn[3],
	    			'nscb_regioncode' => $rgn[4],
	    			'nscb_regionname' => $rgn[5],
	    			'userLevel_id' => $rgn[6],
	    			'region_status' => $rgn[9],
	    		]);
	    	}
	    }    

		// lov_province
    	$prvns = csv_to_array(base_path('/database/seeds/libraries/rprov.csv' ),',');

    	if(is_array($prvns) || is_object($prvns))
    	{
	    	foreach ($prvns as $key => $prvn)
	    	{
	    		DB::table('lov_province')->insert([
	    			'province_id' => $key + 1,
	    			'region_code' => $prvn[0],
	    			'province_code' => $prvn[1],
	    			'province_name' => $prvn[2],
	    			'nscb_provincecode' => $prvn[3],
	    			'nscb_provincename' => $prvn[4],
	    			'userLevel_id' => $prvn[6],
	    			'province_status' => $prvn[8],
	    		]);
	    	}
	    } 

		// lov_citymunicipalities
    	$cms = csv_to_array(base_path('/database/seeds/libraries/rcitymun.csv' ),',');

    	if(is_array($cms) || is_object($cms))
    	{
	    	foreach ($cms as $key => $cm)
	    	{
	    		DB::table('lov_citymunicipalities')->insert([
	    			'citymunicipality_id' => $key + 1,
	    			'region_code' => $cm[0],
	    			'province_code' => $cm[1],
	    			'city_code' => $cm[2],
	    			'city_name' => $cm[3],
	    			'nscb_citycode' => $cm[4],
	    			'nscb_cityname' => $cm[6],
	    			'userLevel_id' => $cm[7],
	    			'citymun_status' => $cm[9],
	    		]);
	    	}
	    } 

	    Model::reguard();
    }
}
