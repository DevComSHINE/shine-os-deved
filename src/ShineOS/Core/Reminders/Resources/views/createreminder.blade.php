@extends('reminders::layouts.master')

@section('reminders-content')

    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> Create a Reminder </h3>
          <div class="box-tools pull-right">

          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
          <p class="innerbox"><h5> Setup an appointment for your patients using this form. </h5></p>
          <hr size="1" noshade="noshade" />
          {!! Form::open(array('url' => 'reminders/add/', 'method' => 'post','id' => 'defaultForm', 'class' => 'form-horizontal')) !!}
              <fieldset>
                @if (Session::has('flash_message'))
                    <div class="alert {{Session::get('flash_type') }}">{{ Session::get('flash_message') }}</div>
                @endif

                @if(count($errors) != NULL AND count($errors) > 0 )
                  <div class="alert alert-danger">
                     @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                  </div>
                @endif

                @if($Patients->patientContact == NULL)
                <div class="alert alert-danger">
                    Error: No Contacts Found. You cannot send a reminder to this patient.
                </div>
                @endif

                  <input type="hidden" name="patientId" value="@if($Patients){{ $Patients->patient_id }}@endif" class="form-control patientId">
                  <div class="form-group">
                      <!-- <div class="col-sm-6 col-sm-offset-3"><p>At least one of the fields below should be filled out to send a reminder. If patient do not have both, please disregard creating a reminder.</p></div> -->
                     <br clear="all" />
                      <label class="col-sm-3 control-label">Patient's E-mail</label>
                      <div class="col-sm-7">
                          <input type="text" name="reminder_email" class="form-control email" value="@if($Patients->patientContact){{ $Patients->patientContact->email }}@endif" readonly="">
                          <!-- <p name="email" class="form-control email"> </p> -->
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Patient Mobile Number</label>
                      <div class="col-sm-7">
                          <input type="text" name="reminder_mobile" class="form-control mobilePH" value="@if($Patients->patientContact){{ $Patients->patientContact->mobile }}@endif" readonly="">
                          <!-- <p name="mobile-number" class="form-control mobilePH"> </p> -->
                      </div>
                  </div>
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Reminder Type</label>
                      <div class="col-sm-7">
                        <select name="reminder-type" class="form-control required">
                          <option disabled="disabled">- Select one -</option>
                          <option value="2">Follow-up Consultation Appointment</option>
                          <option value="3">Lab Exam Results Consultation</option>
                        </select>
                      </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-3 control-label">Message</label>
                      <div class="col-sm-7">
                          <textarea class="form-control required" rows="5" name="message" required></textarea>
                      </div>
                  </div>
                  <!-- Date mm/dd/yyyy -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label">Appointment Date</label>
                        <div class="col-sm-7">
                            <div class="input-group">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                {!! Form::text('date', getCurrentDate('m/d/Y'), ['class' => 'form-control required', 'id'=>'datepicker_future']); !!}
                            </div>

                        </div><!-- /.input group -->
                      <br clear="all" />
                      <label class="col-sm-3 control-label">Appointment Time</label>
                      <div class="col-sm-7">
                            <div class="input-group bootstrap-timepicker">
                                <div class="input-group-addon">
                                <i class="fa fa-clock-o"></i>
                                </div>
                                {!! Form::text('time', getCurrentDate('h:i A'), ['class' => 'form-control', 'id'=>'timepicker']); !!}
                            </div>
                      </div><!-- /.input group -->
                  </div><!-- /.form group -->

                  <div class="form-group">
                      <label class="col-sm-3 control-label">Send before days</label>
                      <div class="col-sm-7">
                            <select name="send_days" class="form-control required" required>
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                            </select>
                      </div>
                  </div>

                  <!--end form-group-->
              </fieldset>

              <div class="form-group">
                  <div class="col-sm-12 col-sm-offset-8">
                      <button type="submit" class="btn btn-primary">Save</button>
                      <a href="{{ url('/reminders/') }}" type="button" class="ajax-link btn btn-danger">Cancel</a>
                  </div>
              </div>
            {!! Form::close() !!}
        </div><!-- /.box-body -->
      </div><!-- /. box -->
    </div><!-- /.col -->
@stop
