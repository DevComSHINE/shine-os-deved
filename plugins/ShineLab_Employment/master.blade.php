@extends('patients::layouts.inner')
@section('header-content') Patient's Profile @stop
@section('patient-title') Editing Profile of {{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }} @stop

@section('patient-content')
<div class="nav-tabs-custom">
    @include('pluginform::employment')
</div>
@stop
