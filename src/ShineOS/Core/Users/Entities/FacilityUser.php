<?php 
namespace ShineOS\Core\Users\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Laracasts\TestDummy\Factory as TestDummy;

class FacilityUser extends Model {
	
	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'facility_user';
	protected static $table_name = 'facility_user';
	
	/**
	 * Override primary key used by model
	 *
	 * @var int
	 */
	protected $primaryKey = 'facilityuser_id';

	public static function addUserToFacility ( $data = array() )
	{
		$FacilityUser = new FacilityUser();
		$FacilityUser->user_id = $data['user_id'];
		$FacilityUser->facility_id = $data['facility_id'];
		$FacilityUser->facilityuser_id = $data['facilityuser_id'];
		$FacilityUser->save();
		
		return $FacilityUser;
	}

	public function users()
	{
		return $this->belongsTo('ShineOS\Core\Users\Entities\Users','user_id','user_id');	
	}

	private static function print_this( $object = array(), $title = '' ) {
		echo "<hr><h2>{$title}</h2><pre>";
		print_r($object);
		echo "</pre>";
	}
}