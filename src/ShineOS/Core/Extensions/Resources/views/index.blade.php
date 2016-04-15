@extends('layout.master')

@section('page-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-gear"></i> @yield('header-content')
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Extensions</li>
    </ol>
  </section>
@stop

@section('content')

    @yield('list-content')

@stop
