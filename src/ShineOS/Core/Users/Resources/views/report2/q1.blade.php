@extends('users::layouts.master')

@section('content')
<!--NOTE:: SEPARATE PORTIONS-->
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">Program Report Q1</h3>
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
						{!! Form::open(array( 'url'=>'reports/q1', 'id'=>'reportsForm', 'name'=>'reportsForm' )) !!}
							<label class="col-sm-1 control-label">Quarter</label>
							<div class="col-sm-3">
								<input type="hidden" value="m" name="range">
								<select name="month" class="form-control" id="month" onchange="resetAction('month',this.value)">
									<option value="" selected="selected"></option>
									<option value="01">January</option>
									<option value="02">February</option>
									<option value="03">March</option>
									<option value="04">April</option>
									<option value="05">May</option>
									<option value="06">June</option>
									<option value="07" selected="">July</option>
									<option value="08">August</option>
									<option value="09">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
							</div>
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
				<h3>Maternal Care</h3>
				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
						<th width="45%">Indicators</th>
						<th width="5%">Elig. Pop.</th>
						<th width="5%">NO.</th>
						<th width="5%">%</th>
						<th width="20%">Interpretation</th>
						<th width="20%">Recommendations/ Actions Taken</th>
					</tr>
					</thead>

					<tbody>
					<tr><td>Pregnant women with 4 or more Prenatal visits ♣</td>
						<td><?php //echo $this->consultation->count_by('medical_category','PRE_NATAL', $month, $year); ?></td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Pregnant women given 2 doses of Tetanus Toxoid ♣</td>
						<td><?php //echo $this->order->count_by('order_type','Prenatal Care', $month, $year); ?></td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Pregnant women given TT2 plus ♣</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Preg. women given complete iron w/ folic acid supplementation ♣</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Postpartum women with at least 2 postpartum visits ♣</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Postpartum women given complete iron supplementation ♣</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Postpartum women given Vitamin A supplementation ♣</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>PP women initiated breastfeeding w/in 1 hr. after delivery ♣</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Women 10-49 years old given Iron supplementation ♥</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr>
					<th colspan="3">STI SURVEILLANCE</th>
					<th>No.</th>
					<th></th>
					<th></th>
					</tr>
					
					<tr><td colspan="3">No. of pregnant women seen</td><td></td><td></td><td></td></tr>
					<tr><td colspan="3">No. of pregnant women tested for Syphillis</td><td></td><td></td><td></td></tr>
					<tr><td colspan="3">No. of pregnant women positive for Syphillis</td><td></td><td></td><td></td></tr>
					<tr><td colspan="3">No. of pregnant women given Penicillin</td><td></td><td></td><td></td></tr>
					<tr><td colspan="6"><em class="small">Eligible Population:   ♣ TP x 2.7%  ♥ TP x 24.6%</em></td></tr>
					</tbody>
				</table>

				<h3>FAMILY PLANNING</h3>
				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
					<th rowspan="3" width="22%">Indicators</th>
					<th rowspan="3" width="8%">Current User (Beginning Month)</th>
					<th colspan="2" width="8%">Acceptors</th>
					<th rowspan="3" width="8%">Dropout (Present Month)</th>
					<th rowspan="3" width="8%">Current User (End of Month)</th>
					<th rowspan="3" width="8%">New Acceptors of the present Month</th>
					<th rowspan="3" width="8%">CPR = (Col. 5/TP x 12.325%)</th>
					<th rowspan="3" width="15%">Interpretations</th>
					<th rowspan="3" width="15%">Recommendations/ Actions Taken</th>
					</tr>
					<tr><th width="5%">New Acceptors</th><th width="5%">Other Acceptors</th></tr>
					<tr><th>Previous Quarter</th><th>Present Quarter</th></tr>
					</thead>

					<tbody>
					<tr><td>a. Female Sterilization/BTL</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>b. Male Sterilization/Vasectomy</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>c. Pills</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>d. IUD (Intrauterine Device)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>e. Injectables (DMPA/CIC)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>f. NFP-CM (Cervical Mucus)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>g. NFP-BBT (Basal Body Temperature)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>h. NFP-STM (Symptothermal Method)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>i. NFP-SDM (Standard Days Method)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>j. NFP-LAM (Lactational Amenorrhea Method)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>k. Condom</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>l. Implant</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>TOTAL</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					</tbody>
				</table>

				<h3>CHILD CARE</h3>
				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
					<th colspan="2" rowspan="2" width="35%">Indicators</th>
					<th rowspan="2" width="7%">Elig. Pop.</th>
					<th colspan="3" width="21%">Number</th>
					<th rowspan="2" width="7%">%</th>
					<th rowspan="2" width="15%">Interpretations</th>
					<th rowspan="2" width="15%">Recommendations/ Actions Taken</th>
					</tr>
					<tr>
					<th width="7%">Male</th>
					<th width="7%">Female</th>
					<th width="7%">Total</th>
					</tr>
					</thead>
					<tbody>
					<tr><td colspan="2">BCG ☻</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td rowspan="3">Pentahib ☻</td><td width="5%">1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td rowspan="3">OPV ☻</td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td rowspan="2">Rota ☻</td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td rowspan="3">PCV ☻</td><td>1</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>2</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>3</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td rowspan="2">Hepa B1 ☻</td><td>w/in 24 hrs</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>>24 hrs</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td rowspan="2">MCV ☻</td><td>(AMV)</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>MMR</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">Fully Immunized Child (0-11 mos) ☻</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">Completely Immunized Child (12-23 mos) ☻</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">Total Live births</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">Child Protected at Birth (CPAB) ♣</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">Infant Age 6 months seen</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">Infant exclusively breastfed until 6 months ☻</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

					<tr><td colspan="2">Infant given complimentary food from 6-8 months ♣</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">Infant referred for newborn screening</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">- referred</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="2">- done</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="9"><em class="small">Eligible Population:  ☻ TP x 2.7%                ♣ Total Livebirths</em></td></tr>       
					</tbody>
				</table>

				<h3>CHILD CARE</h3>
				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
					<th rowspan="2" width="35%">Indicators</th>
					<th rowspan="2" width="7%">Elig. Pop.</th>
					<th colspan="3" width="21%">Number</th>
					<th rowspan="2" width="7%">%</th>
					<th rowspan="2" width="15%">Interpretations</th>
					<th rowspan="2" width="15%">Recommendations/ Actions Taken</th>
					</tr>
					<tr>
					<th width="7%">Male</th>
					<th width="7%">Female</th>
					<th width="7%">Total</th>
					</tr>
					</thead>
					<tbody>
						<tr><td>Infant 6-11 months old received Vit. A ☼</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Children 12-59 months old received Vit. A ♠</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Infant 6-11 months old received iron</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Children 12-23 months old received iron</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Infant 6-11 months old received MNP ☼</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Children 12-23 months old received MNP ©</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Sick Children 6-11 months seen</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Sick Children 6-11 received Vit. A ♣</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Sick Children 12-59 months seen</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Sick Children 12-59 months received Vit. A ♣♣</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Children 12-59 months old given de-worming tablet</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Infant 2-5 months w/low birth weight seen</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Infant 2-5 months w/low birth weight received full dose iron ♥</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Anemic children 6-11 months old seen</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Anemic children 6-11 months received iron ●</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Anemic children 12-59 months old seen</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Anemic children 12-59 months received iron ▲</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Diarrhea cases 0-59 months old seen</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Diarrhea cases 0-59 months old received ORS ☻</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Diarrhea cases 0-59 months old received ORS/ORT with zinc ☻</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Pneumonia cases 0-59 months old</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Pneumonia cases 0-59 months old completed Tx ♦</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td colspan="8"><em class="small">Eligible Pop:   ☼TP x 1.35%    ♠TP x 10.8%    ♣Sick Child 6-11 mos. seen     ♣♣Sick Child 12-59 mos. seen  ● Anemic Children 6-11 mos. seen ♥Infant 2-5 mos.w/LBW seen   ▲ Anemic Child 12-59 mos. old seen   ☻No.Diarrhea cases 0-59 mos old seen</em></td></tr>
					</tbody>
				</table>

				<h3>DENTAL CARE</h3>
				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
					<th rowspan="2" width="35%">Indicators</th>
					<th rowspan="2" width="7%">Elig. Pop.</th>
					<th colspan="3" width="21%">Number</th>
					<th rowspan="2" width="7%">%</th>
					<th rowspan="2" width="15%">Interpretations</th>
					<th rowspan="2" width="15%">Recommendations/ Actions Taken</th>
					</tr>
					<tr>
					<th width="7%">Male</th>
					<th width="7%">Female</th>
					<th width="7%">Total</th>
					</tr>
					</thead>

					<tbody>
					<tr><td>Orally Fit Children 12-71 months old ♠</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Children 12-71 months old provided with BOHC ♠</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Adolescent & Youth(10-24 years) given BOHC ☻</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Pregnant women provided with BOHC ♥</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td>Older Person 60 yrs old & above provided with BOHC ♣</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
						<td>0</td>
					</tr>
					<tr><td colspan="8"><em class="small">Eligible Population:  ♠TP x 13.5%    ☻TP x 30%     ♥TP x 2.7%      ♣TP x 6.9%</em></td></tr>
					</tbody>
				</table>

				<h3>DISEASE CONTROL</h3>
				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
					<th rowspan="2" width="42%">TUBERCULOSIS</th>
					<th colspan="3" width="21%">Number</th>
					<th rowspan="2" width="15%" colspan="2">Interpretations</th>
					<th rowspan="2" width="15%">Recommendations/ Actions Taken</th>
					</tr>
					<tr>
					<th width="7%">Male</th>
					<th width="7%">Female</th>
					<th width="7%">Total</th>
					</tr>
					</thead>
					<tbody>
					<tr><td>TB symptomatics who underwent DSSM</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>Smear Positive discovered and identified</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>New Smear (+) cases initiated tx & registered</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>New Smear (+) cases cured</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>Smear (+) retreatment cases cured</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>Smear (+) retreatment cases initiated tx & registered (relapse, treatment failure, return after default, other type of TB)</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>No of smear (+) retreatment cured (relapse, treatment failure, return after default)</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>Total No. of TB cases (all forms) initiated treatment</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>TB all forms identified</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>
					<tr><td>Cases Detection Rate ♦</td><td></td><td></td><td></td><td colspan="2"></td><td></td></tr>

					<tr>
					<th rowspan="2" width="42%">LEPROSY</th>
					<th colspan="3" width="21%">Number</th>
					<th rowspan="2" width="7%">Rate</th>
					<th rowspan="2" width="15%">Interpretations</th>
					<th rowspan="2" width="15%">Recommendations/ Actions Taken</th>
					</tr>
					<tr>
					<th width="7%">Male</th>
					<th width="7%">Female</th>
					<th width="7%">Total</th>
					</tr>
					<tr><td>1. Total Population</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>2. Total No. of Leprosy cases (undergoing Treatment)</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>3. No. of Newly detected 
					    Leprosy cases</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>       ► &lt; 15 yo</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>       ►  Grade 2 disability</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td>4. No of Leprosy Cases cured</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					<tr><td colspan="7"><em class="small">Denominator ♦ TP x 0.00275 (estimated TB All Forms)</em></td></tr>
					</tbody>
				</table>

				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
					<th rowspan="2" width="35%">MALARIA</th>
					<th colspan="3" width="21%">Number</th>
					<th rowspan="2" width="7%">Rate</th>
					<th rowspan="2" width="15%">Interpretations</th>
					<th rowspan="2" width="15%">Recommendations/ Actions Taken</th>
					</tr>
					<tr>
					<th width="7%">Male</th>
					<th width="7%">Female</th>
					<th width="7%">Total</th>
					</tr>
					</thead>
					<tbody>
						<tr><td>Total Population</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Population at Risk</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Annual parasite incidence</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Confirmed Malaria Cases</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&lt;5yo ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&gt;= 5yo ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>By Pregnancy</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&bull; Pregnant ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>By Species</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&bull; P.falciparum ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&bull; P.vivax ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&bull; P.ovale ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;&bull; P.malariae ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>By Method</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;Slide ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;RDT ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Total no. of LLIN given ♦</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Total no. of Malaria Deaths</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td colspan="7"><em class="small">Denominator: ♣ Morbidity Rate=No. of confirmed Mal. Cases/TP x 100,000 ☻Total Confirmed Malaria Case ♦ Population at risk ♪ Mortality rate=TP<br>Case Fatality Ratio=Total Malaria Cases<br>Annual Parasite Incidence = Tot. confirmed Mal.Cases/Pop. At risk x 1,000<br>Case Fatality Ratio =  No. of Malaria Deaths/ Total Malaria confirmed cases<br>Mortality Rate = Total no. of Mal. Deaths/Total Pop. x 100,000</em></td></tr>
					</tbody>
				</table>

				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr>
					<th rowspan="2" width="35%">SCHISTOSOMIASIS</th>
					<th colspan="3" width="21%">Number</th>
					<th rowspan="2" width="7%">Rate</th>
					<th rowspan="2" width="15%">Interpretations</th>
					<th rowspan="2" width="15%">Recommendations/ Actions Taken</th>
					</tr>
					<tr>
					<th width="7%">Male</th>
					<th width="7%">Female</th>
					<th width="7%">Total</th>
					</tr>
					</thead>
					<tbody>
						<tr><td>Symptomatic case</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Cases examined ♥</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Positive cases ●</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;● Low intensity ♣</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;● Medium intensity ♣</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;● High intensity ♣</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Cases treated ♣</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Complicated cases ♣</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Complicated cases referred ♣</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
					
						<tr>
						<th rowspan="2" width="35%">FILARIASIS</th>
						<th colspan="3" width="21%">Number</th>
						<th rowspan="2" width="7%">Rate</th>
						<th rowspan="2" width="15%">Interpretations</th>
						<th rowspan="2" width="15%">Recommendations/ Actions Taken</th>
						</tr>
						<tr>
						<th width="7%">Male</th>
						<th width="7%">Female</th>
						<th width="7%">Total</th>
						</tr>
						<tr><td>No. of cases w/Hydrocele, Lymphedema, Elephantasis and Chyluria</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>No. of cases examined</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>No. of cases Examined found for MF ☻</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Average MFD ♣</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Eligible population given MDA (94.6% of TP)</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
						<tr><td>Total Population given MDA ☺</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

						<tr><td colspan="7"><em class="small">Denominator for Schistosomiasis:       ☻Case examined       ♣ Positive Schistosomiasis cases  ♥ Symptomatic cases   ♠Total Pop. Given MDA<br> Filariasis : Clinical Rate = No. Cases with hydrocele,lymphedema,Elephantiasis, chyluria/ No. of Cases examined<br>☻ No. of Cases examined  ♣ Total Count of microfilaria in slides found positive / No. of slides found positive  ☺ Total Population</em></td></tr>
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