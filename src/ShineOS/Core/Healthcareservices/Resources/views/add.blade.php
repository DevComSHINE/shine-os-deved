<?php
    //get users roles
    $user = Session::get('user_details');
    $role = getRoleInfoByFacilityUserID($user->facilityUser[0]->facilityuser_id);
    if(isset($prevhealthcareData)) {
        $healthcareData = $prevhealthcareData;
    }
    if(empty($disposition_record->disposition)) { $read = NULL; }
    else { $read = 'disabled'; }
?>

@extends('healthcareservices::layouts.master')
@section('header-content') {{ $pageTitle }} @stop

@section('healthcareservices-content')
  <div class="row">
    <div class="col-xs-12">

    <?php
    if(empty($addendum_record)) { $addendumRead = ''; }
    else { $addendumRead = 'disabled'; }

    if($healthcareData AND $healthcareData->seen_by == NULL){
          $formtype = 5;
    }

    ?>

      @if(Session::has('flash_message'))
            <div class="alert {{Session::get('flash_type') }}">{{ Session::get('flash_message') }}</div>
        @endif

        @if(count($errors) > 0 )
          <div class="alert alert-danger">
             @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
          </div>
        @endif
      @if($healthcareserviceid)
      {!! Form::open(array('route' => 'healthcare.update','id'=>'healthcareForm')) !!}
      @else
      {!! Form::open(array('route' => 'healthcare.insert')) !!}
      @endif

      {!! Form::hidden('patient_id', $patient->patient_id) !!}
      {!! Form::hidden('hservices_id', $healthcareserviceid) !!}
      {!! Form::hidden('follow_healthcareserviceid', $follow_healthcareserviceid) !!}
      {!! Form::hidden('thistabs', json_encode($tabs)) !!}
      <div class="box box-primary">

        <div class="info-box padding-1p">
          <span class="info-box-icon no-bg patient-img">
            <img src="{{ asset('public/dist/img/noimage_male.png') }}">
          </span>
          <div class="info-box-content">
            <h2 class="col-md-12"> {{$patient->last_name}}, {{$patient->first_name}} @if($tabSwitch)<input checked id="tabs-toggle" data-toggle="toggle" data-on="Tabs On" data-off="Tabs Off" data-onstyle="default" data-offstyle="default" data-size="mini" type="checkbox" class="pull-right">@endif</h2>
            <div class="col-md-5">
              <p>
                  <a href="{{ url('patients/view/'.$patient->patient_id) }}" class="bg-primary text-white kbd">Open Patient Profile | <i class="fa fa-search"></i></a> <a href="{{ url('patients/quickhistory/'.$patient->patient_id) }}" class="bg-primary text-white kbd" data-toggle="modal" data-target="#myInfoModal">Medical History | <i class="fa fa-search"></i></a>
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
                      <label class="control-label noPadding fixwidth150">Facility:</label>  <strong>{{ findFacilityByFacilityPatientUserID($healthcareData->facilitypatientuser_id)->facility_name }}</strong>
                  @endif
              </p>
            </div>
            <div class="col-md-7">
              @if($healthcareData)
                @if(!empty($disposition_record->disposition))
                    <p>
                      @if(getModuleStatus('reminders') == 1)
                      <a class="ajax-link btn btn-social bg-blue btn-sm" href="{{ url('reminders/add/' . $patient->patient_id . '/' . $healthcareData->healthcareservice_id) }}">
                        <i class="glyphicon glyphicon-bell"></i> Add Appointment
                      </a>
                      @endif
                      @if(getModuleStatus('referrals') == 1)
                      <a class="ajax-link btn btn-social bg-blue btn-sm" href="{{ url('referrals/add', [$healthcareData->healthcareservice_id]) }}">
                        <i class="glyphicon glyphicon-send"></i> Add Referral
                      </a>
                     @endif
                      <a class="ajax-link btn btn-social btn-warning btn-sm" href="#" data-toggle="modal" data-target="#createAddendum">
                        <i class="glyphicon glyphicon-file"></i> Addendum
                      </a>
                    </p>
                @endif
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
                      <!-- let us check if this record has a follow-up already -->
                      @if(!empty($disposition_record->disposition))
                          @if($childData == NULL)
                          <label id="consuTypeFollow" class="kbd bg-green floatleft">
                                <i class="fa fa-check"></i> New Consultation
                          </label>
                          <a class="bg-red text-black kbd floatleft" href="{{ url('healthcareservices/add/'.$patient->patient_id.'/'.$healthcareserviceid) }}">
                            <i class="fa fa-plus"></i> Add Follow-up
                          </a>
                          @else
                          <label id="consuTypeFollow" class="kbd bg-green floatleft">
                                <i class="fa fa-check"></i> Consultation
                          </label>
                          <a class="bg-yellow text-black kbd floatleft" href="{{ url('healthcareservices/edit/'.$patient->patient_id.'/'.$childData->healthcareservice_id) }}">
                            <i class="fa fa-arrow-circle-right"></i> Open Follow-up
                          </a>
                          @endif
                      @endif
                      <br />
                      </p>
                  @endif
                  @if($healthcareType=='FOLLO')
                      <p>
                          <label id="consuTypeFollow" class="kbd bg-green floatleft">
                                <i class="fa fa-check"></i> | Follow-up
                          </label>
                          <a href="{{ url('healthcareservices/qview/'.$patient->patient_id.'/'.$parent_hcs_id) }}" class="bg-yellow text-black kbd floatleft" data-toggle="modal" data-target="#myInfoModal"><i class="fa fa-search"></i> | View Previous Consultation</a>
                          @if(!empty($disposition_record->disposition))
                            @if($childData == NULL)
                              <a class="bg-red text-black kbd floatleft" href="{{ url('healthcareservices/add/'.$patient->patient_id.'/'.$healthcareserviceid) }}">
                                <i class="fa fa-plus"></i> | Add Follow-up
                              </a>
                              @else
                              <a class="bg-yellow text-black kbd floatleft" href="{{ url('healthcareservices/edit/'.$patient->patient_id.'/'.$childData->healthcareservice_id) }}">
                                <i class="fa fa-arrow-circle-right"></i> Open Follow-up
                              </a>
                              @endif
                          @endif
                      </p>
                      <br clear='all' />
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
                    <?php if(isset($prevhealthcareData)):
                        $thisdate = getMysqlDate();
                    else:
                        $thisdate = $healthcareData->encounter_datetime;
                    endif;
                    ?>
                    <label class="control-label noPadding fixwidth150">Encounter Date/Time:</label> <strong>{{ date( 'M d, Y', strtotime($thisdate)) }} | {{ date( 'h:i A', strtotime($thisdate) ) }}</strong>
                  </p>
              @endif
            </div>
          </div>
          <br clear="all" />
        </div>

        @if($healthcareType=='FOLLO' AND $recent_healthcare)
        <legend class="col-md-12">{{ $formTitle }}  <a href="{{ url('healthcareservices/qview/'.$patient->patient_id.'/'.$healthcareData->parent_service_id) }}" class="" data-toggle="modal" data-target="#myInfoModal">{{ date('M. d, Y', strtotime($recent_healthcare->encounter_datetime)) }}</a> </legend>
        @endif

        <div class="box-body no-padding">
          <!-- Main content -->
            <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs" id="HC_tabs">
                      @if (isset($tabs_child))
                        @foreach ($tabs_child as $key => $val)
                            @if( $role->role_id <= $tabroles[$val] )
                            <li class="{{($default_tabs == $val) ? 'active' : ''}}"><a href="#{{$val}}" data-toggle="tab">{{$tabs[$val]}}</a></li>
                            @endif
                         @endforeach
                      @else
                          <li class="active"><a href="#{{$default_tabs}}" data-toggle="tab">{{$tabs[$default_tabs]}}</a></li>
                      @endif
                </ul>
                <div id="tabContent" class="tab-content">
                  @if (isset($tabs_child))
                    @foreach ($tabs_child as $key => $val)
                      @if( $role->role_id <= $tabroles[$val] )
                      <div class="tab-pane {{($default_tabs == $val) ? 'active' : ''}}" id="{{$val}}">
                        @if(strpos($val, '_plugin') > 0)
                          <h3 class="sectionName">{{ $plugin }}</h3>
                          <?php
                            $pdata = NULL;
                            if(isset($pluginparentdata)) {
                                $pdata = $pluginparentdata;
                            }
                            View::addNamespace('pluginform', plugins_path().$plugin);
                            echo View::make('pluginform::'.strtolower($plugin), array('data'=>$plugindata, 'pdata'=>$pdata,  'allData'=>$allData, 'read'=>$read))->render();
                          ?>
                        @else
                           <h3 class="sectionName">{{ $tabs[$val] }}</h3>
                           @include('healthcareservices::forms.' . $val)
                        @endif
                      </div><!-- /.tab-pane -->
                      @endif
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

    @if($healthcareserviceid)
    <div class="mainbuttons col-md-12 textcenter" {{$disabled}}>
        @if(empty($disposition_record->disposition))
        <button type="submit" class="btn btn-success">Save Healthcare</button>
        @endif
        <a type="button" class="btn btn-default" href='{{ url("/records#visit_list") }}'>Close</a>
    </div>
    @endif

    {!! Form::close() !!}
    <!-- <div class="box box-primary">Widgets</div>
    </div> -->

  </div><!-- /.row -->
@stop

@section('scripts')
    <div class="modal fade" id="myInfoModal" tabindex="-1" role="dialog" aria-labelledby="myInfoModalLabel">
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

    <div class="modal fade" id="deathInfoModal" tabindex="-1" role="dialog" aria-labelledby="deathInfoModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                @include('patients::pages.forms.modal_death')
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
              <div class="modal-header bg-yellow">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Add Addendum </h4>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    {!! Form::textarea('addendum_notes', NULL, ['class' => 'form-control required noresize', 'placeholder' => 'Addendum lets you add new information about this consultation without altering the original record.']) !!}
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

        //set tab setting from cookie
        var tabber = $.cookie('tabsetting');
        if(tabber == 'taboff') {
            $('#tabs-toggle').bootstrapToggle('off');
            $('#HC_tabs').addClass('hidden');
            $('#tabContent').addClass('no-tab-content');
            $('#tabContent').removeClass('tab-content');
        }

        $( document ).ready(function() {
            var service_type = $('#healthcare_services').val();
            if(service_type == 'GeneralConsultation') {
                $("#medicalcategory").removeClass('hidden');
                $("#consultation_type").removeClass('hidden');
            }
            //toggle tabs to collapse
            $('#tabs-toggle').change(function() {
              $('#console-event').html('Toggle: ' + $(this).prop('checked'))
              if($(this).prop('checked')) {
                  $('.nav-tabs').removeClass('hidden');
                  $('#tabContent').addClass('tab-content');
                  $('#tabContent').removeClass('no-tab-content');
                  //save setting to cookies
                  $.cookie('tabsetting', 'tabon',{ expires: 365, path: '/' });
              } else {
                  $('.nav-tabs').addClass('hidden');
                  $('#tabContent').addClass('no-tab-content');
                  $('#tabContent').removeClass('tab-content');
                  //save setting to cookies
                  $.cookie('tabsetting', 'taboff',{ expires: 365, path: '/' });
              }
            })

            <?php if($read != NULL) { ?>
            $(".tab-pane fieldset").attr('disabled','disabled');
            <?php } ?>
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

        /*$('#healthcareForm').submit(function() {
            if($('#deadButton').hasClass('active')) {
                $("#deathInfoModal").modal('show');
            }
        });*/


    </script>
@stop
