<?php namespace ShineOS\Core\Referrals\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referrals extends Model {
	use SoftDeletes; 
    protected $fillable = [];

	protected $table = 'referrals';
	protected static $static_table = 'referrals';
    protected $primaryKey = 'referral_id';

    protected $dates = ['deleted_at'];

    public function Referralmessages() {
        return $this->hasMany('ShineOS\Core\Referrals\Entities\Referralmessages', 'referral_id');
    }

    public function ReferralReasons() {
        return $this->hasMany('ShineOS\Core\Referrals\Entities\ReferralReasons', 'referral_id');
    }

    
}