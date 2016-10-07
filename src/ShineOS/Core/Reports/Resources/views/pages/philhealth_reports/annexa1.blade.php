@extends('reports::layouts.fhsis_master')
@section('reportGroup')Philhealth @stop
@section('reportTitle') Annex A1 @stop

@section('heads')
{!! HTML::style('public/dist/plugins/stickytableheader/css/component.css') !!}
@stop

@section('content')

 @if (Session::has('success'))
  <div class="alert alert-dismissible alert-success">
      <p>{{ Session::get('success') }}</p>
  </div>
@endif

@if (Session::has('warning'))
  <div class="alert alert-dismissible alert-warning">
      <p>{{ Session::get('warning') }}</p>
  </div>
@endif

@if(isset($patient))
<?php //dd($patient); ?>
<!-- PATIENTS DATA -->
  <section class="fhsis">
    <div class="row">
      <div class="col-md-12">
        <center>
          <h5><b>PHILIPPINE HEALTH INSURANCE CORPORATION</b></h5>
          <h5><b>{{ $facility_name or NULL }}</b></h5>
          <h5><b>INDIVIDUAL  HEALTH PROFILE</b></h5>
        </center>
        <table class="table-condensed">
          <tr>
            <td rowspan="2">
              <b> Patient Name: </b>
            </td>
            <td>
              <h5> {{ $patient->last_name or NULL }} </h5>
            </td>
            <td>
              <h5> {{ $patient->first_name or NULL }} </h5>
            </td>
            <td>
              <h5> {{ $patient->middle_name or NULL }} </h5>
            </td>
            <td>
              <h5> {{ $patient->name_suffix or NULL }} </h5>
            </td>
          </tr>
          <tr>
            <td>
              <h6> (Last Name) </h6>
            </td>
            <td>
              <h6> (First Name) </h6>
            </td>
            <td>
              <h6> (Middle Name) </h6>
            </td>
            <td>
              <h6> (Extension: Sr., Jr., etc.) </h6>
            </td>
          </tr>
          <tr>
            <td colspan="5">
              <h6> Note: If this is a follow-up consult or 2nd visit, please indicate if there are any changes in the Basic Demographic Data.   Updating of this Individual Health Profile must be done before the fiscal year ends, to include review of consultation records (Annex A.3) Indicate the date when the new data has been entered. Please use additional page when necessary. </h6>
            </td>
          </tr>
          <tr>
            <td>
            <b> Address: </b>
            </td>
            <td colspan="4">
            @if($patient->patientContact)
              {{ $patient->patientContact->street_address or NULL }}
              {{ $patient->patientContact->barangay or NULL }}
              {{ $patient->patientContact->city or NULL }}
              {{ $patient->patientContact->province or NULL }}
              {{ $patient->patientContact->region or NULL }}
            @endif
            </td>
          </tr>
          <tr>
            <td>
              <b> Age: </b>
            </td>
            <td colspan="4">
              {{ $patient->age }}
            </td>
          </tr>
          <tr>
            <td>
              <b> Birthday (mm/dd/yyyy): </b>
            </td>
            <td>
              {{ dateFormat($patient->birthdate, 'F d, Y') }}
            </td>
            <td>
              <b> Sex: </b> {{ $patient->gender or NULL }}
            </td>
            <td>
              <b> Religion: </b> {{ $patient->religion or NULL }}
            </td>
            <td> </td>
          </tr>
          <tr>
            <td>
              <b> Civil Status: </b>
            </td>
            <td colspan="4">
              @if($patient->civil_status == 'S')
                Single
              @elseif($patient->civil_status == 'M')
                Married
              @elseif($patient->civil_status == 'A')
                Annuled
              @elseif($patient->civil_status == 'W')
                Widowed
              @elseif($patient->civil_status == 'X')
                Separated
              @elseif($patient->civil_status == 'C')
                Co-Habitation
              @elseif($patient->civil_status == 'D')
                Divorced
              @elseif($patient->civil_status == 'U')
                Unknown
              @else
                Not Stated
              @endif              
            </td>
          </tr>
          <tr>
            <td colspan="1">
              <b> PHIC Membership </b>
            </td>
            <td colspan="1">
              @if($patient->patientPhilhealthInfo)
                @if($patient->patientPhilhealthInfo->member_type == 'MM')
                  Member
                @elseif($patient->patientPhilhealthInfo->member_type == 'DD')
                  Dependent
                @elseif($patient->patientPhilhealthInfo->member_type == 'NM')
                  Non Member
                @else
                  Non Member
                @endif
              @endif
            </td>
            <td colspan="1">
              <b> Type of Membership </b>
            </td>
            <td colspan="1">
              @if($patient->patientPhilhealthInfo)
                {{ $arrMembershipType[$patient->patientPhilhealthInfo->philhealth_category] }}
              @endif
            </td>
            <td colspan="1">
            </td>
          </tr>
          <tr>
            <td colspan="1">
              <b> Occupation: </b>
            </td>
            <td colspan="4">
              @if($patient->patientEmploymentInfo)
                {{ $patient->patientEmploymentInfo->occupation }}
              @else
                Not Stated
              @endif
            </td>
          </tr>
          <tr>
            <td colspan="1">
              <b> Highest Completed Educational Attainment: </b>
            </td>
            <td colspan="4">
              @if($patient->highest_education == '01')
                Elementary / Primary Education
              @elseif($patient->highest_education == '02')
                High School / Secondary Education
              @elseif($patient->highest_education == '03')
                College / Tertiary
              @elseif($patient->highest_education == '04')
                Postgraduate Program
              @elseif($patient->highest_education == '05')
                No Formal Education/No Schooling
              @elseif($patient->highest_education == '06')
                Not Applicable
              @elseif($patient->highest_education == '07')
                Vocational
              @elseif($patient->highest_education == '99')
                {{ $patient->highesteducation_others or NULL }}
              @else
                Not Stated
              @endif
            </td>
          </tr>
          @if($patient->patientMedicalHistory)
            @foreach($lovDiseases as $lovkey => $lovvalue)
              <?php $checked = NULL; $disease_status = NULL; ?>
              <tr>
                <td width="25%">
                  <b> {{ $lovkey }} </b>
                </td>
                <td colspan="4">
                  @foreach($lovvalue as $lovvaluekey => $lovvaluevalue)
                    <div class="col-md-4">
                    @foreach($patient->patientMedicalHistory as $medkey => $medvalue)
                      @if($medvalue->disease_id == $lovvaluevalue['disease_id'])
                        <?php
                          $checked = "checked='checked'";
                          $disease_status = $medvalue->disease_status;
                        ?>
                      @endif
                    @endforeach
                      <label>
                        <h6 class="inline">
                            @if($lovvaluevalue['disease_input_type'] == 'checkbox' OR $lovvaluevalue['disease_input_type'] == 'radio')
                              <input type="checkbox" {{ $checked }} disabled="disabled">
                            @endif
                            
                             {{ $lovvaluevalue['disease_name'] }}

                            @if($lovvaluevalue['disease_input_type'] == 'text')
                              <input type="text" disabled="disabled" value="{{ $disease_status or NULL }}">
                            @endif
                        </h6>
                      </label>
                    <?php $checked = NULL; $disease_status = NULL; ?>
                    </div>
                  @endforeach
                </td>
              </tr>
            @endforeach
          @endif
          <tr>
            <td colspan="5">
              <b> Pertinent Physical Examination Findings: </b>
            </td>
          </tr>
          <tr>
            <td colspan="5">
              <dl class="dl-horizontal col-md-6">
                <dt>BP</dt>
                  <dd> <input type="text" disabled="disabled" value="{{ $recenthealthcare->VitalsPhysical->bloodpressure_systolic or NULL }} / {{ $recenthealthcare->VitalsPhysical->bloodpressure_diastolic or NULL }}">
                  </dd>
                <dt>HR</dt>
                  <dd> <input type="text" disabled="disabled" value="{{ $recenthealthcare->VitalsPhysical->heart_rate or NULL }}">
                  </dd> 
                <dt>RR</dt>
                  <dd> <input type="text" disabled="disabled" value="{{ $recenthealthcare->VitalsPhysical->respiratory_rate or NULL }}">
                  </dd>
              </dl>
              <dl class="dl-horizontal col-md-6">
                <dt>Height</dt>
                  <dd> <input type="text" disabled="disabled" value="{{ $recenthealthcare->VitalsPhysical->height or NULL }}"> <h6 class="inline"> (cm) </h6>
                  </dd>
                <dt>Weight</dt>
                  <dd> <input type="text" disabled="disabled" value="{{ $recenthealthcare->VitalsPhysical->weight or NULL }}"> <h6 class="inline"> (kg) </h6>
                  </dd>
                <dt>Waist Circumference</dt>
                  <dd> <input type="text" disabled="disabled" value="{{ $recenthealthcare->VitalsPhysical->waist or NULL }}"> <h6 class="inline"> (cm) </h6>
                  </dd>
              </dl>
            </td>
          </tr>
          @if(isset($LovExamination))
            <?php //dd($LovExamination); ?>
            <?php //dd($LovExamination, array_keys($recenthealthcare->Examination->toArray()[0])); ?>
            @foreach($LovExamination as $exam_key => $exam_value)
              <tr>
                <td>
                  <b> {{ $exam_key }} </b>
                </td>
                <td colspan="4">
                  @foreach($exam_value as $ev_key => $ev_value)
                  <?php $keyChecked = NULL; $others_exists = NULL; ?>
                  <div class="col-md-4">
                    <label>
                      <h6 class="inline">
                        <?php
                          if(!$recenthealthcare->Examination->isEmpty()) {
                            $examination_name = str_replace(' ', '_', $ev_value['examination_name']);
                            $arraykeyexists = array_key_exists($examination_name, $recenthealthcare->Examination->toArray()[0]);
                            if($arraykeyexists) {
                              if($recenthealthcare->Examination->toArray()[0][$examination_name] == 1) {
                                $keyChecked = "checked='checked'";
                              }
                            }
                          }
                        ?>
                        @if($ev_value['examination_name']!='Others')
                          <input type="checkbox" {{ $keyChecked }} disabled="disabled">
                          {{ $ev_value['examination_name'] }}
                        @else
                          @if(!$recenthealthcare->Examination->isEmpty())
                          <?php $others_exists = array_key_exists($ev_value['examination_code'], $recenthealthcare->Examination->toArray()[0]) ?>
                          @endif
                          Others <input type="text" value="<?php if($others_exists) { echo $recenthealthcare->Examination->toArray()[0][$ev_value['examination_code']]; } ?>" disabled="disabled">
                        @endif
                      </h6>
                    </label>
                  </div>
                  @endforeach
                </td>
              </tr>
            @endforeach
          @endif
        </table>
      </div>
    </div>
  </section>
<!-- / PATIENTS DATA -->
@else
<!-- SEARCH -->
  <section class="fhsis">
  <div class="row">
    <div class="col-md-12">
      {!! Form::open(array('url' => 'reports/philhealth/annexa1/search')) !!}
      <!-- form start -->
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-2 control-label">First Name</label>
          <div class="col-sm-10">
            {!! Form::text('search_firstname', NULL, ['class' => 'form-control']); !!}
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Middle Name</label>
          <div class="col-sm-10">
            {!! Form::text('search_middlename', NULL, ['class' => 'form-control']); !!}
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Last Name</label>
          <div class="col-sm-10">
            {!! Form::text('search_lastname', NULL, ['class' => 'form-control']); !!}
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-info pull-right">Search</button>
      </div>
      <!-- /.box-footer -->
      {!! Form::close() !!}
    </div>
  </div>
  </section>
<!-- / SEARCH -->
  @if(isset($patientsdata))
<!-- SEARCH RESULTS -->
  <section class="fhsis">
  <div class="row">

    <div class="col-md-12">
      <table class="datatable table table-bordered table-striped">
        <thead>
        <tr>
          <td>
            First Name
          </td>
          <td>
            Middle Name
          </td>
          <td>
            Last Name
          </td>
          <td>
            Birthday
          </td>
          <td>
          </td>
        </tr>
        </thead>
        <tbody>
        @if(!$patientsdata->isEmpty())
          @foreach($patientsdata as $key => $value)
            <tr>
              <td>
                {{ $value->first_name }}
              </td>
              <td>
                {{ $value->middle_name }}
              </td>
              <td>
                {{ $value->last_name }}
              </td>
              <td>
                {{dateFormat($value->birthdate, 'F d, Y')}}
              </td>
              <td>
              <a href="{{ url('reports/philhealth/annexa1/'.$value->patient_id) }}" type="button" class="btn btn-success btn-flat smalhide"> View </a>
              </td>
            </tr>
          @endforeach
        @else
          <tr>
            <td colspan="5">
              <center> No data found </center>
            </td>
          </tr>
        @endif
        </tbody>
      </table>
    </div>
  </div>
  </section>
<!-- / SEARCH RESULTS -->
  @endif
@endif
@stop
