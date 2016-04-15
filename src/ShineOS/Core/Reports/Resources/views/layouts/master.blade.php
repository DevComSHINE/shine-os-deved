@extends('layout.master')

@section('page-header')
	<section class="content-header">
	  <h1>
	  	<i class="fa fa-paper-plane-o"></i>
	    Reports
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active">Reports</li>
	  </ol>
	</section>
@stop

@section('content')
	<!-- Main content -->
	@yield('reports-content')
@stop