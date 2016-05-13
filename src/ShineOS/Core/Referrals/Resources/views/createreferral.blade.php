@extends('referrals::layouts.masterfull')

@section('referral-content')
<div>
<div class="col-md-12 icheck">
    <div class="box box-primary">
    <div class="box-header with-border">
    <h3 class="box-title">Create Referral</h3>
    </div><!-- /.box-header -->
    {!! Form::open(array( 'url'=>'referrals/add',
                                'id'=>'referrals',
                                'name'=>'referrals'
                            )) !!}
    <div class="box-body">

        <!-- Select Facilities -->
        <div class="modal fade" id="selectFacilities" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Choose a facility </h4>
              </div>
              <div class="modal-body">
                    <!-- Search by Specialization
                    <select name='facilitySpecialization' class="form-control">

                    </select>
                    Search by Services
                    <select name='facilityServices' class="form-control">

                    </select>
                    Search by Equipment
                    <select name='facilityEquipment' class="form-control">

                    </select> -->
                    @if($facilities)
                  <?php //dd($facilities[1]); ?>
                    <div id="provider_lister" class="provider_lister_box select2-container--default">
                        @foreach($facilities as $key => $value)
                            <?php //dd($value); ?>
                            @if($value->facilityContact AND $value->flag_allow_referral == 1)
                            <div class="checkbox ">
                                <label>
                                    <input type="checkbox" class="facilityDetails" name="fdetails" id="facilityDetails" value="{{ $value->facility_id }}" title="{{ $value->facility_name }}"> {{ $value->facility_name }}
                                </label>
                            </div>

                            @endif
                        @endforeach
                    </div>
                    @else
                    <div id="provider_lister" class="provider_lister_box">
                        <h3>No available facility can be referred to.</h3>
                    </div>
                    @endif
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="addProviders" class="btn btn-primary" onclick>Add facilities</button>
              </div>
            </div>
          </div>
        </div>
         @if(count($errors) > 0 )
            <!-- <div class="alert alert-danger">
               @foreach ($errors->all() as $error)
                  {{ $error }}
              @endforeach
            </div> -->
            <div class="alert alert-danger"> All fields are required </div>
          @endif
        <div class="form-group @if ($errors->has('patientId')) has-error @endif" >
            <label class="col-sm-3 control-label">Patient Name</label>
            <div>
                <input type="hidden" class="patientId" name="patientId" value="{{ $Patients->patient_id }}">
                <div class="col-sm-9" id="patientInfo">
                    <p class="form-control"> {{ $Patients->first_name }} {{ $Patients->middle_name }} {{ $Patients->last_name }}  </p>
                </div>
            </div>
        </div>
        <div class="form-group @if ($errors->has('healthcareId')) has-error @endif">
            <label class="col-sm-3 control-label">Health Care Service</label>
            <div>
                <input type="hidden" class="healthcareId" name="healthcareId" value="{{ $Patients->healthcareId }}">
                <div class="col-sm-9" id="healthcareInfo">
                    <p id="healthcare_id" class="form-control"> {{ $Patients->encounter_datetime }} :: {{ $Patients->healthcare_servicetype_name }}  </p>
                </div>
            </div>
        </div>

        <div class="form-group divfacilities @if ($errors->has('facility')) has-error @endif">
            <label class="col-sm-3 control-label">Send Referral To</label>
            <div class="form-group col-sm-8  select2-container--default">
                <input type="hidden" class="facility-txt" name="facility" value=""> <!-- ARRAY of selected facilities -->
                <div class="select2-selection--multiple" id="to_facilities">
                    <ul id="referree"></ul>

                </div>
            </div>
            <div class="col-sm-1">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#selectFacilities">
                      Select Facility
                    </button>
                </div>
            <hr />

        </div>

        <div class="form-group">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Referral Information</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Consultation Information</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <fieldset class="@if ($errors->has('Urgency')) has-error @endif">
                            <label class="col-sm-2 control-label">Urgency</label>
                            <div class="col-sm-10">
                                <div class="radio inline">
                                    <label>
                                      <input type="radio" name="Urgency" id="" value="1" > High Priority
                                    </label>
                                </div>
                                <div class="radio inline">
                                    <label>
                                      <input type="radio" name="Urgency" id="" value="2" > Medium Priority
                                    </label>
                                </div>
                                <div class="radio inline">
                                    <label>
                                      <input type="radio" name="Urgency" id="" value="3" > Low Priority
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="@if ($errors->has('ReferralReasons')) has-error @endif">
                            <label class="col-sm-2 control-label">Referral Reasons</label>
                            <div class="col-sm-10 row">
                                @if($lovReferralReasons!=NULL)
                                @foreach($lovReferralReasons as $key => $value)
                                <div class="col-sm-6">
                                    <div class="checkbox ">
                                        <label>
                                            <input type="checkbox" name="ReferralReasons[]" id="" value="{{$value->lovreferralreason_id }}" >
                                            {{ $value->referral_reason }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </fieldset>
                        <fieldset class="@if ($errors->has('MethodofTransport')) has-error @endif">
                            <label class="col-sm-2 control-label">Method of Transport</label>
                            <div class="col-sm-10">
                                <div class="radio inline">
                                    <label>
                                      <input type="radio" name="MethodofTransport" id="" value="Ambulance" > Ambulance
                                    </label>
                                </div>
                                <div class="radio inline">
                                    <label>
                                      <input type="radio" name="MethodofTransport" id="" value="Others" > Others
                                    </label>
                                </div>
                                <div class="radio inline" id="methodTransportOther">
                                    <label>
                                        <input type="text" name="MethodofTransportOthers" id="" value="" > Specify
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="@if ($errors->has('ManagementDone')) has-error @endif">
                            <label class="col-sm-2 control-label">Management Done</label>
                            <div class="col-sm-10">
                                <textarea id="compose-textarea" name="ManagementDone" class="form-control" style="height: 100px" placeholder="Management Done" value="{{ Request::old('ManagementDone') }}"></textarea>
                            </div>
                        </fieldset>
                        <fieldset class="@if ($errors->has('MedicalGiven')) has-error @endif">
                            <label class="col-sm-2 control-label">Medical Given</label>
                            <div class="col-sm-10">
                                <textarea id="compose-textarea" name="MedicalGiven" class="form-control" style="height: 100px" placeholder="Medical Given" value="{{ Request::old('MedicalGiven') }}"></textarea>
                            </div>
                        </fieldset>
                        <fieldset class="@if ($errors->has('ReferralRemarks')) has-error @endif">
                            <label class="col-sm-2 control-label">Referral Remarks</label>
                            <div class="col-sm-10">
                                <textarea id="compose-textarea" name="ReferralRemarks" class="form-control" style="height: 100px" placeholder="Referral Remarks" value="{{ Request::old('ReferralRemarks') }}"></textarea>
                            </div>
                        </fieldset>

                    </div><!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <fieldset>
                            <label class="col-sm-2 control-label"> Healthcare Service </label>
                            <div class="col-sm-10">
                                {{ $Patients->healthcare_servicetype_name }}
                            </div>
                        </fieldset>

                    </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
        </div>

        <!-- <div class="form-group">
            <div class="btn btn-default btn-file">
                <i class="fa fa-paperclip"></i> Attachment
                <input type="file" name="attachment" />
            </div>
            <p class="help-block">Max. 32MB</p>
        </div> -->
    </div><!-- /.box-body -->
    <div class="box-footer">
        <div class="pull-right">
                {!! Form::submit('Draft', ['class'=>'btn btn-primary', 'name'=>'draft']) !!}
                {!! Form::submit('Send', ['class'=>'btn btn-primary', 'name'=>'send']) !!}
        </div>
        <a href="{{ url('/referrals/') }}" class="btn btn-default">
            <i class="fa fa-times"></i> Discard
        </a>
    </div><!-- /.box-footer -->
    {!! Form::close() !!}
    </div><!-- /. box -->
</div><!-- /.col -->
</div>
@stop


@section('scripts')
<script type="text/javascript">
    $('#addProviders').on('click', function (e) {
        e.preventDefault();
        $('#referree').empty();
        var arr = [];

        $('input[name=fdetails]:checked').each(function() {
            arr.push($(this).attr('value'));

            $( "<li class='select2-selection__choice'><a class='select2-selection__choice__remove' href='javascript:;' onclick='$(this).parent().remove();'>×</a>"+$(this).attr('title')+" <input type='hidden' name='provider_referree[]' value='"+$(this).attr('value')+"' /></li>" ).appendTo( "#referree" );

        });

        $('.facility-txt').val(JSON.stringify(arr));
        $('#selectFacilities').modal('hide');
    });
</script>
@stop
