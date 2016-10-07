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
@section('reportTitle')FHSIS M1 @stop
@section('content')
<!--NOTE:: SEPARATE PORTIONS-->
<div class="row">
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Program Report M1</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-print"></i></button>
          </div><!-- /.box-tool -->
        </div><!-- /.box-header -->
        <div class="box-body text-center">
            <table class="table table-striped table-bordered table-report">
                <tbody><tr><th class="thleft">FHSIS Report Month/Year</th><td>
                    {!! Form::open(array( 'url'=>'reports/fhsis/m1/', 'id'=>'dateFilter', 'name'=>'dateFilter', 'class'=>'form-horizontal' )) !!}
                        <label class="col-sm-1 control-label">Month</label>
                        <div class="col-sm-3">
                            <input type="hidden" value="m" name="range">
                            <select name="month" class="form-control" id="month">
                                <option value="" selected="selected"></option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7" selected="">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <label class="col-sm-1 control-label">Year</label>
                        <div class="col-sm-3">
                            <select name="year" class="form-control" id="year">
                                <option>2010</option>
                                <option>2011</option>
                                <option>2012</option>
                                <option>2013</option>
                                <option>2014</option>
                                <option>2015</option>
                                <option selected="">2016</option>
                                <option>2017</option>
                                <option>2018</option>
                                <option>2019</option>
                                <option>2020</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-primary" value="View">
                    {!! Form::close() !!}
                </td></tr>
                <tr><th class="thleft">Name of BHS</th><td>{{ $facility->facility_name }}</td></tr>
                <tr><th class="thleft">Barangay</th><td>{{ getBrgyName($facility->facility_contact->barangay) }}</td></tr>
                <tr><th class="thleft">City/Municipality of</th><td>{{ getCityName($facility->facility_contact->city) }}</td></tr>
                <tr><th class="thleft">Province of</th><td>{{ getProvinceName($facility->facility_contact->province) }}</td></tr>
                <tr><th class="thleft">Projected Population of the Year</th><td></td></tr>
                </tbody>
            </table><!-- /table details -->

            <table class="table table-striped table-bordered table-report">
                <thead>
                <tr>
                    <th width="55%">MATERNAL CARE</th>
                    <th>NO.</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Pregnant women with 4 or more Prenatal visits</td>
                    <td>{{ $Pre4Visit = ShineOS\Core\Reports\Entities\M1::scopePre4Visit($month, $year) }}</td>
                </tr>
                <tr>
                    <td>Pregnant women given 2 doses of Tetanus Toxoid</td>
                    <td>{{ $TT2X = ShineOS\Core\Reports\Entities\M1::scopeTT2x($month, $year) }}</td>
                </tr>
                <tr>
                    <td>Pregnant women given TT2 plus</td>
                    <td>{{ $TT2 = ShineOS\Core\Reports\Entities\M1::scopeTT2($month, $year) }}</td>
                </tr>
                <tr>
                    <td>Preg. women given complete iron w/ folic acid supplementation</td>
                    <td>{{ $PreIron = ShineOS\Core\Reports\Entities\M1::scopePreIron($month, $year) }}</td>
                </tr>
                <tr>
                    <td>Postpartum women with at least 2 postpartum visits</td>
                    <td>{{ $PP2V = ShineOS\Core\Reports\Entities\M1::scopePP2V($month, $year) }}</td>
                </tr>
                <tr>
                    <td>Postpartum women given complete iron supplementation</td>
                    <td>{{ $PPIron = ShineOS\Core\Reports\Entities\M1::scopePPIron($month, $year) }}</td>
                </tr>
                <tr>
                    <td>Postpartum women given Vitamin A supplementation</td>
                    <td>{{ $PPVitA = ShineOS\Core\Reports\Entities\M1::scopePPVitA($month, $year) }}</td>
                </tr>
                <tr>
                    <td>PP women initiated breastfeeding w/in 1 hr. after delivery</td>
                    <td>{{ $BFeeding = ShineOS\Core\Reports\Entities\M1::scopeBFeeding($month, $year) }}</td>
                </tr>
                <tr>
                    <td>Women 10-49 years old given Iron supplementation</td>
                    <td>{{ $deliveries = ShineOS\Core\Reports\Entities\M1::scopeIronSup($month, $year) }}</td>
                </tr>
                <tr>
                    <td>Deliveries</td>
                    <td>{{ $deliveries = ShineOS\Core\Reports\Entities\M1::scopeDeliveries($month, $year) }}</td>
                </tr>
                </tbody>
            </table><!-- /table Maternal -->
            <table class="table table-striped table-bordered table-report table-responsive">
                <thead>
                <tr>
                <th rowspan="3">FAMILY PLANNING METHOD</th>
                <th rowspan="3" width="10%">Current User<br>(Beginning Month)</th>
                <th colspan="2">Acceptors</th>
                <th rowspan="3" width="10%">Dropout<br>(Present Month)</th>
                <th rowspan="3" width="10%">Current User<br>(End of Month)</th>
                <th rowspan="3" width="10%">New Acceptors of<br>the present Month</th>
                </tr>
                <tr><th width="10%">New Acceptors</th><th width="10%">Other Acceptors</th></tr>
                <tr><th>Previous Month</th><th>Present Month</th></tr>
                </thead>

                <tbody>
                <tr>
                    <td>a. Female Sterilization/BTL</td>
                    <td>{{ $fstrbtlcub = ShineOS\Core\Reports\Entities\M1FP::doFP('FSTR/BTL','CU_begin',$month, $year) }}</td>
                    <td>{{ $fstrbtlpna = ShineOS\Core\Reports\Entities\M1FP::doFP('FSTR/BTL','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $fstrbtloa = ShineOS\Core\Reports\Entities\M1FP::doFP('FSTR/BTL','OA',$month, $year) }}</td>
                    <td>{{ $fstrbtldo = ShineOS\Core\Reports\Entities\M1FP::doFP('FSTR/BTL','Dropout',$month, $year) }}</td>
                    <td>{{ $fstrbtlcue = ShineOS\Core\Reports\Entities\M1FP::doFP('FSTR/BTL','CU_end',$month, $year) }}</td>
                    <td>{{ $fstrbtlcna = ShineOS\Core\Reports\Entities\M1FP::doFP('FSTR/BTL','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>b. Male Sterilization/Vasectomy</td>
                    <td>{{ $vastcub = ShineOS\Core\Reports\Entities\M1FP::doFP('MSTR/VASECTOMY','CU_begin',$month, $year) }}</td>
                    <td>{{ $vastpna = ShineOS\Core\Reports\Entities\M1FP::doFP('MSTR/VASECTOMY','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $vastoa = ShineOS\Core\Reports\Entities\M1FP::doFP('MSTR/VASECTOMY','OA',$month, $year) }}</td>
                    <td>{{ $vastdo = ShineOS\Core\Reports\Entities\M1FP::doFP('MSTR/VASECTOMY','Dropout',$month, $year) }}</td>
                    <td>{{ $vastcue = ShineOS\Core\Reports\Entities\M1FP::doFP('MSTR/VASECTOMY','CU_end',$month, $year) }}</td>
                    <td>{{ $vastcna = ShineOS\Core\Reports\Entities\M1FP::doFP('MSTR/VASECTOMY','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>c. Pills</td>
                    <td>{{ $pillcub = ShineOS\Core\Reports\Entities\M1FP::doFP('PILLS','CU_begin',$month, $year) }}</td>
                    <td>{{ $pillpna = ShineOS\Core\Reports\Entities\M1FP::doFP('PILLS','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $pilloa = ShineOS\Core\Reports\Entities\M1FP::doFP('PILLS','OA',$month, $year) }}</td>
                    <td>{{ $pilldo = ShineOS\Core\Reports\Entities\M1FP::doFP('PILLS','Dropout',$month, $year) }}</td>
                    <td>{{ $pillcue = ShineOS\Core\Reports\Entities\M1FP::doFP('PILLS','CU_end',$month, $year) }}</td>
                    <td>{{ $pillcna = ShineOS\Core\Reports\Entities\M1FP::doFP('PILLS','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>d. IUD (Intrauterine Device)</td>
                    <td>{{ $iudcub = ShineOS\Core\Reports\Entities\M1FP::doFP('IUD','CU_begin',$month, $year) }}</td>
                    <td>{{ $iudpna = ShineOS\Core\Reports\Entities\M1FP::doFP('IUD','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $iudoa = ShineOS\Core\Reports\Entities\M1FP::doFP('IUD','OA',$month, $year) }}</td>
                    <td>{{ $iuddo = ShineOS\Core\Reports\Entities\M1FP::doFP('IUD','Dropout',$month, $year) }}</td>
                    <td>{{ $iudcue = ShineOS\Core\Reports\Entities\M1FP::doFP('IUD','CU_end',$month, $year) }}</td>
                    <td>{{ $iudcna = ShineOS\Core\Reports\Entities\M1FP::doFP('IUD','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>e. Injectables (DMPA/CIC)</td>
                    <td>{{ $injcub = ShineOS\Core\Reports\Entities\M1FP::doFP('INJ','CU_begin',$month, $year) }}</td>
                    <td>{{ $injpna = ShineOS\Core\Reports\Entities\M1FP::doFP('INJ','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $injoa = ShineOS\Core\Reports\Entities\M1FP::doFP('INJ','OA',$month, $year) }}</td>
                    <td>{{ $injdo = ShineOS\Core\Reports\Entities\M1FP::doFP('INJ','Dropout',$month, $year) }}</td>
                    <td>{{ $injcue = ShineOS\Core\Reports\Entities\M1FP::doFP('INJ','CU_end',$month, $year) }}</td>
                    <td>{{ $injcna = ShineOS\Core\Reports\Entities\M1FP::doFP('INJ','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>f. NFP-CM (Cervical Mucus)</td>
                    <td>{{ $nfpcmcub = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-CM','CU_begin',$month, $year) }}</td>
                    <td>{{ $nfpcmpna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-CM','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $nfpcmoa = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-CM','OA',$month, $year) }}</td>
                    <td>{{ $nfpcmdo = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-CM','Dropout',$month, $year) }}</td>
                    <td>{{ $nfpcmcue = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-CM','CU_end',$month, $year) }}</td>
                    <td>{{ $nfpcmcna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-CM','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>g. NFP-BBT (Basal Body Temperature)</td>
                    <td>{{ $nfpbbtcub = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-BBT','CU_begin',$month, $year) }}</td>
                    <td>{{ $nfpbbtpna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-BBT','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $nfpbbtoa = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-BBT','OA',$month, $year) }}</td>
                    <td>{{ $nfpbbtdo = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-BBT','Dropout',$month, $year) }}</td>
                    <td>{{ $nfpbbtcue = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-BBT','CU_end',$month, $year) }}</td>
                    <td>{{ $nfpbbtcna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-BBT','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>h. NFP-STM (Symptothermal Method)</td>
                    <td>{{ $nfpstmcub = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-STM','CU_begin',$month, $year) }}</td>
                    <td>{{ $nfpstmpna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-STM','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $nfpstmoa = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-STM','OA',$month, $year) }}</td>
                    <td>{{ $nfpstmdo = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-STM','Dropout',$month, $year) }}</td>
                    <td>{{ $nfpstmcue = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-STM','CU_end',$month, $year) }}</td>
                    <td>{{ $nfpstmcna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-STM','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>i. NFP-SDM (Standard Days Method)</td>
                    <td>{{ $nfpsdmcub = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-SDM','CU_begin',$month, $year) }}</td>
                    <td>{{ $nfpsdmpna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-SDM','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $nfpsdmoa = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-SDM','OA',$month, $year) }}</td>
                    <td>{{ $nfpsdmdo = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-SDM','Dropout',$month, $year) }}</td>
                    <td>{{ $nfpsdmcue = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-SDM','CU_end',$month, $year) }}</td>
                    <td>{{ $nfpsdmcna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-SDM','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>j. NFP-LAM (Lactational Amenorrhea Method)</td>
                    <td>{{ $nfplamcub = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-LAM','CU_begin',$month, $year) }}</td>
                    <td>{{ $nfplampna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-LAM','NA',$month, $year,'prev') }}</td>
                    <td>{{ $nfplamoa = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-LAM','OA',$month, $year) }}</td>
                    <td>{{ $nfplamdo = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-LAM','Dropout',$month, $year) }}</td>
                    <td>{{ $nfplamcue = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-LAM','CU_end',$month, $year) }}</td>
                    <td>{{ $nfplamcna = ShineOS\Core\Reports\Entities\M1FP::doFP('NFP-LAM','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>k. Condom</td>
                    <td>{{ $concub = ShineOS\Core\Reports\Entities\M1FP::doFP('CON','CU_begin',$month, $year) }}</td>
                    <td>{{ $conpna = ShineOS\Core\Reports\Entities\M1FP::doFP('CON','NA',$month, $year, 'prev') }}</td>
                    <td>{{ $conoa = ShineOS\Core\Reports\Entities\M1FP::doFP('CON','OA',$month, $year) }}</td>
                    <td>{{ $condo = ShineOS\Core\Reports\Entities\M1FP::doFP('CON','Dropout',$month, $year) }}</td>
                    <td>{{ $concue = ShineOS\Core\Reports\Entities\M1FP::doFP('CON','CU_end',$month, $year) }}</td>
                    <td>{{ $concna = ShineOS\Core\Reports\Entities\M1FP::doFP('CON','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>l. Implant</td>
                    <td>{{ $impcub = ShineOS\Core\Reports\Entities\M1FP::doFP('IMPLANT','CU_begin',$month, $year) }}</td>
                    <td>{{ $imppna = ShineOS\Core\Reports\Entities\M1FP::doFP('IMPLANT','NA',$month, $year,'prev') }}</td>
                    <td>{{ $impoa = ShineOS\Core\Reports\Entities\M1FP::doFP('IMPLANT','OA',$month, $year) }}</td>
                    <td>{{ $impdo = ShineOS\Core\Reports\Entities\M1FP::doFP('IMPLANT','Dropout',$month, $year) }}</td>
                    <td>{{ $impcue = ShineOS\Core\Reports\Entities\M1FP::doFP('IMPLANT','CU_end',$month, $year) }}</td>
                    <td>{{ $impcna = ShineOS\Core\Reports\Entities\M1FP::doFP('IMPLANT','NA',$month, $year) }}</td>
                </tr>
                <tr>
                    <td>TOTAL</td>
                    <td>{{ $totalcub = $fstrbtlcub + $vastcub + $pillcub + $iudcub + $injcub + $nfpcmcub + $nfpbbtcub + $nfpstmcub + $nfpsdmcub + $nfplamcub + $concub + $impcub }}</td>
                    <td>{{ $totalpna = $fstrbtlpna + $vastpna + $pillpna + $iudpna + $injpna + $nfpcmpna + $nfpbbtpna + $nfpstmpna + $nfpsdmpna + $nfplampna + $conpna + $imppna }}</td>
                    <td>{{ $totaloa = $fstrbtloa + $vastoa + $pilloa + $iudoa + $injoa + $nfpcmoa + $nfpbbtoa + $nfpstmoa + $nfpsdmoa + $nfplamoa + $conoa + $impoa }}</td>
                    <td>{{ $totaldo = $fstrbtldo + $vastdo + $pilldo + $iuddo + $injdo + $nfpcmdo + $nfpbbtdo + $nfpstmdo + $nfpsdmdo + $nfplamdo + $condo + $impdo }}</td>
                    <td>{{ $totalcue = $fstrbtlcue + $vastcue + $pillcue + $iudcue + $injcue + $nfpcmcue + $nfpbbtcue + $nfpstmcue + $nfpsdmcue + $nfplamcue + $concue + $impcue }}</td>
                    <td>{{ $totalcna = $fstrbtlcna + $vastcna + $pillcna + $iudcna + $injcna + $nfpcmcna + $nfpbbtcna + $nfpstmcna + $nfpsdmcna + $nfplamcna + $concna + $impcna }}</td>
                </tr>
                </tbody>
            </table><!-- /table family planning -->
            <table class="table table-striped table-bordered table-report">
                <thead>
                <tr>
                <th>CHILD CARE - Part 1</th>
                <th width="15%">Male</th>
                <th width="15%">Female</th>
                <th width="15%">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>BCG</td>
                    <td>{{ $scopeBCGM = ShineOS\Core\Reports\Entities\M1::scopeCCare('BCG', 'M', $month, $year) }}</td>
                    <td>{{ $scopeBCGF = ShineOS\Core\Reports\Entities\M1::scopeCCare('BCG', 'F', $month, $year) }}</td>
                    <td>{{ $scopeBCGM + $scopeBCGF }}</td>
                </tr>
                <tr>
                    <td>Hepa B1 (w/in 24 hrs)</td>
                    <td>{{ $scopeHPB1M = ShineOS\Core\Reports\Entities\M1::scopeCCare('HPB1', 'M', $month, $year) }}</td>
                    <td>{{ $scopeHPB1F = ShineOS\Core\Reports\Entities\M1::scopeCCare('HPB1', 'F', $month, $year) }}</td>
                    <td>{{ $scopeHPB1M + $scopeHPB1F  }}</td>
                </tr>
                <tr>
                    <td>Hepa B1 (&gt;24 hrs)</td>
                    <td>{{ $scopeHPB2M = ShineOS\Core\Reports\Entities\M1::scopeCCare('HPB2', 'M', $month, $year) }}</td>
                    <td>{{ $scopeHPB2F = ShineOS\Core\Reports\Entities\M1::scopeCCare('HPB2', 'F', $month, $year) }}</td>
                    <td>{{ $scopeHPB2M + $scopeHPB2F  }}</td>
                </tr>
                <tr>
                    <td>Penta 1</td>
                    <td>{{ $scopePENTA1M = ShineOS\Core\Reports\Entities\M1::scopeCCare('PENTA1', 'M', $month, $year) }}</td>
                    <td>{{ $scopePENTA1F = ShineOS\Core\Reports\Entities\M1::scopeCCare('PENTA1', 'F', $month, $year) }}</td>
                    <td>{{ $scopePENTA1M + $scopePENTA1F }}</td>
                </tr>
                <tr>
                    <td>Penta 2</td>
                    <td>{{ $scopePENTA2M = ShineOS\Core\Reports\Entities\M1::scopeCCare('PENTA1', 'M', $month, $year) }}</td>
                    <td>{{ $scopePENTA2F = ShineOS\Core\Reports\Entities\M1::scopeCCare('PENTA1', 'F', $month, $year) }}</td>
                    <td>{{ $scopePENTA2M + $scopePENTA2F }}</td>
                </tr>
                <tr>
                    <td>Penta 3</td>
                    <td>{{ $scopePENTA3M = ShineOS\Core\Reports\Entities\M1::scopeCCare('PENTA1', 'M', $month, $year) }}</td>
                    <td>{{ $scopePENTA3F = ShineOS\Core\Reports\Entities\M1::scopeCCare('PENTA1', 'F', $month, $year) }}</td>
                    <td>{{ $scopePENTA3M + $scopePENTA3F }}</td>
                </tr>
                <tr>
                    <td>OPV 1</td>
                    <td>{{ $scopeOPV1M = ShineOS\Core\Reports\Entities\M1::scopeCCare('OPV1', 'M', $month, $year) }}</td>
                    <td>{{ $scopeOPV1F = ShineOS\Core\Reports\Entities\M1::scopeCCare('OPV1', 'F', $month, $year) }}</td>
                    <td>{{ $scopeOPV1M + $scopeOPV1F }}</td>
                </tr>
                <tr>
                    <td>OPV 2</td>
                    <td>{{ $scopeOPV2M = ShineOS\Core\Reports\Entities\M1::scopeCCare('OPV2', 'M', $month, $year) }}</td>
                    <td>{{ $scopeOPV2F = ShineOS\Core\Reports\Entities\M1::scopeCCare('OPV2', 'F', $month, $year) }}</td>
                    <td>{{ $scopeOPV2M + $scopeOPV2F }}</td>
                </tr>
                <tr>
                    <td>OPV 3</td>
                    <td>{{ $scopeOPV3M = ShineOS\Core\Reports\Entities\M1::scopeCCare('OPV3', 'M', $month, $year) }}</td>
                    <td>{{ $scopeOPV3F = ShineOS\Core\Reports\Entities\M1::scopeCCare('OPV3', 'F', $month, $year) }}</td>
                    <td>{{ $scopeOPV3M + $scopeOPV3F }}</td>
                </tr>
                <tr>
                    <td>MCV1 (AMV)</td>
                    <td>{{ $scopeMCV1M = ShineOS\Core\Reports\Entities\M1::scopeCCare('MCV1', 'M', $month, $year) }}</td>
                    <td>{{ $scopeMCV1F = ShineOS\Core\Reports\Entities\M1::scopeCCare('MCV1', 'F', $month, $year) }}</td>
                    <td>{{ $scopeMCV1M + $scopeMCV1F }}</td>
                </tr>
                <tr>
                    <td>MCV2 (MMR)</td>
                    <td>{{ $scopeMCV2M = ShineOS\Core\Reports\Entities\M1::scopeCCare('MCV2', 'M', $month, $year) }}</td>
                    <td>{{ $scopeMCV2F = ShineOS\Core\Reports\Entities\M1::scopeCCare('MCV2', 'F', $month, $year) }}</td>
                    <td>{{ $scopeMCV2M + $scopeMCV2F }}</td>
                </tr>
                <tr>
                    <td>Rota 1</td>
                    <td>{{ $scopeROTA1M = ShineOS\Core\Reports\Entities\M1::scopeCCare('ROTA1', 'M', $month, $year) }}</td>
                    <td>{{ $scopeROTA1F = ShineOS\Core\Reports\Entities\M1::scopeCCare('ROTA1', 'F', $month, $year) }}</td>
                    <td>{{ $scopeROTA1M + $scopeROTA1F }}</td>
                </tr>
                <tr>
                    <td>Rota 2</td>
                    <td>{{ $scopeROTA2M = ShineOS\Core\Reports\Entities\M1::scopeCCare('ROTA2', 'M', $month, $year) }}</td>
                    <td>{{ $scopeROTA2F = ShineOS\Core\Reports\Entities\M1::scopeCCare('ROTA2', 'F', $month, $year) }}</td>
                    <td>{{ $scopeROTA2M + $scopeROTA2F }}</td>
                </tr>
                <tr>
                    <td>Rota 3</td>
                    <td>{{ $scopeROTA3M = ShineOS\Core\Reports\Entities\M1::scopeCCare('ROTA3', 'M', $month, $year) }}</td>
                    <td>{{ $scopeROTA3F = ShineOS\Core\Reports\Entities\M1::scopeCCare('ROTA3', 'F', $month, $year) }}</td>
                    <td>{{ $scopeROTA3M + $scopeROTA3F }}</td>
                </tr>
                <tr>
                    <td>PCV 1</td>
                    <td>{{ $scopePCV1M = ShineOS\Core\Reports\Entities\M1::scopeCCare('PCV1', 'M', $month, $year) }}</td>
                    <td>{{ $scopePCV1F = ShineOS\Core\Reports\Entities\M1::scopeCCare('PCV1', 'F', $month, $year) }}</td>
                    <td>{{ $scopePCV1M + $scopePCV1F }}</td>
                </tr>
                <tr>
                    <td>PCV 2</td>
                    <td>{{ $scopePCV2M = ShineOS\Core\Reports\Entities\M1::scopeCCare('PCV2', 'M', $month, $year) }}</td>
                    <td>{{ $scopePCV2F = ShineOS\Core\Reports\Entities\M1::scopeCCare('PCV2', 'F', $month, $year) }}</td>
                    <td>{{ $scopePCV2M + $scopePCV2F }}</td>
                </tr>
                <tr>
                    <td>PCV 3</td>
                    <td>{{ $scopePCV3M = ShineOS\Core\Reports\Entities\M1::scopeCCare('PCV3', 'M', $month, $year) }}</td>
                    <td>{{ $scopePCV3F = ShineOS\Core\Reports\Entities\M1::scopeCCare('PCV3', 'F', $month, $year) }}</td>
                    <td>{{ $scopePCV3M + $scopePCV3F }}</td>
                </tr>
                <tr>
                    <td>Fully Immunized Child (0-11 mos)</td>
                    <td>{{ $scopeFullM = ShineOS\Core\Reports\Entities\M1::scopeFullImmune('M', $month, $year) }}</td>
                    <td>{{ $scopeFullF = ShineOS\Core\Reports\Entities\M1::scopeFullImmune('F', $month, $year) }}</td>
                    <td>{{ $scopeFullM + $scopeFullF }}</td>
                </tr>
                <tr>
                    <td>Completely Immunized Child (12-23 mos)</td>
                    <td>{{ $scopeComplM = ShineOS\Core\Reports\Entities\M1::scopeCompleteImmune('M', $month, $year) }}</td>
                    <td>{{ $scopeComplF = ShineOS\Core\Reports\Entities\M1::scopeCompleteImmune('F', $month, $year) }}</td>
                    <td>{{ $scopeComplM + $scopeComplF }}</td>
                </tr>
                <tr>
                    <td>Total Live births</td>
                    <td>{{ $scopeLBM = ShineOS\Core\Reports\Entities\M1::scopeLiveBirth('M', $month, $year) }}</td>
                    <td>{{ $scopeLBF = ShineOS\Core\Reports\Entities\M1::scopeLiveBirth('F', $month, $year) }}</td>
                    <td>{{ $scopeLBM + $scopeLBF }}</td>
                </tr>
                <tr>
                    <td>Child Protected at Birth</td>
                    <td>{{ $scopeCProM = ShineOS\Core\Reports\Entities\M1::scopeChildProtect('M', $month, $year) }}</td>
                    <td>{{ $scopeCProF = ShineOS\Core\Reports\Entities\M1::scopeChildProtect('F', $month, $year) }}</td>
                    <td>{{ $scopeCProM + $scopeCProF }}</td>
                </tr>
                <tr>
                    <td>Infant Age 6 months seen</td>
                    <td>{{ $scopeSeenM = ShineOS\Core\Reports\Entities\M1::scopeSixMonthSeen('M', $month, $year) }}</td>
                    <td>{{ $scopeSeenF = ShineOS\Core\Reports\Entities\M1::scopeSixMonthSeen('F', $month, $year) }}</td>
                    <td>{{ $scopeSeenM + $scopeSeenF }}</td>
                </tr>
                <tr>
                    <td>Infant exclusively breastfed until 6 months</td>
                    <td>{{ $scopeBFM = ShineOS\Core\Reports\Entities\M1::scopeBreastFeed('M', $month, $year) }}</td>
                    <td>{{ $scopeBFF = ShineOS\Core\Reports\Entities\M1::scopeBreastFeed('F', $month, $year) }}</td>
                    <td>{{ $scopeBFM + $scopeBFF }}</td>
                </tr>
                <thead>
                <tr>
                <th>CHILD CARE - Part 2</th>
                <th width="15%">Male</th>
                <th width="15%">Female</th>
                <th width="15%">Total</th>
                </tr>
                </thead>
                <tr>
                    <td>Infant given complimentary food from 6-8 months</td>
                    <td>{{ $scopeCompFoodM = ShineOS\Core\Reports\Entities\M1::scopeCompFood('M', $month, $year) }}</td>
                    <td>{{ $scopeCompFoodF = ShineOS\Core\Reports\Entities\M1::scopeCompFood('F', $month, $year) }}</td>
                    <td>{{ $scopeCompFoodM + $scopeCompFoodF }}</td>
                </tr>
                <tr>
                    <td>Infant for newborn screening : referred</td>
                    <td>{{ $scopeNBornRefM = ShineOS\Core\Reports\Entities\M1::scopeNBornRef('M', $month, $year) }}</td>
                    <td>{{ $scopeNBornRefF = ShineOS\Core\Reports\Entities\M1::scopeNBornRef('F', $month, $year) }}</td>
                    <td>{{ $scopeNBornRefM + $scopeNBornRefF }}</td>
                </tr>
                <tr>
                    <td>Infant for newborn screening : done</td>
                    <td>{{ $scopeNBornDM = ShineOS\Core\Reports\Entities\M1::scopeNBornDone('M', $month, $year) }}</td>
                    <td>{{ $scopeNBornDF = ShineOS\Core\Reports\Entities\M1::scopeNBornDone('F', $month, $year) }}</td>
                    <td>{{ $scopeNBornDM + $scopeNBornDF }}</td>
                </tr>
                <tr>
                    <td>Infant 6-11 months old received Vitamin A</td>
                    <td>{{ $scopeVitA1M = ShineOS\Core\Reports\Entities\M1::scopeVitAFirst('M', $month, $year) }}</td>
                    <td>{{ $scopeVitA1F = ShineOS\Core\Reports\Entities\M1::scopeVitAFirst('F', $month, $year) }}</td>
                    <td>{{ $scopeVitA1M + $scopeVitA1F }}</td>
                </tr>
                <tr>
                    <td>Chidren 12-59 months old received Vitamin A</td>
                    <td>{{ $scopeVitA2M = ShineOS\Core\Reports\Entities\M1::scopeVitASecond('M', $month, $year) }}</td>
                    <td>{{ $scopeVitA2F = ShineOS\Core\Reports\Entities\M1::scopeVitASecond('F', $month, $year) }}</td>
                    <td>{{ $scopeVitA2M + $scopeVitA2F }}</td>
                </tr>
                <tr>
                    <td>Infant 6-11 months old received Iron</td>
                    <td>{{ $scopeIronAM = ShineOS\Core\Reports\Entities\M1::scopeIronA('M', $month, $year) }}</td>
                    <td>{{ $scopeIronAF = ShineOS\Core\Reports\Entities\M1::scopeIronA('F', $month, $year) }}</td>
                    <td>{{ $scopeIronAM + $scopeIronAF }}</td>
                </tr>
                <tr>
                    <td>Children 12-59 months old received Iron</td>
                    <td>{{ $scopeIronBM = ShineOS\Core\Reports\Entities\M1::scopeIronB('M', $month, $year) }}</td>
                    <td>{{ $scopeIronBF = ShineOS\Core\Reports\Entities\M1::scopeIronB('F', $month, $year) }}</td>
                    <td>{{ $scopeIronBM + $scopeIronBF }}</td>
                </tr>
                <tr>
                    <td>Infant 6-11 months received MNP</td>
                    <td>{{ $scopeMNPAM = ShineOS\Core\Reports\Entities\M1::scopeMNPA('M', $month, $year) }}</td>
                    <td>{{ $scopeMNPAF = ShineOS\Core\Reports\Entities\M1::scopeMNPA('F', $month, $year) }}</td>
                    <td>{{ $scopeMNPAM + $scopeMNPAF }}</td>
                </tr>
                <tr>
                    <td>Children 12-23 months received MNP</td>
                    <td>{{ $scopeMNPBM = ShineOS\Core\Reports\Entities\M1::scopeMNPB('M', $month, $year) }}</td>
                    <td>{{ $scopeMNPBF = ShineOS\Core\Reports\Entities\M1::scopeMNPB('F', $month, $year) }}</td>
                    <td>{{ $scopeMNPBM + $scopeMNPBF }}</td>
                </tr>
                <tr>
                    <td>Sick Children 6-11 months seen</td>
                    <td>{{ $scopeSickAM = ShineOS\Core\Reports\Entities\M1::scopeSickSeen(6,11,'M', $month, $year) }}</td>
                    <td>{{ $scopeSickAF = ShineOS\Core\Reports\Entities\M1::scopeSickSeen(6,11,'F', $month, $year) }}</td>
                    <td>{{ $scopeSickAM + $scopeSickAF }}</td>
                </tr>
                <tr>
                    <td>Sick Children 6-11 months received Vitamin A</td>
                    <td>{{ $scopeSickVitAAM = ShineOS\Core\Reports\Entities\M1::scopeSickVitA(6,11,'M', $month, $year) }}</td>
                    <td>{{ $scopeSickVitAAF = ShineOS\Core\Reports\Entities\M1::scopeSickVitA(6,11,'F', $month, $year) }}</td>
                    <td>{{ $scopeSickVitAAM + $scopeSickVitAAF }}</td>
                </tr>
                <tr>
                    <td>Sick Children 12-59 months seen</td>
                    <td>{{ $scopeSickBM = ShineOS\Core\Reports\Entities\M1::scopeSickSeen(12,59,'M', $month, $year) }}</td>
                    <td>{{ $scopeSickBF = ShineOS\Core\Reports\Entities\M1::scopeSickSeen(12,59,'F', $month, $year) }}</td>
                    <td>{{ $scopeSickBM + $scopeSickBF }}</td>
                </tr>
                <tr>
                    <td>Sick Children 12-59 months received Vitamin A</td>
                    <td>{{ $scopeSickVitABM = ShineOS\Core\Reports\Entities\M1::scopeSickVitA(12,59,'M', $month, $year) }}</td>
                    <td>{{ $scopeSickVitABF = ShineOS\Core\Reports\Entities\M1::scopeSickVitA(12,59,'F', $month, $year) }}</td>
                    <td>{{ $scopeSickVitABM + $scopeSickVitABF }}</td>
                </tr>
                <tr>
                    <td>Children 12-59 mos. old given de-worming tablet/syrup</td>
                    <td>{{ $scopeDeWormM = ShineOS\Core\Reports\Entities\M1::scopeDeWorm('M', $month, $year) }}</td>
                    <td>{{ $scopeDeWormF = ShineOS\Core\Reports\Entities\M1::scopeDeWorm('F', $month, $year) }}</td>
                    <td>{{ $scopeDeWormM + $scopeDeWormF }}</td>
                </tr>
                <tr>
                    <td>Infant 2-5 mos w/ Low Birth Weight seen</td>
                    <td>{{ $scopeLowWtM = ShineOS\Core\Reports\Entities\M1::scopeLowWt(2, 5, 'M', $month, $year) }}</td>
                    <td>{{ $scopeLowWtF = ShineOS\Core\Reports\Entities\M1::scopeLowWt(2, 5, 'F', $month, $year) }}</td>
                    <td>{{ $scopeLowWtM + $scopeLowWtF }}</td>
                </tr>
                <tr>
                    <td>Infant 2-5 mos w/ LBW received full dose iron</td>
                    <td>{{ $scopeLowWtIronM = ShineOS\Core\Reports\Entities\M1::scopeLowWtIron(2, 5, 'M', $month, $year) }}</td>
                    <td>{{ $scopeLowWtIronF = ShineOS\Core\Reports\Entities\M1::scopeLowWtIron(2, 5, 'F', $month, $year) }}</td>
                    <td>{{ $scopeLowWtIronM + $scopeLowWtIronF }}</td>
                </tr>
                <tr>
                    <td>Anemic Children 6-11 months old seen</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Anemic Children 6-11 mos received full dose iron</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Anemic Children 12-59 months old seen</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Anemic Children 12-59 mos received full dose iron</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Diarrhea cases 0-59 months old seen</td>
                    <td>{{ $scopeDiarrheaM = ShineOS\Core\Reports\Entities\M1::scopeDiarrhea(0, 59, 'M', $month, $year) }}</td>
                    <td>{{ $scopeDiarrheaF = ShineOS\Core\Reports\Entities\M1::scopeDiarrhea(0, 59, 'F', $month, $year) }}</td>
                    <td>{{ $scopeDiarrheaM + $scopeDiarrheaF }}</td>
                </tr>
                <tr>
                    <td>Diarrhea cases 0-59 mos old received ORS</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Diarrhea 0-59 mos received ORS/ORT w/ zinc</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Pneumonia cases 0-59 months old</td>
                    <td>{{ $scopePneumoniaM = ShineOS\Core\Reports\Entities\M1::scopePneumonia('M', $month, $year) }}</td>
                    <td>{{ $scopePneumoniaF = ShineOS\Core\Reports\Entities\M1::scopePneumonia('F', $month, $year) }}</td>
                    <td>{{ $scopePneumoniaM + $scopePneumoniaF }}</td>
                </tr>
                <tr>
                    <td>Pneumonia cases 0-59 mos. old completed Tx</td>
                    <td>{{ $scopePneumoniaTM = ShineOS\Core\Reports\Entities\M1::scopePneumoniaTreat('M', $month, $year) }}</td>
                    <td>{{ $scopePneumoniaTF = ShineOS\Core\Reports\Entities\M1::scopePneumoniaTreat('F', $month, $year) }}</td>
                    <td>{{ $scopePneumoniaTM + $scopePneumoniaTF }}</td>
                </tr>

                </tbody>
            </table><!-- /.table child care -->
            <table class="table table-striped table-bordered table-report">
                <thead>
                <tr>
                <th>TUBERCULOSIS</th>
                <th width="15%">Male</th>
                <th width="15%">Female</th>
                <th width="15%">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>TB symptomatics who underwent DSSM</td>
                    <td>{{ $scopeTBDSSMM = ShineOS\Core\Reports\Entities\M1::scopeTBDSSM('M', $month, $year) }}</td>
                    <td>{{ $scopeTBDSSMF = ShineOS\Core\Reports\Entities\M1::scopeTBDSSM('F', $month, $year) }}</td>
                    <td>{{ $scopeTBDSSMM + $scopeTBDSSMF }}</td>
                </tr>
                <tr>
                    <td>Smear Positive discovered and identified</td>
                    <td>{{ $scopeTBDSSMPosM = ShineOS\Core\Reports\Entities\M1::scopeTBDSSMPos('M', $month, $year) }}</td>
                    <td>{{ $scopeTBDSSMPosF = ShineOS\Core\Reports\Entities\M1::scopeTBDSSMPos('F', $month, $year) }}</td>
                    <td>{{ $scopeTBDSSMPosM + $scopeTBDSSMPosF }}</td>
                </tr>
                <tr>
                    <td>New Smear (+) cases initiated tx &amp; registered</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>

                <tr>
                    <td>New Smear (+) cases cured</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Smear (+) retreatment cases cured</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Smear (+) retreatment cases initiated tx &amp; registered (relapse, treatment failure, return after default, other type of TB)</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>No of smear (+) retreatment cured (relapse, treatment failure, return after default)</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Total No. of TB cases (all forms) initiated treatment</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>TB all forms identified</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Cases Detection Rate</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                </tbody>
            </table><!-- /table tuberculosis -->
            <table class="table table-striped table-bordered table-report">
                <thead>
                <tr>
                <th>MALARIA</th>
                <th width="15%">Male</th>
                <th width="15%">Female</th>
                <th width="15%">Total</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Population</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Population at Risk</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Annual parasite incidence</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Confirmed Malaria Cases (&lt;5yo, &gt;= 5yo, Pregnant)</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Confirmed Malaria Cases by Species (P falciparum, P vivax, P ovale, P malariae)</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>By Method (Slide, RDT)</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Malaria Deaths</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Number of LLIN given</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table><!-- /table malaria -->
            <table class="table table-striped table-bordered table-report">
                <thead>
                <tr>
                <th>SCHISTOSOMIASIS</th>
                <th width="15%">Male</th>
                <th width="15%">Female</th>
                <th width="15%">Total</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>No. of symptomatic case</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of cases examined</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of positive cases (low, medium, high intensity)</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of cases treated</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of complicated cases</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of complicated cases referred</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table><!-- /table SCHISTOSOMIASIS -->
            <table class="table table-striped table-bordered table-report">
                <thead>
                <tr>
                <th>STI SURVEILLANCE</th>
                <th width="15%">Male</th>
                <th width="15%">Female</th>
                <th width="15%">Total</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>No. of pregnant women seen</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of pregnant women tested for Syphillis</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of pregnant women positive for Syphillis</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of pregnant women given Penicillin</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table><!-- /table STI SURVEILLANCE -->
            <table class="table table-striped table-bordered table-report">
                <thead>
                <tr>
                <th>FILARIASIS</th>
                <th width="15%">Male</th>
                <th width="15%">Female</th>
                <th width="15%">Total</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>No. of cases w/Hydrocele, Lymphedema, Elephantasis and Chyluria</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of cases examined</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Clinical Rate</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of cases Examined found for MF</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Average MFD</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Eligible population given MDA (94.6% of TP)</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Total Population given MDA</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table><!-- /table FILARIASIS -->
            <table class="table table-striped table-bordered table-report">
                <thead>
                <tr>
                <th>LEPROSY</th>
                <th width="15%">Male</th>
                <th width="15%">Female</th>
                <th width="15%">Total</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Population</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Total No. of Leprosy cases (undergoing treatment)</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of Newly detected Leprosy cases (&lt;15yo, Grade 2 disability)</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>No. of Leprosy cases cured</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                </tbody>
            </table><!-- /table LEPROSY -->
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>
</div>
@stop
