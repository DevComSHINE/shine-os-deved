<?php namespace ShineOS\Core\Healthcareservices\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\VitalsPhysical as VitalsPhysical;
use Shine\Libraries\IdGenerator;
use ShineOS\Core\Healthcareservices\Http\Requests\VitalsPhysicalFormRequest;
use ShineOS\Core\LOV\Http\Controllers\LOVController as LOVController;

use View, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Request;

class VitalsController extends Controller {

    protected $facility_name = "samplefacility name";
    protected $tb_unique_id = "";
    protected $diag_unique_id = "";
    protected $current_timestamp;
    protected $default_tbl = "vital_physical";
    protected $txt_hservices_id;
    private $txt_action;
    private $params;

    public function __construct() {
        /** User Session or Authenticaion  */
        $this->middleware('auth');

        $date = new Datetime('now');
        $this->current_timestamp = strtotime($date->format('Y-m-d H:i:s'));

        $this->tb_unique_id =  IdGenerator::generateId();

        $this->action = Input::has('action') ? Input::get('action')  : false;
        $this->txt_hservices_id = Input::has('healthcareservice_id') ? Input::get('healthcareservice_id')  : false;

        $this->params = array(
            "txt_id" => Input::has('vitalphysical_id') ? Input::get('vitalphysical_id')  : false,
            "txt_temperature" => Input::has('temperature') ? Input::get('temperature')  : false,
            "txt_hr" => Input::has('heart_rate') ? Input::get('heart_rate')  : false,
            "txt_pulse" => Input::has('pulse_rate') ? Input::get('pulse_rate')  : false,
            "txt_respiratory" => Input::has('respiratory_rate') ? Input::get('respiratory_rate')  : false,
            "txt_systolic" => Input::has('bloodpressure_systolic') ? Input::get('bloodpressure_systolic')  : false,
            "txt_diastolic" => Input::has('bloodpressure_diastolic') ? Input::get('bloodpressure_diastolic')  : false,
            "txt_height" => Input::has('height') ? Input::get('height')  : false,
            "txt_weight" => Input::has('weight') ? Input::get('weight')  : false,
            "txt_bmi" => Input::has('bmiResult') ? Input::get('bmiResult')  : false,
            "txt_waist" => Input::has('waist') ? Input::get('waist')  : false,
            "txt_pregnant" => Input::has('Pregnant') ? Input::get('Pregnant')  : false,
            "txt_uterus" => Input::has('WithIntactUterus') ? Input::get('WithIntactUterus')  : false,
            "txt_weightloss" => Input::has('WeightLoss') ? Input::get('WeightLoss')  : false,
            "Pain_Scale" => Input::has('Pain_Scale') ? Input::get('Pain_Scale')  : NULL,
            "Head_abnormal" => Input::has('Head_abnormal') ? Input::get('Head_abnormal')  : NULL,
            "Eyes_abnormal" => Input::has('Eyes_abnormal') ? Input::get('Eyes_abnormal')  : NULL,
            "Ent_abnormal" => Input::has('Ent_abnormal') ? Input::get('Ent_abnormal')  : NULL,
            "Cardiovascular_abnormal" => Input::has('Cardiovascular_abnormal') ? Input::get('Cardiovascular_abnormal')  : NULL,
            "Breasts_abnormal" => Input::has('Breasts_abnormal') ? Input::get('Breasts_abnormal')  : NULL,
            "Chest_abnormal" => Input::has('Chest_abnormal') ? Input::get('Chest_abnormal')  : NULL,
            "Back_abnormal" => Input::has('Back_abnormal') ? Input::get('Back_abnormal')  : NULL,
            "Abdomen_abnormal" => Input::has('Abdomen_abnormal') ? Input::get('Abdomen_abnormal')  : NULL,
            "Pelvis_abnormal" => Input::has('Pelvis_abnormal') ? Input::get('Pelvis_abnormal')  : NULL,
            "Rectal_abnormal" => Input::has('Rectal_abnormal') ? Input::get('Rectal_abnormal')  : NULL,
            "Upper_Extremities_abnormal" => Input::has('Upper_Extremities_abnormal') ? Input::get('Upper_Extremities_abnormal')  : NULL,
            "Lower_Extremities_abnormal" => Input::has('Lower_Extremities_abnormal') ? Input::get('Lower_Extremities_abnormal')  : NULL,
            "Integumentary_abnormal" => Input::has('Integumentary_abnormal') ? Input::get('Integumentary_abnormal')  : NULL,
            "Skin_abnormal" => Input::has('Skin_abnormal') ? Input::get('Skin_abnormal')  : NULL,
            "Nails_abnormal" => Input::has('Nails_abnormal') ? Input::get('Nails_abnormal')  : NULL,
            "Hair_abnormal" => Input::has('Hair_abnormal') ? Input::get('Hair_abnormal')  : NULL,
            "physical_examination" => Input::has('physical_examination') ? Input::get('physical_examination')  : NULL
        );
    }

    public function add(VitalsPhysicalFormRequest $request) {

            $vital = new VitalsPhysical;
            $vital->vitalphysical_id = $this->tb_unique_id;
            $vital->healthcareservice_id = $this->txt_hservices_id;
            $vital->bloodpressure_systolic = $this->params['txt_systolic'];
            $vital->bloodpressure_diastolic = $this->params['txt_diastolic'];
            $vital->heart_rate = $this->params['txt_hr'];
            $vital->pulse_rate = $this->params['txt_pulse'];
            $vital->respiratory_rate = $this->params['txt_respiratory'];
            $vital->temperature = $this->params['txt_temperature'];
            $vital->height = $this->params['txt_height'];
            $vital->weight = $this->params['txt_weight'];
            $vital->BMI_category = VitalsPhysical::computeBMICategory($this->params['txt_bmi']);
            $vital->waist = $this->params['txt_waist'];
            $vital->pregnant = $this->params['txt_pregnant'];
            $vital->with_intact_uterus = $this->params['txt_uterus'];
            $vital->weight_loss = $this->params['txt_weightloss'];
            $vital->Pain_Scale = $this->params['Pain_Scale'];
            $vital->Head_abnormal = $this->params['Head_abnormal'];
            $vital->Eyes_abnormal = $this->params['Eyes_abnormal'];
            $vital->Ent_abnormal = $this->params['Ent_abnormal'];
            $vital->Cardiovascular_abnormal = $this->params['Cardiovascular_abnormal'];
            $vital->Breasts_abnormal = $this->params['Breasts_abnormal'];
            $vital->Chest_abnormal = $this->params['Chest_abnormal'];
            $vital->Back_abnormal = $this->params['Back_abnormal'];
            $vital->Abdomen_abnormal = $this->params['Abdomen_abnormal'];
            $vital->Pelvis_abnormal = $this->params['Pelvis_abnormal'];
            $vital->Rectal_abnormal = $this->params['Rectal_abnormal'];
            $vital->Upper_Extremities_abnormal = $this->params['Upper_Extremities_abnormal'];
            $vital->Lower_Extremities_abnormal = $this->params['Lower_Extremities_abnormal'];
            $vital->Integumentary_abnormal = $this->params['Integumentary_abnormal'];
            $vital->Skin_abnormal = $this->params['Skin_abnormal'];
            $vital->Nails_abnormal = $this->params['Nails_abnormal'];
            $vital->Hair_abnormal = $this->params['Hair_abnormal'];
            $vital->physical_examination = $this->params['physical_examination'];

            /**
             * Blood pressure assessment
             * @var LOVController
             */
            $LOVController = new LOVController();
            if(!empty($this->params['txt_systolic']) AND !empty($this->params['txt_systolic'])) {
                $vital->bloodpressure_assessment = $LOVController->bloodpressure_assessment($this->params['txt_systolic'], $this->params['txt_diastolic']);
            }

            $vital->save();

            return Redirect::back()
                 ->with('flash_message', 'Well done! You successfully Added Vitals Information.')
                 ->with('flash_type', 'alert-success alert-dismissible')
                ->with('flash_tab', 'vitals');
    }

    public function edit(VitalsPhysicalFormRequest $request) {
        $vital = VitalsPhysical::find($this->params['txt_id']);
        $vital->vitalphysical_id = $this->tb_unique_id;
        $vital->healthcareservice_id = $this->txt_hservices_id;
        $vital->bloodpressure_systolic = $this->params['txt_systolic'];
        $vital->bloodpressure_diastolic = $this->params['txt_diastolic'];
        $vital->heart_rate = $this->params['txt_hr'];
        $vital->pulse_rate = $this->params['txt_pulse'];
        $vital->respiratory_rate = $this->params['txt_respiratory'];
        $vital->temperature = $this->params['txt_temperature'];
        $vital->height = $this->params['txt_height'];
        $vital->weight = $this->params['txt_weight'];
        $vital->BMI_category = VitalsPhysical::computeBMICategory($this->params['txt_bmi']);
        $vital->waist = $this->params['txt_waist'];
        $vital->pregnant = $this->params['txt_pregnant'];
        $vital->with_intact_uterus = $this->params['txt_uterus'];
        $vital->weight_loss = $this->params['txt_weightloss'];
        $vital->Pain_Scale = $this->params['Pain_Scale'];
        $vital->Head_abnormal = $this->params['Head_abnormal'];
        $vital->Eyes_abnormal = $this->params['Eyes_abnormal'];
        $vital->Ent_abnormal = $this->params['Ent_abnormal'];
        $vital->Cardiovascular_abnormal = $this->params['Cardiovascular_abnormal'];
        $vital->Breasts_abnormal = $this->params['Breasts_abnormal'];
        $vital->Chest_abnormal = $this->params['Chest_abnormal'];
        $vital->Back_abnormal = $this->params['Back_abnormal'];
        $vital->Abdomen_abnormal = $this->params['Abdomen_abnormal'];
        $vital->Pelvis_abnormal = $this->params['Pelvis_abnormal'];
        $vital->Rectal_abnormal = $this->params['Rectal_abnormal'];
        $vital->Upper_Extremities_abnormal = $this->params['Upper_Extremities_abnormal'];
        $vital->Lower_Extremities_abnormal = $this->params['Lower_Extremities_abnormal'];
        $vital->Integumentary_abnormal = $this->params['Integumentary_abnormal'];
        $vital->Skin_abnormal = $this->params['Skin_abnormal'];
        $vital->Nails_abnormal = $this->params['Nails_abnormal'];
        $vital->Hair_abnormal = $this->params['Hair_abnormal'];
        $vital->physical_examination = $this->params['physical_examination'];

            /**
             * Blood pressure assessment
             * @var LOVController
             */
            $LOVController = new LOVController();
            if(!empty($this->params['txt_systolic']) AND !empty($this->params['txt_systolic'])) {
                $vital->bloodpressure_assessment = $LOVController->bloodpressure_assessment($this->params['txt_systolic'], $this->params['txt_diastolic']);
            }

        $vital->save();

        return Redirect::back()
             ->with('flash_message', 'Well done! You successfully Updated Vitals Information.')
                ->with('flash_type', 'alert-success alert-dismissible')
                    ->with('flash_tab', 'vitals');
    }

}
