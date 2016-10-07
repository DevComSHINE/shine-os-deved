@extends('layout.master')

@section('page-header')
    <section class="content-header">
      <h1>
        <i class="fa fa-clipboard"></i>
        Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>
@stop

<!-- Main content -->
@yield('reports-content')

@section('page_scripts')
<script src="{{ asset('public/dist/plugins/chartjs/Chart.min.js') }}" type="text/javascript"></script>
@stop
