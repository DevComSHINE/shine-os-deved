<?php namespace ShineOS\Core\Roles\Http\Controllers;

use App\Libraries\IdGenerator;
use App\Libraries\Utils;
use Modules\Roles\Entities\UserFeatureRoles;
use Modules\Roles\Entities\Roles;
use Modules\Roles\Entities\Features;
use Pingpong\Modules\Routing\Controller;
use View,
    Response,
    Validator,
    Input,
    Session,
    Redirect,
    DB;

class FeaturesController extends Controller {

    //NOTE: To be refurbished. Separate listing and inner functions.

    protected $moduleName = 'roles';
    protected $modulePath = 'roles';
    protected $viewPath = '::pages.';


    public function __construct()
    {
        $features = Features::where('status','=',0)->orderBy('feature_name', 'asc')->orderBy('status','asc')->get();
        $this->middleware('auth');
        $modules =  Utils::getModules();

        # variables to share to all view
        View::share('modules', $modules);
        View::share('features', $features);
    }

    public function index()
    {

    }

    /**
     * Show form for adding features
     *
     * @return redirect to add page
     * NOTE: Create a library for adding and viewing records
     */
    public function add()
    {
        return view($this->modulePath.'::pages.features.add');
    }

    /**
     * Save form values
     *
     * @return redirect to add page
     * NOTE: Create a library for adding and viewing records
     */
    public function store()
    {
        $feature = new Features();
        $check = $feature->checkIfCore(Input::get('inputFeatureName'));
        $feature->feature_id = IdGenerator::generateId();

        if ($check == true):
            $feature->feature_name = Input::get('inputFeatureName');
            $feature->save();

            Session::flash('alert-class', 'alert-success');
            $message = "Successfully added a new feature";
        else:
            Session::flash('alert-class', 'alert-danger');
            $message = "Sorry but you cannot add a feature. Try again.";
        endif;

        return Redirect::to($this->modulePath)->with('message', $message);
    }

    public function delete()
    {

    }


}
