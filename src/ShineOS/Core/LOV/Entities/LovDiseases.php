<?php namespace ShineOS\Core\LOV\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  

class LovDiseases extends Model {
    use SoftDeletes;  
    protected $fillable = [ ];
    protected $table = 'lov_diseases'; 
    protected $primaryKey = 'disease_id';
}