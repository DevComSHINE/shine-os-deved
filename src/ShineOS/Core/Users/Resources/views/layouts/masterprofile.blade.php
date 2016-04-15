@extends('layout.master')

@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="glyphicon glyphicon-user"></i>
        Profile: {{ $userInfo->first_name }} {{ $userInfo->middle_name }} {{ $userInfo->last_name }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <!-- Main content -->
        @yield('profile-content')
    </div><!-- /.row -->
@stop
