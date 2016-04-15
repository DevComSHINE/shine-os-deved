<?php
namespace Shine\Repositories\Eloquent;

use Shine\Repositories\Eloquent\BaseRepository as AbstractRepository;
use Shine\Repositories\Contracts\FacilityRepositoryInterface;
use Illuminate\Container\Container as App;
use Shine\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * This class only implements methods specific to the User Module
 */
class FacilityRepository extends AbstractRepository implements FacilityRepositoryInterface
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

    public function findByFacilityName($name, $returnType= NULL)
    {
        $findByFacilityName = $this->modelClassName->where('facility_name', 'like', '%'.$name.'%')->first();
        
        return $this->getReturn($findByFacilityName, $returnType);
    }

    public function findByFacilityID($id, $returnType= NULL)
    {
        $findByFacilityID = $this->modelClassName->where('facility_id', $id)->first();

        return $this->getReturn($findByFacilityID, $returnType);
    }

    public function findFacilityByFacilityUserID($id, $returnType= NULL)
    {
        $facility = $this->modelClassName->limit(1)->with('facilityUser')->whereHas('facilityUser', function($query) use ($id) {
            $query->select('facilityuser_id')->where('facilityuser_id', '=', $id);
        })->first();

        return $this->getReturn($facility, $returnType);
    }

    public function findFacilityUserByFacilityID($id, $returnType= NULL)
    {
        $facility = $this->modelClassName->limit(1)->with('facilityUser')->whereHas('facilityUser', function($query) use ($id) {
            $query->where('facility_id', '=', $id);
        })->first();

        return $this->getReturn($facility, $returnType);
    }

    public function findPatientByFacilityPatientUserID($id, $returnType= NULL)
    {
        $patient = DB::table('facility_patient_user')
            ->join('patients', 'facility_patient_user.patient_id', '=', 'patients.patient_id')
            ->select('patients.*')
            ->where('facility_patient_user.facilitypatientuser_id', $id)
            ->first();

        return json_encode($patient);
    }

    public function findAllUsersByFacilityID($id, $limit = NULL, $returnType= NULL)
    {
        $users = $this->modelClassName->with('users')->where('facility_id',$id)->get();
        
        return $this->getReturn($users, $returnType);
    }

    public function findAllPatientsByFacilityID($id, $limit = NULL, $returnType= NULL)
    {
        $patients = DB::table('facility_patient_user')
            ->join('facility_user', 'facility_patient_user.facilityuser_id', '=', 'facility_user.facilityuser_id')
            ->join('patients', 'facility_patient_user.patient_id', '=', 'patients.patient_id')
            ->select('patients.*')
            ->where('facility_user.facility_id', $id)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        return json_encode($patients);
    }

    public function model()
    {
        return 'ShineOS\Core\Facilities\Entities\Facilities';
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

    private function getReturn($arr, $type)
    {
        if ($type!= NULL && $type == 'json'):
            return $arr->toJson();
        elseif ($type!= NULL && $type == 'array'):
            return $arr->toArray();
        endif;

        return $arr;
    }
}
