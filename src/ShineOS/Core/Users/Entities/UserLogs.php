<?php namespace ShineOS\Core\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class UserLogs extends Model {

	use SoftDeletes;
    /**
	 * Protected variables
	 *
	 * @var string
	 */
	protected $table = 'user_usage_stat';
	protected static $table_name = 'user_usage_stat';
	protected $primaryKey = 'userusagestat_id';
    protected $fillable = [];
	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['deleted_at'];

	/**
	 * Override primary key used by model
	 *
	 * @var int
	 */
	
	public function user()
	{
		return $this->belongsTo('ShineOS\Core\Users\Entities\Users','user_usage_stat','user_id');
	}
}
