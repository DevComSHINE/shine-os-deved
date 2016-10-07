<?php
namespace ShineOS\Core\Roles\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class RolesAccess extends Model {

    use SoftDeletes;
    /**
     * Protected variables
     *
     * @var string
     */
    protected $table = 'roles_access';
    protected static $table_name = 'roles_access';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at','created_at','updated_at'];
    protected $fillable = [];

    public function assignRole($role, $facilityuser_id) {
        dd($facilityuser_id);
    }
}
