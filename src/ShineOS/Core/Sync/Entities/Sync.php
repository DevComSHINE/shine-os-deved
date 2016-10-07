<?php 
namespace ShineOS\Core\Sync\Entities;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Sync extends Model {
    use SoftDeletes;  
    
    protected $fillable = [];
    protected $dates = array('deleted_at','created_at','updated_at');
    protected $table = 'sync';
    protected $primaryKey = 'sync_id';
    
 
    public static function getSyncDateTime($facility_id = "", $toFrom) {
    	$facility_id = ($facility_id == "") ? NULL : $facility_id;
    	$data = self::where('facility_id', $facility_id)->where('toFrom', $toFrom)->orderBy('updated_at','DESC')->first();
    	return $data;
    }

    public static function getAllTables()
	{
		$last_sync_date = new Sync();
		$last_sync_date = $last_sync_date->getSyncDateTime();

		dd($last_sync_date);
		 $all_tables = DB::select("SHOW TABLES FROM shinedb WHERE Tables_in_shinedb NOT IN ('migrations', 'lov_allergy_reaction','lov_barangays','lov_citymunicipalities','lov_diagnosis','lov_disabilities','lov_diseases', 'lov_doh_facility_codes', 'lov_drugs','lov_enumerations', 'lov_forms','lov_icd10','lov_immunizations','lov_laboratories', 'lov_loincs','lov_medicalcategory','lov_medicalprocedures','lov_modules','lov_province', 'lov_referral_reasons','lov_roles_access','lov_region','plugins', 'sync')"); // temp query - optimize this
		
		$records = array();
		
		foreach($all_tables as $table)
		{		
			if ($last_sync_date != null)
			{
		    	$records[$table->Tables_in_shinedb] = DB::table($table->Tables_in_shinedb)->where('updated_at','>=', $last_sync_date->updated_at)->count();
		    }
			else
			{
				$records[$table->Tables_in_shinedb] = DB::table($table->Tables_in_shinedb)->count();
			}
		}

		$all_records = $this->getAllTableRecords($records, $last_sync_date);

		return $all_records;
	}

	/**
	 * Retrieves all records that are more recent than the last sync date
	 */

	private function getAllTableRecords($records, $last_sync_date)
	{
		$sync_date = ($last_sync_date != null) ? $last_sync_date->updated_at : '';
		$all_records = '';

		foreach($records as $key => $val):
			if ($val > 0):
				$all_records[$key] = DB::table($key)->where('updated_at','>=', $sync_date)->get();
			endif;
		endforeach;

		return $all_records;
	}

}