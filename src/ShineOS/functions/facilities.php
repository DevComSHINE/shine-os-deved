<?php

/*
 * Methods related to Facilities
 *
 * @package ShineOS+
 * @subpackage Facilities
 * @version 2.0
 *
*/

use ShineOS\Core\Facilities\Entities\Facilities;
use ShineOS\Core\Facilities\Entities\FacilityUser;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use ShineOS\Core\Facilities\Entities\FacilityContact;
use ShineOS\Core\Facilities\Entities\DOHFacilityCode;

/**
 * Get info of facility: all or given field
 * @param  int $id           Facility User ID
 * @param  char [$field=NULL] Field to return
 * @return string or array Array of data or value of field
 */
function getFacilityByFacilityUserID($id, $field=NULL)
{
    $facility = new Facilities;
    $fac = $facility::with('facilityUser')->with('facilityContact')->whereHas('facilityUser', function($query) use($id) {
        $query->where('facilityuser_id', $id);
    })->first();

    if($field) {
        if($fac) {
            return $fac->facility_name;
        } else {
            return NULL;
        }
    } else {
        $d = json_encode($fac);
        return json_decode($d);
    }
}

/**
 * Get the name of the Facility by user ID
 * @param  [string] $id User ID
 * @return [string] Full name of the user
 */
function getFacilityNameByUserID($id)
{
    $facility = DB::table('facility_user')
        ->join('users', 'facility_user.user_id', '=', 'users.user_id')
        ->join('facilities', 'facilities.facility_id', '=', 'facility_user.facility_id')
        ->join('facility_patient_user', 'facility_patient_user.facilityuser_id', '=', 'facility_user.facilityuser_id')
        ->select('facilities.*')
        ->where('users.user_id', $id)
        ->first();
    if($facility) {
        return $facility->facility_name;
    } else {
        return NULL;
    }

}

/**
 * Get the full details user of a facility
 * @param  int $id User ID
 * @return Object Array array of details
 */
function getUserDetailsByUserID($id)
{
    $user = DB::table('users')
        ->leftJoin('user_md', 'users.user_id', '=', 'user_md.user_id')
        ->leftJoin('user_contact', 'users.user_id', '=', 'user_md.user_id')
        ->where('users.user_id', $id)
        ->first();
    if($user) {
        return $user;
    } else {
        return NULL;
    }
}

/**
 * Get the full name of the user of a facility
 * @param  int $id Facility User ID
 * @return string Full name of user
 */
function getUserFullNameByFacilityUserID($id)
{
    $user = DB::table('facility_user')
        ->join('users', 'facility_user.user_id', '=', 'users.user_id')
        ->select('users.*')
        ->where('facility_user.facilityuser_id', $id)
        ->first();

    if($user) {
        return $user->first_name." ".$user->last_name;
    } else {
        return NULL;
    }
}

/**
 * Get the full name of the user by user ID
 * @param  [string] $id User ID
 * @return [string] Full name of the user
 */
function getUserFullNameByUserID($id)
{
    $user = DB::table('facility_user')
        ->join('users', 'facility_user.user_id', '=', 'users.user_id')
        ->select('users.*')
        ->where('facility_user.user_id', $id)
        ->first();
    if($user) {
        return $user->first_name." ".$user->last_name;
    } else {
        return NULL;
    }

}

/**Get Facility data using Facility Name
 * @param  [string] $name Facility Name
 * @return [mixed] Facility data
 */
function findByFacilityName($name)
{
    return Facilities
    ::where('facility_name', 'like', '%'.$name.'%')
    ->first();
}

/**
 * Get Facility data using Facility ID
 * @param  [string] $id Facility ID
 * @return [mixed] Facility Data
 */
function findByFacilityID($id)
{
    return Facilities::where('facility_id', '=', $id)->first();
}

/**
 * Find User Data by Facility User ID
 * @param  [string] $id Facility User ID
 * @return [mixed] User Data array
 */
function findUserByFacilityUserID($id)
{
    $user = DB::table('facility_user')
        ->join('users', 'facility_user.user_id', '=', 'users.user_id')
        ->select('users.*')
        ->where('facility_user.facilityuser_id', $id)
        ->first();
    if($user){
        return $user;
    } else {
        return NULL;
    }
}

/**
 * Find User Creator by Patient ID
 * @param  [string] $id Patient ID
 * @return [mixed] User Data array
 */
function findCreatedByFacilityUserID($id)
{
    $user = DB::table('facility_patient_user')
        ->join('facility_user', 'facility_user.facilityuser_id', '=', 'facility_patient_user.facilityuser_id')
        ->join('users', 'facility_user.user_id', '=', 'users.user_id')
        ->where('facility_patient_user.patient_id', $id)
        ->first();

    if($user){
        return $user;
    } else {
        return NULL;
    }
}

/**
 * Find Facility by Facility ID
 * @param  [string] $id Facility ID
 * @return [mixed] Facility Data array
 */
function findFacilityByFacilityID($id)
{
    $user = DB::table('facility_user')
        ->join('facilities', 'facility_user.facility_id', '=', 'facilities.facility_id')
        ->select('facilities.*')
        ->where('facility_user.facilityuser_id', $id)
        ->first();

    if($user){
        return $user;
    } else {
        return NULL;
    }
}

/**
 * Get Patient by Facility Patient User ID
 * @param  [string] $id Facility Patient User ID
 * @return [mixed] Patient Data Array
 */
function findPatientByFacilityPatientUserID($id)
{
    $patient = DB::table('facility_patient_user')
        ->join('patients', 'facility_patient_user.patient_id', '=', 'patients.patient_id')
        ->select('patients.*')
        ->where('facility_patient_user.facilitypatientuser_id', $id)
        ->first();

    if($patient){
        return $patient;
    } else {
        return NULL;
    }
}

/**
 * Get Facility User by Facility ID
 * @param  [string] $id Facility ID
 * @return [mixed] Facility User Data array
 */
function findFacilityUserByFacilityID($id)
{
    $user = DB::table('facility_user')
        ->join('facilities', 'facility_user.facility_id', '=', 'facilities.facility_id')
        ->select('facilities.*')
        ->where('facility_user.facility_id', $id)
        ->first();

    if($user){
        return $user;
    } else {
        return NULL;
    }
}

/**
 * Find all users of a Facility using Facility ID
 * @param  [string] $id             Facility ID
 * @return [mixed] Array of users
 */
function findAllUsersByFacilityID($id)
{
    $users = DB::table('facilities')
        ->join('facility_user', 'facilities.facility_id', '=', 'facility_user.facility_id')
        ->join('users', 'facility_user.user_id', '=', 'users.user_id')
        ->select('users.*')
        ->where('facility_user.facility_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

    if($users){
        return $users;
    } else {
        return NULL;
    }
}

/**
 * Find all patients of a Facility by Facility ID
 * @param  [string] $id  Facility ID
 * @return [mixed] Array of patients
 */
function findAllPatientsByFacilityID($id)
{
    $patients = DB::table('facility_patient_user')
        ->join('facility_user', 'facility_patient_user.facilityuser_id', '=', 'facility_user.facilityuser_id')
        ->join('patients', 'facility_patient_user.patient_id', '=', 'patients.patient_id')
        ->select('patients.*')
        ->where('facility_user.facility_id', $id)
        ->orderBy('created_at', 'desc')
        ->get();

    if($patients){
        return $patients;
    } else {
        return NULL;
    }
}

function findAllFacilitiesDetails($id)
{
    $facility = Facilities::with('facilityContact')->where('facility_id', $id)->first();

    if($facility){
        return $facility;
    } else {
        return NULL;
    }
}
