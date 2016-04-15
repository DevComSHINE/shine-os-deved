<?php namespace ShineOS\Core\Healthcareservices\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use DB;

class VitalsPhysical extends Model {
use SoftDeletes;
    protected $fillable = [
        'vitalphysical_id',
        'healthcareservice_id',
        'bloodpressure_systolic',
        'bloodpressure_diastolic',
        'bloodpressure_assessment',
        'heart_rate',
        'height',
        'weight',
        'BMI_category',
        'waist',
        'deleted_at',
    ];

    protected $table = 'vital_physical'; 
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $primaryKey = 'vitalphysical_id';
    

    public static function computeBMICategory($bmi) {
        $cat = false;

        if ($bmi < 15.0) {
            $cat = "SWA";
        }

        if ($bmi >= 15.0 &&  $bmi <= 16.0) {
            $cat = "WAS";
        }

        if ($bmi >= 16.0 &&  $bmi <= 18.0) {
            $cat = "UND";
        }

        if ($bmi >= 18.5 &&  $bmi <= 25) {
            $cat = "NOR";
        }

        if ($bmi >= 25 &&  $bmi <= 30) {
            $cat = "OVE";
        }

        if ($bmi >= 30 &&  $bmi <= 35) {
            $cat = "OBE";
        }

        if ($bmi >= 35 &&  $bmi <= 40) {
            $cat = "OBEII";
        }

        if ($bmi > 40) {
            $cat = "OBEIII";
        }

        return  $cat;
    }

    public function Healthcareservices() {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Healthcareservices', 'healthcareservice_id');
    }
}
