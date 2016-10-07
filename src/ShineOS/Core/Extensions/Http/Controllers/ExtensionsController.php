<?php
namespace ShineOS\Core\Extensions\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use ShineOS\Core\Roles\Entities\Features as Features;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Facilities\Entities\Facilities as Facilities;
use ShineOS\Core\Users\Entities\Roles as Roles;
use Shine\Plugin;
use Shine\Libraries\Utils;
use DB,View, Input, Session, Redirect, Config, Module, File, Schema;

class ExtensionsController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');

    }

    /* Display all extensions installed */
    public function index()
    {
        $roles = Session::get('roles');
        $user = Session::get('user_details');
        $facility = Session::get('facility_details');

        $enabled_plugins = $facility->enabled_plugins;
        $a = Utils::getModules();

        //get installed modules
        $allModules = Module::all();

        //get installed plugins
        $patientPluginDir = plugins_path()."/";
        $plugins = directoryFiles($patientPluginDir);
        asort($plugins);
        $plugs = array();
        foreach($plugins as $k=>$plugin) {
            if(strpos($plugin, ".")===false) {
                //plugins are disabled by default
                $plug_active = 0;

                //check if config.php exists
                if(file_exists(plugins_path().$plugin.'/config.php')){
                    $plugin_module = NULL;
                    $plugin_title = NULL;
                    $plugin_id = NULL;
                    $plugin_module = NULL;
                    $plugin_location = NULL;
                    $plugin_primaryKey = NULL;
                    $plugin_table = NULL;
                    $plugin_description = NULL;
                    $plugin_version = NULL;
                    $plugin_developer = NULL;
                    $plugin_url = NULL;
                    $plugin_copy = NULL;

                    //load the config file
                    include(plugins_path().$plugin.'/config.php');
                    //check if plugin is active
                    if(json_decode($enabled_plugins) != NULL){
                        if(in_array($plugin_id, json_decode($enabled_plugins))){
                            $plug_active = 1;
                        }
                    }

                    $plugs[$k]['plugin_module'] = $plugin_module;
                    $plugs[$k]['plugin_title'] = $plugin_title;
                    $plugs[$k]['folder'] = $plugin;
                    $plugs[$k]['plugin'] = $plugin_id;
                    $plugs[$k]['plugin_description'] = $plugin_description;
                    $plugs[$k]['plugin_version'] = isset($plugin_version) ? 'Version: '.$plugin_version : NULL;
                    $plugs[$k]['plugin_developer'] = isset($plugin_developer) ? $plugin_developer : NULL;
                    $plugs[$k]['plugin_copy'] = isset($plugin_copy) ? $plugin_copy : NULL;
                    $plugs[$k]['plugin_url'] = isset($plugin_url) ? $plugin_url : NULL;
                    $plugs[$k]['plugin_active'] = $plug_active;
                }
            }
        }
        //sort array by plugin_title
        sortBy('plugin_title',   $plugs);
        $plugins = $plugs;

        //get all installed widgets
        /*$WidgetsDir = widgets_path()."/";
        $widgets = directoryFiles($WidgetsDir);
        asort($widgets);
        $widgs = array();
        foreach($widgets as $k=>$widget) {
            if(strpos($widget, ".")===false) {

            }
        }*/

        $extModules = array();
        $thisfacility = json_decode(Session::get('facility_details'));

        if ($thisfacility):
            $facilityModules = Facilities::where('facility_id', $thisfacility->facility_id)->select('enabled_modules')->get('enabled_modules');
            $enabled_modules = json_decode($facilityModules[0]->enabled_modules);
        endif;

        foreach ($allModules as $key => $val):
            $active = 0;
            if($enabled_modules AND in_array($key, $enabled_modules)) {
                $active = 1;
            }
            $module = strtolower($key);
                $mods[$key]['mod_name'] = Config::get($module.'.name');
                $mods[$key]['mod_title'] = Config::get($module.'.title');
                $mods[$key]['mod_folder'] = Config::get($module.'.folder');
                $mods[$key]['mod_description'] = Config::get($module.'.description');
                $mods[$key]['mod_version'] = 'Version: '.Config::get($module.'.version');
                $mods[$key]['mod_developer'] = Config::get($module.'.developer');
                $mods[$key]['mod_copy'] = Config::get($module.'.copy');
                $mods[$key]['mod_url'] = Config::get($module.'.url');
                $mods[$key]['mod_active'] = $active;

        endforeach;


        return view('extensions::pages.installed',compact('plugins', 'mods'));
    }

    public function view($type)
    {
        echo $type;

        return view('settings::pages.modules',compact('extModules', 'enabled_modules'));
    }

    public function add()
    {
        //get extensions from marketDB

        return view('extensions::pages.market',compact('plugins', 'mods'));
    }

    public function install($type)
    {
        $data = $_POST;
        return view('extensions::pages.pay')->with($data);
    }

    public function update()
    {
        $facility = Session::get('facility_details');
        $user = Session::get('user_details');

        $updated_modules = array();

        $roles = Session::get('roles');
        $enabled_modules = array();
        if(isset($roles['external_modules'])){
            foreach($roles['external_modules'] as $mods) {
                array_push($enabled_modules, $mods);
            }
        }
        $enabled_plugins = json_decode($facility->enabled_plugins);

        $update = key($_POST['action']);
        $type = $_POST['type'];
        $action = $_POST['action'][$update];
        $uparray = array();

        if($type == 'modules') {
            $uparray = $enabled_modules;
            $field = "enabled_modules";
        }
        if($type == 'plugins') {
            $uparray = $enabled_plugins;
            $field = "enabled_plugins";
        }

        if($uparray) {
            if(in_array($update, $uparray)) {
                //deactivate extension
                if($action == 'Deactivate') {

                    //remove from array
                    foreach($uparray as $modx) {
                        if($modx != $update){
                            array_push($updated_modules, $modx);
                        }
                    }
                    Facilities::where('facility_id', $facility->facility_id)
                        ->update([$field => json_encode($updated_modules)]);
                }
            } else {
                if($action == 'Activate') {
                    //add to array
                    array_push($uparray, $update);

                    Facilities::where('facility_id', $facility->facility_id)
                    ->update([$field => json_encode($uparray)]);

                    //do extension chores
                    //run sql migrate
                    if($type == 'plugins') {
                        //get installed plugins
                        $patientPluginDir = plugins_path()."/";
                        $plugins = directoryFiles($patientPluginDir);
                        foreach($plugins as $k=>$plugin) {
                            if(strpos($plugin, ".")===false AND strpos($plugin, $update)!==false) {
                                $updateFolder = $plugin;
                            }
                        }
                        include(plugins_path().$updateFolder.'/config.php');
                        if(!Schema::hasTable($plugin_table)) {
                            $migrate = Artisan::call('migrate', ['--path'=>'plugins/'.$updateFolder, '--force'=>true]);
                        }
                    } else {
                        $c = strtolower($update).'.table';
                        $tble = Config::get($c);
                        if($tble != NULL AND !Schema::hasTable($tble)) {
                            $migrate = Artisan::call('migrate', ['--path'=>'modules/'.$update.'/Database/Migrations', '--force'=>true]);
                        }
                    }
                }

            }
        } else {
            if($action == 'Activate') {
                //add to array
                $uparray = array($update);
                // array_push($uparray, $update);

                Facilities::where('facility_id', $facility->facility_id)
                ->update([$field => json_encode($uparray)]);

                //do extension chores
                //run sql migrate
                if($type == 'plugins') {
                    //get installed plugins
                    $patientPluginDir = plugins_path()."/";
                    $plugins = directoryFiles($patientPluginDir);
                    foreach($plugins as $k=>$plugin) {
                        if(strpos($plugin, ".")===false AND strpos($plugin, $update)!==false) {
                            $updateFolder = $plugin;
                        }
                    }
                    $migrate = Artisan::call('migrate', ['--path'=>'plugins/'.$updateFolder, '--force'=>true]);
                } else {
                    $migrate = Artisan::call('migrate', ['--path'=>'modules/'.$update.'/Database/Migrations', '--force'=>true]);
                }
            }
        }

        //regenerate roles & store into session
        $this->generateSessionRoles($user->user_id);
        Session::put('facility_details', Facilities::getCurrentFacility($facility->facility_id));

        return Redirect::to('extensions#'.$type);
    }

    public function generateSessionRoles($user_id)
    {
        $facilityuser_id = Users::with('facilityUser','facilities')->where('user_id', $user_id)->get();
        $fid = $facilityuser_id[0]->facilityUser[0]->facilityuser_id;

        $rol = DB::table("facilities")
            ->join('facility_user','facility_user.facility_id','=','facilities.facility_id')
            ->join('users','users.user_id','=','facility_user.user_id')
            ->join('roles_access','roles_access.facilityuser_id','=','facility_user.facilityuser_id')
            ->join('roles','roles_access.role_id','=','roles.role_id')
            ->where('facility_user.facilityuser_id', $fid)
            ->get();

        $roles = array();

        foreach ($rol as $role):
            $roles['role_name'] = $role->role_name;

            $core_access = json_decode($role->core_access);
            $enab_modules = json_decode($role->enabled_modules);

            //create core modules array
            foreach ($core_access as $core=>$access):
                $module = DB::table('lov_modules')->select('*')->where('module_name', strtolower($core))->first();

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
                    $roles['external_modules'][] = $val;
                endforeach;
            else:
                foreach ($enab_modules as $mod):
                    $directory_name = strtolower($mod);
                    $roles['external_modules'][strtolower($mod)] = $mod;
                endforeach;
            endif;
        endforeach;

        Session::put('roles', $roles);

        return true;
    }
}
