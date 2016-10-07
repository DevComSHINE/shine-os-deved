<?php namespace ShineOS\Core\Healthcareservices\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiagnosisICD10 extends Model {
    use SoftDeletes;

    protected $fillable = [
        'diagnosisicd10_id',
        'diagnosis_id',
        'icd10_classifications',
        'icd10_subClassifications',
        'icd10_type',
        'icd10_code',
        'status',
        'deleted_at',
    ];

    protected $table = 'diagnosis_icd10';
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $primaryKey = 'diagnosisicd10_id';

    protected $touches = array('Healthcareservices');

    public function Healthcareservices() {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Healthcareservices', 'healthcareservice_id', 'healthcareservice_id');
    }

    public function Diagnosis()
    {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Diagnosis','diagnosis_id','diagnosis_id');
    }

    public static function DiagnosisICD10 () {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Diagnosis','diagnosis_id','diagnosis_id');
    }

}
