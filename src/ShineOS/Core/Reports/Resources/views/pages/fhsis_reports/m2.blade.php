@extends('reports::layouts.fhsis_master')

@section('heads')
{!! HTML::style('public/dist/plugins/stickytableheader/css/component.css') !!}
<style>
    #diseaseTable tr th {
        width: 65px;
    }
</style>
@stop
@section('reportGroup')FHSIS @stop
@section('reportTitle')M2 @stop
@section('content')
    <!-- Main content -->
    <section class="fhsis">
      <!-- title row -->
      <div class="row report-header">
        <div class="col-xs-6">
            <h4>Morbidity Diseases Report M2</h4>
        </div>
        <div class="col-xs-6 text-right">
            {!! Form::open(array( 'url'=>'reports/fhsis/m2/', 'id'=>'dateFilter', 'name'=>'dateFilter', 'class'=>'form-horizontal' )) !!}
                <label class="col-sm-2 control-label">Month</label>
                <div class="col-sm-3">
                    <select name="month" class="form-control" id="month">
                        <option value="" selected="selected"></option>
                        <option value="1" @if($month == '1') selected='selected'@endif >January</option>
                        <option value="2" @if($month == '2') selected='selected'@endif >February</option>
                        <option value="3" @if($month == '3') selected='selected'@endif >March</option>
                        <option value="4" @if($month == '4') selected='selected'@endif >April</option>
                        <option value="5" @if($month == '5') selected='selected'@endif >May</option>
                        <option value="6" @if($month == '6') selected='selected'@endif >June</option>
                        <option value="7" @if($month == '7') selected='selected'@endif >July</option>
                        <option value="8" @if($month == '8') selected='selected'@endif >August</option>
                        <option value="9" @if($month == '9') selected='selected'@endif >September</option>
                        <option value="10" @if($month == '10') selected='selected'@endif >October</option>
                        <option value="11" @if($month == '11') selected='selected'@endif >November</option>
                        <option value="12" @if($month == '12') selected='selected'@endif >December</option>
                    </select>
                </div>
                <label class="col-sm-1 control-label">Year</label>
                <div class="col-sm-3">
                    <?php $thisyear = date('Y'); ?>
                    <select name="year" class="form-control" id="year">
                        @for( $y=$thisyear-5; $y<=$thisyear; $y++)
                        <option @if($year == $y) selected='selected'@endif >{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" value="View">
            {!! Form::close() !!}
        </div>
      </div>
      <!-- info row -->
      <div class="row fhsis-info">
        <div class="col-sm-5 fhsis-col">
          <div class="col-md-6"><b>Name of BHS: </b></div><div class="col-md-6">{{ $facility->facility_name }}</div>
          <div class="col-md-6"><b>Barangay: </b></div><div class="col-md-6">{{ getBrgyName($facility->facility_contact->barangay) }}</div>
          <div class="col-md-6"><b>City / Municipality of:</b></div><div class="col-md-6">{{ getCityName($facility->facility_contact->city) }}</div>
        </div><!-- /.col -->
        <div class="col-sm-7 fhsis-col">
          <div class="col-md-5"><b>Province of: </b></div><div class="col-md-7">{{ getProvinceName($facility->facility_contact->province) }}</div>
          <div class="col-md-5"><b>Year's Projected Population:</b></div><div class="col-md-7">12345</div>
          <div class="col-md-5"><b>Viewed by:</b></div><div class="col-md-7">{{ $facility->facility_id }}</div>
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
