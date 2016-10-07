<?php namespace ShineOS\Core\Referrals\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferralReasons extends Model {
    use SoftDeletes;
    protected $fillable = [];

	protected $table = 'referral_reasons';
	protected static $static_table = 'referral_reasons';
	protected $primaryKey = 'referralreason_id';

	public function Referrals(){
		return $this->belongsTo('ShineOS\Core\Referrals\Entities\Referrals','referral_id');
	}
}