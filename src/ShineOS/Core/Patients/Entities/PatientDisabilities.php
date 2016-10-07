<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientDisabilities extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'disability_patient';
    protected static $table_name = 'disability_patient';
    protected $primaryKey = 'disability_patient_id';
    protected $fillable = [];
    protected $touches = array('PatientAlert');

    public function PatientAlert()
    {
         return $this->belongsTo('ShineOS\Core\Patients\Entities\PatientAlert', 'patient_alert_id', 'patient_alert_id');
    }

}
