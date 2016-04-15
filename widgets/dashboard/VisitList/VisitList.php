<?php
namespace Widgets\dashboard\VisitList;

use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use Shine\Repositories\Eloquent\UserRepository as UserRepository;
use Shine\Repositories\Eloquent\HealthcareRepository as HealthcareRepository;
use Shine\Repositories\Contracts\FacilityRepositoryInterface;
use Shine\Libraries\HealthcareservicesHelper;
use Shine\Libraries\FacilityHelper;
use Arrilot\Widgets\AbstractWidget;
use View;

//DO NOT FORGET TO UNCOMMENT LOOP WHEN DONE WITH REPOSITORIES
class VisitList extends AbstractWidget
{
    private $UserRepository;
    private $healthcareRepository;

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(UserRepository $UserRepository, HealthcareRepository $healthcareRepository)
    {
        $facilityInfo = FacilityHelper::facilityInfo();
        $this->HealthcareRepository = $healthcareRepository;
        $this->UserRepository = $UserRepository;
        $visits = json_decode($this->HealthcareRepository->findHealthcareByFacilityID($facilityInfo->facility_id, 5));

        foreach ($visits as $k => $v) {
            $v->seen_by = json_decode($this->UserRepository->findUserByFacilityUserID($v->seen_by));
        }

        //dd($visits);
        View::addNamespace('visit_list', 'widgets/dashboard/VisitList/');
        return view("visit_list::index", [
            'config' => $this->config,
            'visit_list' => $visits
        ]);
    }
}
