<?php namespace ShineOS\Core\Patients\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMonitoring extends Model {
    use SoftDeletes;  
    protected $fillable = [];
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $table = 'patient_monitoring'; 
    protected $primaryKey = 'monitoring_id';

    protected $touches = array('patients');
    
    public function patients() {
		return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients','patient_id','patient_id');
	}

}