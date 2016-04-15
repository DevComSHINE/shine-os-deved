<?php
namespace ShineOS\Core\Patients\Http\Controllers;

use Illuminate\Routing\Controller;

use Shine\Plugin;
use Shine\Libraries\Utils\Lovs;
use Shine\Libraries\Utils;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\UserHelper;
use Shine\Repositories\Eloquent\FacilityRepository as FacilityRepository;
use ShineOS\Core\Patients\Entities\FacilityPatientUser;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Patients\Entities\PatientAlert;
use ShineOS\Core\Patients\Entities\PatientAllergies;
use ShineOS\Core\Patients\Entities\PatientContacts;
use ShineOS\Core\Patients\Entities\PatientDisabilities;
use ShineOS\Core\Patients\Entities\PatientDeathInfo;
use ShineOS\Core\Patients\Entities\PatientEmergencyInfo;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\GeneralConsultation;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Healthcareservices\Entities\VitalsPhysical;
use ShineOS\Core\LOV\Http\Controllers\LOVController;


use View, Form, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Request, Storage, Schema;
/**
 * Contains instances related to Patients Module
 */
class PatientsController extends Controller {

    protected $moduleName = 'Patients';
    protected $modulePath = 'patients';
    protected $viewPath = 'patients::pages.';
    protected $formPath = 'patients::pages.forms.';

    private $id = "";
    private $patient_alert_id = "";
    private $facilityuser_id = "";
    private $user_id = "";

    private $FacilityRepository;

    /**
     * Load global variables and authentication
     *
     * @return void
     */
    public function __construct(FacilityRepository $FacilityRepository)
    {
        $this->middleware('auth');

        $modules =  Utils::getModules();

        # variables to share to all view
        View::share('modules', $modules);
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);

        $this->FacilityRepository = $FacilityRepository;
    }

    /**
     * Redirect to records view
     * @return [view]
     */
    public function index()
    {
        //$patients = Patients::with('healthcareservices')->get();
        return Redirect::to('records');
    }

    /**
     * Shows add patient form
     * @return [view] with Medical History, Action, Region, Disabilities, Allergy Reactions, Religions and Education
     */
    public function add()
    {
        $data = array();
        $utilities = new Utils;
        $disabilities = Lovs::getLovs('disabilities');
        $allergyReactions = Lovs::getLovs('allergy_reaction');
        $religion = $utilities->religion();
        $education = $utilities->education();
        $action = 'add';

        return view($this->formPath.'add',compact('medical_history','action','disabilities','allergyReactions','religion','education'))->with($data);
    }

    /**
     * A method to save add patient form values
     * @return [view] Redirects to list page with message
     */
    // revised by Romel
    public function save()
    {
        /**
         * NOTE:: Create a library for this
         * @var Patients
         */

        $patient = new Patients;
        $patient->patient_id = IdGenerator::generateId();
        $id = $patient->patient_id;
        $patient->first_name = Input::get('inputPatientFirstName');
        $patient->last_name = Input::get('inputPatientLastName');
        $patient->middle_name = Input::get('inputPatientMiddleName');
        $patient->maiden_lastname = Input::get('inputMaidenLastName');
        $patient->maiden_middlename = Input::get('inputMaidenMiddleName');
        $patient->name_suffix = Input::has('inputPatientSuffix');
        $patient->gender = Input::get('inputPatientGender');
        $patient->civil_status = Input::get('inputPatientStatus');
        $patient->birthdate = date("Y-m-d", strtotime(Input::get('inputPatientBirthDate'))); /*RJBS*/
        $patient->birthtime = date("H:i:s", strtotime(Input::get('inputPatientBirthTime'))); /*RJBS*/
        $patient->birthplace = Input::get('inputPatientBirthPlace');
        $patient->highest_education = Input::get('inputPatientEducation');
        $patient->highesteducation_others = Input::get('inputPatientEducationOther');
        $patient->religion = Input::get('inputPatientReligion');
        $patient->religion_others = Input::get('inputPatientOtherReligion');
        $patient->nationality = Input::get('inputPatientNationality');
        $patient->blood_type = Input::get('inputPatientBloodType');
        $patient->broadcast_notif = Input::has('inputBroadcastNotif');
        $patient->referral_notif = Input::has('inputReferralNotif');
        $patient->nonreferral_notif = Input::has('inputNonReferralNotif');
        $patient->myshine_acct = Input::has('inputMyShineAcct');
        $patient->patient_consent = Input::has('inputPatientConsent');

        $patient->save();

        /**
         * Get last inserted ID
         *
         * @var patient_id
         */
        $user_id = Auth::user()->user_id;

        $facility_id = FacilityHelper::facilityInfo();
        $facilityuser_id = FacilityHelper::facilityUserId($user_id, $facility_id->facility_id); // get user id

        $facilityPatientUser = new FacilityPatientUser(); //transfer to facility module? change this.
        $facilityPatientUser->facilitypatientuser_id = IdGenerator::generateId();
        $facilityPatientUser->patient_id = $id;
        $facilityPatientUser->facilityuser_id = $facilityuser_id->facilityuser_id; // change to $facility['facility_id'] ( session );
        $facilityPatientUser->save();

        /**
         * Add Patient Contact Info
         *
         * @var Patient Contact
         */

        $contactInfo = new PatientContacts; // change to singular
        $contactInfo->patient_id = $id;
        $contactInfo->patient_contact_id = IdGenerator::generateId();
        $contactInfo->street_address = Input::get('inputPatientAddress');
        $contactInfo->barangay = Input::get('brgy');
        $contactInfo->city = Input::has('city');
        $contactInfo->province = Input::get('province');
        $contactInfo->region = Input::get('region');
        $contactInfo->country = Input::get('inputPatientCountry');
        $contactInfo->zip = Input::has('inputPatientZip');
        $contactInfo->phone = Input::get('inputPatientPhone');
        $contactInfo->phone_ext = Input::get('inputPatientPhoneExtension');
        $contactInfo->mobile = Input::get('inputPatientMobile');
        $contactInfo->email = Input::get('inputPatientEmail');
        $contactInfo->save();

        /**
         * Add Patient Alerts
         *
         * After inserting to patient_alert table, insert to allergies and disabilities
         */

        $alerts = Input::get('alert');
        $alerts_id = '';

        for($i=0; count($alerts) > $i; $i++)
        {
            $alert = new PatientAlert;
            $alert->patient_id = $id;
            $alert->patient_alert_id = IdGenerator::generateId();
            $patient_alert_id = $alert->patient_alert_id;
            $alert->alert_type_other = ($alerts[$i] == "OTHER") ? Input::get('inputAlertOthers') : "";
            $alert->alert_type = $alerts[$i];

            if ($alerts[$i] == "ALLER")
            {
                //check if we are receiving a blank form
                $aller = Input::get('allergy');
                if(!empty($aller['inputAllergyName'][0])) {
                    $alert->save();
                    $this->saveAllergies($patient_alert_id);
                }
            }
            else if ($alerts[$i] == "DISAB")
            {
                $alert->save();
                $this->saveDisabilities($patient_alert_id);
            } else {
                $alert->save();
            }
        }

        # save diseases
        //Diseases::savePatientDiseases($id);
        Session::flash('alert-class', 'alert-success alert-dismissible');
        $message = "A new patient has been added";

        return Redirect::to($this->modulePath."/view/".$id)->with('message', $message);
    }

    public function saveAllergies($id)
    {
        $allergyList = Input::get('allergy');

        for($i=0; count($allergyList['inputAllergyName']) > $i; $i++):
            if(!empty($allergyList['inputAllergyName'][$i])):
                $allergies = new PatientAllergies;
                $allergies->allergy_patient_id = IdGenerator::generateId();
                $allergies->patient_alert_id = $id;
                $allergies->allergy_id = $allergyList['inputAllergyName'][$i];
                $allergies->allergy_reaction_id = isset($allergyList['inputAllergyReaction'][$i]) ? $allergyList['inputAllergyReaction'][$i] : NULL;
                $allergies->allergy_severity = isset($allergyList['inputAllergySeverity'][$i]) ? $allergyList['inputAllergySeverity'][$i] : NULL;
                $allergies->save();
            endif;
        endfor;
    }

    public function saveDisabilities($id)
    {
        $disability_list = Input::get('disability');

        for($i=0; count($disability_list) > $i; $i++):
            $disabilities = new PatientDisabilities;
            $disabilities->disability_patient_id = IdGenerator::generateId();
            $disabilities->patient_alert_id = $id;
            $disabilities->disability_id = $disability_list[$i];
            $disabilities->save();
        endfor;
    }

    public function view($id)
    {
        $data = array();
        $utilities = new Utils;
        $disabilities = Lovs::getLovs('disabilities');
        $allergyReactions = Lovs::getLovs('allergy_reaction');
        $religion = $utilities->religion();
        $education = $utilities->education();

        $patient = getCompletePatientByPatientID($id);

        $facility = Session::get('facility_details');
        $roles = Session::get('roles');

        //Developer Edition implementation
        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        //**Production implementation should come from the database of activated plugins.
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array();
        foreach($plugins as $k=>$plugin) {
            $pdata = NULL;
            if(strpos($plugin, ".")===false) { //isolate folders
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    //load the config file
                    include(plugins_path().$plugin.'/config.php');

                    //check if this folder is enabled
                    if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){

                        //get only plugins for this module
                        if($plugin_module == 'patients'){
                            if($plugin_table == 'plugintable') {
                                $pdata = Plugin::where('primary_key_value',$id)->first();
                            } else {
                                if (Schema::hasTable($plugin_table)) {
                                    $pdata = DB::table($plugin_table)->where($plugin_primaryKey, $id)->first();
                                }
                            }
                            $plugs[$k]['plugin_location'] = $plugin_location;
                            $plugs[$k]['folder'] = $plugin;
                            $plugs[$k]['parent'] = $plugin_module;
                            $plugs[$k]['title'] = $plugin_title;
                            $plugs[$k]['plugin'] = $plugin_id;
                            $plugs[$k]['pdata'] = $pdata;
                        }
                    }
                }
            }
        }
        $action = 'view';

        /*
        * Let us sort the plugins those with data first
        *
        */
        sortBy('pdata', $plugs, 'desc');

        if($patient):
            return view($this->viewPath.'view', compact('plugs','action','patient','disabilities','allergyReactions','bloodType','religion', 'education'))->with($data);
        else:
            Session::flash('alert-class', 'alert-danger alert-dismissible');
            $message = "The patient profile does not exist. Please choose another.";

            return Redirect::to('records')->with('message', $message);
        endif;
    }

    public function dashboard($id)
    {
        $data = array();
        $utilities = new Utils;
        $disabilities = Lovs::getLovs('disabilities');
        $allergyReactions = Lovs::getLovs('allergy_reaction');
        $religion = $utilities->religion();
        $education = $utilities->education();

        $patient = findHealthRecordByPatientID($id);

        //let us collect consultation history for this patient
        //for table display
        $data['hc_history'] =[];
        if($patient->healthcareservices) {
            foreach($patient->healthcareservices as $k=>$hc){
                if($k > 0) {
                    $data['hc_history'][$k]['healthcareservice_id'] = $hc->healthcareservice_id;
                    $data['hc_history'][$k]['dater'] = strtotime($hc->encounter_datetime);
                    $data['hc_history'][$k]['type'] = $hc->healthcareservicetype_id;
                    $data['hc_history'][$k]['diagnosis_type'] = getDiagnosisByHealthServiceID($hc->healthcareservice_id);
                    $data['hc_history'][$k]['consultype'] = $hc->consultation_type;
                    $data['hc_history'][$k]['seen'] = findUserByFacilityUserID( $hc->seen_by );
                }
            }
        }

        //get latest consultation DATA
        if(isset($patient->healthcareservices[0]))
        {
            $data['currentConsultation'] = $latestConsultation = $patient->healthcareservices[0];
            $data['currentVitals'] = VitalsPhysical::where('healthcareservice_id', $latestConsultation->healthcareservice_id)->first();

            if($latestConsultation->healthcareservicetype_id == 'GeneralConsultation') {
                $data['currentConsultationData'] = GeneralConsultation::where('healthcareservice_id', $latestConsultation->healthcareservice_id)->first();
            }
            $data['currentVitals'] = VitalsPhysical::where('healthcareservice_id', $latestConsultation->healthcareservice_id)->first();
            $facilityInfo = findFacilityByFacilityID( $latestConsultation->seen_by );
            $seenBy = findUserByFacilityUserID( $latestConsultation->seen_by );
        }

        $action = 'view';
        $patientsmonitoring = Patients::with('patientMonitoring')->where('patient_id',$id)->get();
        foreach ($patientsmonitoring as $monitoringkey => $monitoringvalue) {
            $data['patients_monitoring'] = $monitoringvalue->patientMonitoring;
               foreach ($monitoringvalue->patientMonitoring as $mkey => $mvalue) {
                    $LOVController = new LOVController();
                    $mvalue->bloodpressure_assessment_name = $LOVController->bloodpressure_assessment_name($mvalue->bloodpressure_assessment);
               }
        }
        $data['creator'] = findCreatedByFacilityUserID($id);

        return view($this->viewPath.'dashboard', compact('action','patient','regions','disabilities','allergyReactions','bloodType','religion', 'education', 'seenBy', 'facilityInfo'))->with($data);
    }

    /**
     *  To be refurbished. Rename view to edit.
     */
    // public function edit($id)
    // {

    // }

    // revised by Romel
    public function update($id)
    {
        //update Patient info
        $updatePatient = array(
            "first_name" => Input::get('inputPatientFirstName'),
            "last_name" => Input::get('inputPatientLastName'),
            "middle_name" => Input::get('inputPatientMiddleName'),
            "maiden_lastname" => Input::get('inputMaidenLastName'),
            "maiden_middlename" => Input::get('inputMaidenMiddleName'),
            "name_suffix" => Input::has('inputPatientSuffix'),
            "gender" => Input::get('inputPatientGender'),
            "civil_status" => Input::get('inputPatientStatus'),
            "birthdate" => date("Y-m-d", strtotime(Input::get('inputPatientBirthDate'))),
            "birthtime" => date("H:i:s", strtotime(Input::get('inputPatientBirthTime'))),
            "birthplace" => Input::get('inputPatientBirthPlace'),
            "highest_education" => Input::get('inputPatientEducation'),
            "highesteducation_others" => Input::get('inputPatientEducationOther'),
            "religion" => Input::get('inputPatientReligion'),
            "religion_others" => Input::get('inputPatientOtherReligion'),
            "nationality" => Input::get('inputPatientNationality'),
            "blood_type" => Input::get('inputPatientBloodType'),
            "broadcast_notif" => Input::has('inputBroadcastNotif'),
            "referral_notif" => Input::has('inputReferralNotif'),
            "nonreferral_notif" => Input::has('inputNonReferralNotif'),
            "myshine_acct" => Input::has('inputMyShineAcct'),
            "patient_consent" => Input::has('inputPatientConsent')
        );

        Patients::where('patient_id', $id)
            ->update($updatePatient);

        //update Contact info
        //let us check if it exist
        $checks = PatientContacts::where('patient_id', $id)->first();
        $updateContacts = array(
            "street_address" => Input::get('inputPatientAddress'),
            "barangay" => Input::get('brgy'),
            "city" => Input::get('city'),
            "province" => Input::get('province'),
            "region" => Input::get('region'),
            "country" => Input::get('inputPatientCountry'),
            "zip" => Input::get('inputPatientZip'),
            "phone" => Input::get('inputPatientPhone'),
            "phone_ext" => Input::get('inputPatientPhoneExtension'),
            "mobile" => Input::get('inputPatientMobile'),
            "email" => Input::get('inputPatientEmail')
        );
        if($checks) {
            PatientContacts::where('patient_id', $id)
            ->update($updateContacts);
        } else {
            $contact = new PatientContacts;
            $contact->patient_contact_id = IdGenerator::generateId();
            $contact->patient_id = $id;
            $contact->street_address = Input::get('inputPatientAddress');
            $contact->barangay = Input::get('brgy');
            $contact->city = Input::get('city');
            $contact->province = Input::get('province');
            $contact->region = Input::get('region');
            $contact->country = Input::get('inputPatientCountry');
            $contact->zip = Input::get('inputPatientZip');
            $contact->phone = Input::get('inputPatientPhone');
            $contact->phone_ext = Input::get('inputPatientPhoneExtension');
            $contact->mobile = Input::get('inputPatientMobile');
            $contact->email = Input::get('inputPatientEmail');
            $contact->save();
        }

        //update Contact info
        //let us check if it exist
        $checkEmer = PatientEmergencyInfo::where('patient_id', $id)->first();
        $updateEmergency = array(
            "emergency_name" => Input::get('emergency_name'),
            "emergency_relationship" => Input::get('emergency_relationship'),
            "emergency_phone" => Input::get('emergency_phone'),
            "emergency_mobile" => Input::get('emergency_mobile'),
            "emergency_address" => Input::get('emergency_address')
        );
        if($checkEmer) {
            PatientEmergencyInfo::where('patient_id', $id)
            ->update($updateEmergency);
        } else {
            $emer = new PatientEmergencyInfo;
            $emer->patient_emergencyinfo_id = IdGenerator::generateId();
            $emer->patient_id = $id;
            $emer->emergency_name = Input::get('emergency_name');
            $emer->emergency_relationship = Input::get('emergency_relationship');
            $emer->emergency_phone = Input::get('emergency_phone');
            $emer->emergency_mobile = Input::get('emergency_mobile');
            $emer->emergency_address = Input::get('emergency_address');
            $emer->save();
        }

        $file = array('profile_picture' => Input::file('profile_picture'));
        $rules = array('profile_picture' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        $validator = Validator::make($file, $rules);
        $profile_picture = Input::file('profile_picture');
        if($profile_picture!=NULL || !empty($profile_picture)) {
            if ($profile_picture->isValid()) {
                $destinationPath = upload_base_path().'patients'; // upload path
                $extension = Input::file('profile_picture')->getClientOriginalExtension();
                $fileName = "profile_".rand(11111,99999).'_'.date('YmdHis').'.'.$extension;
                $originalName = Input::file('profile_picture')->getClientOriginalName();
                Input::file('profile_picture')->move($destinationPath, $fileName);

                // update profile picture
                Patients::updatePatientPicture($id, $fileName);

            }
        }

        //delete all allergies and disabilities
        //get first all patient alerts
        $allAlerts = PatientAlert::where('patient_id', $id)->get();
        foreach($allAlerts as $thisAlert) {
            if($thisAlert->alert_type == "ALLER") {
                $deleteAllAllergies = PatientAllergies::where(['patient_alert_id'=>$thisAlert->patient_alert_id])->forceDelete();
            }
            if($thisAlert->alert_type == "DISAB") {
                $deleteAllDisabilities = PatientDisabilities::where(['patient_alert_id'=>$thisAlert->patient_alert_id])->forceDelete();
            }
        }
        //delete all alerts for this patient
        //then re-save this post
        $deleteAllPatientAlert = PatientAlert::where('patient_id', $id)->forceDelete();
        $alerts = Input::get('alert');
        $alerts_id = '';

        for($i=0; count($alerts) > $i; $i++)
        {
            $alert = new PatientAlert;
            $alert->patient_id = $id;
            $alert->patient_alert_id = IdGenerator::generateId();
            $patient_alert_id = $alert->patient_alert_id;
            $alert->alert_type_other = ($alerts[$i] == "OTHER") ? Input::get('inputAlertOthers') : "";
            $alert->alert_type = $alerts[$i];

            if ($alerts[$i] == "ALLER")
            {
                //check if we are receiving a blank form
                //if not empty then save data
                $aller = Input::get('allergy');
                if(!empty($aller['inputAllergyName'][0])) {
                    $alert->save();
                    $this->saveAllergies($patient_alert_id);
                }
            }
            else if ($alerts[$i] == "DISAB")
            {
                $alert->save();
                $this->saveDisabilities($patient_alert_id);
            } else {
                $alert->save();
            }
        }

        Session::flash('alert-class', 'alert-success alert-dismissible');
        $message = "The patient profile has been updated.";

        return Redirect::to($this->modulePath.'/view/'.$id)->with('message', $message);
    }

    public function uploadCameraPhoto($id)
    {
        $filename = md5($_SERVER['REMOTE_ADDR'].rand()).'.jpg';
        $folder = 'public/uploads/patients';

        $original = $folder.$filename;
        $input = file_get_contents('php://input');

        $newfile = "profile_".rand(11111,99999).'_'.date('YmdHis').'.jpg';

        if(md5($input) == '7d4df9cc423720b7f1f3d672b89362be'){
            // Blank image. We don't need this one.
            exit;
        }

        $result = file_put_contents($original, $input);
        if (!$result) {
            echo '{
                "error"     : 1,
                "message"   : "Failed save the image. Make sure you chmod the uploads folder and its subfolders to 777."
            }';
            exit;
        }

        $info = getimagesize($original);
        if($info['mime'] != 'image/jpeg'){
            unlink($original);
            exit;
        }

        // Moving the temporary file to the originals folder:
        $u = rename($original, 'public/uploads/patients/'.$newfile);

        if($u){
            // update profile picture
            Patients::updatePatientPicture($id, $fileName);
        }

        return Redirect::to('patients/view/'.$id);
    }

    public function deathInfo($id)
    {
        return view($this->viewPath.'view');
    }

    public function checkPatientMorbidity($id)
    {
        $patient = PatientDeathInfo::where('patient_id','=', $id)->count();

        if ($patient > 0)
        {
            echo true;
        }

        echo false;
    }

    public function saveDeathInfo()
    {
        $id = Input::get('patient_id');
        if($id!=NULL) {
            $isDead = $this->checkPatientMorbidity($id);

            if ($isDead == false):

                $patientDeathInfo = new PatientDeathInfo;
                $patientDeathInfo->patient_deathinfo_id = IdGenerator::generateId();
                $patientDeathInfo->patient_id = $id;

                $patientDeathInfo->DeathCertificate_Filename = Input::get('inputDeathCertificate');
                $patientDeathInfo->DeathCertificateNo = Input::get('DeathCertificateNo');
                $patientDeathInfo->datetime_death = (new Datetime(Input::get('inputDateTimeDeath')))->format('Y-m-d H:i:s');
                $patientDeathInfo->PlaceDeath = Input::get('deathPlaceType');
                $patientDeathInfo->PlaceDeath_FacilityBased = Input::get('deathplace_FB');
                $patientDeathInfo->PlaceDeath_NID = Input::get('deathplace_NID');
                $patientDeathInfo->PlaceDeath_NID_Others_Specify = Input::get('deathplace_NID_Others');
                $patientDeathInfo->mStageDeath = Input::get('inputMaternalDeath');
                $patientDeathInfo->Immediate_Cause_of_Death = Input::get('Immediate_Cause_of_Death');
                $patientDeathInfo->Antecedent_Cause_of_Death = Input::get('Antecedent_Cause_of_Death');
                $patientDeathInfo->Underlying_Cause_of_Death = Input::get('Underlying_Cause_of_Death');
                $patientDeathInfo->Type_of_Death = Input::get('inputTypeofDeath');
                $patientDeathInfo->Remarks = Input::get('inputCauseofDeathNotes');

                $patientDeathInfo->save();

                Session::flash('alert-class', 'alert-success alert-dismissible');
                $message = "The patient is now dead.";

            else:

                Session::flash('alert-class', 'alert-danger alert-dismissible');
                $message = "The patient is already dead.";

            endif;
        } else {
            Session::flash('alert-class', 'alert-danger alert-dismissible');
            $message = "Patient not found.";
        }

        return Redirect::to('records')->with('message', $message);
    }

    public function delete($id)
    {
        $user = UserHelper::getUserInfo();

        $facilityInfo = FacilityHelper::facilityInfo();
        $facilityUser = FacilityHelper::facilityUserId($user->user_id, $facilityInfo->facility_id);
        $facpatid = FacilityPatientUser::where('facilityuser_id', $facilityUser->facilityuser_id)->first();

        $deletePatient = Patients::destroy($id);
        $deleteFacilityPatientUser = FacilityPatientUser::where('facilitypatientuser_id', $facpatid->facilitypatientuser_id)->delete();
        $deleteHealthCareServices = HealthCareServices::where('facilitypatientuser_id', $facpatid->facilitypatientuser_id)->get();

        if ($deletePatient && $deleteFacilityPatientUser) :
            Session::flash('alert-class', 'alert-success alert-dismissible');
            $message = "Successfully Deleted a Patient.";
        else:
            Session::flash('alert-class', 'alert-danger alert-dismissible');
            $message = "An error was encountered while deleting the user. Kindly try again.";
        endif;

        return Redirect::to('records')->with('message', $message);
    }

    public static function patientDetails($id)
    {
        $patient = Patients::find($id)->first();

        return $patient;
    }

    public function check()
    {
        $firstname = Input::get('inputPatientFirstName');
        $lastname = Input::get('inputPatientLastName');
        $middlename = Input::get('inputPatientMiddleName');
        $birthdate = date("Y-m-d", strtotime(Input::get('inputPatientBirthDate')));


        $patient = DB::table('patients')
            ->join('facility_patient_user', 'patients.patient_id', '=', 'facility_patient_user.patient_id')
            ->join('facility_user', 'facility_patient_user.facilityuser_id', '=', 'facility_user.facilityuser_id')
            ->join('facilities', 'facility_user.facility_id', '=', 'facilities.facility_id')
            ->where('patients.first_name','like', '%'.$firstname.'%')
            ->where('patients.last_name','like', '%'.$lastname.'%')
            ->where('patients.middle_name','like', '%'.$middlename.'%')
            ->where('patients.birthdate','=', $birthdate)
           ->get();

        if($patient) {
            $p = json_encode($patient);
            echo $p; //trim($p, "[]");
        } else {
            echo '{"firstname" : "none"}';
        }

        exit;
    }

    private function print_this( $data = array(), $title = '' )
    {
        echo "<hr /><h2>{$title}</h2><pre>";
        print_r($data);
        echo "</pre>";
    }

    public function uploadCameraPhotoxx($lastname, $patientid)
    {
        $file = array('profile_picture' => Input::file('profile_picture'));
        $rules = array('profile_picture' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        $validator = Validator::make($file, $rules);
        if (Input::file('profile_picture')->isValid()) {
            $destinationPath = 'uploads/profile_picture'; // upload path
            $extension = Input::file('profile_picture')->getClientOriginalExtension();
            $fileName = "profile_".rand(11111,99999).'_'.date('YmdHis').'.'.$extension;
            $originalName = Input::file('profile_picture')->getClientOriginalName();
            Input::file('profile_picture')->move($destinationPath, $fileName);

            // update profile picture
            Users::updateProfilePicture($id, $fileName);

            Session::flash('message', 'Your profile picture has been successfully added.');
            return Redirect::to("users/changeprofilepic/{$id}");
        }

    }
}
