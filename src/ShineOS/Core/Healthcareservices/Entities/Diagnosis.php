<?php namespace ShineOS\Core\Healthcareservices\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Diagnosis extends Model {
    use SoftDeletes;
    protected $fillable = [
        'diagnosis_id',
        'healthcareservice_id',
        'diagnosislist_id',
        'diagnosis_type',
        'diagnosis_notes',
        'status',
        'deleted_at',
    ];
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $table = 'diagnosis';
    protected $primaryKey = 'healthcareservice_id'; //change

    protected $touches = array('Healthcareservices');

    public static function getDiagnosis($hserviceID) {
        $diagnosis = DB::table('diagnosis as diag')
                        ->select(DB::raw('diag.*, diag.id as diagID,  icd.*,icd.id as icdID'))
                        ->leftJoin('diagnosis_icd10 as icd', 'diag.diagnosis_id', '=', 'icd.diagnosis_id')
                        ->where('diag.healthcareservice_id', '=', $hserviceID)
                        ->get();

        return $diagnosis;
    }

    public function DiagnosisICD10 () {
        return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\DiagnosisICD10', 'diagnosis_id', 'diagnosis_id');
    }

    public function Healthcareservices() {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Healthcareservices', 'healthcareservice_id');
    }

    public function facilityPatientUser() {
        return $this->belongsToMany('ShineOS\Core\Facilities\Entities\FacilityPatientUser','healthcare_services','facilitypatientuser_id', 'healthcareservice_id')->withPivot('created_at');
    }

}



