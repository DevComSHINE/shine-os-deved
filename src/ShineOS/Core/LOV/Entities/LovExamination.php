<?php

namespace ShineOS\Core\LOV\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;  

class LovExamination extends Model {
    use SoftDeletes;  
    protected $fillable = [ ];
    protected $table = 'lov_examination'; 
    protected $primaryKey = 'examination_id';
}