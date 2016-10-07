<?php 
namespace ShineOS\Core\Users\Libraries;

class Cache {

	/**
	 * Get cached details
	 *
	 * @return array
	 */
	public static function getCachedData ($type)
	{
		return Cache::get($type);
	}

	public static function setCachedData ($cacheName, $arr)
	{
		return Cache::forever($cacheName, $arr);
	}

}
