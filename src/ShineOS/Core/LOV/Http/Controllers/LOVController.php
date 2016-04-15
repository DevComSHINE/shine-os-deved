<?php namespace ShineOS\Core\LOV\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\LOV\Entities\LovICD10;
use ShineOS\Core\LOV\Entities\LovLaboratories;
use ShineOS\Core\LOV\Entities\LovMedicalCategory;
use ShineOS\Core\LOV\Entities\LovDiagnosis;
use ShineOS\Core\LOV\Entities\LovHealthcareTabs;

/**
 * Address LOV
 */
use ShineOS\Core\LOV\Entities\LovRegion;
use ShineOS\Core\LOV\Entities\LovProvince;
use ShineOS\Core\LOV\Entities\LovCityMunicipalities;
use ShineOS\Core\LOV\Entities\LovBarangays;

use View, Form, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Request, Storage, Schema;

class LOVController extends Controller {

    public function index() {
        return view('lov::index');
    }

    /**
     * Address
     * @return lists
     */
    public function regionApi() {
        return LovRegion::lists('region_short','region_code');
    }

    public function provinceApi() {
        return LovProvince::lists('province_name','province_code');
    }

    public function cityApi() {
        return LovCityMunicipalities::lists('city_name','city_code');
    }

    public function brgyApi() {
        return LovBarangays::lists('barangay_name','barangay_code');
    }

    /**
     * Address by
     * @return lists
     */
    public function provinceByRegionApi() {
        $region = Input::get('region');
        return LovProvince::where('region_code',$region)->lists('province_name','province_code');
    }

    public function cityByProvinceApi() {
        $province = Input::get('province');
        return LovCityMunicipalities::where('province_code',$province)->lists('city_name','city_code');
    }

    public function brgyByCityApi() {
        $city = Input::get('city');
        $b = LovBarangays::where('city_code',$city)->lists('barangay_name','barangay_code');

        if(count($b)>0) {
            return $b;
        } else {
            $b = collect(['000000' => 'No barangays in this city.']);
            return $b;
        }


    }

    /**
     * ICD10
     * @return lists
     */
    public function icd10Code() {
        return LovICD10::where('icd10_category', 0)
                        ->where('icd10_subcategory', 0)
                        ->where('icd10_tricategory', 0)
                        ->lists('icd10_title','icd10_code');
    }

    public function icd10Category() {
        return LovICD10::where('icd10_subcategory', 0)
                        ->where('icd10_tricategory', 0)
                        ->lists('icd10_title','icd10_code');
    }

    public function icd10CategoryByCode() {
        $id = Input::get('parent');
        return LovICD10::where('icd10_category',$id)
                        ->where('icd10_subcategory', 0)
                        ->where('icd10_tricategory', 0)
                        ->lists('icd10_title','icd10_code');
    }

    public function icd10SubCategory() {
        return LovICD10::where('icd10_tricategory', 0)
                        ->lists('icd10_title','icd10_code');
    }

    public function icd10SubCategoryByCategory() {
        $id = Input::get('category');
        return LovICD10::where('icd10_subcategory', $id)
                        ->where('icd10_tricategory', 0)
                        ->lists('icd10_title','icd10_code');
    }

    public function icd10SubSubCategory() {
        return LovICD10::where('icd10_category', '!=', 0)
                        ->where('icd10_subcategory', '!=', 0)
                        ->where('icd10_tricategory', '!=', 0)
                        ->lists('icd10_title','icd10_code');
    }

    public function icd10SubSubCategoryBySubCategory() {
        $id = Input::get('subcat');
        return LovICD10::where('icd10_tricategory', $id)
                        ->where('icd10_category', '!=', 0)
                        ->where('icd10_subcategory', '!=', 0)
                        ->where('icd10_tricategory', '!=', 0)
                        ->lists('icd10_title','icd10_code');
    }

    /**
     * ('HP','Hypertensive'),
     * ('NH','Nonhypertensive')
    *  ('NA','Not Applicable')
     */
    public function bloodpressure_assessment($systolic, $diastolic){
        if(!empty($systolic) AND !empty($systolic)) {
            if(($systolic >= 70 AND $systolic <= 90) AND ($diastolic >= 40 AND $diastolic <= 60)) {
                return 'NH';
            } elseif(($systolic >= 140 AND $systolic <= 190) AND ($diastolic >= 90 AND $diastolic <= 100)) {
                return 'HP';
            } else {
                return 'NA';
            }
        }
        return false;
    }

    public function bloodpressure_assessment_name($code){
        if(!empty($code)) {
            if($code=='NH'){
                return 'Nonhypertensive';
            } elseif($code=='HP'){
                return 'Hypertensive';
            } else{
                return 'Not Applicable';
            }
        }
        return false;
    }
}
