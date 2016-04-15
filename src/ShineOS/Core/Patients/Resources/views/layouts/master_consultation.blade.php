@extends('layout.master')

@section('content')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
	  	<i class="fa fa-user"></i>
	    Patient's Consultations
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active"><a href="{{ url('/patients') }}"> Patients </a></li>
	    <li class="active">Consultations</li>
	  </ol>
	</section>

	<section class="content">
	  <div class="row">
	    <!-- Main content -->
		@include('patients::layouts.sidebar_consultation')
		@yield('consultations-content')
      </div><!-- /.row -->
    </section><!-- /.content -->

	
@stop