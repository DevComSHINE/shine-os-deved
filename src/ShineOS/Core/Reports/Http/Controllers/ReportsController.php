<?php
namespace ShineOS\Core\Reports\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Reports\Entities\Reports;
use ShineOS\Core\Reports\Entities\M1;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\Utils;

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
        View::addNamespace('analytics', 'src/ShineOS/Core/Analytics/Resources/Views');
        View::addNamespace('reports', 'src/ShineOS/Core/Reports/Resources/Views');
    }

    public function index()
    {
        //$thisfacility = json_decode(Cache::get('facility_details'));
        $thisfacility = json_decode(Session::get('facility_details'));

        if ($thisfacility->ownership_type == 'private')
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
        $data = $this->analytics();

        return view($this->viewPath.'private')->with($data);
    }

    private function publicFacilityReports()
    {
        $data = $this->analytics();

        return view($this->viewPath.'public')->with($data);
    }

    private function analytics()
    {
        $facility = FacilityHelper::facilityInfo();

        $reportData = Reports::getReportData();

        $data['latest_patients'] = isset($reportData['latest_patients']) ? $reportData['latest_patients'] : NULL;
        $data['top_patients'] = isset($reportData['top_patients']) ? $reportData['top_patients'] : NULL;
        $data['total_patients_by_sex'] = isset($reportData['count_by_gender_sex']) ? $reportData['count_by_gender_sex'] : NULL;
        $data['count_by_gender_sex'] = isset($reportData['count_by_gender_sex'][0]) ? $reportData['count_by_gender_sex'][0]->total : 0;
        $data['count_by_age'] = isset($reportData['count_by_age']) ? $reportData['count_by_age'] : NULL;

        //dd($data['count_by_gender_age']);
        $data['count_by_services_rendered'] = isset($reportData['count_by_services_rendered'][0]) ? $reportData['count_by_services_rendered'][0]->total : 0;
        $data['count_by_disease'] = isset($reportData['count_by_disease'][0]) ? $reportData['count_by_disease'][0]->total : 0;

        //Graph
        $maxdate = date('Y-m-d H:i:s');
        $xdate = strtotime($maxdate .' -6 months');
        $mindate = date('Y-m-d', $xdate);
        $data['services'] = Healthcareservices::select('healthcareservicetype_id', DB::raw('count(*) as counter'))->where('created_at', '<=', $maxdate)->where('created_at', '>', $mindate)->groupBy('healthcareservicetype_id')->orderBy('counter')->get();
        $data['diagnosis'] = Diagnosis::select('diagnosis_type','diagnosislist_id', DB::raw('count(*) as bilang'))->where('created_at', '<=', $maxdate)->where('created_at', '>', $mindate)->groupBy('diagnosislist_id')->orderBy('bilang')->take(4)->get();
        $data['total'] = Healthcareservices::where('created_at', '<=', $maxdate)->where('created_at', '>', $mindate)->count();
        $data['cs_stats'] = [];

        for($d = 1; $d <= 6; $d++) {
            $xr = strtotime($mindate .' +'.$d.' months');
            $ranges[$d] = date('Y-m-d', $xr);
        }
        $data['ranges'] = $ranges;

        foreach($data['services'] as $service) {
            foreach($ranges as $range) {
                $max = date('Y-m-30 11:00:00', strtotime($range));
                $min = date('Y-m-01 00:00:00', strtotime($range));

                $bils = Healthcareservices::select(DB::raw('count(*) as bilang'))->where('created_at', '<=', $max)->where('created_at', '>', $min)->where('healthcareservicetype_id', $service->healthcareservicetype_id)->get();

                foreach($bils as $k=>$bil) {
                    $data['cs_stats'][$service->healthcareservicetype_id][$range] = $bil->bilang;
                }
            }
        }

        //exit;
        $facility_id = FacilityHelper::facilityInfo();
        $data['chart'] = $this->getData();
        $data['patient_count'] = Patients::whereHas('facilityUser', function($query) use ($facility) {
                    $query->where('facility_id', '=', $facility->facility_id); })->count();
        $data['visit_count'] = Healthcareservices::count();

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
        $data['top_patients'] = DB::select('SELECT patients.last_name, patients.first_name, patients.middle_name, count(*) as visits FROM healthcare_services JOIN facility_patient_user ON healthcare_services.facilitypatientuser_id = facility_patient_user.facilitypatientuser_id JOIN patients ON facility_patient_user.patient_id = patients.patient_id WHERE healthcare_services.created_at BETWEEN :from_date AND :to_date GROUP BY healthcare_services.facilitypatientuser_id ORDER BY count(*) DESC LIMIT 10', ['from_date' => $from, 'to_date', $to]);

        $data['count_by_gender_sex'] = DB::select('SELECT last_name, first_name, middle_name, patient_id, gender, age, count(*) as total FROM patients WHERE patients.created_at BETWEEN :from_date AND :to_date group by age, gender', ['from_date' => $from, 'to_date', $to]);
        $data['count_by_gender_sex'] = isset($data['count_by_gender_sex'][0]) ? $data['count_by_gender_sex'][0]->total : 0;

        $data['count_by_services_rendered'] = DB::select('SELECT healthcareservicetype_id, count(*) as total FROM healthcare_services WHERE healthcare_services.created_at BETWEEN :from_date AND :to_date group by facilitypatientuser_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date', $to]);
        $data['count_by_services_rendered'] = isset($data['count_by_services_rendered'][0]) ? $data['count_by_services_rendered'][0]->total : 0;

        $data['count_by_disease'] = DB::select('SELECT healthcareservicetype_id, count(*) as total FROM healthcare_services JOIN general_consultation ON healthcare_services.healthcareservice_id = general_consultation.healthcareservice_id JOIN diagnosis ON healthcare_services.healthcareservice_id = diagnosis.healthcareservice_id JOIN lov_diseases ON diagnosis.diagnosislist_id = lov_diseases.disease_id WHERE healthcare_services.created_at BETWEEN :from_date AND :to_date group by facilitypatientuser_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date', $to]);
        $data['count_by_disease'] = isset($data['count_by_disease'][0]) ? $data['count_by_disease'][0]->total : 0;

        echo json_encode($data);
    }

    public function m1()
    {
        $a = FacilityPatientUser::with('familyPlanning')->get();

        $thisfacility = json_decode(Session::get('_global_facility_info'));
        //$a = M1::prenatalVisits('01')->get();
        // $a = findAllFacilitiesDetails($thisfacility->facility_id);
        dd($a);

        return view($this->fhsisPath.'m1', compact('thisfacility'));
    }

    public function m2()
    {
        $month = Input::get('month') ? Input::get('month') : NULL;
        $year = Input::get('year') ? Input::get('year') : NULL;

        $m2 = $this->generateReport($month, $year);

        return view($this->fhsisPath.'m2', compact('m2'));
    }

    public function q1()
    {
        return view($this->fhsisPath.'q1');
    }

    public function q2()
    {
        $month = Input::get('month') ? Input::get('month') : NULL;
        $year = Input::get('year') ? Input::get('year') : NULL;

        $m2 = $this->generateReport($month, $year);

        return view($this->fhsisPath.'q2', compact('m2'));
    }

    public function abrgy()
    {
        $dateNow = new DateTime();
        $yearNow = $dateNow->format("Y");

        $year = Input::get('year') ? Input::get('year') : $yearNow;

        $m2 = $this->generateReport('morbidity', NULL, $year);

        return view($this->fhsisPath.'abrgy', compact('m2'));
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
        $age = explode("-",$age);

        if ($type == 'count'): // count only
            $disease_count = FacilityPatientUser::select('facilitypatientuser_id')->sex($gender)->agerange($age)->hasdiagnosis($disease)->hasicd10($disease_code)->encounter($month, $year)->orderBy('created_at')->count();
        elseif ($type == 'morbidity'): // exclusive to a3 report only
            $disease_count = FacilityPatientUser::select('facilitypatientuser_id')->sex($gender)->agerange($age)->hasdiagnosis($disease)->isdead($year)->hasicd10($disease_code)->encounter($month, $year)->orderBy('created_at')->count();
        else: // get all patients data
            $disease_count = FacilityPatientUser::sex($gender)->agerange($age)->hasdiagnosis($disease)->hasicd10($disease_code)->encounter($month, $year)->orderBy('created_at')->get();
        endif;

        return $disease_count;
    }
}
