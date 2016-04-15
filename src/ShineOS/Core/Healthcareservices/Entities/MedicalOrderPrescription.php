<?php namespace ShineOS\Core\Healthcareservices\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MedicalOrderPrescription extends Model {
    use SoftDeletes;
    protected $dates = array('regimen_startdate', 'regimen_enddate', 'deleted_at','created_at','updated_at');
    protected $fillable = [
        'medicalorderprescription_id',
        'medicalorder_id',
        'generic_name',
        'brand_name',
        'dose_quantity',
        'total_quantity',
        'dosage_regimen',
        'duration_of_intake',
        'regimen_startdate',
        'regimen_enddate',
        'prescription_remarks',
        'deleted_at'
    ];

    protected $table = 'medicalorder_prescription';
    protected $primaryKey = 'medicalorderprescription_id';

    public function MedicalOrder() {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\MedicalOrder', 'medicalorder_id', 'medicalorder_id');
    }
}
