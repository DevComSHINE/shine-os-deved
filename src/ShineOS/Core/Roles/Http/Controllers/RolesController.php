<?php
namespace ShineOS\Core\Roles\Http\Controllers;

use Shine\Repositories\Eloquent\FacilityRepository as UserRepository;
use Shine\Repositories\Contracts\FacilityRepositoryInterface;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\Utils;
use ShineOS\Core\Roles\Entities\UserFeatureRoles;
use ShineOS\Core\Users\Entities\Users;
use ShineOS\Core\Roles\Entities\Roles;
use ShineOS\Core\Roles\Entities\Features;
use View,
    Response,
    Validator,
    Input,
    Session,
    Redirect,
    Request,
    DB;

class RolesController extends Controller {

    protected $moduleName = 'Roles';
    protected $modulePath = 'roles';
    protected $viewPath = 'roles::pages.';
    protected $features = "";
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $features = Features::where('status','=',0)->orderBy('feature_name', 'asc')->orderBy('status','asc')->get();
        $this->userRepository = $userRepository;
        $this->middleware('auth');

        # variables to share to all view
        //View::share('modules', $modules);
        //View::share('features', $features);
    }

    public function index()
    {
        $roleItems = Roles::with('features')->paginate(10);
        $featureItems = Features::paginate(10);
        //dd($coreFeatures);
        return view($this->viewPath.'.index', compact('roleItems','coreFeatures','featureItems'));
    }

}
