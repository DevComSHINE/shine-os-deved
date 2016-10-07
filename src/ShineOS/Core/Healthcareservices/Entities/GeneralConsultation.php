<?php namespace ShineOS\Core\Healthcareservices\Entities;
   
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;
    
use DB;

class GeneralConsultation extends Model {
    use SoftDeletes;
    protected $fillable = [
        'generalconsultation_id', 
        'healthcareservice_id', 
        'medicalcategory_id',
        'complaint',
        'complaint_history',
        'physical_examination',
        'remarks',
        'deleted_at',
    ];

    protected $table = 'general_consultation';
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $primaryKey = 'generalconsultation_id'; 

    public function Healthcareservices() {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Healthcareservices', 'healthcareservice_id');
    }
}
