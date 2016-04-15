<?php

namespace Plugins\Dengue;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class DengueModel extends Model {

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dengue_record';
    protected static $table_name = 'dengue_record';
    protected $primaryKey = 'dengue_id';


}
