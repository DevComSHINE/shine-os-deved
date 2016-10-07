@section('heads')
<style>
.laboratory_group .checkbox {
    margin-top: -5px;
}
.laboratory_group .checkbox .kbd {
    padding: 0 10px 1px;
    margin-bottom: 0;
}
</style>
@stop
<?php
    $medorder = 0;
    $withprescription = 0;
    $withlaboratory = 0;
    $withprocedure = 0;
    $withother = 0;
    $hideprescform = "";
    $hideprocform = "";
?>
<?php

if(empty($disposition_record->disposition)) { $read = NULL; }
else { $read = 'disabled'; $hideprescform = "closed";
    $hideprocform = "closed"; }
?>


    <div class="nav-tabs-custom medicalOrders">
        <ul class="nav nav-tabs" id="medorderTabs">
            <li><a class="tableader">Medical Orders</a></li>

            <?php $presCount = "&nbsp;"; $presFilled = ""; $preschidden = "hidden"; $prescactive = ""; $mayactive = 0; ?>
            @if($medicalorder_record)
                @foreach($medicalorder_record as $medorder)
                    @if($medorder->medicalorder_type == "MO_MED_PRESCRIPTION")
                        <?php
                            $presCount += count($medorder->medical_order_prescription);
                            $presFilled = "filled";
                            $withprescription = 1;
                            $hideprescform = "closed";
                            $preschidden = "";
                            $prescactive = "active";
                            $mayactive = 1;
                        ?>
                    @endif
                @endforeach
            @endif
            <li class="{{ $prescactive }} prescTab {{ $presFilled }} {{ $preschidden }}"><a href="#prescriptionTab" data-toggle="tab">Give Medical Prescription <span class="countNote">{{ $presCount }}</span></a></li>

            <?php $labCount = "&nbsp;"; $labFilled = ""; $labhidden = "hidden"; $labactive = ""; ?>
            @if($medicalorder_record)
                @foreach($medicalorder_record as $medorder)
                    @if($medorder->medicalorder_type == "MO_LAB_TEST")
                        <?php
                            $labCount += count($medorder->medical_order_lab_exam);
                            $labFilled = "filled";
                            $withlaboratory = 1;
                            $labhidden = "";
                            if($mayactive != 1) {
                                $labactive = "active";
                                $mayactive = 1;
                            }
                        ?>
                    @endif
                @endforeach
            @endif
            <li class="{{ $labactive }} labTab {{ $labFilled }} {{ $labhidden }}"><a href="#labTab" data-toggle="tab">Laboratory Test <span class="countNote">{{ $labCount }}</span></a></li>

            <?php $procCount = "&nbsp;"; $procFilled = ""; $prochidden = "hidden"; $procactive = ""; ?>
            @if($medicalorder_record)
                @foreach($medicalorder_record as $medorder)
                    @if($medorder->medicalorder_type == "MO_PROCEDURE")
                        <?php
                            $procCount += count($medorder->medical_order_procedure);
                            $procFilled = "filled";
                            $prochidden = "";
                            $withprocedure = 1;
                            if($mayactive != 1) {
                                $procactive = "active";
                                $mayactive = 1;
                            }
                        ?>
                    @endif
                @endforeach
            @endif
            <li class="{{ $procactive }} procTab {{ $procFilled }} {{ $prochidden }}"><a href="#procedureTab" data-toggle="tab">Medical Procedure <span class="countNote">{{ $procCount }}</span></a></li>

            <?php $otherCount = "&nbsp;"; $otherFilled = ""; $otherhidden = "hidden"; $otheractive = ""; ?>
            @if($medicalorder_record)
                @foreach($medicalorder_record as $medorder)
                    @if($medorder->medicalorder_type == "MO_OTHERS")
                        <?php
                            $otherCount += count($medorder->medicalorder_others);
                            $otherFilled = "filled";
                            $hideprocform = "closed";
                            $otherhidden = "";
                            $withother = 1;
                            if($mayactive != 1) {
                                $otheractive = "active";
                            }
                        ?>
                    @endif
                @endforeach

            @endif
            <li class="{{ $otheractive }} otherTab {{ $otherFilled }} {{ $otherhidden }}"><a href="#otherTab" data-toggle="tab">Other <span class="countNote">{{ $otherCount }}</span></a></li>

            @if(empty($disposition_record->disposition))
            <li class="pull-right"><span class="">{!! Form::select(NULL,
                                    array(
                                        '' => '-- Add a new order --',
                                        'MO_MED_PRESCRIPTION' => 'Give Medical Prescription',
                                        'MO_LAB_TEST' => 'Laboratory Exam',
                                        'MO_PROCEDURE' => 'Medical Procedure',
                                        'MO_OTHERS' => 'Others'
                                    ), NULL,
            ['class' => 'form-control medorders', 'id'=> 'medorders', $read]) !!}</span></li>
            @endif
            <?php /* //'MO_IMMUNIZATION' => 'Immunization', */?>
        </ul>
        <fieldset id="medicalorders_form">
        <div class="tab-content">
            @if($patientalert_record->count() > 0)
            <div id="alertsTab">
                <div class="form-group">
                    <legend class="no-border" style='font-size: 18px;'>Patient Alerts</legend>
                    <div class="">
                        <select class="form-control select2" multiple="multiple" data-placeholder="Allergies" style="width:100%;">
                          @foreach($patientalert_record as $alertKey => $alertValue)
                                @foreach($alertValue->PatientAllergies as $allegyKey => $allergyValue)
                                <option selected="selected">
                                    {{ $allergyValue->allergy_id }}: {{ $allergyValue->allergyreaction_name }}, {{ $allergyValue->allergy_severity }}
                                </option>
                               @endforeach
                          @endforeach
                        </select>
                    </div>
                    <br clear="all" />
                    <legend> </legend>
                </div>
            </div>
            @endif

            <div id="prescriptionTab" class="tab-pane {{ $prescactive }} {{ $preschidden }}">
                <legend>Prescription
                    <span class="pull-right padding">
                        @if($withprescription == 1 AND $healthcareData->seen_by)
                            <a class="btnlike btn-sm btn-success printPrescription" target="_blank" href="{{ url('healthcareservices/medorder/print/prescription/'.$healthcareserviceid) }}">Print Prescription</a>
                        @endif
                        <a class="btn btn-sm btn-danger removePrescriptionTab" {{ $read }}>Remove Prescription</a>
                    </span>
                </legend>
                <div class="col-md-5 medical_prescription_form">
                    <!--Prescription-->
                        <div class="form-group dynamic-row form-add MO_MED_PRESCRIPTION" >

                            <div class="prescription_group form_group">
                                    <div class="col-md-12"><p>&nbsp;</p><p>Fill out the prescription form and click on Add (+). If you need to edit a listed prescription, delete it first and create a new one.</p></div>
                                    {!! Form::hidden('PrescriptionMedID', null, ['class' => 'form-control']) !!}

                                <span class="btn btn-warning btn-sm pull-right addButton prescription_add" title="Add Prescription" {{ $read }}>Add to list <i class="fa fa-chevron-right"></i></span>

                                    <div class="form-group">

                                        <label class="control-label">Generic Name</label>
                                        <div class="col-md-12">
                                            {!! Form::textarea('Drug_Code', null, ['class' => 'form-control drug_input required', 'placeholder'=> 'Generic name', 'id'=>'drug_input', 'rows'=>3, $read]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group dynamic-row">
                                        <label class="control-label">Brand Name</label>
                                        <div class="col-md-12">
                                            {!! Form::text('Drug_Brand_Name', null, ['class' => 'form-control', 'placeholder'=> 'Brand name (optional)', $read]) !!}
                                        </div>
                                    </div>

                                    <div class="form-group dynamic-row">
                                        <label class="control-label">Quantity to buy</label>
                                        <div class="">
                                        <div class="col-md-6">
                                            {!! Form::text('Total_Quantity', null, ['class' => 'form-control nonzero required', $read]) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::select('Total_Quantity_UOM',
                                                array('' => 'Choose',
                                                    'Ampule' => 'Ampule',
                                                    'Bottles' => 'Bottles',
                                                    'Capsules' => 'Capsules',
                                                    'Caplets' => 'Caplets',
                                                    'Diskus' => 'Diskus',
                                                    'Ellipta' => 'Ellipta',
                                                    'Inhaler' => 'Inhaler',
                                                    'Insulin Pens' => 'Insulin Pens',
                                                    'Nebule' => 'Nebule',
                                                    'Papertab' => 'Papertab',
                                                    'Pre-filled Syringe' => 'Pre-filled Syringe',
                                                    'Respimat' => 'Respimat',
                                                    'Sachet' => 'Sachet',
                                                    'Suppository' => 'Suppository',
                                                    'Suspension' => 'Suspension',
                                                    'Syrup' => 'Syrup',
                                                    'Tablets' => 'Tablets',
                                                    'Tube' => 'Tube',
                                                    'Turbohaler' => 'Turbohaler',
                                                    'Unit dose Vial' => 'Unit dose Vial',
                                                    'Vials' => 'Vials'), '',
                                             ['class' => 'form-control required', $read]) !!}
                                        </div>
                                        </div>
                                    </div>

                                    <div class="form-group dynamic-row">
                                        <label class="control-label">Dose</label>
                                        <div class="">
                                            <div class="col-md-6">
                                                {!! Form::text('Dose_Qty', null, ['class' => 'form-control nonzero required', $read]) !!}
                                            </div>
                                            <div class="col-md-6">
                                                {!! Form::select('Dose_UOM',
                                                    array('' => 'Choose',
                                                        'drops' => 'drops',
                                                        'grams' => 'grams',
                                                        'mg' => 'mg',
                                                        'ml' => 'ml',
                                                        'mcg' => 'mcg',
                                                        'meq' => 'meq',
                                                        'units' => 'units'), '',
                                                 ['class' => 'form-control required', $read]) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group dynamic-row">
                                        <label class="control-label">Dosage Regimen </label>
                                        <div class="col-md-12">
                                            {!! Form::select('dosage',
                                                array('' => 'Choose',
                                                    'OD' => 'Once a day',
                                                    'BID' => '2 x a day - Every 12 hours',
                                                    'TID' => '3 x a day - Every 8 hours',
                                                    'QID' => '4 x a day - Every 6 hours',
                                                    'QOD' => 'Every other day',
                                                    'QHS' => 'Every bedtime',
                                                    'OTH' => 'Others'), '',
                                             ['class' => 'forother form-control required', 'id'=>'regimenothers', $read]) !!}
                                            <div id='forregimenothers' class="regimenothers hidden">
                                                    {!! Form::text('Specify', null, ['class' => 'form-control noresize', 'placeholder' => 'Specify others', 'rows'=>'1', $read]) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group dynamic-row">
                                        <label class="control-label">Intake</label>
                                        <div>
                                            <div class="col-md-6">
                                                {!! Form::text('Duration_Intake', null, ['class' => 'form-control nonzero required', 'id' => 'intake_input', 'placeholder'=> 'Duration of Intake', $read]) !!}
                                            </div>

                                            <div class="col-md-6">
                                                {!! Form::select('Duration_Intake_Freq',
                                                    array('' => 'Choose',
                                                        'D' => 'Days',
                                                        'W' => 'Weeks',
                                                        'M' => 'Months',
                                                        'Q' => 'Quarters',
                                                        'Y' => 'Years',
                                                        'C' => 'For Maintenance or Continuous',
                                                        'O' => 'Others'), '',
                                                 ['class' => 'form-control required', 'id'=>'intakeothers', $read]) !!}
                                                 <div id='forintakeothers' class="intakeothers hidden">
                                                        {!! Form::text('IntakeOther', null, ['class' => 'form-control noresize', 'placeholder' => 'Specify others', $read]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="regimen_range" class="form-group dynamic-row hidden">
                                        <label class="control-label">Regimen Start &amp; End Date</label>
                                        <div class="col-md-12 has-feedback">
                                            <div class="input-group">
                                              <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                              </div>
                                              {!! Form::text('regimen_startend_date', null, ['class' => 'form-control pull-right required', 'id'=>'daterangepicker', $read]); !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group dynamic-row">
                                        <label class="control-label">Prescription Remarks</label>
                                        <div class="col-md-12">
                                            {!! Form::textarea('Remarks', null, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'rows'=>'3', $read]) !!}
                                        </div>
                                        <div class="col-md-12">

                                        </div>
                                    </div>

                                <span class="btn btn-warning btn-sm pull-right addButton addbottom prescription_add"  title="Add Prescription" {{ $read }}>Add to list <i class="fa fa-chevron-right"></i></span>
                                <br clear="all" />
                            </div>

                        </div>
                    <!--/Prescription-->
                </div>
                <div class="col-md-7 medOrderData" id="medical_prescription_data">
                    <div class="col-md-12">&nbsp;</div>
                    @if($medicalorder_record)
                        @foreach ($medicalorder_record as $key => $medorder)
                            @if($medorder->medicalorder_type == 'MO_MED_PRESCRIPTION')
                                {!! Form::hidden("medicalorders[prescriptionmedicalorder_id]", $medorder->medicalorder_id) !!}
                                <?php $prescription_instructions = $medorder->user_instructions; ?>
                                @foreach($medorder->medical_order_prescription as $k => $value)
                                    @if($value->generic_name)
                                    <div class="medical_prescription_item added">
                                        {!! Form::hidden("medicalorders[update][type][]", 'MO_MED_PRESCRIPTION') !!}
                                        {!! Form::hidden("medicalorders[update][medicalorder_id][]", $medorder->medicalorder_id, ['class'=>'form-control medid']) !!}
                                        {!! Form::hidden("medicalorders[update][MO_MED_PRESCRIPTION][medicalorderprescription_id][]", $value->medicalorderprescription_id, ['class'=>'form-control remid prescid']) !!}
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Drug_Code][]', $value->generic_name, [ 'class'=>'dcode']) !!}
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Drug_Brand_Name][]', $value->brand_name, [ 'class'=>'brand']) !!}
                                        <?php
                                            $Dose_Qty = explode(" ", $value->dose_quantity);
                                            $dqty = isset($Dose_Qty[0]) ? $Dose_Qty[0] : NULL;
                                            $dqtyoum = isset($Dose_Qty[1]) ? $Dose_Qty[1] : NULL;
                                        ?>
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Dose_Qty][]', $dqty, [ 'class'=>'dqty']) !!}
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Dose_UOM][]', $dqtyoum, [ 'class'=>'dqtyoum']) !!}

                                        <?php
                                            $TQ = explode(" ", $value->total_quantity);
                                            $Total_Quantity = isset($TQ[0]) ? $TQ[0] : NULL;
                                            $Total_Quantity_UOM = isset($TQ[1]) ? $TQ[1] : NULL;
                                        ?>
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Total_Quantity][]', $Total_Quantity, [ 'class'=>'TQ']) !!}
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Total_Quantity_UOM][]', $Total_Quantity_UOM, [ 'class'=>'TQuom']) !!}

                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][dosage][]', $value->dosage_regimen, [ 'class'=>'regimen']) !!}
                                        @if($value->dosage_regimen_others)
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Specify][]', $value->dosage_regimen_others, [ 'class'=>'regimenothers']) !!}
                                        @endif

                                        <?php $Duration_Intake = explode(" ", $value->duration_of_intake); ?>
                                        <?php
                                            $di = isset($Duration_Intake[0]) ? $Duration_Intake[0] : NULL;
                                            $dio = isset($Duration_Intake[1]) ? $Duration_Intake[1] : NULL;
                                            $din = isset($Duration_Intake[1]) ? getIntakeName($Duration_Intake[1]) : NULL;
                                        ?>
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Duration_Intake][]', $di, [ 'class'=>'di']) !!}
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Duration_Intake_Freq][]', $dio, [ 'class'=>'dio']) !!}
                                        @if($dio == 'O' AND isset($value->IntakeOther))
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][IntakeOther][]', $value->IntakeOther, [ 'class'=>'intakeothers']) !!}
                                        @endif

                                        <?php
                                            if($value->duration_of_intake != ' C') {
                                                $regimendates = date('m/d/Y', strtotime($value->regimen_startdate)) .' - '. date('m/d/Y', strtotime($value->regimen_enddate));
                                            } else {
                                                $regimendates = NULL;
                                            }
                                        ?>
                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][regimen_startend_date][]', $regimendates, [ 'class'=>'regimen_dates']); !!}

                                        {!! Form::hidden('medicalorders[update][MO_MED_PRESCRIPTION][Remarks][]', $value->prescription_remarks, [ 'class'=>'remarks']) !!}

                                        <div class="col-md-12 form-group dynamic-row">
                                            <label class="col-md-1 control-label listCounter">&nbsp;</label>
                                            <div class="col-md-10 has-feedback bordered-bottom">
                                                <h4>{{ $value->generic_name }}  #{{ $Total_Quantity." ".$Total_Quantity_UOM}}</h4>
                                                <p>
                                                @if($value->brand_name)
                                                    <strong>({{ $value->brand_name }})</strong><br />
                                                @endif
                                                {{ $dqty.$dqtyoum }} - {{ getRegimenName($value->dosage_regimen) }}<br />
                                                @if($value->duration_of_intake != ' C')
                                                {{ $di." ".$din }} [ {{ $regimendates }} ]<br />
                                                @else
                                                {{ $di." ".$din }} <br />
                                                @endif
                                                <em>{{ $value->prescription_remarks }}</em>
                                                </p>
                                            </div>
                                            <div class="col-md-1">
                                                @if(empty($disposition_record->disposition))
                                                <span class="btn btn-default btn-sm prescription_less" title="Remove Prescription"><i class="fa fa-times"></i></span>
                                                <span class="btn btn-default btn-sm prescription_edit" id="" title="Edit Prescription"><i class="fa fa-pencil"></i></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endif

                        @endforeach
                    @endif

                </div>
                <div class="col-md-12 form-group dynamic-row">
                    <label class="col-md-12 control-label textleft">Doctor's Instructions</label>
                    <div class="col-md-12">
                        @if(isset($prescription_instructions))
                            <?php $instructions = NULL; ?>
                            @if($prescription_instructions != "")
                                <?php $instructions = $prescription_instructions; ?>
                            @endif
                            {!! Form::textarea("medicalorders[update][prescription_instructions][]", $instructions, ['class' => 'form-control noresize instructions', 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @else
                            {!! Form::textarea("medicalorders[insert][prescription_instructions][]", null, ['class' => 'form-control noresize instructions', 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @endif
                    </div>
                </div>
            </div>

            <div id="labTab" class="tab-pane {{ $labactive }} {{ $labhidden }}">
                <div class="col-md-12 medical_laboratory_form">
                    <!--Laboratory-->
                    <div class="form-group dynamic-row form-add MO_LAB_TEST" >
                        <legend>Laboratory Test
                            <span class="pull-right padding">
                                @if($withlaboratory == 1 AND $healthcareData->seen_by)
                                    <a class="btnlike btn-success btn-sm printLab" href="{{ url('healthcareservices/medorder/print/laboratory/'.$healthcareserviceid) }}" target="_blank">Print Lab Order</a>
                                @endif
                                <a class="btn btn-sm btn-danger removeLaboratoryTab">Remove Laboratory</a>
                            </span>
                        </legend>
                        <div class="laboratory_group">
                            <div class="icheck row">
                                <div class="col-md-12">
                                    <h4>Choose all the laboratory exams you require.</h4>
                                    <br clear="all" />
                                </div>

                                <div class="form-group col-md-11 col-md-push-1">
                                    <?php $ohid = "hidden"; $rhid = "hidden"; $results = ""; $others = ""; $laboratory_instructions = ""; $maylab = 0; $curtype = 0; ?>
                                    @if($medicalorder_record)
                                        @foreach ($medicalorder_record as $key => $laboratory)
                                            @if($laboratory->medicalorder_type == 'MO_LAB_TEST' AND !empty($laboratory->medical_order_lab_exam))
                                                <?php
                                                    $maylab = 1;
                                                    $laboratory_instructions = $laboratory->user_instructions;
                                                ?>
                                                {!! Form::hidden("medicalorders[update][type][]", $laboratory->medicalorder_type) !!}
                                                {!! Form::hidden("medicalorders[update][medicalorder_id][]", $laboratory->medicalorder_id) !!}
                                                @foreach($lovlaboratories as $labs)
                                                    <div class="col-md-4 checkbox">
                                                        <label>
                                                          <?php $selectd = ""; ?>
                                                          @foreach ($laboratory->medical_order_lab_exam as $lab_key => $lab_value)
                                                            <?php $labid = ""; ?>
                                                            @if($lab_value->laboratory_test_type == $labs->laboratorycode)
                                                                <?php
                                                                    $selectd = "checked='checked'";
                                                                ?>
                                                                {!! Form::hidden("medicalorders[update][MO_LAB_TEST][medicalorderlaboratoryexam_id][]", $lab_value->medicalorderlaboratoryexam_id,['class'=>'form-control']) !!}
                                                                <?php $labid = $lab_value->medicalorderlaboratoryexam_id; break; ?>
                                                            @endif
                                                          @endforeach

                                                          <input type="checkbox" name="medicalorders[update][MO_LAB_TEST][Examination_Code][]" value="{{ $labs->laboratorycode }}" {{ $selectd }} class="lab-checkbox form-control"  id="{{ $labs->laboratorycode }}" {{ $read }} /> {{ $labs->laboratorydescription }}
                                                        </label>
                                                            <?php $labres = ShineOS\Core\Healthcareservices\Entities\MedicalOrderLabExam::where('medicalorderlaboratoryexam_id',$labid)->with('LaboratoryResult')->first();
                                                                $colr = "bg-gray";
                                                            ?>
                                                            @if($labid != "" AND $labres)
                                                             @if(isset($labres->LaboratoryResult->lab_data))
                                                                <?php $colr = "bg-yellow"; ?>
                                                             @endif
                                                             | <a onclick="return false;" href="{{ url('laboratory/modal/'.$labs->laboratorycode.'/'.$labid) }}" class="{{ $colr }} text-black kbd labshowbutton" data-toggler="modal" data-target="#myInfoModal"><i class="fa fa-search"></i></a>
                                                            @endif
                                                    </div>
                                                @endforeach

                                                @foreach ($laboratory->medical_order_lab_exam as $lab_key => $lab_value)
                                                    @if($lab_value->laboratorytest_result)
                                                        <?php $rhid = ""; ?>
                                                        <?php $results .= "[".getLabName($lab_value->laboratory_test_type)."] :  ".$lab_value->laboratorytest_result."\n"; ?>
                                                        {!! Form::hidden("medicalorders[update][MO_LAB_TEST][results][]", $lab_value->laboratorytest_result) !!}
                                                    @endif
                                                    @if($lab_value->laboratory_test_type_others)
                                                        <?php $ohid = ""; ?>
                                                        <?php $others .= $lab_value->laboratory_test_type_others."; "; ?>
                                                        {!! Form::hidden("medicalorders[insert][MO_LAB_TEST][others][]", $lab_value->laboratory_test_type_others) !!}
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif

                                    @if($maylab == 0)
                                        {!! Form::hidden("medicalorders[insert][type][]", 'MO_LAB_TEST' ) !!}
                                        {!! Form::hidden("medicalorders[insert][medicalorder_id][]", null ) !!}
                                        @foreach($lovlaboratories as $labs)
                                            <div class="col-md-4 checkbox">
                                                <label>
                                                  <input type="checkbox" name="medicalorders[insert][MO_LAB_TEST][Examination_Code][]" value="{{ $labs->laboratorycode }}" class="form-control labchoose"  id="{{ $labs->laboratorycode }}" {{ $read }} /> {{ $labs->laboratorydescription }}

                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div id="labOthers" class="form-group dynamic-row {{ $ohid }}">
                                <label class="col-md-2 control-label">Specify Other Test</label>
                                <div class="col-md-10">
                                    @if($maylab == 1)
                                    {!! Form::text("medicalorders[update][MO_LAB_TEST][others][]", $others, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'rows'=>'3', $read]) !!}
                                    @else
                                    {!! Form::text("medicalorders[insert][MO_LAB_TEST][others][]", null, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'rows'=>'3', $read]) !!}
                                    @endif
                                </div>
                            </div>

                            <div class="form-group dynamic-row {{ $rhid }}">
                                <label class="col-md-2 control-label">Lab Results</label>
                                <div class="col-md-10">
                                    {!! Form::textarea("", $results, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', $read]) !!}
                                </div>
                            </div>

                            <hr />
                        </div>
                    </div>
                    <!--/Laboratory-->
                </div>
                <div class="col-md-12 form-group dynamic-row">
                    <label class="col-md-12 control-label textleft">Doctor's Instructions</label>
                    <div class="col-md-12">
                        @if($maylab == 1)
                            {!! Form::textarea("medicalorders[update][laboratory_instructions][]", $laboratory_instructions, ['class' => 'form-control noresize instructions', 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @else
                            {!! Form::textarea("medicalorders[insert][laboratory_instructions][]", null, ['class' => 'form-control noresize instructions', 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @endif
                    </div>
                </div>

            </div>

            <div id="procedureTab" class="tab-pane {{ $procactive }} {{ $prochidden }}">
                <legend>Medical Procedure
                    <span class="pull-right padding">
                        <a class="btn btn-sm btn-danger removeProcedureTab">Remove Procedure</a>
                    </span>
                </legend>
                <div class="col-md-5 medical_procedure_form">
                    <!--Medical Procedure-->
                        <?php $proc_key = 1; ?>
                        <div class="form-group dynamic-row form-add MO_PROCEDURE" >

                            <div class="procedure_group form_group">
                                <div class="col-md-12"><p>&nbsp;</p><p>Fill out the medical procedure form and click on Add (+). If you need to edit a listed procedure, delete it first and create a new one.</p></div>
                                {!! Form::hidden('ProcedureMedID', null, ['class' => 'form-control']) !!}
                                <span class="btn btn-warning btn-sm pull-right addButton procedure_add" title="Add one more Procedure">Add to list <i class="fa fa-chevron-right"></i></span>
                                <div class="form-group">
                                    <label class="control-label">Procedure Order</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control required" id="procedure_input" rows="2" name="Procedure_Order" {{ $read }}></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Date of Procedure</label>
                                    <div class="col-md-12 has-feedback">
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('Date_of_Procedure', NULL, ['class' => 'form-control datepicker_future required', 'id' => 'datepicker_future', $read]); !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group dynamic-row">
                                    <label class="control-label">Procedure Instructions</label>
                                    <div class="col-md-12">
                                        {!! Form::textarea('Procedure_Remarks', null, ['class' => 'form-control noresize', 'placeholder' => 'Instructions', 'rows'=>'3', $read]) !!}
                                    </div>
                                </div>
                                <span class="btn btn-warning btn-sm pull-right addButton addbottom procedure_add" title="Add one more Procedure">Add to list <i class="fa fa-chevron-right"></i></span>
                            </div>


                        </div>
                    <!--/Medical Procedure-->
                </div>
                <div class="col-md-7 medOrderData" id="medical_procedure_data">
                    <div class="col-md-12">&nbsp;</div>
                @if($medicalorder_record)
                    @foreach ($medicalorder_record as $key => $medorder)
                        @if($medorder->medicalorder_type == 'MO_PROCEDURE')

                            {!! Form::hidden("medicalorders[proceduremedicalorder_id]", $medorder->medicalorder_id) !!}
                            <?php $procedure_user_instructions = $medorder->user_instructions; ?>
                            @foreach($medorder->medical_order_procedure as $k => $proc_value)
                                <div class="medical_procedure_item added">
                                    {!! Form::hidden("medicalorders[update][type][]", 'MO_PROCEDURE') !!}
                                    {!! Form::hidden("medicalorders[update][medicalorder_id][]", $medorder->medicalorder_id, ['class'=>'form-control medid']) !!}
                                    {!! Form::hidden("medicalorders[update][MO_PROCEDURE][medicalorderprocedure_id][]", $proc_value->medicalorderprocedure_id, ['class'=>'form-control remid procid']) !!}

                                    {!! Form::hidden("medicalorders[update][MO_PROCEDURE][Procedure_Order][]", $proc_value->procedure_order, ['class'=>'form-control procorder']) !!}
                                    {!! Form::hidden("medicalorders[update][MO_PROCEDURE][Date_of_Procedure][]", date('m/d/Y', strtotime($proc_value->procedure_date)), [ 'class'=>'procdate']); !!}
                                    {!! Form::hidden("medicalorders[update][MO_PROCEDURE][Procedure_Remarks][]", $proc_value->procedure_instructions, [ 'class'=>'procinstruct']); !!}

                                    <div class="col-md-12 form-group dynamic-row">
                                        <label class="col-md-1 control-label listCounter">&nbsp;</label>
                                        <div class="col-md-10 has-feedback bordered-bottom">
                                            <h4>{{ $proc_value->procedure_order }}</h4>
                                            <p>{{ date('m/d/Y', strtotime($proc_value->procedure_date)) }}<br />{{ $proc_value->procedure_instructions }}</p>
                                        </div>
                                        <div class="col-md-1">
                                            @if(empty($disposition_record->disposition))
                                            <span class="btn btn-default btn-sm procedure_less" title="Remove Procedure"><i class="fa fa-times"></i></span>
                                            <span class="btn btn-default btn-sm procedure_edit" title="Edit Procedure"><i class="fa fa-pencil"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif

                    @endforeach
                @endif
                </div>
                <div class="col-md-12 form-group dynamic-row">
                    <label class="col-md-12 control-label textleft">Doctor's Instructions</label>
                    <div class="col-md-12">
                        @if(isset($procedure_user_instructions) AND $procedure_user_instructions != "")
                            {!! Form::textarea("medicalorders[update][procedure_user_instructions][]", $procedure_user_instructions, ['class' => 'form-control noresize instructions', 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @else
                            {!! Form::textarea("medicalorders[insert][procedure_user_instructions][]", null, ['class' => 'form-control noresize instructions', 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @endif
                    </div>
                </div>
            </div>

            <div id="otherTab" class="tab-pane {{ $otheractive }} {{ $otherhidden }}">
                <div class="col-md-12 medical_other_form">
                    <!--Others-->
                        <div class="form-group dynamic-row form-add MO_OTHERS" >
                            <legend>Other
                                <span class="pull-right padding">
                                    <a class="btn btn-sm btn-danger removeOtherTab">Remove Other</a>
                                </span>
                            </legend>
                            <div class="col-md-12">&nbsp;</div>
                            <div class="form-group dynamic-row">
                                <label class="col-md-3 control-label">Specify Custom Order</label>
                                <div class="col-md-8">
                                    <?php $other_instructions = ""; $mayother = 0; ?>
                                    @if($medicalorder_record)
                                        @foreach ($medicalorder_record as $key => $otherorder)
                                            @if($otherorder->medicalorder_type == 'MO_OTHERS')
                                                <?php $mayother = 1; ?>
                                                {!! Form::hidden("medicalorders[update][type][]", 'MO_OTHERS') !!}
                                                {!! Form::hidden("medicalorders[update][medicalorder_id][]", $medorder->medicalorder_id) !!}
                                                <?php $other_instructions .= $otherorder->user_instructions."\r\n"; ?>
                                                {!! Form::textarea('medicalorders[update][MO_OTHERS][order_type_others][]', $otherorder->medicalorder_others, ['class' => 'form-control noresize', 'placeholder' => 'Specify others', 'rows'=>'3', $read]) !!}
                                            @endif
                                        @endforeach
                                    @endif

                                    @if($mayother == 0)
                                        {!! Form::hidden("medicalorders[insert][type][]", 'MO_OTHERS') !!}
                                        {!! Form::hidden("medicalorders[insert][medicalorder_id][]", null) !!}

                                        {!! Form::textarea('medicalorders[insert][MO_OTHERS][order_type_others][]', null, ['class' => 'form-control noresize', 'placeholder' => 'Specify others', 'rows'=>'3', $read]) !!}
                                    @endif
                                </div>
                            </div>
                            <hr />
                        </div>
                    <!--/Others-->
                </div>
                <div class="col-md-12 form-group dynamic-row">
                    <label class="col-md-12 control-label textleft">Doctor's Instructions</label>
                    <div class="col-md-12">
                        @if($mayother == 1)
                            {!! Form::textarea("medicalorders[update][other_instructions][]", $other_instructions, ['class' => 'form-control noresize instructions', 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @else
                            {!! Form::textarea("medicalorders[insert][other_instructions][]", null, ['class' => 'form-control noresize instructions', 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @endif

                    </div>
                </div>
            </div>
        </div><!-- /.tab-content -->
        </fieldset>
    </div><!-- nav-tabs-custom -->

<br clear="all" />

@section('before_validation_scripts')
<script>
    //setup autocomplete for Procedures
    var availableProcedures = [
        <?php foreach($lovMedicalProcedure as $key => $procedure) { ?>
        "<?php echo htmlentities($procedure, ENT_QUOTES) ?>",
        <?php } ?>
    ];

    var availableDrugs = [
        <?php foreach($lovDrugs as $key => $drug) { ?>
        "<?php echo htmlentities($drug->drug_specification, ENT_QUOTES); ?>",
        <?php } ?>
    ];
</script>

<!--Put page related scripts here-->
<script type="text/javascript">
$(".select2").select2({
    'disabled': 'disabled'
});
$(".labshowbutton").on( "click", function( event ) {
    url = ($(this).attr("href"));
    $('#myInfoModal').modal('show');
    $('#myInfoModal').find(".modal-content").html("");
    $('#myInfoModal').find(".modal-content").load(url);
  });
</script>

@stop
