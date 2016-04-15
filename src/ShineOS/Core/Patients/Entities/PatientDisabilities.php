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

    public function patients()
    {
        return $this->belongsToMany('ShineOS\Core\Patients\Entities\Patients');
    }

}
