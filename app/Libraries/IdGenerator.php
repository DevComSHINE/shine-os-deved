<?php namespace Shine\Libraries;

class IdGenerator
{
	
	function __construct () {
		
	}
	
	/**
	 * Generates unique ID based on a given set of random numbers and timestamp
	 *
	 * @var int
	 */
	public static function generateId ( $prefix_length = 7 )
	{
		return self::randomNumber($prefix_length).date('yymmddhis');
	}
	
	
	/**
	 * Generates random numbers
	 *
	 * @var int
	 */
	private static function randomNumber( $length = 7 ) {
		$result = '';

		for($i = 0; $i < $length; $i++) {
			$result .= mt_rand(0, 9);
		}

		return $result;
	}
}
