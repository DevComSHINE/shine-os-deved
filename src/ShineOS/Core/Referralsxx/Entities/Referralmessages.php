<?php namespace ShineOS\Core\Referrals\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referralmessages extends Model {
	use SoftDeletes;
    protected $fillable = ['referralmessage_id'];

	protected $table = 'referral_messages';
	protected static $static_table = 'referral_messages';
	protected $primaryKey = 'referralmessage_id';
	
	public function Referrals(){
		return $this->belongsTo('ShineOS\Core\Referrals\Entities\Referrals','referral_id');
	}
}
