@extends('layout.master')
@section('title') ShineOS+ @stop

@section('content')
    @if (Session::has('warning'))
        <div class="alert alert-dismissible alert-warning">
            <p>{{ Session::get('warning') }}</p>
        </div>
    @endif
    <?php
        //dd(Cache::get('facility_details'));
    ?>
    <div class="jumbotron"><!--Jumbotron / Welcome Message-->
        <div class="welcome-widget">
            <h1 class="welcome">Welcome to <b>SHINE</b><sup class="text-shine-green">os+</sup></h1>

            <p><strong>{{ $facilityInfo->facility_name }}</strong></p>
            <p class="subwelcome">ShineOS+ Facility Setup</p>
            <hr>

            <div class="pull-left">
                @if(Session::get('_global_user')->user_type != 'Admin')
                <a href="{{ url('/patients/add')}}" class="ajax-link btn btn-primary">Create New Record</a>

                <a href="{{ url('/records/search')}}" class="ajax-link btn btn-warning">Search Records</a>

                @endif
            </div>

            <div class="pull-right">
                <a href="http://www.shine.ph/support/" class="btn btn-danger marginr-10" target="new">Get Support</a>
                <a href="http://www.shine.ph/shineos/test-drive/" class="btn btn-info" target="new">Take a Tour</a>
            </div>
        </div>
    </div><!--./End Jumbotron-->

    {!! Widget::run('\Widgets\dashboard\profileCompleteness\ProfileCompleteness') !!}

    <div class="row">
        <div class="col-md-6">
            {!! Widget::run('\Widgets\dashboard\VisitList\VisitList') !!}
            {!! Widget::run('\Widgets\dashboard\Analytics\analytics') !!}
        </div><!--./col-md-6-->

        <div class="col-md-6">
            {!! Widget::run('\Widgets\dashboard\TotalCount\TotalCountBox') !!}
        </div><!--./col-md-6-->
    </div><!--./row-->
@stop

@section('scripts')
    <!-- Chart /dashboard-page-->
    <script src="{{ asset('public/dist/plugins/chartjs/Chart.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap Switch JS -->
    <script src="{{ asset('public/dist/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('public/dist/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>
@stop
