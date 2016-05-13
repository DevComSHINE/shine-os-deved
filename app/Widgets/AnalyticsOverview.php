<?php
namespace Shine\Widgets;

use Arrilot\Widgets\AbstractWidget;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use Shine\Repositories\Eloquent\FacilityRepository;

use DB;
use Carbon\Carbon;

class AnalyticsOverview extends AbstractWidget
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
        $maxdate = date('Y-m-d H:i:s');
        $xdate = strtotime($maxdate .' -6 months');
        $mindate=date('Y-m-d', $xdate);

        $services = NULL;
        $diagnosis = NULL;
        $ranges = NULL;
        $cs_stats = NULL;
        $total = NULL;

        //check if there are records to generate stats from
        $total = Healthcareservices::where('created_at', '<=', $maxdate)->where('created_at', '>', $mindate)->where('deleted_at', NULL)->count();

        if($total > 0) {
            $services = Healthcareservices::select('healthcareservicetype_id', DB::raw('count(*) as counter'))->where('created_at', '<=', $maxdate)->where('created_at', '>', $mindate)->where('deleted_at', NULL)->groupBy('healthcareservicetype_id')->orderBy('counter')->get();
            $diagnosis = Diagnosis::select('diagnosis_type', DB::raw('count(*) as bilang'))->where('created_at', '<=', $maxdate)->where('created_at', '>', $mindate)->groupBy('diagnosis_type')->orderBy('bilang')->take(4)->get();

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

        return view("widgets.analytics_overview", [
            'config' => $this->config,
            'services' => $services,
            'mon' => $diagnosis,
            'ranges' => $ranges,
            'cs_stats' => $cs_stats,
            'total' => $total
        ]);
    }
}