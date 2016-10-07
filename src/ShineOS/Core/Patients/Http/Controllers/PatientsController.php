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
use ShineOS\Core\Patients\Entities\PatientMedicalHistory;
use ShineOS\Core\Patients\Entities\LovHistoryModel;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\GeneralConsultation;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Healthcareservices\Entities\VitalsPhysical;
use ShineOS\Core\LOV\Http\Controllers\LOVController;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrder;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrderLabExam;
use ShineOS\Core\LOV\Entities\LovLaboratories;
use ShineOS\Core\Users\Entities\ForgotPassword;
use Shine\Libraries\EmailHelper;
use ShineOS\Core\Users\Libraries\Salt;

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
        $modules =  Utils::getModules();

        # variables to share to all view
        View::share('modules', $modules);
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);

        $this->FacilityRepository = $FacilityRepository;

        $this->arrNationality = array("Afghanistan"=>"AFG", 
                                "Aland Islands"=>"ALA", 
                                "Albania"=>"ALB", 
                                "Algeria"=>"DZA", 
                                "American Samoa"=>"ASM", 
                                "Andorra"=>"AND", 
                                "Angola"=>"AGO", 
                                "Anguilla"=>"AIA", 
                                "Antarctica"=>"ATA", 
                                "Antigua and Barbuda"=>"ATG", 
                                "Argentina"=>"ARG", 
                                "Armenia"=>"ARM", 
                                "Aruba"=>"ABW", 
                                "Australia"=>"AUS", 
                                "Austria"=>"AUT", 
                                "Azerbaijan"=>"AZE", 
                                "Bahamas"=>"BHS", 
                                "Bahrain"=>"BHR", 
                                "Bangladesh"=>"BGD", 
                                "Barbados"=>"BRB", 
                                "Belarus"=>"BLR", 
                                "Belgium"=>"BEL", 
                                "Belize"=>"BLZ", 
                                "Benin"=>"BEN", 
                                "Bermuda"=>"BMU", 
                                "Bhutan"=>"BTN", 
                                "Plurinational State of Bolivia"=>"BOL", 
                                "Bonaire - Sint Eustatius and Saba"=>"BES", 
                                "Bosnia and Herzegovina"=>"BIH", 
                                "Botswana"=>"BWA", 
                                "Bouvet Island"=>"BVT", 
                                "Brazil"=>"BRA", 
                                "British Indian Ocean Territory"=>"IOT", 
                                "Brunei Darussalam"=>"BRN", 
                                "Bulgaria"=>"BGR", 
                                "Burkina Faso"=>"BFA", 
                                "Burundi"=>"BDI", 
                                "Cambodia"=>"KHM", 
                                "Cameroon"=>"CMR", 
                                "Canada"=>"CAN", 
                                "Cabo Verde"=>"CPV", 
                                "Cayman Islands"=>"CYM", 
                                "Central African Republic"=>"CAF", 
                                "Chad"=>"TCD", 
                                "Chile"=>"CHL", 
                                "China"=>"CHN", 
                                "Christmas Island"=>"CXR", 
                                "Cocos (Keeling) Islands"=>"CCK", 
                                "Colombia"=>"COL", 
                                "Comoros"=>"COM", 
                                "Congo"=>"COG", 
                                "Democratic Republic of Congo"=>"COD", 
                                "Cook Islands"=>"COK", 
                                "Costa Rica"=>"CRI", 
                                "Cote d'Ivoire"=>"CIV", 
                                "Croatia"=>"HRV", 
                                "Cuba"=>"CUB", 
                                "Curacao !Cura ao"=>"CUW", 
                                "Cyprus"=>"CYP", 
                                "Czech Republic"=>"CZE", 
                                "Denmark"=>"DNK", 
                                "Djibouti"=>"DJI", 
                                "Dominica"=>"DMA", 
                                "Dominican Republic"=>"DOM", 
                                "Ecuador"=>"ECU", 
                                "Egypt"=>"EGY", 
                                "El Salvador"=>"SLV", 
                                "Equatorial Guinea"=>"GNQ", 
                                "Eritrea"=>"ERI", 
                                "Estonia"=>"EST", 
                                "Ethiopia"=>"ETH", 
                                "Falkland Islands (Malvinas)"=>"FLK", 
                                "Faroe Islands"=>"FRO", 
                                "Fiji"=>"FJI", 
                                "Finland"=>"FIN", 
                                "France"=>"FRA", 
                                "French Guiana"=>"GUF", 
                                "French Polynesia"=>"PYF", 
                                "French Southern Territories"=>"ATF", 
                                "Gabon"=>"GAB", 
                                "Gambia"=>"GMB", 
                                "Georgia"=>"GEO", 
                                "Germany"=>"DEU", 
                                "Ghana"=>"GHA", 
                                "Gibraltar"=>"GIB", 
                                "Greece"=>"GRC", 
                                "Greenland"=>"GRL", 
                                "Grenada"=>"GRD", 
                                "Guadeloupe"=>"GLP", 
                                "Guam"=>"GUM", 
                                "Guatemala"=>"GTM", 
                                "Guernsey"=>"GGY", 
                                "Guinea"=>"GIN", 
                                "Guinea-Bissau"=>"GNB", 
                                "Guyana"=>"GUY", 
                                "Haiti"=>"HTI", 
                                "Heard Island and McDonald Islands"=>"HMD", 
                                "Holy See (Vatican City State)"=>"VAT", 
                                "Honduras"=>"HND", 
                                "Hong Kong"=>"HKG", 
                                "Hungary"=>"HUN", 
                                "Iceland"=>"ISL", 
                                "India"=>"IND", 
                                "Indonesia"=>"IDN", 
                                "Islamic Republic of Iran"=>"IRN", 
                                "Iraq"=>"IRQ", 
                                "Ireland"=>"IRL", 
                                "Isle of Man"=>"IMN", 
                                "Israel"=>"ISR", 
                                "Italy"=>"ITA", 
                                "Jamaica"=>"JAM", 
                                "Japan"=>"JPN", 
                                "Jersey"=>"JEY", 
                                "Jordan"=>"JOR", 
                                "Kazakhstan"=>"KAZ", 
                                "Kenya"=>"KEN", 
                                "Kiribati"=>"KIR", 
                                "Democratic People's Republic of Korea"=>"PRK", 
                                "Republic of Korea"=>"KOR", 
                                "Kuwait"=>"KWT", 
                                "Kyrgyzstan"=>"KGZ", 
                                "Lao People's Democratic Republic"=>"LAO", 
                                "Latvia"=>"LVA", 
                                "Lebanon"=>"LBN", 
                                "Lesotho"=>"LSO", 
                                "Liberia"=>"LBR", 
                                "Libya"=>"LBY", 
                                "Liechtenstein"=>"LIE", 
                                "Lithuania"=>"LTU", 
                                "Luxembourg"=>"LUX", 
                                "Macao"=>"MAC", 
                                "Macedonia (the former Yugoslav Republic of)"=>"MKD", 
                                "Madagascar"=>"MDG", 
                                "Malawi"=>"MWI", 
                                "Malaysia"=>"MYS", 
                                "Maldives"=>"MDV", 
                                "Mali"=>"MLI", 
                                "Malta"=>"MLT", 
                                "Marshall Islands"=>"MHL", 
                                "Martinique"=>"MTQ", 
                                "Mauritania"=>"MRT", 
                                "Mauritius"=>"MUS", 
                                "Mayotte"=>"MYT", 
                                "Mexico"=>"MEX", 
                                "Micronesia"=>"FSM", 
                                "Moldova, Republic of"=>"MDA", 
                                "Monaco"=>"MCO", 
                                "Mongolia"=>"MNG", 
                                "Montenegro"=>"MNE", 
                                "Montserrat"=>"MSR", 
                                "Morocco"=>"MAR", 
                                "Mozambique"=>"MOZ", 
                                "Myanmar"=>"MMR", 
                                "Namibia"=>"NAM", 
                                "Nauru"=>"NRU", 
                                "Nepal"=>"NPL", 
                                "Netherlands"=>"NLD", 
                                "New Caledonia"=>"NCL", 
                                "New Zealand"=>"NZL", 
                                "Nicaragua"=>"NIC", 
                                "Niger"=>"NER", 
                                "Nigeria"=>"NGA", 
                                "Niue"=>"NIU", 
                                "Norfolk Island"=>"NFK", 
                                "Northern Mariana Islands"=>"MNP", 
                                "Norway"=>"NOR", 
                                "Oman"=>"OMN", 
                                "Pakistan"=>"PAK", 
                                "Palau"=>"PLW", 
                                "Palestine, State of"=>"PSE", 
                                "Panama"=>"PAN", 
                                "Papua New Guinea"=>"PNG", 
                                "Paraguay"=>"PRY", 
                                "Peru"=>"PER", 
                                "Philippines"=>"PHL", 
                                "Pitcairn"=>"PCN", 
                                "Poland"=>"POL", 
                                "Portugal"=>"PRT", 
                                "Puerto Rico"=>"PRI", 
                                "Qatar"=>"QAT", 
                                "Reunion !RŽunion"=>"REU", 
                                "Romania"=>"ROU", 
                                "Russian Federation"=>"RUS", 
                                "Rwanda"=>"RWA", 
                                "Saint Barthelemy"=>"BLM", 
                                "Saint Helena (Ascension and Tristan da Cunha)"=>"SHN", 
                                "Saint Kitts and Nevis"=>"KNA", 
                                "Saint Lucia"=>"LCA", 
                                "Saint Martin (French part)"=>"MAF", 
                                "Saint Pierre and Miquelon"=>"SPM", 
                                "Saint Vincent and the Grenadines"=>"VCT", 
                                "Samoa"=>"WSM", 
                                "San Marino"=>"SMR", 
                                "Sao Tome and Principe"=>"STP", 
                                "Saudi Arabia"=>"SAU", 
                                "Senegal"=>"SEN", 
                                "Serbia"=>"SRB", 
                                "Seychelles"=>"SYC", 
                                "Sierra Leone"=>"SLE", 
                                "Singapore"=>"SGP", 
                                "Sint Maarten (Dutch part)"=>"SXM", 
                                "Slovakia"=>"SVK", 
                                "Slovenia"=>"SVN", 
                                "Solomon Islands"=>"SLB", 
                                "Somalia"=>"SOM", 
                                "South Africa"=>"ZAF", 
                                "South Georgia and the South Sandwich Islands"=>"SGS", 
                                "South Sudan"=>"SSD", 
                                "Spain"=>"ESP", 
                                "Sri Lanka"=>"LKA", 
                                "Sudan"=>"SDN", 
                                "Suriname"=>"SUR", 
                                "Svalbard and Jan Mayen"=>"SJM", 
                                "Swaziland"=>"SWZ", 
                                "Sweden"=>"SWE", 
                                "Switzerland"=>"CHE", 
                                "Syrian Arab Republic"=>"SYR", 
                                "Taiwan - Province of China"=>"TWN", 
                                "Tajikistan"=>"TJK", 
                                "Tanzania"=>"TZA", 
                                "Thailand"=>"THA", 
                                "Timor-Leste"=>"TLS", 
                                "Togo"=>"TGO", 
                                "Tokelau"=>"TKL", 
                                "Tonga"=>"TON", 
                                "Trinidad and Tobago"=>"TTO", 
                                "Tunisia"=>"TUN", 
                                "Turkey"=>"TUR", 
                                "Turkmenistan"=>"TKM", 
                                "Turks and Caicos Islands"=>"TCA", 
                                "Tuvalu"=>"TUV", 
                                "Uganda"=>"UGA", 
                                "Ukraine"=>"UKR", 
                                "United Arab Emirates"=>"ARE", 
                                "United Kingdom"=>"GBR", 
                                "United States"=>"USA", 
                                "United States Minor Outlying Islands"=>"UMI", 
                                "Uruguay"=>"URY", 
                                "Uzbekistan"=>"UZB", 
                                "Vanuatu"=>"VUT", 
                                "Venezuela (Bolivarian Republic of)"=>"VEN", 
                                "Viet Nam"=>"VNM", 
                                "Virgin Islands - British"=>"VGB", 
                                "Virgin Islands - U.S."=>"VIR", 
                                "Wallis and Futuna"=>"WLF", 
                                "Western Sahara"=>"ESH", 
                                "Yemen"=>"YEM", 
                                "Zambia"=>"ZMB", 
                                "Zimbabwe"=>"ZWE"); 
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
        $facility = Session::get('facility_details');
        $action = 'add';

        $formdata = lovHistoryModel::getAllDiseases();

        $patient = NULL;
        $data['nationality'] = array_flip($this->arrNationality);
        return view($this->formPath.'add',compact('patient','medical_history','action','disabilities','allergyReactions','religion','education', 'facility','formdata'))->with($data);
    }

    /**
     * A method to save add patient form values
     * @return [view] Redirects to list page with message
     */
    // revised by Romel
    public function save()
    {
        // dd(Input::all());
        /**
         * NOTE:: Create a library for this
         * @var Patients
         */
        $patient = new Patients;
        $patient->patient_id = $id = IdGenerator::generateId();
        $patient->first_name = Input::get('inputPatientFirstName');
        $patient->last_name = Input::get('inputPatientLastName');
        $patient->middle_name = Input::get('inputPatientMiddleName');
        $patient->maiden_lastname = Input::get('inputMaidenLastName');
        $patient->maiden_middlename = Input::get('inputMaidenMiddleName');
        $patient->name_suffix = Input::get('inputPatientSuffix');
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
        $patient->broadcast_notif = Input::get('inputBroadcastNotif');
        $patient->referral_notif = Input::get('inputReferralNotif');
        $patient->nonreferral_notif = Input::get('inputNonReferralNotif');
        $patient->myshine_acct = Input::get('inputMyShineAcct');
        $patient->patient_consent = Input::get('inputPatientConsent');
        $patient->email = Input::get('inputPatientEmail');
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
        $contactInfo->city = Input::get('city');
        $contactInfo->province = Input::get('province');
        $contactInfo->region = Input::get('region');
        $contactInfo->country = Input::get('inputPatientCountry');
        $contactInfo->zip = Input::get('inputPatientZip');
        $contactInfo->phone = Input::get('inputPatientPhone');
        $contactInfo->phone_ext = Input::get('inputPatientPhoneExtension');
        $contactInfo->mobile = Input::get('inputPatientMobile');
        $contactInfo->email = Input::get('inputPatientEmail');

        $contactInfo->save();

        /**
         * Add Patient Emergency Info
         *
         * @var Patient Emergency
         */
        $emergencyInfo = new PatientEmergencyInfo; // change to singular
        $emergencyInfo->patient_id = $id;
        $emergencyInfo->patient_emergencyinfo_id = IdGenerator::generateId();
        $emergencyInfo->emergency_name = Input::get('emergency_name');
        $emergencyInfo->emergency_relationship = Input::get('emergency_relationship');
        $emergencyInfo->emergency_phone = Input::get('emergency_phone');
        $emergencyInfo->emergency_mobile = Input::get('emergency_mobile');
        $emergencyInfo->emergency_address = Input::get('emergency_address');

        $emergencyInfo->save();
        
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

        //if there are history data
        if( Input::has('disease') ) {
            LovHistoryModel::savePatientDiseases($id);
        }

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

        $formdata = lovHistoryModel::getAllDiseases();

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
                    if(json_decode($facility->enabled_plugins) != NULL) {
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
        }
        $action = 'view';

        /*
        * Let us sort the plugins those with data first
        *
        */
        sortBy('pdata', $plugs, 'desc');

        if($patient):
            $data['nationality'] = array_flip($this->arrNationality);
            return view($this->viewPath.'view', compact('plugs','action','patient','disabilities','allergyReactions','bloodType','religion', 'education', 'facility', 'formdata'))->with($data);
        else:
            Session::flash('alert-class', 'alert-danger alert-dismissible');
            $message = "The patient profile does not exist. Please choose another.";

            return Redirect::to('records')->with('message', $message);
        endif;
    }

    public function quickprofile($id)
    {
        $data = array();
        /*
        $utilities = new Utils;
        $disabilities = Lovs::getLovs('disabilities');
        $allergyReactions = Lovs::getLovs('allergy_reaction');
        $religion = $utilities->religion();
        $education = $utilities->education();*/

        $patient = getCompletePatientByPatientID($id);

        $facility = Session::get('facility_details');
        $roles = Session::get('roles');

        $data['qvTitle'] = "Profile Quick View";

        //$formdata = lovHistoryModel::getAllDiseases();

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
                    if(json_decode($facility->enabled_plugins) != NULL) {
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
        }

        /*
        * Let us sort the plugins those with data first
        *
        */
        sortBy('pdata', $plugs, 'desc');

        return view($this->viewPath.'qview', compact('plugs','patient'))->with($data);
    }

    public function quickhistory($id)
    {
        $data = array();
        $data['qvTitle'] = "Medical History Quick View";

        $patient = getCompletePatientByPatientID($id);

        $facility = Session::get('facility_details');
        $roles = Session::get('roles');

        $formdata = lovHistoryModel::getAllDiseases();
        $allergyReactions = Lovs::getLovs('allergy_reaction');
        $disabilities = Lovs::getLovs('disabilities');

        $action = 'view';

        return view($this->viewPath.'hview', compact('patient', 'formdata', 'allergyReactions','disabilities'))->with($data);
    }

    public function dashboard($id)
    {
        $data = array();
        $utilities = new Utils;
        $disabilities = Lovs::getLovs('disabilities');
        $allergyReactions = Lovs::getLovs('allergy_reaction');
        $religion = $utilities->religion();
        $education = $utilities->education();

        $facility = Session::get('facility_details');
        $roles = Session::get('roles');

        $patient = getCompletePatientByPatientID($id);

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

        $facilityPatientUser = FacilityPatientUser::where('patient_id', $patient->patient_id)->pluck('facilitypatientuser_id');
        $Healthcareservices = Healthcareservices::where('facilitypatientuser_id', $facilityPatientUser)->lists('healthcareservice_id');
        $MedicalOrder = MedicalOrder::whereIn('healthcareservice_id', $Healthcareservices)->where('medicalorder_type', 'MO_LAB_TEST')->lists('medicalorder_id');
        $data['MedicalOrderLabExam'] = MedicalOrderLabExam::whereIn('medicalorder_id',$MedicalOrder)->with('LaboratoryResult')->get();
        $data['lov_laboratories'] = LovLaboratories::orderBy('laboratorydescription')->lists('laboratorydescription','laboratorycode');

        // dd($data['MedicalOrderLabExam']);

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
                    if(json_decode($facility->enabled_plugins) != NULL) {
                        if(in_array($plugin_id, json_decode($facility->enabled_plugins)) OR $roles['role_name'] == 'Developer')
                        {
                            //get only plugins for this module
                            if($plugin_module == 'patients'){
                                if($plugin_table == 'plugintable') {
                                    $pdata = Plugin::where('primary_key_value',$id)->first();
                                } else {
                                    if (Schema::hasTable($plugin_table)) {
                                        $pdata = DB::table($plugin_table)->where($plugin_primaryKey, $id)->first();
                                    }
                                }
                                $plugs[$k]['plugin'] = $plugin_id;
                                $plugs[$k]['pdata'] = $pdata;
                            }
                        }
                    }
                }
            }
        }

        return view($this->viewPath.'dashboard', compact('action','patient','regions','disabilities','allergyReactions','bloodType','religion', 'education', 'seenBy', 'facilityInfo', 'facility','roles','plugs'))->with($data);
    }

    // revised by Romel
    public function update($id)
    {
        // dd(Input::all());
        //update Patient info
        $updatePatient = array(
            "first_name" => Input::get('inputPatientFirstName'),
            "last_name" => Input::get('inputPatientLastName'),
            "middle_name" => Input::get('inputPatientMiddleName'),
            "maiden_lastname" => Input::get('inputMaidenLastName'),
            "maiden_middlename" => Input::get('inputMaidenMiddleName'),
            "name_suffix" => Input::get('inputPatientSuffix'),
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
            "broadcast_notif" => Input::get('inputBroadcastNotif'),
            "referral_notif" => Input::get('inputReferralNotif'),
            "nonreferral_notif" => Input::get('inputNonReferralNotif'),
            "myshine_acct" => Input::get('inputMyShineAcct'),
            "patient_consent" => Input::get('inputPatientConsent')
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

        //update Emergency info
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

        //if there are history data
        if( Input::has('disease') ) {
            LovHistoryModel::savePatientDiseases($id);
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

    public function addDeathInfo($id = NULL)
    {
        $data['patient_id'] = $id;
        return view($this->viewPath.'forms.modal_death')->with($data);
    }

    public function viewDeathInfo($id = NULL)
    {
        $data['patient_id'] = $id;
        $data['deathInfo'] = PatientDeathInfo::where('patient_id','=', $id)->first();
        return view($this->viewPath.'forms.modal_death')->with($data);
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
        $facpatid = FacilityPatientUser::where('facilityuser_id', $facilityUser->facilityuser_id)->where('patient_id', $id)->first();

        $deletePatient = Patients::where('patient_id', $id)->delete();

        if($facpatid) {
            $deleteFacilityPatientUser = FacilityPatientUser::where('facilitypatientuser_id', $facpatid->facilitypatientuser_id)->delete();
            //$deleteHealthCareServices = Healthcareservices::where('facilitypatientuser_id', $facpatid->facilitypatientuser_id)->delete();
        }

        if ($deletePatient) :
            Session::flash('alert-class', 'alert-success alert-dismissible');
            $message = "Successfully Deleted a Patient.";
        else:
            Session::flash('alert-class', 'alert-danger alert-dismissible');
            $message = "An error was encountered while deleting the user. Kindly try again.";
        endif;

        return Redirect::to('records')->with('message', $message);
    }

    public function undelete($id)
    {
        $user = UserHelper::getUserInfo();

        $facilityInfo = FacilityHelper::facilityInfo();
        $facilityUser = FacilityHelper::facilityUserId($user->user_id, $facilityInfo->facility_id);
        $facpatid = FacilityPatientUser::withTrashed()->where('facilityuser_id', $facilityUser->facilityuser_id)->where('patient_id', $id)->first();

        $undeletePatient = Patients::withTrashed()->where('patient_id', $id)->restore();
        if($facpatid) {
            $undeleteFacilityPatientUser = FacilityPatientUser::withTrashed()->where('facilitypatientuser_id', $facpatid->facilitypatientuser_id)->restore();
            //$undeleteHealthCareServices = Healthcareservices::withTrashed()->where('facilitypatientuser_id', $facpatid->facilitypatientuser_id)->restore();
        } else {
            $facpat = new FacilityPatientUser;
                $facpat->facilitypatientuser_id = IdGenerator::generateId();
                $facpat->facilityuser_id = $facilityUser->facilityuser_id;
                $facpat->patient_id = $id;
            $facpat->save();
        }

        if ($undeletePatient) :
            Session::flash('alert-class', 'alert-success alert-dismissible');
            $message = "Successfully Restored a delted Patient record.";
        else:
            Session::flash('alert-class', 'alert-danger alert-dismissible');
            $message = "An error was encountered while restoring the record. Kindly try again.";
        endif;

        return Redirect::to('patients/view/'.$id);
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
            ->select('patients.patient_id', 'patients.first_name', 'patients.last_name', 'facilities.facility_name', 'patients.deleted_at')
            ->join('facility_patient_user', 'patients.patient_id', '=', 'facility_patient_user.patient_id')
            ->join('facility_user', 'facility_patient_user.facilityuser_id', '=', 'facility_user.facilityuser_id')
            ->join('facilities', 'facility_user.facility_id', '=', 'facilities.facility_id')
            ->where('patients.first_name','like', '%'.$firstname.'%')
            ->where('patients.last_name','like', '%'.$lastname.'%')
            ->where('patients.middle_name','like', '%'.$middlename.'%')
            ->where('patients.birthdate','=', $birthdate)
           ->where('facility_patient_user.deleted_at','=', NULL)
           ->where('patients.deleted_at','=', NULL)
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

    /**
     * Display Forgot Password form
     */
    public function forgotpassword ()
    {
        $data = array();

        return view('patients::pages.forgotpassword')->with($data);
    }

    public function forgotpasswordSend ($email = NULL) {
        $_param = array();
        $email = (Input::get('email') == NULL) ? $email : Input::get('email');
        $check_email = Patients::where('email', $email)->count();

        if($check_email) {
            $forgot_password_code = str_random(25);
            // save the forgot password code first
            ForgotPassword::insertChangePasswordRequest($email, $forgot_password_code);

            // then send the change password link
            $changepassword_link = url('/')."/patient/forgotpassword/changepassword/".$forgot_password_code;

            $_param['email'] = $email;
            $_param['forgot_password_code'] = $forgot_password_code;
            $_param['changepassword_link'] = $changepassword_link;

            EmailHelper::sendPatientForgotPasswordEmail($_param);

            Session::flash('message', 'An email has been sent to update your password.');
            return view('patients::pages.forgotpassword');
        } else {
            Session::flash('warning', 'Email not found.');
            return view('patients::pages.forgotpassword');
        }

    }

    public function changepassword ( $password_code = '' )
    {
        $forgotPassword = ForgotPassword::getPasswordCode($password_code);
        $check_email = Patients::where('email', $forgotPassword->email)->count();

        if($check_email) {
            if ( $forgotPassword && count($forgotPassword) > 0 ) {

                $data = array();
                $data['forgotPassword'] = $forgotPassword;

                return view('patients::pages.changepassword')->with($data);
            } else {
                 Session::flash('message', 'Successfully updated.');
            return view('patients::pages.changepassword');
            }
        } else {
            Session::flash('warning', 'Email not found.');
            return view('patients::pages.changepassword');
        }
    }

    public function changepassword_request () {
        $password = Input::get('password');
        $verify_password = Input::get('verify_password');
        $password_code = Input::get('forgot_password_code');
        $forgotPassword = ForgotPassword::getPasswordCode($password_code);

        // make sure that both passwords are correct
        if ( $password != $verify_password ) {
            Session::flash('warning', 'Your passwords do not match.');
            return Redirect::to('forgotpassword/changepassword/'.$password_code);
        }

        if ( $forgotPassword && count($forgotPassword) > 0 ) {
            // get user by email
            $user = Patients::getRecordByEmail($forgotPassword->email);
            $newPassword = Hash::make($password);

            Patients::updateUserPassword($user->patient_id, $newPassword);

            Session::flash('message', 'You have successfully updated your password.');
            return view('patients::pages.changepassword');
        } else {
            Session::flash('warning', 'Failed to update your password.');
            return view('patients::pages.changepassword');
        }
    }
}
