<?php

namespace ShineOS\Core\Users\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Shine\Libraries\IdGenerator;

use Input;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForgotPassword extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'forgot_password';
	protected static $table_name = 'forgot_password';
	
	/**
	 * Override primary key used by model
	 *
	 * @var int
	 */
	protected $primaryKey = 'forgot_password_id';
	
	
	/**
	 * Returns table name
	 *
	 * @return string
	 */
	protected static function getTableName () {
		return self::$table_name;
	}
	
	/**
	 * Inserts contact details
	 *
	 * @return object
	 */
	protected static function insertChangePasswordRequest ( $email = '', $forgot_password_code = "" ) {
		$forgotPassword = new ForgotPassword();
		$forgotPassword->forgot_password_id = IdGenerator::generateId();
		$forgotPassword->email = (Input::get('email') == NULL) ? $email : Input::get('email');
		$forgotPassword->forgot_password_code = $forgot_password_code;
		$forgotPassword->save();
		
		return $forgotPassword;
	}
	
	/**
	 * Retrieve contact details
	 *
	 * @return object
	 */
	protected static function getPasswordCode ( $forgot_password_code = 0 ) {
		return self::where('forgot_password_code', $forgot_password_code)->first();
	}

}
