<?php $qview = 1; ?>

            <div class="col-md-12">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-yellow">
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                  </div>
                  <div class="widget-user-image">
                    @if($data['patient']->photo_url)
                        <img class="profile-img img-responsive img-circle" src="{{ uploads_url().'patients/'.$data['patient']->photo_url }}" alt="User profile picture">
                      @else
                        <img class="profile-img img-responsive img-circle" src="{{ asset('public/dist/img/noimage_male.png') }}" alt="User profile picture">
                      @endif
                  </div>
                  <!-- /.widget-user-image -->
                  <h3 class="widget-user-username">{{ $data['patient']->first_name." ".$data['patient']->last_name }}</h3>
                  <h5 class="widget-user-desc">{{ date("M d, Y", strtotime($data['patient']->birthdate)) }} | {{ $data['patient']->gender }} | Blood Type: {{ $data['patient']->blood_type }} </h5>

                </div>
                <div class="box-body no-padding">
                  <ul class="nav nav-stacked">
                    <li><span>Healthcare Information</span>
                      <div class="row">
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header">{{ date("M. d, Y", strtotime($data['healthcareData']->encounter_datetime)) }}</h5>
                            <span class="description-text">Date of encounter</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header">{{ getHealthcareServiceName($data['healthcareData']->healthcareservicetype_id) }}</h5>
                            <span class="description-text">Health Service</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header">{{ getConsultTypeName($data['healthcareData']->consultation_type) }}</h5>
                            <span class="description-text">Consultation Type</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3">
                          <div class="description-block">
                            <h5 class="description-header">{{ getEncounterName($data['healthcareData']->encounter_type) }}</h5>
                            <span class="description-text">Encounter</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </li>

                    <li><span>Vitals</span>

                        @if($data['vitals_record'])
                        <div class="row">
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header">{{ $data['vitals_record']->bloodpressure_systolic."/".$data['vitals_record']->bloodpressure_diastolic }}</h5>
                            <span class="description-text">Blood Pressure</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header">{{ $data['vitals_record']->temperature ? $data['vitals_record']->temperature : NULL  }}</h5>
                            <span class="description-text">Temperature</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 border-right">
                          <div class="description-block">
                            <h5 class="description-header">{{ $data['vitals_record']->height ? $data['vitals_record']->height : 0 }} cm</h5>
                            <span class="description-text">Height</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3">
                          <div class="description-block">
                            <h5 class="description-header">{{ $data['vitals_record']->weight ? $data['vitals_record']->weight : 0 }} kg</h5>
                            <span class="description-text">Weight</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        </div>
                        @else
                        <div class="col-sm-12">
                          <div class="description-block textleft">
                            <span class="textleft">No vitals recorded</span>
                          </div>
                          <!-- /.description-block -->
                        </div>
                        @endif

                      <!-- /.row -->
                    </li>


                    <li><span>Complaints</span>
                        <div class="container-fluid">
                            @if($data['complaints_record'])
                                <div class="col-sm-12">
                                  <div class="description-block textleft">
                                    <span class="textleft">{{ $data['complaints_record']->complaint ? $data['complaints_record']->complaint : NULL }}</span>
                                  </div>
                                  <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                @if($data['complaints_record']->complaint_history)
                                <div class="col-sm-12">
                                  <div class="description-block textleft">
                                    <span class="textleft">{{ $data['complaints_record']->complaint_history }}</span>
                                  </div>
                                  <!-- /.description-block -->
                                </div>
                                <!-- /.col -->
                                @endif
                            @else
                            <div class="col-sm-12">
                              <div class="description-block textleft">
                                <span class="textleft">No complaints recorded</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            @endif
                          </div>
                        <!-- /.row -->
                    </li>


                    <li><span>Diagnosis</span>
                        @if($data['diagnosis_record'])
                            <?php $otype = NULL; ?>
                            @foreach($data['diagnosis_record'] as $diagnosis)
                                <div class="row">
                                    <div class="col-sm-3">
                                      <div class="description-block">
                                        @if($diagnosis->diagnosis_type != $otype)
                                        <h5 class="description-header">{{ $diagnosis->diagnosis_type ? getDiagnosisTypeName($diagnosis->diagnosis_type) : NULL }}</h5>
                                        <span class="description-text">Diagnosis Type</span>
                                        <?php $otype = $diagnosis->diagnosis_type; ?>
                                        @endif
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-9 border-left">
                                      <div class="description-block textleft">
                                        <span class="textleft">
                                            @if($diagnosis->diagnosislist_id)
                                                {{ $diagnosis->diagnosislist_id }}
                                                @if($diagnosis->diagnosis_notes)
                                                <br />{{ $diagnosis->diagnosis_notes }}
                                                @endif
                                            @endif
                                        </span>
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                  </div>
                                <!-- /.row -->
                            @endforeach
                        @else
                            <div class="col-sm-12">
                              <div class="description-block textleft">
                                <span class="textleft">No diagnosis recorded</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                        @endif
                    </li>


                    <li><span>Medical Orders</span>
                        @if(!empty($data['medicalorder_record']))
                            <?php $motype = NULL; ?>
                            @foreach($data['medicalorder_record'] as $order)
                                <div class="row">
                                    <div class="col-sm-3">
                                      <div class="description-block">
                                        @if($order->medicalorder_type != $motype)
                                        <h5 class="description-header">{{ getOrderTypeName($order->medicalorder_type) }}</h5>
                                        <span class="description-text">Order Type</span>
                                        <?php $motype = $order->medicalorder_type; ?>
                                        @endif
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-sm-9 border-left">
                                      <div class="description-block textleft">
                                          @if($order->medicalorder_type == 'MO_LAB_TEST')
                                            @foreach($order->medical_order_lab_exam as $lab)
                                                <span class="textleft">
                                                    {{ getLabName($lab->laboratory_test_type) }}
                                                </span>
                                            @endforeach
                                            @if($order->user_instructions)
                                                <span class="textleft">
                                                {{ $order->user_instructions }}
                                                </span>
                                            @endif
                                          @endif
                                          @if($order->medicalorder_type == 'MO_MED_PRESCRIPTION')
                                            @foreach($order->medical_order_prescription as $prescription)
                                                <span class="textleft">
                                                    {{ $prescription->generic_name }}<br>
                                                    {{ $prescription->dosage_regimen }}<br>
                                                    {{ $prescription->prescription_remarks }}
                                                </span>
                                            @endforeach
                                            @if($order->user_instructions)
                                                <span class="textleft">
                                                {{ $order->user_instructions }}
                                                </span>
                                            @endif
                                          @endif
                                          @if($order->medicalorder_type == 'MO_PROCEDURE')
                                            @foreach($order->medical_order_procedure as $procedure)
                                                <span class="textleft">
                                                    {{ $procedure->procedure_order }} | {{ date("M d, Y", strtotime($procedure->procedure_date)) }}
                                                </span>
                                            @endforeach
                                            @if($order->user_instructions)
                                                <span class="textleft">
                                                {{ $order->user_instructions }}
                                                </span>
                                            @endif
                                          @endif
                                          @if($order->medicalorder_type == 'MO_OTHERS')
                                            <span class="textleft">
                                                {{ $order->medicalorder_others }}
                                            </span>
                                            @if($order->user_instructions)
                                                <span class="textleft">
                                                {{ $order->user_instructions }}
                                                </span>
                                            @endif
                                          @endif
                                      </div>
                                      <!-- /.description-block -->
                                    </div>
                                    <!-- /.col -->
                                  </div>
                                <!-- /.row -->
                            @endforeach
                        @else

                                <div class="col-sm-12">
                                  <div class="description-block textleft">
                                    <span class="textleft">No orders recorded</span>
                                  </div>
                                  <!-- /.description-block -->
                                </div>

                            <!-- /.row -->
                        @endif
                    </li>


                    <li><span>Disposition</span>
                        @if($data['disposition_record'])
                        <div class="row">
                            <div class="col-sm-3 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{ getDispositionName($data['disposition_record']->disposition) }}</h5>
                                <span class="description-text">Disposition</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{ getDischargeName($data['disposition_record']->discharge_condition) }}</h5>
                                <span class="description-text">Discharge Condition</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{ date("M d, Y", strtotime($data['disposition_record']->discharge_datetime)) }}</h5>
                                <span class="description-text">Discharge Date/Time</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3">
                              <div class="description-block">
                                <span class="description-text">{{ $data['disposition_record']->discharge_notes }}</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                      </div>
                      <!-- /.row -->
                      @else
                            <div class="col-sm-12">
                              <div class="description-block textleft">
                                <span class="textleft">No Disposition recorded</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                        @endif
                    </li>

                  </ul>
                </div>
                <div class="box-footer textcenter">
                    <a href="{{ url('healthcareservices/edit/'.$data['patient']->patient_id.'/'.$data['healthcareData']->healthcareservice_id) }}" class="small-box-footer">
                      Open this Consultation <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>
              <!-- /.widget-user -->
            </div>




@section('scripts')
<script>
    Healthcare.computeBMI();
</script>
@stop
