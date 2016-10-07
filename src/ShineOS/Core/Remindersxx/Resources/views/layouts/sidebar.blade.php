<div class="col-md-3">
  <!--Hide / Show button depending on the page-->
  <!-- <a href="{{ url('/reminders/add')}}" class="btn btn-success btn-block">Create Reminder</a> -->
  <!-- <a href="{{ url('/broadcast/add')}}" class="btn btn-success btn-block margin-bottom">Create Broadcast</a> -->

  <div class="box box-solid">
    <div class="box-body no-padding">
      <ul class="nav nav-pills nav-stacked">
          <li @if(Request::path() == 'reminders')
              class="active"
              @endif>
              <a href="{{ url('/reminders')}}"><i class="fa fa-list-ol"></i> Reminders List<!-- <span class="label label-primary pull-right">12</span> --></a>
          </li>
          <li @if(Request::path() == 'broadcast')
              class="active"
              @endif>
              <a href="{{ url('/broadcast')}}"><i class="fa fa-list-ol"></i> Broadcasts List </a>
          </li>
      </ul>
    </div><!-- /.box-body -->

  </div><!-- /. box -->              
</div><!-- /.col -->