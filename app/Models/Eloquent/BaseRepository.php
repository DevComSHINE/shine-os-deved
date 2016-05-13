<?php
namespace Shine\Repositories\Eloquent;

use Shine\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * BaseRepository provides the standard functions to be expected of ANY
 * repository.
 */
abstract class BaseRepository implements BaseRepositoryInterface
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
     * Call makeModel() to instatiate new models
     * @param App $app Injected container
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
    * Get All records
    * @param  array  $columns
    * @return dynamic type
    */
    public function all($columns = array('*'), $returnType = NULL)
    {
        $all = $this->modelClassName->get($columns);

        return $this->getReturn($all, $returnType);
    }

    /**
     * Get All records with pagination
     * @param  integer $perPage number of records to be shown per page
     * @param  array   $columns get columns
     * @return dynamic type
     */
    public function paginate($perPage = 10, $columns = array('*'), $returnType = NULL)
    {
        $paginate = $this->model->paginate($perPage, $columns);

        return $this->getReturn($paginate);
    }

    /**
     * Create new record
     * @param  array  $attributes
     * @return bool if saved/not
     */
    public function create(array $attributes)
    {
        return $this->modelClassName->create($data);
    }

    /**
     * Update record
     * @param  array  $data   new form values
     * @param  [type] $id
     * @param  string $column
     * @return bool saved/not
     */
    public function update(array $data, $id, $column="id")
    {
        return $this->modelClassName->where($column, '=', $id)->update($data);
    }

    /**
     * Get specific record
     * @param  [type] $id
     * @param  array  $columns get columns
     * @return dynamic type
     */
    public function find($id, $columns = array('*'), $returnType = NULL)
    {
        $find = $this->modelClassName->find($id, $columns);

        return $this->getReturn($find, $returnType);
    }

    /**
     * Get specific record by
     * @param  string $field
     * @param  string $value
     * @param  array  $columns
     * @return json
     */
    public function findBy($field, $value, $columns = array('*'), $returnType = NULL)
    {
        $findBy = $this->model->where($field, '=', $value)->first($columns);

        return $this->getReturn($findBy, $returnType);
    }

    /**
     * Get record by first and last name. Should be used only for Patients and Users Module
     * @param  string $surname
     * @param  string $lastname
     * @param  array  $column/s
     * @return dynamic type
     */
    public function findByName($surname= NULL, $firstname= NULL, $column= array('*'), $returnType = NULL)
    {
        $findByName = $this->modelClassName
        ->select($column)
        ->where('first_name', 'like', '%'.$firstname.'%')
        ->orWhere('last_name', 'like', '%'.$surname.'%')
        ->first();

        return $this->getReturn($findyByName, $returnType);
    }

    /**
     * Get all content by table name
     * @param  string $tableName [description]
     * @param  array  $column    [description]
     * @return dynamic type
     */
    public function findAllByTable($tableName, $column = array('*'), $returnType = NULL)
    {
        $result = DB::table($tableName)->select('*')->where($column)->get();

        return $result;
    }

    /**
     * Soft Delete record
     * @param  string/array $ids
     * @return bool true/false
     */
    public function destroy($ids)
    {
        return $this->modelClassName->destroy($id);
    }

    abstract public function model();

    /**
     * Throws an exception and set model
     * @return $model
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model)
            throw new RepositoryException("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

        return $this->modelClassName = $model;
    }

    private function getReturn($arr, $type)
    {
        if ($returnType!= NULL):
            return $arr->toJson();
        endif;

        return $arr;
    }
}
