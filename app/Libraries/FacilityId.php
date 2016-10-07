<?php namespace Shine\Libraries;

use Session;

class FacilityId
{
	
	function __construct () {
		
	}
	
	/**
	 * Generates unique ID based on a given set of random numbers and timestamp
	 *
	 * returns ID
	 */
	public static function retrieve ()
	{
		return Session::get('_global_facility_id');
	}
}
