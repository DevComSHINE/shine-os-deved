<?php
    //get the prefix of the page to set the nav to active
    $route = Route::current();
    $pagename = $route->getPrefix();
    $facilityInfo = Shine\Libraries\FacilityHelper::facilityInfo();
?>
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <div class="user-panel">
    <div class="pull-left image">
        <?php
            $userPhoto = $facilityInfo->facility_logo;
        ?>
        @if ( $userPhoto != '' )
            <img src="{{ url( 'public/uploads/profile_picture/'.$userPhoto ) }}" class="profile-img img-circle" />
        @else
            <img src="{{ asset( 'public/dist/img/no_logo.png' ) }}" class="profile-img img-circle" />
        @endif
    </div>
    <div class="pull-left info">
      <p>
        <a href="{{ url('/facilities')}}">
            {{ $facilityInfo->facility_name }}
        </a>
      </p>
    </div>
  </div>

  <ul class="sidebar-menu">
    <li class="divider-bottom @if($pagename == 'dashboard') active @endif">
      <a href="{{ url('/')}}" class="{{ Request::is('/') ? 'active' : '' }}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>
    <!-- Edited by RJBS -->
    @if (Session::get('roles'))
      <?php
          $modules = Session::get('roles');
      ?>

      <!-- start Core modules -->
      <?php $topmods = $modules['modules'];
      sortby('order', $topmods); ?>

      @foreach($topmods as $k => $v)
        @if( $v['name'] != 'dashboard' AND $v['icon'] != NULL AND $v['status'] == '1' AND $v['order'] < 10 )
          <li class="@if($pagename == $v['name']) active @endif">
            <a href="{{ url( '/', $v['name'] )}}" class="{{ Request::is('*'.$v['name']) ? 'active' : '' }}">
              <i class="fa {{ $v['icon'] }}"></i> <span>{{ ucfirst($v['name']) }}</span>
            </a>
          </li>
        @endif
      @endforeach

      <!-- active 3rd party modules -->
      <?php $cnt = 0; $totalc = 0; ?>
      @if(isset($modules['external_modules']))
        <?php $totalc = count($modules['external_modules']); ?>
        @foreach($modules['external_modules'] as $val)
          <?php $cnt++; ?>
          <?php
            $key = strtolower($val);
            $c = Config::get($key.'.icon');
            $name = Config::get($key.'.name');
            $roles = Config::get($key.'.roles');
            if( (in_array($modules['role_name'], json_decode($roles))) OR  $modules['role_name'] == "Developer") {
          ?>
              <li class="@if($pagename == $name)) active @endif @if($cnt == 1) divider-top @endif @if($cnt == $totalc) divider-bottom @endif">
                <a href="{{ url('/', $key)}}" class="{{ Request::is('*'.$v['name']) ? 'active' : '' }}">
                  <i class="fa {{ $c }}"></i> <span>{{ ucfirst($name) }}</span>
                </a>
              </li>
          <?php } $name = NULL; ?>
        @endforeach
      @endif

      <!-- start Utility modules -->
      <?php $lcnt = 1; ?>
      @foreach($topmods as $k => $v)
        @if( $v['name'] != 'dashboard' AND $v['icon'] != NULL AND $v['status'] == '1' AND $v['order'] >= '10000' )
          <li class="@if($pagename == $v['name']) active @endif @if($lcnt == 1) divider-top @endif">
            <a href="{{ url( '/', $v['name'] )}}" class="{{ Request::is('*'.$v['name']) ? 'active' : '' }}">
              <i class="fa {{ $v['icon'] }}"></i> <span>{{ ucfirst($v['name']) }}</span>
            </a>
          </li>
          <?php $lcnt++; ?>
        @endif
      @endforeach

    @endif
    <!-- end RJBS edit -->
  </ul>
</section>
<!-- /.sidebar -->
