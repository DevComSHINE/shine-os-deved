<?php
namespace ShineOS\Core\Healthcareservices\Http\Controllers;

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

use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use ShineOS\Core\Facilities\Entities\FacilityUser;

use Shine\Repositories\Eloquent\FacilityRepository as FacilityRepository;
use Shine\Repositories\Eloquent\UserRepository as UserRepository;
use Shine\Repositories\Eloquent\HealthcareRepository as HealthcareRepository;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\Utils;
use Shine\Libraries\UserHelper;

use View, Form, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Schema, Request;

class HealthcareservicesController extends Controller {

    protected $moduleName = 'healthcareservices';
    protected $modulePath = 'healthcareservices';
    protected $default_tabs = "addservice";
    protected $data = [];
    protected $facilityuser_id;

    protected $tabs = [
        'addservice' => 'Basic Information',
        'disposition' => 'Disposition',
        'examinations' => 'Examinations',
        'immunization' => 'Immunization',
        'impanddiag' => 'Impressions & Diagnosis',
        'medicalorders' => 'Medical Orders',
        'complaints' => 'Complaints',
        'vitals' => 'Vitals & Physical',
    ];
    protected $tabs_child = [
        'GeneralConsultation' => ['addservice', 'complaints', 'vitals', 'examinations', 'impanddiag', 'medicalorders', 'disposition']
    ];

    private $healthcareRepository;

    public function __construct(FacilityRepository $FacilityRepository, UserRepository $UserRepository, HealthcareRepository $healthcareRepository)
    {
        /** User Session or Authenticaion  */
        $this->middleware('auth');

        $this->FacilityRepository = $FacilityRepository;
        $this->UserRepository = $UserRepository;
        $this->HealthcareRepository = $healthcareRepository;

        $this->healthcareserviceid = IdGenerator::generateId();
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

        $this->follow_healthcareserviceid = Input::has('follow_healthcareserviceid') ?  Input::get('follow_healthcareserviceid') : false;

        $this->medical_category = Input::has('medical_category') ?  Input::get('medical_category') : false;
        $this->consultationtype_id = Input::has('consultationtype_id') ?  Input::get('consultationtype_id') : 'CONSU';
        $this->encounter_type = Input::has('encounter_type') ?  Input::get('encounter_type') : 'O';
        $modules =  Utils::getModules();

        // variables to share to all view
        View::share('modules', $modules);
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);

    }

     public function index($action = null, $patient_id = null, $hservice_id = null) {

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
        //since this is an edit function
        //we will disable editing of healthcare
        $data['disabled'] = '';

        $patients = Patients::find($patient_id);
        $healthcareData = Healthcareservices::find($hservice_id);

        $facility = Session::get('facility_details');
        $roles = Session::get('roles');

        if($healthcareData) {
            $data['healthcareData'] =  $healthcareData;
        } else {
            $data['healthcareData'] =  false;
        }

        // for button value
        if ($hservice_id != null):
            $data['healthcareType'] = "FOLLO";
        else:
            $data['healthcareType'] = "CONSU";
        endif;

        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array(); $pluginlist = array();
        $pluginlist[NULL] = "-- Choose a Health Service --";
        //Add the basic General Consultation on HCS listing
        $pluginlist['GeneralConsultation'] = "General Consultation";
        foreach($plugins as $k=>$plugin) {
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');

                    if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                        //get only plugins for this module
                        if($plugin_module == 'healthcareservices'){
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
        $data['plugs'] = $plugs;
        $data['default_tabs'] = $this->default_tabs;
        $data['tabs'] = $this->tabs;
        $data['healthcareservices'] = $pluginlist;
        $data['medicalCategory'] = LovMedicalCategory::orderBy('medicalcategory_name', 'ASC')->get();

        if (count($patients) > 0) {
            $data['follow_healthcareserviceid'] = $hservice_id;
            $data['patient'] = $patients;

            if($healthcareData) { //this is a followup
                $data['formTitle'] = "Followup on Consultation: ";
                $data['healthcareserviceid'] = false;
                $healthcareData->consultationtype_id = 'FOLLO';
                $data['recent_healthcare'] = Healthcareservices::where('healthcareservice_id', $hservice_id)->first();
                $data['gender'] = $patients->gender;
                $data['healthcaretype'] = "FOLLO";
                //temporary
                if($healthcareData->healthcareservicetype_id == 'GeneralConsultation') {
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

    public function insert() {

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

            if($this->healthcareservices_type == 'GeneralConsultation') {
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

        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array(); $pluginlist = array();
        $pluginlist[NULL] = "-- Choose a Health Service --";
        foreach($plugins as $k=>$plugin) {
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');

                    if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                        //get only plugins for this module
                        if($plugin_module == 'healthcareservices'){
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
        $data['plugs'] = $plugs;
        //Add the basic General Consultation on HCS listing
        $pluginlist['GeneralConsultation'] = "General Consultation";

        try {
            $data['session_user_id'] = $this->user->user_id;
            $patients = Patients::find($patient_id);

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
                if($healthcareData->healthcareservicetype_id == 'GeneralConsultation') {
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

    public function edit($patient_id = null,  $hservice_id = null) {

        $facility = Session::get('facility_details');
        $user = Session::get('user_details');
        $roles = Session::get('roles');

        //since this is an edit function
        //we will disable editing of healthcare if it is with disposition
        $data['disabled'] = '';
        $data['formTitle'] = "Consultation";
        $data['follow_healthcareserviceid'] = false;

        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array(); $pluginlist = array();
        $pluginlist[NULL] = "-- Choose a Health Service --";
        foreach($plugins as $k=>$plugin) {
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');

                    if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                        //get only plugins for this module
                        if($plugin_module == 'healthcareservices'){
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
        $data['plugs'] = $plugs;
        //Add the basic General Consultation on HCS listing
        $pluginlist['GeneralConsultation'] = "General Consultation";

        try {
            $data['session_user_id'] = $this->user->user_id;
            $patients = Patients::find($patient_id);

            if(!$patients) {
                Session::flash('alert-class', 'alert-success alert-dismissible');
                $message = "The patient does not exist anymore. Choose another one.";
                return Redirect::to( "records#visit_list" )->with('message', $message);
            }

            $healthcareData = findHealthRecordByServiceID($hservice_id);
            $data['lovlaboratories'] = LovLaboratories::orderBy('laboratorydescription')->get();
            $data['lovMedicalProcedure'] = LovMedicalProcedures::orderBy('procedure_description')->lists('procedure_description','procedure_code');
            $data['lovdiagnosis'] = LovDiagnosis::orderBy('diagnosis_name')->get();
            $data['lovDrugs'] = LovDrugs::orderBy('drug_specification')->get();

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

                $data['recent_healthcare'] = Healthcareservices::where('healthcareservice_id', $hservice_id)->first();
                $data['healthcareType'] = $healthcareData->consultation_type;
                $data['healthcareservices'] = $pluginlist;
                $data['healthcareserviceid'] = $hservice_id;
                $data['default_tabs'] = $this->default_tabs;
                $data['gender'] = $patients->gender;
                /**
                 * Healthcare type is GeneralConsultation
                 * @var varchar
                 */
                if($healthcareData->healthcareservicetype_id == 'GeneralConsultation') {
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
                        }
                    }
                    $data['facilityInfo'] = $this->FacilityRepository->findFacilityByFacilityUserID( $healthcareData->seen_by );
                    $data['seenBy'] = $this->UserRepository->findUserByFacilityUserID( $healthcareData->seen_by );

                    $data['gender'] = $patients->gender;

                    $data['diagnosis_record'] = json_decode($this->HealthcareRepository->findDiagnosisByHealthcareserviceid($hservice_id));

                    $data['medicalorder_record'] = json_decode($this->HealthcareRepository->findMedicalOrdersByHealthcareserviceid($hservice_id));

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

                    $data['plugin'] = $plugin_id;
                    $data['nocategory'] = 1; //this is not general consultation so no category
                    $data['tabs_child'] = $plugin_tabs_child;
                    $data['tabs'] = $plugin_tabs;
                    $data['plugindata'] = $qModel::where('healthcareservice_id', $hservice_id)->first();
                    $allData = $data;

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
        $visits = getAllHealthcareByDate($start, $end);
        $visitlisting = "";
        if(!empty($visits)):
            foreach($visits as $key => $value):
                if($value->seen_by):
                    $seen = $value->seen_by->first_name .' '. $value->seen_by->last_name;
                endif;
                $visitlisting .= '<tr class="row-clicker" onclick="location.href=\''.url('healthcareservices/edit/'.$value->patient_id.'/'.$value->healthcareservice_id).'\'">
                    <td>'.date("m/d/Y", strtotime($value->encounter_datetime)).'</td>
                    <td>'.$value->last_name.', '.$value->first_name.'</td>
                    <td>'.$seen.'</td>
                    <td>'.$value->healthcareservicetype_id.'</td>
                </tr>';
            endforeach;
        else:
            $visitlisting .= '<tr><td colspan="4">No Consultations</td></tr>';
        endif;

        echo $visitlisting;
        exit;
    }
}
