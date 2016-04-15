<?php
namespace ShineOS\Core\Healthcareservices\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalOrder extends Model {
    use SoftDeletes;
  protected $dates = array('deleted_at','created_at','updated_at');

  protected $fillable = [
  'medicalorder_id',
  'healthcareservice_id',
  'medicalorder_type',
  'user_instructions',
  'medicalorder_others',
  'deleted_at'

  ];
  protected $table = 'medicalorder';
  protected $primaryKey = 'healthcareservice_id'; // change

  public function Healthcareservices() {
    return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Healthcareservices', 'healthcareservice_id', 'healthcareservice_id');
  }

  public function MedicalOrderLabExam() {
  return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\MedicalOrderLabExam', 'medicalorder_id', 'medicalorder_id');
  }

  public function MedicalOrderPrescription() {
  return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\MedicalOrderPrescription', 'medicalorder_id', 'medicalorder_id');
  }

  public function MedicalOrderProcedure() {
  return $this->hasMany('ShineOS\Core\Healthcareservices\Entities\MedicalOrderProcedure', 'medicalorder_id', 'medicalorder_id');
  }


  public function facilityPatientUser() {
    return $this->belongsToMany('Modules\Facilities\Entities\FacilityPatientUser','healthcare_services','facilitypatientuser_id', 'healthcareservice_id')->withPivot('created_at');
  }
}
