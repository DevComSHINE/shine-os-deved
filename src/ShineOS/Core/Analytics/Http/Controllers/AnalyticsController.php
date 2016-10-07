<?php namespace ShineOS\Core\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Patients\Models\Patients;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Referrals\Entities\Referrals;
use Shine\Libraries\FacilityHelper;

use View,
    Response,
    Validator,
    Input,
    Mail,
    Session,
    Redirect,
    Hash,
    Auth,
    DateTime,
    DB;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        //variables to share to all view
        //View::share('assetPath', Module::getAssetsPath());
    }

    public function index()
    {
        $facility_id = FacilityHelper::facilityInfo();
        $data['chart'] = $this->getData();
        $data['patient_count'] = Patients::count();
        $data['visit_count'] = Healthcareservices::count();
        $data['referral_count'] = Referrals::where('facility_id', '=', $facility_id->facility_id)->count(); // change this to facility ID

        return view('analytics::index')->with($data);
    }

    public function getData ($type=NULL, $from=NULL, $to=NULL)
    {
        if ($type == 'patient'):
            $patient_stats = $this->getPatientData($from, $to);
            $patient_stats1 = $this->getVisitData($from, $to);
            dd($patient_stats1);
        else:
            $this->getVisitData($from, $to);
        endif;
    }

    public function getPatientData($from=NULL, $to=NULL)
    {
        $data = array();

        if ($from == NULL):
            $from = new DateTime('tomorrow -1 week');
            $to = new DateTime();
        else:
            $from = $from;
            $to = date("Y-m-d H:i:s", $to);
        endif;

        /**
         * Change query / variable name
         */
        $data['query_1'] = DB::select('SELECT patients.last_name, count(*) as visits FROM healthcare_services JOIN facility_patient_user ON healthcare_services.facilitypatientuser_id = facility_patient_user.facilitypatientuser_id JOIN patients ON facility_patient_user.patient_id = patients.patient_id WHERE healthcare_services.created_at > :from_date AND healthcare_services.created_at < :to_date GROUP BY healthcare_services.facilitypatientuser_id ORDER BY count(*) DESC LIMIT 10', ['from_date' => $from, 'to_date', $to]);
        $data['query_2'] = DB::select('SELECT last_name, first_name, middle_name, patient_id, gender, age, count(*) FROM patients WHERE patients.created_at > :from_date AND patients.created_at < :to_date group by age, gender', ['from_date' => $from, 'to_date', $to]);
        $data['query_3'] = DB::select('SELECT healthcare_servicetype_name, count(*) FROM healthcare_services JOIN lov_healthcare_service_type ON healthcare_services.healthcareservicetype_id = lov_healthcare_service_type.healthcareservicetype_id WHERE healthcare_services.created_at > :from_date AND healthcare_services.created_at < :to_date group by facilitypatientuser_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date', $to]);
        $data['query_4'] = DB::select('SELECT healthcare_servicetype_name, count(*) FROM healthcare_services JOIN lov_healthcare_service_type ON healthcare_services.healthcareservicetype_id = lov_healthcare_service_type.healthcareservicetype_id JOIN general_consultation ON healthcare_services.healthcareservice_id = general_consultation.healthcareservice_id JOIN diagnosis ON healthcare_services.healthcareservice_id = diagnosis.healthcareservice_id JOIN lov_diseases ON diagnosis.diagnosislist_id = lov_diseases.disease_id WHERE healthcare_services.created_at > :from_date AND healthcare_services.created_at < :to_date group by facilitypatientuser_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date', $to]);

        return $data;
    }

    public function getVisitData($from=NULL, $to=NULL)
    {
        $data = array();

        if ($from == NULL):
            $from = new DateTime('tomorrow -1 week');
            $to = new DateTime();
        else:
            $from = $from;
            $to = date("Y-m-d H:i:s", $to);
        endif;

        /**
         * Change query / variable name
         */
        $data['query_1a'] = DB::select('SELECT healthcare_servicetype_name,count(*) as visits FROM healthcare_services JOIN lov_healthcare_service_type ON healthcare_services.healthcareservicetype_id = lov_healthcare_service_type.healthcareservicetype_id
WHERE healthcare_services.created_at > :from_date AND healthcare_services.created_at < :to_date group by healthcare_services.healthcareservicetype_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date', $to]);
        $data['query_2a'] = DB::select('SELECT count(*) as a FROM healthcare_services WHERE healthcare_services.created_at > :from_date AND healthcare_services.created_at < :to_date ORDER BY a DESC', ['from_date' => $from, 'to_date', $to]);
        $data['query_3a'] = DB::select('SELECT lov_diseases.disease_name, count(*) FROM healthcare_services JOIN lov_healthcare_service_type ON healthcare_services.healthcareservicetype_id = lov_healthcare_service_type.healthcareservicetype_id JOIN diagnosis ON healthcare_services.healthcareservice_id = diagnosis.healthcareservice_id JOIN lov_diseases ON diagnosis.diagnosislist_id = lov_diseases.disease_id WHERE healthcare_services.created_at > :from_date AND healthcare_services.created_at < :to_date GROUP BY healthcare_services.healthcareservicetype_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date', $to]);

        return $data;
    }
}
