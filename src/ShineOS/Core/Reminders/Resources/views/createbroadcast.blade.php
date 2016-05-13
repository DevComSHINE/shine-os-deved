@extends('reminders::layouts.master')

@section('reminders-content')
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"> Create a Broadcast </h3>
          <div class="box-tools pull-right">
            
          </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(array('url' => 'broadcast/add', 'method' => 'post','id' => 'defaultForm', 'class' => 'form-horizontal')) !!}

            <div class="box-content">
                <p class="innerbox">You can send Broadcast messages to your patients or to your users within your Shine Administrative Facility. Choose to whom you want the broadcast to be send. Fill in the subject and your message and click send. Your message will be recieved by your recipients thru email or SMS. </p>
                <hr size="1" noshade="noshade" />
                  <form  method="post" class="form-horizontal">    
                  <fieldset>
                    
                    @if (Session::has('flash_message'))
                        <div class="alert {{Session::get('flash_type') }}">{{ Session::get('flash_message') }}</div>
                    @endif

                    @if(count($errors) > 0 )
                      <div class="alert alert-danger">
                         @foreach ($errors->all() as $error)
                            {{ $error }}<br>        
                        @endforeach
                      </div>
                    @endif


                    <div class="form-group">
                      <label class="col-sm-3 control-label">Broadcast Type</label>
                      <div class="col-sm-7">
                        <div class="btn-group toggler" data-toggle="buttons">
                            <label class="btn btn-default required">
                            <input type="radio" autocomplete="off"  value="BROADCAST_PATIENTS" onchange="$('#reminder_type_field').val(this.value);"> To Patients
                            </label>
                            <label class="btn btn-default required">
                            <input type="radio" autocomplete="off" value="BROADCAST_USERS" onchange="$('#reminder_type_field').val(this.value);"> To Users
                            </label>
                        </div>
                          <input type="hidden" name="reminder-reminder_type" class="required" id="reminder_type_field" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Subject</label>
                      <div class="col-sm-7">
                        <input type="text" class="form-control required" name="subject" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Message</label>
                      <div class="col-sm-7">
                          <textarea class="form-control required" rows="7" name="message" required></textarea>
                      </div>
                    </div>
                  </fieldset>

                    <div class="form-group">
                        <div class="col-sm-12 col-sm-offset-9 btn-group">
                            <button type="submit" class="btn btn-primary">Send</button>
                            <a href="{{ url('/broadcast/') }}" type="button" class="ajax-link btn btn-danger">Cancel</a>
                        </div>
                    </div>
              
                </form>
            </div>
          {!! Form::close() !!}
        </div><!-- /.box-body -->
      </div><!-- /. box -->
    </div><!-- /.col -->

     @section('scripts') 
    @stop
@stop