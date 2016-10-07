@extends('users::layouts.masterprofile')

@section('profile-content')
       @include('users::partials.user_nav')

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
                      <th>Login Time</th>
                      <th>Logout Time</th>
                      <th>Device</th>
                    </tr>
                    @foreach ($userLogs as $key=>$val)
                      @foreach ($val->userlogs as $log)
                        <tr>
                          <td>{{ $log->login_datetime }}</td>
                          <td>{{ $log->logout_datetime }}</td>
                          <td>{{ $log->device }}</td>
                        </tr>
                      @endforeach
                    @endforeach
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <p class="pull-left"></p>
                  <ul class="pagination pagination-sm no-margin pull-right">
                    {!! $userLogs->render() !!}
                  </ul>
                </div>
              </div><!-- /.box -->
        </div>
@stop
