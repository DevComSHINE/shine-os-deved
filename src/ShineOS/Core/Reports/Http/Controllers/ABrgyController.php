<?php
namespace ShineOS\Core\Reports\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use ShineOS\Core\Facilities\Entities\FacilityUser;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Patients\Entities\PatientDeathInfo;

use ShineOS\Core\Referrals\Entities\Referrals;
use ShineOS\Core\Reports\Entities\Reports;
use ShineOS\Core\Reports\Entities\M1;
use ShineOS\Core\Reports\Entities\M2;
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

class ABrgyController extends Controller {

    protected $moduleName = 'Reports';
    protected $modulePath = 'Reports';
    protected $viewPath = 'reports::pages.';
    protected $fhsisPath = 'reports::pages.fhsis_reports.abrgy';

    public function __construct()
    {
        $this->thisfacility = Session::get('facility_details');
        $this->facility_id = $this->thisfacility->facility_id;
    }

    public function index()
    {
    }

    public function getGeoData( $year )
    {
        $file = 'Plugins\\ShineLab_Geodata\\GeodataModel';
        if(file_exists($file))
        {
            $geodatamodel = new $file;
            $geodata = $geodatamodel::where('facility_id', $this->facility_id)
                                        ->whereYear('created_at', '=', $year)
                                        ->orderBy('created_at', 'DESC')
                                        ->first();
            return $geodata;
        }
        return NULL;
    }

    public function getNeonatal( $year )
    {
        $neonatal = array();

        $livebirth_termination_outcome = array('001','002','003','005','006','009','999');
        $fetal_death_termination_outcome = array('004');
        $abortion_termination_outcome = array('007');
        $death_termination_outcome = array('008');

        $male = 'M';
        $female = 'F';
        $unknown = 'U';

        $neonatal['pregnancies']['male']['count']                       = $this->doQueryNeonatal($year, NULL, $male, NULL, NULL, NULL, NULL, NULL);
        $neonatal['pregnancies']['female']['count']                     = $this->doQueryNeonatal($year, NULL, $female, NULL, NULL, NULL, NULL, NULL);
        $neonatal['pregnancies']['count']                               = $neonatal['pregnancies']['male']['count'] + $neonatal['pregnancies']['male']['count'];

        $neonatal['livebirths']['count']                                 = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, NULL, NULL, NULL, NULL);

        $neonatal['livebirths']['male']['count']                         = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, NULL, NULL, NULL, NULL);
        $neonatal['livebirths']['female']['count']                       = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, NULL, NULL, NULL, NULL);

        $neonatal['livebirths']['greater_weight']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, 'greater', NULL, NULL, NULL);
        $neonatal['livebirths']['male']['greater_weight']['count']       = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, 'greater', NULL, NULL, NULL);
        $neonatal['livebirths']['female']['greater_weight']['count']     = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, 'greater', NULL, NULL, NULL);

        $neonatal['livebirths']['lesser_weight']['count']                = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, 'lesser', NULL, NULL, NULL);
        $neonatal['livebirths']['male']['lesser_weight']['count']        = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, 'lesser', NULL, NULL, NULL);
        $neonatal['livebirths']['female']['lesser_weight']['count']      = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, 'lesser', NULL, NULL, NULL);

        $neonatal['livebirths']['unknown_weight']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, 'unknown', NULL, NULL, NULL);
        $neonatal['livebirths']['male']['unknown_weight']['count']       = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, 'unknown', NULL, NULL, NULL);
        $neonatal['livebirths']['female']['unknown_weight']['count']     = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, 'unknown', NULL, NULL, NULL);

        $neonatal['livebirths']['doctor']['count']                       = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, NULL, '001', NULL, NULL);
        $neonatal['livebirths']['male']['doctor']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, NULL, '001', NULL, NULL);
        $neonatal['livebirths']['female']['doctor']['count']             = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, NULL, '001', NULL, NULL);

        $neonatal['livebirths']['nurse']['count']                       = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, NULL, '002', NULL, NULL);
        $neonatal['livebirths']['male']['nurse']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, NULL, '002', NULL, NULL);
        $neonatal['livebirths']['female']['nurse']['count']             = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, NULL, '002', NULL, NULL);

        $neonatal['livebirths']['midwife']['count']                       = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, NULL, '003', NULL, NULL);
        $neonatal['livebirths']['male']['midwife']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, NULL, '003', NULL, NULL);
        $neonatal['livebirths']['female']['midwife']['count']             = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, NULL, '003', NULL, NULL);

        $neonatal['livebirths']['hilot']['count']                       = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, NULL, '004', NULL, NULL);
        $neonatal['livebirths']['male']['hilot']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, NULL, '004', NULL, NULL);
        $neonatal['livebirths']['female']['hilot']['count']             = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, NULL, '004', NULL, NULL);

        $neonatal['livebirths']['other']['count']                       = $this->doQueryNeonatal($year, $livebirth_termination_outcome, NULL, NULL, NULL, '999', NULL, NULL);
        $neonatal['livebirths']['male']['other']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, NULL, NULL, '999', NULL, NULL);
        $neonatal['livebirths']['female']['other']['count']             = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, NULL, NULL, '999', NULL, NULL);

        $neonatal['fetal_death']['count']                               = $this->doQueryNeonatal($year, $fetal_death_termination_outcome, NULL, NULL, NULL, NULL, NULL, NULL);
        $neonatal['fetal_death']['male']['count']                        = $this->doQueryNeonatal($year, $fetal_death_termination_outcome, $male, NULL, NULL, NULL, NULL, NULL);
        $neonatal['fetal_death']['female']['count']                      = $this->doQueryNeonatal($year, $fetal_death_termination_outcome, $female, NULL, NULL, NULL, NULL, NULL);

        $neonatal['abortion']['count']                                  = $this->doQueryNeonatal($year, $abortion_termination_outcome, NULL, NULL, NULL, NULL, NULL, NULL);
        $neonatal['abortion']['male']['count']                           = $this->doQueryNeonatal($year, $abortion_termination_outcome, $male, NULL, NULL, NULL, NULL, NULL);
        $neonatal['abortion']['female']['count']                         = $this->doQueryNeonatal($year, $abortion_termination_outcome, $female, NULL, NULL, NULL, NULL, NULL);

        $neonatal['delivery']['male']['normal']['count']                 = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'N', NULL, NULL, NULL, NULL);
        $neonatal['delivery']['female'] ['normal']['count']              = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, 'N', NULL, NULL, NULL, NULL);
        $neonatal['delivery']['normal']['count']                        = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'N', NULL, NULL, NULL, NULL);
        $neonatal['delivery']['normal']['home']['count']                = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'N', NULL, NULL, 'NID', 'hme');
        $neonatal['delivery']['normal']['facility']['count']            = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'N', NULL, NULL, 'FB', NULL);
        $neonatal['delivery']['normal']['other']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'N', NULL, NULL, 'NID', 'oth');

        $neonatal['delivery']['male'] ['operative']['count']             = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'O', NULL, NULL, NULL, NULL);
        $neonatal['delivery']['female']['operative']['count']            = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $female, 'O', NULL, NULL, NULL, NULL);
        $neonatal['delivery']['operative']['count']                      = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'O', NULL, NULL, NULL, NULL);
        $neonatal['delivery']['operative']['home']['count']               = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'O', NULL, NULL, 'NID', 'hme');
        $neonatal['delivery']['operative']['facility']['count']         = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'O', NULL, NULL, 'FB', NULL);
        $neonatal['delivery']['operative']['other']['count']            = $this->doQueryNeonatal($year, $livebirth_termination_outcome, $male, 'O', NULL, NULL, 'NID', 'oth');

        return $neonatal;
    }

    public function doQueryNeonatal( $year, $termination_outcome = NULL, $gender = NULL, $delivery_type = NULL, $weight = NULL, $attended_by = NULL, $type_place = NULL, $place = NULL )
    {
        $result = 0;

        $file_1 = 'Plugins\\MaternalCare\\MaternalCareModel';
        if(file_exists($file_1))
        {
            $maternalmodel = new $file_1;
            $facilityusers = FacilityUser::where('facility_id', $this->facility_id)->lists('facilityuser_id');
            $facilitypatientusers = FacilityPatientUser::whereIn('facilityuser_id',$facilityusers)->lists('facilitypatientuser_id');
            $healthcareservices = Healthcareservices::whereIn('facilitypatientuser_id', $facilitypatientusers)->lists('healthcareservice_id');
            $maternalcare = $maternalmodel::whereIn('healthcareservice_id', $healthcareservices)->lists('maternalcase_id');

            $file_2 = 'Plugins\\MaternalCare\\MaternalCareDeliveryModel';
            if(file_exists($file_2))
            {
                $maternaldeliverymodel = new $file_2;
                $result = $maternaldeliverymodel::whereIn('maternalcase_id', $maternalcare)
                                                        ->terminationoutcome($termination_outcome)
                                                        ->gender($gender)
                                                        ->deliverytype($delivery_type)
                                                        ->weight($weight)
                                                        ->attendedby($attended_by)
                                                        ->typeplace($type_place)
                                                        ->place($place)
                                                        ->whereYear('termination_datetime', '=', $year)
                                                        ->count();
            }
        }
        return $result;
    }

    public function getMortality( $year )
    {
        $mortality = array();

        $facilityusers = FacilityUser::where('facility_id', $this->facility_id)->lists('facilityuser_id');
        $patients = FacilityPatientUser::whereIn('facilityuser_id',$facilityusers)->lists('patient_id');


        $mortality['maternal']['count'] = PatientDeathInfo::whereIn('patient_id', $patients)
                                                    ->where('Type_of_Death', 'M')
                                                    ->whereYear('datetime_death', '=', $year)
                                                    ->count();

        $mortality['male'] = PatientDeathInfo::whereHas('patients', function($query) {$query->where('gender', 'M');})
                                                    ->whereIn('patient_id', $patients)
                                                    ->whereYear('datetime_death', '=', $year)
                                                    ->get(); 
        $mortality['under_five']['male']['count'] = $this->countUnderFive($mortality['male']);
        $mortality['male']['count'] = count($mortality['male']);

        $mortality['female'] = PatientDeathInfo::whereHas('patients', function($query) {$query->where('gender', 'F');})
                                                    ->whereIn('patient_id', $patients)
                                                    ->whereYear('datetime_death', '=', $year)
                                                    ->get();
        $mortality['under_five']['female']['count'] = $this->countUnderFive($mortality['female']);
        $mortality['female']['count'] = count($mortality['female']);


        $mortality['neonatal']['male']['count'] = PatientDeathInfo::whereHas('patients', function($query) {$query->where('gender', 'M');})
                                                    ->whereIn('patient_id', $patients)
                                                    ->where('Type_of_Death', 'N')
                                                    ->whereYear('datetime_death', '=', $year)
                                                    ->count();

        $mortality['neonatal']['female']['count'] = PatientDeathInfo::whereHas('patients', function($query) {$query->where('gender', 'F');})
                                                    ->whereIn('patient_id', $patients)
                                                    ->where('Type_of_Death', 'N')
                                                    ->whereYear('datetime_death', '=', $year)
                                                    ->count();

        return $mortality;
    }

    public function countUnderFive( $data )
    {
        $count = 0;
        if(count($data) > 0)
        {
            foreach ($data as $key => $value)
            {
                if( date_diff(date_create(findPatientByPatientID($value->patient_id)->birthdate), date_create($value->datetime_death))->y <= 5 )
                {
                    $count += 1;
                }
            }
        }
        return $count;
    }

}
