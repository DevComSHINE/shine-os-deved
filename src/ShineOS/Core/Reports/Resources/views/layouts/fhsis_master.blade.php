@extends('layout.master')

@section('heads')
  <meta name="_token" content="{{ csrf_token() }}">
@stop

@section('page-header')
    <section class="content-header">
      <h1>
        <i class="fa fa-clipboard"></i>
        Reports - @yield('reportTitle')
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{ url('reports') }}">Reports</a></li>
        <li class="active"><a href="{{url('reports#')}}@yield('reportGroup')"> @yield('reportGroup') </a></li>
        <li class="active"> @yield('reportTitle') </li>
      </ol>
    </section>
@stop