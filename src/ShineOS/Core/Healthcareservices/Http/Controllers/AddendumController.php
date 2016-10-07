<?php namespace ShineOS\Core\Healthcareservices\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\Addendum;
use Shine\Libraries\IdGenerator;
use View, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Request;

class AddendumController extends Controller {
    private $params;
    protected $tb_unique_id = "";
    protected $txt_hservices_id;

    public function __construct() {
        $this->tb_unique_id = IdGenerator::generateId();
        $this->txt_hservices_id = Input::has('healthcareservice_id') ? Input::get('healthcareservice_id')  : '';
        $this->session_user_id = Input::has('session_user_id') ? Input::get('session_user_id')  : '';
        $this->addendum_notes = Input::has('addendum_notes') ? Input::get('addendum_notes')  : '';
    }

    public function add() {
        $query = new Addendum;
        $query->addendum_id = $this->tb_unique_id;
        $query->healthcareservice_id = $this->txt_hservices_id;
        $query->user_id = $this->session_user_id;
        $query->addendum_notes = $this->addendum_notes;
        $qsave = $query->save();

        if ($qsave) {
            return Redirect::back()
                 ->with('flash_message', 'Well done!')
                    ->with('flash_type', 'alert-success alert-dismissible')
                        ->with('flash_tab', 'addendum');
        } else {
            return Redirect::back()
                 ->with('flash_message', 'Please try again')
                    ->with('flash_type', 'alert-error alert-dismissible')
                        ->with('flash_tab', 'addendum');
        }
    }
}
