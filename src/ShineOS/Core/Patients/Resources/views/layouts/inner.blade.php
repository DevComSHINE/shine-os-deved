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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="../../records">Records</a></li>
        <li class="active"><a href="../{{ $pid }}">Patient Dashboard</a></li>
      </ol>
    </section>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@yield('patient-title')</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>

            @yield('patient-info')
        </div>

        <div class="box-body patient-form">
            @yield('patient-content')
        </div><!-- /.box-body -->

        <div class="box-footer">
            @yield('patient-footer')
        </div><!-- /.box-footer-->
    </div>
@stop

@section('linked_scripts')
    {!! HTML::script('public/dist/js/jquery.form.js') !!}
    {!! HTML::script('public/dist/js/jquery.form.wizard.js') !!}
    {!! HTML::script('public/dist/js/jquery.validate.js') !!}
    {!! HTML::script('public/dist/plugins/input-mask/inputmask.js') !!}
    {!! HTML::script('public/dist/plugins/input-mask/inputmask.date.extensions.js') !!}
    {!! HTML::script('public/dist/plugins/input-mask/inputmask.extensions.js') !!}
    {!! HTML::script('public/dist/plugins/input-mask/jquery.inputmask.js') !!}
    {!! HTML::script('public/dist/js/prettify.js') !!}
    {!! HTML::script('public/dist/plugins/chain/jquery.chained.min.js') !!}
    {!! HTML::script('public/dist/plugins/chain/jquery.chained.remote.min.js') !!}
@stop

@section('scripts')
    <script>
        var patientId = "{{ $patient->patient_id or NULL }}";
    </script>
    {!! HTML::script('public/dist/js/pages/patients/patients.js') !!}
@stop
