@extends('layout.master')

@section('page-header')
    <section class="content-header">
      <h1>
          <i class="fa fa-fw fa-user"></i> @yield('header-content')
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active"><a href="../records">Records</a></li>
      </ol>
    </section>
@stop

@section('content')
    <div class="row" id="patient-dashboard">
        @yield('list-content')
    </div>
@stop
