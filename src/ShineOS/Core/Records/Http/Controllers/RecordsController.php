<?php
namespace ShineOS\Core\Records\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Patients\Entities\PatientDeathInfo;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use ShineOS\Core\Facilities\Entities\FacilityUser;
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Referrals\Entities\Referrals;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\Utils;
use Shine\Libraries\HealthcareservicesHelper;
use Shine\Repositories\Eloquent\UserRepository as UserRepository;
use Shine\Repositories\Eloquent\HealthcareRepository as HealthcareRepository;
use Shine\Repositories\Contracts\FacilityRepositoryInterface;

use DB, View, Input, DateTime, Cache, Session;

/**
 * A class that acts as gateway to Patients and Healthcare Modules
 */
class RecordsController extends Controller {

    private $UserRepository;
    private $healthcareRepository;

    public function __construct(UserRepository $UserRepository, HealthcareRepository $healthcareRepository)
    {
        $this->middleware('auth');
        $this->UserRepository = $UserRepository;
        $this->HealthcareRepository = $healthcareRepository;

        $modules =  Utils::getModules();

        # variables to share to all view
        View::share('modules', $modules);

        View::addNamespace('records', 'src/ShineOS/Core/Records/Resources/Views');
    }

    public function index() {

        return view('records::pages.index');
    }

    public function loadpatients() {

        $facilityInfo = FacilityHelper::facilityInfo();

        /**
         * Get patient records from referred and created patients
         * @var [type]
         */
        $datum = array();
        $filtered = FALSE;
        $length = 10;
        $start = 0;

        $datum['recordsTotal'] = countAllPatientsByFacility(); //get total database
        if($_POST AND $_POST['draw']) {
            $datum['draw'] = $_POST['draw'];
        }

        //process query limits
        if($_POST AND $_POST['length']){
            $length = $_POST['length'];
        }
        if($_POST AND $_POST['start']){
            $start = $_POST['start'];
        }

        //process ordering
        if($_POST AND $_POST['order']) {
            $dir = $_POST['order'][0]['dir'];
            switch ($_POST['order'][0]['column']) {
                case '0': $order = 'created_at'; break;
                case '1': $order = 'last_name'; break;
                case '2': $order = 'gender'; break;
                case '3': $order = 'birthdate'; break;
                case '4': $order = 'birthdate'; break;
                case '5': $order = 'family_folder_name'; break;
                case '6': $order = 'barangay'; break;
                default: $order = 'created_at';
            }
        }

        //process search
        $search = NULL;
        if($_POST AND ($_POST['search']['value']!=NULL OR $_POST['search']['value']!="")) {
            $search = $_POST['search']['value'];
        }

        $patients = getAllPatientsByFacility($order, $search, $dir, $length, $start);
        $c = 0;

        foreach($patients as $r) {

            $pic = "noimage_male.png";
            if($r->photo_url) {
                $pic = $r->photo_url;
            }

            if ($r->patient_deathinfo_id != null) {
                $status = 'disabled';
            } else {
                $status = 'active';
            }

            $dateNow = new DateTime();
            $patientBday = new DateTime(($r->birthdate));
            $interval = $dateNow->diff($patientBday);

            //let us identify patients that are owned by this provider and those not
            /*$bcolor = "bg-orange";
            if($r->created_provider_account_id != $user->provider_account_id) {
                $bcolor = "bg-blue";
            }*/
            if(isset($r->barangay)) {
                $brgy = getBrgyName($r->barangay);
            }

            $datum['data'][$c]['pid'] = "<div class='profile_image profile_image_list pat_img' style='background: url(\"".uploads_url().'patients/'.$pic."\") no-repeat center center;'></div>";
            $datum['data'][$c]['name'] = "<a href='".url('patients', [$r->patient_id])."' class='' title='View Patient Dashboard'> ".$r->last_name.", ".$r->first_name." ".$r->middle_name."</a>";
            $datum['data'][$c]['gender'] = $r->gender;
            $datum['data'][$c]['age'] = $interval->format('%Y');
            $datum['data'][$c]['birthdate'] = $r->birthdate;
            $datum['data'][$c]['family_folder_name'] = isset($r->family_folder_name) ? $r->family_folder_name : "";
            $datum['data'][$c]['barangay'] = isset($brgy) ? $brgy : "";

            if($status == 'active'){
                $datum['data'][$c]['action'] = '<div class="btn-group" style="white-space: nowrap; width:245px;">
                    <div class="btn-group">
                        <a href="#" type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown" > Actions <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                          <li><a href="'.url('healthcareservices/add', [$r->patient_id]).'">Add Healthcare Visit</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a href="'.url('patients/addDeathInfo', [$r->patient_id]).'" data-toggle="modal" data-target="#deathInfoModal" class="red deathModal">Declare Dead</a></li>
                          <li role="separator" class="divider widehide"></li>
                          <li class="widehide"><a href="'.url('patients/view', [$r->patient_id]).'" type="button" title="Edit Patient"><i class="fa fa-pencil"></i> Edit</a></li>
                          <li class="widehide"><a href="'.route('patients.delete', [$r->patient_id]).'" type="button" title="Delete" onclick="if( confirm(\'Are you sure you want to delete this patient?\') ) { return true; } return false;"><i class="fa fa-trash-o"></i> Delete</a></li>
                        </ul>
                    </div>
                    <a href="'.url('patients/view', [$r->patient_id]).'" type="button" class="btn btn-success btn-flat smalhide" title="Edit Patient"><i class="fa fa-pencil"></i> Edit</a>
                    <a href="'.route('patients.delete', [$r->patient_id]).'" type="button" class="btn btn-danger btn-flat smalhide" title="Delete" onclick="if( confirm(\'Are you sure you want to delete this patient?\') ) { return true; } return false;"><i class="fa fa-trash-o"></i> Delete</a>
                </div>';
            } else {
                $datum['data'][$c]['action'] = '<div class="btn-group"><a href="'.url('patients/viewDeathInfo', [$r->patient_id]).'" class="btn btn-default btn-flat" data-toggle="modal" data-target="#deathInfoModal">Patient declared dead. View info.</a></div>';

            }


            $c++;
        }

        //get filtered count
        $datum['recordsFiltered'] = countAllPatientsByFacility();

        //output json
        if(count($patients) > 0) {

        } else {
            $datum['data'][0]['pid'] = NULL;
            $datum['data'][0]['name'] = "No patient records found";
            $datum['data'][0]['gender'] = NULL;
            $datum['data'][0]['age'] = NULL;
            $datum['data'][0]['birthdate'] = NULL;
            $datum['data'][0]['family_folder_name'] = NULL;
            $datum['data'][0]['barangay'] = NULL;
            $datum['data'][0]['action'] = NULL;
        }

        $pats = json_encode($datum);

        return $pats;
    }

    public function loadconsultations() {

        $facilityInfo = Session::get('facility_details');

        /**
         * Get patient records from referred and created patients
         * @var [type]
         */
        $datum = array();
        $filtered = FALSE;
        $length = 10;
        $start = 0;

        $datum['recordsTotal'] = countAllHealthcareByFacilityID($facilityInfo->facility_id); //get total database

        if($_POST AND $_POST['draw']) {
            $datum['draw'] = $_POST['draw'];
        }

        //process query limits
        if($_POST AND $_POST['length']){
            $length = $_POST['length'];
        }
        if($_POST AND $_POST['start']){
            $start = $_POST['start'];
        }

        //process ordering
        if($_POST AND $_POST['order']) {
            $dir = $_POST['order'][0]['dir'];
            switch ($_POST['order'][0]['column']) {
                case '0': $order = 'hcid'; break;
                case '1': $order = 'last_name'; break;
                case '2': $order = 'healthcareservicetype_id'; break;
                case '3': $order = 'encounter_type'; break;
                case '4': $order = 'seen_by'; break;
                case '5': $order = 'encounter_datetime'; break;
            }
        }

        //process search
        $search = NULL;
        if($_POST AND ($_POST['search']['value']!=NULL OR $_POST['search']['value']!="")) {
            $search = $_POST['search']['value'];
        }

        // HEALTHCARE RECORDS
        $visits = getAllHealthcareByFacilityIDwOptions($facilityInfo->facility_id, $search, $order, $dir, $length, $start);

        $c = 0;

        foreach($visits as $k => $r) {

            $pic = "noimage_male.png";
            if($r->photo_url) {
                $pic = $r->photo_url;
            }
            //check if this patient is dead
            $status = 'active';
            $dead = PatientDeathInfo::where('patient_id',$r->patient_id)->first();
            if ($dead) {
                $status = 'disabled';
            }

            $r->seen_by = findUserByFacilityUserID($r->seen_by);
            if($r->seen_by) {
                $seen = '<a href="'.url("/users", [$r->seen_by->user_id]).'" title="View User Info">'.$r->seen_by->first_name.' '.$r->seen_by->last_name.'</a>';
            } else {
                $seen = NULL;
            }
            $r->healthcare_disposition = getDispositionByHealthServiceID($r->healthcareservice_id);

            $service = $r->healthcareservicetype_id;
            if($r->parent_service_id AND isset($r->consultation_type) AND $r->consultation_type == 'FOLLO') {
                $service = $r->healthcareservicetype_id."<br>(Follow-up)";
            }

            $datum['data'][$c]['pid'] = "<div class='profile_image profile_image_list pat_img' style='background: url(\"".uploads_url().'patients/'.$pic."\") no-repeat center center;'></div>";
            $datum['data'][$c]['name'] = "<a href='".url('patients', [$r->patient_id])."' class='' title='View Patient Dashboard'> ".$r->last_name.", ".$r->first_name." ".$r->middle_name."</a>";
            $datum['data'][$c]['service_type'] = $service;
            $datum['data'][$c]['encounter_type'] = getEncounterName($r->encounter_type);
            $datum['data'][$c]['seen_by'] = $seen;
            $datum['data'][$c]['encounter_datetime'] = date('M, d, Y', strtotime($r->encounter_datetime));

            if($status == 'active'){
                $action = '<div class="btn-group" style="white-space: nowrap; width:245px;">
                        <div class="btn-group">
                            <a href="#" type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown"> Actions <span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">';
                              if(!empty($r->healthcare_disposition->disposition)):
                                  $child = findHealthRecordChild($r->healthcareservice_id);
                                  if($child) {
                                    $action .= '<li><a href="'.url('healthcareservices/edit/'.$r->patient_id.'/'.$child->healthcareservice_id).'" title="Open Follow-up">Open Follow-up </a></li>';
                                  } else {
                                    $action .= '<li><a href="'.url('healthcareservices/add/'.$r->patient_id.'/'.$r->healthcareservice_id).'" title="Add Follow-up">Add Follow-up </a></li>';
                                  }
                                  if(getModuleStatus('referrals') == 1):
                                  $action .= '<li><a href="'.url('referrals/add', [$r->healthcareservice_id]).'" title="Refer Patient">Refer Patient </a></li>';
                                  endif;
                                  if(getModuleStatus('reminders') == 1):
                                  $action .= '<li><a href="'.url('reminders/add/'.$r->patient_id.'/'.$r->healthcareservice_id).'" title="Refer Patient">Create Appointment </a></li>';
                                  endif;

                                $action .= '<li role="separator" class="divider widehide"></li>
                                <li class="widehide"><a href="'.url('healthcareservices/edit/'.$r->patient_id.'/'.$r->healthcareservice_id).'" title="View Visits"><i class="fa fa-eye"></i> View </a></li>';
                              else:
                                $action .= '<li><a href="'.url("healthcareservices/edit/".$r->patient_id.'/'.$r->healthcareservice_id.'#disposition').'">This record is not yet complete.<br />Please give your Disposition.</a></li>';
                                $action .= '<li role="separator" class="divider widehide"></li>
                                <li class="widehide"><a href="'.url('healthcareservices/edit/'.$r->patient_id.'/'.$r->healthcareservice_id).'" title="Edit Visits"><i class="fa fa-pencil"></i> Edit </a></li>
                                <li class="widehide"><a href="'.url('healthcareservices/delete/'.$r->patient_id.'/'.$r->healthcareservice_id).'" title="Delete Visits" onclick="if( confirm(\'Are you sure you want to delete this health record?\') ) { return true; } return false;"><i class="fa fa-trash-o"></i> Delete</a></li>';
                              endif;
                            $action .= '</ul></div>';

                        if(!empty($r->healthcare_disposition->disposition)):
                        $action .= '<a href="'.url('healthcareservices/edit/'.$r->patient_id.'/'.$r->healthcareservice_id).'" class="btn btn-success btn-flat smalhide" title="View Visits"><i class="fa fa-eye"></i> View </a>
                        <a href="javascript:;" class="btn btn-warning btn-flat smalhide" title=""><i class="fa fa-lock"></i> Locked</a>
                        <a href="" class="btn btn-warning btn-flat widehide"><i class="fa fa-lock"></i></a>';
                        else:
                        $action .= '<a href="'.url('healthcareservices/edit/'.$r->patient_id.'/'.$r->healthcareservice_id).'" class="btn btn-success btn-flat smalhide" title="Edit Visits"><i class="fa fa-pencil"></i> Edit </a>
                        <a href="'.url('healthcareservices/delete/'.$r->patient_id.'/'.$r->healthcareservice_id).'" class="btn btn-danger btn-flat smalhide" title="Delete Visits" onclick="if( confirm(\'Are you sure you want to delete this health record?\') ) { return true; } return false;"><i class="fa fa-trash-o"></i> Delete</a>';
                        endif;
                      $action .= '</div>';
                $datum['data'][$c]['action'] = $action;
            } else {
                $datum['data'][$c]['action'] = '<div class="btn-group"><a href="'.url('patients/viewDeathInfo', [$r->patient_id]).'" class="btn btn-default btn-flat" data-toggle="modal" data-target="#deathInfoModal">Patient declared dead. View info.</a></div>';

            }
             $c++;
        }

        //get filtered count
        $datum['recordsFiltered'] = $datum['recordsTotal'];

        //output json
        if(count($visits) > 0) {

        } else {
            $datum['data'][0]['pid'] = NULL;
            $datum['data'][0]['name'] = "No healthcare records found";
            $datum['data'][0]['service_type'] = NULL;
            $datum['data'][0]['encounter_type'] = NULL;
            $datum['data'][0]['seen_by'] = NULL;
            $datum['data'][0]['encounter_datetime'] = NULL;
            $datum['data'][0]['action'] = NULL;
        }

        $pats = json_encode($datum);

        return $pats;
    }

    public function search()
    {
        $facility = Session::get('facility_details');
        $roles = Session::get('roles');

        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array(); $pluginlist = array();
        $pluginlist[''] = "-- Choose Clinical Service --";
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
                    if(json_decode($facility->enabled_plugins) != NULL){
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'consultation') {
                                    $pluginlist['Consultation'][$plugin_id] = $plugin_title;
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
                    if(json_decode($facility->enabled_plugins) != NULL){
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'surgery') {
                                    $pluginlist['Surgery'][$plugin_id] = $plugin_title;
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
                    if(json_decode($facility->enabled_plugins) != NULL){
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'program') {
                                        $pluginlist['DOH Programs'][$plugin_id] = $plugin_title;
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
                    if(json_decode($facility->enabled_plugins) != NULL){
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                            //get only healthcare service plugins for this module
                            if($plugin_module == 'healthcareservices') {
                                //check if this plugin is for the gender of the patient
                                if($plugin_type == 'special') {
                                        $pluginlist['Special Programs'][$plugin_id] = $plugin_title;
                                }
                            }
                        }
                    }
                }
            }
        }
        $data['healthcareservices'] = $pluginlist;
        return view('records::pages.search')->with($data);
    }

    public function getResults()
    {
        $maycontactna = 0;

        $facilityInfo = Session::get('user_details');

        $name = (Input::get('input_name') != '') ? Input::get('input_name') : null;
        $age = (Input::get('input_ageRange') != '') ? Input::get('input_ageRange') : null;
        $sex = (Input::get('input_sex') != '') ? Input::get('input_sex') : null;
        $barangay = (Input::get('input_barangay') != '') ? Input::get('input_barangay') : null;
        $citymun = (Input::get('input_cityMun') != '') ? Input::get('input_cityMun') : null;
        $diagnosis = (Input::get('input_diagnosis') != '') ? Input::get('input_diagnosis') : null;
        $medicalorder = (Input::get('input_medicalOrder') != '') ? Input::get('input_medicalOrder') : null;
        $healthcare_services = (Input::get('input_healthcare_services') != '') ? Input::get('input_healthcare_services') : null;

        $searchkey = "";
        $namer = "";

        $select = "SELECT *";
        $arg = " FROM patients JOIN patient_contact ON patient_contact.patient_id = patients.patient_id JOIN facility_patient_user ON patients.patient_id = facility_patient_user.patient_id JOIN facility_user ON facility_patient_user.facilityuser_id = facility_user.facilityuser_id ";
        $sql = " WHERE facility_user.facility_id = '".$facilityInfo->facilityUser[0]->facility_id."' AND  patients.deleted_at IS NULL";

        if($name) {
            $searchkey .= " with name of ".$name." ";
            //one word is given
            $namer = ' AND (patients.first_name LIKE "%'.$name.'%" OR patients.last_name LIKE "%'.$name.'%" OR patients.middle_name LIKE "%'.$name.'%") ';
        }
        $sql .= $namer;

        if($age) {
            $ages = explode("-", $age);
            $now = date('Y');
            $minage = $now - $ages[1];
            $maxage = $now - $ages[0];
            $sql .= " AND (YEAR(patients.birthdate) > ".$minage." AND YEAR(patients.birthdate) <= ".$maxage.") ";
            $searchkey .= " with age between ".$age." ";
        }
        if($sex) {
            $sql .= ' AND (patients.gender = "'.$sex.'")';
            $searchkey .= " with gender as ".getGender($sex)." ";
        }
        if($barangay) {
            //get brgy code by barangay name
            $brgy_code = getBrgyCode($barangay);
            $sql .= ' AND (patient_contact.barangay = "'.$brgy_code.'")';
            $maycontactna = 1;
            $searchkey .= " living in barangay ".$barangay." ";
        }
        if($citymun) {
            //get brgy code by barangay name
            $brgy_code = getCityCode($citymun);
            $sql .= ' AND (patient_contact.city = "'.$brgy_code.'")';
            $searchkey .= " in the city of ".$citymun." ";
        }
        if($diagnosis OR $medicalorder OR $healthcare_services) {
            $select .= ", healthcare_services.healthcareservice_id AS hservice_id, disposition.disposition ";
            $arg .= " LEFT JOIN healthcare_services ON healthcare_services.facilitypatientuser_id = facility_patient_user.facilitypatientuser_id LEFT JOIN disposition ON healthcare_services.healthcareservice_id = disposition.healthcareservice_id ";
        }
        if($healthcare_services) {
            $sql .= ' AND (healthcare_services.healthcareservicetype_id LIKE "%'.$healthcare_services.'%")';
            $searchkey .= " with Clinical Service of ".$healthcare_services." ";
        }
        if($diagnosis) {
            $select .= ", diagnosis.diagnosislist_id ";
            $sql .= ' AND (diagnosis.diagnosislist_id LIKE "%'.$diagnosis.'%")';
            $arg .= " LEFT JOIN diagnosis ON diagnosis.healthcareservice_id = healthcare_services.healthcareservice_id ";
            $searchkey .= " with diagnosis of ".$diagnosis." ";
        }
        if($medicalorder) {
            $select .= ", medicalorder.medicalorder_type ";
            $sql .= ' AND (medicalorder.medicalorder_type = "'.$medicalorder.'")';
            $arg .= " LEFT JOIN medicalorder ON medicalorder.healthcareservice_id = healthcare_services.healthcareservice_id ";
            if($medicalorder == 'MO_LAB_TEST') {
                $arg .= " LEFT JOIN medicalorder_laboratoryexam ON medicalorder.medicalorder_id = medicalorder_laboratoryexam.medicalorder_id ";
            }
            if($medicalorder == 'MO_MED_PRESCRIPTION') {
                $arg .= " LEFT JOIN medicalorder_prescription ON medicalorder.medicalorder_id = medicalorder_prescription.medicalorder_id ";
            }
            $searchkey .= " given a ".getOrderTypeName($medicalorder)." ";
        }

        $sql .= ' ORDER BY patients.last_name asc ';
        $patients = DB::select( $select.$arg.$sql );
//dd($patients);
        return view('records::pages.searchResults', compact('patients', 'searchkey'));
    }

    public function getList($action, $value)
    {
        $facilityInfo = Session::get('user_details');
        $arg = "SELECT * FROM patients JOIN patient_contact ON patient_contact.patient_id = patients.patient_id JOIN facility_patient_user ON patients.patient_id = facility_patient_user.patient_id JOIN facility_user ON facility_patient_user.facilityuser_id = facility_user.facilityuser_id ";
        $sql = " WHERE facility_user.facility_id = '".$facilityInfo->facilityUser[0]->facility_id."' AND  patients.deleted_at IS NULL";

        if($action == 'sex') {
            if($value == "M") {
                $v = "Male";
                $sql .= ' AND (patients.gender = "'.$value.'")';
            } elseif($value == "F") {
                $v = "Female";
                $sql .= ' AND (patients.gender = "'.$value.'")';
            } else {
                $v = "Unknown";
                $sql .= ' AND (patients.gender IS NULL)';
            }

            $searchkey = " patients with gender ".$v;
        }
        if($action == 'agerange') {
            $ages = explode("-", $value);
            $now = date('Y');
            if($value == 'NA') {
                $sql .= " AND patients.birthdate IS NULL ";
                $searchkey = " patients with unknown age ";
            } else {
                $minage = $now - $ages[1];
                $maxage = $now - $ages[0];
                $sql .= " AND (YEAR(patients.birthdate) > ".$minage." AND YEAR(patients.birthdate) <= ".$maxage.") ";
                $searchkey = " patients with ages between ".$value." ";
            }
        }

        $sql .= ' ORDER BY patients.last_name asc ';
        $patients = DB::select( $arg.$sql );

        return view('records::pages.searchResults', compact('patients', 'searchkey'));
    }

}
