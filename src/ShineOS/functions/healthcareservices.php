<?php

use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrder;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;

use ShineOS\Core\Patients\Entities\FacilityPatientUser;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Patients\Entities\PatientAlert;
use ShineOS\Core\Patients\Entities\PatientAllergies;
use ShineOS\Core\Patients\Entities\PatientContacts;
use ShineOS\Core\Patients\Entities\PatientDisabilities;
use ShineOS\Core\Patients\Entities\PatientDeathInfo;
use ShineOS\Core\Patients\Entities\PatientEmergencyInfo;


/**
 * Get all health records by facility ID with available options
 * @param  INT $id  Facility ID
 * @param  INT [$order = NULL] Field name to sort from
 * @param  INT [$dir = NULL] Direction of sorting
 * @param  INT [$limit = NULL] Number of records to retrieve
 * @param  INT [$offset = NULL] Starting row to retrieve
 * @return Array Health record array
 */
function getAllHealthcareByFacilityIDwOptions($id, $search = NULL, $order = NULL, $dir = NULL, $limit = NULL, $offset = NULL) {

    $sql = "patients.deleted_at IS NULL";

    if($search) {
        $sql .= ' AND (patients.first_name LIKE "%'.$search.'%" OR patients.last_name LIKE "%'.$search.'%" OR patients.middle_name LIKE "%'.$search.'%" OR healthcare_services.healthcareservicetype_id LIKE "%'.$search.'%" OR healthcare_services.encounter_type LIKE "%'.$search.'%")';
    }
    if(strpos($order, 'name') > 1) {
        $sql .= ' order by patients.'.$order.' '.$dir;
    } else {
        $sql .= ' order by healthcare_services.'.$order.' '.$dir;
    }
    if($limit) {
        $sql .= ' limit '.$limit;
    }
    if($offset) {
        $sql .= ' offset '.$offset;
    }

    $healthcare = DB::table('healthcare_services')
        ->join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
        ->join('facility_user','facility_patient_user.facilityuser_id','=','facility_user.facilityuser_id')
        ->join('facilities','facilities.facility_id','=','facility_user.facility_id')
        ->join('patients','patients.patient_id','=','facility_patient_user.patient_id')
        ->where('facilities.facility_id', $id)
        ->whereRaw( $sql )
            ->get();

    return $healthcare;
}

/**
 * Get all health records by facility ID
 * @param  INT $id  Facility ID
 * @return Array Health record array
 */
function getAllHealthcareByFacilityID($id) {

    $healthcare = DB::table('healthcare_services')
        ->join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
        ->join('facility_user','facility_patient_user.facilityuser_id','=','facility_user.facilityuser_id')
        ->join('facilities','facilities.facility_id','=','facility_user.facility_id')
        ->join('patients','patients.patient_id','=','facility_patient_user.patient_id')
        ->where('facilities.facility_id', $id)
        ->where('patients.deleted_at', NULL)
        ->get();

    return $healthcare;
}

/**
 * Count all health records by facility with available options
 * @param  INT $id  Facility ID
 * @return INT Number of Health records
 */
function countAllHealthcareByFacilityID($id) {

    $healthcare = DB::table('healthcare_services')
        ->join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
        ->join('facility_user','facility_patient_user.facilityuser_id','=','facility_user.facilityuser_id')
        ->join('facilities','facilities.facility_id','=','facility_user.facility_id')
        ->join('patients','patients.patient_id','=','facility_patient_user.patient_id')
        ->where('facilities.facility_id', $id)
        ->where('patients.deleted_at', NULL)
        ->get();

    return count($healthcare);
}

/**
 * Get the diagnosis details by Health service ID
 * @param  INT $id  Health service ID
 * @return Object Array Details of diagnosis
 */
function getDiagnosisDetailsByHealthServiceID($id)
{
    $diagnosis = DB::table('diagnosis')
        ->where('diagnosis.healthcareservice_id', $id)
        ->first();
    if($diagnosis) {
        return $diagnosis;
    } else {
        return false;
    }
}

/**
 * Get the name diagnosis by Health service ID
 * @param  INT $id  Health service ID
 * @return String Name of diagnosis
 */
function getDiagnosisByHealthServiceID($id)
{
    $diagnosis = DB::table('diagnosis')
        ->where('diagnosis.healthcareservice_id', $id)
        ->first();
    if($diagnosis) {
        return $diagnosis->diagnosislist_id;
    } else {
        return "No diagnosis given";
    }
}

/**
 * Get medical order by health service ID
 * @param  Int $id  Health service ID
 * @return String Medical Order name or title
 */
function getMedicalOrderByHealthServiceID($id)
{
    $data = DB::table('medicalorder')
        ->where('medicalorder.healthcareservice_id', $id)
        ->first();

    if($data) {
        return $data->medicalorder_type;
    } else {
        return "No medical order given.";
    }
}


/**
 * Get medical orders by health service ID
 * @param  Int $id  Health service ID
 * @return Object Array Medical Orders
 */
function getMedicalOrdersByHealthServiceID($id)
{
    $data = MedicalOrder::with('MedicalOrderLabExam')->with('MedicalOrderPrescription')->with('MedicalOrderProcedure')->where('healthcareservice_id', $id)->get();
    $d = json_encode($data);

    if($data) {
        return json_decode($d);
    } else {
        return false;
    }
}

/**
 * Find Health Record by Service ID
 * @param  INT $serviceID Health service ID
 * @return Array Health Record array
 */
function findHealthRecordByServiceID($serviceID)
{
    $healthrecord = DB::table('healthcare_services')
        ->join('facility_patient_user', 'healthcare_services.facilitypatientuser_id', '=', 'facility_patient_user.facilitypatientuser_id')
        ->join('facility_user', 'facility_patient_user.facilityuser_id', '=', 'facility_user.facilityuser_id')
        ->where('healthcare_services.healthcareservice_id', $serviceID)
        ->first();

        return $healthrecord;
}

/**
 * Find Health Record by Patient ID
 * @param  INT $patientID Patient ID
 * @return Array Health Record array
 */
function findHealthRecordByPatientID($patientID)
{
    $healthrecord = Patients::with(['healthcareservices' => function ($query) {
            $query->orderBy('created_at', 'desc');

        }],'patientAlert','patientContact','patientDeathInfo','patientEmergencyInfo')->where('patient_id','=', $patientID)->first();

        return $healthrecord;
}


/**
*/
function getHealthcareServiceName($healthcareservicetype_id)
{
    if($healthcareservicetype_id == 'GeneralConsultation') {
        return "General Consultation";
    } else {
        return $healthcareservicetype_id;
    }
}

function getMedicalCategoryName($medicalcategory_id)
{
    $medcat = DB::table('lov_medicalcategory')
            ->where('medicalcategory_id', '=', $medicalcategory_id)
            ->first();
    if($medcat) {
        echo $medcat->medicalcategory_name;
    } else {
        return NULL;
    }
}

function getConsultTypeName($ID)
{
    switch($ID)
    {
        case "ADMIN": return "New Admisssion"; break;
        case "CONSU": return "New Consultation"; break;
        case "FOLLO": return "Followup"; break;
    }
}

function getEncounterName($ID)
{
    switch($ID)
    {
        case "O": return "Out Patient"; break;
        case "I": return "In Patient"; break;
    }
}

function getOrderTypeName($ID)
{
    switch($ID)
    {
        case "MO_LAB_TEST": return "Laboratory Examination"; break;
        case "MO_MED_PRESCRIPTION": return "Prescription"; break;
        case "MO_IMMUNIZATION": return "Immunization"; break;
        case "MO_PROCEDURE": return "Medical Procedure"; break;
        case "MO_OTHERS": return "Other"; break;
    }
}
