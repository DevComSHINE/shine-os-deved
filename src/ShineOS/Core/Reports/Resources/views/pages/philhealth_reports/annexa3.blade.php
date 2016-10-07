<h4><b>QPCB Patient Ledger</b> (Annex A3)</h4>
<h5><b>Part 1</b></h5>

<div class="row">
	<div class="col-md-4">
		<div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Patient Details</h3>
      </div>
      <div class="box-body no-padding">
        <table width="100%" class="table table-bordered table-striped">
          <tr>
            <td><b>Name</b></td>
            <td>Derek Shepherd</td>
          </tr>
          <tr>
            <td><b>Age</b></td>
            <td>42</td>
          </tr>
          <tr>
            <td><b>Sex</b></td>
            <td>Male</td>
          </tr>
          <tr>
            <td><b>Address</b></td>
            <td>71 Katipunan Avenue, QC</td>
          </tr>
          <tr>
            <td><b>PIN</b></td>
            <td>PHIE7381271</td>
          </tr>
          <tr>
            <td><b>Membership Type</b></td>
            <td>Member</td>
          </tr>
          <tr>
            <td><b>Sponsored</b></td>
            <td>NHTS</td>
          </tr>
          <tr>
            <td><b>IPP</b></td>
            <td>OFW</td>
          </tr>
          <tr>
            <td><b>Employed</b></td>
            <td>Private</td>
          </tr>
          <tr>
            <td><b>Lifetime</b></td>
            <td>Yes</td>
          </tr>
        </table>
      </div><!-- /.box-body -->
  	</div>
  </div>

  <div class="col-md-8">
		<div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Obligated Services</h3>
      </div>
      <div class="box-body no-padding">
        <table width="100%" class="table table-bordered table-striped">
          <tr>
            <td rowspan="2"><b>Primary Preventive Services</b></td>
            <td rowspan="2">Frequency</td>
            <td colspan="4"><center>Date Performed</center></td>
          </tr>
          <tr>
            <td>1st Qtr</td>
            <td>2nd Qtr</td>
            <td>3rd Qtr</td>
            <td>4th Qtr</td>
          </tr>
          <tr>
            <td>1a. BP Measurements (Hypertensive)</td>
            <td>Once a Month</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>1b. BP Measurements (Nonhypertensive)</td>
            <td>Once a Year</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>2. Periodical clinical Breast Examination</td>
            <td>Once a Year</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
          <tr>
            <td>3. Visual Inspection with Acetic Acid/td>
            <td>Once a year</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </table>
      </div><!-- /.box-body -->
  	</div>
  </div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Diagnostic Examination Services</h3>
      </div>
      <div class="box-body no-padding">
        <table width="100%" class="table table-bordered table-striped">
          <tr>
            <td><b>Date</b></td>
            <td><b>Diagnosis</b></td>
            <td><b>Type</b></td>
            <td><b>Given</b></td>
            <td><b>Referred</b></td>
            <td><b>Remarks</b></td>
          </tr>
        @for ($i = 1; $i <= 7; $i++)
          <tr>
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

	<div class="col-md-3">
		<div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Other PCB1 Services</h3>
      </div>
      <div class="box-body no-padding">
        <table width="100%" class="table table-bordered table-striped">
          <tr>
            <td><b>Date</b></td>
            <td><b>Diagnosis</b></td>
            <td><b>Type</b></td>
            <td><b>Remarks</b></td>
          </tr>
        @for ($i = 1; $i <= 7; $i++)
          <tr>
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

	<div class="col-md-3">
		<div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Other Services</h3>
      </div>
      <div class="box-body no-padding">
        <table width="100%" class="table table-bordered table-striped">
          <tr>
            <td><b>Date</b></td>
            <td><b>Diagnosis</b></td>
            <td><b>Type</b></td>
            <td><b>Remarks</b></td>
          </tr>
        @for ($i = 1; $i <= 7; $i++)
          <tr>
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


<h5><b>Part 2</b></h5>

<div class="row">
	<div class="col-md-12">
		<div class="box box-success box-solid">
      <div class="box-header with-border">
        <h3 class="box-title">Consultation History</h3>
      </div>
      <div class="box-body no-padding">
        <table width="100%" class="table table-bordered table-striped">
          <tr>
            <td><b>Date</b></td>
            <td><b>History of Present Illness</b></td>
            <td><b>Physical Exam</b></td>
            <td><b>Assessment/Impression</b></td>
            <td><b>Treatment/Management Plan</b></td>
          </tr>
        @for ($i = 1; $i <= 7; $i++)
          <tr>
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