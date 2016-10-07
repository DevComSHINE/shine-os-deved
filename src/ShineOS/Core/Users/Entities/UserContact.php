<?php namespace ShineOS\Core\Users\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserContact extends Model {
	use SoftDeletes; 
    protected $fillable = [];

    protected $table = 'user_contact';
	protected static $static_table = 'user_contact';
    protected $primaryKey = 'usercontact_id';

    protected $dates = ['deleted_at'];
}