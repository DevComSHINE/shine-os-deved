<?php

namespace ShineOS\Core\Healthcareservices\Entities;
   
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes; 


class Examination extends Model {
use SoftDeletes;
    protected $fillable = [
        'examination_id', 
        'healthcareservice_id', 
        'Pallor',
        'Rashes',
        'Jaundice',
        'Good_Skin_Turgor',
        'skin_others',
        'Anicteric_Sclerae',
        'Pupils',
        'Aural_Discharge',
        'Intact_Tympanic_Membrane',
        'Alar_Flaring',
        'Nasal_Discharge',
        'Tonsillopharyngeal_Congestion',
        'Hypertrophic_Tonsils',
        'Palpable_Mass_B',
        'Exudates',
        'heent_others',
        'Symmetrical_Chest_Expansion',
        'Clear_Breathsounds',
        'Retractions',
        'Crackles_Rales',
        'Wheezes',
        'chest_others',
        'Adynamic_Precordium',
        'Rhythm',
        'Heaves',
        'Murmurs',
        'heart_others',
        'Flat',
        'Globular',
        'Flabby',
        'Muscle_Guarding',
        'Tenderness',
        'Palpable_Mass',
        'abdomen_others',
        'Gross_Deformity',
        'Normal_Gait',
        'Full_Equal_Pulses',
        'extreme_others',
        'deleted_at',
    ];

    protected $table = 'examination';
    protected $primaryKey = 'examination_id';
    protected $dates = array('deleted_at','created_at','updated_at');

    public function Healthcareservices() {
        return $this->belongsTo('ShineOS\Core\Healthcareservices\Entities\Healthcareservices', 'healthcareservice_id');
    }
}
