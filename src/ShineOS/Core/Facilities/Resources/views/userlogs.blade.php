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
          <!-- Custom Tabs -->
          <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">User Logs</h3>
                  <div class="box-tools">
                    <div class="input-group" style="width: 350px;">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search" />
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>ID</th>
                      <th>Transaction Date</th>
                      <th>Action</th>
                      <th>Entity Type</th>
                      <th>Entity Details</th>
                      <th>Status</th>
                    </tr>
                    <tr>
                      <td>183</td>
                      <td>11-7-2014</td>
                      <td>Login</td>
                      <td>Login</td>
                      <td>User logged in using blah blah</td>
                      <td>Success</td>
                    </tr>
                    <tr>
                      <td>1813</td>
                      <td>11-7-2014</td>
                      <td>Login</td>
                      <td>Login</td>
                      <td>User logged in using blah blah</td>
                      <td>Success</td>
                    </tr>
                    <tr>
                      <td>1383</td>
                      <td>11-7-2014</td>
                      <td>Login</td>
                      <td>Login</td>
                      <td>User logged in using blah blah</td>
                      <td>Success</td>
                    </tr>
                    <tr>
                      <td>13</td>
                      <td>11-7-2014</td>
                      <td>Login</td>
                      <td>Login</td>
                      <td>User logged in using blah blah</td>
                      <td>Success</td>
                    </tr>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <p class="pull-left">50 out of 100</p>
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
                </div>
              </div><!-- /.box -->
        </div>
    </div>
@stop