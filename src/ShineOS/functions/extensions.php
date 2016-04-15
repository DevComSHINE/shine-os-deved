<?php

function callPluginController($folder, $plugin, $method, $facilityID, $patientID, $ID)
{

    include_once(plugins_path().$folder.DS.$plugin.'Controller.php');
    $rout = "\Plugins\\".$folder."\\".$plugin."Controller";
    $test = (new $rout)->testFunction();
    return $test;
}
