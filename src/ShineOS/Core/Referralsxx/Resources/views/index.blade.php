@extends('referrals::layouts.master')

@section('referral-content')
<div class="col-md-9">
  <div class="box box-primary">
    @if(Session::has('message'))
      <div class="box-header with-border">
        <!-- <h3 class="box-title">Inbound</h3>
        <div class="box-tools pull-right">

        </div> --> <!-- /.box-tools -->

        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>

      </div><!-- /.box-header -->
    @endif

    <div class="box-body no-padding">

      <div class="table-responsive mailbox-messages">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <!-- <th> </th> -->
              <th> Status </th>
              <th>
                  @if (Request::path() == 'referrals/inbound')
                    Referrer
                  @endif
                  @if (Request::path() == 'referrals')
                    Referrer
                  @endif
                  @if (Request::path() == 'referrals/outbound')
                    Referred To
                  @endif
                  @if (Request::path() == 'referrals/drafts')
                    Referred To
                  @endif
              </th>
              <th> Health Care Service </th>
              <th> Patient Name </th>
              <th> Date Referred </th>
            </tr>
          </thead>
          <tbody>
          @if($referrals)
            @foreach($referrals as $k => $v)
              <tr>
                <!-- <td><h5><input type="checkbox" /></h5></td> -->
                <td>
                  @if ($v->referral_status == 1)
                    <h5><span class="label label-warning">
                    @if (Request::path() == 'referrals/inbound') <!-- if referrer = Sent; if referred to = Pending -->
                      Pending
                    @endif
                    @if (Request::path() == 'referrals') <!-- if referrer = Sent; if referred to = Pending -->
                      Pending
                    @endif
                    @if (Request::path() == 'referrals/outbound') <!-- if referrer = Sent; if referred to = Pending -->
                      Sent
                    @endif
                    </span></h5>
                  @elseif ($v->referral_status == 2)
                    <h5><span class="label label-danger"> Declined </span></h5>
                  @elseif ($v->referral_status == 3)
                    <h5><span class="label label-success"> Accepted </span></h5>
                  @elseif ($v->referral_status == 4)
                    <h5><span class="label label-danger"> Closed </span></h5>
                  @elseif ($v->referral_status == 5)
                    <h5><span class="label label-danger"> Cancelled </span></h5>
                  @elseif ($v->referral_status == 6)
                    <h5><span class="label label-warning"> Draft </span></h5>
                  @else
                    <h5></h5>
                  @endif
                </td>
                <td>
                  <a href="{{ url('/referrals').'/'.$v->type.'/'.$v->referral_id }}">
                  @if ((Request::path() == 'referrals/inbound' || Request::path() == 'referrals') AND isset($v->referrer->facility_name)) <!-- if referrer = Sent; if referred to = Pending -->
                    <h5>  {{ $v->referrer->facility_name}} </h5>
                  @endif
                  @if ((Request::path() == 'referrals/outbound' || Request::path() == 'referrals/drafts') AND isset($v->referredTo->facility_name)) <!-- if referrer = Sent; if referred to = Pending -->
                    <h5>  {{ $v->referredTo->facility_name}} </h5>
                  @endif
                  </a>
                </td>
                <td> <h5> {{ $v->healthcare_servicetype_name }} </h5> </td>
                <td> <h5> {{ $v->patient_firstname}}
                          {{ $v->patient_middlename}}
                          {{ $v->patient_lastname}} </h5> </td>
                <td> <h5> {{ $v->created_at}} </h5> </td>
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
