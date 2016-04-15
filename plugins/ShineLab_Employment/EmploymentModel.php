<?php

namespace Plugins\ShineLab_Employment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class EmploymentModel extends Model {

    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'patient_employmentinfo';
    protected static $table_name = 'patient_employmentinfo';
    protected $primaryKey = 'patient_id';

}
