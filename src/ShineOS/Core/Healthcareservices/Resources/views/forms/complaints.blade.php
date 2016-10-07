@if (isset($complaints_record))
    {!! Form::hidden('complaints[generalconsultation_id]', $complaints_record->generalconsultation_id) !!}
@endif

<?php
if(empty($disposition_record->disposition)) { $read = NULL; }
else { $read = 'disabled'; }
?>

<legend>Patient Complaints</legend>
<fieldset {{$disabled}}>
    <div class="form-group">
        <label class="col-md-2 control-label">Complaint*</label>
        <div class="col-md-10">
            {!! Form::textarea('complaints[complaint]', isset($complaints_record) ? $complaints_record->complaint : null, ['class' => 'form-control required noresize', 'required'=>'required', 'placeholder' => 'Complaint', 'cols'=>'10', 'rows'=>'5', $read]) !!}
        </div>
    </div>
</fieldset>
<?php
    $mc = $medicalCategory->lists('medicalcategory_name', 'medicalcategory_id');
    $mc[""] = "-- Choose Medical Category --";
    $m = $mc->sort();
    $m->values()->all();
?>
@if($m->count() > 1)
<fieldset {{$disabled}}>
    <div class="form-group">
        <label class="col-md-2 control-label">Clinical Triage</label>
        <div class="col-md-10">
            @if (isset($complaints_record->medicalcategory_id) AND $complaints_record->medicalcategory_id>0)
                {!! Form::hidden('complaints[medical_category]', isset($complaints_record) ? $complaints_record->medicalcategory_id : null) !!}
                @foreach($medicalCategory as $keyC => $valueC)
                    @if($complaints_record->medicalcategory_id == $valueC->medicalcategory_id)
                        <?php $categoryTitle = $valueC->medicalcategory_name; ?>
                    @endif
                @endforeach
                {!! Form::text(NULL, $categoryTitle, ['class' => 'form-control', 'readonly'=>'readonly']); !!}
            @else
                {!! Form::select('complaints[medical_category]', $m, '', ['class' => 'form-control required', 'required'=>'required', $read]) !!}
            @endif
        </div>
    </div>
</fieldset>
@endif
<fieldset {{$disabled}}>
    <div class="form-group">
        <label class="col-md-2 control-label">Complaint History</label>
        <div class="col-md-10">
            <?php
            //dd($complaints_record, $prevhealth);
                $complainthistory = NULL;
                if(isset($complaints_record)) {
                    $complainthistory = $complaints_record->complaint_history;
                }
                if(isset($prevhealth[0]) AND isset($prevhealth[0]->complaint)) {
                    $complainthistory = "[Complaint from previous consultation last: ".date('M. d, Y', strtotime($prevhealth[0]->encounter_datetime))."]\n".$prevhealth[0]->complaint;
                }
            ?>
            {!! Form::textarea('complaints[complaint_history]', $complainthistory, ['class' => 'form-control noresize', 'placeholder' => 'Illness history', 'cols'=>'10', 'rows'=>'5', $read]) !!}
        </div>
    </div>
</fieldset>


<fieldset {{$disabled}}>
    <div class="form-group">
        <label class="col-md-2 control-label">Remarks</label>
        <div class="col-md-10">
            {!! Form::textarea('complaints[remarks]', isset($complaints_record) ? $complaints_record->remarks : null, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'cols'=>'10', 'rows'=>'5', $read]) !!}
        </div>
    </div>
</fieldset>

<br clear="all" />
