<?php

use ShineOS\Core\Patients\Entities\Patients;
use Plugins\ShineLab_Employment\EmploymentModel;
use Shine\Repositories\Eloquent\UserRepository as UserRepository;
use Shine\Repositories\Contracts\UserRepositoryInterface;
use Shine\Http\Controllers\Controller;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\Utils as Utils;
use Shine\User;
use Shine\Plugin;

class EmploymentController extends Controller
{

    protected $moduleName = 'Patients';
    protected $modulePath = 'patients';

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        //no index
    }

    public function save()
    {
        $id = Input::get('patient_id');
        $employment = new EmploymentModel();
        $employment->patient_employmentinfo_id = IdGenerator::generateId();
        $employment->patient_id = Input::get('patient_id');
        $employment->occupation = Input::get('occupation');
        $employment->company_name = Input::get('company_name');
        $employment->company_phone = Input::get('company_phone');
        $employment->company_unitno = Input::get('company_unitno');
        $employment->company_address = Input::get('company_address');
        $employment->company_region = Input::get('region');
        $employment->company_province = Input::get('province');
        $employment->company_citymun = Input::get('city');
        $employment->company_barangay = Input::get('brgy');
        $employment->company_zip = Input::get('company_zip');
        $employment->company_country = Input::get('company_country');

        $employment->save();

        Session::flash('alert-class', 'alert-success');
        $message = "Employment data has been added to the patient record.";

        header('Location: '.site_url().'patients/view/'.$id);
        exit;
    }

    public static function update()
    {
        $id = Input::get('patient_id');

        $checks = EmploymentModel::where('patient_id', $id)->first();
        $employment = array(
            'occupation' => Input::get('occupation'),
            'company_name' => Input::get('company_name'),
            'company_phone' => Input::get('company_phone'),
            'company_unitno' => Input::get('company_unitno'),
            'company_address' => Input::get('company_address'),
            'company_region' => Input::get('region'),
            'company_province' => Input::get('province'),
            'company_citymun' => Input::get('city'),
            'company_barangay' => Input::get('brgy'),
            'company_zip' => Input::get('company_zip'),
            'company_country' => Input::get('company_country')
        );

        $affectedRows = EmploymentModel::where('patient_id', $id)
            ->update($employment);

        Session::flash('alert-class', 'alert-success');
        $message = "Employment data has been updated.";

        if($affectedRows > 0) {
            header('Location: '.site_url().'patients/view/'.$id);
            exit;
        }
    }

    public function view($id)
    {
        $patient = Patients::where('patient_id','=', $id)->first();
        $plugdata = EmploymentModel::where('patient_id',$id)->first();

        View::addNamespace('pluginform', plugins_path().'ShineLab_Employment');
        echo View::make('pluginform::master', array('patient' => $patient, 'plugdata'=>$plugdata))->render();

    }
}
