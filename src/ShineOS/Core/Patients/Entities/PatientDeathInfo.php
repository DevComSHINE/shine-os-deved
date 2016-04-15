<?php 
namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientDeathInfo extends Model {

	use SoftDeletes;
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patient_death_info';
	protected static $table_name = 'patient_death_info';
	protected $primaryKey = 'patient_deathinfo_id';

	public function patients()
	{
		return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients','patient_id','patient_id');
	}

	public function facilityPatientUser()
	{
		return $this->belongsTo('ShineOS\Core\Patients\Entities\Patients','patient_id','patient_id');	
	}
}
