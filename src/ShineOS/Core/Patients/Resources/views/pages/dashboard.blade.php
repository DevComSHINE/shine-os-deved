@section('heads')
{!! HTML::style('public/dist/plugins/ionslider/ion.rangeSlider.css') !!}
{!! HTML::style('public/dist/plugins/ionslider/ion.rangeSlider.skinFlat.css') !!}
{!! HTML::style('public/dist/css/flaticon.css') !!}
@stop

@extends('patients::layouts.master')
@section('header-content') Patient Dashboard @stop
@section('list-content')
    <div class="col-md-3">
      <div class="box box-primary">
        <div class="box-body box-profile">
          <!--do not forget to add style for profile-user-img-->
          <div class="img_container">
              @if($patient->photo_url)
                <img class="profile-img img-responsive img-circle" src="{{ uploads_url().'patients/'.$patient->photo_url }}" alt="User profile picture">
              @else
                <img class="profile-img img-responsive img-circle" src="{{ asset('public/dist/img/noimage_male.png') }}" alt="User profile picture">
              @endif
          </div>

          <h2 class="text-center">{{ $patient->first_name }} {{ $patient->moddile_name}} {{ $patient->last_name}}</h2>
          <p align="center"><a href="{{ url('/patients/view', [$patient->patient_id]) }}" class="btn btn-xs bg-yellow black">View full health record <i class="fa fa-external-link-square"></i></a></p>
          <ul class="nav">
            <li>
              <label>Status</label>
              <p class="text-muted green">
                @if (!empty($patient->deleted_at))
                  Inactive
                @else
                  Active
                @endif
              </p>
            </li>
            <li>
              <label>Recorded on </label>
              <p class="text-muted">
                {{ $patient->created_at }}
              </p>
            </li>
            <li>
              <label>Created by </label>
              <p class="text-muted">
                {{ $creator->first_name." ".$creator->last_name }}
              </p>
            </li>
            <?php if(isset($plugs)) {
              foreach($plugs as $k=>$p) {
                  if($p['plugin'] == 'Philhealth' AND $p['pdata']) { ?>
                      <li>
                          <label>PhilHealth No. </label>
                          <p class="text-muted">
                            {{ $plugs[$k]['pdata']->philhealth_id }}
                          </p>
                      </li>
                  <?php }
                  break;
              }
            } ?>
          </ul>
        </div><!-- /.box-body -->
      </div>

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-info-circle margin-r-5"></i> Patient Information</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <label>Sex</label>
          <p class="text-muted">
            {{ $patient->gender }}
          </p>

          <label>Birth Date</label>
          <p class="text-muted">{{ dateFormat($patient->birthdate,"M. d, Y") }}</p>

          <label>Age</label>
          <p class="text-muted"><?php echo getAge($patient->birthdate); ?> years old</p>

          <label>Email Address</label>
          <p class="text-muted"><?php echo $patient->patientContact->email; ?></p>

          <label>Phone No.</label>
          <p class="text-muted"><?php echo $patient->patientContact->mobile; ?></p>

          <label>Address/Barangay</label>
          <p><?php echo $patient->patientContact->street_address; ?>
             <?php echo getBrgyName($patient->patientContact->barangay); ?></p>

          <label>City/Province</label>
          <p><?php echo getCityName($patient->patientContact->city); ?> @if($patient->patientContact->province), <?php echo getProvinceName($patient->patientContact->province); ?>@endif</p>

          <label>Region</label>
          <p><?php echo getRegionName($patient->patientContact->region); ?></p>

          <label>ZIP Code</label>
          <p><?php echo $patient->patientContact->zip; ?></p>

          <label>Country</label>
          <p>{{ $patient->patientContact->country or "n/a" }}</p>
        </div><!-- /.box-body -->
      </div>
    </div>

    <div class="col-md-9">
      <div class="row">
        <div class="col-md-12">
          @if (Session::has('message'))
            <div class="alert alert-dismissible alert-success">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <p>{{ Session::get('message') }}</p>
            </div>
          @endif
        </div>
      </div>

      @if($patient->patientDeathInfo != null)
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-certificate"></i> Death Info</h3>
        </div>
        <div class="box-body">
          <div class="col-md-12">
          <label>Immediate Cause of Death: <small>(Disease, injury or complication that led directly to death)</small></label><p>{{ $patient->patientDeathInfo->Immediate_Cause_of_Death }}</p>
          <label>Antecedent Cause of Death: <small>(Conditions giving rise to the immediate cause of death)</small></label><p>{{ $patient->patientDeathInfo->Antecedent_Cause_of_Death }}</p>
          <label>Underlying Cause of Death: <small>(Disease or injury that initiated the train of events leading directly to death)</small></label><p>{{ $patient->patientDeathInfo->Underlying_Cause_of_Death }}</p>
          </div>
          <div class="col-md-4">
          <label>Place:</label>
          <p>
              @if($patient->patientDeathInfo->PlaceDeath == 'FB')
                Facility-Based
              @else
                Non-Institutional
              @endif
          </p>
          </div>
          <div class="col-md-4">
          <label>Date:</label><p>{{ date('m/d/Y', strtotime($patient->patientDeathInfo->datetime_death)) }}</p>
          </div>
          <div class="col-md-12">
          <label>Notes:</label><pre>{{ $patient->patientDeathInfo->Remarks }}</pre>
          </div>
        </div>
      </div>
      @endif

      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><i class="fa fa-stethoscope"></i> Visits</h3>
          <div class="box-tools pull-right">
            @if($patient->patientDeathInfo == null)
            <a href="{{ url('healthcareservices/add', [$patient->patient_id]) }}" class="btn btn-sm btn-danger">Create New Consultation <i class="fa fa-plus"></i></a>
            @endif
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>

        </div><!-- /.box-header -->
        <?php if(isset($currentConsultation)) {
                $childConsultation = findHealthRecordChild($currentConsultation->healthcareservice_id);
            ?>
            <div class="box-body">
              <h3 class="blue">Recent Consultation |  <a href="{{ url('healthcareservices/edit', [$patient->patient_id,$currentConsultation->healthcareservice_id]) }}" class="btn btn-sm btn-info">Open Current Consultation <i class="fa fa-external-link-square"></i></a>
                  @if($patient->patientDeathInfo == null)
                    @if($childConsultation == NULL)
                        <a href="{{ url('healthcareservices/add', [$patient->patient_id, $currentConsultation->healthcareservice_id]) }}" class="btn btn-sm btn-success">Add Followup <i class="fa fa-plus"></i></a>
                    @else
                        <a href="{{ url('healthcareservices/edit', [$patient->patient_id, $childConsultation->healthcareservice_id]) }}" class="btn btn-sm btn-success">Open Followup <i class="fa fa-plus"></i></a>
                    @endif
                  @endif
              </h3>
              <div class="row">
                <div class="col-lg-6">
                  <label>Consultation Date:</label>
                  <p class="text-muted">{{ date("F d, Y", strtotime($currentConsultation->encounter_datetime)) }}</p>

                  @if($currentConsultation->parent_service_id)
                    <?php
                      $previousConsultation = findHealthRecordByServiceID($currentConsultation->parent_service_id);
                    ?>
                    <label>Followup from:</label>
                    <p class="text-muted">{{ date("F d, Y", strtotime($previousConsultation->encounter_datetime)) }}</p>
                  @endif

                  <label>Consultation Type:</label>
                  <p class="text-muted">
                      {{ getHealthcareServiceName($currentConsultation->healthcareservicetype_id) }}
                      @if($currentConsultation->healthcareservicetype_id == 'GeneralConsultation')
                       -
                      {{ getMedicalCategoryName($currentConsultationData->medicalcategory_id) }}
                      @endif
                  </p>

                  <label>Complaint:</label>
                  <p class="text-muted">{{ $currentConsultationData->complaint or "No complaint given" }}</p>
                </div>

                <div class="col-lg-6">
                  <label>Diagnosis:</label>
                  <p class="text-muted">{{ getDiagnosisByHealthServiceID($currentConsultation->healthcareservice_id) }}</p>

                  <label>Medical Order:</label>
                  <p class="text-muted">{{ getMedicalOrderByHealthServiceID($currentConsultation->healthcareservice_id) }}</p>

                  <label>Attending Physician:</label>
                  <p class="text-muted">
                      @if($dr = getUserFullNameByFacilityUserID($currentConsultation->seen_by))
                      Dr. {{ $dr }} [{{ getFacilityByFacilityUserID($currentConsultation->seen_by, 'facility_name') }}]
                      @endif
                  </p>
                </div>
              </div>

              <hr />

              <h4 class="blue">Recent Vitals</h4>
              <div class="">
                <div class="col-md-3 summary-data height-box">
                    <b class="wt">{{ $currentVitals->height or "n/a" }}</b>
                </div>
                <div class="col-md-6 summary-data" style="min-height:230px;">
                    <br />
                    <div class="item wtb"><b>{{ $currentVitals->weight or "n/a" }}</b><label>Weight (kgs)</label></div>
                    <div class="lborder item wtb"><b>{{ $currentVitals->temperature or "n/a" }}&deg;</b><label>Temp (C)</label></div>
                    <div class="lborder item wtb"><b>{{ $patient->blood_type or "n/a" }}</b><label>Blood Type</label></div>
                    <br clear="all" />
                    <hr />
                    <div class="col-sm-12">
                        <input id="bmi_range" type="text" name="bmi_range" value="0;100" data-type="single" data-step="2" data-from="23" data-slider="false" data-hasgrid="true" disabled: disabled !important;/>
                    </div>
                    <label>BMI</label>
                </div>
                <div class="col-md-3 summary-data centered">
                    <h4 class="leftaligned">Heart</h4>
                    <i class="flaticon-heart27 font50 red"></i><br />
                    <b class="font30" style="width:130px;"><span style="border-bottom:2px solid #333;">{{ $currentVitals->bloodpressure_systolic or "n/a" }}</span><br/>{{ $currentVitals->bloodpressure_diastolic or "n/a" }}</b>
                    <br />
                    <div class="item centered paddingl-10 fullw">
                        <span><span class="slabel centered">hr</span>{{ $currentVitals->heart_rate or "n/a" }}</span>
                        <span><span class="slabel centered">pr</span>{{ $currentVitals->pulse_rate or "n/a" }}</span>
                        <span><span class="slabel centered">rr</span>{{ $currentVitals->respiratory_rate or "n/a" }}</span>
                    </div>
                </div>
                <br clear="all" />
              </div>

              <hr />

              <h4 class="blue">Consultation History</h4>
              <table class="table table-hover table-heading table-datatable table-align-top">
                <tbody><tr>
                  <th>Consultation Date</th>
                  <th>Clinical Service</th>
                  <th>Diagnosis</th>
                  <th>Type</th>
                  <th>Physician</th>
                </tr>
                <?php foreach($hc_history as $history) { //dd($hc_history); ?>
                <tr class='row-clicker' onclick="location.href='{{ url('healthcareservices/edit', [$patient->patient_id, $history['healthcareservice_id']] ) }}'">
                  <td>{{ date('m/d/y', $history['dater']) }}</td>
                  <td>{{ getHealthcareServiceName($history['type']) }}</td>
                  <td>{{ $history['diagnosis_type'] }}</td>
                  <td>{{ getConsultTypeName($history['consultype']) }}</td>
                    <?php if($history['seen']):
                        $seenby = $history['seen']->first_name." ".$history['seen']->last_name;
                    else:
                        $seenby = NULL;
                    endif; ?>
                  <td>{{ $seenby }}</td>
                </tr>
                <?php } ?>
              </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <p class="pull-left"></p>
              <ul class="pagination pagination-sm no-margin pull-right">

              </ul>
            </div>
        <?php } else { ?>
            <div class="box-body">
            <h3>No recent consultation visit</h3>
          </div>
        <?php } ?>
      </div>

      @if(count($patients_monitoring))
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-heartbeat"></i> Patient Monitoring</h3>
          </div><!-- /.box-header -->
          <div class="box no-border">
              <div class="box-body table-responsive no-padding overflowx-hidden">
                  <table class="table table-hover datatable">
                      <thead>
                        <tr>
                          <th>Blood Pressure</th>
                          <th>Blood Pressure Assessment</th>
                          <th>Created At</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($patients_monitoring as $mkey => $mvalue)
                          <tr>
                            <td> {{ $mvalue->bloodpressure_systolic }} / {{ $mvalue->bloodpressure_diastolic }}</td>
                            <td> {{ $mvalue->bloodpressure_assessment_name }} </td>
                            <td>  {{ date('M. d, Y', strtotime($mvalue->created_at)) }}  </td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
        @endif

      @if(count($MedicalOrderLabExam))
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-heartbeat"></i> Patient Laboratory</h3>
            </div><!-- /.box-header -->
            <div class="box no-border">
                <div class="box-body table-responsive no-padding overflowx-hidden">
                    <table class="table table-hover datatable">
                        <thead>
                          <tr>
                            <th>Laboratory</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>

                          @foreach ($MedicalOrderLabExam as $lab_key => $lab_value)
                            <tr>
                              <td>
                                    @if( isset($lov_laboratories[$lab_value->laboratory_test_type]) )
                                  {{ $lov_laboratories[$lab_value->laboratory_test_type] }}
                                  @else
                                  {{ $lab_value->laboratory_test_type }}
                                  @endif
                              </td>
                              <td>
                                @if($lab_value->LaboratoryResult!=NULL)
                                  <?php $disabled_upload = TRUE; ?>
                                  <span class="label label-success">Uploaded: <?php echo date('M d, Y h:i A', strtotime($lab_value->LaboratoryResult->created_at)); ?>
                                      </span>
                                @else
                                  <?php $disabled_upload = FALSE; ?>
                                  <span class="label label-warning">Pending: <?php echo date('M d, Y h:i A', strtotime($lab_value->created_at)); ?>
                                      </span>
                                @endif
                              </td>
                              <td>
                                @if($lab_value->laboratory_test_type =='BR')
                                  <?php $Modal_labType = "lab_completebloodcount"; ?>
                                @elseif($lab_value->laboratory_test_type =='UR')
                                  <?php $Modal_labType = "lab_urinalysis"; ?>
                                @elseif($lab_value->laboratory_test_type =='FE')
                                  <?php $Modal_labType = "lab_fecalysis"; ?>
                                @else
                                  <?php $Modal_labType = "labModal"; ?>
                                @endif

                                @if(!$disabled_upload)
                                  <a href="#" class="btn btn-block btn-default btn-sm labClick" data-toggle="modal" data-id="<?php echo $lab_value->medicalorderlaboratoryexam_id; ?>" data-target="#<?php echo $Modal_labType; ?>" > Upload result </a>
                                @else
                                  <a href="{{ URL::to('laboratory/view/'.$lab_value->laboratory_test_type.'/'.$lab_value->medicalorderlaboratoryexam_id) }}" class="btn btn-block btn-default btn-sm"> View </a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div>
          @endif
    </div>

@include('laboratory::modal.modal_lab_completebloodcount')
@include('laboratory::modal.modal_lab_urinalysis')
@include('laboratory::modal.modal_lab_fecalysis')
@include('laboratory::modal.modal_laboratory_result')
@stop

@section('scripts')

{!! HTML::script('public/dist/plugins/ionslider/ion.rangeSlider.min.js') !!}
<script type="text/javascript">
    $(document).ready(function() {
        $("#bmi_range").ionRangeSlider({
            disable: true
        });
    });

    $(document).on("click", ".labClick", function () {
      var lab_dataTarget = $(this).data('target');
      var medicalorderlaboratoryexam_id = $(this).data('id');
      $(lab_dataTarget+" #medicalorderlaboratoryexam_id").val( medicalorderlaboratoryexam_id );

    });
</script>
@stop
