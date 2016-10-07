<?php namespace ShineOS\Controllers;

use Shine\Libraries\UserHelper;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use ShineOS\Core\Reports\Entities\M2;
use ShineOS\Core\Reports\Entities\M1FP;
use \Cache;
use \Event;
use \Session;
use \Redirect;
use \URL;

use Module;

class WarehouseController extends Controller {

    public function __construct($app = null) {

    }

    public function index() {

    }

    /**
     * Update the M2 FHSIS Report rerun update script
     */
    public function updateM2()
    {
        $facility = Session::get('facility_details');

        //run datawarehouse chores
        //fhsis_m2
        $month = date('n');
        $year = date('Y');

        //process today's fhsis M2
        $diagnoses = DB::select( DB::raw("SELECT TIMESTAMPDIFF(YEAR,c.birthdate,d.created_at) as 'age', c.gender, d.diagnosislist_id, e.icd10_code, MONTH(d.created_at) as 'diagnosisMonth', YEAR(d.created_at) as 'diagnosisYear', YEAR(f.datetime_death) as 'deathYear', h.facility_id, count(*) as 'count'
        FROM healthcare_services a
        JOIN facility_patient_user b ON b.facilitypatientuser_id = a.facilitypatientuser_id
        JOIN facility_user g ON g.facilityuser_id = b.facilityuser_id
        JOIN facilities h ON h.facility_id = g.facility_id
        JOIN patients c ON c.patient_id = b.patient_id
        LEFT JOIN diagnosis d ON d.healthcareservice_id = a.healthcareservice_id
        LEFT JOIN diagnosis_icd10 e ON e.diagnosis_id = d.diagnosis_id
        LEFT JOIN patient_death_info f ON f.patient_id = c.patient_id
        WHERE h.facility_id = '".$facility->facility_id."'
        AND d.diagnosislist_id != ''
        GROUP BY d.diagnosislist_id, e.icd10_code, 'age', c.gender, h.facility_id
        ORDER BY a.created_at ASC") );

        if($diagnoses) {
            foreach($diagnoses as $diagnosis) {
                //check if this month is present
                $rec = M2::where('diagnosislist_id', $diagnosis->diagnosislist_id)
                    ->where('age', $diagnosis->age)
                    ->where('gender', $diagnosis->gender)
                    ->where('diagnosisMonth', $diagnosis->diagnosisMonth)
                    ->where('diagnosisYear', $diagnosis->diagnosisYear)
                    ->where('facility_id', $diagnosis->facility_id)
                    ->where('updated_at', '<', date('Y-m-d H:i:s'))
                    ->first();

                if($rec) {
                    $rec->count = $rec->count + $diagnosis->count;
                    $rec->save();
                } else {
                    $m2 = new M2();
                    $m2->age = $diagnosis->age;
                    $m2->gender = $diagnosis->gender;
                    $m2->diagnosislist_id = $diagnosis->diagnosislist_id;
                    $m2->icd10_code = $diagnosis->icd10_code;
                    $m2->diagnosisMonth = $diagnosis->diagnosisMonth;
                    $m2->diagnosisYear = $diagnosis->diagnosisYear;
                    $m2->deathYear = $diagnosis->deathYear;
                    $m2->facility_id = $diagnosis->facility_id;
                    $m2->count = $diagnosis->count;
                    $m2->save();
                }
            }
        }

        return 'done';
    }

    /**
     * Update the M2 FHSIS Report daily script
     */
    public function getDailyM2()
    {
        $facility = Session::get('facility_details');

        //run datawarehouse chores
        //fhsis_m2
        $month = date('n');
        $year = date('Y');

        //process today's fhsis M2
        $diagnoses = DB::select( DB::raw("SELECT TIMESTAMPDIFF(YEAR,c.birthdate,d.created_at) as 'age', c.gender, d.diagnosislist_id, e.icd10_code, MONTH(d.created_at) as 'diagnosisMonth', YEAR(d.created_at) as 'diagnosisYear', YEAR(f.datetime_death) as 'deathYear', h.facility_id, count(*) as 'count'
        FROM healthcare_services a
        JOIN facility_patient_user b ON b.facilitypatientuser_id = a.facilitypatientuser_id
        JOIN facility_user g ON g.facilityuser_id = b.facilityuser_id
        JOIN facilities h ON h.facility_id = g.facility_id
        JOIN patients c ON c.patient_id = b.patient_id
        LEFT JOIN diagnosis d ON d.healthcareservice_id = a.healthcareservice_id
        LEFT JOIN diagnosis_icd10 e ON e.diagnosis_id = d.diagnosis_id
        LEFT JOIN patient_death_info f ON f.patient_id = c.patient_id
        WHERE h.facility_id = '".$facility->facility_id."'
        AND d.diagnosislist_id != ''
        AND DATE(a.created_at) = '".date('Y-m-d')."'
        GROUP BY d.diagnosislist_id, e.icd10_code, 'age', c.gender, h.facility_id
        ORDER BY a.created_at ASC") );

        if($diagnoses) {
            foreach($diagnoses as $diagnosis) {
                //check if this month is present
                $rec = M2::where('diagnosislist_id', $diagnosis->diagnosislist_id)
                    ->where('age', $diagnosis->age)
                    ->where('gender', $diagnosis->gender)
                    ->where('diagnosisMonth', $diagnosis->diagnosisMonth)
                    ->where('diagnosisYear', $diagnosis->diagnosisYear)
                    ->where('facility_id', $diagnosis->facility_id)
                    ->where('updated_at', '<', date('Y-m-d H:i:s'))
                    ->first();

                if($rec) {
                    $rec->count = $rec->count + $diagnosis->count;
                    $rec->save();
                } else {
                    $m2 = new M2();
                    $m2->age = $diagnosis->age;
                    $m2->gender = $diagnosis->gender;
                    $m2->diagnosislist_id = $diagnosis->diagnosislist_id;
                    $m2->icd10_code = $diagnosis->icd10_code;
                    $m2->diagnosisMonth = $diagnosis->diagnosisMonth;
                    $m2->diagnosisYear = $diagnosis->diagnosisYear;
                    $m2->deathYear = $diagnosis->deathYear;
                    $m2->facility_id = $diagnosis->facility_id;
                    $m2->count = $diagnosis->count;
                    $m2->save();
                }
            }
        }

        return 'done';
    }

    //function to get previous months value
    public function getPrevCount($facilityid, $method, $type, $month, $year) {
        $prevCU = M1FP::select($type)->where('facility_id', $facilityid)->where('previous_method', $method)->where('FPmonth', $month)->where('FPyear', $year)->first();

        if($prevCU) {
            if($prevCU->$type > 0) {
                return $prevCU->$type;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    //process Family Planning FHSIS monthly
    //and store into Warehouse
    public function getM1_FP()
    {
        $facility = Session::get('facility_details');

        $month = date('n');
        $year = date('Y');

        //process only current year
        $sql = "SELECT a.`old_facility_id`, ( SELECT h.facility_id FROM healthcare_services d
LEFT JOIN facility_patient_user b ON b.facilitypatientuser_id = d.facilitypatientuser_id
LEFT JOIN facility_user g ON g.facilityuser_id = b.facilityuser_id
LEFT JOIN facilities h ON h.facility_id = g.facility_id WHERE d.`healthcareservice_id` = a.`healthcareservice_id` ) as 'facilityid', a.`current_method`, a.`previous_method`, SUM(a.`client_type`='CU') as 'CU', SUM(a.`client_type`='NA') as 'NA', SUM(a.`client_sub_type`='CC') as 'CC', SUM(a.`client_sub_type`='CM') as 'CM', SUM(a.`client_sub_type`='RS') as 'RS', (SUM(a.`client_sub_type`='CC')+SUM(a.`client_sub_type`='CM')+SUM(a.`client_sub_type`='RS')) as 'OA', SUM(a.`client_type`='dropout_date') as 'Dropout', MONTH(a.`created_at`) as 'FPmonth', YEAR(a.`created_at`) as 'FPyear', count(*) as 'FP_count', a.created_at FROM `familyplanning_service` a
WHERE YEAR(a.created_at) = $year
GROUP BY a.current_method, a.previous_method, facilityid
ORDER BY FPyear ASC, FPmonth ASC";

        $cur_fp = DB::select( DB::raw( $sql ));

        if($cur_fp) {
            foreach($cur_fp as $fp) {
                if($fp->facilityid != NULL AND ($fp->current_method != NULL OR $fp->previous_method != NULL)) {

                    if($fp->FPmonth == 1) {
                        $fpmonth = 12;
                        $fpyear = $fp->FPyear - 1;
                    } else {
                        $fpmonth = $fp->FPmonth-1;
                        $fpyear = $fp->FPyear;
                    }

                    $CUbegin = self::getPrevCount($fp->facilityid, $fp->current_method, 'CU_end', $fpmonth, $fpyear);

                    //for this year, let us consider current month's users in the counting
                    //if there is no previous method recorded - this means these are new acceptors
                    //which we should count as well
                    if($fp->FPyear == 2016) {
                        $CUbegin = $CUbegin + $fp->FP_count;
                    }
                    $NAprev = self::getPrevCount($fp->facilityid, $fp->current_method, 'NA', $fpmonth, $fpyear);

                    //compute ending users using FHSIS formula
                    $CUend = $CUbegin + $NAprev + $fp->OA - $fp->Dropout;

                    $m1fp = new M1FP();
                    $m1fp->facility_id = $fp->facilityid;
                    $m1fp->CU_begin = $CUbegin;
                    $m1fp->current_method = $fp->current_method;
                    $m1fp->previous_method = $fp->previous_method;
                    $m1fp->CU = $fp->CU;
                    $m1fp->NA = $fp->NA;
                    $m1fp->CC = $fp->CC;
                    $m1fp->CM = $fp->CM;
                    $m1fp->RS = $fp->RS;
                    $m1fp->OA = $fp->OA;
                    $m1fp->Dropout = $fp->Dropout;
                    $m1fp->FPmonth = $fp->FPmonth;
                    $m1fp->FPyear = $fp->FPyear;
                    $m1fp->FP_count = $fp->FP_count;
                    $m1fp->CU_end = $CUend;

                    $m1fp->save();
                }
            }
        }
    }

}
