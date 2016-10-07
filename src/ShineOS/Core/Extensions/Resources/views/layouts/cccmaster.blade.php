@extends('layout.master')

@section('content')
	<section class="content-header">
	  <h1>
	  	<i class="fa fa-fw fa-user"></i> @yield('header-content') 
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	    <li class="active">Settings</li>
	  </ol>
	</section>

	<section class="content">
		<div class="row">
			@yield('settings-content')
		</div>
    </section><!-- /.content -->
@stop

