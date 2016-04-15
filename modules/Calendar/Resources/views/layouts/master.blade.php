@extends('layout.master')
@section('title') ShineOS+ | Calendar @stop

@section('page-header')
	<section class="content-header">
		<h1>
			<i class="fa fa-calendar"></i>
		 	Calendar
		</h1>

		<!--Breadcrumbs-->

	</section>
@stop

@section('content')
	<div class="row">
		<!-- Main content -->
		@yield('calendar-content')
	</div><!-- /.row -->
@stop

