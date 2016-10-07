@extends('layout.master')

@section('page-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-hospital-o"></i>
        My Facility
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Facility</li>
      </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <!-- Main content -->
        @yield('profile-content')
    </div><!-- /.row -->
@stop
