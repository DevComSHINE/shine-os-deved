<?php namespace Shine\Libraries;

use Session, DB, Auth;
use ShineOS\Core\Users\Entities\Users;

class UserHelper
{


    function __construct () {

    }

    /**
     * Returns user info
     *
     * @return object
     */
    public static function getUserInfo ()
    {
        if(Auth::check()) {
            $user_id = Auth::user()->user_id;
            $user = Users::getRecordById($user_id);
            return $user;
        } else {
            return NULL;
        }

    }

    private static function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }
}
