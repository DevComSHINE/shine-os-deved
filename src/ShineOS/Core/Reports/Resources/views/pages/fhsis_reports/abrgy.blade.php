<?php
	$year = date('Y');

	$facility_workers = 0;
	$doctors_male = 0;
	$doctors_female = 0;
	$dentists_male = 0;
	$dentists_female = 0;
	$nurses_male = 0;
	$nurses_female = 0;
	$midwives_male = 0;
	$midwives_female = 0;
	$medical_technologists_male = 0;
	$medical_technologists_female = 0;
	$sanitary_engineers_male = 0;
	$sanitary_engineers_female = 0;
	$sanitary_inspectors_male = 0;
	$sanitary_inspectors_female = 0;
	$nutritionists_male = 0;
	$nutritionists_female = 0;
	$active_barangay_health_workers_male = 0;
	$active_barangay_health_workers_female = 0;

	if(isset($facilityInfo->facilityWorkforce->workforce))
	{
		$facility_workers =  json_decode($facilityInfo->facilityWorkforce->workforce);
		$doctors_male = $facility_workers->doctors_male;
		$doctors_female = $facility_workers->doctors_female;
		$dentists_male = $facility_workers->dentists_male;
		$dentists_female = $facility_workers->dentists_female;
		$nurses_male = $facility_workers->nurses_male;
		$nurses_female = $facility_workers->nurses_female;
		$midwives_male = $facility_workers->midwives_male;
		$midwives_female = $facility_workers->midwives_female;
		$medical_technologists_male = $facility_workers->medical_technologists_male;
		$medical_technologists_female = $facility_workers->medical_technologists_female;
		$sanitary_engineers_male = $facility_workers->sanitary_engineers_male;
		$sanitary_engineers_female = $facility_workers->sanitary_engineers_female;
		$sanitary_inspectors_male = $facility_workers->sanitary_inspectors_male;
		$sanitary_inspectors_female = $facility_workers->sanitary_engineers_female;
		$nutritionists_male = $facility_workers->nutritionists_male;
		$nutritionists_female = $facility_workers->nutritionists_female;
		$active_barangay_health_workers_male = $facility_workers->active_barangay_health_workers_male;
		$active_barangay_health_workers_female = $facility_workers->active_barangay_health_workers_male;
	}

	$population = 0;
	$barangay = 0;
	$households = 0;
	$health_centers = 0;
	$bhs = 0;
	$households = 0;
	$households_water_1 = 0;
	$households_water_2 = 0;
	$households_water_3 = 0;
	$households_toilet = 0;
	$households_solid_waste = 0;
	$households_sanitary = 0;
	$food_establishments = 0;
	$food_establishments_permit = 0;
	$food_handlers = 0;
	$food_handlers_permit = 0;
	$salt_samples = 0;
	$salt_samples_iodine = 0;

	if(isset($geodata))
	{
		$population = $geodata->population;
		$barangay = $geodata->barangay;
		$households = $geodata->households;
		$health_centers = $geodata->health_centers;
		$bhs = $geodata->bhs;
		$households_water_1 = $geodata->households_water_1;
		$households_water_2 = $geodata->households_water_2;
		$households_water_3 = $geodata->households_water_3;
		$households_toilet = $geodata->households_toilet;
		$households_solid_waste = $geodata->households_solid_waste;
		$households_sanitary = $geodata->households_sanitary;
		$food_establishments = $geodata->food_establishments;
		$food_establishments_permit = $geodata->food_establishments_permit;
		$food_handlers = $geodata->food_handlers;
		$food_handlers_permit = $geodata->food_handlers_permit;
		$salt_samples = $geodata->salt_samples;
		$salt_samples_iodine = $geodata->salt_samples_iodine;		
	}

?>
@extends('reports::layouts.fhsis_master')

@section('reportGroup')FHSIS @stop
@section('reportTitle')A1-ABrgy @stop
@section('content')
<!--NOTE:: SEPARATE PORTIONS-->
	<div class="box box-primary">
		<div class="box-header with-border">
		  <h3 class="box-title">A1 - Barangay</h3>
		  <div class="box-tools pull-right">
		    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-print"></i></button>
		    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-external-link"></i></button>
		  </div><!-- /.box-tool -->
		</div><!-- /.box-header -->

		<div class="box-body">

			<table class="table table-striped table-bordered table-report">
				<tbody>
				<tr>
					<th class="thleft">
						FHSIS Report Month/Year
					</th>
					<td>
						{!! Form::open(array('url' => 'reports/fhsis/abrgy', 'method' => 'GET', 'id' => 'generate', 'class' => 'form-horizontal')) !!}
							<label class="col-sm-1 control-label">Year</label> 
							<div class="col-sm-3">
								{!! Form::selectRange("year", 2010, $year, $year, array("class" => "form-control", "id" => "year")) !!}
							</div>
							<input type="submit" class="btn btn-primary" value="GO">
						{!! Form::close() !!}
					</td>
				</tr>
				<tr><th class="thleft">Name of BHS</th><td>{{ $facilityInfo->facility_name }}</td></tr>
				<tr><th class="thleft">Barangay</th><td>{{ getBrgyName($facilityInfo->facilityContact->barangay) }}</td></tr>
				<tr><th class="thleft">City/Municipality of</th><td>{{ getCityName($facilityInfo->facilityContact->city) }}</td></tr>
				<tr><th class="thleft">Province of</th><td>{{ getProvinceName($facilityInfo->facilityContact->province) }}</td></tr>
				<tr><th class="thleft">Projected Population of the Year</th><td>{{ $population }}</td></tr>
				</tbody>
			</table><!-- /table details -->

			<br>
			<table class="table table-striped table-bordered table-report">
				<thead>
					<tr><th colspan="5">DEMOGRAPHIC PROFILE</th></tr>
					<tr><th>Indicators</th><th colspan="3">Number</th><th>Ratio to Population</th></tr>
					<tr><th></th><th>Male</th><th>Female</th><th>Total</th><th></th></tr>
				</thead>

				<tbody>
					<tr><td>Barangay</td><td colspan="2" bgcolor="#A9A9A9"></td><td>{{ $barangay }}</td><td>1 : {{ getPercentage($population,$barangay,1,0) }}</td></tr>
					<tr><td>No. of BHS</td><td colspan="2" bgcolor="#A9A9A9"></td><td>{{ $bhs }}</td><td>1 : {{ getPercentage($population,$bhs,1,0) }}</td></tr>
					<tr><td>No. of Health Centers </td><td colspan="2" bgcolor="#A9A9A9"></td><td>{{ $health_centers }}</td><td>1 : {{ getPercentage($population,$health_centers,1,0) }}</td></tr>
					<tr><td>No. of Households</td><td colspan="2" bgcolor="#A9A9A9"></td><td>{{ $households }}</td><td>1 : {{ getPercentage($population,$households,1,0) }}</td></tr>
					<tr><td>Physicians/Doctors</td><td>{{ $doctors_male }}</td><td>{{ $doctors_female }}</td><td>{{ $doctors_male + $doctors_female }}</td><td>1 : {{ getPercentage($population, ($doctors_male + $doctors_female),1,0) }}</td></tr>
					<tr><td>Dentist</td><td>{{ $dentists_male }}</td><td>{{ $dentists_female }}</td><td>{{ $dentists_male + $dentists_female }}</td><td>1 : {{ getPercentage($population, ($dentists_male + $dentists_female),1,0) }}</td></tr>
					<tr><td>Nurses</td><td>{{ $nurses_male }}</td><td>{{ $nurses_female }}</td><td>{{ $nurses_male +  $nurses_female }}</td><td>1 : {{ getPercentage($population,($nurses_male +  $nurses_female),1,0) }}</td></tr>
					<tr><td>Midwives</td><td>{{ $midwives_male }}</td><td>{{ $midwives_female }}</td><td>{{ $midwives_male +  $midwives_female }}</td><td>1 : {{ getPercentage($population,($midwives_male +  $midwives_female),1,0) }}</td></tr>
					<tr><td>Medical Technologists</td><td>{{ $medical_technologists_male }}</td><td>{{ $medical_technologists_female }}</td><td>{{ $medical_technologists_male +  $medical_technologists_female }}</td><td>1 : {{ getPercentage($population,($medical_technologists_male +  $medical_technologists_female),1,0) }}</td></tr>
					<tr><td>Sanitary Engineers</td><td>{{ $sanitary_engineers_male }}</td><td>{{ $sanitary_engineers_female }}</td><td>{{ $sanitary_engineers_male + $sanitary_engineers_female }}</td><td>1 : {{ getPercentage($population,($sanitary_engineers_male + $sanitary_engineers_female),1,0) }}</td></tr>
					<tr><td>Sanitary Inspectors</td><td>{{ $sanitary_inspectors_male }}</td><td>{{ $sanitary_inspectors_female }}</td><td>{{ $sanitary_inspectors_male + $sanitary_inspectors_female }}</td><td>1 : {{ getPercentage($population,($sanitary_inspectors_male + $sanitary_inspectors_female),1,0) }}</td></tr>
					<tr><td>Nutriotionist</td><td>{{ $nutritionists_male }}</td><td>{{ $nutritionists_female }}</td><td>{{ $nutritionists_male + $nutritionists_female }}</td><td>1 : {{ getPercentage($population,($nutritionists_male + $nutritionists_female),1,0) }}</td></tr>
					<tr><td>Active Barangay Health Workers</td><td>{{ $active_barangay_health_workers_male }}</td><td>{{ $active_barangay_health_workers_female }}</td><td>{{ $active_barangay_health_workers_male + $active_barangay_health_workers_female }}</td><td>1 : {{ getPercentage($population,($active_barangay_health_workers_male + $active_barangay_health_workers_female),1,0) }}</td></tr>
				</tbody>
			</table>

			<br>
			<table class="table table-striped table-bordered table-report">
				<thead>
					<tr>
						<th>ENVIRONMENTAL</th>
						<th width="15%">No.</th>
						<th width="15%">%</th>
					</tr>
				</thead>

				<tbody>
					<tr><td>Households with access to improved or safe water supply ♣</td><td>{{ ($households_water_1+$households_water_2+$households_water_3) }}</td><td>{{ getPercentage(($households_water_1+$households_water_2+$households_water_3),$households,100 , 2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level I (Point Source) ♣</td><td>{{ $households_water_1 }}</td><td>{{ getPercentage($households_water_1,$households,100,2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level II (Communal Faucet System or Standpost) ♣</td><td>{{ $households_water_2 }}</td><td>{{ getPercentage($households_water_2,$households,100,2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level III (Waterworks System) ♣</td><td>{{ $households_water_3 }}</td><td>{{ getPercentage($households_water_3,$households,100,2) }}%</td></tr>
					<tr><td>Households with sanitary toilet facilities ♣</td><td>{{ $households_toilet }}</td><td>{{ getPercentage($households_toilet,$households,100,2) }}%</td></tr>
					<tr><td>Households with satisfactory disposal of solid waste ♣</td><td>{{ $households_solid_waste }}</td><td>{{ getPercentage($households_solid_waste,$households,100,2) }}%</td></tr>
					<tr><td>Households with complete basic sanitation facilities ♣</td><td>{{ $households_sanitary }}</td><td>{{ getPercentage($households_sanitary,$households,100,2) }}%</td></tr>
					<tr><td>Food Establishments </td><td>{{ $food_establishments }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>Food Establishments with sanitary permit ♥</td><td>{{ $food_establishments_permit }}</td><td>{{ getPercentage($food_establishments_permit,$food_establishments,100,2) }}%</td></tr>
					<tr><td>Food Handlers</td><td>{{ $food_handlers }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>Food Handlers  with health certificate ☻</td><td>{{ $food_handlers_permit }}</td><td>{{ getPercentage($food_handlers_permit,$food_handlers,100,2) }}%</td></tr>
					<tr><td>Salt Samples Tested</td><td>{{ $salt_samples }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>Salt Samples Tested (+) for iodine</td><td>{{ $salt_samples_iodine }}</td><td>{{ getPercentage($salt_samples_iodine,$salt_samples,100,2) }}%</td></tr>
					<tr><td colspan="3"><em class="small">Denominator: &nbsp; ♣No. Households &nbsp; ♥No.Food Establishments &nbsp; ☻No.Food Handlers  </em></td></tr>
				</tbody>
			</table>

			<br>
			<table class="table table-striped table-bordered table-report">
				<thead>
					<tr>
						<th colspan="8">NATALITY</th>
					</tr>
				</thead>

				<tbody>
					<tr><td colspan="2">No. of livebirths</td><td colspan="2">{{ $neonatal['livebirths']['count'] }}</td><td><strong>Birthweight</strong></td><td><strong>Male</strong></td><td><strong>Female</strong></td><td><strong>Total</td></strong></tr>
					<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. of male</td><td colspan="2">{{ $neonatal['livebirths']['male']['count'] }}</td><td>2500 grams &amp; greater</td><td>{{ $neonatal['livebirths']['male']['greater_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['greater_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['greater_weight']['count'] }}</td></tr>
					<tr><td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No. of female</td><td colspan="2">{{ $neonatal['livebirths']['female']['count'] }}</td><td>Less than 2500 grams</td><td>{{ $neonatal['livebirths']['male']['lesser_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['lesser_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['lesser_weight']['count'] }}</td></tr>
					<tr><td></td><td><strong>Male</strong></td><td><strong>Female</strong></td><td><strong>Total</strong></td><td><strong>Total</strong></td><td>{{ $neonatal['livebirths']['male']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['count'] }}</td><td>{{ $neonatal['livebirths']['count'] }}</td></tr>
					<tr><td>Doctors</td><td>{{ $neonatal['livebirths']['male']['doctor']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['doctor']['count'] }}</td><td>{{ $neonatal['livebirths']['doctor']['count'] }}</td><td colspan="4"></td></tr>
					<tr><td>Nurses</td><td>{{ $neonatal['livebirths']['male']['nurse']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['nurse']['count'] }}</td><td>{{ $neonatal['livebirths']['nurse']['count'] }}</td><td><strong>Pregnancy Outcome</strong></td><td><strong>Male</strong></td><td><strong>Female</strong></td><td><strong>Total</strong></td></tr>
					<tr><td>Midwives</td><td>{{ $neonatal['livebirths']['male']['midwife']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['midwife']['count'] }}</td><td>{{ $neonatal['livebirths']['midwife']['count'] }}</td><td>Livebirths</td><td>{{ $neonatal['livebirths']['male']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['count'] }}</td><td>{{ $neonatal['livebirths']['count'] }}</td></tr>
					<tr><td>Hilot/TBA</td><td>{{ $neonatal['livebirths']['male']['hilot']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['hilot']['count'] }}</td><td>{{ $neonatal['livebirths']['hilot']['count'] }}</td><td>Fetal Deaths</td><td>{{ $neonatal['fetal_death']['male']['count'] }}</td><td>{{ $neonatal['fetal_death']['female']['count'] }}</td><td>{{ $neonatal['fetal_death']['count'] }}</td></tr>
					<tr><td>Others</td><td>{{ $neonatal['livebirths']['male']['other']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['other']['count'] }}</td><td>{{ $neonatal['livebirths']['other']['count'] }}</td><td>Abortion</td><td bgcolor="#A9A9A9"></td><td bgcolor="#A9A9A9"></td><td>{{ $neonatal['abortion']['count'] }}</td></tr>
					<tr><td colspan="4"><strong>Deliveries by Type and Place</strong></td></tr>
					<tr><td rowspan="2">Type</td><td colspan="2">NID</td><td rowspan="2">Health Facility</td></tr>
					<tr><td>Home</td><td>Others</td></tr>
					<tr><td>Normal</td><td>{{ $neonatal['delivery']['normal']['home']['count'] }}</td><td>{{ $neonatal['delivery']['normal']['other']['count'] }}</td><td>{{ $neonatal['delivery']['normal']['facility']['count'] }}</td></tr>
					<tr><td>Operative</td><td>{{ $neonatal['delivery']['operative']['home']['count'] }}</td><td>{{ $neonatal['delivery']['operative']['other']['count'] }}</td><td>{{ $neonatal['delivery']['operative']['facility']['count'] }}</td></tr>
				</tbody>
			</table>

			<br>
			<table class="table table-striped table-bordered table-report">
				<thead>
					<tr><th colspan="5">NATALITY LIVEBIRTHS</th></tr>
					<tr><th rowspan="2">Indicators</th><th colspan="3">Number</th><th rowspan="2">%</th></tr>
					<tr><th>Male</th><th>Female</th><th>Total</th></tr>
				</thead>

				<tbody>
					<tr><td>No. of Pregnacies</td><td>{{ $neonatal['pregnancies']['male']['count'] }}</td><td>{{ $neonatal['pregnancies']['female']['count'] }}</td><td>{{ $neonatal['pregnancies']['count'] }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>Pregnancies by outcome</td><td></td><td></td><td></td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Livebirths (LB)</td><td>{{ $neonatal['livebirths']['male']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['count'] }}</td><td>{{ $neonatal['livebirths']['count'] }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fetal Death</td><td>{{ $neonatal['fetal_death']['male']['count'] }}</td><td>{{ $neonatal['fetal_death']['female']['count'] }}</td><td>{{ $neonatal['fetal_death']['male']['count'] + $neonatal['fetal_death']['female']['count'] }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abortion</td><td>{{ $neonatal['abortion']['male']['count'] }}</td><td>{{ $neonatal['abortion']['female']['count'] }}</td><td>{{ $neonatal['abortion']['male']['count'] + $neonatal['abortion']['female']['count'] }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>No. of Deliveries</td><td></td><td></td><td></td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NSD</td><td>{{ $neonatal['delivery']['male']['normal']['count'] }}</td><td>{{ $neonatal['delivery']['female']['normal']['count'] }}</td><td>{{ $neonatal['delivery']['male']['normal']['count'] + $neonatal['delivery']['female']['normal']['count'] }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Operative</td><td>{{ $neonatal['delivery']['male']['operative']['count'] }}</td><td>{{ $neonatal['delivery']['female']['operative']['count'] }}</td><td>{{ $neonatal['delivery']['male']['operative']['count'] +$neonatal['delivery']['female']['operative']['count'] }}</td><td bgcolor="#A9A9A9"></td></tr>
					<tr><td>LB w/ weight 2500 grams &amp; greater ☻</td><td>{{ $neonatal['livebirths']['male']['greater_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['greater_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['greater_weight']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['greater_weight']['count'],$neonatal['livebirths']['count'],100,2) }}%</td></tr>
					<tr><td>LB w/ weight less than 2500 grams ☻</td><td>{{ $neonatal['livebirths']['male']['lesser_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['lesser_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['lesser_weight']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['lesser_weight']['count'],$neonatal['livebirths']['count'],100,2) }}%</td></tr>
					<tr><td>LB - Not known weights ☻</td><td>{{ $neonatal['livebirths']['male']['unknown_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['unknown_weight']['count'] }}</td><td>{{ $neonatal['livebirths']['unknown_weight']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['unknown_weight']['count'],$neonatal['livebirths']['count'],100,2) }}%</td></tr>
					<tr><td>LB delivered by doctors ☻</td><td>{{ $neonatal['livebirths']['male']['doctor']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['doctor']['count'] }}</td><td>{{ $neonatal['livebirths']['doctor']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['doctor']['count'],$neonatal['livebirths']['count'],100,2) }}%</td></tr>
					<tr><td>LB delivered by nurses ☻</td><td>{{ $neonatal['livebirths']['male']['nurse']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['nurse']['count'] }}</td><td>{{ $neonatal['livebirths']['nurse']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['nurse']['count'],$neonatal['livebirths']['count'],100,2) }}%</td></tr>
					<tr><td>LB delivered by midwives ☻</td><td>{{ $neonatal['livebirths']['male']['midwife']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['midwife']['count'] }}</td><td>{{ $neonatal['livebirths']['midwife']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['midwife']['count'],$neonatal['livebirths']['count'],100,2) }}%</td></tr>
					<tr><td>LB delivered by hilot/TBA ☻</td><td>{{ $neonatal['livebirths']['male']['hilot']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['hilot']['count'] }}</td><td>{{ $neonatal['livebirths']['hilot']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['hilot']['count'],$neonatal['livebirths']['count'],100,2) }}%</td></tr>
					<tr><td>LB delivered by others ☻</td><td>{{ $neonatal['livebirths']['male']['other']['count'] }}</td><td>{{ $neonatal['livebirths']['female']['other']['count'] }}</td><td>{{ $neonatal['livebirths']['other']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['other']['count'],$neonatal['livebirths']['count'],100,2) }}%</td></tr>
					<tr><td colspan="5"><em class="small"> Denominator: &nbsp; ☻Livebirths </em></td></tr>
				</tbody>
			</table>

			<br>
			<table class="table table-striped table-bordered table-report">
				<thead>
					<tr>
						<th>NATALITY DELIVERIES</th>
						<th width="15%">No.</th>
						<th width="15%">%</th>
					</tr>
				</thead>

				<tbody>
					<tr><td>Total No. of Pregnancies ♣</td><td>{{ $neonatal['pregnancies']['count'] }}</td><td>{{ getPercentage($neonatal['pregnancies']['count'],$neonatal['pregnancies']['count'],100,2) }}%</td></tr>
					<tr><td>Outcome of Pregnancy ♣</td><td></td><td></td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Live Births</td><td>{{ $neonatal['livebirths']['count'] }}</td><td>{{ getPercentage($neonatal['livebirths']['count'],$neonatal['pregnancies']['count'],100,2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fetal death</td><td>{{ $neonatal['fetal_death']['count'] }}</td><td>{{ getPercentage($neonatal['fetal_death']['count'],$neonatal['pregnancies']['count'],100,2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abortion</td><td>{{ $neonatal['abortion']['count'] }}</td><td>{{ getPercentage($neonatal['abortion']['count'],$neonatal['pregnancies']['count'],100,2) }}%</td></tr>
					<tr><td>Normal Deliveries ♣</td><td>{{ $neonatal['delivery']['normal']['count'] }}</td><td>{{ getPercentage( $neonatal['delivery']['normal']['count'],$neonatal['pregnancies']['count'],100,2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deliveries at Home ♥</td><td>{{ $neonatal['delivery']['normal']['home']['count'] }}</td><td>{{ getPercentage($neonatal['delivery']['normal']['home']['count'],$neonatal['delivery']['normal']['count'],100,2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deliveries at Health Facility ♥</td><td>{{ $neonatal['delivery']['normal']['facility']['count'] }}</td><td>{{ getPercentage($neonatal['delivery']['normal']['facility']['count'],$neonatal['delivery']['normal']['count'],100,2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deliveries - Other Place ♥</td><td>{{ $neonatal['delivery']['normal']['other']['count'] }}</td><td>{{ getPercentage( $neonatal['delivery']['normal']['other']['count'],$neonatal['delivery']['normal']['count'],100,2) }}%</td></tr>
					<tr><td>Operative Deliveries ♣</td><td>{{ $neonatal['delivery']['operative']['count'] }}</td><td>{{ getPercentage( $neonatal['delivery']['operative']['count'],$neonatal['pregnancies']['count'],100,2)  }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deliveries at Health Facility ♠</td><td>{{ $neonatal['delivery']['operative']['facility']['count'] }}</td><td>{{ getPercentage($neonatal['delivery']['operative']['facility']['count'],$neonatal['delivery']['operative']['count'],100,2) }}%</td></tr>
					<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deliveries - Other Place ♠</td><td>{{ $neonatal['delivery']['operative']['other']['count'] }}</td><td>{{ getPercentage($neonatal['delivery']['operative']['other']['count'],$neonatal['delivery']['operative']['count'],100,2) }}%</td></tr>
					<tr><td colspan="3"><em class="small"> Denominator: &nbsp; ☻Livebirths &nbsp; ♣Pregnancies &nbsp; ♥Normal Deliveries &nbsp; ♠Other Type of Deliveries </em></td></tr>
				</tbody>
			</table>

			<br>
			<table class="table table-striped table-bordered table-report">
				<thead>
					<tr><th colspan="5">MORTALITY</th></tr>
					<tr><th rowspan="2">Indicators</th><th colspan="3">Number</th><th rowspan="2">Rate</th></tr>
					<tr><th>Male</th><th>Female</th><th>Total</th></tr>
				</thead>

				<tbody>
					<?php $mort_mult = 100000 ?>
					<tr><td>Deaths ♣</td><td>{{ $mortality['male']['count'] }}</td><td>{{ $mortality['female']['count'] }}</td><td>{{ $mortality['male']['count'] + $mortality['female']['count'] }}</td><td>{{ getPercentage( $mortality['male']['count'] + $mortality['female']['count'] , $population, $mort_mult, 0) }} / {{ $mort_mult }}</td></tr>
					<tr><td>Maternal Deaths ☻</td><td bgcolor="#A9A9A9"></td><td>{{ $mortality['maternal']['count'] }}</td><td>{{ $mortality['maternal']['count'] }}</td><td>{{ getPercentage( $mortality['maternal']['count'] , $neonatal['livebirths']['count'], $mort_mult, 0) }} / {{ $mort_mult }}</td></tr>
					<tr><td>Perinatal Deaths ☻</td><td>0</td><td>0</td><td>0</td><td>0 / {{ $mort_mult }}</td></tr>
					<tr><td>Fetal Deaths ☻</td><td>{{ $neonatal['fetal_death']['male']['count'] }}</td><td>{{ $neonatal['fetal_death']['female']['count'] }}</td><td>{{ $neonatal['fetal_death']['male']['count'] + $neonatal['fetal_death']['female']['count'] }}</td><td>{{ getPercentage( $neonatal['fetal_death']['male']['count'] + $neonatal['fetal_death']['female']['count'], $neonatal['livebirths']['count'], $mort_mult, 0) }} / {{ $mort_mult }}</td></tr>
					<tr><td>Neonatal Deaths ☻</td><td>{{ $mortality['neonatal']['male']['count'] }}</td><td>{{ $mortality['neonatal']['male']['count'] }}</td><td>{{ $mortality['neonatal']['male']['count'] + $mortality['neonatal']['male']['count'] }}</td><td>{{ getPercentage( $mortality['neonatal']['male']['count'] + $mortality['neonatal']['male']['count'], $neonatal['livebirths']['count'], $mort_mult, 0) }} / {{ $mort_mult }}</td></tr>
					<tr><td>Infant Deaths ☻</td><td>0</td><td>0</td><td>0</td><td>0 / {{ $mort_mult }}</td></tr>
					<tr><td>Deaths among children Under 5 yrs old ☻</td><td>{{ $mortality['under_five']['male']['count'] }}</td><td>{{ $mortality['under_five']['female']['count'] }}</td><td>{{ $mortality['under_five']['male']['count'] + $mortality['under_five']['female']['count'] }}</td><td>{{ getPercentage( $mortality['under_five']['male']['count'] + $mortality['under_five']['female']['count'], $neonatal['livebirths']['count'], $mort_mult, 0) }} / {{ $mort_mult }}</td></tr>
					<tr><td>Deaths due to Neonatal Tetanus ☻</td><td>0</td><td>0</td><td>0</td><td>0 / {{ $mort_mult }}</td></tr>
					<tr><td colspan="5"><em class="small"> Denominator: &nbsp; ♣ Population &nbsp; ☻Livebirths </em></td></tr>
				</tbody>
			</table>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
@stop