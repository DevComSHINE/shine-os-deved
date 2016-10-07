<?php namespace ShineOS\Core\Facilities\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DB, Input;

class DOHFacilityCode extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lov_doh_facility_codes';
    protected static $table_name = 'lov_doh_facility_codes';

    /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'DOHfacilitycode_id';


    /**
     * Returns table name
     *
     * @return string
     */
    public static function getTableName () {
        return self::$table_name;
    }


    /**
     * Returns facility doh info by Facility ID
     *
     * @return object
     */
    public static function getDoh ( $facility_id = 0 )
    {
        return DB::table(self::$table_name)
            ->where('facility_id', $facility_id)
            ->first();
    }


    /**
     * Returns facility doh info by DOH Code
     *
     * @return object
     */
    public static function checkDoh ( $code = 0 )
    {
        return DB::table(self::$table_name)
            ->where('code', $code)
            ->first();
    }

    /**
     * Updates facility doh info
     *
     * @return object
     */
    public static function updateByFacilityId ( $facility_id = 0 ) {
        $doh = self::where('facility_id', $facility_id)
            ->first();

        $doh->name = Input::get('facility_name');
        $doh->DOH_facility_code = Input::get('DOH_facility_code');
        $doh->save();

        return $doh;
    }

    private static function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }
}
