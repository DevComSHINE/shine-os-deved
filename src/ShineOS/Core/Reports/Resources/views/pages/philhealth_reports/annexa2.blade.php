@extends('reports::layouts.fhsis_master')
@section('reportGroup')Philhealth @stop
@section('reportTitle') Annex A2 @stop

@section('heads')
{!! HTML::style('public/dist/plugins/stickytableheader/css/component.css') !!}
@stop

@section('content')
<section class="fhsis">
<div class="row">
  <div class="col-md-12">
    <h4><b>PCB Provider Clientele Profile</b> (Annex A2)</h4>
    <div class="row">
      <div class="col-md-4">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">PCB Provider Data</h3>
            </div>
            <div class="box-body no-padding">
              <table width="100%" class="table table-bordered table-striped">
                <tr>
                  <td><b>Region</b></td>
                  <td>Region 4</td>
                </tr>
                <tr>
                  <td><b>Province</b></td>
                  <td>Batangas</td>
                </tr>
                <tr>
                  <td><b>City/Municipality</b></td>
                  <td>San Juan</td>
                </tr>
                <tr>
                  <th colspan=2> <center>No. of Assigned Families </center></th>
                </tr>
                <tr>
                  <td><b>SP-NHTS</b></td>
                  <td>3</td>
                </tr>
                <tr>
                  <td><b>SP-LGU</b></td>
                  <td>2</td>
                </tr>
                <tr>
                  <td><b>SP-NGA</b></td>
                  <td>0</td>
                </tr>
                <tr>
                  <td><b>SP-Private</b></td>
                  <td>1</td>
                </tr>
                <tr>
                  <td><b>SP-OG</b></td>
                  <td>2</td>
                </tr>
                <tr>
                  <td><b>SP-OFW</b></td>
                  <td>3</td>
                </tr>
                <tr>
                  <td><b>Non-PHIC Members</b></td>
                  <td>2</td>
                </tr>
              </table>
            </div><!-- /.box-body -->
        </div>
      </div>

      <!-- AGE SEX DISTRIBUTION -->
      <div class="col-md-4">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Age-Sex Distribution</h3>
            </div>
            <div class="box-body no-padding">
              <table width="100%" class="table table-bordered table-striped">
                <tr>
                  <th ></th>
                  <th colspan=3><center>Members and Dependent</center></th>
                </tr>
                <tr>
                  <td><b>Age Group</b></td>
                  <td>Male</td>
                  <td>Female</td>
                  <td>Total</td>
                </tr>
                <tr>
                  <td>0-1 Years</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>2-5 Years</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>6-15 Years</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>16-24 Years</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>25-59 Years</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Over 60 Years</td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            </div><!-- /.box-body -->
        </div>
      </div>

      <!-- PRIMARY PREVENTIVE SERVICES -->
      <div class="col-md-4">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Primary Preventive Services</h3>
            </div>
            <div class="box-body no-padding">
              <table width="100%" class="table table-bordered table-striped">
                <tr>
                  <th ></th>
                  <th colspan=2><center>Members and Dependent</center></th>
                </tr>
                <tr>
                  <td><b>Services</b></td>
                  <td>Member</td>
                  <td>Dependents</td>
                </tr>
                <tr>
                  <td>Breast Cancer Screening <small>Female, 25 Years Old and Above</small></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Cervical Cancer Screening <small>Female, 25 to 55 Years Old With Intact Uterus</small></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            </div><!-- /.box-body -->
        </div>
      </div>
    </div>

    <!-- SECOND ROW -->
    <div class="row">
        <!--  Diabetes Mellitus -->
      <div class="col-md-12">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Primary Preventive Services</h3>
            </div>
            <div class="box-body no-padding">
              <table width="100%" class="table table-bordered table-striped">
                <tr>
                  <th ></th>
                  <th colspan=2><center>Member</center></th>
                  <th colspan=2><center>Dependent</center></th>
                  <th colspan=2><center>Total</center></th>
                </tr>
                <tr>
                  <td><b>Cases</b></td>
                  <td><b>Male</b></td>
                  <td><b>Female</b></td>
                  <td><b>Male</b></td>
                  <td><b>Female</b></td>
                  <td><b>Male</b></td>
                  <td><b>Female</b></td>
                </tr>
                <tr>
                  <td>With symptoms/signs of polyuria, polydipsia, weight loss</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Waist Circumference <small style="color:grey;"> </br> > or equal 80cm (Female)</small></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Waist Circumference <small style="color:grey;"> </br> > or equal 90cm (Male)</small></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>History of diagnosis of Diabetes</small></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Intake of oral hypoglycemic agents</small></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            </div><!-- /.box-body -->
        </div>
      </div>

      <!-- HYPERTENSION -->
      <div class="col-md-12">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Primary Preventive Services</h3>
            </div>
            <div class="box-body no-padding">
              <table width="100%" class="table table-bordered table-striped">
                <tr>
                  <th ></th>
                  <th colspan=3><center>Member</center></th>
                  <th colspan=3><center>Dependent</center></th>
                  <th colspan=1 rowspan=2><center>Total</center></th>
                </tr>
                <tr>
                  <td><b>Cases</b></td>
                  <td><b>Male</b></td>
                  <td><b>Female</br><small style="color:grey;">Non-Pregnant</small></b></td>
                  <td><b>Female</br><small style="color:grey;">Pregnant</small></b></td>
                  <td><b>Male</b></td>
                  <td><b>Female</br><small style="color:grey;">Non-Pregnant</small></b></td>
                  <td><b>Female</br><small style="color:grey;">Pregnant</small></b></td>
                </tr>
                <tr>
                  <td>Adult </br><div style = "color:grey"> with BP < 140/90 mmHg </div> </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Adult</br><div style = "color:grey">with BP >/= 140/90 but less than 180/120mmHg</div></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Adult </br><div style = "color:grey"> with BP > 180/120 mmHg </div> </td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>History of diagnosis of Hypertension</small></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Intake of Hypertension Medicine</small></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
@stop
