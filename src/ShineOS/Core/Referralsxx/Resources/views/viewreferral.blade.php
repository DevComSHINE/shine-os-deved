@extends('referrals::layouts.master')

@section('referral-content')
<?php
    $user = Session::get('_global_user');
    $userPhoto = $user->profile_picture;
?>
@foreach($referrals as $key => $value)
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-header with-border">
        <p class="pull-right">{{ $value->created_at }}</p>
            <h5> Referrer: <strong> {{ $value->referrer->facility_name }} </strong> </h5>
            <h5> Referred to: <strong> {{ $value->referredTo->facility_name }} </strong> </h5>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-2 hidden">
                @if ( $userPhoto != '' )
                  <img src="{{ url('public/uploads/profile_picture/'.$userPhoto) }}" class="profile-user-img img-responsive img-circle" />
                @else
                    <img src="{{ asset('public/dist/img/noimage_male.png') }}" class="profile-user-img img-responsive img-circle" />
                @endif
            </div>
            <div class="col-md-12">
              <dl class="dl-horizontal">
                <dt>Patient Name:</dt>
                <dd>
                    {{ $value->patient_firstname }}
                    {{ $value->patient_middlename }}
                    {{ $value->patient_lastname }}
                </dd>
                <dt>Referral Status:</dt>
                <dd>
                    @if ($value->referral_status == 1)
                    <span class="label label-warning">
                     @if($value->type == 'inbound') <!-- if referrer = Sent; if referred to = Pending -->
                      Pending
                      @endif
                      @if($value->type == 'outbound') <!-- if referrer = Sent; if referred to = Pending -->
                        Sent
                      @endif
                    </span>
                    @elseif ($value->referral_status == 2)
                      <span class="label label-warning"> Declined </span>
                    @elseif ($value->referral_status == 3)
                      <span class="label label-success"> Accepted </span>
                    @elseif ($value->referral_status == 4)
                      <span class="label label-warning"> Closed </span>
                    @elseif ($value->referral_status == 5)
                      <span class="label label-warning"> Cancelled </span>
                    @elseif ($value->referral_status == 6)
                      <span class="label label-warning"> Draft </span>
                    @else
                      <span></span>
                    @endif
                </dd>
                <dt> Referral Reasons: </dt>
                <dd>
                    @foreach($value->reasons as $kreason => $vreason)
                    <p> {{ $vreason->reasondesc }} </p>
                    @endforeach
                </dd>
              </dl>
            </div>
          </div>
          <div class="form-group">
             <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#ConsultationInformation" data-toggle="tab">Consultation Information</a></li>
                <li class="pull-right">
                @if ($value->referral_status == 1 AND $value->type=='outbound') <!-- outbound -->
                    {!! Form::open(array( 'url'=>"referrals/outbound/$value->referral_id",
                                              'id'=>'referrals',
                                              'name'=>'referrals',
                                              'class'=>'form-horizontal no-padding'
                                          )) !!}
                       {!! Form::submit('Follow Up', ['class'=>'btn btn-primary', 'name'=>'followup']) !!}
                    {!! Form::close() !!}
                @elseif($value->referral_status == 6) <!-- Drafts -->
                    {!! Form::open(array( 'url'=>"referrals/drafts/$value->referral_id",
                                              'id'=>'referrals',
                                              'name'=>'referrals',
                                              'class'=>'form-horizontal no-padding'
                                          )) !!}

                        {!! Form::submit('Send', ['class'=>'btn btn-success', 'name'=>'send']) !!}
                        {!! Form::submit('Discard', ['class'=>'btn btn-primary', 'name'=>'discard']) !!}
                    {!! Form::close() !!}
                @elseif($value->referral_status == 1 AND $value->type=='inbound') <!-- inbound -->
                    {!! Form::open(array( 'url'=>"referrals/inbound/$value->referral_id",
                                              'id'=>'referrals',
                                               'name'=>'referrals',
                                              'class'=>'form-horizontal no-padding'
                                          )) !!}

                        {!! Form::submit('Accept', ['class'=>'btn btn-success', 'name'=>'accept']) !!}
                        {!! Form::submit('Decline', ['class'=>'btn btn-primary', 'name'=>'decline']) !!}
                    {!! Form::close() !!}
                @endif
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="ConsultationInformation">
                  <fieldset>
                      <div class="form-group">
                          <label class="col-md-4 control-label"> Healthcare service type</label>
                          <div class="col-md-8">
                            @if($value->healthcare_servicetype_name == 'GeneralConsultation')
                              <strong> General Consultation </strong>
                            @else
                              <strong> {{ $value->healthcare_servicetype_name }} </strong>
                            @endif
                          </div>
                      </div>
                  </fieldset>
                  <?php //dd($value->complaintsData); ?>
                  @if($value->complaintsData!=NULL)
                  @foreach($value->complaintsData as $kcomplaints => $vcomplaints)
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Complaint*</label>
                            <div class="col-md-8">
                              {{ $vcomplaints->complaint }}
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Complaint History</label>
                            <div class="col-md-8">
                              {{ $vcomplaints->complaint_history }}
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Physical Examination</label>
                            <div class="col-md-8">
                              {{ $vcomplaints->physical_examination }}
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Remarks</label>
                            <div class="col-md-8">
                              {{ $vcomplaints->remarks }}
                            </div>
                        </div>
                    </fieldset>
                  @endforeach
                  @endif
                  <?php //dd($value->diagnosisData); 
                  //dd(count($value->diagnosisData));?>
                  @if(!is_null($value->diagnosisData) AND count($value->diagnosisData)!=0)
                    <hr>
                    <fieldset>
                      <div class="form-group">
                          <strong>Impressions and Diagnosis</strong>
                      </div>
                    </fieldset>
                    @foreach($value->diagnosisData as $kdiagnosis => $vdiagnosis) 
                        <fieldset>
                          <div class="row">
                              <label class="col-sm-4 control-label">Diagnosys Type</label>
                              <label class="col-sm-4 control-label">Diagnosis</label>
                              <label class="col-sm-4 control-label">Diagnosis Notes</label>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              @if($vdiagnosis->diagnosis_type == 'ADMDX')
                                Admitting diagnosis
                              @elseif($vdiagnosis->diagnosis_type == 'CLIDI')
                                Clinical diagnosis
                              @elseif($vdiagnosis->diagnosis_type == 'OTHER')
                                Other Diagnosis
                              @elseif($vdiagnosis->diagnosis_type == 'WODIA')
                                Working Diagnosis
                              @elseif($vdiagnosis->diagnosis_type == 'WORDX')
                                Interim Diagnosis
                              @else
                                Final Diagnosis
                              @endif
                            </div>
                            <div class="col-md-4">
                              {{$vdiagnosis->diagnosislist_id}}
                            </div>
                            <div class="col-md-4">
                               {{$vdiagnosis->diagnosis_notes}}
                            </div>
                          </div>
                        </fieldset> 
                      @if($vdiagnosis->diagnosis_type == 'FINDX')
                        <hr>
                        <fieldset>
                          <div class="form-group">
                              <strong>Final Diagnosis</strong>
                          </div>
                        </fieldset>
                        @foreach($vdiagnosis->diagnosis_i_c_d10 as $kicd10 => $vicd10)
                          <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label">ICD10 Classifications</label>
                                <div class="col-md-8">
                                    {{ $vicd10->icd10_classifications }}
                                </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label">ICD10 Sub-Classification</label>
                                <div class="col-md-8">
                                    {{ $vicd10->icd10_subClassifications }}
                                </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label">ICD10 Disease Type</label>
                                <div class="col-md-8">
                                    {{ $vicd10->icd10_type }}
                                </div>
                            </div>
                          </fieldset>
                          <fieldset>
                            <div class="form-group">
                                <label class="col-md-4 control-label">ICD10 CODE</label>
                                <div class="col-md-8">
                                    {{ $vicd10->icd10_code }}
                                </div>
                            </div>
                          </fieldset>
                        @endforeach
                      @endif
                    @endforeach
                  @endif
                </div><!-- /.tab-pane -->
              </div><!-- /.tab-content -->
            </div><!-- nav-tabs-custom -->
          </div>
          <!-- <div class="form-group">
            <div class="btn btn-default btn-file">
              <i class="fa fa-paperclip"></i> Attachment
              <input type="file" name="attachment" />
            </div>
            <p class="help-block">Size: 12MB</p>
          </div> -->
        </div><!-- /.box-body -->
      <!--   <div class="box-footer">
          <div class="pull-right">
            <button type="submit" class="btn btn-success">View Consultation</button>
          </div>
        </div> --><!-- /.box-footer -->
      </div><!-- /. box -->
    </div><!-- /.col -->

@endforeach

@stop
