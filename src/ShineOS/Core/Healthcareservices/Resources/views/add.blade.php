@extends('healthcareservices::layouts.master')
@section('header-content') New Healthcare Record @stop

@section('healthcareservices-content')
  <div class="row">
    <div class="col-xs-12">

    <?php
    if(empty($addendum_record)) { $addendumRead = ''; }
    else { $addendumRead = 'disabled'; }
    ?>

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
      <div class="box box-primary">

        <div class="info-box padding-1p">
          <span class="info-box-icon no-bg patient-img">
            <img src="{{ asset('public/dist/img/noimage_male.png') }}">
          </span>
          <div class="info-box-content">
            <div class="col-md-5">
              <h2> {{$patient->last_name}}, {{$patient->first_name}} </h2>
              <p>
                  <a href="{{ url('patients/quick/'.$patient->patient_id) }}" class="hidden bg-yellow text-black kbd" data-toggle="modal" data-target="#myInfoModal">Quick View Patient Profile | <i class="fa fa-search"></i></a>
                  <br />
                    {{$patient->gender}} | {{ getAge($patient->birthdate) }} years old | {{dateFormat($patient->birthdate, 'F d, Y')}}
              @if ($patient->patientContact)
                  <br />
                 {{($patient->patientContact->address) ?  $patient->patientContact->address . ', ' : ''}}
                 {{ getCityName($patient->patientContact->city) }}
              @endif

              @if($healthcareData)
              <br />
                  <label class="control-label noPadding fixwidth150">Attending Physician:</label> <strong>{{ getUserFullNameByUserID($healthcareData->seen_by) }}</strong><br />
                  <label class="control-label noPadding fixwidth150">Facility:</label>  <strong>{{ getFacilityNameByUserID($healthcareData->seen_by) }}</strong>
              @endif
              </p>
            </div>
            <div class="col-md-7">
              @if($healthcareData)
                  <h2 style="height:35px;">
                    @if(!empty($disposition_record->disposition))
                      @if(getModuleStatus('reminders') == 1)
                      <a class="ajax-link btn btn-social bg-blue btn-sm" href="{{ url('reminders/add', [$patient->patient_id]) }}">
                        <i class="glyphicon glyphicon-bell"></i> Create Appointment
                      </a>
                      @endif
                      @if(getModuleStatus('referrals') == 1)
                      <a class="ajax-link btn btn-social bg-blue btn-sm" href="{{ url('referrals/add', [$healthcareData->healthcareservice_id]) }}">
                        <i class="glyphicon glyphicon-send"></i> Create Referral
                      </a>
                      @endif

                      <a class="ajax-link btn btn-social bg-blue btn-sm" href="#" data-toggle="modal" data-target="#createAddendum">
                        <i class="glyphicon glyphicon-file"></i> Addendum
                      </a>

                    @endif
                  </h2>
                  <!-- add by RJBS -->
                  @if($healthcareType=='ADMIN')
                      <p>
                      <label id="consuTypeFollow" class="kbd bg-green floatleft">
                            <i class="fa fa-check"></i> New Admission
                      </label><br />
                      </p>
                  @endif
                  @if($healthcareType=='CONSU')
                      <p>
                      <label id="consuTypeFollow" class="kbd bg-green floatleft">
                            <i class="fa fa-check"></i> New Consultation
                      </label><br />
                      </p>
                  @endif
                  @if($healthcareType=='FOLLO')
                      <p>
                          <label id="consuTypeFollow" class="kbd bg-green floatleft">
                                <i class="fa fa-check"></i> Follow-up
                          </label>
                          <a href="{{ url('healthcareservices/qview/'.$patient->patient_id.'/'.$healthcareData->parent_service_id) }}" class="bg-yellow text-black kbd floatleft" data-toggle="modal" data-target="#myInfoModal">View Previous Consultation | <i class="fa fa-search"></i></a><br />
                      </p>
                  @endif
                  <!-- end RJBS -->
                <p><label class="control-label noPadding fixwidth150">Encounter Type:</label> @if($healthcareData->encounter_type=='O') <strong>Out Patient</strong> @else <strong>In Patient</strong> @endif
                      <br />
                    <label class="control-label noPadding fixwidth150">Healthcare Service:</label>  <strong>{{ getHealthcareServiceName($healthcareData->healthcareservicetype_id) }} @if(isset($healthcareData->healthcareservice_treatment))[ {{ $healthcareData->healthcareservice_treatment }} ] @endif</strong>
                  @if(isset($generalConsultation->medicalcategory_id))
                      <br />
                    <label class="control-label noPadding fixwidth150">Medical Service:</label> <strong>{{ getMedicalCategoryName($generalConsultation->medicalcategory_id) }}</strong>
                  @endif
                    <br />
                    <label class="control-label noPadding fixwidth150">Encounter Date/Time:</label> <strong>{{ date( 'M d, Y', strtotime($healthcareData->encounter_datetime)) }} | {{ date( 'h:i A', strtotime($healthcareData->encounter_datetime) ) }}</strong>
                  </p>

              @endif
            </div>
          </div>
          <br clear="all" />
        </div>

        <div class="box-body no-padding">
          <!-- Main content -->
            <div class="">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <?php //dd($tabs); ?>
                      @if (isset($tabs_child))
                        @foreach ($tabs_child as $key => $val)
                           <li class="{{($default_tabs == $val) ? 'active' : ''}}"><a href="#{{$val}}" data-toggle="tab">{{$tabs[$val]}}</a></li>
                         @endforeach
                      @else
                      <li class="active"><a href="#{{$default_tabs}}" data-toggle="tab">{{$tabs[$default_tabs]}}</a></li>

                  @endif
                </ul>
                <div class="tab-content">
                  @if (isset($tabs_child))
                    @foreach ($tabs_child as $key => $val)
                      <div class="tab-pane {{($default_tabs == $val) ? 'active' : ''}}" id="{{$val}}">
                        @if(strpos($val, '_plugin') > 0)
                          <?php

                            View::addNamespace('pluginform', plugins_path().$plugin);
                            echo View::make('pluginform::'.strtolower($plugin), array('data'=>$plugindata, 'allData'=>$allData))->render();
                          ?>
                        @else
                            @include('healthcareservices::forms.' . $val)
                        @endif
                      </div><!-- /.tab-pane -->
                     @endforeach
                  @else
                     <div class="tab-pane active" id="{{$default_tabs}}">
                        @include('healthcareservices::forms.' . $default_tabs)
                      </div><!-- /.tab-pane -->

                  @endif
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
            </div>
        </div>
        <div class="box-footer">
        </div>
    </div>

    <!-- <div class="box box-primary">Widgets</div>
    </div> -->

  </div><!-- /.row -->
@stop

@section('scripts')
    <div class="modal fade" id="myInfoModal" tabindex="-1" role="dialog" aria-labelledby="myInfoModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myInfoModalLabel"> Healthcare Record Preview </h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Addendum -->
    <div class="modal fade" id="createAddendum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            {!! Form::open(array('route' => 'addendum.add')) !!}
            @if($healthcareData)
            {!! Form::hidden('healthcareservice_id', $healthcareData->healthcareservice_id) !!}
            @endif
            @if(isset($session_user_id))
              {!! Form::hidden('session_user_id', $session_user_id) !!}
            @endif
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Add Addendum </h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    {!! Form::textarea('addendum_notes', NULL, ['class' => 'form-control required noresize', 'placeholder' => 'Addendum']) !!}
                  </div>
                </div>
                @if(isset($addendum_record))
                  @foreach($addendum_record as $k_addendum => $v_addendum)
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box no-border">
                            <div class="box-body">
                                <p>
                                <b> {{ date( 'M. d, Y h:i a', strtotime($v_addendum->created_at)) }} </b> : {{ $v_addendum->addendum_notes }}
                                </p>
                            </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {!! Form::submit('Send Addendum', ['class'=>'btn btn-primary', 'name'=>'sendAddendum']) !!}
              </div>
            </div>
            {!! Form::close() !!}
          </div>
    </div>
    <!-- End:: Create Addendum -->

    {!! HTML::script('public/dist/js/pages/healthcareservices/healthcare.js') !!}
    <script type="text/javascript">
        var patient_id = "{{$patient->patient_id}}";

        $( document ).ready(function() {
            var service_type = $('#healthcare_services').val();
            if(service_type == 'GeneralConsultation') {
                $("#medicalcategory").removeClass('hidden');
                $("#consultation_type").removeClass('hidden');
            }
        });

        $("#myInfoModal").on("show.bs.modal", function(e) {
            $(this).find(".modal-content").html("");
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("href"));
        });

        <?php if (Session::has('flash_tab')) { ?>
            var tab = '{{Session::get('flash_tab') }}';
            $('.nav-tabs a[href="#' + tab + '"]').tab('show');
        <?php } ?>

    </script>
@stop
