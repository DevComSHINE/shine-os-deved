<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lov_enumerations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Model::unguard();

        $enums = csv_to_array(base_path('/database/seeds/libraries/enumerations.csv' ),',');

    	if(is_array($enums) || is_object($enums))
    	{
	    	foreach ($enums as $key => $enum)
	    	{
	    		DB::table('lov_enumerations')->insert([
	    			'enum_id' => $enum[0],
	    			'code' => $enum[1],
	    			'description' => $enum[2],
	    			'sequence_number' => $enum[3],
	    			'enum_type_id' => $enum[4],
	    		]);
	    	}
	    }
	    
		Model::reguard();
    }
}
