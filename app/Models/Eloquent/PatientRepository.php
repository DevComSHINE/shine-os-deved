<?php 
namespace Shine\Repositories\Eloquent;

use Shine\Repositories\Eloquent\BaseRepository as AbstractRepository;
use Shine\Repositories\Contracts\PatientRepositoryInterface;
use Illuminate\Container\Container as App;
use Shine\Repositories\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * This class only implements methods specific to the User Module
 */
class PatientRepository extends AbstractRepository implements PatientRepositoryInterface
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
    }

    /**
     * Get patient info
     * @param  [string] $id         patient_id
     * @param  [string] $attribute  modelObject name
     * @return mixed
     */
    public function findByPatientID($id, $attribute= NULL)
    {
        $this->makeModel($attribute);

        return $this->modelClassName->where('patient_id', '=', $id)->get();
    }

    public function findPatientDetailsByPatientID($id, $attribute= NULL) {
        $this->makeModel($attribute);
        $result = $this->modelClassName
                ->with('patientContact', 'patientAlert','patientDeathInfo')
                ->where('patient_id', '=', $id)
                ->first();
        return $result;
    }

    public function findPatientsByFacilityId($id, $attribute= NULL) {
        $this->makeModel($attribute);
        $result = $this->modelClassName
                ->with('patientContact','facilityUser')
                ->whereHas('facilityUser', function($query) use ($id) {
                    $query->where('facility_id', '=', $id);
                })->get();
        return $result;
    }

    /**
     * Returns model object (dynamic)
     * @param  [string] $model Model Name
     * @return path
     */
	public function model($model = NULL)
    {
        if ($model != NULL):
            $modelObj ='ShineOS\Core\Patients\Entities\\'.$model;
        else:
            $modelObj ='ShineOS\Core\Patients\Entities\Patients';
        endif;

        return $modelObj;
    }

    /**
     * @return Model
     * @throws RepositoryException
     */
    public function makeModel($model = NULL) {
        $model = $this->app->make($this->model($model));
 
        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
 
        return $this->modelClassName = $model;
    }
}