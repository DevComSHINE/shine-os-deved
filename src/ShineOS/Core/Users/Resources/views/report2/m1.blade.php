@extends('users::layouts.master')

@section('content')
<!--NOTE:: SEPARATE PORTIONS-->
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Program Report M1</h3>
			  <div class="box-tools pull-right">
			    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-print"></i></button>
			    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-external-link"></i></button>
			  </div><!-- /.box-tool -->
			</div><!-- /.box-header -->
			<div class="box-body text-center">
			
			@if (Session::has('message'))
				<div class="alert alert-dismissible alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<p>{{ Session::get('message') }}</p>
				</div>
			@endif
			@if (Session::has('warning'))
				<div class="alert alert-dismissible alert-warning">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<p>{{ Session::get('warning') }}</p>
				</div>
			@endif
			
				<table class="table table-striped table-bordered table-report">
					<tbody><tr><th class="thleft">FHSIS Report Month/Year</th><td>
						{!! Form::open(array( 'url'=>'reports/m1', 'id'=>'reportsForm', 'name'=>'reportsForm' )) !!}
							<label class="col-sm-1 control-label">Month</label>
							<div class="col-sm-3">
								<input type="hidden" value="m" name="range">
								<select name="month" class="form-control" id="month" onchange="resetAction('month',this.value)" required>
									<option value="" selected="selected"></option>
									<option value="01">January</option>
									<option value="02">February</option>
									<option value="03">March</option>
									<option value="04">April</option>
									<option value="05">May</option>
									<option value="06">June</option>
									<option value="07">July</option>
									<option value="08">August</option>
									<option value="09" selected="september">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
							</div>
							<label class="col-sm-1 control-label">Year</label> 
							<div class="col-sm-3">
								<select name="year" class="form-control" id="year" onchange="resetAction('year',this.value)" required>
									<option>2010</option>
									<option>2011</option>
									<option>2012</option>
									<option>2013</option>
									<option>2014</option>
									<option selected="">2015</option>
									<option>2016</option>
									<option>2017</option>
									<option>2018</option>
									<option>2019</option>
									<option>2020</option>
								</select>
							</div>
							<input type="submit" class="btn btn-primary" value="GO">
						{!! Form::close() !!}<!-- /form -->
					</td></tr>
					<tr><th class="thleft">Name of BHS</th><td>ShineOS Test Facility</td></tr>
					<tr><th class="thleft">Barangay</th><td>LOYOLA HEIGHTS</td></tr>
					<tr><th class="thleft">City/Municipality of</th><td>QUEZON CITY</td></tr>
					<tr><th class="thleft">Province of</th><td>NCR, SECOND DISTRICT (Not a Province)</td></tr>
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
						<td></td>
					</tr>
					<tr>
						<td>Pregnant women given 2 doses of Tetanus Toxoid</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Pregnant women given TT2 plus</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Preg. women given complete iron w/ folic acid supplementation</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Postpartum women with at least 2 postpartum visits</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Postpartum women given complete iron supplementation</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Postpartum women given Vitamin A supplementation</td>
						<td>0</td>
					</tr>
					<tr>
						<td>PP women initiated breastfeeding w/in 1 hr. after delivery</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Women 10-49 years old given Iron supplementation</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Deliveries</td>
						<td>0</td>
					</tr>
					</tbody>
				</table><!-- /table Maternal -->
				<table class="table table-striped table-bordered table-report table-responsive">
					<thead>
					<tr>
					<th rowspan="3">FAMILY PLANNING METHOD</th>
					<th rowspan="3" width="10%">Current User (Beginning Month)</th>
					<th colspan="2">Acceptors</th>
					<th rowspan="3" width="10%">Dropout (Present Month)</th>
					<th rowspan="3" width="10%">Current User (End of Month)</th>
					<th rowspan="3" width="10%">New Acceptors of the present Month</th>
					</tr>
					<tr><th width="10%">New Acceptors</th><th width="10%">Other Acceptors</th></tr>
					<tr><th>Previous Month</th><th>Present Month</th></tr>
					</thead>

					<tbody>
					<tr>
						<td>a. Female Sterilization/BTL</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>b. Male Sterilization/Vasectomy</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>c. Pills</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>d. IUD (Intrauterine Device)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>e. Injectables (DMPA/CIC)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>f. NFP-CM (Cervical Mucus)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>g. NFP-BBT (Basal Body Temperature)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>h. NFP-STM (Symptothermal Method)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>i. NFP-SDM (Standard Days Method)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>j. NFP-LAM (Lactational Amenorrhea Method)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>k. Condom</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>l. Implant</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>TOTAL</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					</tbody>
				</table><!-- /table family planning -->
				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
					<th>CHILD CARE</th>
					<th width="15%">Male</th>
					<th width="15%">Female</th>
					<th width="15%">Total</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>BCG</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Pentahib (1,2,3)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>OPV (1,2,3)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Rota (1,2)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>PCV (1,2,3)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Hepa B1 (w/in 24 hrs, &gt;24 hrs)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>MCV (AMV/MMR)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Fully Immunized Child (0-11 mos)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Completely Immunized Child (12-23 mos)</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Total Live births</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Child Protected at Birth</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Infant Age 6 months seen</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Infant exclusively breastfed until 6 months</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
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
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
						<td>Smear Positive discovered and identified</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
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
						<tr><td>Total Population</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Population at Risk</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Annual parasite incidence</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Confirmed Malaria Cases (&lt;5yo, &gt;= 5yo, Pregnant)</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Confirmed Malaria Cases by Species (P falciparum, P vivax, P ovale, P malariae)</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>By Method (Slide, RDT)</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Malaria Deaths</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Number of LLIN given</td><td>0</td><td>0</td><td>0</td></tr>
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
						<tr><td>No. of symptomatic case</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of cases examined</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of positive cases (low, medium, high intensity)</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of cases treated</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of complicated cases</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of complicated cases referred</td><td>0</td><td>0</td><td>0</td></tr>
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
						<tr><td>No. of pregnant women seen</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of pregnant women tested for Syphillis</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of pregnant women positive for Syphillis</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of pregnant women given Penicillin</td><td>0</td><td>0</td><td>0</td></tr>
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
						<tr><td>No. of cases w/Hydrocele, Lymphedema, Elephantasis and Chyluria</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of cases examined</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Clinical Rate</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of cases Examined found for MF</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Average MFD</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Eligible population given MDA (94.6% of TP)</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Total Population given MDA</td><td>0</td><td>0</td><td>0</td></tr>
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
						<tr><td>Total Population</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>Total No. of Leprosy cases (undergoing treatment)</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of Newly detected Leprosy cases (&lt;15yo, Grade 2 disability)</td><td>0</td><td>0</td><td>0</td></tr>
						<tr><td>No. of Leprosy cases cured</td><td>0</td><td>0</td><td>0</td></tr>
					</tbody>
				</table><!-- /table LEPROSY -->
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
@stop

@section('footer')
	<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
	<script>
		$('#reportsForm').validate();
	</script>
@stop