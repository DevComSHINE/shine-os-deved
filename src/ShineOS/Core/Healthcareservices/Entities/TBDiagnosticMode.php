<?php namespace ShineOS\Core\Healthcareservices\Entities;
   
use Illuminate\Database\Eloquent\Model;
use DB;

class TBDiagnosticMode extends Model {

    protected $fillable = [
        'tbdiagnostictest_id',
        'tuberculosis_id', 
        'diagnostic_test_type',
        'scheduled_date',
        'actual_date',
        'diagnostic_test_type_result',
        'diagnostic_test_type_findings_notes',
        'deleted_at'
    ];

    protected $table = 'tb_diagnostic_test';

    protected $primaryKey = 'id';


}