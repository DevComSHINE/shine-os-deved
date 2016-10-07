<?php
namespace ShineOS\Core\Users\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Users\Libraries\Register;
use ShineOS\Core\Users\Libraries\TempId;
use ShineOS\Core\Users\Libraries\UserActivation;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Facilities\Entities\DOHFacilityCode;
use ShineOS\Core\Users\Entities\RolesAccess;
use Illuminate\Support\Facades\Config;

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
    Image;

class RegistrationController extends Controller {

    protected $moduleName = 'Registration';
    protected $modulePath = 'registration';
    protected $viewPath = 'users::pages.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        # variables to share to all view
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);


    }

    /**
     * Display registration form.
     *
     * @return Response
     */
    public function index()
    {
        $is_installed = shineos_is_installed();
        if (!$is_installed){
            return Redirect::to('install');
        }

        $data = array();

        return view($this->viewPath.'registration')->with($data);
    }

    public function ce()
    {
        $data = array();

        return view($this->viewPath.'registrationce')->with($data);
    }

    /**
     * Stores registration details
     *
     * @return Response
     */
    public function register()
    {
        Session::flash('enteredData', $_POST);
        $data = array();
        $user = Users::getRecordByEmail(Input::get('email'));
        $facilities = FALSE;
        if(Input::get('ownership_type') == 'government') {
            //registrant should provide a DOH Code
            if(!Input::get('DOH_facility_code')){
                Session::flash('warning', 'You chosen a government facility, please enter your DOH Facility Code.');
                return Redirect::to('registration');// not where where to go after registration
            }
            //check if the DOH Code is valid
            else
            {
                $code = DOHFacilityCode::checkDoh(Input::get('DOH_facility_code'));
            }

            //if DOH code is valid - check if facility is already registered
            if($code) {
                $facilities = Facilities::getFacilityByDOHCode(Input::get('DOH_facility_code'));
            } else {
                Session::flash('warning', 'You entered an invalid DOH Facility Code, please check your DOH Facility Code.');
                return Redirect::to('registration');// not where where to go after registration
            }
        }

        //if facility is already registered, return error
        if ( $facilities && count($facilities) > 0 ) {
            // redirect
            Session::flash('warning', 'Facility Code already in use.');
            return Redirect::to('registration');// not where where to go after registration
        }
        //if email address is already used, return error
        elseif ( $user && count($user) > 0 ) {
            // redirect
            Session::flash('warning', 'Email address already in use.');
            return Redirect::to('registration');// not where where to go after registration
        //if everything is fine, registered new facility
        } else {
            Register::initializeRegistration();

            // redirect
            Session::flash('message', 'Registration complete! Please check your email for verification.');
            return Redirect::to('login');// not where where to go after registration
        }
    }

    /**
     * Stores registration details from a Community Edition registration
     *
     * @return Response
     */
    public function register_ce()
    {
        Session::flash('enteredData', $_POST);
        $data = array();
        $user = Users::getRecordByEmail(Input::get('email'));
        $facilities = FALSE;
        if(Input::get('ownership_type') == 'government') {
            //registrant should provide a DOH Code
            if(!Input::get('DOH_facility_code')){
                Session::flash('warning', 'You chosen a government facility, please enter your DOH Facility Code.');
                return Redirect::to('registration');// not where where to go after registration
            }
            //check if the DOH Code is valid
            else
            {
                $code = DOHFacilityCode::checkDoh(Input::get('DOH_facility_code'));
            }

            //if DOH code is valid - check if facility is already registered
            if($code) {
                $facilities = Facilities::getFacilityByDOHCode(Input::get('DOH_facility_code'));
            } else {
                Session::flash('warning', 'You entered an invalid DOH Facility Code, please check your DOH Facility Code.');
                return Redirect::to('registrationce');// not where where to go after registration
            }
        }

        //if facility is already registered, return error
        if ( $facilities && count($facilities) > 0 ) {
            // redirect
            Session::flash('warning', 'Facility Code already in use.');
            return Redirect::to('registrationce');// not where where to go after registration
        }
        //if email address is already used, return error
        elseif ( $user && count($user) > 0 ) {
            // redirect
            Session::flash('warning', 'Email address already in use.');
            return Redirect::to('registrationce');// not where where to go after registration
        //if everything is fine, registered new facility
        } else {
            Register::initializeRegistration('ce');

            // redirect
            Session::flash('message', 'Registration complete! Please check your email for activation code.');
            return Redirect::to('http://www.shine.ph/shineos/editions/community-edition/'); // not where where to go after registration
        }
    }

    public function getactivation()
    {
        $email = Input::get('identity');
        $password = Input::get('password');

        $user = Users::getRecordByEmail($email);

        /**
         * Check if user is old or new. If old, redirect to change password. If new or updated, continue with the login process.
         */
        if ($user && count($user) > 0)
        {
            Register::getActivationCode($user);
            // redirect
            Session::flash('message', 'Registration complete! Please check your email for activation code.');
            return Redirect::to('http://www.shine.ph/shineos/editions/community-edition/'); // where to go after registration
        }
        else
        {
            Session::flash('warning', 'Incorrect Login Credentials');
            return Redirect::to('registrationce');
        }
    }

    public function captcha ()
    {
        header("Pragma: no-cache"); header("Content-Type: image/png");

        // generate random string
        $captcha_string = str_random(7);
        Session::put('registration_captcha', $captcha_string);

        // create image
        $dir = 'public/dist/fonts/';
        $image = imagecreatetruecolor(180, 50); //custom image size
        $font = "SEGOEUIL.ttf"; // custom font style
        $color = imagecolorallocate($image, 113, 193, 217); // custom color
        $white = imagecolorallocate($image, 255, 255, 255); // custom background color
        imagefilledrectangle($image,0,0,399,99,$white);
        imagettftext ($image, 30, 0, 10, 40, $color, $dir.$font, Session::get('registration_captcha'));

        $thisImage = Image::make(imagepng($image));
        echo $thisImage->response('png');
    }

    public function check_captcha ()
    {
        $captcha = Session::get('registration_captcha');
        $userInput = Input::get('captcha');

        if( $userInput == $captcha ){
            $isAvailable = 'true';
        } else {
            $isAvailable = 'false';
        }
        echo json_encode(array(
            'valid' => $isAvailable,
        ));
    }

    public function activate_account ( $activation_code = '' )
    {
        $data = array();
        $data['activation_code'] = $activation_code;

        return view($this->viewPath.'activate_account')->with($data);
    }

    public function activate_ce_account ()
    {

        return view($this->viewPath.'activate_ce_account');
    }

    public function verify_user_account ( $activation_code = '' ) {

        $user = Users::verifyUserCredentials($activation_code);

        // redirect
        if ( !$user ) {
            Session::flash('message', 'Incorrect temporary password. Please check your email again...');
            return Redirect::to("activateaccount/user/{$activation_code}");
        } else {
            Session::flash('message', 'You have successfully updated your password. Please login using your new credentials.');
            return Redirect::to("login");
        }
    }

    public function activate_admin ( $type = 'cloud', $activation_code = '' )
    {
        $user = Users::activateUser($activation_code);

        if($type == 'ce') {
            Register::getActivationCode($user);
        }

        // redirect
        Session::flash('message', 'Congratulations! Your account has been verified.');
        return Redirect::to('login');// not where where to go after registration
    }

    public function activate_admin_ce ()
    {
        $allowed_configs = array('shineos');

        $file = Input::file('activation_code')->openFile();
        $fordecrypt = $file->fread($file->getSize());
        //decrypt code
        $decrypted_txt = Register::encrypt_decrypt('decrypt', $fordecrypt);

        $activation_code = json_decode($decrypted_txt);

        Register::initializeRegistration($activation_code);

        Config::set('shineos.is_activated', 1);
        Config::save($allowed_configs);
        // redirect
        Session::flash('message', 'Congratulations! Your account has been verified.');
        return Redirect::to('login');// not where where to go after registration
    }

    public function check_doh_code ()
    {
        $doh_code = Input::get('doh_code');
        $facility = DOHFacilityCode::checkDoh($doh_code);
        $result = array();

        if ( $facility ) {
            $result['flag_result'] = true;
            $result['result'] = $facility;
        } else {
            $result['flag_result'] = false;
            $result['result'] = '';
        }

        echo json_encode($result);
    }

    private function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }
}
