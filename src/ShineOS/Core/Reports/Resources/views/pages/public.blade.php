@extends('reports::layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-12">
        @if (Session::has('flash_message'))
            <div class="alert {{Session::get('flash_type') }}">{{ Session::get('flash_message') }}</div>
        @endif
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs"  role="tablist">
                <li class="active"><a href="#analytics" data-toggle="tab">SHINEOS+ Analytics</a></li>
                @if(Config::get('config.mode') == 'cloud' OR Config::get('config.mode') == 'training' )
                <li><a href="#FHSIS" data-toggle="tab">FHSIS Reports</a></li>
                <li class="hidden"><a href="#Philhealth" data-toggle="tab">PhilHealth Reports</a></li>
                @endif
                @if(Config::get('config.mode') == 'ce')
                <li><a>DOH & Philhealth Reports are accessible online only.</a></li>
                @endif
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="analytics">
                    @include('reports::pages.analytics')
                </div>
                @if(Config::get('config.mode') == 'cloud' OR Config::get('config.mode') == 'training' )
                <div role="tabpanel" class="tab-pane" id="FHSIS">
                    @include('reports::pages.fhsis')
                </div>
                <div role="tabpanel" class="tab-pane" id="Philhealth">
                    @include('reports::pages.philhealth')
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
