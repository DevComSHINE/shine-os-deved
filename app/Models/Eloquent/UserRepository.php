<?php
namespace Shine\Repositories\Eloquent;

use Shine\Repositories\Eloquent\BaseRepository as AbstractRepository;
use Shine\Repositories\Contracts\UserRepositoryInterface;
use Shine\Repositories\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use ShineOS\Core\Users\Entities\Users;

/**
 * This class only implements methods specific to the User Module
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
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
    /**
     * [__construct description]
     * @param App $app [description]
     */
    public function findByUserID($id, $returnType= NULL)
    {
        $user = $this->modelClassName->where('user_id','=',$id)->first();

        return $this->getReturn($user, $returnType);
    }

    /**
     * [__construct description]
     * @param App $app [description]
     */
    public function findUserAndFacilityUserByUserID($id, $returnType= NULL)
    {
        $user = $this->modelClassName->with('facilityUser')->whereHas('facilityUser', function($query) use ($id) {
                $query->where('user_id', '=', $id);
        })->first();

        return $this->getReturn($user, $returnType);
    }

    /**
     * [__construct description]
     * @param App $app [description]
     */
    public function findByColumn($column, $returnType= NULL)
    {
        $user = $this->modelClassName->get($column);

        return $this->getReturn($user, $returnType);
    }

    /**
     * [__construct description]
     * @param App $app [description]
     */
    public function findUserContactByID($id, $returnType= NULL)
    {
        $userContact = $this->modelClassName->limit(1)->with('contact')->where('user_id','=',$id)->first();

        return $this->getReturn($userContact, $returnType);
    }

    /**
     * [__construct description]
     * @param App $app [description]
     */
    public function findDocUserDetailsByID($id, $returnType= NULL)
    {
        $docUserDetails = $this->modelClassName->limit(1)->with('mdUsers')->where('user_id','=',$id)->first();

        return $this->getReturn($docUserDetails, $returnType);
    }

    /**
     * [__construct description]
     * @param App $app [description]
     */
    public function findUserByFacilityUserID($id, $returnType= NULL)
    {
        $userFacilities = $this->modelClassName->limit(1)->with('facilities')->whereHas('facilities', function($query) use ($id) {
            $query->select('facilityuser_id')->where('facilityuser_id', '=', $id);
        })->first();

        return $this->getReturn($userFacilities, $returnType);
    }

    /**
     * [__construct description]
     * @param App $app [description]
     */
    public function model()
    {
        return 'ShineOS\Core\Users\Entities\Users';
    }

    /**
     * @return Model
     * @throws RepositoryException
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
        if ($type!= NULL && $type == 'json'):
            return $arr->toJson();
        elseif ($type!= NULL && $type == 'array'):
            return $arr->toArray();
        endif;

        return $arr;
    }
}
