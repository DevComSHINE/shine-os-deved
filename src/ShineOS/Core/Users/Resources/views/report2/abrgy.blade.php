@extends('users::layouts.master')

@section('content')
<!--NOTE:: SEPARATE PORTIONS-->
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">ABarangay</h3>
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
						{!! Form::open(array( 'url'=>'reports/abrgy', 'id'=>'reportsForm', 'name'=>'reportsForm' )) !!}
							<label class="col-sm-1 control-label">Year</label> 
							<div class="col-sm-3">
								<select name="year" class="form-control" id="year" onchange="resetAction('year',this.value)">
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
					<tr><th colspan="4">DEMOGRAPHIC</th></tr>
					</thead>

					<tbody>
					<tr><td>Population</td><td></td><td>No. of Households</td><td></td></tr>
					<tr><td>Barangay</td><td></td><td>No. of BHS</td><td></td></tr>
					</tbody>
				</table>

				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
						<th rowspan="3">ENVIRONMENTAL</th>
						<th rowspan="3" width="15%">No.</th>
						<th rowspan="3" width="15%">%</th>
					</tr>
					</thead>

					<tbody>
						<tr><td>Households with access to improved or safe water supply</td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;Level I (Point Source)</td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;Level II (Communal Faucet System or Standpost)</td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;Level III (Waterworks System)</td><td></td><td></td></tr>
						<tr><td>Households with sanitary toilet facilities</td><td></td><td></td></tr>
						<tr><td>Households with satisfactory disposal of solid waste</td><td></td><td></td></tr>
						<tr><td>Households with complete basic sanitation facilities</td><td></td><td></td></tr>
						<tr><td>Food Establishments </td><td></td><td></td></tr>
						<tr><td>Food Establishments with sanitary permit</td><td></td><td></td></tr>
						<tr><td>Food Handlers</td><td></td><td></td></tr>
						<tr><td>Food Handlers  with health certificate</td><td></td><td></td></tr>
						<tr><td>Salt Samples Tested</td><td></td><td></td></tr>
						<tr><td>Salt Samples Tested (+) for iodine</td><td></td><td></td></tr>
					</tbody>
				</table>

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
					<tr><td>BCG</td><td></td><td></td><td></td></tr>
					<tr><td>Pentahib (1,2,3)</td><td></td><td></td><td></td></tr>
					<tr><td>OPV (1,2,3)</td><td></td><td></td><td></td></tr>
					<tr><td>Rota (1,2)</td><td></td><td></td><td></td></tr>
					<tr><td>PCV (1,2,3)</td><td></td><td></td><td></td></tr>
					<tr><td>Hepa B1 (w/in 24 hrs, >24 hrs)</td><td></td><td></td><td></td></tr>
					<tr><td>MCV (AMV/MMR)</td><td></td><td></td><td></td></tr>
					<tr><td>Fully Immunized Child (0-11 mos)</td><td></td><td></td><td></td></tr>
					<tr><td>Completely Immunized Child (12-23 mos)</td><td></td><td></td><td></td></tr>
					<tr><td>Total Live births</td><td></td><td></td><td></td></tr>
					<tr><td>Child Protected at Birth</td><td></td><td></td><td></td></tr>
					<tr><td>Infant Age 6 months seen</td><td></td><td></td><td></td></tr>
					<tr><td>Infant exclusively breastfed until 6 months</td><td></td><td></td><td></td></tr>
					</tbody>
				</table>

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
						<tr><td>Infant given complimentary food from 6-8 months</td><td></td><td></td><td></td></tr>
						<tr><td>Infant referred for newborn screening</td><td></td><td></td><td></td></tr>
						<tr><td>Infant newborn screening done at RHU</td><td></td><td></td><td></td></tr>
						<tr><td>Infant 6-11 months old received Vit. A</td><td></td><td></td><td></td></tr>
						<tr><td>Children 12-59 months old received Vit. A</td><td></td><td></td><td></td></tr>
						<tr><td>Infant 6-11 months old received MNP</td><td></td><td></td><td></td></tr>
						<tr><td>Children 12-59 months old received MNP</td><td></td><td></td><td></td></tr>
						<tr><td>Sick Children 6-11 months seen</td><td></td><td></td><td></td></tr>
						<tr><td>Sick Children 12-59 months seen</td><td></td><td></td><td></td></tr>
						<tr><td>Sick Children 12-59 months received Vit. A</td><td></td><td></td><td></td></tr>
						<tr><td>Children 12-59 months old given de-worming tablet/syrup</td><td></td><td></td><td></td></tr>
						<tr><td>Infant 2-6 months w/low birth weight seen</td><td></td><td></td><td></td></tr>
						<tr><td>Infant 2-6 months w/low birth weight received full dose iron</td><td></td><td></td><td></td></tr>
						<tr><td>Anemic children 6-11 months old seen</td><td></td><td></td><td></td></tr>
						<tr><td>Anemic children 6-11 months received full dose iron</td><td></td><td></td><td></td></tr>
						<tr><td>Anemic children 12-59 months old seen</td><td></td><td></td><td></td></tr>
						<tr><td>Anemic children 12-59 months received full dose iron</td><td></td><td></td><td></td></tr>
						<tr><td>Diarrhea cases 0-59 months old seen</td><td></td><td></td><td></td></tr>
						<tr><td>Diarrhea cases 0-59 months old received ORS</td><td></td><td></td><td></td></tr>
						<tr><td>Diarrhea cases 0-59 months old received ORS/ORT with zinc</td><td></td><td></td><td></td></tr>
						<tr><td>Pneumonia cases 0-59 months old</td><td></td><td></td><td></td></tr>
						<tr><td>Pneumonia cases 0-59 months old completed Tx</td><td></td><td></td><td></td></tr>
					</tbody>
				</table>

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
					<tr><td>TB symptomatics who underwent DSSM</td><td></td><td></td><td></td></tr>
					<tr><td>Smear Positive discovered and identified</td><td></td><td></td><td></td></tr>
					<tr><td>New Smear (+) cases initiated tx & registered</td><td></td><td></td><td></td></tr>
					<tr><td>New Smear (+) cases cured</td><td></td><td></td><td></td></tr>
					<tr><td>Smear (+) retreatment cases cured</td><td></td><td></td><td></td></tr>
					<tr><td>Smear (+) retreatment cases initiated tx & registered (relapse, treatment failure, return after default, other type of TB)</td><td></td><td></td><td></td></tr>
					<tr><td>No of smear (+) retreatment cured (relapse, treatment failure, return after default)</td><td></td><td></td><td></td></tr>
					<tr><td>Total No. of TB cases (all forms) initiated treatment</td><td></td><td></td><td></td></tr>
					<tr><td>TB all forms identified</td><td></td><td></td><td></td></tr>
					<tr><td>Cases Detection Rate</td><td></td><td></td><td></td></tr>
					</tbody>
				</table>

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
						<tr><td>Total Population</td><td></td><td></td><td></td></tr>
						<tr><td>Population at Risk</td><td></td><td></td><td></td></tr>
						<tr><td>Annual parasite incidence</td><td></td><td></td><td></td></tr>
						<tr><td>Confirmed Malaria Cases (&lt;5yo, &gt;= 5yo, Pregnant)</td><td></td><td></td><td></td></tr>
						<tr><td>Confirmed Malaria Cases by Species (P falciparum, P vivax, P ovale, P malariae)</td><td></td><td></td><td></td></tr>
						<tr><td>By Method (Slide, RDT)</td><td></td><td></td><td></td></tr>
						<tr><td>Malaria Deaths</td><td></td><td></td><td></td></tr>
						<tr><td>Number of LLIN given</td><td></td><td></td><td></td></tr>
					</tbody>
				</table>

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
						<tr><td>No. of symptomatic case</td><td></td><td></td><td></td></tr>
						<tr><td>No. of cases examined</td><td></td><td></td><td></td></tr>
						<tr><td>No. of positive cases (low, medium, high intensity)</td><td></td><td></td><td></td></tr>
						<tr><td>No. of cases treated</td><td></td><td></td><td></td></tr>
						<tr><td>No. of complicated cases</td><td></td><td></td><td></td></tr>
						<tr><td>No. of complicated cases referred</td><td></td><td></td><td></td></tr>
					</tbody>
				</table>

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
						<tr><td>No. of pregnant women seen</td><td></td><td></td><td></td></tr>
						<tr><td>No. of pregnant women tested for Syphillis</td><td></td><td></td><td></td></tr>
						<tr><td>No. of pregnant women positive for Syphillis</td><td></td><td></td><td></td></tr>
						<tr><td>No. of pregnant women given Penicillin</td><td></td><td></td><td></td></tr>
					</tbody>
				</table>

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
						<tr><td>No. of cases w/Hydrocele, Lymphedema, Elephantasis and Chyluria</td><td></td><td></td><td></td></tr>
						<tr><td>No. of cases examined</td><td></td><td></td><td></td></tr>
						<tr><td>Clinical Rate</td><td></td><td></td><td></td></tr>
						<tr><td>No. of cases Examined found for MF</td><td></td><td></td><td></td></tr>
						<tr><td>Average MFD</td><td></td><td></td><td></td></tr>
						<tr><td>Eligible population given MDA (94.6% of TP)</td><td></td><td></td><td></td></tr>
						<tr><td>Total Population given MDA</td><td></td><td></td><td></td></tr>
					</tbody>
				</table>

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
						<tr><td>Total Population</td><td></td><td></td><td></td></tr>
						<tr><td>Total No. of Leprosy cases (undergoing treatment)</td><td></td><td></td><td></td></tr>
						<tr><td>No. of Newly detected Leprosy cases (&lt;15yo, Grade 2 disability)</td><td></td><td></td><td></td></tr>
						<tr><td>No. of Leprosy cases cured</td><td></td><td></td><td></td></tr>
					</tbody>
				</table>
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