@extends('layout.master')
@section('title') ShineOS+ | User Management @stop

@section('page-header')
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i>
            Users Management
        </h1>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users Management</li>
        </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Facility Users</h3>
                    <div class="box-tools">
                        <div class="input-group pull-right">
                            <a href="{{ url('users/add')}}" class="btn btn-sm btn-primary">Add New User</a>
                        </div>
                    </div>
                </div><!-- /.box-header -->

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

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="UseList">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email Address</th>
                                <!-- <th>Role</th> -->
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $records as $record )
                            <tr>
                                <td>{{ $record->user_id }}</td>
                                <td>{{ $record->first_name }} {{ $record->middle_name }} {{ $record->last_name }}</td>
                                <td>{{ $record->email }}</td>
                                <!-- <td>  to follow  </td> -->
                                <td>
                                    @if ( $record->status == 'Pending' )
                                        <?php $statusClass = 'default'; ?>
                                    @elseif ( $record->status == 'Disabled' )
                                        <?php $statusClass = 'primary'; ?>
                                    @else
                                        <?php $statusClass = 'success'; ?>
                                    @endif
                                    <span class="label label-{{ $statusClass }}">

                                        {{ $record->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ url('/users', [$record->user_id])}}" type="button" class="btn btn-primary btn-flat" title="View User Info"><i class="fa fa-eye"></i> Edit</a>&nbsp;
                                        <?php $disable = ""; ?>
                                        @if ( $record->user_type != 'Admin' )
                                            @if ($record->user_id == $currentID)
                                                <?php $disable = 'disabled'; ?>
                                            @endif
                                            <a href="{{ url('/users/delete', [$record->user_id])}}" {{ $disable }} type="button" class="btn btn-danger btn-flat" title="Delete User"><i class="fa fa-trash-o"></i> Delete</a>
                                        @else
                                        <span type="button" disabled class="btn btn-warning btn-flat" title="Delete User"><i class="fa fa-ban"></i> Fixed </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@stop

@section('scripts')
    <!-- DATA TABES SCRIPT -->
    <script src="{{ asset('public/dist/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/dist/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>

    <!-- DATA TABES SCRIPT -->
    <script src="{{ asset('pages/users/userlist.js') }}" type="text/javascript"></script>
@stop