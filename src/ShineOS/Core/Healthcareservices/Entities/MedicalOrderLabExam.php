<?php namespace ShineOS\Core\Healthcareservices\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MedicalOrderLabExam extends Model {
    use SoftDeletes;
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $fillable = [
        'medicalorderlaboratoryexam_id',
        'medicalorder_id',
        'laboratory_test_type',
        'laboratory_test_type_others',
        'deleted_at'

    ];

    protected $table = 'medicalorder_laboratoryexam';
    protected $primaryKey = 'medicalorderlaboratoryexam_id';

      public function MedicalOrder() {
          return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\MedicalOrder', 'medicalorder_id', 'medicalorder_id');
      }
}
