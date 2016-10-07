@extends('layout.master')
@section('title') SHINE OS+ | Rizal @stop

@section('page-header')
    <section class="content-header">
        <h1>
            <i class="fa fa-cube"></i>
             Rizal Module
        </h1>

        <!--Breadcrumbs-->

    </section>
@stop

@section('content')
    <div class="row">
        <!-- Main content -->
        @yield('rizal-content')
    </div><!-- /.row -->
@stop

