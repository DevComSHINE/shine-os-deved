<?php namespace ShineOS\Core\Patients\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ShineOS\Core\Patients\Entities\Patients;
use Shine\Libraries\IdGenerator;

use ShineOS\Core\Patients\Entities\MedicalHistoryModel;
use Input;

class LovHistoryModel extends Model {

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lov_diseases';
    protected static $table_name = 'lov_diseases';
    protected $primaryKey = 'disease_id';

    protected $fillable = [];

    /**
     * Get all form fields from LOV Medical History
     * to prepare form UI for Medical History
     * @return array Array of sections and fields
     */
    public static function getAllDiseases()
    {
        $data = array();
        $data['patient_medicalhistory'] = self::getDiseaseSetByCategory('Medical History');
        $data['patient_surgicalhistory'] = self::getDiseaseSetByCategory('Surgical History');
        $data['patient_familymedicalhistory'] = self::getDiseaseSetByCategory('Family Medical History');
        $data['patient_personalhistory'] = self::getDiseaseSetByCategory('Personal/Social History');
        $data['patient_menstrualhistory'] = self::getDiseaseSetByCategory('Menstrual History');
        $data['patient_pregnancyimmunizationhistory'] = self::getDiseaseSetByCategory('Immunization History for Pregnancy');
        $data['patient_childimmunizationhistory'] = self::getDiseaseSetByCategory('Immunization History for Children');
        $data['patient_womenimmunizationhistory'] = self::getDiseaseSetByCategory('Immunization History for Young Women');
        $data['patient_elderlyimmunizationhistory'] = self::getDiseaseSetByCategory('Immunization History for Elderly');
        $data['patient_pregnancyhistory'] = self::getDiseaseSetByCategory('Pregnancy History');
        $data['patient_fpcounseling'] = self::getDiseaseSetByCategory('Family Planning Counseling');
        $data['patient_medicineintake'] = self::getDiseaseSetByCategory('Drugs & Medicine Intake');
        return $data;
    }

    /**
     * Get the required fields of a History category based on category name
     * @param  string [$category = ''] Name of category
     * @return array  Array object of fields for particular category
     */
    public static function getDiseaseSetByCategory( $category = '' )
    {
        return self::where('disease_category', $category)
            ->get();
    }

    public static function getDiseaseCodeByID( $ID )
    {
        $disease = self::where('disease_id', $ID)
            ->first();
        return $disease->disease_code;
    }

    public static function savePatientDiseases( $patient_id = 0 )
    {
        $allDiseases = self::getAllDiseases(); //Input::get('disease');
        $diseases = Input::get('disease');

        foreach($allDiseases as $allDiseaseA) {

            foreach($allDiseaseA as $x => $alldisease) {

                //if there is a record for this disease for the patient
                $currentDisease = MedicalHistoryModel::where('patient_id', '=', $patient_id)
                        ->where('disease_id', '=', $alldisease->disease_id)
                        ->first();

                //make sure only posted data is added or deleted
                if(isset($diseases[$alldisease->disease_category][$alldisease->disease_id])){

                    $id = $alldisease->disease_id;
                    $sagot = $diseases[$alldisease->disease_category][$alldisease->disease_id];
                    // there's an existing record and needs updating
                    if ( $currentDisease && count($currentDisease) > 0) {
                        if($sagot != "" OR $sagot != "No") {
                            MedicalHistoryModel::where('patient_id', '=', $patient_id)
                        ->where('disease_id', '=', $alldisease->disease_id)
                        ->update(array('disease_status'=>$sagot));

                        } else { //else delete the entry
                            $currentDisease->where('patient_id', '=', $patient_id)->where('disease_id', '=', $alldisease->disease_id)->forceDelete();
                        }
                    //no existing data and we need to create it
                    } else {

                        if($sagot != "" OR $sagot != "No"){
                            $query = new MedicalHistoryModel;

                            if($id == 'narrative')
                            {
                                $query->disease_code = 'Narrative';
                            } else {
                                $query->disease_code = $alldisease->disease_code;
                            }
                            $query->disease_status = $sagot;
                            $query->patient_medicalhistory_id = IdGenerator::generateId();
                            $query->patient_id = $patient_id;
                            $query->disease_id = $alldisease->disease_id;

                            $query->save();
                        }
                    }
                } else {

                    //there is data but is not posted, we delete the data
                    if ( $currentDisease && count($currentDisease) > 0) {
                        $currentDisease->where('patient_id', '=', $patient_id)->where('disease_id', '=', $alldisease->disease_id)->forceDelete();
                    }
                }
            }
        }
    }

    private static function print_this( $object = array(), $title = '' ) {
        echo "<hr><h2>{$title}</h2><pre>";
        print_r($object);
        echo "</pre>";
    }
}

?>
