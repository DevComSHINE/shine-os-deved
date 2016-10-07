<?php

namespace ShineOS\Core\Reports\Widgets;

use Arrilot\Widgets\AbstractWidget;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use Shine\Libraries\FacilityHelper;

use DB;
use Carbon\Carbon;
use View;
use Session, DateTime;

class diagnosisWidget extends AbstractWidget
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
                    <h3 class="box-title"><i class="fa fa-cog fa-spin fa-fw"></i> Loading Top Diagnosis...</h3>
                </div>
            </div>';


        return $loading;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run($from=NULL, $to=NULL)
    {
        $maxdate = date('Y-m-d H:i:s');
        $xdate = strtotime($maxdate .' -6 months');
        $mindate = date('Y-m-d H:i:s', $xdate);

        if ($from == NULL):
            $from = new DateTime('tomorrow -10 year');
            $from = $from->format('Y-m-d H:i:s');
            $to = new DateTime();
            $to = $to->format('Y-m-d H:i:s');
        else:
            $from = $from;
            $to = $to;
        endif;

        $facilityInfo = Session::get('user_details');
        $facility = FacilityHelper::facilityInfo();

        $diagnosis = DB::table('diagnosis_view')
                ->select('diagnosislist_id', DB::raw('count(*) as bilang'))
                ->where('facility_id', $facility->facility_id)
                ->where('hccreated', '<=', $maxdate)
                ->where('hccreated', '>', $mindate)
                ->groupBy('diagnosislist_id')
                ->orderBy('bilang', 'desc')
                ->orderBy('hccreated', 'desc')
                ->take(6)
                ->get();

        $total = DB::table('healthcare_view')
            ->where('facility_id', $facility->facility_id)
            ->where('deleted_at', NULL)
            ->count();

        View::addNamespace('reports-diagnosis', 'src/ShineOS/Core/Reports/Widgets');
        return view("reports-diagnosis::diagnosis", [
            'config' => $this->config,
            'diagnosis' => $diagnosis,
            'total' => $total
        ]);
    }
}
