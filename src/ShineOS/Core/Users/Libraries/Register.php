<?php
namespace ShineOS\Core\Users\Libraries;

// User Entities
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Users\Entities\Contact;
use ShineOS\Core\Users\Entities\MDUsers;
use ShineOS\Core\Users\Entities\FacilityUser;

// Facility Entities
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Facilities\Entities\FacilityContact;
use ShineOS\Core\Facilities\Entities\FacilityWorkforce;
use ShineOS\Core\Facilities\Entities\DOHFacilityCode;

//Role
use ShineOS\Core\Users\Entities\RolesAccess;

// others
use ShineOS\Core\Users\Libraries\Salt;
use ShineOS\Core\Users\Libraries\UserActivation;
use Input, Hash;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\Utils\Lovs;
use Illuminate\Support\Facades\Config;

use DB;

class Register {

    public function __construct() {
    }

    /**
     * Inserts facility info
     *
     * @return int
     */
    protected static function addFacility( $user_id , $faci ) {

        $mode = self::getMode();

        if($mode == 'ce')
        {
            // sync ids
            $facility_id = $faci->facility_id;
            $facilitycontact_id = $faci->facility_contact->facilitycontact_id;

            // facility info
            $facility = new Facilities();
            $facility->facility_id = $facility_id; // change to hashed id
            $facility->phic_accr_id = $faci->phic_accr_id;

            //if government, let us take the official information from the lov_doh_facility_codes
            if(Input::get('ownership_type') == 'government') {
                $facility->facility_name = $faci->facility_name;
                $facility->provider_type = $faci->provider_type;
                $facility->ownership_type = $faci->ownership_type;
                $facility->facility_type = $faci->facility_type;
                $facility->DOH_facility_code = $faci->DOH_facility_code;
                $facility->enabled_plugins = NULL;
            } else {
                $facility->facility_name = $faci->facility_name;
                $facility->provider_type = $faci->provider_type;
                $facility->ownership_type = $faci->ownership_type;
                $facility->facility_type = $faci->facility_type;
                $facility->DOH_facility_code = NULL;
                $facility->enabled_plugins = NULL; //add PHIE later
            }

            $facility->enabled_modules = $facility->enabled_modules;
            $facility->enabled_plugins = $facility->enabled_plugins;
            $facility->phic_benefit_package = $facility->phic_benefit_package;
            $facility->phic_benefit_package_date = $facility->phic_benefit_package_date;
            $facility->Provider_PRC_No = $facility->Provider_PRC_No;
            $facility->ownership_type = $facility->ownership_type;
            $facility->facility_type = $facility->facility_type;
            $facility->provider_type = $facility->provider_type;
            $facility->bmonc_cmonc = $facility->bmonc_cmonc;
            $facility->hospital_license_number = $facility->hospital_license_number;
            $facility->flag_allow_referral = $facility->flag_allow_referral;
            $facility->specializations = $facility->specializations;
            $facility->services = $facility->services;
            $facility->equipment = $facility->equipment;
            $facility->facility_logo = $facility->facility_logo;

            $facility->save();



            // facility contact
            $facilityContact = new FacilityContact();

            //get lov values for location
            $brgycode = getBrgyCode($faci->facility_contact->barangay);
            $citycode = getCityCode($faci->facility_contact->city);
            $provcode = getProvinceCode($faci->facility_contact->province);
            $regioncode = getRegionCode($faci->facility_contact->region);

            $facilityContact->barangay = $brgycode;
            $facilityContact->city = $citycode;
            $facilityContact->province = $provcode;
            $facilityContact->region = $regioncode;
            $facilityContact->zip = $faci->facility_contact->zip;
            $facilityContact->country = "PHL";

            $facilityContact->facilitycontact_id = $facilitycontact_id;
            $facilityContact->facility_id = $facility_id;
            $facilityContact->save();

            return $facility_id;
        }
        else
        {
            // sync ids
            $facility_id = IdGenerator::generateId();
            $facilitycontact_id = IdGenerator::generateId();

            // facility info
            $facility = new Facilities();
            $facility->facility_id = $facility_id; // change to hashed id
            $facility->phic_accr_id = Input::get('phic_accr_id');

            // facility contact
            $facilityContact = new FacilityContact();

            //if government, let us take the official information from the lov_doh_facility_codes
            if(Input::get('ownership_type') == 'government') {
                $doh = DOHFacilityCode::checkDoh(Input::get('DOH_facility_code'));
                $facility->facility_name = $doh->name;
                $facility->provider_type = Input::get('provider_type');
                $facility->ownership_type = Input::get('ownership_type');
                $facility->facility_type = $doh->type;
                $facility->DOH_facility_code = $doh->code;

                //get lov values for location
                $brgycode = getBrgyCode($doh->barangay);
                $citycode = getCityCode($doh->city);
                $provcode = getProvinceCode($doh->province);
                $regioncode = getRegionCode($doh->region);

                $facilityContact->barangay = $brgycode;
                $facilityContact->city = $citycode;
                $facilityContact->province = $provcode;
                $facilityContact->region = $regioncode;
                $facilityContact->zip = $doh->zip;
                $facilityContact->country = "PHL";
                $facility->enabled_plugins = '["MaternalCare","FamilyPlanning","Pediatrics","Tuberculosis","Employment","FamilyInfo","MedicalHistory","Philhealth"]';
            } else {
                $facility->facility_name = Input::get('facility_name');
                $facility->provider_type = Input::get('provider_type');
                $facility->ownership_type = Input::get('ownership_type');
                $facility->facility_type = Input::get('facility_type');
                $facility->DOH_facility_code = Input::get('DOH_facility_code');
                $facility->enabled_plugins = '["FamilyInfo","MedicalHistory","Philhealth"]';
            }

            $facility->enabled_modules = '["Calendar","Laboratory"]';
            $facility->save();

            $facilityContact->facilitycontact_id = $facilitycontact_id;
            $facilityContact->facility_id = $facility_id;
            $facilityContact->save();

            return $facility_id;
        }
    }

    /**
     * Add admin user
     *
     * @return array
     */
    protected static function addAdminUser($user = NULL) {

        $mode = self::getMode();

        if($mode == 'ce')
        {
            // password and salt
            $password = $user->password;
            $salt = $user->salt;

            // activation code
            $activation_code = $user->activation_code;

            // sync ids
            $user_id = $user->user_id;
            $usercontact_id = $user->contact->usercontact_id;
            $usermd_id = $user->md_users->usermd_id;

            // add user
            $users = new Users();
            $users->user_id = $user_id;
            $users->activation_code = $activation_code;
            $users->first_name = $user->first_name;
            $users->middle_name = $user->middle_name;
            $users->last_name = $user->last_name;
            $users->suffix = $user->suffix;
            $users->email = $user->email;
            $users->status = 'Active'; //auto-active for Developer Edition
            $users->user_type = 'Admin'; //set to Developer for Developer Edition
            $users->salt = $salt;
            $users->password = $password;
            $users->civil_status = $user->civil_status;
            $users->gender = $user->gender;
            $users->birth_date = $user->birth_date;
            $users->user_type = $user->user_type;
            $users->profile_picture = $user->profile_picture;
            $users->prescription_header = $user->prescription_header;
            $users->qrcode = $user->qrcode;
            $users->status = $user->status;
            $users->old_profile = $user->old_profile;
            $users->save();

            // add user contact
            $contact = new Contact();
            $contact->phone = $user->contact->phone;
            $contact->mobile = $user->contact->mobile;
            $contact->user_id = $user_id;
            $contact->usercontact_id = $usercontact_id;
            $contact->barangay = $user->contact->barangay;
            $contact->city = $user->contact->city;
            $contact->province = $user->contact->province;
            $contact->region = $user->contact->region;
            $contact->country = $user->contact->country;
            $contact->zip = $user->contact->zip;
            $contact->house_no = $user->contact->house_no;
            $contact->building_name = $user->contact->building_name;
            $contact->street_name = $user->contact->street_name;
            $contact->village = $user->contact->village;
            $contact->save();

            // add user md info
            $md = new MDUsers();
            $md->user_id = $user_id;
            $md->usermd_id = $usermd_id;
            $md->profession = $user->md_users->profession;
            $md->professional_titles = $user->md_users->professional_titles;
            $md->professional_type_id = $user->md_users->professional_type_id;
            $md->professional_license_number = $user->md_users->professional_license_number;
            $md->s2 = $user->md_users->s2;
            $md->ptr = $user->md_users->ptr;
            $md->med_school = $user->md_users->med_school;
            $md->med_school_grad_yr = $user->md_users->med_school_grad_yr;
            $md->residency_trn_inst = $user->md_users->residency_trn_inst;
            $md->residency_grad_yr = $user->md_users->residency_grad_yr;
            $md->save();

            $data = array();
            $data['users'] = $users;
            $data['user_id'] = $user_id;
            return $data;
        }
        else
        {
            // password and salt
            $password = Input::get('password');
            $salt = Salt::generateRandomSalt(10);

            // activation code
            $activation_code = UserActivation::generateActivationCode();

            // sync ids
            $user_id = IdGenerator::generateId();
            $usercontact_id = IdGenerator::generateId();
            $usermd_id = IdGenerator::generateId();

            // add user
            $users = new Users();
            $users->user_id = $user_id;
            $users->activation_code = $activation_code;
            $users->first_name = Input::get('first_name');
            $users->last_name = Input::get('last_name');
            $users->email = Input::get('email');
            if($mode == 'developer'):
            $users->status = 'Active'; //auto-active for Developer Edition
            else:
            $users->status = 'Pending';
            endif;
            $users->user_type = 'Admin'; //set to Developer for Developer Edition
            $users->salt = $salt;
            $users->password = Hash::make($password.$salt);
            $users->save();

            // add user contact
            $contact = new Contact();
            $contact->phone = Input::get('phone');
            $contact->mobile = Input::get('mobile');
            $contact->user_id = $user_id;
            $contact->usercontact_id = $usercontact_id;
            $contact->save();

            // add user md info
            $md = new MDUsers();
            $md->user_id = $user_id;
            $md->usermd_id = $usermd_id;
            $md->save();

            $data = array();
            $data['users'] = $users;
            $data['user_id'] = $user_id;
            return $data;
        }
    }

    /**
     * Establish relationship between user and facility
     *
     * @return null
     */
    public static function addFacilityUser ( $user_id, $facility_id, $facility ) {

        $mode = self::getMode();

        // add facility and user relationship

        if($mode == 'ce')
        {
            $FacilityUser = new FacilityUser();
            $FacilityUser->facilityuser_id = $facility[0]->facilityuser_id;
            $FacilityUser->user_id = $facility[0]->user_id;
            $FacilityUser->facility_id = $facility[0]->facility_id;
            $FID = $facility[0]->facilityuser_id;
            $FacilityUser->save();

            return $FID;
        }
        else
        {
            $FacilityUser = new FacilityUser();
            $FacilityUser->facilityuser_id = IdGenerator::generateId();
            $FacilityUser->user_id = $user_id;
            $FacilityUser->facility_id = $facility_id;
            $FID = $FacilityUser->facilityuser_id;
            $FacilityUser->save();

            return $FID;
        }
    }

    /**
     * Assign role to user
     *
     * @return null
     */
    public static function addRole ( $facilityUserID ) {

        $mode = self::getMode();

        // add role
        $userRole = new RolesAccess();
        $userRole->role_id = 1;  //change to 0 for DevEd
        $userRole->facilityuser_id = $facilityUserID;
        $userRole->save();

        return $userRole;
    }

    /**
     * Add admin user
     *
     * @return null
     */
    public static function initializeRegistration ($data = NULL) {
        // add facility

        $mode = self::getMode();
        $parameter = NULL;

        if($mode == 'ce')
        {
            $users = self::addAdminUser($data->user);
            $facility_id = self::addFacility( $parameter , $data->facility);
            $facilityUserID = self::addFacilityUser( $parameter , $parameter, $data->user->facility_user );
            $userRole = self::addRole($facilityUserID);
        }
        else
        {
            $users = self::addAdminUser();
            $facility_id = self::addFacility($users['user_id'], $parameter );
            $facilityUser = self::addFacilityUser( $users['user_id'], $facility_id, $parameter );
            $userRole = self::addRole($facilityUser);

            //send email
            //removed on Developer Edition
            UserActivation::sendAdminActivationCode($users['users'], $data);
        }
    }

    public static function getActivationCode ($user) {

        //added for Community Edition registration
        //sends activation code
        $userFacilityID = DB::table('facility_user')->where('user_id', $user->user_id)->first();

        $actcode['user'] = Users::where('user_id', $user->user_id)->with('contact')->with('mdUsers')->with('facilityUser')->first();
        $actcode['facility'] = Facilities::where('facility_id',$actcode['user']->facilityUser[0]->facility_id)->with('facilityContact')->first();
        $actcode['userRole'] = RolesAccess::where('facilityuser_id',$userFacilityID->facilityuser_id)->first();

        $plain_txt = json_encode($actcode);

        $ac = self::encrypt_decrypt('encrypt', $plain_txt);
        //$activationcode = wordwrap($ac, 60, "<br />\n", true);

        $acfile = file_put_contents('public/uploads/'.$user->user_id.'.txt', $ac);

        //send email
        UserActivation::sendAdminCEActivationCode($user,$user->user_id);

    }

    private static function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }

    public static function encrypt_decrypt($action, $string)
    {
        $output = false;

        $encrypt_method = getenv('ENCRYPT_METHOD');
        $secret_key = getenv('SECRET_KEY');
        $secret_iv = getenv('SECRET_IV');

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    public static function getMode()
    {
        $mode = Config::get('config.mode');
        return $mode;
    }
}
