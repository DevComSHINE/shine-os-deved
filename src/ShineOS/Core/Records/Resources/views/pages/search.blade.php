@extends('layout.master')
@section('title') ShineOS+ || Search @stop

@section('page-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-search"></i>
      Search
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Search</li>
    </ol>
  </section>
@stop

@section('content')
    @if (Session::has('warning'))
        <div class="alert alert-dismissible alert-warning">
            <p>{{ Session::get('warning') }}</p>
        </div>
    @endif
    
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Search Records</h3>
                </div><!-- /.box-header -->

                @if (Session::has('message'))
                    <div class="alert alert-dismissible alert-success">
                        <button type="button" class="close" data-dismiss="alert">Ã—</button>
                        <p>{{ Session::get('message') }}</p>
                    </div>
                @endif

                @if (Session::has('warning'))
                    <div class="alert alert-dismissible alert-warning">
                        <button type="button" class="close" data-dismiss="alert">Ã—</button>
                        <p>{{ Session::get('warning') }}</p>
                    </div>
                @endif

                <div class="box-body">
                    <p>Kindly fill up the form below to do an advanced search on records.</p>
                    {!! Form::open(array( 'url'=>'records/search/getResults', 'id'=>'searchForm', 'name'=>'searchForm','class'=>'form-horizontal' )) !!}
                      <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="input_name" id="input_name">
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-2 control-label">Sex</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="input_sex" id="input_sex">
                              <option value="">--Select a gender--</option>
                              <option value="F">Female</option>
                              <option value="M">Male</option>
                              <option value="U">Unknown</option>
                            </select>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Age Range</label>
                          <div class="col-sm-10">
                            <select class="form-control" name="input_ageRange" id="input_ageRange">
                              <option value="">--Select an age range--</option>
                              <option value="0-10">0 to 10</option>
                              <option value="11-19">11 to 19</option>
                              <option value="20-39">20 to 39</option>
                              <option value="40-59">40 to 59</option>
                              <option value="60-79">60 to 79</option>
                              <option value="80-99">80 to 99</option>
                              <option value="100-200">100 onwards</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      </div>

                      <hr />

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Barangay</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="input_barangay" id="input_barangay">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-2 control-label">City / Municipality </label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="input_cityMun" id="input_cityMun">
                            </div>
                          </div>
                        </div>
                      </div>

                      <hr />

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Diagnosis</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="input_diagnosis" id="input_diagnosis">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Medical Order</label>
                            <div class="col-sm-10">
                            <select class="form-control" id="input_medicalOrder" name="input_medicalOrder">
                              <option value="" selected="selected">-- Select a medical order --</option>
                              <option value="MO_MED_PRESCRIPTION">Give Medical Prescription</option>
                              <option value="MO_LAB_TEST">Laboratory Exam</option>
                              <option value="MO_PROCEDURE">Medical Procedure</option>
                              <option value="MO_OTHERS">Others</option>
                            </select>
                            </div>
                          </div>
                        </div>
                      </div>

                      <hr />

                      <div class="text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                      </div>
                    {!! Form::close() !!}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@stop