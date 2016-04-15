<?php namespace ShineOS\Core\Facilities\Entities;

use Illuminate\Database\Eloquent\Model;


class FacilityUser extends Model {

    protected $fillable = [];
    protected $table = 'facility_user';
    protected static $static_table = 'facility_user';

       /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'facilityuser_id';

    public function patients()
    {
        return $this->belongsToMany('ShineOS\Core\Patients\Entities\Patients','facility_patient_user','patient_id','patient_id')->withPivot('created_at');
    }
 
    public function healthCareServices()
    {
        return $this->belongsToMany('ShineOS\Core\Healthcareservices\Entities\Healthcareservices');
    }  
 
	public static function addUserToFacility ( $data = array() )
	{
		$FacilityUser = new FacilityUser();
		$FacilityUser->user_id = $data['user_id'];
		$FacilityUser->facility_id = $data['facility_id'];
		$FacilityUser->save();
		
		return $FacilityUser;
	} 

    public function facilityPatientUser() {
        return $this->hasMany('ShineOS\Core\Facilities\Entities\FacilityPatientUser', 'facilityuser_id','facilityuser_id');
    }

    public function facilities()
    {
        return $this->belongsToMany('ShineOS\Core\Facilities\Entities\Facilities','facilityuser_id');
    }
}