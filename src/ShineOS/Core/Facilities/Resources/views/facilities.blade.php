@extends('facilities::layouts.masterfacility')

@section('profile-content')
    @include('facilities::fac_nav')
        <div class="col-md-9">
           <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                        <div class="alert alert-dismissible alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif
                    @if (Session::has('warning'))
                        <div class="alert alert-dismissible alert-warning">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <p>{{ Session::get('warning') }}</p>
                        </div>
                    @endif
                </div>
            </div>

          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Facility Information</a></li>
              <li><a href="#tab_2" data-toggle="tab">Facility Contact</a></li>
              <li><a href="#tab_3" data-toggle="tab">Specializations</a></li>
              @if($plugs)
                  @foreach($plugs  as $key => $plug)
                    @if($plug['plugin_location'] == 'tab')
                    <li><a href="#{{ $plug['plugin'] }}" data-toggle="tab">{{ $plug['title'] }}</a></li>
                    @endif
                  @endforeach
              @endif
            </ul>
            <div class="tab-content">

                <!-- Facility Info -->
              <div class="tab-pane active" id="tab_1">
                <h4>Facility Information</h4>
                <!-- form start -->
               {!! Form::open(array( 'url'=>$modulePath.'/updatefacilityinfo/'.$currentFacility->facility_id, 'id'=>'facilityForm', 'name'=>'facilityForm', 'class'=>'form-horizontal' )) !!}

                  <div class="box-body">
                    <div class="form-group">
                      <label for="facility_name" class="col-sm-3 control-label">Facility Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="facility_name" name="facility_name" placeholder="Facility Name" value="{{ $currentFacility->facility_name }}" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="DOH_facility_code" class="col-sm-3 control-label">DOH Facility Code</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" readonly placeholder="DOH Facility Code" value="{{ $doh }}" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="phic_accr_id" class="col-sm-3 control-label">PHIC Accr No.</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="phic_accr_id" name="phic_accr_id" placeholder="PHIC Accr No" value="{{ $currentFacility->phic_accr_id }}" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="ownership_type" class="col-sm-3 control-label">Ownership Type</label>
                      <div class="col-sm-9">
                        <select name="ownership_type" id="ownership_type" class="form-control">
                            <option value="">Ownership Type</option>
                            <option value="government" @if ($currentFacility->ownership_type == 'government') selected="selected" @endif>Government</option>
                            <option value="private" @if ($currentFacility->ownership_type == 'private') selected="selected" @endif>Private</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="provider_type" class="col-sm-3 control-label">Provider Type</label>
                      <div class="col-sm-9">
                        <select name="provider_type" id="provider_type" class="form-control">
                            <option value="">Provider Type</option>
                            <option value="facility" @if ($currentFacility->provider_type == 'facility') selected="selected" @endif>Facility</option>
                            <option value="individual" @if ($currentFacility->provider_type == 'individual') selected="selected" @endif>Individual</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="facility_type" class="col-sm-3 control-label">Facility Type</label>
                      <div class="col-sm-9">
                        <select name="facility_type" id="facility_type" class="form-control">
                            <option value="">Select Facility Type</option>
                            <option value="Barangay Health Station" @if ($currentFacility->facility_type == 'Barangay Health Station') selected="selected" @endif>Barangay Health Station</option>
                            <option value="Birthing Home" @if ($currentFacility->facility_type == 'Birthing Home') selected="selected" @endif>Birthing Home</option>
                            <option value="City Health Office" @if ($currentFacility->facility_type == 'City Health Office') selected="selected" @endif>City Health Office</option>
                            <option value="District Health Office" @if ($currentFacility->facility_type == 'District Health Office') selected="selected" @endif>District Health Office</option>
                            <option value="Hospital" @if ($currentFacility->facility_type == 'Hospital') selected="selected" @endif>Hospital</option>
                            <option value="Main Health Center" @if ($currentFacility->facility_type == 'Main Health Center') selected="selected" @endif>Main Health Center</option>
                            <option value="Municipal Health Office" @if ($currentFacility->facility_type == 'Municipal Health Office') selected="selected" @endif>Municipal Health Office</option>
                            <option value="Provincial Health Office" @if ($currentFacility->facility_type == 'Provincial Health Office') selected="selected" @endif>Provincial Health Office</option>
                            <option value="Rural Health Unit" @if ($currentFacility->facility_type == 'Rural Health Unit') selected="selected" @endif>Rural Health Unit</option>
                            <option value="Private Clinic" @if ($currentFacility->facility_type == 'Private Clinic') selected="selected" @endif>Private Clinic</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="registration_date" class="col-sm-3 control-label">Registration Date</label>
                      <div class="col-sm-9">
                        <input type="date" class="form-control" id="registration_date" name="registration_date" placeholder="Registration Date" value="{{ $currentFacility->created_at }}" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="bmonc_cmonc" class="col-sm-3 control-label">BMONC/CMONC</label>
                      <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="bmonc_cmonc" value="bmonc" @if ($currentFacility->bmonc_cmonc == 'bmonc') checked="checked" @endif />BMONC</label>
                        <label class="radio-inline"><input type="radio" name="bmonc_cmonc" value="cmonc" @if ($currentFacility->bmonc_cmonc == 'cmonc') checked="checked" @endif />CMONC</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="flag_allow_referral" class="col-sm-3 control-label">Can receive referrals?</label>
                      <div class="col-sm-9">
                        <label class="radio-inline"><input type="radio" name="flag_allow_referral" value="1" @if ($currentFacility->flag_allow_referral == '1') checked="checked" @endif />Yes</label>
                        <label class="radio-inline"><input type="radio" name="flag_allow_referral" value="0" @if ($currentFacility->flag_allow_referral == '0') checked="checked" @endif />No</label>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right">Update Info</button>
                  </div><!-- /.box-footer -->
               {!! Form::close() !!}
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="tab_2">
                <h4>Contact Details</h4>
                <!-- form start -->
                {!! Form::open(array( 'url'=>$modulePath.'/updatefacilitycontact/'.$currentFacility->facility_id, 'id'=>'facilityContactForm', 'name'=>'facilityContactForm', 'class'=>'form-horizontal' )) !!}
                  <div class="box-body">
                    <div class="form-group">
                      <label for="email_address" class="col-sm-2 control-label">Email Address</label>
                      <div class="col-sm-4">
                        <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Email Address" value="{{ $facilityContact->email_address }}" />
                      </div>
                      <label for="email_address" class="col-sm-2 control-label">Mobile No.</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" value="{{ $facilityContact->mobile }}" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="website" class="col-sm-2 control-label">Website</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="website" name="website" placeholder="Website" value="{{ $facilityContact->website }}" />
                      </div>
                      <label for="hospital_license_number" class="col-sm-2 control-label">Hospital License Number</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="hospital_license_number" name="hospital_license_number" placeholder="Hospital License Number" value="{{ $facilityContact->hospital_license_number }}" />
                      </div>
                    </div>

                    <div class="form-group">
                      <h4 class="col-sm-12">Address</h4>
                      <hr />
                      <label for="house_no" class="col-sm-2 control-label">No.</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="house_no" name="house_no" placeholder="House No." value="{{ $facilityContact->house_no }}" />
                      </div>
                      <label for="house_no" class="col-sm-2 control-label">Building</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="building_name" name="building_name" placeholder="Building Name" value="{{ $facilityContact->building_name }}" />
                      </div>

                      <label for="street_name" class="col-sm-2 control-label">Street</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="street_name" name="street_name" placeholder="Street Name" value="{{ $facilityContact->street_name }}" />
                      </div>
                      <label for="street_name" class="col-sm-2 control-label">Village</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="village" name="village" placeholder="Village" value="{{ $facilityContact->village }}" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="region" class="col-sm-2 control-label">Region</label>
                      <div class="col-sm-4">
                            <select class="placeholder form-control required" name="region" id="region">
                                {{ Shine\Libraries\Utils::get_regions($facilityContact->region) }}
                            </select>
                      </div>
                      <label for="province" class="col-sm-2 control-label">Province</label>
                      <div class="col-sm-4">
                            <select class="populate placeholder form-control required" name="province" id="province">
                                {{ Shine\Libraries\Utils::get_provinces($facilityContact->region, $facilityContact->province) }}
                            </select>
                      </div>

                      <label for="city" class="col-sm-2 control-label">City</label>
                      <div class="col-sm-4">
                        <select class="populate placeholder form-control required" name="city" id="city">
                            {{ Shine\Libraries\Utils::get_cities($facilityContact->region, $facilityContact->province, $facilityContact->city) }}
                        </select>
                      </div>
                      <label for="brgy" class="col-sm-2 control-label">Barangay</label>
                      <div class="col-sm-4">
                        <select class="populate placeholder form-control required" name="brgy" id="brgy">
                            {{ Shine\Libraries\Utils::get_brgys($facilityContact->region, $facilityContact->province, $facilityContact->city, $facilityContact->barangay) }}
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="zip" class="col-sm-2 control-label">Zip Code</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="zip" name="zip" placeholder="ZIP" value="{{ $facilityContact->zip }}" />
                      </div>
                      <label for="country" class="col-sm-2 control-label">Country</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" id="country" name="country" placeholder="Country" value="{{ $facilityContact->country }}" />
                      </div>
                    </div>
                  </div>

                <div class="box-footer">
                    <input type="submit" name="updateContact" id="updateContact" class="btn btn-success pull-right" value="Update Contacts" />
                </div><!-- /.box-footer -->
                {!! Form::close() !!}
              </div><!-- /.tab-pane -->

              <div class="tab-pane" id="tab_3">
                <h4>Specializations</h4>
                <p>Choose as many specializations your facility can provide. Click on the field and choose.</p>
                <!-- form start -->
                <!-- NOTE:: Fix this! -->
                {!! Form::open(array( 'url'=>$modulePath.'/updatespecialization/'.$currentFacility->facility_id, 'id'=>'facilitySpecializationForm', 'name'=>'facilitySpecializationForm', 'class'=>'form-horizontal' )) !!}
                  <div class="box-body">
                    <div class="form-group">
                      <label for="specializations" class="col-sm-3 control-label">Specializations</label>
                      <div class="col-sm-9">
                        <select id="specializations" name="specializations[]" class="form-control select2" multiple="multiple" style="width: 100%;">
                            <option value=""></option>
                            <?php foreach($specialties as $specialty) { ?>
                                <option value="<?php echo $specialty->code; ?>"
                                    <?php
                                        foreach (explode(',', $currentFacility->specializations) as $key => $value)
                                            {
                                                // echo $value;
                                                if($value === $specialty->code) { echo "selected='selected'"; }
                                            }
                                         ?>>

                                        <?php echo $specialty->description; ?>
                                </option>
                            <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="services" class="col-sm-3 control-label">Services</label>
                      <div class="col-sm-9">
                          <select id="services" class="form-control select2" name="services[]" multiple="multiple" style="width: 100%">
                                <option value=""></option>
                                <?php foreach($services as $service) { ?>
                                    <option value="<?php echo $service->code; ?>" <?php foreach (explode(',', $currentFacility->services) as $key => $value)
                                                {
                                                    // echo $value;
                                                    if($value === $service->code) { echo "selected='selected'"; }
                                                }
                                             ?>>
                                        <?php echo $service->description; ?>
                                    </option>
                                <?php } ?>
                            </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="equipment" class="col-sm-3 control-label">Equipment</label>
                      <div class="col-sm-9">
                          <select id="equipment" class="form-control select2" name="equipment[]" multiple="multiple" style="width: 100%">
                                <option value=""></option>
                                <?php foreach($equipments as $equipment) { ?>
                                    <option value="<?php echo $equipment->code; ?>"<?php foreach (explode(',', $currentFacility->equipment) as $key => $value)
                                                {
                                                    // echo $value;
                                                    if($value === $equipment->code) { echo "selected='selected'"; }
                                                }
                                             ?>>
                                             <?php echo $equipment->description; ?>
                                    </option>
                                <?php } ?>
                            </select>
                      </div>
                    </div>
                  </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right">Update Specilizations</button>
                </div><!-- /.box-footer -->
                {!! Form::close() !!}
              </div><!-- /.tab-pane -->

              <!-- insert tab plugins here -->
              @if($plugs)
                @foreach($plugs as $k=>$tab)
                    @if($tab['plugin_location'] == 'tab')
                        <div class="tab-pane" id="{{ $tab['plugin'] }}">
                            <?php
                                View::addNamespace('pluginform', plugins_path().$tab['folder']);
                                echo View::make('pluginform::'.strtolower($tab['plugin']), array('plugdata'=>$tab['pdata'], 'currentFacility' => $currentFacility))->render();
                              ?>
                        </div>
                    @endif
                @endforeach
              @endif

            </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->
        </div>
@stop

@section('linked_scripts')
{!! HTML::script('public/dist/plugins/chain/jquery.chained.min.js') !!}
{!! HTML::script('public/dist/plugins/chain/jquery.chained.remote.min.js') !!}
{!! HTML::script('public/dist/js/pages/users/userprofile.js') !!}
@stop
