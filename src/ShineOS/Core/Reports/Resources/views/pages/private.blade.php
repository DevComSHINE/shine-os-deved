@extends('reports::layouts.master')

@section('content')
<div class="row">
    <div class="col-xs-12">
        @if (Session::has('flash_message'))
            <div class="alert {{Session::get('flash_type') }}">{{ Session::get('flash_message') }}</div>
        @endif
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#analytics" data-toggle="tab">Analytics</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="analytics">
                  @include('reports::pages.analytics')
                </div><!-- /.tab-pane -->
            </div>
        </div>
    </div>
</div>
@stop
