<?php
namespace ShineOS\Core\Reports\Entities;

use Shine\Libraries\FacilityHelper;
use ShineOS\Core\Patients\Entities\Patients;
use App\Libraries\CSSColors;
use DB, Input, DateTime, Session;
use Illuminate\Database\Eloquent\Model;

class M1FP extends Model {

    /**
     *  REUSABLE SCOPE HERE
     */

    protected $table = 'fhsis_m1fp';
    protected static $table_name = 'fhsis_m1fp';
    protected $primaryKey = 'id';


    public static function doFP($method,$col, $month, $year, $time = NULL) {

        $facility = Session::get('facility_details');

        if($time AND $time == 'prev') {
            if($month == 1) {
                $month = 12;
                $year = $year - 1;
            } else {
                $month = $month - 1;
            }
        }

        $val = DB::table(self::$table_name)->select($col)->where('facility_id', $facility->facility_id)->where('current_method', $method)->where('FPmonth', $month)->where('FPyear', $year)->first();
        if($val) {
            return $val->$col;
        } else {
            return 0;
        }
    }
}
