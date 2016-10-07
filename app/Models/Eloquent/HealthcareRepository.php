<?php
namespace Shine\Repositories\Eloquent;

use Shine\Repositories\Eloquent\BaseRepository as AbstractRepository;
use Shine\Repositories\Contracts\HealthcareRepositoryInterface;
use Illuminate\Container\Container as App;
use Shine\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrder;

/**
 * This class only implements methods specific to the User Module
 */
class HealthcareRepository extends AbstractRepository implements HealthcareRepositoryInterface
{

    /**
     * @var App
     */
    private $app;

     /**
     * @var Model
     */
    protected $modelClassName;

    /**
     * [__construct description]
     * @param App $app [description]
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }
    public function model() {
        return 'ShineOS\Core\Healthcareservices\Entities\Healthcareservices';
    }

    /**
     * Find by healthcareservice_id
     * @return  json
     */
    public function findVitalsByHealthcareserviceid($healthcareservice_id, $return_type = NULL) {
        $data = Healthcareservices::with('VitalsPhysical')->has('VitalsPhysical')->where('healthcareservice_id', $healthcareservice_id)->first();

        if ($return_type == 'arr')
        {
            return $data;
        }

        return json_encode($data);
    }

    public function findDiagnosisByHealthcareserviceid($healthcareservice_id, $return_type = NULL) {
        $data = Diagnosis::with('DiagnosisICD10')->where('healthcareservice_id', $healthcareservice_id)->get();

        if ($return_type == 'arr')
        {
            return $data;
        }

        return json_encode($data);
    }

    public function findExaminationsByHealthcareserviceid($healthcareservice_id, $return_type = NULL) {
        $data = Healthcareservices::with('Examination')->has('Examination')->where('healthcareservice_id', $healthcareservice_id)->first();

        if ($return_type == 'arr')
        {
            return $data;
        }

        return json_encode($data);
    }

    public function findMedicalOrdersByHealthcareserviceid($healthcareservice_id, $return_type = NULL) {
        $data = MedicalOrder::with('MedicalOrderLabExam')->with('MedicalOrderPrescription')->with('MedicalOrderProcedure')->where('healthcareservice_id', $healthcareservice_id)->get();

        if ($return_type == 'arr')
        {
            return $data;
        }

        return json_encode($data);
    }

    public function findMaintenanceDrugsByPatientid($patient_id, $return_type = NULL) {

        $maintenancemeds =  Healthcareservices::join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
                ->join('patients','patients.patient_id','=','facility_patient_user.patient_id')
                ->join('medicalorder','medicalorder.healthcareservice_id','=','healthcare_services.healthcareservice_id')
                ->leftJoin('medicalorder_prescription','medicalorder_prescription.medicalorder_id','=','medicalorder.medicalorder_id')
                ->where('patients.patient_id', $patient_id)
                ->where('patients.deleted_at', NULL)
                ->where('medicalorder_prescription.duration_of_intake', '  C' )
                ->where('facility_patient_user.deleted_at', NULL)
                ->get();

        /*MedicalOrder::with('MedicalOrderLabExam')->with('MedicalOrderPrescription')->with('MedicalOrderProcedure')->with('facilityPatientUser')->with('patients')->where('patient_id', $patient_id)->get();*/

        if ($return_type == 'arr')
        {
            return $maintenancemeds;
        }

        return json_encode($maintenancemeds);
    }

    public function findDispositionByHealthcareserviceid($healthcareservice_id, $return_type = NULL) {
        $data = Healthcareservices::with('Disposition')->has('Disposition')->where('healthcareservice_id', $healthcareservice_id)->first();

        if ($return_type == 'arr')
        {
            return $data;
        }

        return json_encode($data);
    }

    public function findGeneralConsultationByHealthcareserviceid($healthcareservice_id, $return_type = NULL) {
        $data = Healthcareservices::with('GeneralConsultation')->has('GeneralConsultation')->where('healthcareservice_id', $healthcareservice_id)->first();

        if ($return_type == 'arr')
        {
            return $data;
        }

        return json_encode($data);
    }

    public function allFormsByHealthcareserviceid($healthcareservice_id, $return_type = NULL) {
        $data = Healthcareservices::with(array('GeneralConsultation', 'VitalsPhysical', 'Diagnosis' => function($query) {
                $query->with('DiagnosisICD10');
            },
            'Examination', 'MedicalOrder', 'Disposition' => function($query) {
                $query->whereNotNull('disposition');
            }, 'Addendum' => function($query) {
                $query->orderBy('created_at', 'DESC');
            }
            )
        )
        ->where('healthcareservice_id', $healthcareservice_id)->get();

        if ($return_type == 'arr')
        {
            return $data;
        }

        return json_encode($data);
    }

    /**
     * Find by Facility
     * @return  json
     */
    public function findHealthcareByFacilityID($facility_id, $limit = NULL, $skip = NULL, $return_type = NULL) {
        $healthcare = Healthcareservices::join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
                ->join('facility_user','facility_patient_user.facilityuser_id','=','facility_user.facilityuser_id')
                ->join('facilities','facilities.facility_id','=','facility_user.facility_id')
                ->join('patients','patients.patient_id','=','facility_patient_user.patient_id')
                ->where('facilities.facility_id', $facility_id)
                ->where('healthcare_services.deleted_at','=',NULL)
                ->where('facility_patient_user.deleted_at','=',NULL)
                ->where('patients.deleted_at','=',NULL)
                ->orderBy('healthcare_services.encounter_datetime', 'DESC')
                ->skip($skip)
                ->take($limit)
                ->get();

        if ($return_type == 'arr')
        {
            return $healthcare;
        }

        return $healthcare->toJson();
    }

    public function findHealthcareByPatientID($patient_id, $limit = NULL, $return_type = NULL) {
        $healthcare = Healthcareservices::join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
                ->join('facility_user','facility_patient_user.facilityuser_id','=','facility_user.facilityuser_id')
                ->join('facilities','facilities.facility_id','=','facility_user.facility_id')
                ->join('patients','patients.patient_id','=','facility_patient_user.patient_id')
                ->where('patients.patient_id', $patient_id)
                ->where('patients.deleted_at', NULL)
                ->where('facility_patient_user.deleted_at', NULL)
                ->orderBy('healthcare_services.encounter_datetime', 'DESC')
                ->take($limit)
                ->get();

        if ($return_type == 'arr')
        {
            return $healthcare;
        }

        return $healthcare->toJson();
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel() {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->modelClassName = $model;
    }
}
