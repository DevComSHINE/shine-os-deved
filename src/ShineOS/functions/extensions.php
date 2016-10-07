<?php

function sh_persistent()
{
    //let us handle any UI injections from modules
    $modules = Session::get('roles');
    if(isset($modules['external_modules'])) {
        foreach($modules['external_modules'] as $module) {
            if(file_exists(modules_path().$module.'/Config/persist.php')) {
                $f = include modules_path().$module.'/Config/persist.php';
                echo $f;
            }
        }
    }
}
