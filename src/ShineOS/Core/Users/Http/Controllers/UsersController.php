<?php
namespace ShineOS\Core\Users\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Users\Entities\Contact;
use ShineOS\Core\Users\Entities\MDUsers;
use ShineOS\Core\Users\Entities\FacilityUser;
use Shine\Libraries\FacilityId;
use ShineOS\Core\Users\Entities\Roles;
use ShineOS\Core\Users\Entities\RolesAccess;
use Shine\Libraries\Utils\Lovs;
use Shine\Libraries\Utils;
use ShineOS\Core\Users\Libraries\Salt;
use ShineOS\Core\Facilities\Entities\Facilities;
use Shine\Libraries\UserHelper;
use Shine\Libraries\IdGenerator;
use App\Libraries\FacilityHelper;

use View,
    Response,
    Validator,
    Input,
    Mail,
    Session,
    Redirect,
    Hash,
    Cache,
    Auth,
    DB;

class UsersController extends Controller {

    protected $moduleName = 'Users';
    protected $modulePath = 'users';
    protected $viewPath = 'users::pages.';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $modules =  Utils::getModules();

        # variables to share to all view
        View::share('modules', $modules);
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);
    }

    /**
     * Display a user listing.
     *
     * @return Response
     */
    public function index()
    {
        //$userFacilityID = Cache::get('facility_details');
        $userFacilityID = Session::get('facility_details');
        $facilityID = $userFacilityID['facility_id'];

        $data = array();
        $data['records'] = Users::with('facilityUser')->whereHas('facilityUser', function ($query) use($facilityID) {
            $query->where('facility_id', $facilityID);
        })->paginate(30);

        $curUser = UserHelper::getUserInfo();

        // get data
        $data['currentID'] = $curUser->user_id;

        return view($this->viewPath.'admin.userslist')->with($data);
    }

    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function adduser()
    {
        $data = array();
        $data['roles'] = Roles::where('role_name','!=','Admin')->lists('role_name','role_id')->toArray();

        return view($this->viewPath.'admin.adduser')->with($data);
    }

    /**
     * Store a newly created user in user table(s).
     *
     * @return Response
     */
    public function store() {
        $data = array();
        $data['input'] = Input::all();
        $data['roles'] = Roles::where('role_name','!=','Admin')->lists('role_name','role_id')->toArray();
        
        $user = Users::addUser();

        // redirect
        if ($user != false):
            Session::flash('message', 'Successfully created a new record!');
        else:
            $userdata = Users::where('email',Input::get('email'))->first();
            // Session::flash('warning', 'There is an existing email address.');
            Session::flash('email_exists', TRUE);
            //create view - add existing email to the Facility
            
            return view($this->viewPath.'admin.adduser')->with($data);
        endif;

        return Redirect::to($this->modulePath);
    }
    /**
     * Store additional facility to user
     *
     * @return Response
     */
    public function store_facilityuser() {
        Session::flash('email_exists', FALSE);
        $data = array();
        $data = Input::all();
        $data['roles'] = Roles::where('role_name','!=','Admin')->lists('role_name','role_id')->toArray();
        
        $userFacilityID = Session::get('facility_details');
        $email = $data['email'];
        $check = Users::checkIfExists($email,$userFacilityID['facility_id']);
        if($check) {
            //exists in facility user
            Session::flash('warning', 'User already connected to this Facility.');
            return view($this->viewPath.'admin.adduser')->with($data);
        } else {
            //insert to facility user
            $userdata = Users::where('email',$email)->first();
            $facilityuser = new FacilityUser();
            $facilityuser->facilityuser_id = IdGenerator::generateId();
            $facilityuser->user_id = $userdata->user_id;
            $facilityuser->facility_id = $userFacilityID['facility_id'];
            $facilityuser->save();

            Session::flash('message', 'User successfully connected to this Facility.');
            
        }

        return Redirect::to($this->modulePath);
    }

    /**
     * Display profile of user
     *
     * @param  int  $id
     * @return Response
     */
    public function profile( $id )
    {
        $data = array();

        $curUser = UserHelper::getUserInfo();
        $userFacility = Users::with('facilityUser')->where('user_id', $id)->first();


        // get data
        $data['currentID'] = $curUser->user_id;
        $userInfo = Users::getRecordById($id);
        $data['userInfo'] = $userInfo;
        $userContact = Contact::getRecordById($id);
        $data['userContact'] = $userContact;
        $userMd = MDUsers::getRecordById($id);
        $data['userMd'] = $userMd;
        $data['profile_completeness'] = Users::computeProfileCompleteness($id);
        $data['role'] = Roles::all()->toArray();
        $data['userRole'] = getRoleByFacilityUserID($userFacility->facilityUser[0]->facilityuser_id);
        //dd($data['userRole']);
        // lovs
        $regions = Lovs::getLovs('region');
        $data['regions'] = $regions;
        $provinces = Lovs::getLovs('province');
        $data['provinces'] = $provinces;
        $citymunicipalities = Lovs::getLovs('citymunicipalities');
        $data['citymunicipalities'] = $citymunicipalities;

        // dd($data);
        return view($this->viewPath.'userprofile')->with($data);
    }


    public function facilities( $id = 0 )
    {
        $data = array();

        // get data
        $userInfo = DB::table('users')->where('user_id', $id)->first();
        $data['userInfo'] = $userInfo;
        $data['profile_completeness'] = Users::computeProfileCompleteness($id);
        $userFacilityID = DB::table('facility_user')->where('user_id', $id)->first();
        $facilityID = $userFacilityID->facility_id;
        $facility = DB::table('facilities')->where('facility_id', $facilityID)->first();
        $data['facility'] = $facility;
        $facilityContact = DB::table('facility_contact')->where('facility_id', $facilityID)->first();
        $data['facilityContact'] = $facilityContact;

        return view($this->viewPath.'userfacilities')->with($data);
    }

    public function auditTrail( $id = 0 )
    {
        $profile_completeness = Users::computeProfileCompleteness($id);
        $userLogs = Users::with('userlogs')->paginate(5);
        $userInfo = Users::getRecordById($id);
        //dd($userLogs);

        return view($this->viewPath.'userlogs',compact('userLogs','userInfo','profile_completeness'));
    }

    public function access( $id = 0 )
    {
        $data = array();

        // get all user data
        $userInfo = Users::getRecordById($id);
        $data['userInfo'] = $userInfo;
        $userContact = Contact::getRecordById($id);
        $data['userContact'] = $userContact;
        $userMd = MDUsers::getRecordById($id);
        $data['userMd'] = $userMd;
        $data['profile_completeness'] = Users::computeProfileCompleteness($id);
        $data['role'] = Roles::all()->toArray();

        return view($this->viewPath.'userrole')->with($data);
    }

    /**
     * Update User Password
     *
     * @return Response
     */
    public function changeUserPassword ( $id = 0 )
    {

        $currentPassword = Input::get('currentPassword');
        $newPassword = Input::get('newPassword');
        $confirmPassword = Input::get('confirmPassword');

        // get user via user_id
        $user = Users::getRecordById($id);
        $checkCurrentPassword = Hash::make('baltarejos12@gmail.com'.$user->salt);

        if (Hash::check($currentPassword.$user->salt, $user->password)) {
            if ( $newPassword != $confirmPassword ) {
                Session::flash('warning', 'You have entered mismatched passwords.');
                return Redirect::to($this->modulePath.'/'.$id);
            } else {
                $salt = Salt::generateRandomSalt(10);
                $newPassword = Hash::make($newPassword.$salt);

                Users::updateUserPassword($id, $newPassword, $salt);

                Session::flash('message', 'Password successfully updated!');
                return Redirect::to($this->modulePath.'/'.$id);
            }
        } else { // old password did not match
            Session::flash('warning', 'Current password did not match. Please try again.');
            return Redirect::to($this->modulePath.'/'.$id);
        }
    }

    /**
     * Update User Information
     *
     * @return Response
     */
    public function updateInfo( $id = 0 )
    {
        // dd(Input::all());
        // ben: will convert to eloquent and move these DB codes to model
        DB::table('users')
            ->where('user_id', $id)
            ->update(array(
                'last_name' => Input::get('last_name'),
                'first_name' => Input::get('first_name'),
                'middle_name' => Input::get('middle_name'),
                'suffix' => Input::get('suffix_name'),
                'gender' => Input::get('usergender'),
                'birth_date' => date("Y-m-d", strtotime(Input::get('birth_date'))),
            ) );

        DB::table('user_contact')
            ->where('user_id', $id)
            ->update(array(
                'phone' => Input::get('phone'),
                'mobile' => Input::get('mobile'),
                'house_no' => Input::get('house_no'),
                'building_name' => Input::get('building_name'),
                'street_name' => Input::get('street_name'),
                'village' => Input::get('village'),
                'region' => Input::get('region'),
                'province' => Input::get('province'),
                'city' => Input::get('city'),
                'barangay' => Input::get('brgy'),
                'zip' => Input::get('zip'),
                'country' => Input::get('country'),
            ) );



        // redirect
        Session::flash('message', 'Successfully updated User Information!');
        return Redirect::to($this->modulePath.'/'.$id);
    }

    /**
     * Update User Information
     *
     * @return Response
     */
    public function updateSettings( $id = 0 )
    {
        // ben: will convert to eloquent and move these DB codes to model
        DB::table('users')
            ->where('user_id', $id)
            ->update(array(
                'prescription_header' => Input::get('prescription_header'),
                'qrcode' => Input::get('qrcode'),
            ) );

        // redirect
        Session::flash('message', 'Successfully updated User Settings!');
        return Redirect::to($this->modulePath.'/'.$id);
    }

    /**
     * Update User Background
     *
     * @return Response
     */
    public function updateBackground($id)
    {
        //check if this exist
        $userMD = DB::table('user_md')
            ->where('user_id', $id)->first();

        if($userMD) {
            DB::table('user_md')
            ->where('user_id', $id)
            ->update(array(
                'professional_titles' => Input::get('professional_titles'),
                'profession' => Input::get('profession'),
                'professional_license_number' => Input::get('professional_license_number'),
                's2' => Input::get('s2'),
                'ptr' => Input::get('ptr'),
                'med_school' => Input::get('med_school'),
                'residency_trn_inst' => Input::get('residency_trn_inst'),
                'residency_grad_yr' => Input::get('residency_grad_yr'),
            ) );
        } else {
            $md = new MDUsers();

                $md->usermd_id = IdGenerator::generateId();
                $md->user_id= $id;
                $md->professional_titles= Input::get('professional_titles');
                $md->profession= Input::get('profession');
                $md->professional_license_number= Input::get('professional_license_number');
                $md->s2= Input::get('s2');
                $md->ptr= Input::get('ptr');
                $md->med_school= Input::get('med_school');
                $md->residency_trn_inst= Input::get('residency_trn_inst');
                $md->residency_grad_yr= Input::get('residency_grad_yr');

            $md->save();

        }

        // redirect
        Session::flash('message', 'Successfully updated User Background!');
        return Redirect::to($this->modulePath.'/'.$id);
    }

    /**
     * Change Profile Pic Form
     *
     * @return Response
     */
    public function changeprofilepic ( $id = 0 )
    {
        $data = array();

        // get data
        $userInfo = Users::getRecordById($id);
        $data['userInfo'] = $userInfo;
        $userContact = Contact::getRecordById($id);
        $data['userContact'] = $userContact;
        $userMd = MDUsers::getRecordById($id);
        $data['userMd'] = $userMd;
        $data['profile_completeness'] = Users::computeProfileCompleteness($id);

        return view($this->viewPath.'profile_picture')->with($data);
    }

    public function changeprofilepic_update ( $id = 0 )
    {
        $data = array();
        $file = array('profile_picture' => Input::file('profile_picture'));
        $rules = array('profile_picture' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            return Redirect::to("users/changeprofilepic/{$id}")->withInput()->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('profile_picture')->isValid()) {
                $destinationPath = 'public/uploads/profile_picture'; // upload path
                $extension = Input::file('profile_picture')->getClientOriginalExtension();
                $fileName = "profile_".rand(11111,99999).'_'.date('YmdHis').'.'.$extension;
                $originalName = Input::file('profile_picture')->getClientOriginalName();
                Input::file('profile_picture')->move($destinationPath, $fileName);


                // update profile picture
                Users::updateProfilePicture($id, $fileName);

                Session::flash('message', 'Your profile picture has been successfully added.');
                return Redirect::to("users/changeprofilepic/{$id}");
            }
            else {
                // sending back with error message.
                Session::flash('warning', 'uploaded file is not valid');
                return Redirect::to("users/changeprofilepic/{$id}");
            }
        }
    }

    /**
     * "Delete" User
     *
     * @return Response
     */
    public function deleteUser( $id = 0 )
    {
        //Users::deleteUser($id);
        Users::where('user_id', $id)->delete();

        // redirect
        Session::flash('message', 'Successfully Deleted User!');
        return Redirect::to($this->modulePath);
    }

    /**
     * Disable User
     *
     * @return Response
     */
    public function disableUser( $id = 0 )
    {
        $user = Users::getRecordById($id);

        if ( $user->user_type == 'Admin' ) {
            Session::flash('warning', 'You cannot disable this account.');
            return Redirect::to($this->modulePath.'/'.$id);
        } else {
            Users::disableUser($id);

            Session::flash('message', 'Successfully disabled the selected user!');
            return Redirect::to($this->modulePath);
        }
    }

    /**
     * Enable User
     *
     * @return Response
     */
    public function enableUser( $id = 0 )
    {
        $user = Users::getRecordById($id);
        Users::enableUser($id);

        Session::flash('message', 'Successfully enabled the selected user!');
        return Redirect::to($this->modulePath);
    }

    public function saveRole ($id)
    {
        $facilityuser_id = DB::table('facility_user')->where('user_id', $id)->first();
        $newRole = Input::get('role');

        $role = RolesAccess::where('facilityuser_id', $facilityuser_id->facilityuser_id)->first();
        $role->role_id = $newRole;
        $role->save();

        Session::flash('message', 'Successfully changed user role!');
        return Redirect::to($this->modulePath.'/'.$id);
    }
}
