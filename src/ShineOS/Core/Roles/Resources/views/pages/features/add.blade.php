@extends('layout.master')
@section('title') ShineOS+ | Role Management - Add Feature @stop

@section('page-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-users"></i>
      Role Management
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ url('/roles') }}">Role Management</a></li>
      <li class="active">Add New Role</li>
    </ol>
  </section>
@stop

@section('content')
    {!! Form::open(array( 'url'=>'roles/add_feature', 'id'=>'feature_form', 'name'=>'feature_form', 'class'=>'form-horizontal' )) !!}

      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <h4>Add Feature</h4>
                @include('roles::partials/_form_feature')
      </div><!-- /.box -->

    {!! Form::close() !!}
@stop