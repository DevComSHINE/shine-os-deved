<?php
namespace Shine\Libraries;

use Illuminate\Support\Collection;
use DB, File;

/**
 *  A class for lovs
 *  NOTE: - TRANSFER TO UTILS FOLDER THEN RENAME TO A MORE APPROPRIATE CLASS NAME
 *        - METHODS SHOULD BE PLURAL
 */

class Utils
{
    public static function barangay()
    {
        $barangay = DB::table('lov_barangays')->get();

        return $barangay;
    }

    public static function province()
    {
        //$barangay = DB::table('lov_provinces')->get();
        $province = DB::table('lov_province')->get();

        return $province;
    }

    public static function others($id = NULL)
    {
        $citymun = DB::table('lov_citymunicipalities')->where('region_code','=',$id)->get();

        return $citymun;
    }

    public static function region()
    {
        $region = DB::table('lov_region')->orderBy('region_name')->get();

        return $region;
    }

    //added by RJBS

    /**
     * Get Dropdown Regions with given Region selected
     *
     * @param region
     * @return string
     */
    public static function get_regions($reg=NULL)
    {
        $form = '';
        $regions = self::region();
        if($reg == NULL) {
            $form .= "<option value='' selected='selected' >- Choose Region -</option>";
        }
        //create menu
        foreach($regions as $region) {
            $sel = '';
            if($reg AND $reg == $region->region_code) $sel = " selected='selected'";
            $form .= "<option value='".$region->region_code."'".$sel.">".$region->region_name."</option>";
        }
        print $form;
    }

    /**
     * Get Dropdown Provinces with given Province selected
     *
     * @param region
     * @return string
     */
    public static function get_provinces($region, $prov=NULL)
    {
        $form = '';
        $provinces = DB::table('lov_province')->where('region_code', $region)->get();
        if($prov == NULL AND $region != NULL) {
            $form .= "<option value='' selected='selected' >- Choose Province -</option>";
        }
        if($region == NULL) {
            $form .= "<option value='' selected='selected' >- Choose region first -</option>";
        }
        //create menu
        foreach($provinces as $province) {
            $sel = '';
            if($prov != NULL AND $prov == $province->province_code) $sel = "selected='selected'";
            $form .= "<option value='".$province->province_code."' ".$sel." >".$province->province_name."</option>";
        }

        print $form;
    }

    public static function get_all_provinces($prov=NULL)
    {
        $form = '';
        $provinces = DB::table('lov_province')->get();

        foreach($provinces as $province) {
            $sel = '';
            if($prov != NULL AND $prov == $province->province_code) $sel = "selected='selected'";
            $form .= "<option value='".$province->province_code."' ".$sel." >".$province->province_name."</option>";
        }

        print $form;
    }

    /**
     * Get Dropdown Cities with given City selected
     *
     * @param region
     * @return string
     */
    public static function get_cities($region=NULL, $prov=NULL, $citi=NULL)
    {

        $form = "";
        $cities = DB::table('lov_citymunicipalities')->where('region_code',$region)->where('province_code',$prov)->get();
        if($region == NULL) {
            $form .= "<option value='' selected = 'selected' >- Choose region first -</option>";
        }
        if($prov == NULL AND $region != NULL) {
            $form .= "<option value='' selected = 'selected' >- Choose province first -</option>";
        }
        if($citi == NULL AND $prov != NULL AND $region != NULL) {
            $form .= "<option value='' selected = 'selected' >- Choose City/Municipality -</option>";
        }
        //create menu
        foreach($cities as $city) {
            $sel = '';
            if($citi != NULL AND $citi == $city->city_code) $sel = "selected = 'selected'";
            $form .= "<option value='".$city->city_code."' ".$sel." >".$city->city_name."</option>";
        }

        print $form;
    }

    /**
     * Get Dropdown Barangays with given Barangay selected
     *
     * @param region
     * @return string
     */
    public static function get_brgys($region=NULL, $province=NULL, $city=NULL, $bgy=NULL)
    {

        $form = "";
        $brgys = DB::table('lov_barangays')
            ->where('region_code',$region)
            ->where('province_code',$province)
            ->where('city_code',$city)
            ->get();

        if($region == NULL) {
            $form .= "<option value='' selected = 'selected' >- Choose region first -</option>";
        }
        if($region != NULL AND $province == NULL) {
            $form .= "<option value='' selected = 'selected' >- Choose province first -</option>";
        }
        if($region != NULL AND $province != NULL AND $city == NULL) {
            $form .= "<option value='' selected = 'selected' >- Choose city first -</option>";
        }
        if($region != NULL AND $province != NULL AND $city != NULL AND $bgy == NULL) {
            $form .= "<option value='' selected = 'selected' >- Choose Barangay -</option>";
        }
        //create menu
        if($brgys) {
            foreach($brgys as $brgy) {
                $sel = '';
                if($bgy != NULL AND $bgy == $brgy->barangay_code) {
                    $sel = "selected = 'selected'";
                }
                $form .= "<option value='".$brgy->barangay_code."' ".$sel." >".$brgy->barangay_name."</option>";
            }
        } else {
            $form = "<option value='0' selected = 'selected' >- No barangays in this city -</option>";
        }

        print $form;
    }

    //end of added by RJBS

    // public static function countries()
    // {

    // }

    public static function religion()
    {
        $religion = Collection::make([
            'AGLIP'=>'Aglipay',
            'ALLY'=>'Alliance of Bible Christian Communities',
            'BAPTI'=>'Baptist',
            'BRNAG'=>'Born Again Christian',
            'BUDDH'=>'Buddhism',
            'CATHO'=>'Catholic',
            'XTIAN'=>'Christian',
            'CHOG'=>'Church of God',
            'EVANG'=>'Evangelical',
            'IGNIK'=>'Iglesia ni Cristo',
            'JEWIT'=>'Jehovahs Witness',
            'LRCM'=>'Life Renewal Christian Ministry',
            'LUTHR'=>'Lutheran',
            'METOD'=>'Methodist',
            'MORMO'=>'LDS-Mormons',
            'MUSLI'=>'Islam',
            'PENTE'=>'Pentecostal',
            'PROTE'=>'Protestant',
            'SVDAY'=>'Seventh Day Adventist',
            'UCCP'=>'UCCP',
            'UNKNO'=>'Unknown',
            'WESLY'=>'Wesleyan',
            'OTHER'=>'Others',
        ]);

        return $religion;
    }

    public static function education()
    {
        $education = Collection::make([
            '01'=>'Elementary Education',
            '02'=>'High School Education',
            '03'=>'College',
            '04'=>'Postgraduate Program',
            '05'=>'No Formal Education/No Schooling',
            '06'=>'Not Applicable',
            '07'=>'Vocational',
            '99'=>'Others'
        ]);

        return $education;
    }

    /**
     * Utilities for Registration Module
     */

    public static function faciltyType()
    {
        $faciltyType = Collection::make([
            'Barangay Health Station' => 'Barangay Health Station',
            'Birthing Home' => 'Birthing Home',
            'City Health Office'=> 'City Health Office',
            'District Health Office'=>'District Health Office',
            'Hospital'=>'Hospital',
            'Main Health Center'=>'Main Health Center',
            'Municipal Health Office'=>'Municipal Health Office',
            'Provincial Health Office'=>'Provincial Health Office',
            'Rural Health Unit' => 'Rural Health Unit',
            'Private Clinic' => 'Private Clinic'
        ]);

        return $faciltyType;
    }

    public static function getModules()
    {
        $coreModules = config("core.core");
        $allModules = array_map('basename', File::directories(base_path().'/modules'));
        $modules = [];
        $reg = '/(?<=[a-z])(?=[A-Z])/x';

        foreach($allModules as $val):
            if (!in_array($val, $coreModules)):
                $title = preg_split($reg, $val);
                $sidebar_title = implode(" ",$title);
                $modules[strtolower($val)] = $sidebar_title;
            endif;
        endforeach;

        return $modules;
    }
}
