<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class MedicalHistoryModel extends Model {

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_medicalhistory';
    protected static $table_name = 'patient_medicalhistory';
    protected $primaryKey = 'patient_id';

    public function patients()
    {
        return $this->belongsTo('Modules\Patients\Entities\Patients');
    }

}
