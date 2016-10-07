<?php namespace ShineOS\Core\Healthcareservices\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\MedicalOrder; //model
use ShineOS\Core\Healthcareservices\Entities\MedicalOrderPrescription; //model
use ShineOS\Core\Healthcareservices\Entities\MedicalOrderLabExam; //model
use ShineOS\Core\Healthcareservices\Entities\MedicalOrderProcedure; //model
use ShineOS\Core\Healthcareservices\Http\Requests\MedicalOrderFormRequest;
use Shine\Repositories\Eloquent\HealthcareRepository as HealthcareRepository;
use ShineOS\Core\LOV\Entities\LovLaboratories;
use Shine\Libraries\IdGenerator;
use Shine\Libraries\Utils\Lovs;

use ShineOS\Core\Patients\Models\Patients;
use View, Response, Validator, Input, Mail, Session, Redirect,
    Hash,
    Auth,
    DB,
    Datetime,
    Request;

class MedicalOrderController extends Controller {

    protected $facility_name = "samplefacility name";
    protected $unique_id = "";
    protected $current_timestamp;

    protected $default_tbl = "medicalorder";
    protected $tbl_prescription = "medicalorder_prescription";
    protected $tbl_laboratory = "medicalorder_laboratoryexam";
    protected $tbl_procedure = "medicalorder_procedure";

    protected $txt_hservices_id;

    private $txt_action;
    private $params;

    public function __construct(HealthcareRepository $healthcareRepository) {
        /** User Session or Authenticaion  */
        $this->middleware('auth');

        $this->HealthcareRepository = $healthcareRepository;

        $date = new Datetime('now');
        $this->current_timestamp = strtotime($date->format('His'));
        $this->unique_id =  IdGenerator::generateId();
        $this->txt_hservices_id = Input::has('hservices_id') ? Input::get('hservices_id')  : false;

        View::addNamespace('healthcareservices', 'src/ShineOS/Core/Healthcareservices/Resources/Views');
    }

    public function UpdateCreate(MedicalOrderFormRequest $request) {
        $input = Request::all();

        if (array_key_exists('insert', $input)) {

            foreach ($input['insert']['type'] as $key => $value) {
                if( $value != 'MO_NONE' ) {

                    if( isset($input['insert']['medicalorder_id'][$key]) AND ($input['insert']['medicalorder_id'][$key] != NULL AND $input['insert']['medicalorder_id'][$key] != "undefined")  ){
                        $medorderID = $input['insert']['medicalorder_id'][$key];

                    } else {

                        $med_query = new MedicalOrder;
                        $med_query->medicalorder_id = $medorderID = $this->unique_id.$key;
                        $med_query->healthcareservice_id = $this->txt_hservices_id;
                        $med_query->medicalorder_type = $value;
                    }

                    if($value == 'MO_MED_PRESCRIPTION') {
                        $pres_query = new MedicalOrderPrescription;
                        $pres_query->medicalorderprescription_id = IdGenerator::generateId().$key;
                        $pres_query->medicalorder_id = $medorderID;
                        $pres_query->generic_name = $input['insert'][$value]['Drug_Code'][$key];
                        $pres_query->brand_name = $input['insert'][$value]['Drug_Brand_Name'][$key];
                        $pres_query->dose_quantity = $input['insert'][$value]['Dose_Qty'][$key].' '.$input['insert'][$value]['Dose_UOM'][$key];
                        $pres_query->total_quantity = $input['insert'][$value]['Total_Quantity'][$key].' '.$input['insert'][$value]['Total_Quantity_UOM'][$key];
                        $pres_query->dosage_regimen = $input['insert'][$value]['dosage'][$key];
                        $pres_query->dosage_regimen_others = $input['insert'][$value]['Specify'][$key];
                        $pres_query->duration_of_intake = $input['insert'][$value]['Duration_Intake'][$key].' '.$input['insert'][$value]['Duration_Intake_Freq'][$key];

                        $regimen_startend_date = explode(" - ", $input['insert'][$value]['regimen_startend_date'][$key]);
                        $start_date = new Datetime($regimen_startend_date[0]);
                        $pres_query->regimen_startdate = $start_date;

                        if(isset($regimen_startend_date[1])) {
                            $end_date = new Datetime($regimen_startend_date[1]);
                            $pres_query->regimen_enddate = $end_date;
                        }

                        $pres_query->dosage_regimen_others = $input['insert'][$value]['Specify'][$key];
                        $pres_query->prescription_remarks = $input['insert'][$value]['Remarks'][$key];

                        if(isset($med_query) AND $med_query->medicalorder_type = "MO_MED_PRESCRIPTION") {
                            if(isset($input['insert']['prescription_instructions'][$key])){
                                $med_query->user_instructions = $input['insert']['prescription_instructions'][$key];
                            }
                            $MedicalOrder_insert = $med_query->save();
                        }
                        if(isset($input['update']['prescription_instructions'][$key])):
                            $med_query_u['user_instructions'] = $input['update']['prescription_instructions'][$key];
                            if($med_query_u['user_instructions']):
                                $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $medorderID)->update($med_query_u);
                            endif;
                        endif;

                        $pres_query->save();

                    }
                    else if($value == 'MO_LAB_TEST') {

                        if(isset($input['insert'][$value]['Examination_Code'])) {
                            $Examination_Code = $input['insert'][$value]['Examination_Code'];

                            foreach ($Examination_Code as $keyExamination_Code => $valueExamination_Code) {
                                $lab_query = new MedicalOrderLabExam;
                                $lab_query->medicalorderlaboratoryexam_id = IdGenerator::generateId().$keyExamination_Code;
                                $lab_query->medicalorder_id = $medorderID;
                                $lab_query->laboratory_test_type = $valueExamination_Code;
                                if(isset($input['insert'][$value]['others'][$key])){
                                    $lab_query->laboratory_test_type_others = $input['insert'][$value]['others'][$key];
                                }
                                if(isset($med_query) AND $med_query->medicalorder_type = "MO_LAB_TEST") {
                                    if(isset($input['insert']['laboratory_instructions'][$key])){
                                        $med_query->user_instructions = $input['insert']['laboratory_instructions'][$key];
                                    }
                                    $MedicalOrder_insert = $med_query->save();
                                }
                                if(isset($input['update']['laboratory_instructions'][$key])):
                                    $med_query_u['user_instructions'] = $input['update']['laboratory_instructions'][$key];
                                    if($med_query_u['user_instructions']):
                                        $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $medorderID)->update($med_query_u);
                                    endif;
                                endif;
                                $lab_query->save();
                            }
                        }
                    }
                    else if($value == 'MO_PROCEDURE') {

                        foreach($input['insert'][$value]['medicalorderprocedure_id'] as $pkey => $procedure) {

                            $prod_query = new MedicalOrderProcedure;
                            $prod_query->medicalorderprocedure_id = IdGenerator::generateId().$key;
                            $prod_query->medicalorder_id = $medorderID;
                            $prod_query->procedure_order = $input['insert'][$value]['Procedure_Order'][$pkey];
                            $prod_query->procedure_date = new Datetime($input['insert'][$value]['Date_of_Procedure'][$pkey]);
                            $prod_query->procedure_instructions = $input['insert'][$value]['Procedure_Remarks'][$pkey];
                            $prod_query->save();

                            if(isset($med_query) AND $med_query->medicalorder_type = "MO_PROCEDURE") {
                                if(isset($input['insert']['procedure_user_instructions'][$key])) {
                                    $med_query->user_instructions = $input['insert']['procedure_user_instructions'][$key];
                                }
                                $MedicalOrder_insert = $med_query->save();
                            }
                            if(isset($input['update']['procedure_user_instructions'][$key])):
                                $med_query_u['user_instructions'] = $input['update']['procedure_user_instructions'][$key];
                                if($med_query_u['user_instructions']):
                                    $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $medorderID)->update($med_query_u);
                                endif;
                            endif;
                        }

                    }
                    else if($value == 'MO_OTHERS') {

                        if(!empty($input['insert'][$value]['order_type_others'])) {
                            foreach($input['insert'][$value]['order_type_others'] as $okey => $others) {
                                if($others){
                                    if(isset($input['insert'][$value]['order_type_others'][$okey])) {
                                        $med_query->medicalorder_others = $input['insert'][$value]['order_type_others'][$okey];
                                    }
                                    if(isset($med_query) AND $med_query->medicalorder_type = "MO_OTHERS") {
                                        if(isset($input['insert']['other_instructions'][$okey])) {
                                            $med_query->user_instructions = $input['insert']['other_instructions'][$okey];
                                        }
                                    $MedicalOrder_insert = $med_query->save();
                                    }
                                    if(isset($input['update']['other_instructions'][$okey])):
                                        $med_query_u['user_instructions'] = $input['update']['other_instructions'][$okey];
                                        if($med_query_u['user_instructions']):
                                            $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $medorderID)->update($med_query_u);
                                        endif;
                                    endif;
                                }
                            }
                        }
                    }
                    else {

                    }
                } else {
                    $MedicalOrder_insert = FALSE;
                }
            }
        }

        if (array_key_exists('update', $input)) {

            foreach ($input['update']['type'] as $key => $value) {
                if( $value != 'MO_NONE' ) {



                    if($value == 'MO_MED_PRESCRIPTION') {

                        $pres_query_u['generic_name'] = $input['update'][$value]['Drug_Code'][$key];
                        $pres_query_u['brand_name'] = $input['update'][$value]['Drug_Brand_Name'][$key];
                        $pres_query_u['dose_quantity'] = $input['update'][$value]['Dose_Qty'][$key].' '.$input['update'][$value]['Dose_UOM'][$key];
                        $pres_query_u['total_quantity'] = $input['update'][$value]['Total_Quantity'][$key].' '.$input['update'][$value]['Total_Quantity_UOM'][$key];
                        $pres_query_u['dosage_regimen'] = $input['update'][$value]['dosage'][$key];
                        $pres_query_u['dosage_regimen_others'] = isset($input['update'][$value]['Specify'][$key]) ? $input['update'][$value]['Specify'][$key] : NULL;
                        $pres_query_u['duration_of_intake'] = $input['update'][$value]['Duration_Intake'][$key].' '.$input['update'][$value]['Duration_Intake_Freq'][$key];

                        $regimen_startend_date  = explode(" - ", $input['update'][$value]['regimen_startend_date'][$key]);
                        $start_date  =  new Datetime($regimen_startend_date[0]);
                        $end_date  = new Datetime($regimen_startend_date[1]);

                        $pres_query_u['regimen_startdate'] = $start_date;
                        $pres_query_u['regimen_enddate'] = $end_date;

                        $pres_query_u['prescription_remarks'] = $input['update'][$value]['Remarks'][$key];

                        $pres_query_u_update = MedicalOrderPrescription::where('medicalorderprescription_id', $input['update'][$value]['medicalorderprescription_id'][$key])->update($pres_query_u);

                        $med_query_u['user_instructions'] = isset($input['update']['prescription_instructions'][$key]) ? $input['update']['prescription_instructions'][$key] : NULL;

                        $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($med_query_u);
                    }
                    else if($value == 'MO_LAB_TEST') {
                        //reset all lab exams by force deleting all so that unchecked items will be removed
                        $deleteAllExam = MedicalOrderLabExam::where('medicalorder_id',$input['update']['medicalorder_id'][$key])->forceDelete();
                        if(isset($input['update'][$value]['Examination_Code'])){
                            $Examination_Code = $input['update'][$value]['Examination_Code']; //dd($key, $Examination_Code, $input['update']);
                            foreach ($Examination_Code as $key_u_e_code => $value_u_e_code) {
                                    $lab_query = new MedicalOrderLabExam;
                                    $lab_query->medicalorderlaboratoryexam_id = IdGenerator::generateId().$key;
                                    $lab_query->medicalorder_id = $input['update']['medicalorder_id'][$key];
                                    $lab_query->laboratory_test_type = $value_u_e_code;
                                    $lab_query->laboratory_test_type_others = isset($input['update'][$value]['others'][$key_u_e_code]) ? $input['update'][$value]['others'][$key_u_e_code] : NULL;
                                    $lab_query->save();
                            }
                        } else {
                            //there is no checked lab
                            //delete this medical order ID
                            $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->forceDelete();
                        }
                        $med_query_u['user_instructions'] = isset($input['update']['laboratory_instructions'][$key]) ? $input['update']['laboratory_instructions'][$key] : NULL;

                        $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($med_query_u);

                    }
                    else if($value == 'MO_PROCEDURE') {
                        foreach($input['update'][$value]['Procedure_Order'] as $key => $v){
                            $prod_query_u['procedure_order'] = $input['update'][$value]['Procedure_Order'][$key];
                            $prod_query_u['procedure_date'] =  new Datetime($input['update'][$value]['Date_of_Procedure'][$key]);
                            $prod_query_u['procedure_instructions'] =  $input['update'][$value]['Procedure_Remarks'][$key];

                            $prod_query_u_update = MedicalOrderProcedure::where('medicalorderprocedure_id', $input['update'][$value]['medicalorderprocedure_id'][$key])->update($prod_query_u);
                        }
                        $med_query_u['user_instructions'] = isset($input['update']['procedure_user_instructions'][$key]) ? $input['update']['procedure_user_instructions'][$key] : NULL;

                        $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($med_query_u);


                    }
                    else if($value == 'MO_OTHERS') {

                        $other_query_u['medicalorder_others'] = isset($input['update'][$value]['order_type_others'][$key]) ? $input['update'][$value]['order_type_others'][$key] : NULL;

                        $med_query_u['user_instructions'] = isset($input['update']['other_instructions'][$key]) ? $input['update']['other_instructions'][$key] : NULL;

                        //if others entry to empty - delete medical order others
                        if($other_query_u['medicalorder_others'] == "") {
                            MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->forceDelete();
                        //else update the entry
                        } else {
                            $other_query_u_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($other_query_u);
                            $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($med_query_u);
                        }


                    }
                    else {

                    }

                }
            }
        }

        if (array_key_exists('delete', $input)) {

            foreach ($input['delete']['type'] as $key => $value) {

                if($value == 'MO_MED_PRESCRIPTION') {
                       $prescripDelete = MedicalOrderPrescription::where('medicalorderprescription_id', $input['delete'][$value]['medicalorderprescription_id'][$key])->delete();

                        if(isset($input['delete'][$value]['medicalorder_id'][$key])) {
                            $medprescDelete = MedicalOrder::where('medicalorder_id', $input['delete'][$value]['medicalorder_id'][$key])->forceDelete();
                        }
                }
                if($value == 'MO_PROCEDURE') {
                    //delete the item for deletion
                    $procDelete = MedicalOrderProcedure::where('medicalorderprocedure_id', $input['delete'][$value]['medicalorderprocedure_id'][$key])->forceDelete();

                    //check if there still orders here
                    $mayronpa = 0;
                    $mayprodcedurespa = MedicalOrder::where('healthcareservice_id', $input['hservices_id'])->get();

                    foreach($mayprodcedurespa as $proc){
                        $proced = MedicalOrderProcedure::where('medicalorder_id', $proc->medicalorder_id)->get();
                        if(empty($proced)) {
                            $mayronpa++;
                        }
                    }

                    //if the order is empty, delete medicalorder item
                    if($mayronpa == 0){
                        $procDelete = MedicalOrder::where('healthcareservice_id', $input['hservices_id'])->forceDelete();
                    }
                    //if the whole order form is deleted, delete medicalorder item
                    if(isset($input['delete'][$value]['medicalorder_id'][$key])) {
                        $procDelete = MedicalOrder::where('medicalorder_id', $input['delete'][$value]['medicalorder_id'][$key])->forceDelete();
                    }
                }
            }
        }

        $flash_message = 'Well done with your medical order!';
        $flash_type = 'alert-success alert-dismissible';

        return Redirect::back()->with('flash_message', $flash_message)
                                ->with('flash_type', $flash_type)
                                    ->with('flash_tab', 'medicalorders');

    }

    public function printLaboratory($hservice_id)
    {
        $data['consultation'] = $consultation = findHealthRecordByServiceID($hservice_id);

        $data['order'] = $medicalorder_record = getMedicalOrdersByHealthServiceID($hservice_id);

        foreach($medicalorder_record as $order)
        {
            if($order->medical_order_lab_exam) {
                $data['labs'] = $glabs = $order->medical_order_lab_exam;
                $data['instructions'] = $order->user_instructions;
            }
        }

        $data['consultation_id'] = $hservice_id;
        $phic = "NP";

        //get provider
        $data['provider'] = $provider = getFacilityByFacilityUserID($consultation->facilityuser_id);
        $data['user'] = $doctor = getUserDetailsByUserID($provider->facility_user->user_id);

        //get patient data
        $data['patient'] = $patient = getCompletePatientByPatientID($consultation->patient_id);

        //get patient phic data
        $data['phic'] = $patphic = NULL;

        //diagnosis
        $diagnosis = getDiagnosisDetailsByHealthServiceID($hservice_id);

        $data['lovlaboratories'] = LovLaboratories::orderBy('laboratorydescription')->get();

        //generate patient data for QRCode
        $pat['id'] = $patient->id;
        $pat['firstname'] = $patient->firstname;
        $pat['lastname'] = $patient->lastname;
        if(isset($patphic->MEMID_NO)) $patient->MEMID_NO = $phic = $patphic->MEMID_NO;
        $pat['barangay'] = $patient->barangay;
        $pat['city'] = $patient->city;
        $pat['province'] = $patient->province;
        $pat['sex'] = $patient->sex;
        $pat['birthdate'] = $patient->birthdate;
        $data['patqrcode'] = json_encode($pat);

        return view('healthcareservices::laboratory')->with($data);
    }

    public function printPrescription($hservice_id)
    {
        $data['consultation'] = $consultation = findHealthRecordByServiceID($hservice_id);

        $medicalorder_record = getMedicalOrdersByHealthServiceID($hservice_id);

        $k = 0;
        foreach($medicalorder_record as $order)
        {
            if($order->medical_order_prescription) {
                foreach($order->medical_order_prescription as $prescription) {
                    $data['drugs'][$k] = $qdrugs[$k] = $prescription;
                    $k++;
                }
            }
        }


        $data['consultation_id'] = $hservice_id;

        //get provider
        $data['provider'] = $provider = getFacilityByFacilityUserID($consultation->facilityuser_id);
        $data['user'] = $doctor = getUserDetailsByUserID($provider->facility_user->user_id);

        $phic = "NP";

        //get patient data
        $data['patient'] = $patient = getCompletePatientByPatientID($consultation->patient_id);

        //get patient phic data
        $data['phic'] = $patphic = NULL;

        //diagnosis
        $diagnosis = getDiagnosisDetailsByHealthServiceID($hservice_id);

        //generate patient data for QRCode
        $pat['id'] = $patient->id;
        $pat['firstname'] = $patient->firstname;
        $pat['lastname'] = $patient->lastname;
        if(isset($patphic->MEMID_NO)) $patient->MEMID_NO = $phic = $patphic->MEMID_NO;
        $pat['barangay'] = $patient->barangay;
        $pat['city'] = $patient->city;
        $pat['province'] = $patient->province;
        $pat['sex'] = $patient->sex;
        $pat['birthdate'] = $patient->birthdate;
        $data['patqrcode'] = json_encode($pat);

        //count all prescribed drugs
        $drugcount = count($qdrugs);

        //count number of drugs
        $dcount = count($drugcount)/5;
        $data['pages'] = ceil($dcount); //divide drugs into 3 each page

        $age = getAge($patient->birthdate);

        //setup MedRX data
        $totaldrugnum = count($qdrugs);
        $qcnt = 1;


        /*$medrx = '
        {
            "PhilhealthNumber": "'.$phic.'",
            "PatientFirstName": "'.$patient->firstname.'",
            "PatientLastName": "'.$patient->lastname.'",
            "PatientAge": "'.$age.'",
            "PatientSex": "'.$patient->sex.'",
            "PatientAddress": "'.$patient->barangay.', '.$patient->city.', '.$patient->province.'",
            "PatientBirthDate": "'.$patient->birthdate.'",
            "PatientContactNumber": "'.trim($patient->telephone,',').'",
            "DrugstoreId": "2",
            "DrugstoreName": "Generics Pharmacy",
            "HealthUnitId": "'.$patient->created_provider_account_id.'",
            "HealthUnitName": "'.$provider->facility_name.'",
            "HealthUnitAddress": "'.$provider->facility_contact->barangay.', '.$provider->facility_contact->city.', '.$provider->facility_contact->province.'",
            "DoctorId": "'.$doctor ? $doctor->user_id : NULL.'",
            "DoctorName": "Dr. '.$doctor ? ($doctor->first_name.' '.$doctor->last_name) : NULL. '",
            "PrescriptionList": [';

            foreach($qdrugs as $drug){
                $dcode = $freq = NULL;
                switch($drug->dosage_regimen)
                {
                    case 'OD': $regimen = 'Once a day'; break;
                    case 'BID': $regimen = '2 x a day - Every 12 hours'; break;
                    case 'TID': $regimen = '3 x a day - Every 8 hours'; break;
                    case 'QID': $regimen = '4 x a day - Every 6 hours'; break;
                    case 'QOD': $regimen = 'Every other day'; break;
                    case 'QHS': $regimen = 'Every bedtime'; break;
                    case 'OTH': $regimen = 'Others'; break;
                    default: $regimen = 'Not given';
                }
                $intake = explode(" ",$drug->duration_of_intake);

                if(isset($intake[1])){
                    switch($intake[1])
                    {
                        case 'D': $freq = 'Days'; break;
                        case 'W': $freq = 'Weeks'; break;
                        case 'M': $freq = 'Months'; break;
                        case 'Q': $freq = 'Quarters'; break;
                        case 'Y': $freq = 'Years'; break;
                        case 'O': $freq = 'Others'; break;
                        default: $freq = 'Not given';
                    }
                    //let us get the drug_code
                    $dcode = Lovs::getValueOfFieldBy('drugs', 'drug_specification', 'product_id', NULL);
                }

                if($dcode) {
                    $drugcode = $dcode->hprodid;
                } else {
                    $drugcode = $drug->generic_name;
                }
                if(isset($intake[0])) {
                    $drugin = $intake[0];
                } else {
                    $drugin = "none";
                }
                $dosage = explode(" ",$drug->dose_quantity);
                $total = explode(" ",$drug->total_quantity);
                $illness = isset($diagnosis->diagnosislist_id) ? $diagnosis->diagnosislist_id : "Not specified";
                $medrx .= '{
                    "illnessId": "15",
                    "illnessName": "'.$illness.'",
                    "medicineid": "'.$drugcode.'",
                    "medicineName": "'.$drugcode.'",
                    "brandname": "'.$drug->brand_name.'",
                    "doseqty": "'.$dosage[0].'",
                    "doseuom": "'.$dosage[1].'",
                    "totalquantity": "'.$total[0].'",
                    "totalquantityuom": "'.$total[1].'",
                    "dosageregimen": "'.$regimen.'",
                    "intakefrequency": "'.$drugin.'",
                    "intakefrequnceyuom": "'.$freq.'",
                    "regimenstartdate": "'.$drug->regimen_startdate.'",
                    "regimenenddate": "'.$drug->regimen_enddate.'",
                    "remarks": "'.$drug->prescription_remarks.'"
                }';
                if($qcnt < count($qdrugs)){
                    $medrx .= ',';
                }
                $qcnt++;
            }

            $medrx .= ']
        }';

        $data['medrx'] = $medrx;*/

        for($page = 1; $page <= ceil($dcount); $page++) {

            $dc = 0;
            foreach($qdrugs as $q => $drug){
                $dcode = $freq = NULL;
                if($q >= $dc AND $q <= $totaldrugnum){
                    $qrdata[$page][$dc] = '{
                        "PatientId": "'.$patient->id.'",
                        "DrugstoreId": "1",
                        "HealthUnitId": "1",
                        "PrescriptionList": [';

                        switch($drug->dosage_regimen)
                        {
                            case 'OD': $regimen = 'Once a day'; break;
                            case 'BID': $regimen = '2 x a day - Every 12 hours'; break;
                            case 'TID': $regimen = '3 x a day - Every 8 hours'; break;
                            case 'QID': $regimen = '4 x a day - Every 6 hours'; break;
                            case 'QOD': $regimen = 'Every other day'; break;
                            case 'QHS': $regimen = 'Every bedtime'; break;
                            case 'OTH': $regimen = 'Others'; break;
                            default: $regimen = 'Not given';
                        }
                        $intake = explode(" ",$drug->duration_of_intake);

                        if(isset($intake[1])){
                        switch($intake[1])
                        {
                            case 'D': $freq = 'Days'; break;
                            case 'W': $freq = 'Weeks'; break;
                            case 'M': $freq = 'Months'; break;
                            case 'Q': $freq = 'Quarters'; break;
                            case 'Y': $freq = 'Years'; break;
                            case 'O': $freq = 'Others'; break;
                            default: $freq = 'Not given';
                        }
                        //let us get the drug_code
                        $dcode = Lovs::getValueOfFieldBy('drugs', 'drug_specification', 'product_id', NULL);
                        }

                        if($dcode) {
                            $drugcode = $dcode->hprodid;
                        } else {
                            $drugcode = $drug->generic_name;
                        }
                        if(isset($intake[0])) {
                            $drugin = $intake[0];
                        } else {
                            $drugin = "none";
                        }
                        $dosage = explode(" ",$drug->dose_quantity);
                        $total = explode(" ",$drug->total_quantity);
                        $tq = $total[0];
                        if(isset($total[1])) {
                            $tq .= "|".$total[1];
                        }
                        $qrdata[$page][$dc] .= '{
                            "genericnameid": "'.$drug->generic_name.'",
                            "brandname": "'.$drug->brand_name.'",
                            "doseqty": "'.$dosage[0].' '.$dosage[1].'",
                            "totalquantity": "'.$tq.'",
                            "dosageregimen": "'.$regimen.'",
                            "intakefrequency": "'.$intake[0].'|'.$freq.'",
                            "regimenstartdate": "'.$drug->regimen_startdate.'|'.$drug->regimen_enddate.'",
                            "remarks": "'.$drug->prescription_remarks.'"
                        },';

                        $qrdata[$page][$dc] .= ']
                    }';
                }
                $dc++;
            }
        }

        return view('healthcareservices::prescription', compact('qrdata'))->with($data);
    }

    public function save($data)
    {
        $input = $data;

        if ($input AND array_key_exists('insert', $input)) {

            foreach ($input['insert']['type'] as $key => $value) {
                if( $value != 'MO_NONE' ) {

                    if( isset($input['insert']['medicalorder_id'][$key]) AND ($input['insert']['medicalorder_id'][$key] != NULL AND $input['insert']['medicalorder_id'][$key] != "undefined")  ){
                        $medorderID = $input['insert']['medicalorder_id'][$key];

                    } else {

                        $med_query = new MedicalOrder;
                        $med_query->medicalorder_id = $medorderID = $this->unique_id.$key;
                        $med_query->healthcareservice_id = $this->txt_hservices_id;
                        $med_query->medicalorder_type = $value;
                    }

                    if($value == 'MO_MED_PRESCRIPTION') {
                        $pres_query = new MedicalOrderPrescription;
                        $pres_query->medicalorderprescription_id = IdGenerator::generateId().$key;
                        $pres_query->medicalorder_id = $medorderID;
                        $pres_query->generic_name = $input['insert'][$value]['Drug_Code'][$key];
                        $pres_query->brand_name = $input['insert'][$value]['Drug_Brand_Name'][$key];
                        $pres_query->dose_quantity = $input['insert'][$value]['Dose_Qty'][$key].' '.$input['insert'][$value]['Dose_UOM'][$key];
                        $pres_query->total_quantity = $input['insert'][$value]['Total_Quantity'][$key].' '.$input['insert'][$value]['Total_Quantity_UOM'][$key];
                        $pres_query->dosage_regimen = $input['insert'][$value]['dosage'][$key];
                        $pres_query->dosage_regimen_others = $input['insert'][$value]['Specify'][$key];
                        $pres_query->duration_of_intake = $input['insert'][$value]['Duration_Intake'][$key].' '.$input['insert'][$value]['Duration_Intake_Freq'][$key];

                            $regimen_startend_date = explode(" - ", $input['insert'][$value]['regimen_startend_date'][$key]);
                            $start_date = new Datetime($regimen_startend_date[0]);
                            if(isset($regimen_startend_date[1])) {
                                $end_date = new Datetime($regimen_startend_date[1]);
                                $pres_query->regimen_enddate = $end_date;
                            }

                        $pres_query->regimen_startdate = $start_date;

                        $pres_query->dosage_regimen_others = $input['insert'][$value]['Specify'][$key];
                        $pres_query->prescription_remarks = $input['insert'][$value]['Remarks'][$key];

                        if(isset($med_query) AND $med_query->medicalorder_type = "MO_MED_PRESCRIPTION") {
                            if(isset($input['insert']['prescription_instructions'][$key])){
                                $med_query->user_instructions = $input['insert']['prescription_instructions'][$key];
                            }
                            $MedicalOrder_insert = $med_query->save();
                        }
                        if(isset($input['update']['prescription_instructions'][$key])):
                            $med_query_u['user_instructions'] = $input['update']['prescription_instructions'][$key];
                            if($med_query_u['user_instructions']):
                                $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $medorderID)->update($med_query_u);
                            endif;
                        endif;

                        $pres_query->save();

                    }
                    else if($value == 'MO_LAB_TEST') {

                        if(isset($input['insert'][$value]['Examination_Code'])) {
                            $Examination_Code = $input['insert'][$value]['Examination_Code'];

                            foreach ($Examination_Code as $keyExamination_Code => $valueExamination_Code) {
                                $lab_query = new MedicalOrderLabExam;
                                $lab_query->medicalorderlaboratoryexam_id = IdGenerator::generateId().$keyExamination_Code;
                                $lab_query->medicalorder_id = $medorderID;
                                $lab_query->laboratory_test_type = $valueExamination_Code;
                                if(isset($input['insert'][$value]['others'][$key])){
                                    $lab_query->laboratory_test_type_others = $input['insert'][$value]['others'][$key];
                                }
                                if(isset($med_query) AND $med_query->medicalorder_type = "MO_LAB_TEST") {
                                    if(isset($input['insert']['laboratory_instructions'][$key])){
                                        $med_query->user_instructions = $input['insert']['laboratory_instructions'][$key];
                                    }
                                    $MedicalOrder_insert = $med_query->save();
                                }
                                if(isset($input['update']['laboratory_instructions'][$key])):
                                    $med_query_u['user_instructions'] = $input['update']['laboratory_instructions'][$key];
                                    if($med_query_u['user_instructions']):
                                        $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $medorderID)->update($med_query_u);
                                    endif;
                                endif;
                                $lab_query->save();
                            }
                        }
                    }
                    else if($value == 'MO_PROCEDURE') {

                        foreach($input['insert'][$value]['medicalorderprocedure_id'] as $pkey => $procedure) {

                            $prod_query = new MedicalOrderProcedure;
                            $prod_query->medicalorderprocedure_id = IdGenerator::generateId().$key;
                            $prod_query->medicalorder_id = $medorderID;
                            $prod_query->procedure_order = $input['insert'][$value]['Procedure_Order'][$pkey];
                            $prod_query->procedure_date = new Datetime($input['insert'][$value]['Date_of_Procedure'][$pkey]);
                            $prod_query->procedure_instructions = $input['insert'][$value]['Procedure_Remarks'][$pkey];
                            $prod_query->save();

                            if(isset($med_query) AND $med_query->medicalorder_type = "MO_PROCEDURE") {
                                if(isset($input['insert']['procedure_user_instructions'][$key])) {
                                    $med_query->user_instructions = $input['insert']['procedure_user_instructions'][$key];
                                }
                                $MedicalOrder_insert = $med_query->save();
                            }
                            if(isset($input['update']['procedure_user_instructions'][$key])):
                                $med_query_u['user_instructions'] = $input['update']['procedure_user_instructions'][$key];
                                if($med_query_u['user_instructions']):
                                    $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $medorderID)->update($med_query_u);
                                endif;
                            endif;
                        }

                    }
                    else if($value == 'MO_OTHERS') {

                        if(!empty($input['insert'][$value]['order_type_others'])) {
                            foreach($input['insert'][$value]['order_type_others'] as $okey => $others) {
                                if($others){
                                    if(isset($input['insert'][$value]['order_type_others'][$okey])) {
                                        $med_query->medicalorder_others = $input['insert'][$value]['order_type_others'][$okey];
                                    }
                                    if(isset($med_query) AND $med_query->medicalorder_type = "MO_OTHERS") {
                                        if(isset($input['insert']['other_instructions'][$okey])) {
                                            $med_query->user_instructions = $input['insert']['other_instructions'][$okey];
                                        }
                                    $MedicalOrder_insert = $med_query->save();
                                    }
                                    if(isset($input['update']['other_instructions'][$okey])):
                                        $med_query_u['user_instructions'] = $input['update']['other_instructions'][$okey];
                                        if($med_query_u['user_instructions']):
                                            $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $medorderID)->update($med_query_u);
                                        endif;
                                    endif;
                                }
                            }
                        }
                    }
                    else {

                    }
                } else {
                    $MedicalOrder_insert = FALSE;
                }
            }
        }

        if ($input AND array_key_exists('update', $input)) {
            if(isset($input['update']['type'])){
            foreach ($input['update']['type'] as $key => $value) {
                if( $value != 'MO_NONE' ) {
                    if($value == 'MO_MED_PRESCRIPTION') {

                        $pres_query_u['generic_name'] = $input['update'][$value]['Drug_Code'][$key];
                        $pres_query_u['brand_name'] = $input['update'][$value]['Drug_Brand_Name'][$key];
                        $pres_query_u['dose_quantity'] = $input['update'][$value]['Dose_Qty'][$key].' '.$input['update'][$value]['Dose_UOM'][$key];
                        $pres_query_u['total_quantity'] = $input['update'][$value]['Total_Quantity'][$key].' '.$input['update'][$value]['Total_Quantity_UOM'][$key];
                        $pres_query_u['dosage_regimen'] = $input['update'][$value]['dosage'][$key];
                        $pres_query_u['dosage_regimen_others'] = isset($input['update'][$value]['Specify'][$key]) ? $input['update'][$value]['Specify'][$key] : NULL;
                        $pres_query_u['duration_of_intake'] = $input['update'][$value]['Duration_Intake'][$key].' '.$input['update'][$value]['Duration_Intake_Freq'][$key];

                        if($input['update'][$value]['regimen_startend_date'][$key] AND $input['update'][$value]['Duration_Intake_Freq'][$key] != "C"){
                            $regimen_startend_date  = explode(" - ", $input['update'][$value]['regimen_startend_date'][$key]);
                            $start_date  =  new Datetime($regimen_startend_date[0]);
                            $end_date  = new Datetime($regimen_startend_date[1]);

                            $pres_query_u['regimen_startdate'] = $start_date;
                            $pres_query_u['regimen_enddate'] = $end_date;
                        } else {
                            $pres_query_u['regimen_startdate'] = NULL;
                            $pres_query_u['regimen_enddate'] = NULL;
                        }

                        $pres_query_u['prescription_remarks'] = $input['update'][$value]['Remarks'][$key];

                        $pres_query_u_update = MedicalOrderPrescription::where('medicalorderprescription_id', $input['update'][$value]['medicalorderprescription_id'][$key])->update($pres_query_u);

                        $med_query_u['user_instructions'] = isset($input['update']['prescription_instructions'][$key]) ? $input['update']['prescription_instructions'][$key] : NULL;

                        $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($med_query_u);
                    }
                    else if($value == 'MO_LAB_TEST') {
                        //reset all lab exams by force deleting all so that unchecked items will be removed
                        $deleteAllExam = MedicalOrderLabExam::where('medicalorder_id',$input['update']['medicalorder_id'][$key])->forceDelete();
                        if(isset($input['update'][$value]['Examination_Code'])){
                            $Examination_Code = $input['update'][$value]['Examination_Code']; //dd($key, $Examination_Code, $input['update']);
                            foreach ($Examination_Code as $key_u_e_code => $value_u_e_code) {
                                    $lab_query = new MedicalOrderLabExam;
                                    $lab_query->medicalorderlaboratoryexam_id = IdGenerator::generateId().$key;
                                    $lab_query->medicalorder_id = $input['update']['medicalorder_id'][$key];
                                    $lab_query->laboratory_test_type = $value_u_e_code;
                                    $lab_query->laboratory_test_type_others = isset($input['update'][$value]['others'][$key_u_e_code]) ? $input['update'][$value]['others'][$key_u_e_code] : NULL;
                                    $lab_query->save();
                            }
                        } else {
                            //there is no checked lab
                            //delete this medical order ID
                            $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->forceDelete();
                        }
                        $med_query_u['user_instructions'] = isset($input['update']['laboratory_instructions'][$key]) ? $input['update']['laboratory_instructions'][$key] : NULL;

                        $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($med_query_u);

                    }
                    else if($value == 'MO_PROCEDURE') {
                        foreach($input['update'][$value]['Procedure_Order'] as $key => $v){
                            $prod_query_u['procedure_order'] = $input['update'][$value]['Procedure_Order'][$key];
                            $prod_query_u['procedure_date'] =  new Datetime($input['update'][$value]['Date_of_Procedure'][$key]);
                            $prod_query_u['procedure_instructions'] =  $input['update'][$value]['Procedure_Remarks'][$key];

                            $prod_query_u_update = MedicalOrderProcedure::where('medicalorderprocedure_id', $input['update'][$value]['medicalorderprocedure_id'][$key])->update($prod_query_u);
                        }
                        $med_query_u['user_instructions'] = isset($input['update']['procedure_user_instructions'][$key]) ? $input['update']['procedure_user_instructions'][$key] : NULL;

                        $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($med_query_u);


                    }
                    else if($value == 'MO_OTHERS') {

                        $other_query_u['medicalorder_others'] = isset($input['update'][$value]['order_type_others'][$key]) ? $input['update'][$value]['order_type_others'][$key] : NULL;

                        $med_query_u['user_instructions'] = isset($input['update']['other_instructions'][$key]) ? $input['update']['other_instructions'][$key] : NULL;

                        //if others entry to empty - delete medical order others
                        if($other_query_u['medicalorder_others'] == "") {
                            MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->forceDelete();
                        //else update the entry
                        } else {
                            $other_query_u_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($other_query_u);
                            $MedicalOrder_update = MedicalOrder::where('medicalorder_id', $input['update']['medicalorder_id'][$key])->update($med_query_u);
                        }


                    }
                    else {

                    }

                }
            }
            }
        }

        if ($input AND array_key_exists('delete', $input)) {

            foreach ($input['delete']['type'] as $key => $value) {

                if($value == 'MO_MED_PRESCRIPTION') {
                       $prescripDelete = MedicalOrderPrescription::where('medicalorderprescription_id', $input['delete'][$value]['medicalorderprescription_id'][$key])->delete();

                        if(isset($input['delete'][$value]['medicalorder_id'][$key])) {
                            $medprescDelete = MedicalOrder::where('medicalorder_id', $input['delete'][$value]['medicalorder_id'][$key])->forceDelete();
                        }
                }
                if($value == 'MO_PROCEDURE') {
                    //delete the item for deletion
                    $procDelete = MedicalOrderProcedure::where('medicalorderprocedure_id', $input['delete'][$value]['medicalorderprocedure_id'][$key])->forceDelete();

                    //check if there still orders here
                    $mayronpa = 0;
                    $mayprodcedurespa = MedicalOrder::where('healthcareservice_id', $input['hservices_id'])->get();

                    foreach($mayprodcedurespa as $proc){
                        $proced = MedicalOrderProcedure::where('medicalorder_id', $proc->medicalorder_id)->get();
                        if(empty($proced)) {
                            $mayronpa++;
                        }
                    }

                    //if the order is empty, delete medicalorder item
                    if($mayronpa == 0){
                        $procDelete = MedicalOrder::where('healthcareservice_id', $input['hservices_id'])->forceDelete();
                    }
                    //if the whole order form is deleted, delete medicalorder item
                    if(isset($input['delete'][$value]['medicalorder_id'][$key])) {
                        $procDelete = MedicalOrder::where('medicalorder_id', $input['delete'][$value]['medicalorder_id'][$key])->forceDelete();
                    }
                }
            }
        }

        return "ok";
    }

}
