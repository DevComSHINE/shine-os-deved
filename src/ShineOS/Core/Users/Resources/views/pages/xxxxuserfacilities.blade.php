@extends('users::layouts.masterprofile')

@section('profile-content')
        @include('users::partials.user_nav')

        <div class="col-md-9">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Facility Information</a></li>
              <li><a href="#tab_2" data-toggle="tab">Contact Details</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <h4>Facility Information</h4>
                <!-- form start -->
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputFacilityName" class="col-sm-2 control-label">Facility Name</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFacilityName" placeholder="Facility Name" value="{{ $facility->facility_name }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputFacilityCode" class="col-sm-2 control-label">DOH Facility Code</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputFacilityCode" placeholder="DOH Facility Code" value="{{ $facility->DOH_facility_code }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPhicNo" class="col-sm-2 control-label">PHIC Accr No.</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPhicNo" placeholder="PHIC Accr No" value="{{ $facility->phic_accr_id }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">PHIC Accr Date</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" id="inputPassword3" placeholder="PHIC Accr Date" value="{{ $facility->phic_accr_date }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Ownership Type</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Ownership Type" value="{{ $facility->ownership_type }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Provider Type</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Provider Type" value="{{ $facility->provider_type }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Facility Type</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Facility Type" value="{{ $facility->facility_type }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Registration Date</label>
                      <div class="col-sm-10">
                        <input type="date" class="form-control" id="inputPassword3" placeholder="Registration Date" value="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">BMONC/CMONC</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="BMONC/CMONC">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Can receive referrals?</label>
                      <div class="col-sm-10">
                        <label class="radio-inline"><input type="radio" name="optradio">Yes</label>
                        <label class="radio-inline"><input type="radio" name="optradio">No</label>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right">Update Info</button>
                  </div><!-- /.box-footer -->
                </form>
              </div><!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <h4>Contact Details</h4>
                <!-- form start -->
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Registered Contact Details</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Phone" value="{{ $facilityContact->phone }}">
                      </div>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Mobile Number" value="{{ $facilityContact->mobile }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Website</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Website">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Primary Location</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Primary Location">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Hospital License Number</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Hospital License Number">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Address</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputPassword3" placeholder="Street Address" value="{{ $facilityContact->house_no }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
                      <div class="col-sm-5">
                        <select class="form-control">
                            <option>Region</option>
                        </select>
                      </div>
                      <div class="col-sm-5">
                        <select class="form-control">
                            <option>Province</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
                      <div class="col-sm-5">
                        <select class="form-control">
                            <option>City / Municipal</option>
                        </select>
                      </div>
                      <div class="col-sm-5">
                        <select class="form-control">
                            <option>Barangay</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
                      <div class="col-sm-5">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="ZIP">
                      </div>
                      <div class="col-sm-5">
                        <input type="password" class="form-control" id="inputPassword3" placeholder="Country">
                      </div>
                    </div>
                  </div>
                </form>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right">Update Profile</button>
                </div><!-- /.box-footer -->
              </div><!-- /.tab-pane -->


              </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->

@stop

@section('footer')
<script type="text/javascript">
    $(function () {
      //Initialize Select2 Elements - transfer to footer
      $(".select2").select2();
    });
</script>
@stop
