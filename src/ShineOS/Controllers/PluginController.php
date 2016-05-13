<?php

namespace ShineOS\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Module;
use Shine\Plugin;
use Event,
    Cache,
    View,
    Response,
    Validator,
    Input,
    Session,
    Redirect,
    Hash,
    Auth,
    DB;

class PluginController extends Controller {


    public function __construct() {

    }

    public function index(Request $request) {

    }

    /* Plugin call
    *
    *  Calls a plugin method
    *  $container - Laravel container variable
    *  $parent - parent module of the plugin
    *  $folder - plugin folder e.g. ShineLab_Employment
    *  $plugin - plugin name e.g. Employment
    *  $method - method to call
    *
    */
    public function call(Container $container, $folder, $plugin, $method, $ID) {

        //let us load the plugin controller
        include_once(plugins_path().$folder.DS.ucfirst($plugin).'Controller.php');

        $plugController = $container->make($plugin.'Controller');
        $container->call(
            [$plugController, $method],
            ['id' => $ID]
        );
    }

    /**
     * saveBlob - saves plugin data to meta DB plugin
     * @param string $parent Parent Module of the plugin
     * @param string $plugin Plugin name
     * @param string $ID     [[Description]]
     */
    public function saveBlob($parent, $plugin, $ID)
    {

        include_once(plugins_path().$plugin.'/config.php');

        if($_POST['id']){
            $update = array();
            foreach($_POST as $k=>$v){
                if($k == $plugin_primaryKey) {
                    $update['primary_key_value'] = $v;
                    $update['primary_key'] = $plugin_primaryKey;
                } else {
                    $p[$k] = $v;
                }
            }
            $update['values'] = json_encode($p);
            $update['plugin_id'] = $plugin_id;

            Plugin::where('id', $_POST['id'])
            ->update($update);
        } else {
            $plugin = new Plugin;
            foreach($_POST as $k=>$v){
                if($k == $plugin_primaryKey) {
                    $plugin->primary_key_value = $v;
                    $plugin->primary_key = $plugin_primaryKey;
                } else {
                    $p[$k] = $v;
                }
            }
            $plugin->values = json_encode($p);
            $plugin->plugin_id = $plugin_id;
            $plugin->save();
        }

        Session::flash('alert-class', 'alert-success alert-dismissible');
        $message = ucfirst($plugin)." data has been added to the ".ucfirst($parent)." record.";

        header('Location: '.site_url().'/'.$parent.'/view/'.$ID);
        exit;
    }

}
