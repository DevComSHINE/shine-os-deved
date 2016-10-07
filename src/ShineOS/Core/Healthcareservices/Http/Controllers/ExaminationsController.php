<?php namespace ShineOS\Core\Healthcareservices\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices; //model
use ShineOS\Core\Healthcareservices\Entities\Examination; //model

use Shine\Http\Requests\Healthcareservices\TBFormRequest;
use Shine\Libraries\UserHelper;
use ShineOS\Core\Patients\Models\Patients;
use Shine\Libraries\IdGenerator;
use View,
    Response,
    Validator,
    Input,
    Mail,
    Session,
    Redirect,
    Hash,
    Auth,
    DB,
    Datetime,
    Request;

class ExaminationsController extends Controller {

    protected $facility_name = "samplefacility name";
    protected $tb_unique_id = "";
    protected $current_timestamp;

    protected $default_tbl = "examination";
    protected $txt_hservices_id;

    private $txt_action;
    private $params;

    public function __construct() {
        /** User Session or Authenticaion  */
        $this->middleware('auth');

        $date = new Datetime('now');
        $this->current_timestamp = strtotime($date->format('Y-m-d H:i:s'));

        $this->user = UserHelper::getUserInfo();
        $this->roles = Session::get('roles');

        $this->tb_unique_id =  IdGenerator::generateId();

        $this->action = Input::has('action') ? Input::get('action')  : false;
        $this->txt_hservices_id = Input::has('healthcareservice_id') ? Input::get('healthcareservice_id')  : false;

        $this->params = array(
            "txt_id" => Input::has('examination_id') ? Input::get('examination_id')  : false,
            "txt_anatomy" => Input::has('anatomy') ? Input::get('anatomy')  : false,
        );


    }

    public function add() {
        $hc =  Healthcareservices::where('healthcareservice_id', $this->txt_hservices_id);
        if($hc AND strtolower($this->roles['role_name']) == 'physician' OR strtolower($this->roles['role_name']) == 'doctor') { //if this is a doctor set the seen_by (attending physician)
            $hc->seen_by = $this->user->user_id;
            $hc->save();
        }

        $data = Input::get();
        $query = new Examination;
        $query->examination_id = IdGenerator::generateId();
        $query->healthcareservice_id = $this->txt_hservices_id;
        if($data['anatomy']) {
            foreach ($data['anatomy'] as $key => $val) {
                $query->$key = $val;
            }
            $querysave = $query->save();
        } else {
            $querysave = false;
        }

        if ($querysave) {
            return Redirect::back()
                 ->with('flash_message', 'Well done! You successfully Added Examination Information.')
                    ->with('flash_type', 'alert-success alert-dismissible')
                        ->with('flash_tab', 'examinations');
        }

        return Redirect::back()
                 ->with('flash_message', 'Please try again')
                    ->with('flash_type', 'alert-error alert-dismissible')
                        ->with('flash_tab', 'examinations');
    }

    public function edit() {

        if(strtolower($this->roles['role_name']) == 'physician' OR strtolower($this->roles['role_name']) == 'doctor') { //if this is a doctor set the seen_by (attending physician)
            Healthcareservices::where('healthcareservice_id', $this->txt_hservices_id)
                ->update(['seen_by' => $this->user->user_id]);
        }

        $data = Input::get();
        $query = Examination::find($data['examination_id']);
        if($data['anatomy']) {
            foreach ($data['anatomy'] as $key => $val) {
                $query->$key = $val;
            }
            $querysave = $query->save();
        } else {
            $querysave = false;
        }

        if ($querysave) {
            return Redirect::back()
                 ->with('flash_message', 'Well done! You successfully Updated Examination Information.')
                    ->with('flash_type', 'alert-success alert-dismissible')
                        ->with('flash_tab', 'examinations');
        }

        return Redirect::back()
                 ->with('flash_message', 'Please try again')
                    ->with('flash_type', 'alert-error alert-dismissible')
                        ->with('flash_tab', 'examinations');
    }

    public function save($data)
    {
        if(isset($data['examination_id']) AND $data['examination_id'] != NULL) {
            $query = Examination::find($data['examination_id']);
            $query->examination_id	 = $data['examination_id'];
        } else {
            $query = new Examination;
            $query->examination_id	 = IdGenerator::generateId();
        }
        $query->healthcareservice_id = $hcid = Input::has('hservices_id') ? Input::get('hservices_id')  : false;

        //if this is an existing health record
        if($hcid){
            //if this is a doctor set the seen_by (attending physician)
            $hc =  Healthcareservices::where('healthcareservice_id', $hcid);
            if($hc AND strtolower($this->roles['role_name']) == 'physician' OR strtolower($this->roles['role_name']) == 'doctor') {
                $hc->seen_by = $this->user->user_id;
                $hc->update(['seen_by'=>$this->user->user_id]);
            }
        }

        if($data['anatomy']) {
            foreach ($data['anatomy'] as $key => $val) {
                //let us store keys with values only
                $query->$key = $val;
            }
            $querysave = $query->save();
        }
        return "ok";
    }

}
