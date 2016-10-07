<?php

namespace ShineOS\Core\Reports\Widgets;

use Arrilot\Widgets\AbstractWidget;
use ShineOS\Core\Patients\Entities\Patients;
use Shine\Libraries\FacilityHelper;

use DB;
use Carbon\Carbon;
use View;
use Session;

class ageWidget extends AbstractWidget
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
                    <h3 class="box-title"><i class="fa fa-cog fa-spin fa-fw"></i> Loading Age Stats...</h3>
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

        //count patients by age range
        $count_by_age = DB::select('SELECT
             CASE
                WHEN age < 10 THEN "A"
                WHEN age BETWEEN 10 and 24 THEN "B"
                WHEN age BETWEEN 25 and 39 THEN "C"
                WHEN age BETWEEN 40 and 59 THEN "D"
                WHEN age BETWEEN 60 and 79 THEN "E"
                WHEN age >= 80 THEN "F"
                WHEN age IS NULL THEN "G"
            END as age_range,
            COUNT(*) AS count
              FROM (SELECT TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age FROM patients
              JOIN facility_patient_user ON facility_patient_user.patient_id = patients.patient_id
              JOIN facility_user ON facility_patient_user.facilityuser_id = facility_user.facilityuser_id
              WHERE facility_patient_user.facilityuser_id = "'.$facilityInfo->facilityUser[0]->facilityuser_id.'" AND patients.deleted_at IS NULL) as derived
              GROUP BY age_range');

        $patient_count = Patients::whereHas('facilityUser', function($query) use ($facility) {
                    $query->where('facility_id', '=', $facility->facility_id); })->count();

        View::addNamespace('reports-age', 'src/ShineOS/Core/Reports/Widgets');
        return view("reports-age::age", [
            'config' => $this->config,
            'count_by_age' => $count_by_age,
            'patient_count' => $patient_count
        ]);
    }
}
