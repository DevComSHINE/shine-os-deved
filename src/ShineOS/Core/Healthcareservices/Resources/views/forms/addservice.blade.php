<?php

if(empty($disposition_record->disposition)) { $read = NULL; }
else { $read = 'disabled'; }

if(!$healthcareData):
    $disabled = "";
else:
    $disabled = "";
endif;
?>

<fieldset class="tab-pane" id="tab_1">
    <legend>Consultation</legend>
    <fieldset {{ $disabled }}>
        <div class="col-sm-12">
            <label class="col-sm-2 control-label">Encounter DateTime</label>
            <div class="col-sm-2">
                <div class="input-group">
                    <i class="fa fa-calendar inner-icon"></i>
                    <?php
                        if(empty($healthcareData) OR isset($prevhealthcareData)) {
                            $date = getCurrentDate('m/d/Y');
                        } else {
                            $date = date('m/d/Y', strtotime($healthcareData->encounter_datetime));
                        }
                    ?>
                    {!! Form::text('e-date', $date, ['class' => 'form-control datepicker', 'readonly' => 'readonly',  $read]); !!}
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <div class="iconed-input bootstrap-timepicker">
                    <i class="fa fa-clock-o inner-icon"></i>
                    <?php
                        if(empty($healthcareData) OR isset($prevhealthcareData)) {
                            $time = date( 'h:i A', strtotime(getMysqlDate()) );
                        } else {
                            $time = date('h:i A', strtotime($healthcareData->encounter_datetime));
                        }
                    ?>
                    {!! Form::text('e-time', $time, ['class' => 'form-control', 'id'=>'timepicker', 'readonly' => 'readonly', $read]); !!}
                    </div>
                </div>
            </div>
            <label class="col-md-2 control-label"> Healthcare Service</label>
            <div class="col-md-4">
                <?php $hidden = "hidden"; //hide medical category first ?>
                @if (!$healthcareData)
                    {!! Form::select('healthcare_services', $healthcareservices, '',
                        ['class' => 'required form-control ui-wizard-content valid', 'id'=> 'healthcare_services', 'required'=>'required']) !!}
                @else
                    <?php
                        $hidden = ""; //show medical category
                        $serviceTitle = NULL;
                    ?>
                    {!! Form::hidden('healthcare_services', $healthcareData->healthcareservicetype_id) !!}
                    {!! Form::text(NULL, getHealthcareServiceName($healthcareData->healthcareservicetype_id) , ['class' => 'form-control', 'readonly'=>'readonly']); !!}

                @endif

            </div>
        </div>
    </fieldset>
    <fieldset {{ $disabled }}>
        <div class="col-sm-12">
            <div id="consultation_type">

                        @if($healthcareType!='FOLLO')
                <label class="col-md-2 control-label">Consultation Type</label>
                <div class="col-md-4">
                    <div class="btn-group toggler" data-toggle="buttons">
                        <label id="consuTypeNewAdmit" class="btn btn-default required @if($healthcareType=='ADMIN') active @endif {{$read}}">
                            <i class="fa fa-check"></i> {!! Form::radio('consultationtype_id', 'ADMIN', ''); !!} New Admission
                        </label>
                        <label id="consuTypeNewConsu" class="btn btn-default required @if($healthcareType=='CONSU') active @endif {{$read}}">
                            <?php
                                $cchk = "";
                                if($healthcareType=='CONSU') $cchk = "checked";
                            ?>
                            <i class="fa fa-check"></i> {!! Form::radio('consultationtype_id', 'CONSU', $cchk); !!} New Consultation
                        </label>
                    </div>
                </div>
                        @endif

                        @if($healthcareType=='FOLLO')
                <label class="col-md-2 control-label">Consultation & Encounter</label>
                <div class="col-md-4">
                    <div class="btn-group toggler" data-toggle="buttons">
                        <label id="consuTypeFollow" class="btn btn-default required active {{$read}}">
                            <i class="fa fa-check"></i> {!! Form::radio('consultationtype_id', 'FOLLO', 'checked'); !!} Follow-up
                        </label>
                    </div>
                    <div class="btn-group toggler" data-toggle="buttons">
                        <label id="outPatient" class="btn btn-default required active {{$read}}">
                            <i class="fa fa-check"></i> {!! Form::radio('encounter_type', 'O', 'checked'); !!} Out Patient
                        </label>
                    </div>
                </div>
                        @endif


                @if($healthcareType!='FOLLO')
                <label class="col-md-2 control-label">Encounter Type</label>
                <div class="col-md-4">
                    <div class="btn-group toggler" data-toggle="buttons">
                        <label id="inPatient" class="btn btn-default disabled @if(!empty($healthcareData)) @if($healthcareData->encounter_type=='I') active @endif @endif {{$read}}">
                            <i class="fa fa-check"></i> {!! Form::radio('encounter_type', 'I', '') !!} In Patient
                        </label>
                        <label id="outPatient" class="btn btn-default disabled @if(!empty($healthcareData)) @if($healthcareData->encounter_type=='O') active @endif @else @if($healthcareType=='CONSU') active @endif @endif {{$read}}">
                            <?php
                                $chk = "";
                                if($healthcareType=='CONSU') $chk = "checked";
                                if($healthcareType=='FOLLO') $chk = "checked";
                            ?>
                            <i class="fa fa-check"></i> {!! Form::radio('encounter_type', 'O', $chk) !!} Out Patient
                        </label>
                    </div>
                </div>
                @endif
                <?php /*if($healthcareType=='FOLLO')
                <label class="col-md-2 control-label">Disease Type</label>
                <div class="col-md-4">
                    {!! Form::select('healthcare_subservices', $subform, '',
                        ['class' => 'required form-control ui-wizard-content valid', 'id'=> 'healthcare_subform', 'required'=>'required']) !!}
                </div>
                @endif*/ ?>
            </div>
        </div>
    </fieldset>

</fieldset><!-- /.tab-pane -->

@if(empty($healthcareserviceid))
<fieldset>
    <div class="form-group">
        <div class="col-md-12">
            <div class="row">
                <a href="{{ url('records#visit_list') }}" class="btn btn-default pull-right sideMargin">Cancel</a>
                @if (!$follow_healthcareserviceid)
                    @if(!$healthcareData)
                    <button type="submit" class="btn btn-primary pull-right">Create Health Record</button>
                    @endif
                @else
                    <button type="submit" class="btn btn-primary pull-right">Create Follow Up</button>
                @endif

            </div>
        </div>
    </div>
</fieldset>
@endif
