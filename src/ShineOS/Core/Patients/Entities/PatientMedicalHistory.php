<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMedicalHistory extends Model {

    use SoftDeletes;
    protected $table = 'patient_medicalhistory';
    protected static $table_name = 'patient_medicalhistory';
    protected $primaryKey = 'patient_medicalhistory_id';

    protected $touches = array('patients');

    protected $fillable = [];

    public function patients()
    {
        return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients','patient_id','patient_id');
    }
}

?>
