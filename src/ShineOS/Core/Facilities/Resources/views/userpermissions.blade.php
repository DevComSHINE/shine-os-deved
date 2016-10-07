@extends('users::layouts.masterprofile')

@section('profile-content')
    <div class="box box-primary">
        <div class="box-header with-border">
          <i class="fa fa-star"></i><h3 class="box-title blue"> Your Profile</h3> &nbsp; <small><em>Completing your profile will help the system work for you better. Head on to your profile to edit.</em></small>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div><!-- /.box-header -->
        <!--Profile Progress-->
        <div class="box-body">
          <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
              <span class="sr-only">40% Complete (success)</span>
            </div>
            <small> Completeness: 66% </small>
          </div>
        </div><!-- /.box-body -->
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border text-center">
                  <h3 class="box-title">Van Alden Enriquez</h3>
                  <p class="text-green">Active</p>
                  <a href="#" title="Change Profile Pic"><img src="{{ asset('public/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image"></a>
                  <h5><strong>Doctor</strong></h5>
                  <h5><strong>Member Since:</strong> July 2, 2015</h5>
                </div>
                <div class="box-body no-padding">
                <!--NOTE:: Super Admin View Only-->
                  <ul class="nav nav-pills nav-stacked text-center">
                    <li><a href="{{ url('/users/123/facilities')}}">Facility</a></li>
                    <li><a href="{{ url('/users/123/permissions')}}">Permissions</a></li>
                    <li><a href="{{ url('/users/123/logs')}}">Audit Trail</a></li>
                  </ul>
                </div><!-- /.box-body -->
            </div><!-- /. box -->
            <a href="#" class="btn btn-danger btn-block margin-bottom">Disable Account</a>
        </div>
        
        <div class="col-md-9">
           <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">User Permissions</h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form role="form">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputFacilityName" class="col-sm-2 control-label">User Group</label>
                      <div class="col-sm-10">
                        <select class="form-control select2" multiple="multiple" data-placeholder="Select a role">
                          <option>Super Administrator</option>
                          <option>Doctor</option>
                          <option>Nurse</option>
                          <option>Midwife</option>
                          <option>Encoder</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputFacilityName" class="col-sm-2 control-label">Permissions</label>
                      <div class="col-sm-10">
                        <div class="row">
                          <div class="col-sm-4">
                          <label class="checkbox-inline"><input type="checkbox" value="">Dashboard</label><br />
                          <label class="checkbox-inline"><input type="checkbox" value="">Reports</label>
                          </div>

                          <div class="col-sm-4">
                          <label class="checkbox-inline"><input type="checkbox" value="">Records</label><br />
                          <label class="checkbox-inline"><input type="checkbox" value="">Calendar</label>
                          </div>

                          <div class="col-sm-4">
                          <label class="checkbox-inline"><input type="checkbox" value="">Referrals</label><br />
                          <label class="checkbox-inline"><input type="checkbox" value="">Analytics</label>
                          </div>
                        </div><!--/.row-->
                      </div><!--/.col-sm-10-->
                    </div>
                  </div>
                </form>
                <div class="box-footer">
                  <button type="submit" class="btn btn-success pull-right">Save Permissions</button>
                </div><!-- /.box-footer -->

           </div>
        </div>
    </div>
@stop