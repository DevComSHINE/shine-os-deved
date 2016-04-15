<?php namespace ShineOS\Core\Healthcareservices\Entities;
   
use Illuminate\Database\Eloquent\Model;
use DB;

class TBModel extends Model {

    protected $fillable = [
        'healthcareservice_id', 
        'tbcasenumber', 
        'date_treatment_started',
        'BCG_scar',
        'treatment_outcome',
        'date_last_intake',
        'treatment_regimen',
        'bacteriological_status',
        'anatomical_site',
        'registration_group',
        'deleted_at',
    ];

    protected $table = 'tuberculosis';
	protected static $static_table = 'healthcare_services';

    protected $primaryKey = 'tuberculosis_id';


}