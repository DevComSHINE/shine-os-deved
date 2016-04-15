{!! Form::open(array('route' => 'medorder.insert', 'class'=>'form-horizontal')) !!}
{!! Form::hidden('hservices_id', $healthcareserviceid) !!}
<?php
    $medorder = 0;
    $withprescription = 0;
    $withlaboratory = 0;
?>
<?php

if(empty($disposition_record->disposition)) { $read = NULL; }
else { $read = 'disabled'; }
?>

<fieldset>
    <legend>
        <span  class="col-md-5">Medical Orders</span>
        @if(empty($disposition_record->disposition))
        <span class="col-md-7 pull-right"><span class="col-md-5 textright">Choose here ></span> <span class="col-md-7">{!! Form::select(NULL,
                                array(
                                    '' => '-- Add a new order --',
                                    'MO_MED_PRESCRIPTION' => 'Give Medical Prescription',
                                    'MO_LAB_TEST' => 'Laboratory Exam',
                                    'MO_PROCEDURE' => 'Medical Procedure',
                                    'MO_OTHERS' => 'Others'
                                ), NULL,
        ['class' => 'form-control medorders col-md-7', 'id'=> 'medorders', $read]) !!}</span></span>
        @endif
        <?php /* //'MO_IMMUNIZATION' => 'Immunization', */?>
    </legend>
</fieldset>
@if($patientalert_record->count() > 0)
<div class="form-group">
    <p class='lead col-md-2 text-right'>Patient Alerts</p>
    <div class="col-md-10">
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
@endif

<fieldset>
@if($medicalorder_record)
<?php // dd($medicalorder_record); ?>
    @foreach ($medicalorder_record as $key => $value)
        <?php $fix = 1; ?>
        <div id="medorder{{ $key }}" class="loaded-content">
            <div>
                <?php $hidden = "hidden"; ?>

                {!! Form::hidden("update[type][]", $value->medicalorder_type) !!}
                {!! Form::hidden("update[medicalorder_id][]", $value->medicalorder_id) !!}

                <!--DYNAMIC FORM GROUP-->
                <div class="form-group dynamic-row">
                    <label class="col-md-2 control-label">Medical Management &amp; Orders</label>
                    <div class="col-md-8 medical_order_form">
                        <!--Prescription-->
                            @if(!empty($value->medical_order_prescription))
                                <?php $withprescription = 1; $fix = 0; //dd($value->medical_order_prescription); ?>
                                @foreach ($value->medical_order_prescription as $pres_key => $pres_value)

                                    {!! Form::hidden("update[MO_MED_PRESCRIPTION][medicalorderprescription_id][$key]", $pres_value->medicalorderprescription_id, ['class'=>'form-control']) !!}
                                    <div class="form-group dynamic-row form-add MO_MED_PRESCRIPTION">
                                        <legend style='font-size: 18px;'>Prescription</legend>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Generic Name</label>
                                            <div class="col-md-8">
                                                {!! Form::text("update[MO_MED_PRESCRIPTION][Drug_Code][]", $pres_value->generic_name, ['class' => 'form-control drug_input', 'placeholder'=> 'Generic name', 'id'=>'drug_input', $read]) !!}
                                            </div>
                                        </div>

                                        <div class="form-group dynamic-row">
                                            <label class="col-md-3 control-label">Brand Name</label>
                                            <div class="col-md-8">
                                                {!! Form::text("update[MO_MED_PRESCRIPTION][Drug_Brand_Name][]", $pres_value->brand_name, ['class' => 'form-control', 'placeholder'=> 'Brand name', $read]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group dynamic-row">
                                            <?php $Dose_Qty = explode(" ", $pres_value->dose_quantity); ?>
                                            <label class="col-md-3 control-label">Dose Quantity</label>
                                            <div class="col-md-5">

                                                {!! Form::text("update[MO_MED_PRESCRIPTION][Dose_Qty][]", $Dose_Qty[0], ['class' => 'form-control forreq', 'placeholder'=> 'Dosage', 'data-fv-numeric'=>'true', 'data-fv-numeric-decimalseparator'=>'.', $read]) !!}
                                            </div>

                                            <div class="col-md-3">
                                                <?php
                                                    if(isset($Dose_Qty[1])) {
                                                        $dqty = $Dose_Qty[1];
                                                    } else {
                                                        $dqty = NULL;
                                                    }
                                                ?>
                                                {!! Form::select("update[MO_MED_PRESCRIPTION][Dose_UOM][]",
                                                    array('' => 'Choose',
                                                        'drops' => 'drops',
                                                        'mg' => 'mg',
                                                        'ml' => 'ml',
                                                        'mcg' => 'mcg',
                                                        'mec' => 'mec',
                                                        'units' => 'units',
                                                        'other' => 'other'), $dqty,
                                                 ['class' => 'form-control forreq', $read]) !!}
                                            </div>
                                        </div>

                                        <div class="form-group dynamic-row">
                                            <?php $Total_Quantity = explode(" ", $pres_value->total_quantity); ?>
                                            <label class="col-md-3 control-label">Total Quantity</label>
                                            <div class="col-md-5">
                                                {!! Form::text("update[MO_MED_PRESCRIPTION][Total_Quantity][]", $Total_Quantity[0], ['class' => 'form-control nonzero forreq', 'placeholder'=> 'Quantity', $read]) !!}
                                            </div>

                                            <div class="col-md-3">
                                                <?php
                                                    if(isset($Total_Quantity[1])) {
                                                        $tqty = $Total_Quantity[1];
                                                    } else {
                                                        $tqty = NULL;
                                                    }
                                                ?>
                                                {!! Form::select("update[MO_MED_PRESCRIPTION][Total_Quantity_UOM][]",
                                                    array('' => 'Choose',
                                                        'Tablets' => 'Tablets',
                                                        'Capsules' => 'Capsules',
                                                        'Bottles' => 'Bottles',
                                                        'Others' => 'Others'), $tqty,
                                                 ['class' => 'form-control forreq', $read]) !!}
                                            </div>
                                        </div>

                                        <div class="form-group dynamic-row">
                                            <label class="col-md-3 control-label">Dosage Regimen </label>
                                            <div class="col-md-8">
                                                {!! Form::select("update[MO_MED_PRESCRIPTION][dosage][]",
                                                    array('' => 'Choose',
                                                        'OD' => 'Once a day',
                                                        'BID' => '2 x a day - Every 12 hours',
                                                        'TID' => '3 x a day - Every 8 hours',
                                                        'QID' => '4 x a day - Every 6 hours',
                                                        'QOD' => 'Every other day',
                                                        'QHS' => 'Every bedtime',
                                                        'OTH' => 'Others'), $pres_value->dosage_regimen,
                                                 ['class' => 'forother form-control forreq', 'id'=>'regimenothers0', $read]) !!}
                                                 <!-- 'onchange'=>'if(this.value == 'OTH') show(event.target.id);' -->
                                            </div>
                                        </div>

                                        <div id='forregimenothers0' class="form-group dynamic-row regimenothers hidden">
                                            <div >
                                                <label class="col-md-3 control-label">Specify</label>
                                                <div class="col-md-8">
                                                    {!! Form::textarea("update[MO_MED_PRESCRIPTION][Specify][]", $pres_value->dosage_regimen_others, ['class' => 'form-control noresize', 'placeholder' => 'Specify others', 'rows'=>'3', $read]) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group dynamic-row">
                                            <?php $Duration_Intake = explode(" ", $pres_value->duration_of_intake); ?>
                                            <label class="col-md-3 control-label">Intake Frequency</label>
                                            <div class="col-md-5">
                                                {!! Form::text("update[MO_MED_PRESCRIPTION][Duration_Intake][]", $Duration_Intake[0], ['class' => 'form-control nonzero forreq', 'placeholder'=> 'Frequency', $read]) !!}
                                            </div>

                                            <div class="col-md-3">
                                                <?php if(isset($Duration_Intake[1])) {
                                                    $di = $Duration_Intake[1];
                                                } else {
                                                    $di = NULL;
                                                } ?>
                                                {!! Form::select("update[MO_MED_PRESCRIPTION][Duration_Intake_Freq][]",
                                                    array('' => 'Choose',
                                                        'D' => 'Days',
                                                        'M' => 'Months',
                                                        'Q' => 'Quarters',
                                                        'W' => 'Weeks',
                                                        'Y' => 'Years',
                                                        'O' => 'Others'), $di,
                                                 ['class' => 'form-control forreq', $read]) !!}
                                            </div>
                                        </div>

                                        <div class="form-group dynamic-row">
                                            <label class="col-md-3 control-label">Regimen Start &amp; End Date</label>
                                            <div class="col-md-8 has-feedback">
                                                <div class="input-group">
                                                  <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                  </div>
                                                  {!! Form::text("update[MO_MED_PRESCRIPTION][regimen_startend_date][]", date('m/d/Y', strtotime($pres_value->regimen_startdate)) .' - '. date('m/d/Y', strtotime($pres_value->regimen_enddate)), ['class' => 'form-control pull-right', 'id'=>'daterangepicker', $read]); !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group dynamic-row">
                                            <label class="col-md-3 control-label">Prescription Remarks</label>
                                            <div class="col-md-8">
                                                {!! Form::textarea("update[MO_MED_PRESCRIPTION][Remarks][]", $pres_value->prescription_remarks, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'rows'=>'3', $read]) !!}
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            @endif
                        <!--/Prescription-->
                        <!--Laboratory-->
                            @if(!empty($value->medical_order_lab_exam))
                                <?php $withlaboratory = 1; $fix = 0; ?>
                                    <div class="form-group dynamic-row form-add MO_LAB_TEST">
                                        {!! Form::hidden("update[MO_LAB_TEST][medicalorderlaboratoryexam_id][]", $value->medical_order_lab_exam[0]->medicalorderlaboratoryexam_id, ['class'=>'form-control']) !!}
                                        <legend style='font-size: 18px;'>Laboratory Test</legend>

                                        <div class="icheck row">
                                            <div class="col-md-12">
                                            <h4>Selected laboratory exams:</h4>
                                            </div>
                                            @foreach($lovlaboratories as $labs)
                                                <div class="col-md-4 checkbox">
                                                    <label>
                                                      <?php $selectd = ""; ?>
                                                      @foreach ($value->medical_order_lab_exam as $lab_key => $lab_value)
                                                        @if($lab_value->laboratory_test_type == $labs->laboratorycode)
                                                            <?php $selectd = "checked='checked'"; ?>
                                                        @endif
                                                      @endforeach
                                                      <input type="checkbox" name="update[MO_LAB_TEST][Examination_Code][]" value="{{ $labs->laboratorycode }}" {{ $selectd }} class="form-control" {{ $read }} /> {{ $labs->laboratorydescription }}

                                                    </label>
                                                  </div>
                                            @endforeach
                                        </div>
                                        <div class="form-group dynamic-row hidden">
                                            <label class="col-md-3 control-label">Specify Others</label>
                                            <div class="col-md-8">
                                                {!! Form::textarea("update[MO_LAB_TEST][others][]", $value->medical_order_lab_exam[0]->laboratory_test_type_others, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'rows'=>'3', $read]) !!}
                                            </div>
                                        </div>
                                    </div>
                            @endif
                        <!--/Laboratory-->

                        <!--Medical Procedure-->
                            @if(!empty($value->medical_order_procedure))
                                <?php $procedure_key = 0; $fix = 0; ?>
                                @foreach ($value->medical_order_procedure as $proc_key => $proc_value)
                                    <div class="form-group dynamic-row form-add MO_PROCEDURE">
                                        {!! Form::hidden("update[MO_PROCEDURE][medicalorderprocedure_id][]", $proc_value->medicalorderprocedure_id, ['class'=>'form-control']) !!}

                                        <legend>Medical Procedure</legend>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Procedure Order</label>
                                            <div class="col-md-8">
                                                <textarea id="procedure_input{{ $procedure_key }}" class="form-control procedure_input" rows="3" name="update[MO_PROCEDURE][Procedure_Order][]">{{ $proc_value->procedure_order }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Date of Procedure</label>
                                            <div class="col-md-8 has-feedback">
                                                <div class="input-group">
                                                  <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                  </div>
                                                  {!! Form::text("update[MO_PROCEDURE][Date_of_Procedure][]", date('m/d/Y', strtotime($proc_value->procedure_date)), ['class' => 'form-control', 'id'=>'datepicker_future', $read]); !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $procedure_key++ ?>
                                @endforeach
                            @endif
                        <!--/Medical Procedure-->
                        <!--Others-->
                            @if(!empty($value->medicalorder_others))
                                <?php $withothers = 0; $fix = 0; ?>
                                @if($value->medicalorder_type == 'MO_OTHERS')
                                    <div class="form-group dynamic-row form-add MO_OTHERS">
                                        <legend style='font-size: 18px;'>Other</legend>
                                        {!! Form::textarea("update[MO_OTHERS][order_type_others][]", $value->medicalorder_others, ['class' => 'form-control noresize', 'placeholder' => 'Specify others', 'rows'=>'3', $read]) !!}
                                    </div>
                                @endif
                            @endif
                        <!--/Others-->

                        <!-- Fix: accommodating old records from version 2.0 -->
                            @if($fix == 1 AND !empty($value->user_instructions))
                            <?php $fix = 0; ?>
                            <div class="form-group dynamic-row form-add">
                                <legend style='font-size: 18px;'>{{ getOrderTypeName($value->medicalorder_type) }}</legend>
                            </div>
                            @endif
                        <!-- version 2.0 fix -->
                    </div>
                    <div class="col-md-2">
                        <?php
                            $hid = "hidden";
                            if($key > 0) {
                                $hid = "";
                            }
                        ?>
                        @if(empty($disposition_record->disposition))
                        <button id="rmvbtn{{ $key }}" type="button" class="btn btn-danger {{ $hid }} rmvbtn"><i class="fa fa-times"></i> Remove</button>
                        @endif
                    </div>
                </div><!--/END DYNAMIC FORM GROUP-->

                <div class="form-group dynamic-row">
                    <label class="col-md-2 control-label">Doctor's Instructions</label>
                    <div class="col-md-8">
                        @if($key >= 0)
                            {!! Form::textarea("update[instructions][]", $value->user_instructions, ['class' => 'form-control noresize instructions', 'placeholder' => "Doctor's instructions for this medical order", 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                        @endif
                    </div>
                </div>
                <legend> </legend>
            </div>
        </div>

    @endforeach
    <?php $medorder = 1;
    $isnew = 'hidden'; ?>
@else
    <?php $isnew = ''; ?>
@endif
    <!-- basic medical order form for new inserts initially hidden -->
    <div class="dynamic-content hidden">
        <div>
            {!! Form::hidden("insert[type][]", null) !!}
            {!! Form::hidden("insert[medicalorder_id][]", null) !!}

            <!--DYNAMIC FORM GROUP-->
            <div class="form-group dynamic-row">
                <label class="col-md-2 control-label">Medical Management &amp; Orders</label>
                <div class="col-md-8 medical_order_form">
                    <!--Prescription-->
                        <div class="form-group dynamic-row form-add MO_MED_PRESCRIPTION hidden" >

                                <legend style='font-size: 18px;'>Prescription</legend>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Generic Name</label>
                                    <div class="col-md-8">
                                        {!! Form::text('insert[MO_MED_PRESCRIPTION][Drug_Code][]', null, ['class' => 'form-control drug_input', 'placeholder'=> 'Generic name', 'id'=>'drug_input', $read]) !!}
                                    </div>
                                </div>

                                <div class="form-group dynamic-row">
                                    <label class="col-md-3 control-label">Brand Name</label>
                                    <div class="col-md-8">
                                        {!! Form::text('insert[MO_MED_PRESCRIPTION][Drug_Brand_Name][]', null, ['class' => 'form-control', 'placeholder'=> 'Brand name', $read]) !!}
                                    </div>
                                </div>

                                <div class="form-group dynamic-row">
                                    <label class="col-md-3 control-label">Dose Quantity</label>
                                    <div class="col-md-5">
                                        {!! Form::text('insert[MO_MED_PRESCRIPTION][Dose_Qty][]', null, ['class' => 'form-control decimal forreq', 'placeholder'=> 'Dosage', $read]) !!}
                                    </div>

                                    <div class="col-md-3">
                                        {!! Form::select('insert[MO_MED_PRESCRIPTION][Dose_UOM][]',
                                            array('' => 'Choose',
                                            'drops' => 'drops',
                                            'mg' => 'mg',
                                            'ml' => 'ml',
                                            'mcg' => 'mcg',
                                            'mec' => 'mec',
                                            'units' => 'units',
                                            'other' => 'other'), '',
                                         ['class' => 'form-control forreq', $read]) !!}
                                    </div>
                                </div>

                                <div class="form-group dynamic-row">
                                    <label class="col-md-3 control-label">Total Quantity</label>
                                    <div class="col-md-5">
                                        {!! Form::text('insert[MO_MED_PRESCRIPTION][Total_Quantity][]', null, ['class' => 'form-control nonzero forreq', 'placeholder'=> 'Quantity', $read]) !!}
                                    </div>

                                    <div class="col-md-3">
                                        {!! Form::select('insert[MO_MED_PRESCRIPTION][Total_Quantity_UOM][]',
                                            array('' => 'Choose',
                                                'Tablets' => 'Tablets',
                                                'Capsules' => 'Capsules',
                                                'Bottles' => 'Bottles',
                                                'Others' => 'Others'), '',
                                         ['class' => 'form-control forreq', $read]) !!}
                                    </div>
                                </div>

                                <div class="form-group dynamic-row">
                                    <label class="col-md-3 control-label">Dosage Regimen </label>
                                    <div class="col-md-8">
                                        {!! Form::select('insert[MO_MED_PRESCRIPTION][dosage][]',
                                            array('' => 'Choose',
                                                'OD' => 'Once a day',
                                                'BID' => '2 x a day - Every 12 hours',
                                                'TID' => '3 x a day - Every 8 hours',
                                                'QID' => '4 x a day - Every 6 hours',
                                                'QOD' => 'Every other day',
                                                'QHS' => 'Every bedtime',
                                                'OTH' => 'Others'), '',
                                         ['class' => 'forother form-control forreq', 'id'=>'regimenothers0', $read]) !!}
                                    </div>
                                </div>

                                <div id='forregimenothers0' class="form-group dynamic-row regimenothers hidden">
                                    <div >
                                        <label class="col-md-3 control-label">Specify</label>
                                        <div class="col-md-8">
                                            {!! Form::textarea('insert[MO_MED_PRESCRIPTION][Specify][]', null, ['class' => 'form-control noresize', 'placeholder' => 'Specify others', 'rows'=>'3', $read]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group dynamic-row">
                                    <label class="col-md-3 control-label">Intake Frequency</label>
                                    <div class="col-md-5">
                                        {!! Form::text('insert[MO_MED_PRESCRIPTION][Duration_Intake][]', null, ['class' => 'form-control nonzero forreq', 'placeholder'=> 'Frequency', $read]) !!}
                                    </div>

                                    <div class="col-md-3">
                                        {!! Form::select('insert[MO_MED_PRESCRIPTION][Duration_Intake_Freq][]',
                                            array('' => 'Choose',
                                                'D' => 'Days',
                                                'M' => 'Months',
                                                'Q' => 'Quarters',
                                                'W' => 'Weeks',
                                                'Y' => 'Years',
                                                'O' => 'Others'), '',
                                         ['class' => 'form-control forreq', $read]) !!}
                                    </div>
                                </div>

                                <div class="form-group dynamic-row">
                                    <label class="col-md-3 control-label">Regimen Start &amp; End Date</label>
                                    <div class="col-md-8 has-feedback">
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          {!! Form::text('insert[MO_MED_PRESCRIPTION][regimen_startend_date][]', null, ['class' => 'form-control pull-right', 'id'=>'daterangepicker', $read]); !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group dynamic-row">
                                    <label class="col-md-3 control-label">Prescription Remarks</label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('insert[MO_MED_PRESCRIPTION][Remarks][]', null, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'rows'=>'3', $read]) !!}
                                    </div>
                                </div>

                            </div>
                    <!--/Prescription-->
                    <!--Laboratory-->
                        <div class="form-group dynamic-row form-add MO_LAB_TEST hidden" >
                                {!! Form::hidden("insert[MO_LAB_TEST][medicalorderlaboratoryexam_id][]", null) !!}
                                <legend style='font-size: 18px;'>Laboratory Test</legend>
                                <div class="icheck row">
                                    <div class="col-md-12">
                                    <h4>Choose all the laboratory exams you require.</h4>
                                    </div>
                                    @foreach($lovlaboratories as $labs)
                                        <div class="col-md-4 checkbox">
                                            <label>
                                              <input type="checkbox" name="insert[MO_LAB_TEST][Examination_Code][]" value="{{ $labs->laboratorycode }}" class="form-control" {{ $read }} /> {{ $labs->laboratorydescription }}
                                            </label>
                                          </div>
                                    @endforeach
                                </div>
                                <div class="form-group dynamic-row hidden">
                                    <label class="col-md-3 control-label">Specify Others</label>
                                    <div class="col-md-8">
                                        {!! Form::textarea('insert[MO_LAB_TEST][others][]', null, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'rows'=>'5', $read]) !!}
                                    </div>
                                </div>
                            </div>
                    <!--/Laboratory-->
                    <!--Medical Procedure-->
                        <?php $proc_key = 0; ?>
                        <div class="form-group dynamic-row form-add MO_PROCEDURE hidden" >
                            <legend>Medical Procedure</legend>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Procedure Order</label>
                                <div class="col-md-8">
                                    <textarea id="procedure_input{{ $proc_key }}" class="form-control procedure_input" rows="3" name="insert[MO_PROCEDURE][Procedure_Order][]"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Date of Procedure</label>
                                <div class="col-md-8 has-feedback">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      {!! Form::text('insert[MO_PROCEDURE][Date_of_Procedure][]', '$procedures', ['class' => 'form-control', 'id'=>'datepicker_future', $read]); !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--/Medical Procedure-->
                    <!--Others-->
                        <div class="form-group dynamic-row form-add MO_OTHERS hidden" >
                                <legend style='font-size: 18px;'>Other</legend>
                                {!! Form::textarea('insert[MO_OTHERS][order_type_others][]', null, ['class' => 'form-control noresize', 'placeholder' => 'Specify others', 'rows'=>'3', $read]) !!}
                            </div>
                    <!--/Others-->

                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger hidden rmvbtn"><i class="fa fa-times"></i> Remove</button>
                </div>
            </div><!--/END DYNAMIC FORM GROUP-->

            <div class="form-group dynamic-row">
                <label class="col-md-2 control-label">Doctor's Instructions</label>
                <div class="col-md-8">
                    {!! Form::textarea("insert[instructions][]", null, ['class' => 'form-control noresize instructions', 'placeholder' => "Doctor's instructions for this medical order", 'rows'=>'3', 'style' => 'margin: 0px; width: 100%; height: 112px;', $read]) !!}
                </div>
            </div>
            <legend> </legend>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @if($withprescription == 1)
                <a class="btn btn-success" href="{{ url('healthcareservices/medorder/print/prescription/'.$healthcareserviceid) }}" target="_blank">Print Prescription</a>
            @endif
            @if($withlaboratory == 1)
                <a class="btn btn-success" href="{{ url('healthcareservices/medorder/print/laboratory/'.$healthcareserviceid) }}" target="_blank">Print Lab Order</a>
            @endif
        </div>
        <div class="col-md-6">
            @if(empty($disposition_record->disposition))
            <button type="submit" class="btn btn-primary pull-right">Save Medical Orders</button>
            @endif
        </div>
    </div>


</fieldset>
{!! Form::close() !!}


@section('linked_scripts')

<script>
    //setup autocomplete for Procedures
    var availableProcedures = [
        <?php foreach($lovMedicalProcedure as $key => $procedure) { ?>
        "<?php echo $procedure?>",
        <?php } ?>
    ];
</script>

<!--Put page related scripts here-->
<script type="text/javascript">
$(".select2").select2({
    'disabled': 'disabled'
});
</script>

@stop
