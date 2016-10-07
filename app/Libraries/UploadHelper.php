<?php namespace App\Libraries;

use Session;

class UploadHelper
{
	
	
	function __construct () {
		
	}

	/**
	 * Returns user info
	 *
	 * @return object
	 */
	public static function uploadImage ( $data = array() )
	{
		// prepare variables
		$_inputName = $data['inputName'];
		$_destinationPath = $data['destinationPath']; // upload path
		$_destinationResizedPath = $data['destinationPath'];
		$_flagResized = $data['flagResized'];
		
		$file = array("{$_inputName}" => Input::file("{$_inputName}"));
		$rules = array("{$_inputName}" => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
		$validator = Validator::make($file, $rules);
		
		if ($validator->fails()) {
			return false;
		}
		else {
			// checking file is valid.
			if (Input::file("{$_inputName}")->isValid()) {
				
				$extension = Input::file("{$_inputName}")->getClientOriginalExtension();
				$fileName = "profile_".rand(11111,99999).'_'.date('YmdHis').'.'.$extension;
				$originalName = Input::file("{$_inputName}")->getClientOriginalName();
				Input::file("{$_inputName}")->move($_destinationPath, $fileName);
				
				
				// update profile picture
				Users::updateProfilePicture($id, $fileName);
				
				return true;
			}
			else {
				return false;
			}
		}

	}
	
	private static function print_this( $object = array(), $title = '' ) {
		echo "<hr><h2>{$title}</h2><pre>";
		print_r($object);
		echo "</pre>";
	}
}
