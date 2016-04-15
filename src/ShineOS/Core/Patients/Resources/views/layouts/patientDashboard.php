@extends('layouts.master')

@section('page-header')
    <section class="content-header">
      <h1>
          <i class="fa fa-fw fa-user"></i> @yield('header-content')
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Patients</li>
      </ol>
    </section>
@stop

@section('list-content')
    <div class="row">
        <!-- Main content -->
        @yield('profile-content')
    </div><!-- /.row -->
@stop
