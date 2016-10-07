<?php
namespace ShineOS\Core\Sync\Http\Controllers;

use Illuminate\Routing\Controller;
use Shine\Libraries\IdGenerator;
use ShineOS\Core\Sync\Entities\Sync;
use DB, Session, Schema, Config;

class SyncController extends Controller {

    protected $curr_db;
    protected $master_array = array();

    public function __construct() {
        DB::enableQueryLog();
        $this->curr_db = Config::get('database.connections.'.Config::get('database.default').'.database');
    }

    public function sendtoCloud() {
        $all = $this->getAllTables();
        if($all!=NULL) {
            $sync = json_decode($this->sendRecords('manageRecords', $all));
        } else {
            $sync = json_encode(array('status'=>'Facility ID does not exists.'), 400);
        }

        dd($sync);
        return $sync;
    }

    public function downloadFromCloud() {
        $result = NULL;
        $facility_details = Session::get('facility_details')->toArray();

        //compare tables from CE to CLOUD
        $tables = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$this->curr_db."' AND TABLE_NAME NOT IN ('sync','phie_sync','tracker','migrations','api_user_account','sessions','roles') AND TABLE_NAME NOT LIKE 'temp_%' AND TABLE_NAME NOT LIKE 'lov_%' AND TABLE_NAME NOT LIKE '%_view'");
        $tables['facility_id'] = $facility_details['facility_id'];
        // dd($tables);
        // echo "<pre> downloadFromCloud "; print_r($facility_details['facility_id']); echo "</pre>";
        $sync = json_decode($this->sendRecords('cloudRecords', $tables));
        if($sync) {
            $result = $this->insert_to_DB($sync);
        }

        if($result){
            $a =$this->insertLastSync($facility_details['facility_id'], "fromCloud");
        }
        dd($result);
        return $result;
    }

    public function index()	{
        return view('sync::index');
    }

    /*** To Cloud */
    private function getAllTables() {
        $all_records = NULL;
        $facility_details = Session::get('facility_details')->toArray();
        $last_sync_date = json_decode($this->getLastSync('toCloud'));
        $countFacilityID = self::checkFacilityID();

        if($countFacilityID!=0) {
            $TablesInCurrDB = "Tables_in_".$this->curr_db;
            $whereInTables = $this->gettableData();

            $all_tables = DB::select("SHOW TABLES FROM ".$this->curr_db." WHERE ".$TablesInCurrDB." IN (".$whereInTables.")");
            $records = array();
            foreach($all_tables as $table) {
                if (isset($last_sync_date->updated_at)) {
                    $records[$table->$TablesInCurrDB] = DB::table($table->$TablesInCurrDB)->where('updated_at','>=', $last_sync_date->updated_at)->get();
                }
                else {
                    $records[$table->$TablesInCurrDB] = DB::table($table->$TablesInCurrDB)->get();
                }
            }
            $records['facility_id'] = $facility_details['facility_id'];
        }
        return $records;
    }

    //get and compare tables CE to CLOUD and vice versa
    private function gettableData() {
        $tables = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$this->curr_db."'");
        $tbl_result = $this->compareTables_CE_SAAS($tables); //connect to API, get result
        $values = array_flatten(json_decode($tbl_result, true));

        $whereInTables = '';
        foreach ($values as $key => $value) {
            $whereInTables .= "'".$value."'";
            if($value != end($values)){
                $whereInTables .= ", ";
            }
        }
        return $whereInTables;
    }


    /**********************************************************************************************************
    ** Sends records to SHINE API
    ************************************************************************************************************/

    public function sendRecords($param, $records) {
        $data = array(
          "Records" => $records
        );
        $url = "http://".getenv('CLOUDIP')."/devemr/api/sync/".$param;
        // $url = "http://localhost/shineoslaravel2/api/sync/".$param;
        $str_data = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "ShineKey:3670407151512120101064700",
            "ShineSecret:3670407151512120101064700")
        );
        $result = curl_exec($ch);
        curl_close($ch);
        // echo "<pre> sendRecords"; print_r($result); echo "</pre>";
        return $result;
    }

    /**
     * Get last sync date
     * @return [type] [description]
     */
    public static function getLastSync($toFrom=NULL) {
        $facility_id = Session::get('facility_details');
        $data = array(
          "facility_id" => $facility_id->facility_id,
          "toFrom" => $toFrom
        );

        $url = "http://".getenv('CLOUDIP')."/devemr/api/sync/getSyncDateTime";
        // $url = "http://localhost/shineoslaravel2/api/sync/getSyncDateTime";

        $str_data = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "ShineKey:3670407151512120101064700",
            "ShineSecret:3670407151512120101064700")
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**
     * Check Facility if exists
     */
    public static function checkFacilityID() {
        $facility_id = Session::get('facility_details');
        $data = array(
          "facility_id" => $facility_id->facility_id
        );

        $url = "http://".getenv('CLOUDIP')."/devemr/api/sync/checkFacilityID";
        // $url = "http://localhost/shineoslaravel2/api/sync/checkFacilityID";

        $str_data = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "ShineKey:3670407151512120101064700",
            "ShineSecret:3670407151512120101064700")
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function compareTables_CE_SAAS($tables) {
        foreach ($tables as $key => $value) {
            $array[$key] = $value->TABLE_NAME;
        }
        $data = $array;
        $url = "http://".getenv('CLOUDIP')."/devemr/api/sync/compareTables_CE_SAAS";
        // $url = "http://localhost/shineoslaravel2/api/sync/compareTables_CE_SAAS";

        $str_data = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "ShineKey:3670407151512120101064700",
            "ShineSecret:3670407151512120101064700")
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function insertLastSync($facilityid, $toFrom) {
        $data = array(
          "facility_id" => $facilityid,
          "toFrom" => $toFrom
        );

        $url = "http://".getenv('CLOUDIP')."/devemr/api/sync/insertLastSync";
        // $url = "http://localhost/shineoslaravel2/api/sync/insertLastSync";

        $str_data = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$str_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "ShineKey:3670407151512120101064700",
            "ShineSecret:3670407151512120101064700")
        );

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    /**********************************************************************************************************
    ** API SIDE
    ************************************************************************************************************/

    /**
     * Manage insertion of data
     */
    public static function manageRecords($records) {
        $id = $records['facility_id'];
        unset($records['facility_id']);
        $_this = new self;
        $ins_if_new = $_this->insert_to_DB($records);

        // CLOUD TO INSERT
        if($ins_if_new){
            self::insert_last_sync($id, 'toCloud');
            return TRUE;
        }
        return FALSE;
    }

    public static function compareTables($tables) {
        $_this = new self;
        $tables_2 = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$_this->curr_db."' AND TABLE_NAME NOT IN ('sync','phie_sync','tracker','migrations','api_user_account','sessions','roles') AND TABLE_NAME NOT LIKE 'temp_%' AND TABLE_NAME NOT LIKE 'lov_%' AND TABLE_NAME NOT LIKE '%_view'");
        foreach ($tables_2 as $key => $value) {
            $array[$key] = $value->TABLE_NAME;
        }
        $data = array_intersect($tables, $array); //compare
        return $data;
    }

    public static function insert_last_sync($facility_id, $toFrom = NULL) {
        $syncid = IdGenerator::generateId();
        $query = new Sync;
        $query->sync_id = $syncid;
        $query->facility_id = $facility_id;
        $query->toFrom = $toFrom;
        $query->save();

        return $query;
    }


    /**********************************************************************************************************
    ** CLOUD SIDE
    ************************************************************************************************************/

    // PLEASE SEPARATE INTO FUNCTIONS
    public static function cloudRecords($tables) {
        $_this = new self;
        $_this->curr_db = Config::get('database.connections.'.Config::get('database.default').'.database');
        $whereInTables = '';

        $facility_id = (!empty($tables)) ? $tables['facility_id'] : NULL;
        unset($tables['facility_id']);

        if(!empty($tables)) {
            $tables_2 = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$_this->curr_db."' AND TABLE_NAME NOT IN ('sync','phie_sync','tracker','migrations','api_user_account','sessions','roles') AND TABLE_NAME NOT LIKE 'temp_%' AND TABLE_NAME NOT LIKE 'lov_%' AND TABLE_NAME NOT LIKE '%_view'" );

            foreach ($tables as $key_1 => $value_1) {
                $array_1[$key_1] = $value_1['TABLE_NAME'];
            }

            foreach ($tables_2 as $key_2 => $value_2) {
                $array_2[$key_2] = $value_2->TABLE_NAME;
            }

            $tables_intersect = array_intersect($array_1, $array_2);

            foreach ($tables_intersect as $key_3 => $value_3) {
                $whereInTables .= "'".$value_3."'";
                if($value_3 != end($tables_intersect)){
                    $whereInTables .= ", ";
                }
            }
        }

        $updated_at = Sync::getSyncDateTime($facility_id, 'fromCloud');
        if($updated_at!=NULL OR $updated_at) {
            $updatedat = $updated_at->updated_at;
        } else {
            $updatedat = "0000-00-00 00:00:00";
        }
        // echo "<pre> updatedat "; print_r($updatedat); echo "</pre>";
        //step1 : select all table with facility_id column
        $facilities = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$_this->curr_db."' AND COLUMN_NAME = 'facility_id' AND TABLE_NAME IN (".$whereInTables.")");

        foreach($facilities as $table_facility_id) {
            $_this->master_array[$table_facility_id->TABLE_NAME] = DB::table($table_facility_id->TABLE_NAME)->where('facility_id', $facility_id)->where('updated_at', '>', $updatedat)->get();
        }

        $facilityuserid = DB::table('facility_user')->where('facility_id', $facility_id)->lists('facilityuser_id');

        //step2 : select all table with facilityuser_id column
        $facility_user = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$_this->curr_db."' AND COLUMN_NAME = 'facilityuser_id' AND TABLE_NAME IN (".$whereInTables.")");

        foreach($facility_user as $table_facilityuser_id) {
            $_this->master_array[$table_facilityuser_id->TABLE_NAME] = DB::table($table_facilityuser_id->TABLE_NAME)->whereIn('facilityuser_id', $facilityuserid)->where('updated_at', '>', $updatedat)->get();
        }

        // get all
        $fpuid_by_fuid = DB::table('facility_patient_user')->whereIn('facilityuser_id', $facilityuserid)->lists('facilitypatientuser_id');
        $pid_by_fuid = DB::table('facility_patient_user')->whereIn('facilityuser_id', $facilityuserid)->lists('patient_id');

        $_this->master_array['healthcare_services'] = DB::table('healthcare_services')->whereIn('facilitypatientuser_id', $fpuid_by_fuid)->where('updated_at', '>', $updatedat)->get();
        $_this->master_array['patients'] = DB::table('patients')->whereIn('patient_id', $pid_by_fuid)->where('updated_at', '>', $updatedat)->get();

        $user_id = DB::table('facility_user')->where('facility_id', $facility_id)->lists('user_id');
        $users = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$_this->curr_db."' AND COLUMN_NAME = 'user_id' AND TABLE_NAME IN (".$whereInTables.")");

        foreach($users as $table_user_id) {
            $_this->master_array[$table_user_id->TABLE_NAME] = DB::table($table_user_id->TABLE_NAME)->whereIn('user_id', $user_id)->where('updated_at', '>', $updatedat)->get();
        }

        $except_from_patients = implode("','", array_keys($_this->master_array));
        $patients = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$_this->curr_db."' AND COLUMN_NAME = 'patient_id' AND TABLE_NAME NOT IN ('".$except_from_patients."') AND TABLE_NAME IN (".$whereInTables.")");

        foreach($patients as $table_patient_id) {
            $_this->master_array[$table_patient_id->TABLE_NAME] = DB::table($table_patient_id->TABLE_NAME)->whereIn('patient_id', $pid_by_fuid)->where('updated_at', '>', $updatedat)->get();
        }

        //get all healthcareservices of the facilitypatientuser_id
        $healthcareservice_id = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$_this->curr_db."' AND COLUMN_NAME = 'healthcareservice_id' AND TABLE_NAME IN (".$whereInTables.")");
        $healthcareservices = DB::table('healthcare_services')->whereIn('facilitypatientuser_id', $fpuid_by_fuid)->lists('healthcareservice_id');


        foreach($healthcareservice_id as $table_healthcareservice_id) {
            $_this->master_array[$table_healthcareservice_id->TABLE_NAME] = DB::table($table_healthcareservice_id->TABLE_NAME)->whereIn('healthcareservice_id', $healthcareservices)->where('updated_at', '>', $updatedat)->get();

            $constraint_type[$table_healthcareservice_id->TABLE_NAME] = DB::select("SELECT DISTINCT COLUMN_NAME from information_schema.KEY_COLUMN_USAGE where TABLE_SCHEMA = '".$_this->curr_db."' AND CONSTRAINT_NAME!='PRIMARY' AND TABLE_NAME = '".$table_healthcareservice_id->TABLE_NAME."' AND TABLE_NAME IN (".$whereInTables.")");
            $except = implode("','", array_keys($_this->master_array));
            if(count($constraint_type[$table_healthcareservice_id->TABLE_NAME])!=NULL) {
                foreach ($constraint_type[$table_healthcareservice_id->TABLE_NAME] as $ct_tbl_key => $ct_tbl_value) {
                    $constraint_type[$table_healthcareservice_id->TABLE_NAME]['COLUMN_NAME_VALUES'] = DB::table($table_healthcareservice_id->TABLE_NAME)->whereIn('healthcareservice_id', $healthcareservices)->lists($ct_tbl_value->COLUMN_NAME);
                    $constraint_type[$table_healthcareservice_id->TABLE_NAME]['COLUMN_CONSTRAINT_LIST'] = DB::select("SELECT DISTINCT TABLE_NAME FROM Information_Schema.Columns WHERE TABLE_SCHEMA = '".$_this->curr_db."' AND COLUMN_NAME = '".$ct_tbl_value->COLUMN_NAME."' AND TABLE_NAME NOT LIKE 'temp_%' AND TABLE_NAME NOT LIKE 'lov_%' AND TABLE_NAME NOT LIKE '%_view' AND TABLE_NAME NOT IN ('".$except."') AND TABLE_NAME != 'tracker'");
                }

                foreach ($constraint_type as $key => $value) {
                    if(count($value)) {
                        if(count($value['COLUMN_CONSTRAINT_LIST'])!=NULL) {
                            foreach ($value['COLUMN_CONSTRAINT_LIST'] as $const_key => $const_value) {

                                $_this->master_array[$const_value->TABLE_NAME] = DB::table($const_value->TABLE_NAME)->whereIn($value[0]->COLUMN_NAME, $value['COLUMN_NAME_VALUES'])->where('updated_at', '>', $updatedat)->get();

                            }
                        }
                    }
                }
            }
        }
        return $_this->master_array;
    }

    // Insert to DB - compare, update and insert
    public static function insert_to_DB($record) {
        if(is_array($record)==TRUE) {
            $arr_obj = $record;
        } else {
            $arr_obj = $record->data;
        }
        $_this = new self;
        $result = FALSE;
        foreach ($arr_obj as $key => $value) {
            if(count($value)) {
                foreach ($value as $key_1 => $value_2) {
                    if(is_array($record)==TRUE) {
                        $toarray = $value_2;
                        $toarray_2 = $value_2;
                    } else {
                        $toarray = get_object_vars($value_2);
                        $toarray_2 = get_object_vars($value_2);
                    }
                    unset($toarray['id']);
                    $constraint[$key] = DB::select("SELECT DISTINCT COLUMN_NAME from information_schema.KEY_COLUMN_USAGE where TABLE_SCHEMA = '".$_this->curr_db."' AND CONSTRAINT_NAME!='PRIMARY' AND TABLE_NAME = '".$key."'");
                    // dd($constraint[$key][0]->COLUMN_NAME);

                    if(!empty($constraint[$key])) {
                        $checker_count = DB::table($key)->where($constraint[$key][0]->COLUMN_NAME, $toarray[$constraint[$key][0]->COLUMN_NAME])->count();
                            if($checker_count == 1) { //update
                                unset($toarray_2['id']);
                                unset($toarray_2[$constraint[$key][0]->COLUMN_NAME]);

                                $result[$key][$key_1] = DB::table($key)->where($constraint[$key][0]->COLUMN_NAME, $toarray[$constraint[$key][0]->COLUMN_NAME])->update($toarray_2);
                                // dd($result);
                            } else { //insert
                                $result[$key][$key_1] = DB::table($key)->insert($toarray);
                                // dd($result);
                            }
                    }

                }
            }
        }
        return $result;
    }
}


