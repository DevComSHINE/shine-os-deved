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

use Shine\Libraries\FacilityHelper;


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

    $sql = "deleted_at IS NULL AND hcdeleted IS NULL";

    if($search) {
        $sql .= ' AND (first_name LIKE "%'.$search.'%" OR last_name LIKE "%'.$search.'%" OR middle_name LIKE "%'.$search.'%" OR healthcareservicetype_id LIKE "%'.$search.'%" OR encounter_type LIKE "%'.$search.'%")';
    }
    if(strpos($order, 'name') > 1) {
        $sql .= ' order by '.$order.' '.$dir;
    } else {
        $sql .= ' order by '.$order.' '.$dir;
    }
    if($limit) {
        $sql .= ' limit '.$limit;
    }
    if($offset) {
        $sql .= ' offset '.$offset;
    }

    /*$healthcare = DB::table('healthcare_services')
        ->join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
        ->join('facility_user','facility_patient_user.facilityuser_id','=','facility_user.facilityuser_id')
        ->join('facilities','facilities.facility_id','=','facility_user.facility_id')
        ->join('patients','patients.patient_id','=','facility_patient_user.patient_id')
        ->where('facilities.facility_id', $id)
        ->where('patients.deleted_at', NULL)
        ->where('facility_patient_user.deleted_at', NULL)
        ->whereRaw( $sql )
            ->get();*/

    $healthcare = DB::table('healthcare_view')
        ->where('facility_id', $id)
        ->where('deleted_at','=',NULL)
        ->whereRaw($sql)
        ->get();

    return $healthcare;
}

/**
 * Get all health records by facility ID
 * @param  INT $id  Facility ID
 * @return Array Health record array
 */
function getAllHealthcareByFacilityID($id) {

    /*$healthcare = DB::table('healthcare_services')
        ->join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
        ->join('facility_user','facility_patient_user.facilityuser_id','=','facility_user.facilityuser_id')
        ->join('facilities','facilities.facility_id','=','facility_user.facility_id')
        ->join('patients','patients.patient_id','=','facility_patient_user.patient_id')
        ->where('facilities.facility_id', $id)
        ->where('patients.deleted_at', NULL)
        ->where('facility_patient_user.deleted_at', NULL)
        ->get();*/

    $healthcare = DB::table('healthcare_view')
        ->where('facility_id', $id)
        ->where('deleted_at', NULL)
        ->get();

    return $healthcare;
}

/**
 * Get all health records by month given date range
 * @param  date $start  Starting date Y-m-d
 * @param  date $end  Ending date Y-m-d Nullable
 * @return Array list of Health records array per month
 *
 *      healthcareservice_id      - ID of healthcare record
 *      encounter_datetime        - date of encounter
 *      patient_id                - patient ID
 *      first_name                - patient First Name
 *      last_name                 - patient Last Name
 *      seen_by                   - attending physician
 *      healthcareservicetype_id  - healthcare type ID
 */
function getAllHealthcareByDate($start, $end = NULL) {

    $facilityInfo = FacilityHelper::facilityInfo();

    if($end == NULL) {
        //visits today
        $rawsql = 'DATE_FORMAT(`encounter_datetime`, "%Y-%m-%d") = "'.date('Y-m-d').'"';
    } else {
        //visits from date range
        $rawsql = 'DATE_FORMAT(`encounter_datetime`, "%Y-%m-%d") BETWEEN "'.$start.'" AND "'.$end.'"';
    }

    $visits = DB::table('healthcare_view')
        ->where('facility_id', $facilityInfo->facility_id)
        ->where('deleted_at','=',NULL)
        ->whereRaw($rawsql)
        ->orderBy('encounter_datetime', 'DESC')
        ->get();

    foreach ($visits as $k => $v) {
        $v->seen_by = findUserByFacilityUserID($v->seen_by);
    }

    return $visits;
}

function getCountHealthcareByMonth($start, $end) {

    $facilityInfo = FacilityHelper::facilityInfo();

    //visits from date range
    $daterangeRaw = 'DATE_FORMAT(`encounter_datetime`, "%Y-%m-%d") BETWEEN "'.$start.'" AND "'.$end.'"';

    $visits = DB::table('healthcare_view')
        ->select(DB::raw('MONTHNAME(`encounter_datetime`) AS monther , YEAR(`encounter_datetime`) AS yearer, DATE_FORMAT(`encounter_datetime`, "%Y-%m-%d") AS encounter_date, COUNT(*) as counter'))
        ->where('facility_id', $facilityInfo->facility_id)
        ->where('deleted_at','=',NULL)
        ->whereRaw($daterangeRaw)
        ->groupBy('monther','yearer')
        ->orderBy('encounter_date', 'ASC')
        ->get();

    return $visits;
}

function getCountByDiagnosis($start, $end, $top = 10) {

    $facilityInfo = FacilityHelper::facilityInfo();

    $data['diagnosis'] = DB::table('diagnosis_view')
        ->select('diagnosislist_id', DB::raw('count(*) as bilang'))
        ->where('facility_id', $facilityInfo->facility_id)
        ->where('hccreated', '<=', $end)
        ->where('hccreated', '>=', $start)
        ->groupBy('diagnosislist_id')
        ->orderBy('bilang', 'desc')
        ->take($top)
        ->get();

    $data['totalCount'] = DB::table('diagnosis_view')
        ->where('facility_id', $facilityInfo->facility_id)
        ->where('hccreated', '<=', $end)
        ->where('hccreated', '>=', $start)
        ->count();

    return $data;
}

function getCountOfSpecificDiagnosis($start, $end, $diagnosis) {

    $facilityInfo = FacilityHelper::facilityInfo();

    $count = DB::table('diagnosis_view')
        ->where('facility_id', $facilityInfo->facility_id)
        ->where('hccreated', '<=', $end)
        ->where('hccreated', '>=', $start)
        ->where('diagnosislist_id', 'LIKE', '%'. $diagnosis . '%')
        ->count();

    return $count;
}

/**
 * Count all health records by facility with available options
 * @param  INT $id  Facility ID
 * @return INT Number of Health records
 */
function countAllHealthcareByFacilityID($id, $start=NULL, $end=NULL) {

    if($end == NULL) {
        $rawsql = 'DATE_FORMAT(`encounter_datetime`, "%Y-%m-%d") <= "'.date('Y-m-d').'"';
    } else {
        $rawsql = 'DATE_FORMAT(`encounter_datetime`, "%Y-%m-%d") BETWEEN "'.$start.'" AND "'.$end.'"';
    }

    $healthcare = DB::table('healthcare_view')
        ->where('facility_id', $id)
        ->whereRaw($rawsql)
        ->count();

    return $healthcare;
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
        switch($data->medicalorder_type){
            case "MO_MED_PRESCRIPTION": return "Prescription"; break;
            case "MO_LAB_TEST": return "Laboratory Examination"; break;
            case "MO_PROCEDURE": return "Medical Procedure"; break;
            case "MO_IMMUNIZATION": return "Immunization"; break;
            case "MO_OTHER": return "Other"; break;
        }
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
 * Get the disposition by Health service ID
 * @param  INT $id  Health service ID
 * @return Array of disposition
 */
function getDispositionByHealthServiceID($id)
{
    $disposition = DB::table('disposition')
        ->where('disposition.healthcareservice_id', $id)
        ->whereNotNull('disposition.disposition')
        ->first();
    if($disposition) {
        return $disposition;
    } else {
        return NULL;
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
        ->where('healthcare_services.healthcareservice_id', $serviceID)
        ->where('healthcare_services.deleted_at', NULL)
        ->where('facility_patient_user.deleted_at', NULL)
        ->first();

        return $healthrecord;
}

/**
 * Find Health Record by Parent Record ID
 * @param  INT $parentID Health service ID
 * @return Array Health Record array
 */
function findHealthRecordChild($parentID)
{
    $healthrecord = DB::table('healthcare_services')
        ->join('facility_patient_user', 'healthcare_services.facilitypatientuser_id', '=', 'facility_patient_user.facilitypatientuser_id')
        ->where('healthcare_services.parent_service_id', $parentID)
        ->where('healthcare_services.deleted_at', NULL)
        ->where('facility_patient_user.deleted_at', NULL)
        ->first();

        return $healthrecord;
}


function getCompleteHealthRecordByServiceID($serviceID)
{
    $healthrecord = DB::table('healthcare_view')
        ->where('healthcareservice_id', $serviceID)
        ->where('deleted_at','=',NULL)
        ->get();

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
        return "General/Family Medicine";
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

function getRegimenName($ID)
{
    switch($ID)
    {
        case 'OD': return 'Once a day'; break;
        case 'BID': return '2 x a day - Every 12 hours'; break;
        case 'TID': return '3 x a day - Every 8 hours'; break;
        case 'QID': return '4 x a day - Every 6 hours'; break;
        case 'QOD': return 'Every other day'; break;
        case 'QHS': return 'Every bedtime'; break;
        case 'OTH': return 'Others'; break;
    }
}

function getIntakeName($ID)
{
    switch($ID)
    {
        case 'D': return 'Days'; break;
        case 'M': return 'Months'; break;
        case 'Q': return 'Quarters'; break;
        case 'W': return 'Weeks'; break;
        case 'Y': return 'Years'; break;
        case 'C': return 'For Maintenance or Continuous'; break;
        case 'O': return 'Others'; break;
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

function getDiagnosisTypeName($ID)
{
    switch($ID)
    {
        case 'ADMDX': return 'Admitting diagnosis'; break;
        case 'CLIDI': return 'Clinical diagnosis'; break;
        case 'FINDX': return 'Final Diagnosis'; break;
        case 'OTHER': return 'Other Diagnosis'; break;
        case 'WODIA': return 'Working Diagnosis'; break;
        case 'WORDX': return 'Interim Diagnosis'; break;
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

function getDispositionName($ID)
{
    switch($ID)
    {
        case 'ADMDX': return 'Admitted'; break;
        case 'HOME': return 'Sent Home'; break;
        case 'ABS': return 'Absconded'; break;
        case 'HAMA': return 'Home Against Medical Advise'; break;
        case 'REFER': return 'Referred'; break;
    }
}

function getDischargeName($ID)
{
    switch($ID)
    {
        case 'IMPRO': return 'Improved'; break;
        case 'RECOV': return 'Recovered'; break;
        case 'UNIMP': return 'Unimproved'; break;
        case 'UNKNW': return 'Unknown'; break;
    }
}
