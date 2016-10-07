
@section ("heads")
{!! HTML::style('/public/dist/css/philhealth_report.css') !!}
@stop

<div class = "row">
	<div class="col-md-12">
		<h4><b>Quarterly Summary of PCB Services Provided </b> (Annex A5)</h4>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Table of Summary</h3>
          </div>
          <div class="box-body no-padding">
            <table id="annex_a5_table" width="100%" class="table table-bordered table-striped">

            	<?php $benefitsGiven = array(" ","Date","Philhealth Number", "Name", "Membership","Sex", "Age", "Diagnosis", "Consultation", "Visual Inspection with Acetic Acid", "Regular BP Measurements", "Breastfeeding program Education", "Periodic Clinical Breast Examinations", "Counselling for Lifestyle Modification", "Counselling for Smoking Cessation", "Body Measuremnts", "Digital Rectal Examination","CBC", "Urinalysis","Fecalysis","Sputum Miroscopy", "FBS","Lipid Profile", "Chest X-Ray", " ") ?>

              <tr>
                <th></th>
                <th></th>
                <th colspan="6"><center>Patient</center></th>
                <th colspan="16"><center>Benefits Given (Number of Times Benefit was Given)</center></th>
                <th><center>Medicines Given</center></th>
              </tr>
              <tr>
                @foreach ($benefitsGiven as $bg)
                <th>{{$bg}}</th>
                @endforeach
              </tr>

              @for ($i = 1; $i <= 25; $i++)
						    <tr>
						    	<td>{{$i}}</td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
						    	<td></td>
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