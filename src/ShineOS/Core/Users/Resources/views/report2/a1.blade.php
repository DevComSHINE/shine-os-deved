@extends('users::layouts.master')

@section('content')
<!--NOTE:: SEPARATE PORTIONS-->
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
			  <h3 class="box-title">A1 Report</h3>
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
						<form action="/demo/#reports/generate/m1/" method="post" id="generate">
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
						</form><!-- /form -->
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
					<tr><th colspan="7">DEMOGRAPHIC PROFILE</th></tr>
					</thead>
					<tbody>
						<thead> <tr>
							<th rowspan="2"> Indicators </th>
							<th colspan="3"> Number </th>
							<th rowspan="2" width="6%"> Ratio to Pop. </th>
							<th rowspan="2"> Interpretation </th>
							<th rowspan="2"> Recommendation / Actions Taken </th>
						</tr>
						<tr>
							<th width="6%"> Male </th>
							<th width="6%"> Female </th>
							<th width="6%"> Total </th>
						</tr> </thead>
						<tr>
							<td> Barangays </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Barangay Health Stations </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Health Centers </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Households </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Physicians/Doctors </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Dentist </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Nurses </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Midwives </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Medical Technologists </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Sanitary Engineers </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Sanitation Inspectors </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Nutritionist </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Active Barangay Health Workers </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>

					</tbody>
				</table>

				<table class="table table-striped table-bordered table-report">
					<thead>
					<tr><th colspan="7">ENVIRONMENTAL</th></tr>
					<tr>
						<th rowspan="3">ENVIRONMENTAL</th>
						<th rowspan="3" width="6%">No.</th>
						<th rowspan="3" width="6%">%</th>
						<th rowspan="3">Interpretation</th>
						<th rowspan="3">Recommendation / Actions Taken</th>

					</tr>
					</thead>

					<tbody>
						<tr><td> Total number of Households (HH)</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> HH w/ access to improved water supply</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> --- Level I</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> --- Level II</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> --- Level III</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> HH w/ sanitary toilet facilities</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> HH w/satisfactory disposal of solid waste</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> HH w/complete basic sanitation facilities</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> Food Establishment</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> Food Establishment w/Sanitary Permit</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> Food Handlers</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> Food Handlers w/Health Certificate</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> Salt Samples Tested</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr><td> Salt Samples Tested (+) for Iodine</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>


				<table class="table table-striped table-bordered  table-report">
					<thead>
					<tr><th colspan="7">NATALITY - LIVEBIRTHS</th></tr>
					</thead>

					<tbody>
						<thead> 
							<tr>
								<th rowspan="2"> Indicators </th>
								<th colspan="3"> Number </th>
								<th rowspan="2" width="6%"> % </th>
								<th rowspan="2"> Interpretation </th>
								<th rowspan="2"> Recommendation / Actions Taken </th>
							</tr>
							<tr>
								<th width="6%"> Male </th>
								<th width="6%"> Female </th>
								<th width="6%"> Total </th>
							</tr> 
						</thead>
						
						<tr>
							<td> No. of Pregnancies</td>			
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Pregnancies by outcome</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Livebirths (LB) </td>
							<td></td> <td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Fetal Death </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Abortion</td>
							<td></td> <td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> No. of Deliveries </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- NSD </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Operative </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> LB w/weights 2500 grams &amp; greater </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> LB w/weights less than 2500 grams </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> LB - Unknown weight </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> LB delivered by doctors </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> LB delivered by nurses </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> LB delivered by midwives </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> LB delivered by hilot/TBA </td>
							<td></td> <td></td>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> LB delivered by others </td>
							<td></td> <td></td>
							</td>
							<td> </td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>


				<table class="table table-striped table-bordered  table-report">
					<thead>
					<tr><th colspan="7">NATALITY - DELIVERIES</th></tr>
					</thead>

					<tbody>
						<thead> <tr>
							<th> Indicators </th>
							<th width="6%"> Number </th>
							<th width="6%"> % </th>
							<th> Interpretation </th>
							<th> Recommendation / Actions Taken </th>
						</tr></thead>
						<tr>
							<td> Total No. of Pregnancies</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Outcome of  Pregnancy</td>
							<td> </td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Live Births</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Fetal death</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Abortion</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> Normal Deliveries</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr> 
						<!-- livebirth_place_of_delivery -->
							<td> --- Deliveries at Home</td> 
							<!-- hme -->
							<!-- FB -->
							<!-- oth -->
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr> 
							<td> --- Deliveries at Health Facility</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Deliveries - Other Place</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>  Operative Deliveries </td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Deliveries at Home</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Deliveries at Health Facility</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td> --- Deliveries - Other Place</td>
							<td> </td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>


				<table class="table table-striped table-bordered  table-report">
					<thead>
					<tr><th colspan="7">MORTALITY</th></tr>
					</thead>

					<tbody>
						<thead> <tr>
							<th rowspan="2"> Indicators </th>
							<th colspan="3"> Number </th>
							<th rowspan="2" width="6%"> Rate </th>
							<th rowspan="2"> Interpretation </th>
							<th rowspan="2"> Recommendation / Actions Taken </th>
						</tr>
						<tr>
							<th width="6%"> Male </th>
							<th width="6%"> Female </th>
							<th width="6%"> Total </th>
						</tr> </thead>
						<tbody>
							<tr>
								<td>Deaths</td>
								<td></td> <td></td>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Maternal Deaths</td>
								<td></td> <td></td>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Perinatal Deaths</td>
								<td></td> <td></td>

								<td>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Fetal Deaths</td>
								<td></td> <td></td>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Neonatal Deaths</td>
								<td></td><td></td>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Infant Deaths</td>
								<td></td>
								<td></td>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Deaths among children Under 5 yrs old</td>
								<td></td>
								<td></td>
								</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Deaths due to Neonatal Tetanus</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
						</tbody>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
@stop