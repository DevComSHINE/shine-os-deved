<?php
namespace ShineOS\Core\Roles\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Roles extends Model {

    use SoftDeletes;
    /**
     * Protected variables
     *
     * @var string
     */
    protected $table = 'roles';
    protected static $table_name = 'roles';
    protected $primaryKey = 'role_id';
    protected $dates = ['deleted_at'];
    protected $fillable = [];

    /**
     * Override primary key used by model
     *
     * @var int
     */

    public function features()
    {
        return $this->belongsToMany('ShineOS\Core\Roles\Entities\Features','feature_role','role_id','feature_id')->withPivot('featureroleuser_id');
    }

    public function access()
    {
        return $this->belongsToMany('ShineOS\Core\LOV\Entities\LovRolesAccess','roles_access','role_id','role_id')->withPivot('created_at');
    }
}
