@extends('referrals::layouts.master')

@section('referral-content')
<div class="col-md-9">
  <div class="box box-primary">
    <!-- <div class="box-header with-border">
      <h3 class="box-title">Outbound</h3>
      <div class="box-tools pull-right">
        
      </div> --><!-- /.box-tools -->
    <!-- </div> --><!-- /.box-header -->
    <div class="box-body no-padding">
      
      <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
          <thead>
            <tr> 
              <!-- <th> </th> -->
              <!-- <th> Id </th>  --><!-- Facility or User -->
              <th> Health Care Service </th>
              <th> Patient Name </th>
              <th> Date </th>
            </tr>
          </thead>
          <tbody>
              @if($referrals)
              @foreach($referrals as $key => $value) 
                  <tr>
                    <!-- <td><h5><input type="checkbox" /></h5></td> -->
                    <td> <a href="{{ url('/referrals/messages').'/'.$value->referral_id}}">
                          <h5> {{$value->healthcare_servicetype_name}} </h5>
                          </a>
                    </td>
                    <td> <h5>
                          {{ $value->patientsdata->first_name }}
                          {{ $value->patientsdata->middle_name }}
                          {{ $value->patientsdata->last_name }}
                    </h5> </td>
                    <td> <h5> {{ $value->created_at}} </h5> </td>
                  </tr> 
              @endforeach
              @endif
          </tbody>
        </table><!-- /.table -->
      </div><!-- /.mail-box-messages -->
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">
          <p class="pull-left"></p>
          <ul class="pagination pagination-sm no-margin pull-right">
             {!! $referrals->render() !!} 
          </ul>
    </div><!-- /.box -->
  </div><!-- /. box -->
</div><!-- /.col -->
@stop