<?php
use ShineOS\Core\Healthcareservices\Entities\LOV; //model

function getAge($birthdate)
{
    return date_diff(date_create($birthdate), date_create('today'))->y;
}

function csv_to_array($filename, $delimiter='') //removing headers
{
    if(!file_exists($filename) || !is_readable($filename))
    {
        return FALSE;
    }

    $header = NULL;
    $data = array();

    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        fgetcsv($handle);
        while (($row = fgetcsv($handle, 0, $delimiter)) !== FALSE)
        {
            $data[] = $row;
        }
        fclose($handle);
    }
    //print_r($data);
    return $data;
}


function dateFormat($date, $format) {
    $date = new DateTime($date);
    $date = $date->format($format);
    return $date;
}

function getCurrentDate($format = null) {
    date_default_timezone_set('Asia/Manila');
    $date = new DateTime('now');
    $date = ($format != null) ? $date->format($format) : $date->format('Y-m-d');

    return $date;
}

function getMysqlDate() {
    date_default_timezone_set('Asia/Manila');
    $date = new DateTime('now');
    $date = $date->format('Y-m-d H:i:s');

    return $date;
}


function DiagGetCategory($id) {
    return LOV::icd10_category($id);
}

function DiagSubCategory($id) {
    return LOV::icd10_subcat($id);
}

function DiagSubSubCategory($id) {
    return LOV::icd10_subsubcat($id);
}

function getBrgyName($brgycode) {
    $barangay = DB::table('lov_barangays')
            ->where('barangay_code', '=', $brgycode)
            ->first();
    if($barangay) {
        return $barangay->barangay_name;
    } else {
        return NULL;
    }
}

function getBrgyCode($brgyname) {
    $barangay = DB::table('lov_barangays')
    ->where('barangay_name', 'LIKE',  $brgyname.'%')
    ->first();

    if($barangay) {
        return $barangay->barangay_code;
    } else {
        return NULL;
    }
}

function getCityName($citycode) {
    $city = DB::table('lov_citymunicipalities')
            ->where('city_code', '=', $citycode)
            ->first();

    if($city) {
        echo $city->city_name;
    } else {
        return NULL;
    }
}

function getCityCode($cityname) {
    $city = DB::table('lov_citymunicipalities')
            ->where('city_name', 'LIKE', $cityname.'%')
            ->first();

    if($city) {
        return $city->city_code;
    } else {
        return NULL;
    }
}

function getProvinceName($provcode) {
    $province = DB::table('lov_province')
            ->where('province_code', '=', $provcode)
            ->first();
    if($province) {
        echo $province->province_name;
    } else {
        return NULL;
    }
}

function getProvinceCode($province) {
    $province = DB::table('lov_province')
            ->where('province_name', '=', $province)
            ->first();
    if($province) {
        return $province->province_code;
    } else {
        return NULL;
    }
}

function getRegionName($regioncode) {
    $region = DB::table('lov_region')
            ->where('region_code', '=', $regioncode)
            ->first();
    if($region) {
        echo $region->region_name;
    } else {
        return NULL;
    }
}

function getRegionCode($region) {
    $region = DB::table('lov_region')
            ->where('region_short', '=', $region)
            ->first();
    if($region) {
        return $region->region_code;
    } else {
        return NULL;
    }
}

function getCityNameReturn($citycode) {
    $city = DB::table('lov_citymunicipalities')
            ->where('city_code', '=', $citycode)
            ->first();

    if($city) {
        return $city->city_name;
    } else {
        return NULL;
    }
}

function getProvinceNameReturn($provcode) {
    $province = DB::table('lov_province')
            ->where('province_code', '=', $provcode)
            ->first();
    if($province) {
        return $province->province_name;
    } else {
        return NULL;
    }
}

function getRegionNameReturn($regioncode) {
    $region = DB::table('lov_region')
            ->where('region_code', '=', $regioncode)
            ->first();
    if($region) {
        return $region->region_name;
    } else {
        return NULL;
    }
}

function getModuleStatus($name)
{
    $module = DB::table('lov_modules')
            ->where('module_name', '=', $name)
            ->first();

    if($module) {
        return $module->status;
    } else {
        return NULL;
    }
}

function getPercentage($numerator, $denominator, $multiplier = 100, $decimalplace = 2)
{
    $answer = 0;
    if($denominator != 0 || $denominator != NULL)
    {
        $answer = number_format(($numerator/$denominator)*$multiplier, $decimalplace);
    }
    return $answer;
}

?>
