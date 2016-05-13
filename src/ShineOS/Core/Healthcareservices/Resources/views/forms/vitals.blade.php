@if (isset($vitals_record))
    {!! Form::model($vitals_record, array('route' => 'vitals.edit')) !!}
    <?php $vitals = $vitals_record; ?>
@else
    {!! Form::open(array('route' => 'vitals.insert')) !!}
@endif

    {!! Form::hidden('vitalphysical_id', null) !!}
    {!! Form::hidden('healthcareservice_id', $healthcareserviceid) !!}
    {!! Form::hidden('bmi', '') !!}

<?php
//dd($patient->birthdate);
if(empty($disposition_record->disposition)) { $read = ''; }
else { $read = 'disabled'; }
//let us get the age of the patient
$age = getAge($patient->birthdate);
$required = "required";
if($age <= 14) {
    $required = "";
}
?>
<div class="icheck">
    <fieldset {{ $disabled }}>
        <legend>Vital Signs</legend>
        <div class="">
            <label class="col-sm-2 control-label">Temperature &deg;C</label>
            <label class="col-sm-4 control-label"> Blood Pressure <small> (Systolic / Diastolic) </small></label>
            <label class="col-sm-2 control-label">Heart Rate <small>(bpm)</small> </label>
            <label class="col-sm-2 control-label">Pulse Rate <small>(bpm)</small> </label>
            <label class="col-sm-2 control-label">Respiratory Rate <small>(bpm)</small> </label>
        </div>
        <div class="row">
          <div class="col-md-2">
            {!! Form::text('temperature', (isset($vitals->temperature) ? (($vitals->temperature) ? $vitals->temperature : '') : ''), ['class' => 'form-control required', 'step' => 'any', 'placeholder'=>'Temperature', $read, 'required'=>'required']) !!}
          </div>
          <div class="col-md-2">
            {!! Form::text('bloodpressure_systolic', (isset($vitals->bloodpressure_systolic) ? (($vitals->bloodpressure_systolic) ? $vitals->bloodpressure_systolic : '') : ''), ['class' => 'form-control '.$required, 'placeholder'=> 'Systolic', $read, $required]) !!}
          </div>
          <div class="col-md-2">
            {!! Form::text('bloodpressure_diastolic', (isset($vitals->bloodpressure_diastolic) ? (($vitals->bloodpressure_diastolic) ? $vitals->bloodpressure_diastolic : '') : ''), ['class' => 'form-control '.$required, 'placeholder'=> 'Diastolic', $read, $required]) !!}
          </div>
          <div class="col-md-2">
            {!! Form::text('heart_rate', (isset($vitals->heart_rate) ? (($vitals->heart_rate) ? $vitals->heart_rate : '') : ''), ['class' => 'form-control', 'placeholder'=>'Heart rate', $read]) !!}
          </div>
          <div class="col-md-2">
            {!! Form::text('pulse_rate', (isset($vitals->pulse_rate) ? (($vitals->pulse_rate) ? $vitals->pulse_rate : '') : ''), ['class' => 'form-control', 'placeholder'=>'Pulse rate', $read]) !!}
          </div>
          <div class="col-md-2">
            {!! Form::text('respiratory_rate', (isset($vitals->respiratory_rate) ? (($vitals->respiratory_rate) ? $vitals->respiratory_rate : '') : ''), ['class' => 'form-control', 'placeholder'=>'Respiratory rate', $read]) !!}
          </div>
        </div>
    </fieldset>
    <fieldset {{ $disabled }}>
        <legend>Anthropometrics</legend>
        <div class="form-group bmigroup">
            <div class="">
                <label class="col-sm-2 control-label">Height <small>(cm)</small></label>
                <label class="col-sm-2 control-label">Weight <small>(kgs)</small></label>
                <label class="col-sm-2 control-label">Waist <small>(cm)</small></label>
                <label class="col-sm-1 control-label">BMI</label>
                <label class="col-sm-5 control-label">Weight Status</label>
            </div>
            <div class="row">
                <div class="col-md-2">
                    {!! Form::text('height', (isset($vitals->height) ? (($vitals->height) ? $vitals->height : '') : ''), ['class' => 'form-control', 'placeholder'=> 'Height', 'name'=>'height', 'id'=>'height', $read]) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('weight', (isset($vitals->weight) ? (($vitals->weight) ? $vitals->weight : '') : ''), ['class' => 'form-control', 'placeholder'=> 'Weight', 'name'=>'weight', 'id'=>'weight', $read]) !!}
                </div>
                <div class="col-md-2">
                    {!! Form::text('waist', (isset($vitals->waist) ? (($vitals->waist) ? $vitals->waist : '') : ''), ['class' => 'form-control', 'placeholder'=> 'Waist', $read]) !!}
                </div>
                <div class="col-md-1">
                    <p class="bmiResult"></p>
                </div>
                <div class="col-md-5 weightStat">
                    <p class="control-label">Complete Weight and Height to get patient BMI.</p>
                </div>
            </div>
        </div>

        @if ($gender == 'female' || $gender == 'f' || $gender == 'F')
        <legend>Female Condition</legend>
        <div class="form-group">
            <div class="row">

                <dl class="col-sm-3 control-label">
                    <dt class="col-sm-7"> <label class="control-label">Pregnant</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                            {!! Form::checkbox("Pregnant", 1, (isset($vitals->pregnant) ? (($vitals->pregnant==1) ? true : '') : ''), [$read]); !!} Yes
                        </label>

                    </dd>
                </dl>
                <dl class="col-sm-3 control-label">
                    <dt class="col-sm-7"> <label class="control-label">Weight Loss</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox('WeightLoss', 1, (isset($vitals->weight_loss) ? (($vitals->weight_loss==1) ? true : '') : ''), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>
                <dl class="col-sm-4 control-label">
                    <dt class="col-sm-7"> <label class="control-label">With Intact Uterus</label> </dt>
                    <dd class="btn-group col-sm-5">
                        <label>
                                {!! Form::checkbox('WithIntactUterus', 1, (isset($vitals->with_intact_uterus) ? (($vitals->with_intact_uterus==1) ? true : '') : ''), [$read]); !!} Yes
                            </label>
                    </dd>
                </dl>



            </div>
        </div>
        @endif
    </fieldset>

    <fieldset {{$disabled}}>
        <legend>Physical Examination</legend>
        <div class="row">
            <div class="col-md-8">
                <table class="table table-condensed">
                    <tr>
                        <td width="23%"></td>
                        <td><strong>Abnormal Findings</strong> | <em>Leaving this blank means item is normal.</em></td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Head &amp; Neck</label></td>
                        <td>{!! Form::text('Head_abnormal', (isset($vitals->Head_abnormal) ? (($vitals->Head_abnormal) ? $vitals->Head_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Eyes</label></td>
                        <td>{!! Form::text('Eyes_abnormal', (isset($vitals->Eyes_abnormal) ? (($vitals->Eyes_abnormal) ? $vitals->Eyes_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">ENT</label></td>
                        <td>{!! Form::text('Ent_abnormal', (isset($vitals->Ent_abnormal) ? (($vitals->Ent_abnormal) ? $vitals->Ent_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Cardiovascular</label></td>
                        <td>{!! Form::text('Cardiovascular_abnormal', (isset($vitals->Cardiovascular_abnormal) ? (($vitals->Cardiovascular_abnormal) ? $vitals->Cardiovascular_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Breasts and Axillae</label></td>
                        <td>{!! Form::text('Breasts_abnormal', (isset($vitals->Breasts_abnormal) ? (($vitals->Breasts_abnormal) ? $vitals->Breasts_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Chest and Lungs</label></td>
                        <td>{!! Form::text('Chest_abnormal', (isset($vitals->Chest_abnormal) ? (($vitals->Chest_abnormal) ? $vitals->Chest_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Back and Spine</label></td>
                        <td>{!! Form::text('Back_abnormal', (isset($vitals->Back_abnormal) ? (($vitals->Back_abnormal) ? $vitals->Back_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Abdomen</label></td>
                        <td>{!! Form::text('Abdomen_abnormal', (isset($vitals->Abdomen_abnormal) ? (($vitals->Abdomen_abnormal) ? $vitals->Abdomen_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Pelvis/ GU Tract</label></td>
                        <td>{!! Form::text('Pelvis_abnormal', (isset($vitals->Pelvis_abnormal) ? (($vitals->Pelvis_abnormal) ? $vitals->Pelvis_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Rectal</label></td>
                        <td>{!! Form::text('Rectal_abnormal', (isset($vitals->Rectal_abnormal) ? (($vitals->Rectal_abnormal) ? $vitals->Rectal_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Upper Extremitie</label></td>
                        <td>{!! Form::text('Upper_Extremities_abnormal', (isset($vitals->Upper_Extremities_abnormal) ? (($vitals->Upper_Extremities_abnormal) ? $vitals->Upper_Extremities_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Lower Extremities</label></td>
                        <td>{!! Form::text('Lower_Extremities_abnormal', (isset($vitals->Lower_Extremities_abnormal) ? (($vitals->Lower_Extremities_abnormal) ? $vitals->Lower_Extremities_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Integumentary</label></td>
                        <td>{!! Form::text('Integumentary_abnormal', (isset($vitals->Integumentary_abnormal) ? (($vitals->Integumentary_abnormal) ? $vitals->Integumentary_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Skin</label></td>
                        <td>{!! Form::text('Skin_abnormal', (isset($vitals->Skin_abnormal) ? (($vitals->Skin_abnormal) ? $vitals->Skin_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Nails</label></td>
                        <td>{!! Form::text('Nails_abnormal', (isset($vitals->Nails_abnormal) ? (($vitals->Nails_abnormal) ? $vitals->Nails_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                    <tr>
                        <td><label class="control-label noPaddingMargin">Hair & Scalp</label></td>
                        <td>{!! Form::text('Hair_abnormal', (isset($vitals->Hair_abnormal) ? (($vitals->Hair_abnormal) ? $vitals->Hair_abnormal : '') : ''), ['class' => 'form-control noMargin', $read]) !!}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <!-- Put human image here -->
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">Physical Examination Remarks</label>
            <div class="col-md-10">
                {!! Form::textarea('physical_examination', null, ['class' => 'form-control noresize', 'placeholder' => 'Physical Examination', 'cols'=>'10', 'rows'=>'5', $read]) !!}
            </div>
        </div>
    </fieldset>

    @if(empty($disposition_record->disposition))
    <fieldset {{ $disabled }}>
        <div class="form-group">
            <div class="col-md-12">
                <div class="row">
                    <button type="submit" class="btn btn-primary pull-right">Save Vitals</button>
                </div>
            </div>
        </div>
    </fieldset>
    @endif
</div>
{!! Form::close() !!}
