<?php namespace ShineOS\Core\Facilities\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Shine\Libraries\IdGenerator;

use DB, Input;

class FacilityWorkforce extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facility_workforce';
    protected static $table_name = 'facility_workforce';

    /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'facilityworkforce_id';


    /**
     * Returns table name
     *
     * @return string
     */
    public static function getTableName () {
        return self::$table_name;
    }


    /**
     * Returns facility contact info
     *
     * @return object
     */
    public static function getWorkforce ( $facility_id = 0 )
    {
        return DB::table(self::$table_name)
            ->where('facility_id', $facility_id)
            ->orderBy('created_at', 'DESC')
            ->first();
    }

    public function facility()
    {
        return $this->belongsTo('ShineOS\Core\Facilities\Entities\Facilities','facility_id');
    }

    /**
     * Updates facility workforce info
     *
     * @return object
     */
    public static function updateFacilityWorkforceById( $id = 0 ) {

        $facility = self::find($id);

        $posted = $_POST;
        unset($posted['_token']);
        $workforce_count = json_encode($posted);

        $workforce = new self();
        $workforce->facility_id = $id;
        $workforce->facilityworkforce_id = IdGenerator::generateId();
        $workforce->workforce = $workforce_count;
        $workforce->save();

        return $facility;
    }

    private static function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }
}
