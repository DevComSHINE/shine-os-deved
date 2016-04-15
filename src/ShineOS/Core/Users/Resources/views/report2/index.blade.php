@extends('users::layouts.master')

@section('content')
	<div class="col-md-12">
		<p>The Health Reports section allows you create and generate reports required by government. Reporting availability requires accreditation from these goverment agencies. If your facility or practice is not registered and do not have an accreditation number, the reporting function will not be available to you. If you believe you are accredited and want to generate this reports, please enter your accreditation number in your Facility Profile thru your facility administrator.</p>
	</div>

	<div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">PHIE Sync Transmission</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
          <p>Click on the sync button to send your health data to DOH PHIE. Data that has been synced will not be sent to PHIE anymore. Only new records and those that has been modified.</p>
        </div><!-- /.box-header -->
        <div class="box-body text-center">
          <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myPHIE" data-backdrop="static" href="phie">Sync with PHIE</button>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>

    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">DOH FHSIS Reporting</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
          <p>To generate your FHSIS Report by setting the date range you want and clicking on the Generate button.</p>
        </div><!-- /.box-header -->
        <div class="box-body">
			<div class="list-group">
			  	<div class="list-group-item active"><span>Monthly Reports</span></div>
			    <a class="ajax-link list-group-item" href="reports/m1"><i class="fa fa-caret-square-o-right"></i> Program Report M1</a>
			    <a class="ajax-link list-group-item" href="reports/m2"><i class="fa fa-caret-square-o-right"></i> Morbidity Report M2</a>

			    <div class="list-group-item active"><span>Quarterly Reports</span></div>
			    <a class="ajax-link list-group-item" href="reports/q1"><i class="fa fa-caret-square-o-right"></i> Program Report Q1</a>
			    <a class="ajax-link list-group-item" href="reports/q2"><i class="fa fa-caret-square-o-right"></i> Morbidity Report Q2</a>
			    
			    <div class="list-group-item active"><span>Annual Reports</span></div>
			    <a class="ajax-link list-group-item" href="reports/abrgy"><i class="fa fa-caret-square-o-right"></i> A-Brgy</a>
			    <a class="ajax-link list-group-item" href="reports/a1"><i class="fa fa-caret-square-o-right"></i> A1</a>
			    <a class="ajax-link list-group-item" href="reports/a2"><i class="fa fa-caret-square-o-right"></i> A2</a>
			    <a class="ajax-link list-group-item" href="reports/a3"><i class="fa fa-caret-square-o-right"></i> A3</a>
			</div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>

    <div class="col-md-4">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">PhilHealth PCB1 Report</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
          <p>To generate your PHIC PCB1 Report by setting the period and clicking on the Generate button.</p>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="list-group">
			  	<div class="list-group-item active"><span>Primary Care Benefit 1 (Coming Soon!)</span></div>
			    <a class="ajax-link list-group-item" href="#"><i class="fa fa-caret-square-o-right"></i> Annex 1</a>
			    <a class="ajax-link list-group-item" href="#"><i class="fa fa-caret-square-o-right"></i> Annex 2</a>
			    <a class="ajax-link list-group-item" href="#"><i class="fa fa-caret-square-o-right"></i> Annex 3</a>
			    <a class="ajax-link list-group-item" href="#"><i class="fa fa-caret-square-o-right"></i> Annex 4</a>
			    <a class="ajax-link list-group-item" href="#"><i class="fa fa-caret-square-o-right"></i> Annex 5</a>
			</div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
@stop