<?php namespace ShineOS\Core\Referrals\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class referrals extends Model {
	use SoftDeletes; 
    protected $fillable = [];

	protected $table = 'referrals';
	protected static $static_table = 'referrals';
    protected $primaryKey = 'referral_id';

    protected $dates = ['deleted_at'];

    public function referralmessages() {
        return $this->hasMany('ShineOS\Core\Referrals\Entities\referralmessages', 'referral_id');
    }

    public function referralReasons() {
        return $this->hasMany('ShineOS\Core\Referrals\Entities\referralReasons', 'referral_id');
    }

    
}