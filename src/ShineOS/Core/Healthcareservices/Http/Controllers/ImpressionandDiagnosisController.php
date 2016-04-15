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

        $this->txt_diag = Input::has('diag') ? Input::get('diag') : false;

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
                    if (array_key_exists($key, $this->txt_diag['insert']['notes']) AND $this->txt_diag['insert']['type'][$key] != NULL) {
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
                $ctr = 0;
                    foreach ($this->txt_diag['update']['type'] as $k => $v) {
                        // dd("Update ".$v);
                        if (array_key_exists($k, $this->txt_diag['update']['type']) AND array_key_exists($k, $this->txt_diag['update']['notes']) AND array_key_exists($k, $this->txt_diag['update']['diagnosis_id']) )
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
                        }
                        // echo "<pre>"; print_r('parent '.$this->icd10['parent']); echo '</pre>';
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
}
