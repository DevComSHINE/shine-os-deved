<?php
namespace ShineOS\Core\Facilities\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB, DateTime;

class FacilityPatientUser extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facility_patient_user';
    protected static $table_name = 'facility_patient_user';
    /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'facilitypatientuser_id';

    protected $fillable = [];


    public function healthCareServices()
    {
        return $this->belongsToMany('ShineOS\Core\Healthcareservices\Entities\Healthcareservices','facility_patient_user','facilitypatientuser_id','facilitypatientuser_id')->withPivot('facilitypatientuser_id');
    }

    public function consultations()
    {
        return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\Healthcareservices','facilitypatientuser_id','facilitypatientuser_id');

    }

    public function facilityUser()
    {
        return $this->belongsToMany('ShineOS\Core\Facilities\Entities\FacilityUser', 'facility_patient_user', 'facilitypatientuser_id', 'facilityuser_id');
        //return $this->hasMany('ShineOS\Core\Facilities\Entities\FacilityUser', 'facilityuser_id', 'facilityuser_id');
    }

    public function facilities()
    {
        return $this->belongsToMany('ShineOS\Core\Facilities\Entities\Facilities', 'facility_user', 'facilityuser_id', 'facilityuser_id')->withPivot('created_at');
    }

    public function patients()
    {
        DB::enableQueryLog();
        return $this->hasMany('ShineOS\Core\Patients\Entities\Patients', 'patient_id', 'patient_id');
    }

    public function patientContact()
    {
        DB::enableQueryLog();
        return $this->hasMany('ShineOS\Core\Patients\Entities\PatientContacts', 'patient_id', 'patient_id');
    }

    public function diagnosis()
    {
        DB::enableQueryLog();
        return $this->belongsToMany('ShineOS\Core\Healthcareservices\Entities\Diagnosis','healthcare_services','facilitypatientuser_id', 'healthcareservice_id')->withPivot('created_at');
    }

    public function diagnosisIcd()
    {
        DB::enableQueryLog();
        return $this->belongsToMany('ShineOS\Core\Healthcareservices\Entities\DiagnosisICD10','diagnosis','diagnosis_id', 'diagnosis_id')->withPivot('created_at');
    }

    public function medicalOrder()
    {
        DB::enableQueryLog();
        return $this->belongsToMany('ShineOS\Core\Healthcareservices\Entities\MedicalOrder','healthcare_services','facilitypatientuser_id', 'healthcareservice_id')->withPivot('created_at');
    }

    public function deathInfo()
    {
        DB::enableQueryLog();
        return $this->hasOne('ShineOS\Core\Patients\Entities\PatientDeathInfo', 'patient_id', 'patient_id');
    }

    public function familyPlanning()
    {
        DB::enableQueryLog();
        return $this->belongsToMany('Plugins\FamilyPlanning\FamilyPlanningModel','healthcare_services','facilitypatientuser_id', 'healthcareservice_id')->withPivot('created_at');
    }

    // DYNAMIC SCOPE

    public function scopeName($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('patients', function ($q) use ($type)
            {
                $q->where('first_name','LIKE','%'.$type.'%')->orwhere('middle_name','LIKE','%'.$type.'%')->orwhere('last_name','LIKE','%'.$type.'%');
            });
        endif;

        return false;
    }

    public function scopeMonthRange($query, $month)
    {
        DB::enableQueryLog();
        if ($month != null) :
            return $query->where(DB::raw('MONTH(created_at)'), $month);
        endif;

        return false;
    }

    public function scopeQuarterRange($query, $quarter)
    {
        DB::enableQueryLog();
        if ($quarter != null) :
            return $query->where(DB::raw('QUARTER(created_at)'), $quarter);
        endif;

        return false;
    }

    public function scopeYearRange($query, $month, $year)
    {
        DB::enableQueryLog();
        if ($month != null || $year != null) :
            return $query->where(DB::raw('YEAR(created_at)'), $year);
        endif;

        return false;
    }

    public function scopeEncounter($query, $month, $year)
    {
        DB::enableQueryLog();
        if ($month != null || $year != null) :
            return $query->whereHas('consultations', function ($q) use ($month, $year)
            {
                $q->where(DB::raw('MONTH(encounter_datetime)'), $month)->orwhere(DB::raw('YEAR(encounter_datetime)'), $year);
            });
        endif;

        return false;
    }

    public function scopeEncounterMonth($query, $month)
    {
        DB::enableQueryLog();
        if ($month != null) :
            return $query->whereHas('consultations', function ($q) use ($month)
            {
                $q->where(DB::raw('MONTH(encounter_datetime)'), $month);
            });
        endif;

        return false;
    }

    public function scopeEncounterQuarter($query, $quarter)
    {
        DB::enableQueryLog();
        if ($quarter != null) :
            return $query->whereHas('consultations', function ($q) use ($quarter)
            {
                $q->where(DB::raw('QUARTER(encounter_datetime)'), $quarter);
            });
        endif;

        return false;
    }

    public function scopeEncounterYear($query, $year)
    {
        DB::enableQueryLog();
        if ($month != null) :
            return $query->whereHas('consultations', function ($q) use ($year)
            {
                $q->where(DB::raw('YEAR(encounter_datetime)'), $year);
            });
        endif;

        return false;
    }

    public function scopeAgeRange($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('patients', function ($q) use ($type)
            {
                $dateNow = new DateTime();
                $year = $dateNow->format("Y");
                $maxAge = $year - $type[0];
                $minAge = $year - $type[1];

                $q->where(DB::raw('YEAR(birthdate)'),'>', $minAge)->where(DB::raw('YEAR(birthdate)'),'<=', $maxAge);
            });
        endif;

        return false;
    }

    public function scopeSex($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('patients', function ($q) use ($type)
            {
                $q->where('gender',$type);
            });
        endif;

        return false;
    }

    public function scopeHasBarangay($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('patientContact', function ($q) use ($type)
            {
                $q->where('barangay', $type);
            });
        endif;

        return false;
    }

    public function scopeHasCityMun($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('patientContact', function ($q) use ($type)
            {
                $q->where('city', $type);
            });
        endif;

        return false;
    }

    public function scopeHasDiagnosis($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('diagnosis', function ($q) use ($type)
            {
                $type = strtolower($type);
                $q->where('diagnosislist_id','LIKE', '%'.$type.'%');
            });
        endif;

        return false;
    }

    public function scopeHasIcd10($query, $code)
    {
        DB::enableQueryLog();
        if ($code != null) :
            return $query->whereHas('diagnosisIcd', function ($q) use ($code)
            {
                $q->where('icd10_code', $code);
            });
        endif;

        return false;
    }

    public function scopeInFacility($query, $facility_id)
    {
        DB::enableQueryLog();
        if ($facility_id != null) :
            return $query->whereHas('facilityUser', function ($q) use ($facility_id)
            {
                $q->where('facility_user.facility_id', $facility_id);
            });
        endif;

        return false;
    }

    public function scopeHasMedicalOrder($query, $type)
    {
        DB::enableQueryLog();
        if ($type != null) :
            return $query->whereHas('medicalorder', function ($q) use ($type)
            {
                $q->where('medicalorder_type', $type);
            });
        endif;

        return false;
    }

    public function scopeIsDead($query, $year)
    {
        DB::enableQueryLog();

        return $query->whereHas('deathInfo', function ($q) use ($year)
        {
            $q->where(DB::raw('YEAR(datetime_death)'), $year);
        });
    }

    // MATERNAL CARE
    public function scopePrenatalVisits($query, $month, $year)
    {
        DB::enableQueryLog();

        return $query->whereHas('deathInfo', function ($q) use ($year)
        {
            $q->where(DB::raw('YEAR(datetime_death)'), $year);
        });
    }
}
