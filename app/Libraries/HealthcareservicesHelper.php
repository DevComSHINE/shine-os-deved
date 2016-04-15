<?php namespace Shine\Libraries;
use ShineOS\Core\Healthcareservices\Entities\healthcareservicetype;
class HealthcareservicesHelper
{ 
	function __construct () {
		
	}
	
	public static function healthcareservice_name($id) {
		return healthcareservicetype::where('healthcareservicetype_id', $id)->pluck('healthcare_servicetype_name'); 
	}


}
