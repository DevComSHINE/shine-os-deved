<?php namespace ShineOS\Core\Healthcareservices\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\Disposition; //model
use ShineOS\Core\Healthcareservices\Http\Requests\DispositionFormRequest;
use ShineOS\Core\Patients\Entities\Patients;
use Shine\Libraries\IdGenerator;

use View, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Request;

class DispositionController extends Controller {

    protected $moduleName = 'Disposition';
    protected $modulePath = 'disposition';
    protected $default_tbl = "disposition";

    public function __construct() {

        $date = new Datetime('now');
        $this->current_timestamp = strtotime($date->format('Y-m-d H:i:s'));
        $this->tb_unique_id = IdGenerator::generateId();

        $this->action = Input::has('action') ? Input::get('action')  : null;
        $this->txt_hservices_id = Input::has('hservices_id') ? Input::get('hservices_id')  : null;


        $this->params = array(
            "txt_id" => Input::has('disposition_id') ? Input::get('disposition_id')  : null,
            "txt_disposition" => (Input::has('disposition') AND !is_array(Input::get('disposition'))) ? Input::get('disposition')  : null,
            "txt_discharge_condition" => Input::has('discharge_condition') ? Input::get('discharge_condition')  : null,
            "txt_date" => Input::has('date') ? Input::get('date')  : null,
            "txt_time" => Input::has('time') ? Input::get('time')  : null,
            "txt_discharge_notes" => Input::has('discharge_notes') ? Input::get('discharge_notes')  : null,
        );
    }

    public function add(DispositionFormRequest $request) {
        $query = new Disposition;
        $query->disposition_id	 = $this->tb_unique_id;
        $query->healthcareservice_id = $this->txt_hservices_id;
        $query->disposition = $this->params['txt_disposition'];
        $convert_datetime = new Datetime($this->params['txt_date'] . ' ' . $this->params['txt_time']);
        $query->discharge_condition = $this->params['txt_discharge_condition'];
        $query->discharge_datetime = $convert_datetime->format('Y-m-d H:i:s');
        $query->discharge_notes = $this->params['txt_discharge_notes'];

        if ($query->save()) {
            return Redirect::back()
                 ->with('flash_message', 'Well done! You successfully Updated Disposition Information.')
                    ->with('flash_type', 'alert-success alert-dismissible')
                        ->with('flash_tab', 'disposition');
        }

        return Redirect::back()
                 ->with('flash_message', 'Please try again')
                    ->with('flash_type', 'alert-error alert-dismissible')
                        ->with('flash_tab', 'disposition');
    }

    public function edit(DispositionFormRequest $request) {
        $query = Disposition::find($this->params['txt_id']);
        $query->disposition_id	 = $this->tb_unique_id;
        $query->healthcareservice_id = $this->txt_hservices_id;
        $query->disposition = $this->params['txt_disposition'];
            $convert_datetime = new Datetime($this->params['txt_date'] . ' ' . $this->params['txt_time']);
        $query->discharge_condition = $this->params['txt_discharge_condition'];
        $query->discharge_datetime = $convert_datetime->format('Y-m-d H:i:s');
        $query->discharge_notes = $this->params['txt_discharge_notes'];

        if ($query->save()) {
            return Redirect::back()
                 ->with('flash_message', 'Well done! You successfully Updated Disposition Information.')
                    ->with('flash_type', 'alert-success alert-dismissible')
                        ->with('flash_tab', 'disposition');
        }

        return Redirect::back()
                 ->with('flash_message', 'Please try again')
                    ->with('flash_type', 'alert-error alert-dismissible')
                        ->with('flash_tab', 'disposition');
    }

    public function save($data) {
        if(!empty($data['disposition'])) {
            if($data AND !empty($data['disposition_id'])) {
                $query = Disposition::find($data['disposition_id']);
                $query->disposition_id = $data['disposition_id'];
            } else {
                $query = new Disposition;
                $query->disposition_id = $this->tb_unique_id;
            }
            $query->healthcareservice_id = $this->txt_hservices_id;
            $query->disposition = isset($data['disposition']) ? $data['disposition'] : null;

            if(isset($data['date']) AND isset($data['time'])) {
                $convert_datetime = new Datetime($data['date'] . ' ' . $data['time']);
                $query->discharge_datetime = $convert_datetime->format('Y-m-d H:i:s');
            }
            $query->discharge_condition = isset($data['discharge_condition']) ? $data['discharge_condition'] : null;
            $query->discharge_notes = isset($data['discharge_notes']) ? $data['discharge_notes'] : null;

            if ($query->save()) {
                return "saved";
            }
        }
        return "opps";
    }
}
