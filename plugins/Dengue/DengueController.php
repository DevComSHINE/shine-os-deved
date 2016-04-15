<?php

use Plugins\Dengue\DengueModel as Dengue;
use Modules\Helathcareservices\Entities\Healthcareservices;
use Shine\Repositories\Eloquent\HealthcareRepository as HealthcareRepository;
use Shine\Repositories\Contracts\HealthcareRepositoryInterface;
use Shine\Http\Controllers\Controller;
use Shine\Libraries\IdGenerator;
use Shine\User;
use Shine\Plugin;

class DengueController extends Controller
{
    protected $moduleName = 'Healthcareservices';
    protected $modulePath = 'healthcareservices';

    public function __construct(HealthcareRepository $healthcareRepository) {
        $this->healthcareRepository = $healthcareRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        //no index
    }

    public function save()
    {
        $dengue_id = Input::get('dservice_id');
        $hservice_id = Input::get('hservice_id');

        $dengue_record = Dengue::find($dengue_id);

        $dengue_record->fever_lasting = Input::get('Fever_Lasting');
        $dengue_record->fever_now = Input::get('Fever_Now');
        $dengue_record->platelets_critical = Input::get('Platelets_Critical');
        //$dengue_record->platelet_count = Input::get('Platelet_Count');

        if (Input::get('Platelet_Count') == NULL) {
            $dengue_record->platelet_count = NULL;
        }
        else {
            $dengue_record->platelet_count = Input::get('Platelet_Count');
        }

        $dengue_record->rapid_weak_pulse = Input::get('Rapid_Weak_Pulse');
        $dengue_record->pallor_cool_skin = Input::get('Pallor_Cool_Skin');
        $dengue_record->chills = Input::get('Chills');
        $dengue_record->rash = Input::get('Rash');
        $dengue_record->headache = Input::get('Headache');
        $dengue_record->eye_pain = Input::get('Eye_Pain');
        $dengue_record->body_pain = Input::get('Body_Pain');
        $dengue_record->joint_pain = Input::get('Joint_Pain');
        $dengue_record->anorexia = Input::get('Anorexia');
        $dengue_record->tourniquet_test = Input::get('Tourniquet_Test');
        $dengue_record->petechiae = Input::get('Petechiae');
        $dengue_record->purpura_ecchymosis = Input::get('Purpura_Ecchymosis');
        $dengue_record->vomit_with_blood = Input::get('Vomit_With_Blood');
        $dengue_record->blood_in_stool = Input::get('Blood_In_Stool');
        $dengue_record->nasal_bleeding = Input::get('Nasal_Bleeding');
        $dengue_record->vaginal_bleeding = Input::get('Vaginal_Bleeding');
        $dengue_record->positive_urinalysis = Input::get('Positive_Urinalysis');

        if (Input::get('Lowest_Hematocrit') == NULL) {
            $dengue_record->lowest_hematocrit = NULL;
        }
        else {
            $dengue_record->lowest_hematocrit = Input::get('Lowest_Hematocrit');
        }

        if (Input::get('Highest_Hematocrit') == NULL) {
            $dengue_record->highest_hematocrit = NULL;
        }
        else {
            $dengue_record->highest_hematocrit = Input::get('Highest_Hematocrit');
        }

        if (Input::get('Lowest_Serum_Albumin') == NULL) {
            $dengue_record->lowest_serum_albumin = NULL;
        }
        else {
            $dengue_record->lowest_serum_albumin = Input::get('Lowest_Serum_Albumin');
        }

        if (Input::get('Lowest_Serum_Protein') == NULL) {
            $dengue_record->lowest_serum_protein = NULL;
        }
        else {
            $dengue_record->lowest_serum_protein = Input::get('Lowest_Serum_Protein');
        }

        if (Input::get('Lowest_Pulse_Pressure') == NULL) {
            $dengue_record->lowest_pulse_pressure = NULL;
        }
        else {
            $dengue_record->lowest_pulse_pressure = Input::get('Lowest_Pulse_Pressure');
        }

        if (Input::get('Lowest_WBC_Count') == NULL) {
            $dengue_record->lowest_wbc_count = NULL;
        }
        else {
            $dengue_record->lowest_wbc_count = Input::get('Lowest_WBC_Count');
        }

        //$dengue_record->highest_hematocrit = Input::get('Highest_Hematocrit');
        //$dengue_record->lowest_serum_albumin = Input::get('Lowest_Serum_Albumin');
        //$dengue_record->lowest_serum_protein = Input::get('Lowest_Serum_Protein');
        // $dengue_record->lowest_bp_sbp = Input::get('Lowest_BP_SBP');
        // $dengue_record->lowest_bp_dbp = Input::get('Lowest_BP_DBP');
        //$dengue_record->lowest_pulse_pressure = Input::get('Lowest_Pulse_Pressure');
        //$dengue_record->lowest_wbc_count= Input::get('Lowest_WBC_Count');
        $dengue_record->persistent_vomiting = Input::get('Persistent_Vomiting');
        $dengue_record->abdominal_pain_tenderness = Input::get('Abdominal_Pain_Tenderness');
        $dengue_record->mucosal_bleeding = Input::get('Mucosal_Bleeding');
        $dengue_record->lethargy_restlessness = Input::get('Lethargy_Restlessness');
        $dengue_record->liver_enlargement = Input::get('Liver_Enlargement');
        $dengue_record->pleural_or_abdominal_effusion = Input::get('Pleural_Or_Abdominal_Effusion');
        $dengue_record->diarrhea = Input::get('Diarrhea');
        $dengue_record->cough = Input::get('Cough');
        $dengue_record->conjunctivitis = Input::get('Conjunctivitis');
        $dengue_record->nasal_congestion = Input::get('Nasal_Congestion');
        $dengue_record->sore_throat = Input::get('Sore_Throat');
        $dengue_record->jaundice = Input::get('Jaundice');
        $dengue_record->convulsion_or_coma = Input::get('Convulsion_Or_Coma');
        $dengue_record->nausea_and_vomiting = Input::get('Nausea_And_Vomiting');
        $dengue_record->arthritis = Input::get('Arthritis');
        $dengue_record->is_submitted = true;

        $dengue_record->save();

        $flash_message = 'Dengue Record Saved!';

        $patient_id = getPatientIDByHealthcareserviceID($hservice_id);

        header('Location: '.site_url().'healthcareservices/edit/'.$patient_id.'/'.$hservice_id);
        exit;

        //return Redirect::back()
         //            ->with('flash_message', $flash_message)
           //          ->with('flash_type', 'alert-success')
             //        ->with('flash_tab', 'dengue');
    }

    public function view()
    {

    }

    public static function update()
    {

    }
}
