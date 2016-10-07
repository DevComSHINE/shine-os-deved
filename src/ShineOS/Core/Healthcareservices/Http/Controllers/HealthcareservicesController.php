<?php
namespace ShineOS\Core\Healthcareservices\Http\Controllers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Controller;

use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\VitalsPhysical;
use ShineOS\Core\Healthcareservices\Entities\GeneralConsultation;
use ShineOS\Core\Healthcareservices\Entities\Examination;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Healthcareservices\Entities\DiagnosisICD10;
use ShineOS\Core\Healthcareservices\Entities\Disposition;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrder;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrderLabExam;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrderPrescription;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrderProcedure;
use ShineOS\Core\Healthcareservices\Entities\Addendum;

use ShineOS\Core\LOV\Entities\LovICD10;
use ShineOS\Core\LOV\Entities\LovLaboratories;
use ShineOS\Core\LOV\Entities\LovDiagnosis;
use ShineOS\Core\LOV\Entities\LovMedicalCategory;
use ShineOS\Core\LOV\Entities\LovAllergyReaction;
use ShineOS\Core\LOV\Entities\LovMedicalProcedures;
use ShineOS\Core\LOV\Entities\LovDrugs;

use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Patients\Entities\PatientAlert;

use ShineOS\Core\Reminders\Entities\Reminders;
use ShineOS\Core\Reminders\Entities\ReminderMessage;

use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use ShineOS\Core\Facilities\Entities\FacilityUser;

use Shine\Repositories\Eloquent\FacilityRepository as FacilityRepository;
use Shine\Repositories\Eloquent\UserRepository as UserRepository;
use Shine\Repositories\Eloquent\HealthcareRepository as HealthcareRepository;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\Utils;
use Shine\Libraries\UserHelper;

use Module;

use View, Form, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Schema, Request, Event;

class HealthcareservicesController extends Controller {

    protected $moduleName = 'healthcareservices';
    protected $modulePath = 'healthcareservices';
    protected $default_tabs = "addservice";
    protected $data = [];
    protected $facilityuser_id;

    //standard tabs definition
    protected $tabs = [
        'addservice' => 'Basic Information',
        'disposition' => 'Disposition',
        'examinations' => 'Examinations',
        'impanddiag' => 'Impressions & Diagnosis',
        'medicalorders' => 'Medical Orders',
        'complaints' => 'Complaints',
        'vitals' => 'Vitals & Physical',
    ];

    //standard roles definition
    protected $tabroles = [
        'addservice' => 5,
        'disposition' => 2,
        'examinations' => 3,
        'impanddiag' => 2,
        'medicalorders' => 2,
        'complaints' => 5,
        'vitals' => 5
    ];

    protected $sections = [
        'disposition' => 'Disposition',
        'examinations' => 'Examinations',
        'impanddiag' => 'ImpressionandDiagnosis',
        'medicalorders' => 'MedicalOrder',
        'complaints' => 'Complaints',
        'vitals' => 'Vitals',
    ];
    protected $tabs_child = [
        'GeneralConsultation' => ['addservice', 'complaints', 'vitals', 'examinations', 'impanddiag', 'medicalorders', 'disposition'],
        'InternalMedicine' => ['addservice', 'complaints', 'vitals', 'examinations', 'impanddiag', 'medicalorders', 'disposition']
    ];

    private $healthcareRepository;

    public function __construct(FacilityRepository $FacilityRepository, UserRepository $UserRepository, HealthcareRepository $healthcareRepository)
    {
        /** User Session or Authenticaion  */
        $this->middleware('auth');

        $this->FacilityRepository = $FacilityRepository;
        $this->UserRepository = $UserRepository;
        $this->HealthcareRepository = $healthcareRepository;

        $this->healthcareserviceid = Input::has('hservices_id') ?  Input::get('hservices_id') : IdGenerator::generateId();
        $facility = FacilityHelper::facilityInfo();
        $this->user = UserHelper::getUserInfo();

        $this->facilityuser_id = FacilityUser::where('facility_id',$facility->facility_id)->where('user_id',$this->user->user_id)->pluck('facilityuser_id');

        $this->healthcareservices_type = Input::has('healthcare_services') ?  Input::get('healthcare_services') : false;
        $this->patient_id = Input::has('patient_id') ?  Input::get('patient_id') : false;

        if(Input::has('e-date')){
            $dt = new Datetime(Input::get('e-date') . ' ' . Input::get('e-time'));
            $this->encounter_date = $dt->format('Y-m-d H:i:s');
        } else {
            $this->encounter_date = date('Y-m-d H:i:s');
        }

        //if this is a followup, then add parent ID
        $this->follow_healthcareserviceid = Input::has('follow_healthcareserviceid') ?  Input::get('follow_healthcareserviceid') : false;

        $this->consultationtype_id = Input::has('consultationtype_id') ?  Input::get('consultationtype_id') : 'CONSU';
        $this->encounter_type = Input::has('encounter_type') ?  Input::get('encounter_type') : 'O';
        $modules =  Utils::getModules();

        // variables to share to all view
        View::share('modules', $modules);
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);

    }

    public function index($action = null, $patient_id = null, $hservice_id = null)
    {

        switch ($action) {
            case "add":
                return $this->add($patient_id, $hservice_id);
            break;

            case "edit":
                return $this->edit($patient_id, $hservice_id);
            break;

            case "delete":
                return $this->delete($patient_id, $hservice_id);
            break;

            case "undelete":
                return $this->undelete($patient_id, $hservice_id);
            break;

            case "qview":
                return $this->qview($patient_id, $hservice_id);
            break;

            case "getVisits":
                return $this->getVisitList($patient_id, $hservice_id);
            break;

            default:
                return Redirect::back();
            break;
        }
    }

    public function add($patient_id = NULL, $hservice_id = null)
    {
        $data['pageTitle'] = "New Healthcare Record";
        $data['tabSwitch'] = false;
        //since this is an edit function
        //we will disable editing of healthcare
        $data['disabled'] = '';

        $patients = Patients::find($patient_id);
        $prevhealthcareData = Healthcareservices::find($hservice_id);

        $facility = Session::get('facility_details');
        $roles = Session::get('roles');

        if($prevhealthcareData) {
            $data['prevhealthcareData'] =  $prevhealthcareData;
        } else {
            $data['prevhealthcareData'] =  false;
        }

        // for button value
        if ($hservice_id != null){
            $data['healthcareType'] = "FOLLO";
            $data['parent_hcs_id'] = $hservice_id;
            $data['follow_healthcareserviceid'] = $hservice_id;
        } else {
            $data['healthcareType'] = "CONSU";
            $data['parent_hcs_id'] = NULL;
            $data['follow_healthcareserviceid'] = NULL;
        }

        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array(); $pluginlist = array(); $subpluglist = array();
        $pluginlist[''] = "-- Choose Health Service --";

        //Add the basic General Consultation on HCS listing
        $pluginlist['Consultation']['GeneralConsultation'] = "General/Family Medicine";
        $pluginlist['Consultation']['InternalMedicine'] = "Internal Medicine";
        foreach($plugins as $k=>$plugin) {
            $plugin_type = $plugin_gender = $plugin_age = $plugin_module = '';
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'consultation' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( isset($plugin_age) OR ($plugin_age=='') OR (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $plugs[$k]['plugin_location'] = $plugin_location;
                                        $plugs[$k]['folder'] = $plugin;
                                        $plugs[$k]['plugin'] = $plugin_id;
                                        $pluginlist['Consultation'][$plugin_id] = $plugin_title;
                                        $this->tabs_child = array_merge($this->tabs_child, $plugin_tabs_child);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        //Add Surgery group
        foreach($plugins as $k=>$plugin) {
            $plugin_type = $plugin_gender = $plugin_age = $plugin_module = '';
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'surgery' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( ($plugin_age=='') OR (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $plugs[$k]['plugin_location'] = $plugin_location;
                                        $plugs[$k]['folder'] = $plugin;
                                        $plugs[$k]['plugin'] = $plugin_id;
                                        $pluginlist['Surgery'][$plugin_id] = $plugin_title;
                                        $this->tabs_child = array_merge($this->tabs_child, $plugin_tabs_child);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        //Add DOH Programs
        foreach($plugins as $k=>$plugin) {
            $plugin_type = $plugin_gender = $plugin_age = $plugin_module = '';
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'program' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( ($plugin_age=='') OR (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $plugs[$k]['plugin_location'] = $plugin_location;
                                        $plugs[$k]['folder'] = $plugin;
                                        $plugs[$k]['plugin'] = $plugin_id;
                                        $pluginlist['DOH Programs'][$plugin_id] = $plugin_title;
                                        $this->tabs_child = array_merge($this->tabs_child, $plugin_tabs_child);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        //Add Special Programs
        foreach($plugins as $k=>$plugin) {
            $plugin_type = $plugin_gender = $plugin_age = $plugin_module = '';
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'subform' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( ($plugin_age=='') OR (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $splugs[$k]['plugin_location'] = $plugin_location;
                                        $splugs[$k]['folder'] = $plugin;
                                        $splugs[$k]['plugin'] = $plugin_id;
                                        $pluginlist['Special Programs'][$plugin_id] = $plugin_title;
                                        $this->subtabs_child = array_merge($this->subtabs_child, $plugin_tabs_child);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $data['plugs'] = $plugs;
        $data['default_tabs'] = $this->default_tabs;
        $data['tabs'] = $this->tabs;
        $data['healthcareservices'] = $pluginlist;
        $data['subform'] = $subpluglist;
        $data['medicalCategory'] = LovMedicalCategory::orderBy('medicalcategory_name', 'ASC')->get();

        if (count($patients) > 0) {
            $data['patient'] = $patients;

            if($prevhealthcareData) { //this is a followup
                $data['formTitle'] = "Follow-up Consultation for: ";
                $data['healthcareserviceid'] = false;
                $prevhealthcareData->consultationtype_id = 'FOLLO';
                $data['recent_healthcare'] = Healthcareservices::where('healthcareservice_id', $hservice_id)->first();
                $data['gender'] = $patients->gender;
                $data['healthcaretype'] = "FOLLO";
                //temporary
                if($prevhealthcareData->healthcareservicetype_id == 'GeneralConsultation' OR $prevhealthcareData->healthcareservicetype_id == 'InternalMedicine') {
                    $data['generalConsultation'] = GeneralConsultation::where('healthcareservice_id', $hservice_id)->first();
                } else {
                    $data['nocategory'] = 1;
                }

            } else {
                $data['formTitle'] = "New Consultation";
                $data['healthcareserviceid'] = false;

            }
            return view('healthcareservices::add')->with($data);
        }
    }

    public function insert()
    {

        $patient_facity_user = FacilityPatientUser::where('patient_id', Input::get('patient_id'))->get();

        if (!empty($patient_facity_user)) { //patient should exist in facilityPatientUser

            $insertQuery = new Healthcareservices;
            $insertQuery->healthcareservice_id = $this->healthcareserviceid;
            $insertQuery->facilitypatientuser_id = $patient_facity_user[0]->facilitypatientuser_id;
            $insertQuery->healthcareservicetype_id	= $this->healthcareservices_type;
            if($this->user->mdUsers) { //if this is a doctor set the seen_by (attending physician)
                $insertQuery->seen_by = $this->facilityuser_id;
            } else {
                $insertQuery->seen_by = NULL;
            }
            $insertQuery->encounter_datetime = $this->encounter_date;
            $insertQuery->consultation_type = $this->consultationtype_id;
            $insertQuery->encounter_type = $this->encounter_type;

            if($this->healthcareservices_type == 'GeneralConsultation' OR $this->healthcareservices_type == 'InternalMedicine') {
                $query = new GeneralConsultation;
                $query->generalconsultation_id = IdGenerator::generateId();
                $query->healthcareservice_id = $this->healthcareserviceid;
            } else {
                //get some values from the plugin config file
                include(plugins_path().$this->healthcareservices_type.'/config.php');
                //load the plugin Model file
                $qModel = 'Plugins\\'.$plugin_folder.'\\'.$plugin_id."Model";
                $query = new $qModel;

                $query->$plugin_primaryKey = IdGenerator::generateId();
                $query->healthcareservice_id = $this->healthcareserviceid;
            }

            if($this->follow_healthcareserviceid) {
                $insertQuery->parent_service_id = $this->follow_healthcareserviceid;

                //check if this follow-up came from an appointment
                $appointment = Reminders::where('healthcareservice_id', $this->follow_healthcareserviceid)->with('ReminderMessage')->first();
                if($appointment) {
                    $reminderMessage = ReminderMessage::where('remindermessage_id', $appointment->ReminderMessage->remindermessage_id)->first();
                    $reminderMessage->sent_status = "MET";
                    $reminderMessage->save();
                }
            }

            //save general healthcareservice
            $insertQuery->save();
            //save healthcareservice type
            $query->save();

            return Redirect::route('healthcare.edit', ['action' => 'edit', 'patiend_id' => $this->patient_id, 'hservice_id' =>  $this->healthcareserviceid]);
        } else {
            echo "does not exists";
        }
    }

    public function update(Container $container)
    {
        $user = Session::get('user_details');
        $role = getRoleInfoByFacilityUserID($user->facilityUser[0]->facilityuser_id);
        $patient_facity_user = FacilityPatientUser::where('patient_id', Input::get('patient_id'))->get();

        if (!empty($patient_facity_user)) { //patient should exist in facilityPatientUser

            if($this->healthcareserviceid){
                $insertQuery = Healthcareservices::find($this->healthcareserviceid);
            } else {
                $insertQuery = new Healthcareservices;
            }

            $insertQuery->healthcareservice_id = $this->healthcareserviceid;
            $insertQuery->facilitypatientuser_id = $patient_facity_user[0]->facilitypatientuser_id;
            $insertQuery->healthcareservicetype_id	= $this->healthcareservices_type;
            if($this->user->mdUsers) { //if this is a doctor set the seen_by (attending physician)
                $insertQuery->seen_by = $this->facilityuser_id;
            } else {
                $insertQuery->seen_by = NULL;
            }
            $insertQuery->encounter_datetime = $this->encounter_date;
            $insertQuery->consultation_type = $this->consultationtype_id;
            $insertQuery->encounter_type = $this->encounter_type;

            if($this->follow_healthcareserviceid) {
                $insertQuery->parent_service_id = $this->follow_healthcareserviceid;
            }
            //save general healthcareservice
            $insertQuery->save();

            $mysections = $this->sections;
            if(Input::has('thistabs')) {
                $mysections = json_decode(Input::get('thistabs'));
            }

            //let us save the rest of the sections
            foreach($mysections as $sect => $section) {
                // dd($mysections);
                if($sect != 'addservice'){
                    if( (isset($this->tabroles[$sect]) AND $role->role_id <= $this->tabroles[$sect]) OR !isset($this->tabroles[$sect]) ){

                        if(array_key_exists($sect, $this->sections)) {
                            $data = Input::has($sect) ?  Input::get($sect) : false;
                            $s = $this->sections[$sect];
                            $controller = app()->make("ShineOS\Core\Healthcareservices\Http\Controllers"."\\".$s.'Controller');
                            app()->call(
                                [$controller, 'save'],
                                ['data' => $data]
                            );
                        } else {

                            $data = Input::has(str_replace('_plugin','', $sect)) ?  Input::get(str_replace('_plugin','', $sect)) : false;

                            // dd($data);
                            $s = str_replace(" ", "", $mysections->$sect);
                            include_once(plugins_path().$s.DS.$s.'Controller.php');

                            $plugController = $container->make($s.'Controller');
                            $container->call(
                                [$plugController, 'save'],
                                ['data' => $data]
                            );
                        }
                    }
                }
            }

            return Redirect::route('healthcare.edit', ['action' => 'edit', 'patiend_id' => $this->patient_id, 'hservice_id' =>  $this->healthcareserviceid])
                ->with('flash_message', 'Well done! You successfully updated the Healthcare Service.')
                    ->with('flash_type', 'alert-success alert-dismissible')
                        ->with('flash_tab', 'examinations');
        } else {
            echo "does not exists";
        }
    }

    private function retrieve($patient_id = null,  $hservice_id = null)
    {
        $facility = Session::get('facility_details');
        $user = Session::get('user_details');
        $roles = Session::get('roles');

        //since this is an edit function
        //we will disable editing of healthcare if it is with disposition
        $data['disabled'] = '';
        $data['formTitle'] = "Consultation";
        $data['follow_healthcareserviceid'] = false;

        $data['session_user_id'] = $this->user->user_id;
        $patients = Patients::find($patient_id);

        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array(); $pluginlist = array();
        $pluginlist[NULL] = "-- Choose a Health Service --";
        //Add the basic General Consultation on HCS listing
        $pluginlist['GeneralConsultation'] = "General/Family Medicine";
        $pluginlist['InternalMedicine'] = "Internal Medicine";
        foreach($plugins as $k=>$plugin) {
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'service' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $plugs[$k]['plugin_location'] = $plugin_location;
                                        $plugs[$k]['folder'] = $plugin;
                                        $plugs[$k]['plugin'] = $plugin_id;
                                        $pluginlist[$plugin_id] = $plugin_title;
                                        $this->tabs_child = array_merge($this->tabs_child, $plugin_tabs_child);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $data['plugs'] = $plugs;

        try {

            $healthcareData = findHealthRecordByServiceID($hservice_id);

            //get service data base on service ID
            if ($healthcareData!=NULL && $patients!=NULL) {
                $data['healthcareData'] =  $healthcareData;
                $data['patient'] = $patients;
                $allFormsByHealthcareserviceid = json_decode($this->HealthcareRepository->allFormsByHealthcareserviceid($hservice_id));
                foreach ($allFormsByHealthcareserviceid as $allFormsKey => $allFormsValue) {
                    $data['vitals_record'] = ((!empty($allFormsValue->vitals_physical)) ? $allFormsValue->vitals_physical: NULL);
                    $data['complaints_record'] = ((!empty($allFormsValue->general_consultation)) ? $allFormsValue->general_consultation[0]: NULL);
                    $data['examinations_record'] = ((!empty($allFormsValue->examination)) ? $allFormsValue->examination[0]: NULL);
                    $data['disposition_record'] = ((!empty($allFormsValue->disposition)) ? $allFormsValue->disposition: NULL);
                    $data['addendum_record'] = ((!empty($allFormsValue->addendum)) ? $allFormsValue->addendum: NULL);
                }

                if ($healthcareData!=NULL && $patients!=NULL) {

                    $data['healthcareData'] =  $healthcareData;
                    $data['patient'] = $patients;
                    $allFormsByHealthcareserviceid = json_decode($this->HealthcareRepository->allFormsByHealthcareserviceid($hservice_id));
                    // dd($allFormsByHealthcareserviceid);
                    foreach ($allFormsByHealthcareserviceid as $allFormsKey => $allFormsValue) {
                        $data['vitals_record'] = ((!empty($allFormsValue->vitals_physical)) ? $allFormsValue->vitals_physical: NULL);
                        $data['complaints_record'] = ((!empty($allFormsValue->general_consultation)) ? $allFormsValue->general_consultation[0]: NULL);
                        $data['examinations_record'] = ((!empty($allFormsValue->examination)) ? $allFormsValue->examination[0]: NULL);
                        $data['disposition_record'] = ((!empty($allFormsValue->disposition)) ? $allFormsValue->disposition: NULL);
                        $data['addendum_record'] = ((!empty($allFormsValue->addendum)) ? $allFormsValue->addendum: NULL);
                    }

                    $data['diagnosis_record'] = json_decode($this->HealthcareRepository->findDiagnosisByHealthcareserviceid($hservice_id));

                    $data['medicalorder_record'] = json_decode($this->HealthcareRepository->findMedicalOrdersByHealthcareserviceid($hservice_id));

                $data['patientalert_record'] = PatientAlert::has('PatientAllergies')
                                                        ->with('PatientAllergies')
                                                        ->where('patient_id',$patient_id)
                                                        ->get();
                foreach ($data['patientalert_record']  as $key => $value) {
                    foreach ($value->PatientAllergies as $key => $value) {
                        $value->allergyreaction_name = LovAllergyReaction::where('allergyreaction_id',$value->allergy_reaction_id)->pluck('allergyreaction_name');
                    }
                }

                $data['recent_healthcare'] = Healthcareservices::where('healthcareservice_id', $hservice_id)->first();
                $data['healthcareType'] = $healthcareData->consultation_type;
                $data['healthcareservices'] = $pluginlist;
                $data['healthcareserviceid'] = $hservice_id;
                $data['gender'] = $patients->gender;
                /**
                 * Healthcare type is GeneralConsultation
                 * @var varchar
                 */
                if($healthcareData->healthcareservicetype_id == 'GeneralConsultation' OR $healthcareData->healthcareservicetype_id == 'InternalMedicine') {
                    $data['generalConsultation'] = GeneralConsultation::where('healthcareservice_id', $hservice_id)->first();
                    $data['tabs_child'] =  $this->tabs_child[$healthcareData->healthcareservicetype_id];
                    $data['healthcareserviceType'] = $healthcareData->healthcareservicetype_id;
                    $data['tabs'] = $this->tabs;
                    $data['facilityInfo'] = $this->FacilityRepository->findFacilityByFacilityUserID( $healthcareData->seen_by );
                    $data['seenBy'] = $this->UserRepository->findUserByFacilityUserID( $healthcareData->seen_by );
                    return $data;
                }
                /**
                 * Healthcare type is a plugin
                 * @var varchar
                 */
                else {
                    //get some values from the plugin config file
                    include(plugins_path().$healthcareData->healthcareservicetype_id.'/config.php');
                    foreach($plugin_tabs_models as $k=>$model){
                        if($model != $plugin_id.'Model') {
                            $qModel = 'ShineOS\Core\Healthcareservices\Entities\\'.$model;
                            $query = new $qModel;
                            $data[strtolower($k).'_record'] = $query->where('healthcareservice_id',$hservice_id)->first();
                        } else {
                            //load the plugin Model file
                            $qModel = 'Plugins\\'.$plugin_id.'\\'.$model;
                            $query = new $qModel;
                            $data[strtolower($k).'_record'] = $query->where('healthcareservice_id',$hservice_id)->first();
                        }
                    }
                    $data['facilityInfo'] = $this->FacilityRepository->findFacilityByFacilityUserID( $healthcareData->seen_by );
                    $data['seenBy'] = $this->UserRepository->findUserByFacilityUserID( $healthcareData->seen_by );

                    $data['gender'] = $patients->gender;

                    $data['diagnosis_record'] = json_decode($this->HealthcareRepository->findDiagnosisByHealthcareserviceid($hservice_id));

                    $data['medicalorder_record'] = json_decode($this->HealthcareRepository->findMedicalOrdersByHealthcareserviceid($hservice_id));

                    $data['patientalert_record'] = PatientAlert::has('PatientAllergies')
                                                    ->with('PatientAllergies')
                                                    ->where('patient_id',$patient_id)
                                                    ->get();

                    foreach ($data['patientalert_record']  as $key => $value) {
                        foreach ($value->PatientAllergies as $key => $value) {
                            $value->allergyreaction_name = LovAllergyReaction::where('allergyreaction_id',$value->allergy_reaction_id)->pluck('allergyreaction_name');
                        }
                    }

                    $facilitypatientuser = FacilityPatientUser::where('patient_id', $patient_id)->lists('facilitypatientuser_id');
                    $healthcareservices = Healthcareservices::whereIn('facilitypatientuser_id', $facilitypatientuser)->lists('healthcareservice_id');
                    $data['plugindataall'] = $qModel::whereIn('healthcareservice_id', $healthcareservices)->get();

                    $data['plugin'] = $plugin_id;
                    $data['nocategory'] = 1; //this is not general consultation so no category
                    $data['tabs_child'] = $plugin_tabs_child;
                    $data['tabs'] = $plugin_tabs;
                    $data['plugindata'] = $qModel::where('healthcareservice_id', $hservice_id)->first();
                    $allData = $data;

                    return $allData;
                }
            } else {
                    return NULL;
                }
            }
        } catch(\Exception $e){
           echo "error :".$e;
        }
    }

    public function edit($patient_id = null,  $hservice_id = null)
    {
        $facility = Session::get('facility_details');
        $user = Session::get('user_details');
        $roles = Session::get('roles');

        $data['pageTitle'] = "Healthcare Record";
        $data['tabSwitch'] = true;
        //since this is an edit function
        //we will disable editing of healthcare if it is with disposition
        $data['disabled'] = '';
        $data['formTitle'] = "Consultation";
        $data['follow_healthcareserviceid'] = false;

        $data['session_user_id'] = $this->user->user_id;
        $patients = Patients::find($patient_id);

        if(!$patients) {
            Session::flash('alert-class', 'alert-success alert-dismissible');
            $message = "The patient does not exist anymore. Choose another one.";
            return Redirect::to( "records#visit_list" )->with('message', $message);
        }

        $healthcareData = findHealthRecordByServiceID($hservice_id);
        $data['parent_hcs_id'] = $healthcareData->parent_service_id;
        //check of this has a child
        $data['childData'] = findHealthRecordChild($hservice_id);
        $data['lovlaboratories'] = LovLaboratories::orderBy('laboratorydescription')->get();
        $data['lovMedicalProcedure'] = LovMedicalProcedures::orderBy('procedure_description')->lists('procedure_description','procedure_code');
        $data['lovdiagnosis'] = LovDiagnosis::orderBy('diagnosis_name')->get();
        $data['lovDrugs'] = LovDrugs::orderBy('drug_specification')->get();

        //can we get values from previous consultation
        $data['prevhealth'] = getCompleteHealthRecordByServiceID($healthcareData->parent_service_id);

        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array(); $pluginlist = array(); $tabs_sections = array();

        //Add the basic General Consultation on HCS listing
        $pluginlist['GeneralConsultation'] = "General/Family Medicine";
        $pluginlist['InternalMedicine'] = "Internal Medicine";
        foreach($plugins as $k=>$plugin) {
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'service' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $plugs[$k]['plugin_location'] = $plugin_location;
                                        $plugs[$k]['folder'] = $plugin;
                                        $plugs[$k]['plugin'] = $plugin_id;
                                        $pluginlist[$plugin_id] = $plugin_title;
                                        $this->tabs_child = array_merge($this->tabs_child, $plugin_tabs_child);
                                        $tabs_sections[strtolower($plugin_id)] = $plugin_id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach($plugins as $k=>$plugin) {
            $plugin_type = $plugin_gender = $plugin_age = $plugin_module = '';
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'surgery' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( ($plugin_age=='') OR (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $plugs[$k]['plugin_location'] = $plugin_location;
                                        $plugs[$k]['folder'] = $plugin;
                                        $plugs[$k]['plugin'] = $plugin_id;
                                        $pluginlist[$plugin_id] = $plugin_title;
                                        $this->tabs_child = array_merge($this->tabs_child, $plugin_tabs_child);
                                        $tabs_sections[strtolower($plugin_id)] = $plugin_id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach($plugins as $k=>$plugin) {
            $plugin_type = $plugin_gender = $plugin_age = $plugin_module = '';
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'program' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( ($plugin_age=='') OR (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $plugs[$k]['plugin_location'] = $plugin_location;
                                        $plugs[$k]['folder'] = $plugin;
                                        $plugs[$k]['plugin'] = $plugin_id;
                                        $pluginlist[$plugin_id] = $plugin_title;
                                        $this->tabs_child = array_merge($this->tabs_child, $plugin_tabs_child);
                                        $tabs_sections[strtolower($plugin_id)] = $plugin_id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        foreach($plugins as $k=>$plugin) {
            $plugin_type = $plugin_gender = $plugin_age = $plugin_module = '';
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');
                    //if plugin is activated or this is a developer role
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'subform' AND (($plugin_gender == $patients->gender OR $plugin_gender == 'all') )) {
                                    //check if the plugin is for the age of the patient
                                    $age = getAge($patients->birthdate);
                                    if(strpos($plugin_age,"-")>0){
                                        $range = explode('-',$plugin_age);
                                    }
                                    if( ($plugin_age=='') OR (isset($range) AND $age >= $range[0] AND $age <= $range[1]) OR (!isset($range) AND $age >= $plugin_age) )  {
                                        $plugs[$k]['plugin_location'] = $plugin_location;
                                        $plugs[$k]['folder'] = $plugin;
                                        $plugs[$k]['plugin'] = $plugin_id;
                                        $pluglist[$plugin_id] = $plugin_title;
                                        $this->tabs_child = array_merge($this->tabs_child, $plugin_tabs_child);
                                        $tabs_sections[strtolower($plugin_id)] = $plugin_id;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $data['plugs'] = $plugs;

        try {

            //get service data base on service ID
           if ($healthcareData!=NULL && $patients!=NULL) {
                $data['medicalCategory'] = LovMedicalCategory::where('medicalcategory_group',$healthcareData->healthcareservicetype_id)->orderBy('medicalcategory_name', 'ASC')->get();
                $data['healthcareData'] =  $healthcareData;
                $data['patient'] = $patients;
                $allFormsByHealthcareserviceid = json_decode($this->HealthcareRepository->allFormsByHealthcareserviceid($hservice_id));
                foreach ($allFormsByHealthcareserviceid as $allFormsKey => $allFormsValue) {
                    $data['vitals_record'] = ((!empty($allFormsValue->vitals_physical)) ? $allFormsValue->vitals_physical: NULL);
                    $data['complaints_record'] = ((!empty($allFormsValue->general_consultation)) ? $allFormsValue->general_consultation[0]: NULL);
                    $data['examinations_record'] = ((!empty($allFormsValue->examination)) ? $allFormsValue->examination[0]: NULL);
                    $data['disposition_record'] = ((!empty($allFormsValue->disposition)) ? $allFormsValue->disposition: NULL);
                    $data['addendum_record'] = ((!empty($allFormsValue->addendum)) ? $allFormsValue->addendum: NULL);
                }

                if ($healthcareData!=NULL && $patients!=NULL) {

                    $data['healthcareData'] =  $healthcareData;
                    $data['patient'] = $patients;
                    $allFormsByHealthcareserviceid = json_decode($this->HealthcareRepository->allFormsByHealthcareserviceid($hservice_id));
                    // dd($allFormsByHealthcareserviceid);
                    foreach ($allFormsByHealthcareserviceid as $allFormsKey => $allFormsValue) {
                        $data['vitals_record'] = ((!empty($allFormsValue->vitals_physical)) ? $allFormsValue->vitals_physical: NULL);
                        $data['complaints_record'] = ((!empty($allFormsValue->general_consultation)) ? $allFormsValue->general_consultation[0]: NULL);
                        $data['examinations_record'] = ((!empty($allFormsValue->examination)) ? $allFormsValue->examination[0]: NULL);
                        $data['disposition_record'] = ((!empty($allFormsValue->disposition)) ? $allFormsValue->disposition: NULL);
                        $data['addendum_record'] = ((!empty($allFormsValue->addendum)) ? $allFormsValue->addendum: NULL);
                    }

                    $data['diagnosis_record'] = json_decode($this->HealthcareRepository->findDiagnosisByHealthcareserviceid($hservice_id));

                    $data['medicalorder_record'] = json_decode($this->HealthcareRepository->findMedicalOrdersByHealthcareserviceid($hservice_id));

                    $data['maintenance_drugs'] = json_decode($this->HealthcareRepository->findMaintenanceDrugsByPatientid($patient_id));

                $data['patientalert_record'] = PatientAlert::has('PatientAllergies')
                                                        ->with('PatientAllergies')
                                                        ->where('patient_id',$patient_id)
                                                        ->get();
                foreach ($data['patientalert_record']  as $key => $value) {
                    foreach ($value->PatientAllergies as $key => $value) {
                        $value->allergyreaction_name = LovAllergyReaction::where('allergyreaction_id',$value->allergy_reaction_id)->pluck('allergyreaction_name');
                    }
                }
                $data['icd10'] = LovICD10::where('icd10_category', '=', 0)->where('icd10_subcategory', '=', 0)->where('icd10_tricategory', '=', 0)->lists('icd10_title','icd10_code');
                $data['icd10_sub'] = LovICD10::where('icd10_category', '!=', 0)->where('icd10_subcategory', 0)->where('icd10_tricategory', 0)->lists('icd10_title','icd10_code');
                $data['icd10_type'] = LovICD10::where('icd10_category', '!=', 0)->where('icd10_subcategory', '!=', 0)->where('icd10_tricategory', 0)->lists('icd10_title','icd10_code');
                $data['icd10_code'] = LovICD10::where('icd10_category', '!=', 0)->where('icd10_subcategory', '!=', 0)->where('icd10_tricategory', '!=', 0)->lists('icd10_title','icd10_code');

                $data['recent_healthcare'] = NULL;
                if($healthcareData->parent_service_id) {
                    $data['formTitle'] = "Followup on Consultation for: ";
                    $data['recent_healthcare'] = Healthcareservices::where('healthcareservice_id', $healthcareData->parent_service_id)->first();
                }
                $data['healthcareType'] = $healthcareData->consultation_type;
                $data['healthcareservices'] = $pluginlist;
                $data['healthcareserviceid'] = $hservice_id;
                $data['default_tabs'] = $this->default_tabs;
                $data['gender'] = $patients->gender;

                $data['tabroles'] = $this->tabroles;
                /**
                 * Healthcare type is GeneralConsultation
                 * @var varchar
                 */
                if($healthcareData->healthcareservicetype_id == 'GeneralConsultation' OR $healthcareData->healthcareservicetype_id == 'InternalMedicine') {
                    $data['generalConsultation'] = GeneralConsultation::where('healthcareservice_id', $hservice_id)->first();
                    $data['tabs_child'] =  $this->tabs_child[$healthcareData->healthcareservicetype_id];
                    $data['healthcareserviceType'] = $healthcareData->healthcareservicetype_id;
                    $data['tabs'] = $this->tabs;
                    $data['facilityInfo'] = $this->FacilityRepository->findFacilityByFacilityUserID( $healthcareData->seen_by );
                    $data['seenBy'] = $this->UserRepository->findUserByFacilityUserID( $healthcareData->seen_by );

                    return view('healthcareservices::add')->with($data);
                }
                /**
                 * Healthcare type is a plugin
                 * @var varchar
                 */
                else {
                    //get some values from the plugin config file
                    include(plugins_path().$healthcareData->healthcareservicetype_id.'/config.php');
                    foreach($plugin_tabs_models as $k=>$model){
                        if($model != $plugin_id.'Model') {
                            $qModel = 'ShineOS\Core\Healthcareservices\Entities\\'.$model;
                            $query = new $qModel;
                            $data[strtolower($k).'_record'] = $query->where('healthcareservice_id',$hservice_id)->first();
                        } else {
                            //load the plugin Model file
                            $qModel = 'Plugins\\'.$plugin_id.'\\'.$model;
                            $query = new $qModel;
                            $data[strtolower($k).'_record'] = $query->where('healthcareservice_id',$hservice_id)->first();
                            if($healthcareData->parent_service_id) {
                                $data[strtolower($k).'_parentrecord'] = $query->where('healthcareservice_id',$healthcareData->parent_service_id)->first();
                            }
                        }
                    }

                    $data['facilityInfo'] = $this->FacilityRepository->findFacilityByFacilityUserID( $healthcareData->seen_by );
                    $data['seenBy'] = $this->UserRepository->findUserByFacilityUserID( $healthcareData->seen_by );

                    $data['gender'] = $patients->gender;

                    $data['diagnosis_record'] = json_decode($this->HealthcareRepository->findDiagnosisByHealthcareserviceid($hservice_id));

                    $data['medicalorder_record'] = json_decode($this->HealthcareRepository->findMedicalOrdersByHealthcareserviceid($hservice_id));

                    $data['maintenance_drugs'] = json_decode($this->HealthcareRepository->findMaintenanceDrugsByPatientid($patient_id));

                    $data['medicalCategory'] = LovMedicalCategory::where('medicalcategory_group',$healthcareData->healthcareservicetype_id)->orderBy('medicalcategory_name', 'ASC')->get();

                    $data['patientalert_record'] = PatientAlert::has('PatientAllergies')
                                                    ->with('PatientAllergies')
                                                    ->where('patient_id',$patient_id)
                                                    ->get();

                    foreach ($data['patientalert_record']  as $key => $value) {
                        foreach ($value->PatientAllergies as $key => $value) {
                            $value->allergyreaction_name = LovAllergyReaction::where('allergyreaction_id',$value->allergy_reaction_id)->pluck('allergyreaction_name');
                        }
                    }

                    $facilitypatientuser = FacilityPatientUser::where('patient_id', $patient_id)->lists('facilitypatientuser_id');
                    $healthcareservices = Healthcareservices::whereIn('facilitypatientuser_id', $facilitypatientuser)->lists('healthcareservice_id');
                    $data['plugindataall'] = $qModel::whereIn('healthcareservice_id', $healthcareservices)->get();

                    $data['plugin'] = $plugin_id;
                    $data['nocategory'] = 1; //this is not general consultation so no category
                    $data['tabs_child'] = $plugin_tabs_child;
                    $data['tabs'] = $plugin_tabs;
                    $data['tabs_sections'] = $tabs_sections;
                    $data['plugindata'] = $qModel::where('healthcareservice_id', $hservice_id)->first();
                    if($healthcareData->parent_service_id):
                    $data['pluginparentdata'] = $qModel::where('healthcareservice_id', $healthcareData->parent_service_id)->first();
                    endif;
                    $allData = $data;
                    //define tab role
                    $ptab[strtolower($plugin_id)."_plugin"] = $plugin_role;
                    $data['tabroles'] = $data['tabroles'] + $ptab;

                    return view('healthcareservices::add', compact('allData'))->with($data);
                }
            } else {
                    Session::flash('alert-class', 'alert-error alert-dismissible');
                    $message = "The patient does not exist.";
                    return Redirect::to( "records" )->with('message', $message);
                }
            }
        } catch(\Exception $e){
           echo "error :".$e;
        }
    }

    public function delete($pid, $id)
    {

        $user = UserHelper::getUserInfo();

        $facilityInfo = FacilityHelper::facilityInfo();
        $facilityUser = FacilityHelper::facilityUserId($user->user_id, $facilityInfo->facility_id);
        $facpatid = FacilityPatientUser::where('facilityuser_id', $facilityUser->facilityuser_id)->where('patient_id', $pid)->first();

        //delete healthcare record if not yet deleted
        $deletePatient = Healthcareservices::where('healthcareservice_id', $id)->where('deleted_at', NULL)->delete();

        //let us delete all related records
        VitalsPhysical::where('healthcareservice_id', $id)->delete();
        GeneralConsultation::where('healthcareservice_id', $id)->delete();
        Examination::where('healthcareservice_id', $id)->delete();
        Disposition::where('healthcareservice_id', $id)->delete();
        Addendum::where('healthcareservice_id', $id)->delete();

        //get all diagnosis
        $ds = Diagnosis::where('healthcareservice_id', $id)->get();
        if($ds):
            foreach($ds as $d):
                DiagnosisICD10::where('diagnosis_id', $d->diagnosis_id)->delete();
            endforeach;
        endif;
        Diagnosis::where('healthcareservice_id', $id)->delete();

        $orders = MedicalOrder::where('healthcareservice_id', $id)->get();
        if($orders):
            foreach($orders as $order):
                MedicalOrderLabExam::where('medicalorder_id', $order->medicalorder_id)->delete();
                MedicalOrderPrescription::where('medicalorder_id', $order->medicalorder_id)->delete();
                MedicalOrderProcedure::where('medicalorder_id', $order->medicalorder_id)->delete();
            endforeach;
        endif;
        MedicalOrder::where('healthcareservice_id', $id)->delete();

        if ($deletePatient) :
            Session::flash('alert-class', 'alert-success alert-dismissible');
            $message = "Successfully deleted Healthcare Record.";
        else:
            Session::flash('alert-class', 'alert-danger alert-dismissible');
            $message = "An error was encountered while deleting the Healthcare Record. Kindly try again.";
        endif;

        return Redirect::to('records#visit_list')->with('message', $message);
    }

    public function undelete($pid, $id)
    {

        $user = UserHelper::getUserInfo();

        $facilityInfo = FacilityHelper::facilityInfo();
        $facilityUser = FacilityHelper::facilityUserId($user->user_id, $facilityInfo->facility_id);
        $facpatid = FacilityPatientUser::where('facilityuser_id', $facilityUser->facilityuser_id)->where('patient_id', $pid)->first();

        //restore healthcare record if not yet deleted
        $restoredPatient = Healthcareservices::where('healthcareservice_id', $id)->restore();

        //let us delete all related records
        VitalsPhysical::where('healthcareservice_id', $id)->restore();
        GeneralConsultation::where('healthcareservice_id', $id)->restore();
        Examination::where('healthcareservice_id', $id)->restore();
        Disposition::where('healthcareservice_id', $id)->restore();
        Addendum::where('healthcareservice_id', $id)->restore();

        //get all diagnosis
        Diagnosis::where('healthcareservice_id', $id)->restore();
        $ds = Diagnosis::where('healthcareservice_id', $id)->get();
        if($ds):
            foreach($ds as $d):
                DiagnosisICD10::where('diagnosis_id', $d->diagnosis_id)->restore();
            endforeach;
        endif;

        MedicalOrder::where('healthcareservice_id', $id)->restore();
        $orders = MedicalOrder::where('healthcareservice_id', $id)->get();
        if($orders):
            foreach($orders as $order):
                MedicalOrderLabExam::where('medicalorder_id', $order->medicalorder_id)->restore();
                MedicalOrderPrescription::where('medicalorder_id', $order->medicalorder_id)->restore();
                MedicalOrderProcedure::where('medicalorder_id', $order->medicalorder_id)->restore();
            endforeach;
        endif;

        if ($restoredPatient) :
            Session::flash('alert-class', 'alert-success alert-dismissible');
            $message = "Successfully restored Healthcare Record.";
        else:
            Session::flash('alert-class', 'alert-danger alert-dismissible');
            $message = "An error was encountered while restoring the Healthcare Record. Kindly try again.";
        endif;

        return Redirect::to('records#visit_list')->with('message', $message);
    }

    function qview($patient_id, $healthcareservice_id)
    {
        $data = $this->retrieve($patient_id, $healthcareservice_id);
        $d['data'] = $data;
        return view('healthcareservices::qview')->with($d);
    }

    function getVisitList($start, $end)
    {
        $visits = getAppointments($start, $end);
        $visitlisting = "";
        $seen = NULL;
        if(!empty($visits)):
            foreach($visits as $key => $value):
                if($value->sent_status == 'SENT' OR $value->sent_status == NULL):
                    if(isset($value->appointment_datetime)):
                        $visitlisting .= '<tr class="row-clicker" onclick="location.href=\''.url('healthcareservices/add/'.$value->patient_id.'/'.$value->healthcareservice_id).'\'">';
                    else:
                        $visitlisting .= '<tr class="row-clicker" onclick="location.href=\''.url('healthcareservices/edit/'.$value->patient_id.'/'.$value->healthcareservice_id).'\'">';
                    endif;
                    if(isset($value->appointment_datetime)):
                        $visitlisting .= '<td><span class="fa fa-calendar-check-o text-danger"></span> '.date('m/d/y h:i A', strtotime($value->visit_date)).'</td>';
                    else:
                        $visitlisting .= '<td><span class="fa fa-blind text-danger"></span> '.date('m/d/y h:i A', strtotime($value->visit_date)).'</td>';
                    endif;
                    $visitlisting .= '
                        <td>'.$value->last_name.', '.$value->first_name.'</td>
                        <td>'.$value->healthcareservicetype_id.'</td>
                    </tr>';
                endif;
            endforeach;
        else:
            $visitlisting .= '<tr><td colspan="4">No Consultations</td></tr>';
        endif;

        echo $visitlisting;
        exit;
    }
}
