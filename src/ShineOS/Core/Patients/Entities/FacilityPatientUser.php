<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacilityPatientUser extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facility_patient_user';
    protected static $table_name = 'facility_patient_user';
    /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'facilitypatientuser_id';

    protected $fillable = [];

    public function patients()
    {
        return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients','patient_id','patient_id');
    }

    public function facilities()
    {
        return $this->belongsToMany('ShineOS\Core\Facilities\Entities\Facilities','facility_user','facilityuser_id','facility_id')->withPivot('facilityuser_id');
    }

    public function patientContact()
    {
        return $this->has('ShineOS\Core\Patients\Entities\PatientContacts','patient_id','patient_id');
    }
}
