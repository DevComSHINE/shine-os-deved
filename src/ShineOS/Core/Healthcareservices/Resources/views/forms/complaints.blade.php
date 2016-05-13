@if (isset($complaints_record))
    {!! Form::model($complaints_record, array('route' => 'complaints.edit')) !!}
    {!! Form::hidden('generalconsultation_id', $complaints_record->generalconsultation_id) !!}
@else
    {!! Form::open(array('route' => 'complaints.insert')) !!}
@endif

{!! Form::hidden('healthcareservice_id', $healthcareserviceid) !!}

<?php
if(empty($disposition_record->disposition)) { $read = NULL; }
else { $read = 'disabled'; }
?>

<legend>Patient Complaints</legend>
<fieldset {{$disabled}}>
    <div class="form-group">
        <label class="col-md-2 control-label">Complaint*</label>
        <div class="col-md-10">
            {!! Form::textarea('complaint', null, ['class' => 'form-control required noresize', 'placeholder' => 'Complaint', 'cols'=>'10', 'rows'=>'5', $read]) !!}
        </div>
    </div>
</fieldset>
<fieldset {{$disabled}}>
    <div class="form-group">
        <label class="col-md-2 control-label">Complaint History</label>
        <div class="col-md-10">
            {!! Form::textarea('complaint_history', null, ['class' => 'form-control noresize', 'placeholder' => 'Illness history', 'cols'=>'10', 'rows'=>'5', $read]) !!}
        </div>
    </div>
</fieldset>

<fieldset {{$disabled}}>
    <div class="form-group">
        <label class="col-md-2 control-label">Triage</label>
        <div class="col-md-10">
            <?php
                $mc = $medicalCategory->lists('medicalcategory_name', 'medicalcategory_id');
                $mc[0] = "-- Choose Medical Category --";
                $m = $mc->sort();
                $m->values()->all();

            ?>
            @if (isset($complaints_record->medicalcategory_id) AND $complaints_record->medicalcategory_id>0)
                {!! Form::hidden('medical_category', $complaints_record->medicalcategory_id) !!}
                @foreach($medicalCategory as $keyC => $valueC)
                    @if($complaints_record->medicalcategory_id == $valueC->medicalcategory_id)
                        <?php $categoryTitle = $valueC->medicalcategory_name; ?>
                    @endif
                @endforeach
                {!! Form::text(NULL, $categoryTitle, ['class' => 'form-control', 'readonly'=>'readonly']); !!}
            @else
                {!! Form::select('medical_category', $m, '', ['class' => 'form-control', $read]) !!}
            @endif
        </div>
    </div>
</fieldset>
<fieldset {{$disabled}}>
    <div class="form-group">
        <label class="col-md-2 control-label">Remarks</label>
        <div class="col-md-10">
            {!! Form::textarea('remarks', null, ['class' => 'form-control noresize', 'placeholder' => 'Remarks', 'cols'=>'10', 'rows'=>'5', $read]) !!}
        </div>
    </div>
</fieldset>

@if(empty($disposition_record->disposition))
<fieldset {{$disabled}}>
    <div class="form-group">
        <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary pull-right">Save Complaints</button>
            </div>
        </div>
    </div>
</fieldset>
@endif
{!! Form::close() !!}
