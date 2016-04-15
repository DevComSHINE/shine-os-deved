@extends('layout.master')

@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
            <i class="fa fa-users"></i>
            Users Management
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('users') }}">Users</a></li>
        <li class="active">Add User</li>
      </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <!-- Main content -->
        @yield('profile-content')
    </div><!-- /.row -->
@stop
