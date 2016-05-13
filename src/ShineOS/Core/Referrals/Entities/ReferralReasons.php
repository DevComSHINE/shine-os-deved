<?php namespace ShineOS\Core\Referrals\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class referralReasons extends Model {
    use SoftDeletes;
    protected $fillable = [];

	protected $table = 'referral_reasons';
	protected static $static_table = 'referral_reasons';
	protected $primaryKey = 'referralreason_id';

	public function referrals(){
		return $this->belongsTo('ShineOS\Core\Referrals\Entities\referrals','referral_id');
	}
}