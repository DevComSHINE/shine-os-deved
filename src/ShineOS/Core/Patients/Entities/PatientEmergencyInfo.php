<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientEmergencyInfo extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_emergencyinfo';
    protected static $table_name = 'patient_emergencyinfo';
    protected $primaryKey = 'patient_emergencyinfo_id';

    //protected $fillable = [];

    public function patients()
    {
        return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients','patient_id','patient_id');
    }
}
