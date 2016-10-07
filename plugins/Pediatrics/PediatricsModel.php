<?php
namespace Plugins\Pediatrics;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class PediatricsModel extends Model {

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pediatrics_service';
    protected static $table_name = 'pediatrics_service';
    protected $primaryKey = 'pediatrics_id';

}
