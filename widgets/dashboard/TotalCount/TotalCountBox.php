<?php
namespace Widgets\dashboard\TotalCount;

use Arrilot\Widgets\AbstractWidget;
use Shine\Repositories\Eloquent\UserRepository as BaseRepository;
use Shine\Repositories\Contracts\UserRepositoryInterface;
use Shine\Libraries\FacilityHelper;
use Shine\Libraries\UserHelper;
use View, Config;

/**
 * Widget for the total number of records per module
 */
class TotalCountBox extends AbstractWidget
{
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
                    <h3 class="box-title"><i class="fa fa-cog fa-spin fa-fw"></i> Loading Stats widget...</h3>
                </div>
            </div>';


        return $loading;
    }

    /**
     * The repository object.
     *
     * @var object
     */
    private $baseRepository;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(BaseRepository $baseRepository)
    {

        $this->baseRepository = $baseRepository;

        $id = UserHelper::getUserInfo();
        $facilityInfo = FacilityHelper::facilityInfo(); // get user id
        $userFacilities = FacilityHelper::getFacilities($id);

        //Number of patients
        //$patient_count = count($this->baseRepository->findAllByTable('facility_patient_user', array('deleted_at'=>NULL,'facilityuser_id' => $userFacilities[0]->facilityuser_id)));
        $patient_count = countAllPatientsByFacility();

        if(Config::get('mode') == 'cloud'):
            //Number of inbound referrals
            $inbound_count = countInboundReferrals($userFacilities[0]->facility_id);
                //count($this->baseRepository->findAllByTable('referrals', array('facility_id' => $userFacilities[0]->facility_id)));

            //Number of outbound referrals
            $outbound_count = countOutboundReferrals($userFacilities[0]->facility_id);
                //count($this->baseRepository->findAllByTable('referrals', array('facility_id' => $userFacilities[0]->facility_id)));

            //Number of referrals
            $referral_count = count($this->baseRepository->findAllByTable('referrals', array('facility_id' => $userFacilities[0]->facility_id)));

            //Number of Reminders
            $reminders_count = count($this->baseRepository->findAllByTable('reminders', array('facilityuser_id' => $userFacilities[0]->facilityuser_id)));

            $dashboard_count = array('patient' => $patient_count,'inbound'=>$inbound_count,'outbound'=>$outbound_count,'referral'=>$referral_count,'reminders'=>$reminders_count);
        else:
            $dashboard_count = array('patient' => $patient_count);
        endif;
        View::addNamespace('total_count_box', 'widgets/dashboard/TotalCount/');
        return view("total_count_box::index", [
            'config' => $this->config,
            'dashboard_count' => $dashboard_count,
        ]);
    }
}
