<?php namespace Modules\Rizal\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Rizal\Entities\Calendar; //model
use Shine\Libraries\IdGenerator;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\UserHelper;

use View, Response, Input, Datetime;

class RizalController extends Controller {

    private $facility_id;

    public function __construct() {
        $this->middleware('auth');
        $this->user = UserHelper::getUserInfo();
        $this->facility = FacilityHelper::facilityInfo();

    }

    public function index()
    {
        $data['user'] = $this->user;
        $data['facilityInfo'] = $this->facility;

        return view('rizal::index')->with($data);
    }

}


