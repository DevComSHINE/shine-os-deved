<?php

use Plugins\Pediatrics\PediatricsModel as Pediatrics;
use Modules\Helathcareservices\Entities\Healthcareservices;
use Shine\Repositories\Eloquent\HealthcareRepository as HealthcareRepository;
use Shine\Repositories\Contracts\HealthcareRepositoryInterface;
use Shine\Http\Controllers\Controller;
use Shine\Libraries\IdGenerator;
use Shine\User;
use Shine\Plugin;

class PediatricsController extends Controller
{
    protected $moduleName = 'Healthcareservices';
    protected $modulePath = 'healthcareservices';

    public function __construct(HealthcareRepository $healthcareRepository) {
        $this->healthcareRepository = $healthcareRepository;
        $this->middleware('auth');
    }

    public function index()
    {
        //no index
    }

    public function save($data)
    {
        $pediatrics_id = $data['fpservice_id'];
        $hservice_id = $data['hservice_id'];
        $patient_id = $data['patient_id'];
        $pediatricscase_id = $data['pediatricscase_id'];

        $pediatrics_service = Pediatrics::where('pediatrics_id','=',$pediatrics_id)->first();

        if($pediatrics_service == NULL) {
            $pediatrics_service =  new Pediatrics;
            $pediatrics_service->patient_id = $patient_id;
            $pediatrics_service->healthcareservice_id = $hservice_id;
        }

        //if this is a new maternal case, let us add a CaseID
        if($pediatricscase_id == NULL) //if there is no caseID given, this is a new maternal case
        {
            $pediatrics_service->pediatricscase_id = IdGenerator::generateId();
        } else {
            //if this is a follow-up and caseID is given, assign caseID to this
            if($pediatrics_service->pediatricscase_id == NULL)
            {
                $pediatrics_service->pediatricscase_id = $data['pediatricscase_id'];
            }
        }

        $pediatrics_service->newborn_screening_referral_date = $data['newborn_screening_referral_date'] ? date('Y-m-d', strtotime($data['newborn_screening_referral_date'])) : NULL;
        $pediatrics_service->newborn_screening_actual_date = $data['newborn_screening_actual_date'] ? date('Y-m-d', strtotime($data['newborn_screening_actual_date'])) : NULL;
        $pediatrics_service->child_protection_date = $data['child_protection_date'] ? date('Y-m-d', strtotime($data['child_protection_date'])) : NULL;
        $pediatrics_service->tt_status = $data['tt_status'];
        $pediatrics_service->birth_weight = $data['birth_weight'];
        $pediatrics_service->vit_a_supp_first_date = $data['vit_a_supp_first_date'] ? date('Y-m-d', strtotime($data['vit_a_supp_first_date'])) : NULL;
        $pediatrics_service->vit_a_first_age = $data['vit_a_first_age'];
        $pediatrics_service->vit_a_supp_second_date = $data['vit_a_supp_second_date'] ? date('Y-m-d', strtotime($data['vit_a_supp_second_date'])) : NULL;
        $pediatrics_service->vit_a_second_age = $data['vit_a_second_age'];
        $pediatrics_service->iron_supp_start_date = $data['iron_supp_start_date'] ? date('Y-m-d', strtotime($data['iron_supp_start_date'])) : NULL;
        $pediatrics_service->iron_supp_end_date = $data['iron_supp_end_date'] ? date('Y-m-d', strtotime($data['iron_supp_end_date'])) : NULL;

        $pediatrics_service->bcg_recommended_date = $data['bcg_recommended_date'] ? date('Y-m-d', strtotime($data['bcg_recommended_date'])) : NULL;
        $pediatrics_service->bcg_actual_date = $data['bcg_actual_date'] ? date('Y-m-d', strtotime($data['bcg_actual_date'])) : NULL;

        $pediatrics_service->penta1_recommended_date = $data['penta1_recommended_date'] ? date('Y-m-d', strtotime($data['penta1_recommended_date'])) : NULL;
        $pediatrics_service->penta1_actual_date = $data['penta1_actual_date'] ? date('Y-m-d', strtotime($data['penta1_actual_date'])) : NULL;
        $pediatrics_service->penta2_recommended_date = $data['penta2_recommended_date'] ? date('Y-m-d', strtotime($data['penta2_recommended_date'])) : NULL;
        $pediatrics_service->penta2_actual_date = $data['penta2_actual_date'] ? date('Y-m-d', strtotime($data['penta2_actual_date'])) : NULL;
        $pediatrics_service->penta3_recommended_date = $data['penta3_recommended_date'] ? date('Y-m-d', strtotime($data['penta3_recommended_date'])) : NULL;
        $pediatrics_service->penta3_actual_date = $data['penta3_actual_date'] ? date('Y-m-d', strtotime($data['penta3_actual_date'])) : NULL;

/*        $pediatrics_service->dpt1_recommended_date = $data['dpt1_recommended_date'] ? date('Y-m-d', strtotime($data['dpt1_recommended_date'])) : NULL;
        $pediatrics_service->dpt1_actual_date = $data['dpt1_actual_date'] ? date('Y-m-d', strtotime($data['dpt1_actual_date'])) : NULL;
        $pediatrics_service->dpt2_recommended_date = $data['dpt2_recommended_date'] ? date('Y-m-d', strtotime($data['dpt2_recommended_date'])) : NULL;
        $pediatrics_service->dpt2_actual_date = $data['dpt2_actual_date'] ? date('Y-m-d', strtotime($data['dpt2_actual_date'])) : NULL;
        $pediatrics_service->dpt3_recommended_date = $data['dpt3_recommended_date'] ? date('Y-m-d', strtotime($data['dpt3_recommended_date'])) : NULL;
        $pediatrics_service->dpt3_actual_date = $data['dpt3_actual_date'] ? date('Y-m-d', strtotime($data['dpt3_actual_date'])) : NULL;
*/
        $pediatrics_service->hepa_b1_recommended_date = $data['hepa_b1_recommended_date'] ? date('Y-m-d', strtotime($data['hepa_b1_recommended_date'])) : NULL;
        $pediatrics_service->hepa_b1_actual_date = $data['hepa_b1_actual_date'] ? date('Y-m-d', strtotime($data['hepa_b1_actual_date'])) : NULL;
        $pediatrics_service->hepa_b2_recommended_date = $data['hepa_b2_recommended_date'] ? date('Y-m-d', strtotime($data['hepa_b2_recommended_date'])) : NULL;
        $pediatrics_service->hepa_b2_actual_date = $data['hepa_b2_actual_date'] ? date('Y-m-d', strtotime($data['hepa_b2_actual_date'])) : NULL;
        $pediatrics_service->hepa_b3_recommended_date = $data['hepa_b3_recommended_date'] ? date('Y-m-d', strtotime($data['hepa_b3_recommended_date'])) : NULL;
        $pediatrics_service->hepa_b3_actual_date = $data['hepa_b3_actual_date'] ? date('Y-m-d', strtotime($data['hepa_b3_actual_date'])) : NULL;

        $pediatrics_service->measles_recommended_date = $data['measles_recommended_date'] ? date('Y-m-d', strtotime($data['measles_recommended_date'])) : NULL;
        $pediatrics_service->measles_actual_date = $data['measles_actual_date'] ? date('Y-m-d', strtotime($data['measles_actual_date'])) : NULL;

        $pediatrics_service->opv1_recommended_date = $data['opv1_recommended_date'] ? date('Y-m-d', strtotime($data['opv1_recommended_date'])) : NULL;
        $pediatrics_service->opv1_actual_date = $data['opv1_actual_date'] ? date('Y-m-d', strtotime($data['opv1_actual_date'])) : NULL;
        $pediatrics_service->opv2_recommended_date = $data['opv2_recommended_date'] ? date('Y-m-d', strtotime($data['opv2_recommended_date'])) : NULL;
        $pediatrics_service->opv2_actual_date = $data['opv2_actual_date'] ? date('Y-m-d', strtotime($data['opv2_actual_date'])) : NULL;
        $pediatrics_service->opv3_recommended_date = $data['opv3_recommended_date'] ? date('Y-m-d', strtotime($data['opv3_recommended_date'])) : NULL;
        $pediatrics_service->opv3_actual_date = $data['opv3_actual_date'] ? date('Y-m-d', strtotime($data['opv3_actual_date'])) : NULL;

        $pediatrics_service->rota1_recommended_date = $data['rota1_recommended_date'] ? date('Y-m-d', strtotime($data['rota1_recommended_date'])) : NULL;
        $pediatrics_service->rota1_actual_date = $data['rota1_actual_date'] ? date('Y-m-d', strtotime($data['rota1_actual_date'])) : NULL;
        $pediatrics_service->rota2_recommended_date = $data['rota2_recommended_date'] ? date('Y-m-d', strtotime($data['rota2_recommended_date'])) : NULL;
        $pediatrics_service->rota2_actual_date = $data['rota2_actual_date'] ? date('Y-m-d', strtotime($data['rota2_actual_date'])) : NULL;

        $pediatrics_service->pcv1_recommended_date = $data['pcv1_recommended_date'] ? date('Y-m-d',
        strtotime($data['pcv1_recommended_date'])) : NULL;
        $pediatrics_service->pcv1_actual_date = $data['pcv1_actual_date'] ? date('Y-m-d', strtotime($data['pcv1_actual_date'])) : NULL;
        $pediatrics_service->pcv2_recommended_date = $data['pcv2_recommended_date'] ? date('Y-m-d', strtotime($data['pcv2_recommended_date'])) : NULL;
        $pediatrics_service->pcv2_actual_date = $data['pcv2_actual_date'] ? date('Y-m-d', strtotime($data['pcv2_actual_date'])) : NULL;
        $pediatrics_service->pcv3_recommended_date = $data['pcv3_recommended_date'] ? date('Y-m-d', strtotime($data['pcv3_recommended_date'])) : NULL;
        $pediatrics_service->pcv3_actual_date = $data['pcv3_actual_date'] ? date('Y-m-d', strtotime($data['pcv3_actual_date'])) : NULL;

        $pediatrics_service->mcv1_recommended_date = $data['mcv1_recommended_date'] ? date('Y-m-d', strtotime($data['mcv1_recommended_date'])) : NULL;
        $pediatrics_service->mcv1_actual_date = $data['mcv1_actual_date'] ? date('Y-m-d', strtotime($data['mcv1_actual_date'])) : NULL;
        $pediatrics_service->mcv2_recommended_date = $data['mcv2_recommended_date'] ? date('Y-m-d', strtotime($data['mcv2_recommended_date'])) : NULL;
        $pediatrics_service->mcv2_actual_date = $data['mcv2_actual_date'] ? date('Y-m-d', strtotime($data['mcv2_actual_date'])) : NULL;

        $pediatrics_service->is_breastfed_first_month = isset($data['is_breastfed_first_month']) ? $data['is_breastfed_first_month'] : NULL;
        $pediatrics_service->is_breastfed_second_month = isset($data['is_breastfed_second_month']) ? $data['is_breastfed_second_month'] : NULL;
        $pediatrics_service->is_breastfed_third_month = isset($data['is_breastfed_third_month']) ? $data['is_breastfed_third_month'] : NULL;
        $pediatrics_service->is_breastfed_fourth_month = isset($data['is_breastfed_fourth_month']) ? $data['is_breastfed_fourth_month'] : NULL;
        $pediatrics_service->is_breastfed_fifth_month = isset($data['is_breastfed_fifth_month']) ? $data['is_breastfed_fifth_month'] : NULL;
        $pediatrics_service->is_breastfed_sixth_month = isset($data['is_breastfed_sixth_month']) ? $data['is_breastfed_sixth_month'] : NULL;
        $pediatrics_service->breastfeed_sixth_month = isset($data['breastfeed_sixth_month']) ? $data['breastfeed_sixth_month'] : NULL;

        $pediatrics_service->save();

        header('Location: '.site_url().'healthcareservices/edit/'.$patient_id.'/'.$hservice_id);

        exit;
    }
}
