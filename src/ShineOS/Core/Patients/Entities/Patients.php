<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Patients extends Model {

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patients';
    protected static $table_name = 'patients';
    protected $primaryKey = 'patient_id';


    public function facilityUser()
    {
        return $this->belongsToMany('ShineOS\Core\Facilities\Entities\FacilityUser', 'facility_patient_user', 'patient_id', 'facilityuser_id')->withPivot('created_at');
    }

    public function facilityPatientUser()
    {
         return $this->hasMany('ShineOS\Core\Patients\Entities\facilityPatientUser', 'patient_id', 'patient_id');
    }

    public function patientAlert()
    {
        return $this->hasMany('ShineOS\Core\Patients\Entities\PatientAlert', 'patient_id', 'patient_id');
    }

    public function patientContact()
    {
        return $this->hasOne('ShineOS\Core\Patients\Entities\PatientContacts', 'patient_id', 'patient_id');
    }

    public function patientDeathInfo()
    {
        return $this->hasOne('ShineOS\Core\Patients\Entities\PatientDeathInfo','patient_id','patient_id');
    }

    public function patientEmergencyInfo()
    {
        return $this->hasOne('ShineOS\Core\Patients\Entities\PatientEmergencyInfo','patient_id','patient_id');
    }

    // revised by Romel
    public function patientAllergies()
    {
        return $this->hasManyThrough('ShineOS\Core\Patients\Entities\PatientAllergies','ShineOS\Core\Patients\Entities\PatientAlert','patient_id','patient_alert_id');
    }
    // revised by Romel
    public function patientDisabilities()
    {
        return $this->hasManyThrough('ShineOS\Core\Patients\Entities\PatientDisabilities','ShineOS\Core\Patients\Entities\PatientAlert','patient_id','patient_alert_id');
    }

    public function patientMonitoring()
    {
        return $this->hasMany('ShineOS\Core\Patients\Entities\PatientMonitoring','patient_id','patient_id');
    }

    public function patientMedicalHistory()
    {
        return $this->hasMany('ShineOS\Core\Patients\Entities\PatientMedicalHistory','patient_id','patient_id');
    }

    public function healthcareservices()
    {
        return $this->hasManyThrough('ShineOS\Core\Healthcareservices\Entities\Healthcareservices','ShineOS\Core\Patients\Entities\FacilityPatientUser','patient_id','facilitypatientuser_id')->orderBy('encounter_datetime', 'desc');
    }

    // Dynamic Scopes Here
    public function scopeName($query, $type)
    {
        return $query->where('first_name','LIKE','%'.$type.'%')->orwhere('middle_name','LIKE','%'.$type.'%')->orwhere('last_name','LIKE','%'.$type.'%');
    }

    public function scopeGender($query, $type)
    {
        return $query->whereGender('gender','LIKE','%'.$type.'%');
    }


    /**
     * Update Patient Profile Photo
     *
     * @return object
     */
    protected static function updatePatientPicture ( $patient_id = '', $profile_picture = '' ) {
        $patient = self::where('patient_id', $patient_id)
            ->first();
        $patient->photo_url = $profile_picture;
        $patient->save();

        return $patient;
    }
}
