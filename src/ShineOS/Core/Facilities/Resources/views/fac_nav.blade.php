<?php
    $facilityInfo = Shine\Libraries\FacilityHelper::facilityInfo();
?>
<div class="profile col-md-3">
    <div class="box box-solid">
        <div class="box-header with-border text-center">

            <a href="{{ url('facilities/changelogo/'.$facilityInfo->facility_id) }}" title="Click to change Profile Pic">
                @if ( $facilityInfo->facility_logo != NULL OR $facilityInfo->facility_logo != '' )
                    <img src="{{ url('public/uploads/profile_picture/'.$facilityInfo->facility_logo) }}" class="profile-img img-circle" />
                @else
                    <img src="{{ asset('public/dist/img/no_logo.png') }}" class="profile-img img-circle" alt="User Image" />
                @endif
            </a>
            <h5><strong>Member Since:</strong><br /> {{ $userInfo->created_at }}</h5>
            
            <div class="alert @if($profile_completeness['percent']==100) alert-success @else alert-warning @endif" role="alert">
                <h4>{{ $profile_completeness['percent'] }}% complete</h4>
            </div>
        </div>
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked text-center">
                <li><a href="{{ url('/users/'.$userInfo->user_id) }}">Profile</a></li>
                <li><a href="{{ url('/facilities/') }}">Facility</a></li>
                <li><a href="{{ url('/users/audittrail/'.$userInfo->user_id) }}">Audit Trail</a></li>
            </ul>
        </div><!-- /.box-body -->
    </div><!-- /. box -->

</div>
