<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientSurgicalHistory extends Model {

    use SoftDeletes;
    protected $table = 'patient_surgicalhistory';
    protected static $table_name = 'patient_surgicalhistory';
    protected $primaryKey = 'patient_surgicalhistory_id';

    protected $touches = array('patients');

    protected $fillable = [];

    public function patients()
    {
        return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients','patient_id','patient_id');
    }
}

?>
