<?php namespace ShineOS\Core\Users\Libraries;



class TempId {

	function __construct(){
	}
	
	public static function generateId ( $prefix = '' )
	{
		return $prefix.date('yymmddhis');
	}
}
