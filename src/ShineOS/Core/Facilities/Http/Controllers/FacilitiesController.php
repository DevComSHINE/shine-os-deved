<?php namespace ShineOS\Core\Facilities\Http\Controllers;

use Shine\Libraries\Utils;
use Shine\Libraries\Utils\Lovs;
use Illuminate\Routing\Controller;
use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Facilities\Entities\FacilityContact;
use ShineOS\Core\Facilities\Entities\DOHFacilityCode;
use ShineOS\Core\Users\Entities\Users;
use View,
    DB,
    Response,
    Validator,
    Input,
    Mail,
    Cache,
    Session,
    Redirect,
    Hash,
    Auth,
    Schema;

class FacilitiesController extends Controller {

    protected $moduleName = 'Facilities';
    protected $modulePath = 'facilities';
    protected $viewPath = 'facilities::';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $modules =  Utils::getModules();

        # variables to share to all view
        View::share('modules', $modules);
        View::share('moduleName', $this->moduleName);
        View::share('modulePath', $this->modulePath);
    }

    //UNCOMMENT TO ENABLE

    /**
     * Display a user listing.
     *
     * @return Response
     */
    public function facilities()
    {
        //get this facility info from session
        //$thisfacility = json_decode(Cache::get('facility_details'));
        $thisfacility = json_decode(Session::get('facility_details'));
        $thisUser = Session::get('_global_user');
        $roles = Session::get('roles');
        $facilities = Facilities::getCurrentFacility($thisfacility->facility_id);

        //get all available plugins in the patients plugin folder
        //later on will use options DB to get only activated plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array();

        foreach($plugins as $k=>$plugin) {
            if(strpos($plugin, ".")===false) {
                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    include(plugins_path().$plugin.'/config.php');

                    //check if this folder is enabled
                    if(in_array($plugin_id, json_decode($thisfacility->enabled_plugins)) OR $roles['role_name'] == 'Developer'){
                        //get only plugins for this module
                        if($plugin_module == 'facilities'){
                            if($plugin_table == 'plugintable') {
                                $pdata = Plugin::where('primary_key_value',$thisfacility->facility_id)->first();
                            } else {
                                if (Schema::hasTable($plugin_table)) {
                                    $pdata = DB::table($plugin_table)->where($plugin_primaryKey, $thisfacility->facility_id)->first();
                                }
                            }
                            $plugs[$k]['plugin_location'] = $plugin_location;
                            $plugs[$k]['folder'] = $plugin_folder;
                            $plugs[$k]['parent'] = $plugin_module;
                            $plugs[$k]['title'] = $plugin_title;
                            $plugs[$k]['plugin'] = $plugin_id;
                            $plugs[$k]['pdata'] = $pdata;
                        }
                    }
                }
            }
        }
        $data = array();

        $data['plugs'] = $plugs;
        $data['currentFacility'] = $thisfacility;
        $facilityContact = FacilityContact::getContact($thisfacility->facility_id);
        $data['facilityContact'] = $facilityContact;
        $data['doh'] = $thisfacility->DOH_facility_code;
        $data['userInfo'] = $thisUser;
        $data['profile_completeness'] = Users::computeProfileCompleteness($thisUser->user_id);

        $data['equipments'] = Lovs::getEnumsByType('EQUIPMENT_TYPE');
        $data['specialties'] = Lovs::getEnumsByType('SPECIALTY_TYPE');
        $data['services'] = Lovs::getEnumsByType('SERVICES_TYPE');

        return view($this->viewPath.'facilities')->with($data);
    }

    /**
     * Add facilities
     *
     * @return Response
     */
    public function add_facility () {
        $data = array();
        return view($this->viewPath.'index')->with($data);
    }

    /**
     * Update Facility Info
     *
     * @return Response
     */
    public function updatefacilityinfo ( $facility_id = 0 ) {
        $data = array();

        Facilities::updateFacilityById($facility_id);

        //let us update session values
        //$facility = json_encode(Facilities::getCurrentFacility($facility_id));
        //Session::put('_global_facility_info', $facility);
        Session::put('facility_details', Facilities::getCurrentFacility($facility_id));

        // redirect
        Session::flash('message', 'Successfully updated Facility Information!');
        return Redirect::to($this->modulePath);
    }

    /**
     * Update Facility Contact
     *
     * @return Response
     */
    public function updatefacilitycontact ( $facility_id = 0 ) {
        $data = array();

        FacilityContact::updateContactByFacilityId($facility_id);

        Session::put('facility_details', Facilities::getCurrentFacility($facility_id));

        // redirect
        Session::flash('message', 'Successfully updated Facility Contact!');
        return Redirect::to($this->modulePath);
    }

    /**
     * Update Facility Specialization
     *
     * @return Response
     */
    public function updatespecialization ( $facility_id = 0 ) {
        $data = array();
        Facilities::updateFacilitySpecializationById($facility_id);

        //let us update session values
        Session::put('facility_details', Facilities::getCurrentFacility($facility_id));

        // redirect
        Session::flash('message', 'Successfully updated Facility Specialization!');
        return Redirect::to($this->modulePath);
    }



    public function auditTrail()
    {
        return view($this->viewPath.'userlogs');
    }

    public function permissions()
    {
        return view($this->viewPath.'userpermissions');
    }


    private function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }

    /**
     * Change Profile Pic Form
     *
     * @return Response
     */
    public function changelogo ( $id = 0 )
    {
        $data = array();

        $thisUser = Session::get('_global_user');
        $data['userInfo'] = $thisUser;
        // get data
        $facInfo = Facilities::getCurrentFacility($id);
        $data['facilityInfo'] = $facInfo;
        $data['profile_completeness'] = Users::computeProfileCompleteness($thisUser->user_id);

        return view($this->viewPath.'logo_picture')->with($data);
    }

    public function changelogo_update ( $id = 0 )
    {
        $data = array();
        $file = array('profile_picture' => Input::file('profile_picture'));
        $rules = array('profile_picture' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
        $validator = Validator::make($file, $rules);

        if ($validator->fails()) {
            return Redirect::to("facilities/changelogo/{$id}")->withInput()->withErrors($validator);
        }
        else {
            // checking file is valid.
            if (Input::file('profile_picture')->isValid()) {
                $destinationPath = 'public/uploads/profile_picture'; // upload path
                $extension = Input::file('profile_picture')->getClientOriginalExtension();
                $fileName = "facility_".rand(11111,99999).'_'.date('YmdHis').'.'.$extension;
                $originalName = Input::file('profile_picture')->getClientOriginalName();
                Input::file('profile_picture')->move($destinationPath, $fileName);


                // update profile picture
                Facilities::updateLogo($id, $fileName);

                Session::flash('message', 'Your logo has been successfully added.');
                return Redirect::to("facilities/changelogo/{$id}");
            }
            else {
                // sending back with error message.
                Session::flash('warning', 'uploaded file is not valid');
                return Redirect::to("facilities/changelogo/{$id}");
            }
        }
    }

}
