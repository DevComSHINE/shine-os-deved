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

    public function placeholder()
    {
        $loading = '<div class="box box-primary"><!--Consultations-->
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-cog fa-spin fa-fw"></i> Loading Queue widget...</h3>
                </div>
            </div>';


        return $loading;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(UserRepository $UserRepository, HealthcareRepository $healthcareRepository)
    {
        /*$visits = getAllHealthcareByDate('today');*/
        $appointments = getAppointments('today');


        View::addNamespace('visit_list', 'widgets/dashboard/VisitList/');
        return view("visit_list::index", [
            'config' => $this->config,
            'visit_list' => $appointments
        ]);
    }
}
