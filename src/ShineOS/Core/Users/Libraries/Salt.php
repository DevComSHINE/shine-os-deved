<?php namespace ShineOS\Core\Users\Libraries;



class Salt {

	function __construct(){
	}
	
	
	/**
	 * Generate random salt
	 *
	 * @return string
	 */
	public static function generateRandomSalt ( $length = 10 )
	{
		return self::randomString($length);
	}
	
	
	public static function randomString ( $length = 10 )
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}
