<?php namespace Shine\Libraries\Utils;

use Illuminate\Support\Collection;
use DB;

class Lovs
{

    function __construct () {

    }

    /**
     * Get records from LOV tables
     *
     * @var int
     */
    public static function getLovs($table)
    {
        $records = DB::table('lov_'.$table)->get();

        return $records;
    }

    public static function getLovsWhere($table, $field, $value)
    {
        $records = DB::table('lov_'.$table)
            ->where($field, $value)
            ->get();

        return $records;
    }

    public static function getEnumsByType($type)
    {
        $records = DB::table('lov_enumerations')->where('enum_type_id', $type)->orderby('sequence_number')->get();
        return $records;
    }

    public static function getValueOfFieldBy($table, $field, $param, $value)
    {
        $records = DB::table('lov_'.$table)->where($param, $value)->first();

        if($records) {
            return $records->$field;
        } else {
            return NULL;
        }
    }

    public static function getBloodTypes()
    {
        $bloodType = Collection::make(['A-', 'A+', 'AB-','AB+','B-','B+','O-','O+','U']);

        return $bloodType;
    }

    public static function getAlerts()
    {
        $alerts = Collection::make(['ALLER', 'DISAB', 'DRUGS','HANDI','IMPAI','NOTAP','OTHER']);

        return $alerts;
    }
}
