@extends('layout.master')
@section('title') SHINE OS+ @stop

@section('content')
    @if (Session::has('warning'))
        <div class="alert alert-dismissible alert-warning">
            <p>{{ Session::get('warning') }}</p>
        </div>
    @endif
    <div class="jumbotron"><!--Jumbotron / Welcome Message-->
        <div class="welcome-widget">
            <h1 class="welcome">Welcome to <b>SHINE</b><sup class="text-shine-green">OS+</sup></h1>

            <p><strong>{{ $facilityInfo->facility_name }}</strong></p>
            <p class="subwelcome">SHINE OS+ Facility Setup</p>
            <hr>

            <div class="pull-left">
                <a href="{{ url('/patients/add')}}" class="ajax-link btn btn-primary">Create New Patient</a>
                <a href="{{ url('/records/search')}}" class="ajax-link btn btn-warning"><i class="fa fa-search"></i> | Advanced Search</a>
            </div>

            <div class="pull-right">
                <a href="http://www.shine.ph/support/" class="btn btn-danger marginr-10" target="new">Get Support</a>
                <a href="http://www.shine.ph/shineos/test-drive/" class="btn btn-info" target="new">Take a Tour</a>
            </div>
        </div>
    </div><!--./End Jumbotron-->
    
    {!! AsyncWidget::run('\Widgets\dashboard\profileCompleteness\ProfileCompleteness') !!}

    <div class="row">
        <div class="col-md-6">
            {!! AsyncWidget::run('\Widgets\dashboard\VisitList\VisitList') !!}
            {!! AsyncWidget::run('\Widgets\dashboard\Analytics\analytics') !!}
        </div><!--./col-md-6-->

        <div class="col-md-6">
            {!! AsyncWidget::run('\Widgets\dashboard\TotalCount\TotalCountBox') !!}
        </div><!--./col-md-6-->
    </div><!--./row-->
@stop



