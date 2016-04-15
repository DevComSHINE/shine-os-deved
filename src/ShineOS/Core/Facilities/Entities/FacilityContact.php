<?php namespace ShineOS\Core\Facilities\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DB, Input;

class FacilityContact extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'facility_contact';
    protected static $table_name = 'facility_contact';

    /**
     * Override primary key used by model
     *
     * @var int
     */
    protected $primaryKey = 'facilitycontact_id';


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
    public static function getContact ( $facility_id = 0 )
    {
        return DB::table(self::$table_name)
            ->where('facility_id', $facility_id)
            ->first();
    }

    public function facility()
    {
        return $this->belongsTo('ShineOS\Core\Facilities\Entities\Facilities','facility_id');
    }

    /**
     * Updates facility contact info
     *
     * @return object
     */
    public static function updateContactByFacilityId ( $facility_id = 0 )
    {
        $contact = self::where('facility_id', $facility_id)
            ->first();
        //self::print_this($contact, '$contact');

        $contact->email_address = Input::get('email_address');
        $contact->mobile = Input::get('mobile');
        $contact->website = Input::get('website');
        $contact->hospital_license_number = Input::get('hospital_license_number');
        $contact->house_no = Input::get('house_no');
        $contact->building_name = Input::get('building_name');
        $contact->street_name = Input::get('street_name');
        $contact->village = Input::get('village');
        $contact->region = Input::get('region');
        $contact->province = Input::get('province');
        $contact->city = Input::get('city');
        $contact->barangay = Input::get('brgy');
        $contact->zip = Input::get('zip');
        $contact->country = Input::get('country');
        $contact->save();

        return $contact;
    }

    private static function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }
}
