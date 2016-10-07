<?php
namespace ShineOS\Core\Reports\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Referrals\Entities\Referrals;
use ShineOS\Core\Reports\Entities\Reports;
use ShineOS\Core\Reports\Entities\M1;
use ShineOS\Core\Reports\Entities\M2;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\Utils;

use ShineOS\Core\Reports\Http\Controllers\ABrgyController;

use View,
    Response,
    Validator,
    Input,
    Mail,
    Session,
    Cache,
    Redirect,
    Hash,
    Auth,
    DateTime,
    DB;

class ReportsController extends Controller {

    protected $moduleName = 'Reports';
    protected $modulePath = 'Reports';
    protected $viewPath = 'reports::pages.';
    protected $fhsisPath = 'reports::pages.fhsis_reports.';

    public function __construct()
    {
        View::addNamespace('reports', 'src/ShineOS/Core/Reports/Resources/Views');

        $this->abrgycontroller = new ABrgyController;
    }

    public function index()
    {
        $thisfacility = json_decode(Session::get('facility_details'));

        if ($thisfacility->ownership_type == 'PRIVATE')
        {
            return $this->privateFacilityReports();
        }
        else
        {
            return $this->publicFacilityReports();
        }
    }

    private function privateFacilityReports()
    {
        $data['facility'] = json_decode(Session::get('facility_details'));

        return view($this->viewPath.'private', $data);
    }

    private function publicFacilityReports()
    {
        $data['facility'] = json_decode(Session::get('facility_details'));

        return view($this->viewPath.'public', $data);
    }

    private function analytics()
    {
        $facility = FacilityHelper::facilityInfo();

        //to be removed later on
        $facility_id = FacilityHelper::facilityInfo();
        $data['chart'] = $this->getData();
        $data['patient_count'] = Patients::whereHas('facilityUser', function($query) use ($facility) {
                    $query->where('facility_id', '=', $facility_id->facility_id); })->count();
        $data['visit_count'] = Healthcareservices::count();
        $data['referral_count'] = Referrals::where('facility_id', '=', $facility_id->facility_id)->count(); // change this to facility ID

        return $data;
    }

    private function getFilteredResults ()
    {
        $from = Input::get('from');
        $to = Input::get('to');
        $filterBy = Input::get('filterBy');

        echo Reports::getGraphByAge($from,$to);
    }

    private function getData ($type=NULL, $from=NULL, $to=NULL)
    {
        if ($type == 'patient'):
            $patient_stats = Reports::getPatientData($from, $to);
            $patient_stats1 = Reports::getVisitData($from, $to);
            //dd($patient_stats1);
        else:
            Reports::getVisitData($from, $to);
        endif;
    }

    private function getReportDataJSON()
    {
        $data = array();

        if (Input::get('from') == NULL):
            $from = new DateTime('tomorrow -1 week');
            $from = $from->format('Y-m-d H:i:s');
            $to = new DateTime();
            $to = $to->format('Y-m-d H:i:s');
        else:
            $from = Input::get('from');
            $to = Input::get('to');
        endif;

        /**
         * Change query / variable name
         */
        $data['top_patients'] = DB::select('SELECT patients.last_name, patients.first_name, patients.middle_name, count(*) as visits FROM healthcare_services JOIN facility_patient_user ON healthcare_services.facilitypatientuser_id = facility_patient_user.facilitypatientuser_id JOIN patients ON facility_patient_user.patient_id = patients.patient_id WHERE healthcare_services.created_at BETWEEN :from_date AND :to_date AND facility_patient_user.deleted_at = NULL AND patients.deleted_at = NULL GROUP BY healthcare_services.facilitypatientuser_id ORDER BY count(*) DESC LIMIT 10', ['from_date' => $from, 'to_date', $to]);

        $data['count_by_gender_sex'] = DB::select('SELECT last_name, first_name, middle_name, patient_id, gender, age, count(*) as total FROM patients JOIN facility_patient_user ON patients.patient_id = facility_patient_user.patient_id WHERE patients.created_at BETWEEN :from_date AND :to_date AND facility_patient_user.deleted_at = NULL AND patients.deleted_at = NULL group by age, gender', ['from_date' => $from, 'to_date', $to]);
        $data['count_by_gender_sex'] = isset($data['count_by_gender_sex'][0]) ? $data['count_by_gender_sex'][0]->total : 0;

        $data['count_by_services_rendered'] = DB::select('SELECT healthcareservicetype_id, count(*) as total FROM healthcare_services JOIN facility_patient_user ON healthcare_services.facilitypatientuser_id = facility_patient_user.facilitypatientuser_id WHERE healthcare_services.created_at BETWEEN :from_date AND :to_date AND facility_patient_user.deleted_at = NULL group by facilitypatientuser_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date', $to]);
        $data['count_by_services_rendered'] = isset($data['count_by_services_rendered'][0]) ? $data['count_by_services_rendered'][0]->total : 0;

        $data['count_by_disease'] = DB::select('SELECT healthcareservicetype_id, count(*) as total FROM healthcare_services JOIN general_consultation ON healthcare_services.healthcareservice_id = general_consultation.healthcareservice_id JOIN diagnosis ON healthcare_services.healthcareservice_id = diagnosis.healthcareservice_id JOIN lov_diseases ON diagnosis.diagnosislist_id = lov_diseases.disease_id JOIN facility_patient_user ON healthcare_services.facilitypatientuser_id = facility_patient_user.facilitypatientuser_id WHERE healthcare_services.created_at BETWEEN :from_date AND :to_date AND facility_patient_user.deleted_at = NULL group by facilitypatientuser_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date', $to]);
        $data['count_by_disease'] = isset($data['count_by_disease'][0]) ? $data['count_by_disease'][0]->total : 0;

        echo json_encode($data);
    }

    public function m1()
    {
        $facilityInfo = Session::get('user_details');
        $facility = FacilityHelper::facilityInfo();
        $facility_id = $facilityInfo->facilities[0]->facility_id;

        $month = Input::get('month') ? Input::get('month') : date('n');
        $year = Input::get('year') ? Input::get('year') : date('Y');
/*
        //$a = FacilityPatientUser::with('familyPlanning')->get();
        $sql = "SELECT g.facility_id, a.`current_method`, a.`previous_method`, SUM(a.`client_type`= 'CU') as 'CU', SUM(a.`client_type`='NA') as 'NA', SUM(a.`client_type`='CC') as 'CC', SUM(a.`client_type`='CM') as 'CM', SUM(a.`client_type`='RS') as 'RS', SUM(a.`client_type`='dropout_date') as 'Dropout', MONTH(a.`created_at`) as FPmonth, YEAR(a.`created_at`) as FPyear, count(a.`previous_method`) as 'FP_count', a.created_at
FROM `familyplanning_service` a
JOIN healthcare_services b ON b.healthcareservice_id = a.healthcareservice_id
JOIN facility_patient_user c ON c.facilitypatientuser_id = b.facilitypatientuser_id
JOIN facility_user g ON g.facilityuser_id = c.facilityuser_id
JOIN facilities h ON h.facility_id = g.facility_id
WHERE g.facility_id = '$facility_id'
GROUP BY a.`previous_method`, g.facility_id
ORDER BY FPyear DESC, FPmonth DESC
LIMIT 0, 500";
        $a = DB::select( DB::raw( $sql )); dd($facility_id, $a);
        //$facilityInfo = Session::get('user_details');
        //$facility = FacilityHelper::facilityInfo();
        //$a = M1::prenatalVisits('01')->get();
        // $a = findAllFacilitiesDetails($thisfacility->facility_id);
*/
        return view($this->fhsisPath.'m1', compact('facilityInfo', 'facility', 'month', 'year'));
    }

    public function m2()
    {
        $facilityInfo = Session::get('user_details');
        $facility = FacilityHelper::facilityInfo();

        $month = Input::get('month') ? Input::get('month') : date('n');
        $year = Input::get('year') ? Input::get('year') : date('Y');

        $m2 = $this->generateReport(NULL, $month, $year);

        $diseases = getDiseases();
        $ageGroup = getAgeGroups();

        return view($this->fhsisPath.'m2', compact('m2', 'diseases', 'ageGroup', 'month', 'year', 'facilityInfo', 'facility'));
    }

    public function q1()
    {
        return view($this->fhsisPath.'q1');
    }

    public function q2()
    {
        $month = Input::get('month') ? Input::get('month') : date('n');
        $year = Input::get('year') ? Input::get('year') : date('Y');

        $m2 = $this->generateReport($month, $year);

        return view($this->fhsisPath.'q2', compact('m2'));
    }

    public function abrgy()
    {
        $facilityInfo = Session::get('facility_details');
        $dateNow = new DateTime();
        $yearNow = $dateNow->format("Y");

        $year = Input::get('year') ? Input::get('year') : $yearNow;

        $geodata = $this->abrgycontroller->getGeoData($year);
        $neonatal = $this->abrgycontroller->getNeoNatal($year);
        $mortality= $this->abrgycontroller->getMortality($year);

        return view($this->fhsisPath.'abrgy', compact('geodata','neonatal', 'mortality','facilityInfo'));
    }

    public function a1()
    {
        $dateNow = new DateTime();
        $yearNow = $dateNow->format("Y");

        $year = Input::get('year') ? Input::get('year') : $yearNow;

        $m2 = $this->generateReport('morbidity', NULL, $year);

        return view($this->fhsisPath.'a1', compact('m2'));
    }

    public function a2()
    {
        $dateNow = new DateTime();
        $yearNow = $dateNow->format("Y");

        $year = Input::get('year') ? Input::get('year') : $yearNow;

        $m2 = $this->generateReport(NULL, NULL, $year);

        return view($this->fhsisPath.'a2', compact('m2'));
    }

    public function a3()
    {
        $dateNow = new DateTime();
        $yearNow = $dateNow->format("Y");

        $year = Input::get('year') ? Input::get('year') : $yearNow;

        $m2 = $this->generateReport('morbidity', NULL, $year);

        return view($this->fhsisPath.'a3', compact('m2'));
    }

    private function generateReport($type=NULL, $month=NULL, $year=NULL)
    {
        $diseases = getDiseases();
        $ageGroup = getAgeGroups();
        $type = ($type == NULL) ? 'count' : $type;

        $m2 = array();

        foreach ($diseases as $k => $v):
            $m2[$k]['code'] = $v;

            foreach($ageGroup as $key => $val):
                $m2[$k]['details'][$val]['F'] = $this->getDiseaseCount($type, 'F', $val, $k, NULL, $month, $year);
                $m2[$k]['details'][$val]['M'] = $this->getDiseaseCount($type, 'M', $val, $k, NULL, $month, $year);
            endforeach;
        endforeach;

        return $m2;
    }

    private function getDiseaseCount($type, $gender, $age, $disease, $disease_code = NULL, $month = NULL, $year = NULL)
    {
        $facilityInfo = Session::get('user_details');
        $facility_id = $facilityInfo->facilities[0]->facility_id;
        $age = explode("-",$age);

        if ($type == 'count'): // count only

            $disease_count = DB::table('fhsis_m2')
                ->where('gender', $gender)
                ->whereRaw( "(`diagnosislist_id` LIKE '%".$disease."%' OR `icd10_code` = '".$disease_code."' )" )
                ->where('facility_id', $facility_id)
                ->where('diagnosisMonth', $month)
                ->where('diagnosisYear', $year)
                ->whereBetween('age', array($age[0], $age[1]))
                ->sum('count');

        elseif ($type == 'morbidity'): // exclusive to a3 report only
            //$disease_count = FacilityPatientUser::select('facilitypatientuser_id')->sex($gender)->agerange($age)->hasdiagnosis($disease)->isdead($year)->hasicd10($disease_code)->encounter($month, $year)->orderBy('created_at')->count();
            $disease_count = DB::table('fhsis_m2')
                ->where('gender', $gender)
                ->where('facility_id', $facilityInfo->facility_id)
                ->where('diagnosisMonth', $month)
                ->where('diagnosisYear', $year)
                ->where('deathYear', $year)
                ->whereBetween('age', array($age[0], $age[1]))
                ->sum('count');

        else: // get all patients data
            $disease_count = FacilityPatientUser::sex($gender)->agerange($age)->hasdiagnosis($disease)->hasicd10($disease_code)->encounter($month, $year)->orderBy('created_at')->get();
        endif;

        return $disease_count;
    }

}
