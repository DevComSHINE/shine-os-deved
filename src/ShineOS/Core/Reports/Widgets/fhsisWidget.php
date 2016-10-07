<?php

namespace ShineOS\Core\Reports\Widgets;

use Arrilot\Widgets\AbstractWidget;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use Shine\Libraries\FacilityHelper;

use DB;
use Carbon\Carbon;
use View;
use Session;

class fhsisWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */

    protected $config = [
        'type'=>'count',
        'gender'=>'F',
        'age'=>NULL,
        'disease'=>NULL,
        'disease_code'=>NULL,
        'month'=>NULL,
        'year'=>NULL
    ];

    public function placeholder()
    {
        $loading = '<i class="fa fa-spinner fa-pulse"></i>';
        return $loading;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $facilityInfo = Session::get('user_details');

        $age = explode("-",$this->config['age']);

        if($this->config['year']==NULL) $this->config['year'] = date('Y');
        if($this->config['month']==NULL) $this->config['month'] = date('n');

        /*$disease_count = FacilityPatientUser::select('facilitypatientuser_id')->sex($this->config['gender'])->agerange($this->config['age'])->hasdiagnosis($this->config['disease'])->hasicd10($this->config['disease_code'])->encounter($this->config['month'], $this->config['year'])->orderBy('created_at')->count();*/
        //SELECT * FROM `fhsis` WHERE `gender` = 'F' AND (`diagnosislist_id` = 'Influenza' OR `icd10_code` = 'J11') AND `birth` BETWEEN 2014-9 AND 2014-5

        $disease_count = DB::table('fhsis_m2_view')
            ->where('gender', $this->config['gender'])
            ->whereRaw( "(`diagnosislist_id` LIKE '%".$this->config['disease']."%' OR `icd10_code` = '".$this->config['disease_code']."' )" )
            ->where('facility_id', '9733538111109090808035624')
            ->where('diagnosisMonth', $this->config['month'])
            ->where('diagnosisYear', $this->config['year'])
            ->whereBetween('age', array($age[0], $age[1]))
            ->sum('count');

        View::addNamespace('fhsis-cell', 'src/ShineOS/Core/Reports/Widgets');
        return view("fhsis-cell::fhsis_cell", [
            'disease_count' => $disease_count
        ]);
    }
}
