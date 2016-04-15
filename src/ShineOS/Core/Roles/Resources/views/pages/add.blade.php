@extends('layout.master')
@section('title') ShineOS+ | Role Management - Add @stop

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
    {!! Form::open(array( 'url'=>'roles/add', 'id'=>'role_form', 'name'=>'role_form', 'class'=>'form-horizontal' )) !!}

      <div class="box box-primary">
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <h4>Add Role</h4>
                @include('roles::partials/_form_role')
      </div><!-- /.box -->

    {!! Form::close() !!}
@stop