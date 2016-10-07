<?php

namespace ShineOS\Core\Reports\Widgets;

use Arrilot\Widgets\AbstractWidget;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use Shine\Libraries\FacilityHelper;

use DB;
use Carbon\Carbon;
use View;
use Session, DateTime;

class recapWidget extends AbstractWidget
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
                    <h3 class="box-title"><i class="fa fa-cog fa-spin fa-fw"></i> Loading Facility Stats...</h3>
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

        $count_by_gender_sex = Patients::select(DB::raw('CASE WHEN gender = "F" THEN "F" WHEN gender = "M" THEN "M" WHEN gender <> "F" THEN "U" WHEN gender <> "M" THEN "U" WHEN gender IS NULL THEN "U" END as genderu, count(*) as total'))
            ->where('deleted_at', NULL)
            ->groupby('genderu')
            ->whereHas('facilityUser', function($query) use ($facilityInfo) {
                    $query->where('facility_id', '=', $facilityInfo->facilityUser[0]->facility_id);
            })
            ->get();

        $patient_count = Patients::whereHas('facilityUser', function($query) use ($facility) {
                    $query->where('facility_id', '=', $facility->facility_id); })->count();

        $count_by_services_rendered = DB::select('SELECT healthcareservicetype_id, count(*) as total FROM healthcare_services JOIN facility_patient_user ON facility_patient_user.facilitypatientuser_id = healthcare_services.facilitypatientuser_id JOIN facility_user ON facility_patient_user.facilityuser_id = facility_user.facilityuser_id WHERE healthcare_services.deleted_at IS NULL AND facility_patient_user.facilityuser_id = "'.$facilityInfo->facilityUser[0]->facilityuser_id.'" AND healthcare_services.created_at BETWEEN :from_date AND :to_date group by healthcare_services.facilitypatientuser_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date' => $to]);

        $count_by_disease = DB::select('SELECT diagnosis.diagnosislist_id, count(*) as total FROM healthcare_services JOIN diagnosis ON healthcare_services.healthcareservice_id = diagnosis.healthcareservice_id  JOIN facility_patient_user ON facility_patient_user.facilitypatientuser_id = healthcare_services.facilitypatientuser_id JOIN facility_user ON facility_patient_user.facilityuser_id = facility_user.facilityuser_id WHERE healthcare_services.deleted_at IS NULL AND facility_patient_user.facilityuser_id = "'.$facilityInfo->facilityUser[0]->facilityuser_id.'" AND healthcare_services.created_at BETWEEN :from_date AND :to_date group by diagnosis.diagnosislist_id ORDER BY count(*) DESC', ['from_date' => $from, 'to_date' => $to]);

        $services = Healthcareservices::select('healthcareservicetype_id', DB::raw('count(*) as counter'))->where('created_at', '<=', $maxdate)->where('created_at', '>', $mindate)->groupBy('healthcareservicetype_id')->orderBy('counter')->get();

        $cs_stats = $ranges = [];

        for($d = 1; $d <= 6; $d++) {
            $xr = strtotime($mindate .' +'.$d.' months');
            $ranges[$d] = date('Y-m-d', $xr);
        }
        $scount = count($services);
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

        View::addNamespace('reports-recap', 'src/ShineOS/Core/Reports/Widgets');
        return view("reports-recap::recap", [
            'config' => $this->config,
            'count_by_gender_sex' => $count_by_gender_sex,
            'count_by_services_rendered' => $count_by_services_rendered,
            'count_by_disease' => $count_by_disease,
            'services' => $services,
            'scount' => count($services),
            'patient_count' => $patient_count,
            'cs_stats' => $cs_stats,
            'ranges' => $ranges
        ]);
    }
}
