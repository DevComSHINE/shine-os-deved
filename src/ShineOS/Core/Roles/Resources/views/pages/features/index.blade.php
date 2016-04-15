@extends('layout.master')
@section('title') ShineOS+ | Role Management @stop

@section('page-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i>
      Role Management
    </h1>

    {!! Breadcrumbs::render() !!}
  </section>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#role_list" data-toggle="tab">Roles</a></li>
                <li><a href="#feature_list" data-toggle="tab">Features</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="role_list">
                  <div class="box no-border">
                      <div class="input-group-btn mb10">
                        <a href="{{ url('roles/add')}}" class="btn btn-primary pull-right">Add New Role</a>
                      </div>

                      @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                      @endif

                      <div class="box-body table-responsive no-padding overflowx-hidden">
                          <table class="table table-hover">
                            <tr>
                              <th>Role</th>
                              <th>Features</th>
                              <th>Status</th>
                              <th class="text-center">Action</th>
                            </tr>
                            @foreach ($roleItems as $key=>$val)
                            <tr>
                              <td>{{ $val['role_name'] }}</td>
                              <td>
                                @foreach ($val->features as $v)
                                  <span class="label label-primary"> {{ $v->feature_name }} </span> &nbsp;
                                @endforeach
                              </td>
                              <td>
                                {{ $val['deleted_at'] == NULL ? 'Active' : 'Inactive' }}
                              </td>
                              <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('roles.edit', [$val['role_id']]) }}" type="button" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i> Edit </a>
                                    <a href="{{ url('/roles/delete', [$val['role_id']]) }}" type="button" class="btn btn-default btn-flat"><i class="fa fa-trash-o"></i> Delete </a>
                                </div>
                              </td>
                            </tr>
                            @endforeach
                          </table>
                      </div><!-- /.box-body -->
                  </div><!-- /.box -->
                  
                  <div class="box-footer clearfix">
                    <p class="pull-left"></p>
                    <ul class="pagination pagination-sm no-margin pull-right">
                      {!! $roleItems->render() !!}
                    </ul>
                  </div>

                </div><!-- /.tab-pane -->
                <div class="tab-pane" id="feature_list">
                  <div class="box no-border">
                      @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                      @endif

                      <div class="box-body table-responsive no-padding overflowx-hidden">
                        <div class="input-group-btn mb10">
                          <a href="{{ url('roles/add')}}" class="btn btn-primary pull-right">Add New Feature</a>
                        </div>

                        <table class="table table-hover">
                          <tr>
                            <th>Feature Name</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                          </tr>
                          @foreach ($featureItems as $key=>$val)
                            <tr>
                              <td>{{ $val['feature_name'] }}</td>
                              <td>
                                {{ $val['deleted_at'] == NULL ? 'Active' : 'Inactive' }}
                              </td>
                              <td class="text-center">
                                <div class="btn-group">
                                    @if ($val['status'] != 8)
                                      <a href="{{ route('roles.edit', [$val['role_id']]) }}" type="button" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i> Edit </a>
                                      <a href="{{ url('/roles/delete', [$val['role_id']]) }}" type="button" class="btn btn-default btn-flat"><i class="fa fa-trash-o"></i> Delete </a>
                                    @else
                                      <p class="text-green">Core Feature</p>
                                    @endif
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        </table>
                    </div><!-- /.box-body -->
                  </div><!-- /.box -->
                  
                  <div class="box-footer clearfix">
                    <p class="pull-left"></p>
                    <ul class="pagination pagination-sm no-margin pull-right">
                      {!! $roleItems->render() !!}
                    </ul>
                  </div>
                </div><!-- /.tab-pane -->
            </div>
        </div>
    </div>
</div>
@stop