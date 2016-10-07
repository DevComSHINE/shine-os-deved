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

    public function placeholder()
    {
        $loading = '<div class="box box-primary"><!--Consultations-->
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-cog fa-spin fa-fw"></i> Loading Analytics widget...</h3>
                </div>
            </div>';


        return $loading;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $facilityInfo = Session::get('facility_details');

        $maxdate = date('Y-m-d H:i:s');
        $xdate = strtotime($maxdate .' -6 months');
        $mindate=date('Y-m-d H:i:s', $xdate);

        $services = NULL;
        $diagnosis = NULL;
        $ranges = NULL;
        $cs_stats = NULL;
        $total = $scount = 0;

        //check if there are records to generate stats from
        $total = DB::table('healthcare_view')
            ->where('facility_id', $facilityInfo->facility_id)
            ->where('hccreated', '<=', $maxdate)
            ->where('hccreated', '>', $mindate)
            ->count();

        if($total > 0) {

            $services = DB::table('healthcare_view')
                ->select('healthcareservicetype_id')
                ->where('facility_id', $facilityInfo->facility_id)
                ->groupBy('healthcareservicetype_id')
                ->get();

            $diagnosis = DB::table('diagnosis_view')
                ->select('diagnosislist_id', DB::raw('count(*) as bilang'))
                ->where('facility_id', $facilityInfo->facility_id)
                ->where('hccreated', '<=', $maxdate)
                ->where('hccreated', '>', $mindate)
                ->groupBy('diagnosislist_id')
                ->orderBy('bilang', 'desc')
                ->take(4)
                ->get();

            $cs_stats = NULL;

            if($services) {
                $scount = count($services);
            }

            for($d = 1; $d <= 6; $d++) {
                $xr = strtotime($mindate .' +'.$d.' months');
                $ranges[$d] = date('Y-m-d', $xr);
            }

            foreach($services as $service) {
                if($service->healthcareservicetype_id != NULL) {
                    foreach($ranges as $range) {
                        $max = date('Y-m-30 11:00:00', strtotime($range));
                        $min = date('Y-m-01 00:00:00', strtotime($range));

                        $bils = DB::table('healthcare_view')
                            ->select('healthcareservicetype_id', 'hccreated' , DB::raw('count(*) as bilang'))
                            ->where('facility_id', $facilityInfo->facility_id)
                            ->where('healthcareservicetype_id', $service->healthcareservicetype_id)
                            ->where('hccreated', '<=', $max)
                            ->where('hccreated', '>', $min)
                            ->orderBy('bilang','desc')
                            ->get();

                        foreach($bils as $k=>$bil) {
                            $cs_stats[$service->healthcareservicetype_id][$range] = $bil->bilang;
                        }
                    }
                }
            }

        }

        View::addNamespace('analytics-widgets', 'widgets/dashboard/Analytics/');
        return view("analytics-widgets::index", [
            'config' => $this->config,
            'services' => $services,
            'mon' => $diagnosis,
            'ranges' => $ranges,
            'cs_stats' => $cs_stats,
            'total' => $total,
            'scount' => $scount
        ]);
    }
}
