<?php
namespace ShineOS\Core\Reports\Entities;

use Shine\Libraries\FacilityHelper;
use ShineOS\Core\Patients\Entities\Patients;
use App\Libraries\CSSColors;
use DB, Input, DateTime;
use Illuminate\Database\Eloquent\Model;

class M1 extends Model {
    
    

    /**
     *  REUSABLE SCOPE HERE
     */
    
    public function scopePrenatalVisits($query, $month)
    {
        return $query->where('created_at','>', $month);
    }
}
