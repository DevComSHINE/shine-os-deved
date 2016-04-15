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

class Contact extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_contact';
	protected static $table_name = 'user_contact';
	
	/**
	 * Override primary key used by model
	 *
	 * @var int
	 */
	protected $primaryKey = 'facilitycontact_id';
	
	
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
	protected static function insertUserContact ( $user_id = 0 ) {

		$contact = new Contact();
		$contact->usercontact_id = IdGenerator::generateId(); //change to hashed ID generated
		$contact->phone = Input::get('phone');
		$contact->mobile = Input::get('mobile');
		$contact->user_id = $user_id;
		$contact->save();
		
		return $contact;
	}
	
	/**
	 * Retrieve contact details
	 *
	 * @return object
	 */
	protected static function getRecordById ( $user_id = 0 ) {
		return self::where('user_id', $user_id)->first();
	}

	public function users()
	{
		return $this->belongsTo('ShineOS\Core\Users\Entities\Users','user_id');
	}
}