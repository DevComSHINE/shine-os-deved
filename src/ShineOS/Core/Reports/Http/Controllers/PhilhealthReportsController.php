<?php

namespace ShineOS\Core\Reports\Http\Controllers;

use Illuminate\Routing\Controller;
use Shine\Libraries\FacilityHelper;
use ShineOS\Core\Patients\Entities\Patients;
use ShineOS\Core\LOV\Entities\LovDiseases;
use ShineOS\Core\LOV\Entities\LovExamination;
use ShineOS\Core\Healthcareservices\Entities\Healthcareservices;
use ShineOS\Core\Facilities\Entities\FacilityPatientUser;
use ShineOS\Core\Facilities\Entities\FacilityUser;
use ShineOS\Core\Facilities\Entities\Facilities;
use View, Session, Input;

class PhilhealthReportsController extends Controller {

    public function __construct() {
        $this->data = NULL;
        $facility = Session::get('facility_details');
        if($facility) {
            $this->data['facility'] = Facilities::with('facilityContact')->where('facility_id',$facility->facility_id)->first();
            $this->data['facility_name'] = $facility->facility_name;
            $fac_user = FacilityUser::where('facility_id', $facility->facility_id)->lists('facilityuser_id')->toArray();
            $this->data['facility_patients_list'] = FacilityPatientUser::whereIn('facilityuser_id',$fac_user)->lists('patient_id')->toArray();
        }

        View::addNamespace('reports', 'src/ShineOS/Core/Reports/Resources/Views');
    }

    public function index() {
        return NULL;
    }

    public function annex_a1() {
        return view('reports::pages.philhealth_reports.annexa1')->with($this->data);
    }

    public function patientSearch() {
        $input = Input::all();
        $this->data['patientsdata'] = Patients::whereIn('patient_id',$this->data['facility_patients_list'])->where('first_name','LIKE','%'.$input['search_firstname'].'%')->where('middle_name','LIKE','%'.$input['search_middlename'].'%')->where('last_name','LIKE', '%'.$input['search_lastname'].'%')->get();
        
        return view('reports::pages.philhealth_reports.annexa1')->with($this->data);
        // dd($input, $this->data);
    }

    public function patientrecord($patient_id) {
        $this->data['patient'] = Patients::whereIn('patient_id',$this->data['facility_patients_list'])->with('patientMedicalHistory', 'patientEmploymentInfo', 'patientContact', 'patientPhilhealthInfo')->where('patient_id', $patient_id)->first();

        if($this->data['patient']) {
            $this->data['arrMembershipType'] = array('01'=>'FE - Private - Permanent Regular', 
                '02'=>'FE - Private - Casual',
                '03'=>'FE - Private - Contract/Project Based',
                '04'=>'FE - Govt - Permanent Regular', 
                '05'=>'FE - Govt - Casual', 
                '06'=>'FE - Govt - Contract/Project Based',
                '07'=>'FE - Enterprise Owner', 
                '08'=>'FE - Household Help/Kasambahay',
                '09'=>'FE - Family Driver', 
                '10'=>'IE - Migrant Worker - Land Based',  
                '11'=>'IE - Migrant Worker - Sea Based', 
                '12'=>'IE - Informal Sector',
                '13'=>'IE - Self Earning Individual',  
                '14'=>'IE - Filipino with Dual Citizenship',  
                '15'=>'IE - Naturalized Filipino Citizen',  
                '16'=>'IE - Citizen of other countries working/residing/studying in the Philippines',  
                '17'=>'IE - Organized Group',  
                '18'=>'Indigent - NHTS-PR',  
                '19'=>'Sponsored - LGU',  
                '20'=>'Sponsored - NGA', 
                '21'=>'Sponsored - Others',  
                '22'=>'Lifetime Member - Retiree/Pensioner',  
                '23'=>'Lifetime Member - With 120 months contribution and has reached retirement age');

            $LovDiseases = LovDiseases::all();
            $this->data['lovDiseases'] = $LovDiseases->groupBy('disease_category')->toArray();

            $LovExamination = LovExamination::all();
            $this->data['LovExamination'] = $LovExamination->groupBy('examination_type')->toArray();

            $fpu = FacilityPatientUser::where('patient_id', $patient_id)->first();
            $this->data['recenthealthcare'] = Healthcareservices::with('VitalsPhysical','Examination')->orderby('updated_at', 'DESC')->where('facilitypatientuser_id', $fpu->facilitypatientuser_id)->first();
            
            $this->data['patient']['age'] = getAge($this->data['patient']->birthdate);

            $this->data['patient']->patientContact['barangay'] = ucwords(strtolower(getBrgyName($this->data['patient']->patientContact['barangay'])));
            $this->data['patient']->patientContact['city'] = ucwords(strtolower(getCityNameReturn($this->data['patient']->patientContact['city'])));
            $this->data['patient']->patientContact['province'] = ucwords(strtolower(getProvinceNameReturn($this->data['patient']->patientContact['province'])));
            $this->data['patient']->patientContact['region'] = getRegionNameReturn($this->data['patient']->patientContact['region']);
           
            return view('reports::pages.philhealth_reports.annexa1')->with($this->data);
            // dd($this->data['patient']);
        } else {
            Session::flash('warning', 'Patient not found.');
            return view('reports::pages.philhealth_reports.annexa1')->with($this->data);
        }
    }

    public function annex_a2() {
        return view('reports::pages.philhealth_reports.annexa2');
    }

    public function annex_a3() {
        return view('reports::pages.philhealth_reports.annexa3');
    }

    public function annex_a4() {
        return view('reports::pages.philhealth_reports.annexa4');
    }

    public function annex_a5() {
        return view('reports::pages.philhealth_reports.annexa5');
    }


}
