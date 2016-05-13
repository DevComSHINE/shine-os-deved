<?php namespace ShineOS\Core\Referrals\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class referralmessages extends Model {
	use SoftDeletes;
    protected $fillable = ['referralmessage_id'];

	protected $table = 'referral_messages';
	protected static $static_table = 'referral_messages';
	protected $primaryKey = 'referralmessage_id';
	
	public function referrals(){
		return $this->belongsTo('ShineOS\Core\Referrals\Entities\referrals','referral_id');
	}
}
