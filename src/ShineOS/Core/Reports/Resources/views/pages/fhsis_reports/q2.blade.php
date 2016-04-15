@section('heads')
{!! HTML::style('public/dist/plugins/stickytableheader/css/component.css') !!}
@stop

@extends('reports::layouts.master')

@section('reports-content')
    <!-- Main content -->
    <section class="fhsis">
      <!-- title row -->
      <div class="row report-header">
        <div class="col-xs-6">
        	<h4>Morbidity Disease Report Q2</h4>
        </div>
        <div class="col-xs-6 text-right">
        	{!! Form::open(array( 'url'=>'reports/m2/', 'id'=>'dateFilter', 'name'=>'dateFilter', 'class'=>'form-horizontal' )) !!}
				<label class="col-sm-2 control-label">Quarter</label>
				<div class="col-sm-3">
					<select name="quarter" class="form-control" id="quarter">
						<option value="" selected="selected"></option>
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
					</select>
				</div>
				<label class="col-sm-2 control-label">Year</label> 
				<div class="col-sm-3">
					<select name="year" class="form-control" id="year">
						<option>2010</option>
						<option>2011</option>
						<option>2012</option>
						<option>2013</option>
						<option>2014</option>
						<option>2015</option>
						<option>2016</option>
						<option>2017</option>
						<option>2018</option>
						<option>2019</option>
						<option>2020</option>
					</select>
				</div>
				<input type="submit" class="btn btn-primary" value="GO">
			{!! Form::close() !!}
        </div>
      </div>
      <!-- info row -->
      <div class="row fhsis-info">
        <div class="col-sm-6 fhsis-col">
          <b>Name of BHS: </b> Test<br/>
          <b>Barangay: </b> Test<br/>
          <b>City / Municipality of: </b> Test
        </div><!-- /.col -->
        <div class="col-sm-6 fhsis-col">
          <b>Province of: </b> Test<br/>
          <b>Projected Population of the Year:</b> 12345<br/>
          <b>Viewed by:</b> Camille
        </div><!-- /.col -->
      </div><!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          @include('reports::pages.fhsis_reports.disease_table')
        </div><!-- /.col -->
      </div><!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="fhsis-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
        </div>
      </div>
    </section><!-- /.content -->
@stop

@section('scripts')
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js"></script>
	{!! HTML::script('public/dist/plugins/stickytableheader/js/jquery.stickyheader.js') !!}
@stop