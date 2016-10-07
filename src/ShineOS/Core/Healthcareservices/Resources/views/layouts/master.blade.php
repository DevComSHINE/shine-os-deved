<?php
    $pid = NULL;
    if(isset($patient))
    {
        $pid = $patient->patient_id;
    }
?>

@extends('layout.master')

@section('page-header')
    <section class="content-header">
      <h1>
          <i class="fa fa-fw fa-user"></i> @yield('header-content')
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url() }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ url('records#visit_list') }}">Healthcare Visits</a></li>
        <li class="active"><a href="{{ url('patients/'.$pid) }}">Patient Dashboard</a></li>
      </ol>
    </section>
@stop

@section('content')
    @yield('healthcareservices-content')
@stop
