<?php

namespace Widgets\dashboard\Analytics;

use Arrilot\Widgets\AbstractWidget;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use Shine\Repositories\Eloquent\FacilityRepository;

use DB;
use Carbon\Carbon;
use View;
use Session;

class analytics extends AbstractWidget
{
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
    public function run()
    {
        $facilityInfo = Session::get('facility_details');

        $maxdate = date('Y-m-d H:i:s');
        $xdate = strtotime($maxdate .' -6 months');
        $mindate=date('Y-m-d', $xdate);

        $services = NULL;
        $diagnosis = NULL;
        $ranges = NULL;
        $cs_stats = NULL;
        $total = NULL;

        //check if there are records to generate stats from
        $total = countAllHealthcareByFacilityID($facilityInfo->facility_id);

        if($total > 0) {
            $services = Healthcareservices::select('healthcareservicetype_id', DB::raw('count(*) as counter'))->where('created_at', '<=', $maxdate)->where('created_at', '>', $mindate)->where('deleted_at', NULL)->groupBy('healthcareservicetype_id')->orderBy('counter')->get();

            $diagnosis = Diagnosis::select('diagnosislist_id', DB::raw('count(*) as bilang'))
                ->join('healthcare_services', 'healthcare_services.healthcareservice_id','=','diagnosis.healthcareservice_id')
                ->join('facility_patient_user','healthcare_services.facilitypatientuser_id','=','facility_patient_user.facilitypatientuser_id')
                ->join('facility_user','facility_patient_user.facilityuser_id','=','facility_user.facilityuser_id')
                ->where('facility_user.facility_id', $facilityInfo->facility_id)
                ->where('healthcare_services.created_at', '<=', $maxdate)
                ->where('healthcare_services.created_at', '>', $mindate)
                ->groupBy('diagnosis.diagnosislist_id')
                ->orderBy('bilang', 'desc')
                ->take(4)
                ->get();

            $cs_stats = NULL;

            for($d = 1; $d <= 6; $d++) {
                $xr = strtotime($mindate .' +'.$d.' months');
                $ranges[$d] = date('Y-m-d', $xr);
            }

            foreach($services as $service) {
                foreach($ranges as $range) {
                    $max = date('Y-m-30 11:00:00', strtotime($range));
                    $min = date('Y-m-01 00:00:00', strtotime($range));

                    $bils = Healthcareservices::select(DB::raw('count(*) as bilang'))->where('created_at', '<=', $max)->where('created_at', '>', $min)->where('healthcareservicetype_id', $service->healthcareservicetype_id)->get();

                    foreach($bils as $k=>$bil) {
                        $cs_stats[$service->healthcareservicetype_id][$range] = $bil->bilang;
                    }
                }
            }
        }
//dd($total, $diagnosis);
        View::addNamespace('analytics-widgets', 'widgets/dashboard/Analytics/');
        return view("analytics-widgets::index", [
            'config' => $this->config,
            'services' => $services,
            'mon' => $diagnosis,
            'ranges' => $ranges,
            'cs_stats' => $cs_stats,
            'total' => $total
        ]);
    }
}
