<?php
namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Sync {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sync';
    protected static $table_name = 'sync';
    protected $primaryKey = 'sync_id';

    /**
     * Returns table name
     *
     * @return object
     */
    public static function getSyncDateTime ()
    {
        return self::where('facility_id', $facility_id)->first();
    }

}