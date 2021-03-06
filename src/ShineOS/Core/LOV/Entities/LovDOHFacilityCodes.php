<?php namespace ShineOS\Core\LOV\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  

class LovDOHFacilityCodes extends Model {
    use SoftDeletes;  
    protected $fillable = [ ];
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $table = 'lov_doh_facility_codes'; 
    protected $primaryKey = 'code';
}