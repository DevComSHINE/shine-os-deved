<?php namespace Shine\Libraries;

use Session, DB, Cache;

class FacilityHelper
{


    /**
     * Random string to implode and explode facility details from session
     *
     * @return object
     */
    public static $divider = '!!$$!##';


    function __construct () {

    }

    /**
     * Retrieves data from session then convert into object attributes
     *
     * @return array()
     */
    public static function facilityInfo ()
    {
        //$facility = Cache::get('facility_details');
        $facility = Session::get('facility_details');
        return json_decode($facility);
    }

    public static function facilityUserId ($id,$facilityId)
    {
        $facilityUserId = DB::table('facility_user')->where('user_id','=',$id)->where('facility_id','=',$facilityId)->first(['facilityuser_id']);
        return $facilityUserId;
    }

    public static function getFacilities($id) {
        $facilities = DB::table('facility_user')->join('facilities', 'facility_user.facility_id', '=', 'facilities.facility_id')->where('user_id','=',$id->user_id)->get();
        return $facilities;
    }



}
