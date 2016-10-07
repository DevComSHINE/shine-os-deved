<?php namespace ShineOS\Core\Healthcareservices\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//Relationship
use DB;

class Healthcareservices extends Model {
    use SoftDeletes;
    protected $dates = array('encounter_datetime','deleted_at','created_at','updated_at');
    protected $fillable = [];

    protected $table = 'healthcare_services';
    protected static $static_table = 'healthcare_services';
    protected $primaryKey = 'healthcareservice_id';

    protected function setPrimaryKey($key)
    {
      $this->primaryKey = $key;
    }

    public function GeneralConsultation() {
        return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\GeneralConsultation', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function VitalsPhysical() {
        return $this->hasOne('ShineOS\Core\Healthcareservices\Entities\VitalsPhysical', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function Examination() {
        return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\Examination', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function Diagnosis() {
        return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\Diagnosis', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function MedicalOrder() {
        return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\MedicalOrder', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function Disposition() {
        return $this->hasOne('ShineOS\Core\Healthcareservices\Entities\Disposition', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function Addendum() {
        return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\Addendum', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function MaternalCare() {
        return $this->hasMany('Plugins\MaternalCare\MaternalCareModel', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function patients() {
        DB::enableQueryLog();
        return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients', 'facility_patient_user', 'facilitypatientuser_id','facilitypatientuser_id')->withPivot('patient_id');
    }

    public function facilityUser() {
        DB::enableQueryLog();
        return $this->belongsToMany('ShineOS\Core\Facilities\Entities\FacilityUser');
    }

    // DYNAMIC SCOPE PUT HERE
    public function scopeDiagnosis ($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('Diagnosis', function ($q) use ($type)
            {
                $q->where('diagnosislist_id', $type);
            });
        endif;

        return false;
    }

    public function scopeMedicalOrder ($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('MedicalOrder', function ($q) use ($type)
            {
                $q->where('medicalorder_type', $type);
            });
        endif;

        return false;
    }

    public function scopePatient ($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('patients', function ($q) use ($type)
            {
                $q->where('patient_id', $type);
            });
        endif;

        return false;
    }
}
