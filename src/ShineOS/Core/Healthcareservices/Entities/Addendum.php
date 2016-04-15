<?php namespace ShineOS\Core\Healthcareservices\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use DB;

class Addendum extends Model {
    use SoftDeletes;  
    protected $fillable = ['addendum_id',
                            'healthcareservice_id', 
                            'addendum_notes',
                            'deleted_at',
                            ];
                            
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $table = 'healthcare_addendum'; 
    protected $primaryKey = 'addendum_id'; 

    public function Healthcareservices() {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Healthcareservices', 'healthcareservice_id');
    }
}



