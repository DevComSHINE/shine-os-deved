<?php
namespace ShineOS\Core\Users\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

use ShineOS\Core\Users\Libraries\Salt;
use ShineOS\Core\Users\Libraries\Password;
use ShineOS\Core\Users\Libraries\UserActivation;
use ShineOS\Core\Users\Entities\Contact;
use ShineOS\Core\Users\Entities\MDUsers;
use ShineOS\Core\Users\Entities\UserLogs;
use ShineOS\Core\Users\Entities\FacilityUser;
use ShineOS\Core\Users\Entities\RolesAccess;
use Input, Hash, Cache, Session;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\FacilityHelper;

class Users extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected static $table_name = 'users';

    /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Returns table name
     *
     * @return string
     */
    protected static function getTableName () {
        return self::$table_name;
    }

    protected static function getAllUsers () {
        return self::where('status', '!=', 'Deleted')
            ->paginate(15);
    }

    public static function getAllFacilityUsers ( $facility_id = 0 )
    {
        return DB::table('users')
            ->join('facility_user', 'users.user_id', '=', 'facility_user.user_id')
            ->join('facilities', 'facility_user.facility_id', '=', 'facilities.facility_id')
            ->where('facilities.facility_id', $facility_id)
            ->get();
    }

    protected static function addUser () {
        // check if user exists
        //$userFacilityID = Cache::get('facility_details');
        $userFacilityID = Session::get('facility_details');
        $email = Input::get('email');
        $check = self::checkIfExists($email,$userFacilityID['facility_id']);

        if ($check): // if exists
            return false;
        else: // new user
            // new user_id
            $user_id = IdGenerator::generateId();

            // temporary password and salt
            $temporaryPassword = Password::generateRandomPassword(8);
            $salt = Salt::generateRandomSalt(10);

            // activation code
            $activation_code = UserActivation::generateActivationCode();

            $users = new Users();
            $users->last_name = Input::get('last_name');
            $users->first_name = Input::get('first_name');
            $users->email = Input::get('email');
            $users->status = 'Pending';
            $users->salt = $salt;
            $users->password = Hash::make($temporaryPassword.$salt);
            $users->activation_code = $activation_code;
            $users->user_id = $user_id; // revert to hashed id
            $users->save();

            // insert user contact details
            Contact::insertUserContact($user_id);

            // inserts defaul user md details
            MDUsers::insertUserMDInfo($user_id);

            // get facility id
            $facility = FacilityHelper::facilityInfo();

            // insert user into facility
            $data = array();
            $data['user_id'] = $user_id;
            $data['facility_id'] = $facility->facility_id;
            $data['facilityuser_id'] = IdGenerator::generateId();
            FacilityUser::addUserToFacility($data);

            // add role to user
            $facilityuser_id = $data['facilityuser_id'];
            $roles = new RolesAccess();
            $roles->role_id = Input::get('role');
            $roles->facilityuser_id = $facilityuser_id;
            $roles->save();

            // send verification email
            UserActivation::sendUserActivationCode($users, $temporaryPassword);

            return $users;
        endif;

    }

    /**
     * Retrieve user email and facility ID
     *
     * @return object
     */
    protected static function checkIfExists ( $email  = NULL, $facilityID = NULL ) {
        $exists = FacilityUser::with('users')->where('facility_id',$facilityID)->whereHas('users', function ($query) use($email) {
            $query->where('email', $email);
        })->count();

        return $exists;
    }

    /**
     * Retrieve get record by id
     *
     * @return object
     */
    protected static function getRecordById ( $user_id = 0 ) {
        return self::where('user_id', $user_id)->first();
    }

    /**
     * Retrieve get record by id
     *
     * @return object
     */
    protected static function getRecordByEmail ( $email = '' ) {
        return self::where('email', $email)->first();
    }

    /**
     * Retreive updates user info
     *
     * @return object
     */
    protected static function updateUserInfo ( $user_id = 0 ) {
        $user = self::where('user_id', $user_id);

        self::print_this($user, '$user');
        exit;
    }

    /**
     * Delete user
     *
     * @return object
     */
    protected static function deleteUser ( $user_id = 0 ) {
        $user = self::where('user_id', $user_id)
            ->first();

        $user->status = 'Deleted';
        $user->deleted_at = date('Y-m-d H:i:s');
        $user->save();

        return $user;
    }

    /**
     * Change user password
     *
     * @return object
     */
    protected static function updateUserPassword ( $user_id = 0, $newPassword = '', $salt = '' ) {
        $user = self::where('user_id', $user_id)
            ->first();

        $user->password = $newPassword;
        $user->salt = $salt;
        $user->save();

        return $user;
    }

    /**
     * Disable user
     *
     * @return object
     */
    protected static function disableUser ( $user_id = 0 ) {
        $user = self::where('user_id', $user_id)->first();

        $user->status = 'Disabled';
        $user->save();

        return $user;
    }

    /**
     * Enable user
     *
     * @return object
     */
    protected static function enableUser ( $user_id = 0 ) {
        $user = self::where('user_id', $user_id)->first();

        $user->status = 'Active';
        $user->save();

        return $user;
    }

    /**
     * Activate user
     *
     * @return object
     */
    protected static function activateUser ( $activation_code = '' ) {
        $user = self::where('activation_code', $activation_code)
            ->first();

        $user->status = 'Active';
        $user->save();

        return $user;
    }

    /**
     * Update User Profile Photo
     *
     * @return object
     */
    protected static function updateProfilePicture ( $user_id = '', $profile_picture = '' ) {
        $user = self::where('user_id', $user_id)
            ->first();

        $user->profile_picture = $profile_picture;
        $user->save();

        return $user;
    }

    /**
     * Verify user password for activation
     *
     * @return object
     */
    protected static function verifyUserCredentials ( $activation_code = '' ) {
        $user = self::where('activation_code', $activation_code)
            ->first();

        //self::print_this($user, '$user');

        $password = Input::get('password');
        $temporary_password = Input::get('temporary_password');

        if (Hash::check($temporary_password.$user->salt, $user->password))
        {
            // generate new salt
            $salt = Salt::generateRandomSalt(10);
            $user->status = 'Active';
            $user->salt = $salt;
            $user->password = Hash::make($password.$salt);
            $user->save();

            return $user;
        }
        return false;
    }

    /**
     * Compute User Profile Completeness
     *
     * @return array
     */
    protected static function computeProfileCompleteness ( $user_id = 0 ) {
        $data = array();
        $completeness = 0;
        $userProfile = array('first_name', 'middle_name', 'last_name');
        $userContactProfile = array('street_address', 'barangay', 'city', 'province', 'region', 'country', 'zip', 'phone', 'mobile');
        $facilities = array('facility_name', 'specializations','services','equipment');
        $facilityContact = array('mobile','email_address','house_no','building_name','street_name','village','region','province','city','barangay','hospital_license_number');

        $user = self::where('user_id', $user_id)
            ->first();
        $userContact = Contact::getRecordById($user_id);
        //$facility = json_decode(Cache::get('facility_details'));
        $facility = json_decode(Session::get('facility_details'));

        foreach ( $userProfile as $profileKey ) {
            if ( $user->{$profileKey} != '' ) {
                $completeness++;
            }
        }
        foreach ( $userContactProfile as $profileKey ) {
            if ( $userContact->{$profileKey} != '' ) {
                $completeness++;
            }
        }
        foreach ( $facilities as $profileKey ) {
            if ( $facility->{$profileKey} != '' ) {
                $completeness++;
            }
        }
        $fcontact = $facility->facility_contact;
        foreach ( $facilityContact as $profileKey ) {
            if ( $fcontact->{$profileKey} != '' ) {
                $completeness++;
            }
        }

        $total = count($userProfile) + count($userContactProfile) + count($facilities) + count($facilityContact);
        $data['total'] = $total;
        $data['completeness'] = $completeness;
        $data['percent'] = round(($completeness * 100) / $total, 2);

        return $data;
    }

    /**
     * NEW ENTITIES
     * DO NOT REMOVE!
     */
    public function facilities()
    {
        return $this->belongsToMany('ShineOS\Core\Facilities\Entities\Facilities', 'facility_user', 'user_id', 'facility_id')->withPivot('facilityuser_id');
    }

    public function contact()
    {
        return $this->hasOne('ShineOS\Core\Users\Entities\Contact','user_id');
    }

    public function mdUsers()
    {
        return $this->hasOne('ShineOS\Core\Users\Entities\MDUsers','user_id');
    }

    public function userlogs ()
    {
        return $this->hasMany('ShineOS\Core\Users\Entities\UserLogs','user_id');
    }

    public function facilityUser()
    {
        return $this->hasMany('ShineOS\Core\Users\Entities\FacilityUser','user_id');
    }

    // public function roles ()
    // {
    // 	return $this->hasMany('ShineOS\Core\Users\Entities\Roles','facility_user','user_id','featureroleuser_id');
    // }
}
