@extends('users::layouts.master')
@section('title') SHINE OS+ | Select Facility @stop
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
            <h3>Multiple SHINEOS+ Accounts</h3>
            <p>You are part of more than one SHINEOS+ Facilities. Please choose the facility/clinic you want to login to. Only your patients that is recorded in that facility/clinic will be accessible.</p>

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
