@if (isset($disposition_record))
    {!! Form::model($disposition_record, array('route' => 'disposition.edit')) !!}
@else
    {!! Form::open(array('route' => 'disposition.insert')) !!}
@endif

{!! Form::hidden('hservices_id', $healthcareserviceid) !!}
{!! Form::hidden('disposition_id', null) !!}
<?php
if(empty($disposition_record->disposition)) { $read = ''; }
else { $read = 'disabled'; }
?>

<fieldset {{$disabled}}>
    <legend>Disposition &amp; Discharge</legend>
        <label class="col-md-2 control-label">Disposition</label>
        <div class="col-sm-8">
            <div class="btn-group toggler" data-toggle="buttons">
              <label class="btn btn-default @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'ADMDX') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="disposition" id="" autocomplete="off" value="ADMDX" @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'ADMDX') checked='checked' @endif> Admitted
              </label>
              <label class="btn btn-default @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'HOME') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="disposition" id="" autocomplete="off" value="HOME" @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'HOME') checked='checked' @endif> Sent Home
              </label>
              <label class="btn btn-default @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'ABS') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="disposition" id="" autocomplete="off" value="ABS" @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'ABS') checked='checked' @endif> Absconded
              </label>
              <label class="btn btn-default @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'HAMA') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="disposition" id="" autocomplete="off" value="HAMA" @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'HAMA') checked='checked' @endif> Home Against Medical Advise
              </label>
              <label class="btn btn-default @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'REFER') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="disposition" id="" autocomplete="off" value="REFER" @if(isset($disposition_record->disposition) AND $disposition_record->disposition == 'REFER') checked='checked' @endif> Referred
              </label>
            </div>
        </div>
</fieldset>
<fieldset {{$disabled}}>
    <label class="col-md-2 control-label">Discharge Condition</label>
    <div class="col-sm-8">
            <div class="btn-group toggler" data-toggle="buttons">
              <label class="btn btn-default @if(isset($disposition_record->discharge_condition) AND $disposition_record->discharge_condition == 'IMPRO') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="discharge_condition" id="" autocomplete="off" value="IMPRO" @if(isset($disposition_record->discharge_condition) AND $disposition_record->discharge_condition == 'IMPRO') checked='checked' @endif> Improved
              </label>
              <label class="btn btn-default @if(isset($disposition_record->discharge_condition) AND $disposition_record->discharge_condition == 'RECOV') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="discharge_condition" id="" autocomplete="off" value="RECOV" @if(isset($disposition_record->discharge_condition) AND $disposition_record->discharge_condition == 'RECOV') checked='checked' @endif> Recovered
              </label>
              <label class="btn btn-default @if(isset($disposition_record->discharge_condition) AND $disposition_record->discharge_condition == 'UNIMP') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="discharge_condition" id="" autocomplete="off" value="UNIMP" @if(isset($disposition_record->discharge_condition) AND $disposition_record->discharge_condition == 'UNIMP') checked='checked' @endif> Unimproved
              </label>
              <label class="btn btn-default @if( isset($disposition_record->discharge_condition) AND $disposition_record->discharge_condition == 'UNKNW') active @endif {{$read}}">
                <i class="fa fa-check"></i> <input type="radio" name="discharge_condition" id="" autocomplete="off" value="UNKNW" @if(isset($disposition_record->discharge_condition) AND $disposition_record->discharge_condition == 'UNKNW') checked='checked' @endif> Unknown
              </label>
            </div>
        </div>
</fieldset>

<fieldset {{$disabled}}>
    <label class="col-sm-2 control-label">Discharge Date/Time</label>
    <div class="col-sm-3">
        <div class="input-group">
            <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
            </div>
            {!! Form::text('date', (empty($disposition_record) ? getCurrentDate('m/d/Y') : date('m/d/Y', strtotime($disposition_record->discharge_datetime))), ['class' => 'form-control', 'id'=>'datepicker', $read]); !!}
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
            <div class="input-group bootstrap-timepicker">
            {!! Form::text('time', (empty($disposition_record) ? getCurrentDate('h:i A') : date('h:i A', strtotime($disposition_record->discharge_datetime))), ['class' => 'form-control', 'id'=>'timepicker', $read]); !!}
                <div class="input-group-addon">
                <i class="fa fa-clock-o"></i>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<fieldset {{$disabled}}>
    <label class="col-md-2 control-label">Notes</label>
    <div class="col-md-8 ui-widget">
        {!! Form::textarea('discharge_notes', null, ['class' => 'form-control noresize', 'placeholder' => 'Discharge Note', 'cols'=>'10', 'rows'=>'5', $read]) !!}
    </div>
</fieldset>

@if(empty($disposition_record->disposition))
<fieldset {{$disabled}}>
    <div class="form-group">
        <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary pull-right">Save Disposition</button>
            </div>
        </div>
    </div>
</fieldset>
@endif
{!! Form::close() !!}
