<?php
namespace ShineOS\Core\Users\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Users\Libraries\Register;
use ShineOS\Core\Users\Libraries\TempId;
use ShineOS\Core\Users\Libraries\UserActivation;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Facilities\Entities\DOHFacilityCode;

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
        $data = array();

        return view($this->viewPath.'registration')->with($data);
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

        echo ( $userInput == $captcha ) ? 'true' : 'false';
    }

    public function activate_account ( $activation_code = '' )
    {
        $data = array();
        $data['activation_code'] = $activation_code;

        return view($this->viewPath.'activate_account')->with($data);
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

    public function activate_admin ( $activation_code = '' )
    {
        Users::activateUser($activation_code);

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
