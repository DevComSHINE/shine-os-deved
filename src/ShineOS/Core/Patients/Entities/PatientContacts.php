<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientContacts extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_contact';
    protected static $table_name = 'patient_contact';
    protected $primaryKey = 'patient_contact_id';

    public function patients()
    {
        return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients','patient_id','patient_id');
    }

    public function facilitypatientuser()
    {
        return $this->belongsTo('ShineOS\Core\Patients\Entities\FacilityPatientUser','patient_id','patient_id');
    }

    
    public function scopeBarangay($query, $type)
    {
        return $query->where('barangay','LIKE','"%'.$type.'%"');
    }

}

?>
