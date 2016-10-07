<?php 
namespace ShineOS\Core\Users\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Shine\Libraries\IdGenerator;

use Input;

class MDUsers extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_md';
	protected static $table_name = 'user_md';
	
	/**
	 * Override primary key used by model
	 *
	 * @var int
	 */
	//protected $primaryKey = 'usermd_id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];
	
	
	/**
	 * Returns table name
	 *
	 * @return string
	 */
	protected static function getTableName() {
		return self::$table_name;
	}
	
	/**
	 * Inserts User MD details
	 *
	 * @return object
	 */
	protected static function insertUserMDInfo( $user_id = 0 ) {
		$md = new MDUsers();
		$md->user_id = $user_id;
		$md->usermd_id = IdGenerator::generateId();
		$md->save();
		
		return $md;
	}
	
	/**
	 * Retreive MD details
	 *
	 * @return object
	 */
	protected static function getRecordById( $user_id = 0 ) {
		return self::where('user_id', $user_id)->first();
	}
	
	public function users()
	{
		return self::where('user_id', $user_id)->first();
	}
}