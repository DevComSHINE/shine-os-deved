@extends('layout.master')

@section('page-header')
    <section class="content-header">
      <h1>
          <i class="fa fa-paper-plane-o"></i> Referrals
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Referrals</li>
      </ol>
    </section>
@stop

@section('content')
    <div class="row">
        <!-- Main content -->
        @include('referrals::layouts.sidebar')
        @yield('referral-content')
    </div><!-- /.row -->
@stop
