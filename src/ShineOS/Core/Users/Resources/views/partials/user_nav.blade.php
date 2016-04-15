<div class="profile col-md-3">
    <div class="box box-solid">
        <div class="box-header with-border text-center">
            <h3 class="box-title">{{ $userInfo->first_name }} {{ $userInfo->middle_name }} {{ $userInfo->last_name }}</h3>
            <a href="{{ url('users/changeprofilepic/'.$userInfo->user_id) }}" title="Click to change Profile Pic">
                <div class="img_container">
                @if ( $userInfo->profile_picture != '' )
                    <img src="{{ url('public/uploads/profile_picture/'.$userInfo->profile_picture) }}" class="profile-img" />
                @else
                    <img src="{{ asset('public/dist/img/noimage_male.png') }}" class="profile-img" alt="User Image" />
                @endif
                </div>
            </a>
            <h5><strong>Member Since:</strong><br /> {{ $userInfo->created_at }}</h5>
            <div class="alert alert-warning" role="alert">
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

    <?php //if ($userInfo->user_id != $currentID AND $userInfo->user_type != 'Admin') { ?>
    <?php if ($userInfo->user_type != 'Admin') {?>
        @if($userInfo->status == 'Disabled' OR $userInfo->status == 'Pending')
            <a href="{{ url('/users/enable/'.$userInfo->user_id) }}" class="btn btn-success btn-block margin-bottom">Enable Account</a>
        @else
            <a href="{{ url('/users/disable/'.$userInfo->user_id) }}" class="btn btn-danger btn-block margin-bottom">Disable Account</a>
        @endif
    <?php } ?>
</div>
