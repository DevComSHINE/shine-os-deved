<?php

if (version_compare(phpversion(), "5.5.9", "<=")) {
    exit("Error: You must have PHP version 5.5.9 or greater to run SHINE OS+");
}
if (!defined('T')) {
    $mtime = microtime();
    $mtime = explode(" ", $mtime);
    $mtime = $mtime[1] + $mtime[0];
    define('T', $mtime);
}

if (!defined('SHINEOS_VERSION')) {
    define('SHINEOS_VERSION', '3.2.0');
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('SHINEOS_PATH')) {
    define('SHINEOS_PATH', realpath(__DIR__ . '/../') . DS);
}


if (!defined('SHINEOS_ROOTPATH')) {
    define('SHINEOS_ROOTPATH', base_path() . DS);
}

if (!defined('SHINEOS_USERFILES_FOLDER_NAME')) {
    define('SHINEOS_USERFILES_FOLDER_NAME', 'public'); //relative to public dir
}
if (!defined('SHINEOS_MODULES_FOLDER_NAME')) {
    define('SHINEOS_MODULES_FOLDER_NAME', 'modules'); //relative to userfiles dir
}
if (!defined('SHINEOS_PLUGINS_FOLDER_NAME')) {
    define('SHINEOS_PLUGINS_FOLDER_NAME', 'plugins'); //relative to userfiles dir
}
if (!defined('SHINEOS_WIDGETS_FOLDER_NAME')) {
    define('SHINEOS_WIDGETS_FOLDER_NAME', 'widgets'); //relative to userfiles dir
}
if (!defined('SHINEOS_ELEMENTS_FOLDER_NAME')) {
    define('SHINEOS_ELEMENTS_FOLDER_NAME', 'elements'); //relative to userfiles dir
}
if (!defined('SHINEOS_MEDIA_FOLDER_NAME')) {
    define('SHINEOS_MEDIA_FOLDER_NAME', 'media'); //relative to userfiles dir
}
if (!defined('SHINEOS_UPLOADS_FOLDER_NAME')) {
    define('SHINEOS_UPLOADS_FOLDER_NAME', 'uploads'); //relative to userfiles dir
}
if (!defined('SHINEOS_TEMPLATES_FOLDER_NAME')) {
    define('SHINEOS_TEMPLATES_FOLDER_NAME', 'themes'); //relative to userfiles dir
}
if (!defined('SHINEOS_SYSTEM_MODULE_FOLDER')) {
    define('SHINEOS_SYSTEM_MODULE_FOLDER', 'src/ShineOS'); //relative to modules dir
}
if (!defined('SHINEOS_SYSTEM_CORE_FOLDER')) {
    define('SHINEOS_SYSTEM_CORE_FOLDER', 'Core'); //relative to modules dir
}
if (!defined('SHINEOS_USER_IP')) {
    if (isset($_SERVER["REMOTE_ADDR"])) {
        define("SHINEOS_USER_IP", $_SERVER["REMOTE_ADDR"]);
    } else {
        define("SHINEOS_USER_IP", '127.0.0.1');
    }
}


$functions_dir = __DIR__ . DS;

include_once($functions_dir . 'api.php');
include_once($functions_dir . 'config.php');
include_once($functions_dir . 'common.php');
include_once($functions_dir . 'lang.php');
include_once($functions_dir . 'paths.php');
include_once($functions_dir . 'db.php');
include_once($functions_dir . 'extensions.php');
include_once($functions_dir . 'query.php');
include_once($functions_dir . 'facilities.php');
include_once($functions_dir . 'users.php');
include_once($functions_dir . 'patients.php');
include_once($functions_dir . 'healthcareservices.php');
include_once($functions_dir . 'referrals.php');
include_once($functions_dir . 'reminders.php');
include_once($functions_dir . 'lovs.php');
include_once($functions_dir . 'reports.php');

date_default_timezone_set('Asia/Manila');

/*

include_once($functions_dir . 'api_callbacks.php');
include_once($functions_dir . 'filesystem.php');

include_once($functions_dir . 'events.php');



include_once($functions_dir . 'user.php');

include_once($functions_dir . 'media.php');
include_once($functions_dir . 'other.php');
include_once($functions_dir . 'content.php');
include_once($functions_dir . 'custom_fields.php');
include_once($functions_dir . 'menus.php');
include_once($functions_dir . 'categories.php');
include_once($functions_dir . 'options.php');
include_once($functions_dir . 'shop.php');
include_once($functions_dir . 'modules.php');
*/
