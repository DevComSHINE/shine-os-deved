<?php
namespace ShineOS\Core\Reports\Entities;

use Shine\Libraries\FacilityHelper;
use ShineOS\Core\Patients\Entities\Patients;
use App\Libraries\CSSColors;
use DB, Input, DateTime;
use Illuminate\Database\Eloquent\Model;

class M2 extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fhsis_m2';
    protected static $table_name = 'fhsis_m2';
    protected $primaryKey = 'id';


}
