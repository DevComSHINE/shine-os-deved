<?php
namespace ShineOS\Core\Updates\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use ShineOS\Core\Roles\Entities\Features as Features;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Facilities\Entities\Facilities as Facilities;
use ShineOS\Core\Users\Entities\Roles as Roles;
use Shine\Plugin;
use Shine\Libraries\Utils;
use DB,View, Input, Session, Redirect, Config, Module, File, Schema;

class UpdatesController extends Controller {

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

        return view('updates::pages.updates');
    }

    public function coreupdate($date, $ver)
    {
        $upserver = getenv('CLOUDIP');
        //Download The File If We Do Not Have It
        if ( !is_file(  userfiles_path().'/upgrades/core-'.$date."-".$ver.'.zip' )) {
            echo '<p>Downloading New Update</p>';
            $newUpdate = file_get_contents('http://'.$upserver.'/upgrades/coreupdate/core-'.$date."-".$ver.'.zip');
            if ( !is_dir( userfiles_path().'/upgrades/' ) ) mkdir ( userfiles_path().'/upgrades/' );
            $dlHandler = fopen(userfiles_path().'/upgrades/core-'.$date."-".$ver.'.zip', 'w');
            if ( !fwrite($dlHandler, $newUpdate) ) { echo '<p>Could not save new update. Operation aborted.</p>'; exit(); }
            fclose($dlHandler);
            echo '<p>Update Downloaded And Saved</p>';
        } else {
            echo '<p>Update already downloaded.</p>';
        }

        //Open The File And Do Stuff
        $zipHandle = zip_open(userfiles_path().'/upgrades/core-'.$date."-".$ver.'.zip');
        echo '<p>Starting update..</p><p></p>';
        echo '<ul>';
        while ($aF = zip_read($zipHandle) )
        {
            $thisFileName = zip_entry_name($aF);
            $thisFileDir = dirname($thisFileName);

            //Continue if its not a file
            if ( substr($thisFileName,-1,1) == '/') continue;

            //Make the directory if we need to...
            if ( !is_dir ( base_path().'/'.$thisFileDir ) AND strpos($thisFileDir, 'MAC')===false)
            {
                 mkdir ( base_path().'/'.$thisFileDir );
                 echo '<li>Created Directory '.$thisFileDir.'</li>';
            }

            //read zipFile and copy/overwrite to destination
            if(strpos($thisFileName, '.DS')===false) {
                echo '<li>'.$thisFileName.'...........';
                $contents = zip_entry_read($aF, zip_entry_filesize($aF));
                $contents = str_replace("rn", "n", $contents);
                $updateThis = '';

                $updateThis = fopen(base_path().'/'.$thisFileName, 'w');
                fwrite($updateThis, $contents);
                fclose($updateThis);
                unset($contents);
                echo' UPDATED</li>';
            }

        }
        echo '</ul>';
        $updated = TRUE;

        //let us update the version
        /*'version' => '3.1',
          'date' => '06202016',
          'copy' => 2016,
          'codename' => 'laravel51',
          'mode' => 'ce'*/
        Config::set('config.version', $ver);
        Config::set('config.date', $date);
        Config::save('config');

        echo "<p>Update successful.</p>";
        echo "<p><a href='".url('/updates')."' class='btn btn-primary' target='_parent'>Back to Updates</a></p>";
    }


}
