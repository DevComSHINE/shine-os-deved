<?php namespace ShineOS\Core\Roles\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Features extends Model {

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'features';
    protected static $table_name = 'features';
    protected $primaryKey = 'feature_id';
    protected $dates = ['deleted_at'];
    protected $fillable = [];

    /**
     * Override primary key used by model
     *
     * @var int
     */

    public function roles()
    {
        return $this->belongsToMany('ShineOS\Core\Roles\Entities\Roles','feature_role','feature_id','role_id')->withPivot('featureroleuser_id');
    }

    /**
     * Transfer to a class library
     *     This checks if the added feature is a core feature or not
     * @param  [string] $feature [feature name]
     * @return [bool]
     */
    public static function checkIfCore($feature)
    {
        $feature = strtolower($feature);

        $core_features = array('records','referrals','reminders','reports');

        if (in_array($feature, $core_features)):
            return false;
        endif;

        return true;
    }
}
