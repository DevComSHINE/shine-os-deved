<?php

namespace ShineOS\Controllers;

use ShineOS\View;
use ShineOS\Install;
use Shine\Libraries\UserHelper;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use ShineOS\Core\Reports\Entities\M2;
use \Cache;
use \Event;
use \Session;
use \Redirect;
use \URL;

use Module;

class DefaultController extends Controller {

    public function __construct($app = null) {
        if (!is_object($this->app)){

            if (is_object($app)){
                $this->app = $app;
            } else {
                $this->app = shineos();
            }
        }

    }

    public function index() {
        $is_installed = shineos_is_installed();
        if (!$is_installed){
            $installer = new InstallController($this->app);
            return Redirect::to('install');
        }

        return Redirect::to('dashboard/');
    }

    public $return_data = false;
    public $page_url = false;
    public $create_new_page = false;
    public $render_this_url = false;
    public $isolate_by_html_id = false;
    public $functions = array();
    public $page = array();
    public $params = array();
    public $vars = array();
    public $app;


    public function track() {

        $facility = Session::get('facility_details');
        $curUser = Session::get('user_details');

        if(isset($curUser)) {
            $user = $curUser->user_id;
        } else {
            $user = NULL;
        }

        $json = array(
            'date' => date('Y-m-d H:i:s'),
            'url' => stripslashes($_POST['url']),
            'user_id' => $user,
            'element' => $_POST['element'],
            'element_type' => $_POST['type'],
            'element_name' => $_POST['name'],
            'element_id' => $_POST['ID'],
            'element_label' => $_POST['label'],
            'curvalue' => $_POST['curvalue'],
            'action' => $_POST['action'],
            'msg' => 'test'
        );
        $text = json_encode($json, JSON_UNESCAPED_SLASHES);

        $data['user_id'] = $user;
        $data['facility_id'] = $facility->facility_id;
        $data['datetime'] = date('Y-m-d H:i:s');
        $data['json'] = $text;

        DB::table('tracker')->insert($data);

        $results['result'] = "OK";
        echo json_encode($json);

    }

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
        AND DATE(a.updated_at) = '".date('Y-m-d')."'
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
    }

}
