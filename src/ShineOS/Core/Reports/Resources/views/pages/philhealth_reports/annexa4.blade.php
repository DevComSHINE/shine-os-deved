<h4><b>Quarterly Report Form</b> (Annex A4)</h4>
<div class="row">
  <div class="col-md-4">

  	<!-- COVERED PERIOD -->
  	<div class="row">
  		<div class="col-md-12">
    		<div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Covered Period</h3>
          </div>
          <div class="box-body no-padding">
            <table width="100%" class="table table-bordered table-striped">
              <tr>
                <td><b>From</b></td>
                <td>01/01/2016</td>
              </tr>
              <tr>
                <td><b>To</b></td>
                <td>03/31/2016</td>
              </tr>
            </table>
          </div><!-- /.box-body -->
      	</div>
      </div>
  	</div>

    <!-- PCB Participation No. -->
    <div class="row">
  		<div class="col-md-12">
    		<div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">PCB Participation No.</h3>
          </div>
          <div class="box-body no-padding">
            <table width="100%" class="table table-bordered table-striped">
              <tr>
                <td><b>Participation No.</b></td>
                <td>01929382193</td>
              </tr>
            </table>
          </div><!-- /.box-body -->
      	</div>
      </div>
  	</div>

  	<!-- MUNICIPALITY/CITY/PROVINCE -->
    <div class="row">
  		<div class="col-md-12">
    		<div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Municipality/City/Province</h3>
          </div>
          <div class="box-body no-padding">
            <table width="100%" class="table table-bordered table-striped">
              <tr>
                <td><b>Municipality/City</b></td>
                <td>Quezon City</td>
              </tr>
              <tr>
                <td><b>Province</b></td>
                <td>Metro Manila</td>
              </tr>
            </table>
          </div><!-- /.box-body -->
      	</div>
      </div>
  	</div>

  	<!-- MEMBERS AND DEPENDENTS SERVED -->
    <div class="row">
  		<div class="col-md-12">
    		<div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Members and Dependents Served</h3>
          </div>
          <div class="box-body no-padding">
            <table width="100%" class="table table-bordered table-striped">
              <tr>
                <th><b></b></th>
                <th><b>Male</b></th>
                <th><b>Female</b></th>
                <th><b>Total</b></th>
              </tr>
              <tr>
                <td><b>Members</b></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>Dependents</b></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><b>Total</b></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </table>
          </div><!-- /.box-body -->
      	</div>
      </div>
  	</div>

  	<!-- TOP 10 COMMON ILLNESSES (MORBIDITY) -->
    <div class="row">
  		<div class="col-md-12">
    		<div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Top 10 Common Illnesses (Morbidity)</h3>
          </div>
          <div class="box-body no-padding">
            <table width="100%" class="table table-bordered table-striped">
              <tr>
                <th><b>Illness</b></th>
                <th><b>Number of Cases</b></th>
              </tr>

              @for ($i = 1; $i <= 10; $i++)
						    <tr>
	                <td>Disease {{ $i }}</td>
	                <td></td>
	              </tr>
							@endfor
              
            </table>
          </div><!-- /.box-body -->
      	</div>
      </div>
  	</div>
  </div>

  
	<div class="col-md-8">
		<!-- OBLIGATED SERVICES -->
		<div class="row">
			<div class="col-md-12">
    		<div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Obligated Services</h3>
          </div>
          <div class="box-body no-padding">
            <table width="100%" class="table table-bordered table-striped">
              <tr>
                <th><b>Obligated Services</b></th>
                <th><b>Target</b></br><small style="color:grey;">(For the Quarter)</small></th>
                <th><b>Accomplishment</b></br><small style="color:grey;">(Number)</small></th>
              </tr>
              <tr>
                <td colspan="3"><b>Primary Preventive Services</b></td>
              </tr>
              <tr>
                <td>BP Measurement <i>(Hypertensive)</i></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>BP Measurement <i>(Nonhypertensive)</i></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Periodic Clinical Breast Examination</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Visual Inspection with Acetic Acid</td>
                <td></td>
                <td></td>
              </tr>
            </table>
          </div><!-- /.box-body -->
      	</div>
      </div>
    </div>

    <!-- MEDICINES GIVEN -->
		<div class="row">
			<div class="col-md-12">
    		<div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Medicines Given</h3>
          </div>
          <div class="box-body no-padding">
            <table width="100%" class="table table-bordered table-striped">
              <tr>
              	<th><b>Service</b></th>
                <th><b>Generic Name</b></th>
                <th colspan="2"><center>No. of Members/Dependents</center></th>
              </tr>
              <tr>
                <td colspan="2"></td>
                <td><b>Member</b></td>
                <td><b>Dependent</b></td>
              </tr>

              <tr>
                <td rowspan="2"><b>Asthma</b></td>
                <td>Medicine 1<td>
                <td></td>
                <td></td>
              </tr>
              @for ($i = 2; $i <= 2; $i++)
	              <tr>
	                <td>Medicine {{ $i }}</td>
	                <td></td>
	                <td></td>
	              </tr>
              @endfor	
              
              <tr>
                <td rowspan ="4"><b>AGE With No or Mild Dehydration</b></td>
                <td>Medicine 1<td>
                <td></td>
                <td></td>
              </tr>
              @for ($i = 2; $i <= 4; $i++)
	              <tr>
	                <td>Medicine {{ $i }}</td>
	                <td></td>
	                <td></td>
	              </tr>
              @endfor	
              
              <tr>
                <td rowspan ="3"><b>URTI/Pneumonia</b></br><small style="color:grey;"> (Minimal & Low Risk)</small></td>
                <td>Medicine 1<td>
                <td></td>
                <td></td>
              </tr>
              @for ($i = 2; $i <= 3; $i++)
	              <tr>
	                <td>Medicine {{ $i }}</td>
	                <td></td>
	                <td></td>
	              </tr>
              @endfor	
              
              <tr>
                <td rowspan ="2"><b>Urinary Tract Infection</b></td>
                <td>Medicine 1<td>
                <td></td>
                <td></td>
              </tr>
              @for ($i = 2; $i <= 2; $i++)
	              <tr>
	                <td>Medicine {{ $i }}</td>
	                <td></td>
	                <td></td>
	              </tr>
              @endfor	
              
              <tr>
                <td rowspan ="2"><b>Nebulisation Services</b></td>
                <td>Medicine 1<td>
                <td></td>
                <td></td>
              </tr>
              @for ($i = 2; $i <= 2; $i++)
	              <tr>
	                <td>Medicine {{ $i }}</td>
	                <td></td>
	                <td></td>
	              </tr>
              @endfor	
            </table>
          </div><!-- /.box-body -->
      	</div>
      </div>
    </div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Benefits/Services Provided</h3>
      </div>
      <div class="box-body no-padding">
        <table width="100%" class="table table-bordered table-striped">
          <tr>
            <th rowspan="3" style="vertical-align:middle;"><b><center>Benefits/Services Provided</center></b></th>
            <th colspan="4"><b>No. of Members/Dependents</b></th>
          </tr>
          <tr>
          	<th colspan="2"><b>Given</b></th>
          	<th colspan="2"><b>Referred</b></th>
          </tr>
          <tr>
          	<th><b>M</b></th>
          	<th><b>D</b></th>
          	<th><b>M</b></th>
          	<th><b>D</b></th>
          </tr>
          <tr>
          	<th colspan="5"><b><center>Primary Preventive Services</center></b></th>
          </tr>

          <?php $primaryPreventiveServices = array("Consultation", "Visual Inspection with Acetic Acid", "Regular BP Measurements", "Breastfeeding program Education", "Periodic Clinical Breast Examinations", "Counselling for Lifestyle Modification", "Counselling for Smoking Cessation", "Body Measuremnts", "Digital Rectal Examination") ?>

          @foreach ($primaryPreventiveServices as $pps)
				  	<tr>
				  		<td>{{$pps}}</td>
				  		<td></td>
				  		<td></td>
				  		<td colspan="2"><center>N/A</center></td>
				  	</tr>
					@endforeach

					<tr>
          	<th colspan="5"><b><center>Diagnostics Examinations</center></b></th>
          </tr>

          <?php $diagnosticsExamination = array("Complete Blood Count (CBC)", "Urinalysis","Fecalysis","Sputum Miroscopy", "Fasting Blood Sugar","Lipid Profile", "Chest X-Ray") ?>

          @foreach ($diagnosticsExamination as $de)
				  	<tr>
				  		<td>{{$de}}</td>
				  		<td></td>
				  		<td></td>
				  		<td></td>
				  		<td></td>
				  	</tr>
					@endforeach
        </table>
      </div><!-- /.box-body -->
  	</div>
	</div>
</div>