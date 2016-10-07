<?php namespace ShineOS\Core\Facilities\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use ShineOS\Core\Users\Entities\FacilityUser as FacilityU;

use DB, Input;

class Facilities extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facilities';
    protected static $table_name = 'facilities';

    /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'facility_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function facilityUser()
    {
        return $this->hasOne('ShineOS\Core\Facilities\Entities\FacilityUser','facility_id');
    }


    /**
     * Returns table name
     *
     * @return string
     */
    public static function getTableName () {
        return self::$table_name;
    }


    /**
     * Returns table name
     *
     * @return object
     */
    public static function getFacilityList ()
    {
        return DB::table(self::$table_name)->simplePaginate(15);
    }


    /**
     * Returns facility info
     *
     * @return object
     */
    public static function getCurrentFacility ($facility_id)
    {
        return Facilities::with('facilityContact', 'facilityWorkforce')->where('facility_id','=', $facility_id)->first();        
    }

    /**
    * Returns Facility Name
    *
    * @return Name String
    */
    // Added by Romel
    protected static function getFacilityByFacilityUserID ( $facilityuser_id ) {
        $fac = FacilityU::where('facilityuser_id', $facilityuser_id)
            ->first();
        $facility = self::where('facility_id', $fac->facility_id)
            ->first();
        return $facility;
    }

    protected static function getFacilityNameByFacilityUserID ( $facilityuser_id ) {
        if($facilityuser_id) {
            $fac = FacilityU::where('facilityuser_id', $facilityuser_id)
                ->first();
            $facility = self::where('facility_id', $fac->facility_id)
                ->first();
            return $facility->facility_name;
        } else {
            return NULL;
        }
    }

    /**
     * Returns facility info by DOH Code
     *
     * @return object
     */
    public static function getFacilityByDOHCode ( $code = '' )
    {
        return self::where('DOH_facility_code', $code)->first();
    }

    /**
     * Updates facility by id
     *
     * @return object
     */
    public static function updateFacilityById( $facility_id = 0 ) {

        $facility = self::find($facility_id);
        $facility->facility_name = Input::get('facility_name');
        $facility->phic_accr_id = Input::get('phic_accr_id');
        $facility->ownership_type = Input::get('ownership_type');
        $facility->provider_type = Input::get('provider_type');
        $facility->facility_type = Input::get('facility_type');
        $facility->bmonc_cmonc = Input::get('bmonc_cmonc');
        $facility->hospital_license_number = Input::get('hospital_license_number');
        $facility->flag_allow_referral = Input::get('flag_allow_referral');

        $facility->save();

        return $facility;
    }

    /**
     * Updates facility specialization by id
     *
     * @return object
     */
    public static function updateFacilitySpecializationById( $id = 0 ) {

        $facility = self::find($id);
        if(Input::has('specializations')):
        $facility->specializations = implode(',', Input::get('specializations'));
        endif;
        if(Input::has('services')):
        $facility->services = implode(',', Input::get('services'));
        endif;
        if(Input::has('equipment')):
        $facility->equipment = implode(',', Input::get('equipment'));
        endif;
        $facility->save();

        return $facility;
    }

    /**
     * Update Facility Logo
     *
     * @return object
     */
    protected static function updateLogo ( $facility_id = '', $logo = '' ) {
        $facility = self::where('facility_id', $facility_id)
            ->first();

        $facility->facility_logo = $logo;
        $facility->save();

        return $facility;
    }

    /**
     * INTERNAL QUERIES
     */
    public function facilityContact()
    {
        return $this->hasOne('ShineOS\Core\Facilities\Entities\FacilityContact','facility_id','facility_id');
    }

    public function facilityWorkforce()
    {
        return $this->hasOne('ShineOS\Core\Facilities\Entities\FacilityWorkforce','facility_id','facility_id')->orderBy('created_at', 'DESC');
    }

    /**
     *  EXTERNAL QUERIES
     */

    /**
     * Get user facilities
     *
     * @return array
     */
    public function users()
    {
        return $this->belongsToMany('ShineOS\Core\Users\Entities\Users', 'facility_user', 'facility_id', 'user_id')->withPivot('facilityuser_id');
    }

    public function patients()
    {
        return $this->belongsToMany('ShineOS\Core\Patients\Entities\Patients', 'facility_patient_user', 'facility_id', 'user_id')->withPivot('facilityuser_id');
    }

    public function facilityUsers()
    {
        return $this->hasMany('ShineOS\Core\Facilities\Entities\FacilityUser', 'facility_user', 'facility_id', 'facility_id');
    }

    public function facilityPatientUsers()
    {
        return $this->hasMany('ShineOS\Core\Facilities\Entities\FacilityPatientUser', 'facility_user', 'facilityuser_id', 'facilityuser_id')->withPivot('created_at');
    }
}
