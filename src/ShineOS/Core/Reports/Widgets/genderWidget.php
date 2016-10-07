<?php

namespace ShineOS\Core\Reports\Widgets;

use Arrilot\Widgets\AbstractWidget;
use ShineOS\Core\Patients\Entities\Patients;
use Shine\Libraries\FacilityHelper;

use DB;
use Carbon\Carbon;
use View;
use Session;

class genderWidget extends AbstractWidget
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
                    <h3 class="box-title"><i class="fa fa-cog fa-spin fa-fw"></i> Loading Gender Stats...</h3>
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

        View::addNamespace('reports-gender', 'src/ShineOS/Core/Reports/Widgets');
        return view("reports-gender::gender", [
            'config' => $this->config,
            'total_patients_by_sex' => $count_by_gender_sex,
            'patient_count' => $patient_count
        ]);
    }
}
