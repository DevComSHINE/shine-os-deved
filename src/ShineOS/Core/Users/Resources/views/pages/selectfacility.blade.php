@extends('users::layouts.master')
@section('title') ShineOS+ | Select Facility @stop
@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-6 top40">
			<div class="jumbotron reg-jumbotron">
				<img src="{{ asset('public/dist/img/logos/shinelogo-x-big.png') }}" class="img-responsive" />
				<h2>Select Facility</h2>
			</div>
		</div>

		<div class="col-md-6 top40 bottom40">
			<h4>Pick facility to use?</h4>
			<p>This is a placeholder.</p>
			
			<div class="list-group">
				@foreach( $user->facilities as $facility )
			  		<a href="#" class="list-group-item dataFacility" data-user="{{ $user->user_id }}" data-facility="{{ $facility->facility_id }}">{{ $facility->facility_name }}</a>
			  	@endforeach
			</div>
		</div>
	</div>
</div>
@stop

@section('footer')
	<script src="{{ asset('public/dist/js/pages/login/selecfacility.js') }}"></script>
@stop