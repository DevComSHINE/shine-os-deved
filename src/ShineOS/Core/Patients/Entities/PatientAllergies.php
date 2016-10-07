<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientAllergies extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'allergy_patient';
    protected static $table_name = 'allergy_patient';
    protected $primaryKey = 'allergy_patient_id';
    protected $fillable = [];
    protected $touches = array('PatientAlert');

    public function PatientAlert() {
        return $this->belongsTo('ShineOS\Core\Patients\Entities\PatientAlert', 'patient_alert_id', 'patient_alert_id');
    }
}
