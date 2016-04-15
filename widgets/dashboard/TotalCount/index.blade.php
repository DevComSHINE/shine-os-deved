<div class="box box-primary" id="content_overview">
    <div class="box-header ui-sortable-handle">
        <i class="fa fa-eye"></i>
        <h3 class="box-title text-shine-blue">At a glance</h3>
    </div><!-- /.box-header -->

    <div class="box-body">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <?php

                if( strlen($dashboard_count['patient']) >= 5 )
                {
                    $class = "class='col-lg-12 col-md-12 col-sm-12 col-xs-12 wide'";
                }
                elseif( strlen($dashboard_count['patient']) == 4 )
                {
                    $class = "class='col-lg-6 col-md-6 col-sm-6 col-xs-12 narrow'";
                }
                else
                {
                    $class = "class='col-lg-6 col-md-6 col-sm-6 col-xs-12'";
                }
            ?>
            <div <?php echo $class; ?>>
                <!-- small box -->
                <div class="overview-box small-box bg-smartred">
                    <a href="{{ url('/records')}}" class="ajax-link">
                        <div class="inner">
                            <div class="icon"><i class="ion ion-ios-people"></i></div>
                            <h3>{{ $dashboard_count['patient'] }}</h3>
                            <p>Patient Record/s</p>
                        </div>

                    </a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="overview-box small-box bg-smartolive">
                    <a href="{{ url('/referrals/inbound')}}" class="ajax-link">
                    <div class="inner">
                        <h3>{{ $dashboard_count['inbound'] }}</h3>
                        <p>Inbound Referrals</p>
                    </div>
                    <div class="icon"><i class="ion ion-ios-download"></i></div>
                    </a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="overview-box small-box bg-smartlitblue">
                    <a href="{{ url('/referrals/outbound')}}" class="ajax-link">
                    <div class="inner">
                        <h3>{{ $dashboard_count['outbound'] }}</h3>
                        <p>Outbound Referrals</p>
                    </div>
                    <div class="icon"><i class="ion ion-ios-upload"></i></div>
                    </a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="overview-box small-box bg-yellow">
                    <a href="{{ url('/referrals')}}" class="ajax-link">
                    <div class="inner">
                        <h3>{{ $dashboard_count['referral'] }}</h3>
                        <p>Referral Messages</p>
                    </div>
                    <div class="icon"><i class="ion ion-chatbubbles"></i></div>
                    </a>
                </div>
            </div><!-- ./col -->

            <?php if( strlen($dashboard_count['patient']) >= 5 ) { ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <!-- small box -->
                <div class="overview-box small-box bg-orange">
                    <a href="{{ url('/reminders')}}" class="ajax-link">
                    <div class="inner">
                        <h3>{{ $dashboard_count['reminders'] }}</h3>
                        <p>Reminders</p>
                    </div>
                    <div class="icon"><i class="ion ion-android-alarm-clock"></i></div>
                    </a>
                </div>
            </div><!-- ./col -->
            <?php } ?>
        </div><!-- /.row -->
    </div>
</div><!--./box-->
