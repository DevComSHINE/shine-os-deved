@extends('layout.master')

@section('page-header')
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
	  	<i class="fa fa-bell-o"></i>
	     Reminders & Broadcasts
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active">Reminders & Broadcasts</li>
	  </ol>
	</section>
@stop

@section('content')
	<div class="row">
		<!-- Main content -->
		@include('reminders::layouts.sidebar')
		@yield('reminders-content')
	</div><!-- /.row -->
@stop