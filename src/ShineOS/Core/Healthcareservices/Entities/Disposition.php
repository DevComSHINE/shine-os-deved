<?php namespace ShineOS\Core\Healthcareservices\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Disposition extends Model {
    use SoftDeletes;
    protected $fillable = [
        'disposition_id',
        'healthcareservice_id',
        'disposition',
        'discharge_condition',
        'discharge_datetime',
        'discharge_notes',
        'deleted_at',
    ];

    protected $table = 'disposition';

    protected $primaryKey = 'disposition_id';
    protected $dates = array('deleted_at','discharge_datetime','created_at','updated_at');

    public function Healthcareservices() {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Healthcareservices', 'healthcareservice_id', 'healthcareservice_id');
    }
}
