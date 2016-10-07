<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientAlert extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_alert';
    protected static $table_name = 'patient_alert';
    protected $primaryKey = 'patient_alert_id';
    protected $touches = array('patients');
    protected $fillable = [];

    public function patients()
    {
        return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients');
    }

    public function PatientAllergies()
    {
        return $this->hasMany('ShineOS\Core\Patients\Entities\PatientAllergies', 'patient_alert_id', 'patient_alert_id');
    }

}

?>
