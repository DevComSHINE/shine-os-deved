<?php
namespace ShineOS\Core\LOV\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LovRolesAccess extends Model {
    use SoftDeletes;

    protected $fillable = [ ];
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $table = 'lov_roles_access';
    protected $primaryKey = 'role_id';

    public function roles()
    {
        return $this->belongsToMany('ShineOS\Core\Users\Entities\Roles','roles_access','role_id','role_id')->withPivot('created_at');
    }
}
