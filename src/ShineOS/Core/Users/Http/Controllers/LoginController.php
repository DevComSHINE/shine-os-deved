<?php
namespace ShineOS\Core\Users\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Users\Entities\Contact;
use ShineOS\Core\Users\Entities\MDUsers;
use ShineOS\Core\Users\Entities\FacilityUser;
use ShineOS\Core\Users\Entities\UserLogs;
use ShineOS\Core\Users\Entities\ForgotPassword;
use ShineOS\Core\Users\Entities\Roles;
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Users\Libraries\Salt;
use Shine\Libraries\FacilityHelper;
use Carbon\Carbon;
use Shine\Libraries\EmailHelper;

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
    Cache,
    File,
    Crypt;

class LoginController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display login form
     *
     * @return Response
     */
    public function index()
    {
        $data = array();

        return view('users::pages.login')->with($data);
    }

    /**
     * Validates login credentials
     *
     * @return redirect
     */
    public function checkLogin()
    {
        $email = Input::get('identity');
        $password = Input::get('password');
        $remember_me = Input::get('remember_me');

        $user = Users::getRecordByEmail($email);

        /**
         * Check if user is old or new. If old, redirect to change password. If new or updated, continue with the login process.
         * NOTE: I noticed na di required yung password - double check; Niremove rin yung change/forgot password na page. Ilagay sa cloud ito. DO NOT FORGET TO INCLUDE FIELD TO MIGRATION
         */
        if ($user && count($user) > 0)
        {
            //checks if old
            if ($user->old_profile != 0 && $user->password == NULL && $user->status == 'Active'):
                return view('users::pages.changeoldpassword');
            else: //new or updated
                if ($user->status == 'Active') :
                    Session::put('_global_user', $user);

                    if ( $remember_me != 1 ) {

                        if (Auth::attempt(['email' => $email, 'password' => $password.$user->salt]))
                        {
                            return Redirect::to('selectfacility');
                        } else {
                            Session::flash('warning', 'Incorrect Login Credentials');
                            return Redirect::to('login');
                        }

                    } else {

                        if (Auth::attempt(['email' => $email, 'password' => $password.$user->salt]))
                        {
                            Auth::login(Auth::user(), true);

                            return Redirect::to('selectfacility');
                        } else {
                            Session::flash('warning', 'Incorrect Login Credentials');
                            return Redirect::to('login');
                        }

                    }
                else:
                    Session::flash('warning', 'Your account is not activated yet. Kindly check your email.');
                    return Redirect::to('login');
                endif;
            endif;
        }
        else
        {
            Session::flash('warning', 'Incorrect Login Credentials');
            return Redirect::to('login');
        }
    }

    /**
     * Have user select a facility -- Multiple facilities
     *
     * @return response
     */
    public function select_facility (Request $request)
    {
        $data = array();
        if ($request->user()) {
            $user_id = $request->user()->user_id;

            $user = Users::with('facilities','facilityUser','mdUsers','rolesaccess')
                ->where('user_id', $user_id)
                ->first();
            $data['user'] = $user;
            Session::put('user_details', $user);

            $facility_id = $user->facilities[0]->facility_id;

            $this->saveLog('login', $user_id, $facility_id);

            if (count($user->facilities) > 1):
                return view('users::pages.selectfacility')->with($data);
            else:
                $this->assign_facility($facility_id, $user_id);
                $this->getRoleAndAccess($user_id);
                //check if this is the first time
                $firsttime = UserLogs::where('user_id', $user_id)->get();
                //if logged-in before go to dashboard
                if($firsttime->count() > 1){
                    return Redirect::to('dashboard');
                //else let user finish profile
                } else {
                    Session::flash('popup', 'Welcome');
                    return Redirect::to('facilities');
                }
            endif;
        } else {
            return Redirect::to('login');
        }
    }

    // Change password - old version
    public function changeOldPasswordView()
    {
        return view('users::pages.forgotpassword');
    }

    public function changeOldPassword()
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $verify_password = Input::get('verify_password');

        $user = Users::getRecordByEmail($email);

        if (count($user) > 0 && ($password == $verify_password))
        {
            $salt = Salt::generateRandomSalt(10);
            $newPassword = Hash::make($password.$salt);

            $user = Users::where('user_id', $user->user_id)->first();

            $user->password = $newPassword;
            $user->salt = $salt;
            $user->save();

            Session::flash('warning', 'Change password successful!');
            return Redirect::to('login');
        }
        else
        {
            Session::flash('warning', 'Incorrect Login Credentials');
            return Redirect::to('login');
        }
    }

    /**
     * Assigns a facility to a session
     *
     * @return response
     */
    public function assign_facility ( $facility_id = 0, $user_id = 0 )
    {

        $this->middleware('auth');
        $this->getRoleAndAccess($user_id);
        //Cache::forever('facility_details', Facilities::getCurrentFacility($facility_id));
        Session::put('facility_details', Facilities::getCurrentFacility($facility_id));

        return Redirect::to('dashboard');
    }

    /**
     * Logs out user
     *
     * @return redirect
     */
    public function logout( $user_id = NULL )
    {
        //let us check if the user is logged in
        $loggedin = UserLogs::where('user_id', $user_id)->first();

        if($loggedin) {
            $this->saveLog('logout', $user_id, $loggedin->facility_id);
            Session::flush();

            // clear cache
            Session::forget('roles');
            Session::forget('user_details');
            Session::forget('facility_details');
            Session::forget('facilityuser_details');

            // logout
            Auth::logout();

            // clear session
            Session::flush();
        }

        return Redirect::to('login');
    }

    /**
     * Display Forgot Password form
     *
     * @return Response
     */
    public function forgotpassword ()
    {
        $data = array();

        return view('users::pages.forgotpassword')->with($data);
    }

    public function forgotpasswordSend ($email = NULL)
    {
        $_param = array();
        $email = (Input::get('email') == NULL) ? $email : Input::get('email');

        $check_email = Users::where('email', $email)->count();

        if($check_email) {
            $forgot_password_code = str_random(25);
            // save the forgot password code first
            ForgotPassword::insertChangePasswordRequest($email, $forgot_password_code);

            // then send the change password link
            $changepassword_link = url('/')."/forgotpassword/changepassword/".$forgot_password_code;

            $_param['email'] = $email;
            $_param['forgot_password_code'] = $forgot_password_code;
            $_param['changepassword_link'] = $changepassword_link;

            EmailHelper::sendForgotPasswordEmail($_param);

            Session::flash('message', 'An email has been sent to update your password.');
            return Redirect::to('login');
        } else {
            Session::flash('warning', 'Email not found.');
            return view('users::pages.forgotpassword');
        }

    }

    public function changepassword ( $password_code = '' )
    {

        $forgotPassword = ForgotPassword::getPasswordCode($password_code);
        $check_email = Users::where('email', $forgotPassword->email)->count();

        // dd($password_code, $forgotPassword, $check_email);

        if($check_email) {
            if ( $forgotPassword && count($forgotPassword) > 0 ) {

                $data = array();
                $data['forgotPassword'] = $forgotPassword;

                return view('users::pages.changepassword')->with($data);
            } else {
                return Redirect::to('login');
            }
        } else {
            Session::flash('warning', 'Email not found.');
            return view('users::pages.changepassword');
        }
    }

    public function changepassword_request ()
    {
        $password = Input::get('password');
        $verify_password = Input::get('verify_password');
        $passwordcode = Input::get('forgot_password_code');
        $password_code = str_replace(' ', '', $passwordcode);
        $forgotPassword = ForgotPassword::getPasswordCode($password_code);

        // make sure that both passwords are correct
        if ( $password != $verify_password ) {
            Session::flash('warning', 'Your passwords do not match.');
            return Redirect::to('forgotpassword/changepassword/'.$password_code);
        }

        if ( $forgotPassword && count($forgotPassword) > 0 ) {
            // get user by email
            $user = Users::getRecordByEmail($forgotPassword->email);

            $salt = Salt::generateRandomSalt(10);
            $newPassword = Hash::make($password.$salt);

            Users::updateUserPassword($user->user_id, $newPassword, $salt);

            Session::flash('message', 'You have successfully updated your password. Please try logging in.');
            return Redirect::to('login');
        } else {
            Session::flash('warning', 'Failed to update your password');
            return Redirect::to('login');
        }
    }

    private function saveLog( $type=NULL, $user_id=NULL, $facility_id=NULL )
    {
        /**
         * NOTE: DO NOT FORGET TO INCLUDE FACILITY ID
         *
         */
        $datenow = Carbon::now();

        $logs = new UserLogs;
        $logs->userusagestat_id =
        $logs->user_id = $user_id;
        $logs->facility_id = $facility_id;

        if ($type == 'login'):
            $logs->login_datetime = $datenow;
        else:
            $logs->logout_datetime = $datenow;
        endif;

        $logs->device = "Desktop"; //temp

        $logs->save();

        if ($logs->save() == true):
            return true;
        endif;

        return false;
    }

    /**
     * TRANSFER THIS CAMILLE
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    private function getRoleAndAccess($user_id = NULL)
    {
        $facilityuser_id = Users::with('facilityUser','facilities')->where('user_id', $user_id)->get();
        $fu_id = $facilityuser_id[0]->facilityUser[0]->facilityuser_id; // USE REPOSITORY CAMILLE

        /*$rr = Roles::with('access')->whereHas('access', function($query) use ($fu_id) {
            $query->where('roles_access.facilityuser_id', $fu_id);
        })->get();*/

        $r = DB::table("facilities")
            ->join('facility_user','facility_user.facility_id','=','facilities.facility_id')
            ->join('users','users.user_id','=','facility_user.user_id')
            ->join('roles_access','roles_access.facilityuser_id','=','facility_user.facilityuser_id')
            ->join('roles','roles_access.role_id','=','roles.role_id')
            ->where('facility_user.facilityuser_id', $fu_id)
            ->get();

        $roles = array();

        foreach ($r as $role):
            $roles['role_name'] = $role->role_name;

            $core_access = json_decode($role->core_access);
            $enab_modules = json_decode($role->enabled_modules);

            //create core modules array
            foreach ($core_access as $core=>$access):
                $module = $this->getModuleName($core);
                if($module) {
                    $roles['modules'][$module->module_name]['name'] = $module->module_name;
                    $roles['modules'][$module->module_name]['icon'] = $module->icon;
                    $roles['modules'][$module->module_name]['status'] = $module->status;
                    $roles['modules'][$module->module_name]['access'][] = $access;
                    $roles['modules'][$module->module_name]['order'] = $module->menu_order;
                }
            endforeach;

            //create 3rd party modules array
            if ($role->role_name == 'Developer'): // FOR DEVELOPER VERSION ONLY get all 3rd party modules
                $directoryModules = File::directories('modules');
                foreach($directoryModules as $val):
                    $directory = explode(DS,$val); //changed DS to make it function on Linux and Windows
                    $directory_name = strtolower($directory[1]);
                    $roles['external_modules'][] = $directory_name;
                endforeach;
            else:
                if($enab_modules){
                    foreach ($enab_modules as $mod):
                        $directory_name = strtolower($mod);
                        $roles['external_modules'][$directory_name] = $mod;
                    endforeach;
                }
            endif;
        endforeach;

        //Cache::forever('roles', $roles);
        Session::put('roles', $roles);
    }

    private function getModuleName($module_name)
    {
        $module = DB::table('lov_modules')->select('*')->where('module_name', strtolower($module_name))->first();

        return $module;
    }

    private function getModuleAccess($module_id, $role)
    {
        $access = DB::table('lov_roles_access')->where('module_id', $module_id)->where('role_id', $role)->first();

        return $access;
    }


}
