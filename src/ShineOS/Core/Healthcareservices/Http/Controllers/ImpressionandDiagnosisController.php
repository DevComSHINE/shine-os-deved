<?php namespace ShineOS\Core\Healthcareservices\Http\Controllers;

use Illuminate\Routing\Controller;
use ShineOS\Core\Healthcareservices\Entities\Diagnosis;
use ShineOS\Core\Healthcareservices\Entities\DiagnosisICD10;

use ShineOS\Core\Healthcareservices\Http\Requests\DiagnosisFormRequest;
use Shine\Libraries\IdGenerator;
use ShineOS\Core\Healthcareservices\Entities\Lovicd10; //model
use View, Response, Validator, Input, Mail, Session, Redirect, Hash, Auth, DB, Datetime, Request;

class ImpressionandDiagnosisController extends Controller {

    protected $tb_unique_id = "";
    protected $current_timestamp;
    protected $txt_hservices_id;
    private $txt_diag;
    private $icd10;

    public function __construct() {
        /** User Session or Authenticaion  */
        $this->middleware('auth');

        $date = new Datetime('now');
        $this->current_timestamp = strtotime($date->format('Y-m-d H:i:s'));
        $this->tb_unique_id =  IdGenerator::generateId();
        $this->tb_diagICD10_id =  IdGenerator::generateId();

        $this->action = Input::has('action') ? Input::get('action')  : false;
        $this->txt_hservices_id = Input::has('healthcareservice_id') ? Input::get('healthcareservice_id')  : false;

        $this->txt_diag = Input::has('impanddiag') ? Input::get('impanddiag') : false;

        $this->icd10 = array(
            'parent' => Input::has('parent') ? Input::get('parent') : false,
            'category' => Input::has('category') ? Input::get('category') : false,
            'subcat' => Input::has('subcat') ? Input::get('subcat') : false,
            'subsubcat' => Input::has('subsubcat') ? Input::get('subsubcat') : false,
        );
    }

    public function UpdateCreate(DiagnosisFormRequest $request) {

            if (array_key_exists('insert', $this->txt_diag)) {
                $ctr = 0;
                foreach ($this->txt_diag['insert']['type'] as $key => $val) {
                    // dd("Insert ".$val);
                    if (array_key_exists($key, $this->txt_diag['insert']['diagnosislist_id']) AND $this->txt_diag['insert']['type'][$key] != NULL) {
                        $query = new Diagnosis;
                        $query->diagnosis_id = $this->tb_unique_id . $ctr;
                        $query->healthcareservice_id = $this->txt_hservices_id;
                        $query->diagnosislist_id = $this->txt_diag['insert']['diagnosislist_id'][$key];
                        $query->diagnosis_type = $val;
                        $query->diagnosis_notes = $this->txt_diag['insert']['notes'][$key];
                        $query->save();
                    }
                    if ($val == 'FINDX' && $this->icd10['parent']) {

                            $icd10_query = new DiagnosisICD10;
                            $icd10_query->diagnosisicd10_id = $ctr . $this->tb_unique_id;
                            $icd10_query->diagnosis_id = $this->tb_unique_id . $ctr ;
                            $icd10_query->icd10_classifications = $this->icd10['parent'];
                            $icd10_query->icd10_subClassifications = $this->icd10['category'];
                            $icd10_query->icd10_type = $this->icd10['subcat'];
                            $icd10_query->icd10_code = $this->icd10['subsubcat'];
                            $icd10_query->save();
                    }
                    $ctr++;
                }
                $flash_message = 'Well done! You successfully Added Diagnosis Information.';
            }

            if (array_key_exists('update', $this->txt_diag)) {
                //delete all diagnosis to reset
                //then save again
                $AllDiag = Diagnosis::where('healthcareservice_id',$this->txt_hservices_id)->forceDelete();
                $ctr = 0;
                    foreach ($this->txt_diag['update']['type'] as $k => $v) {
                        $query = new Diagnosis;
                                $query->diagnosis_id = $this->tb_unique_id . $ctr;
                                $query->healthcareservice_id = $this->txt_hservices_id;
                                $query->diagnosislist_id = $this->txt_diag['update']['diagnosislist_id'][$k];
                                $query->diagnosis_type = $this->txt_diag['update']['type'][$k];
                                $query->diagnosis_notes = $this->txt_diag['update']['notes'][$k];
                                $query->save();

                        /*if (array_key_exists($k, $this->txt_diag['update']['type']) AND array_key_exists($k, $this->txt_diag['update']['notes']) AND array_key_exists($k, $this->txt_diag['update']['diagnosis_id']) )
                        {
                            if($this->txt_diag['update']['diagnosis_id'][$k] != "") {
                                $update = Diagnosis::where('diagnosis_id', $this->txt_diag['update']['diagnosis_id'][$k])
                                            ->update(array('diagnosis_type' => $this->txt_diag['update']['type'][$k],
                                                'diagnosis_notes' => $this->txt_diag['update']['notes'][$k],
                                                'diagnosislist_id' => $this->txt_diag['update']['diagnosislist_id'][$k]));
                            } else {
                                $query = new Diagnosis;
                                $query->diagnosis_id = $this->tb_unique_id . $ctr;
                                $query->healthcareservice_id = $this->txt_hservices_id;
                                $query->diagnosislist_id = $this->txt_diag['update']['diagnosislist_id'][$k];
                                $query->diagnosis_type = $this->txt_diag['update']['type'][$k];
                                $query->diagnosis_notes = $this->txt_diag['update']['notes'][$k];
                                $query->save();
                            }
                        }*/

                        if ($this->txt_diag['update']['type'][$k] == 'FINDX' AND $this->icd10['parent']) {
                            $updated = DiagnosisICD10::where('diagnosis_id', $this->txt_diag['update']['diagnosis_id'][$k])
                                ->update(array('icd10_classifications' => $this->icd10['parent'],
                                    'icd10_subClassifications' => $this->icd10['category'],
                                    'icd10_type' => $this->icd10['subcat'],
                                    'icd10_code' => $this->icd10['subsubcat']));

                        }
                        $ctr++;
                    }

                $flash_message = 'Well done! You successfully Updated Diagnosis Information.';

            }

            return Redirect::back()
                         ->with('flash_message', $flash_message)
                         ->with('flash_type', 'alert-success alert-dismissible')
                            ->with('flash_tab', 'impanddiag');


    }

    public function save($data)
    {
        //dd($data);
        $hcsID = Input::has('hservices_id') ? Input::get('hservices_id')  : false;
        if($hcsID) {
            if ($data AND array_key_exists('insert', $data)) {
                $ctr = 0;
                foreach ($data['insert']['type'] as $key => $val) {
                    // dd("Insert ".$val);
                    if (array_key_exists($key, $data['insert']['diagnosislist_id']) AND $data['insert']['type'][$key] != NULL) {
                        $query = new Diagnosis;
                        $query->diagnosis_id = $this->tb_unique_id . $ctr;
                        $query->healthcareservice_id = $hcsID;
                        $query->diagnosislist_id = $data['insert']['diagnosislist_id'][$key];
                        $query->diagnosis_type = $val;
                        $query->diagnosis_notes = $data['insert']['notes'][$key];
                        $query->save();
                    }
                    if ($val == 'FINDX' && isset($data['category']) AND $data['category'] != NULL) {
                            $icd10_query = new DiagnosisICD10;
                            $icd10_query->diagnosisicd10_id = $ctr . $this->tb_unique_id;
                            $icd10_query->diagnosis_id = $this->tb_unique_id . $ctr ;
                            $icd10_query->icd10_classifications = isset($data['parent']);
                            $icd10_query->icd10_subClassifications = $data['category'];
                            if(isset($data['subcat'])){
                                $icd10_query->icd10_type = $data['subcat'];
                            }
                            if(isset($data['subsubcat'])) {
                                $icd10_query->icd10_code = $data['subsubcat'];
                            }
                            $icd10_query->save();
                    }
                    $ctr++;
                }
                $flash_message = 'Well done! You successfully Added Diagnosis Information.';
            }

            if ($data AND array_key_exists('update', $data)) {
                $ctr = 0;
                    foreach ($data['update']['type'] as $k => $v) {
                        $upquery = Diagnosis::where('diagnosis_id', $data['update']['diagnosis_id'][$k])
                            ->update(
                                array(
                                    'healthcareservice_id' => $hcsID,
                                    'diagnosislist_id' => $data['update']['diagnosislist_id'][$k],
                                    'diagnosis_type' => $data['update']['type'][$k],
                                    'diagnosis_notes' => $data['update']['notes'][$k],
                            )
                        );

                        if ($data['update']['type'][$k] == 'FINDX' AND $data['parent'] != "0") {
                            $ck = DiagnosisICD10::where('diagnosis_id', $data['update']['diagnosis_id'][$k])->first();
                            if($ck){
                                $updated = DiagnosisICD10::where('diagnosis_id', $data['update']['diagnosis_id'][$k])
                                    ->update(
                                        array('icd10_classifications' => $data['parent'],
                                        'icd10_subClassifications' => isset($data['category']) ? $data['category'] : NULL,
                                        'icd10_type' => isset($data['subcat']) ? $data['subcat'] : NULL,
                                        'icd10_code' => isset($data['subsubcat']) ? $data['subsubcat'] : NULL
                                    )
                                );
                            } else {
                                $icd10_query = new DiagnosisICD10;
                                $icd10_query->diagnosisicd10_id = $ctr . $this->tb_unique_id;
                                $icd10_query->diagnosis_id = $data['update']['diagnosis_id'][$k];
                                $icd10_query->icd10_classifications = $data['parent'];
                                $icd10_query->icd10_subClassifications = isset($data['category']) ? $data['category'] : NULL;
                                if(isset($data['subcat'])){
                                    $icd10_query->icd10_type = $data['subcat'];
                                }
                                if(isset($data['subsubcat'])) {
                                    $icd10_query->icd10_code = $data['subsubcat'];
                                }
                                $icd10_query->save();
                            }
                        }
                        $ctr++;
                    }

                $flash_message = 'Well done! You successfully Updated Diagnosis Information.';

            }

            return "ok";
        }
    }
}
