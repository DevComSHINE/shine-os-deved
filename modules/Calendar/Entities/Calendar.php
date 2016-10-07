<?php 
namespace Modules\Calendar\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Calendar extends Model {

    protected $table = 'calendar';
    protected static $static_table = 'calendar';
    protected $primaryKey = 'id';
    protected $fillable = [];

}
