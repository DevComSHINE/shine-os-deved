@extends('layout.master')

@section('page-header')
  <section class="content-header">
    <h1>
      <i class="fa fa-pie-chart"></i>
      Reports: Analytics
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Analytics</li>
    </ol>
  </section>
@stop

@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-4">
            <!-- USERS LIST -->
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Patients by Sex</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <canvas id="patpie" height="150"></canvas>
                  @foreach ($total_patients_by_sex as $sex)
                  <div class="progress-group">
                    <?php if ($sex->gender == 'M' )
                      {
                          $color = "bg-red";
                          $tag = "Male";
                      } else if ($sex->gender == 'F' )
                      {
                          $color = "bg-yellow";
                          $tag = "Female";
                      } else {
                          $color = "bg-blue";
                          $tag = "Unknown";
                      }
                        $percent = ($sex->total/$patient_count)*100;
                    ?>
                    <span class="progress-text"><a href="{{ url('records/sex/'.$sex->gender) }}" class="btn btn-xs bg-black white">View</a> {{ $tag }}</span>
                    <span class="progress-number"><b>{{ $sex->total }}</span>
                    <div class="progress sm">
                      <div class="progress-bar {{ $color }}" style="width: {{ $percent }}%"></div>
                    </div>
                  </div>
                @endforeach
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="{{ url('/patients') }}" class="uppercase hidden">View All Patients</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!--/.box -->
        </div>

        <div class="col-md-4">
            <!-- USERS LIST -->
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Patients by Age</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                @if($count_by_age)
                  @foreach ($count_by_age as $ages)
                  <?php
                      switch($ages->age_range){
                        case "A": $color = "progress-bar-default"; $label = "Under 10"; $para = "0-10"; break;
                        case "B": $color = "progress-bar-info"; $label = "10 - 24"; $para = "10-24"; break;
                        case "C": $color = "progress-bar-primary"; $label = "25 - 39"; $para = "25-39"; break;
                        case "D": $color = "progress-bar-success"; $label = "40 - 59"; $para = "40-59"; break;
                        case "E": $color = "progress-bar-warning"; $label = "60 - 79"; $para = "60-79"; break;
                        case "F": $color = "progress-bar-danger"; $label = "Over 80"; $para = "80-200"; break;
                      }
                    ?>
                  <div class="progress-group">
                    <span class="progress-text"><a href="{{ url('records/agerange/'.$para) }}" class="btn btn-xs bg-black white">View</a> {{ $label }} years old</span>
                    <span class="progress-number"><b>{{ $ages->count }}</b>/{{ $patient_count }}</span>
                    <div class="progress sm">
                      @if($patient_count > 1)
                      <div class="progress-bar {{ $color }}" style="width: {{ ($ages->count/$patient_count)*100 }}%"></div>
                      @endif
                    </div>
                  </div>
                @endforeach
                @endif
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="{{ url('/patients') }}" class="uppercase hidden">View All Patients</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!--/.box -->
        </div>

        <div class="col-md-4">
            <!-- USERS LIST -->
            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">New Patients</h3>
                  <div class="box-tools pull-right">
                    <?php
                      $patt = "Patient";
                      if($patient_count > 1) {
                          $patt = "Patients";
                      }
                    ?>
                    <span class="label label-danger">{{ $patient_count }} New {{ $patt }}</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  @if($latest_patients)
                    @foreach ($latest_patients as $patients)
                        <li>
                          <span class="img_circle">
                          @if($patients->photo_url != "")
                          <img src="{{ uploads_url().'patients/'.$patients->photo_url }}" alt="User Image">
                          @else
                          <img src="{{ asset('public/dist/img/noimage_male.png') }}" alt="User Image">
                          @endif
                          </span>
                          <a class="users-list-name" href="{{ url('/patients', [$patients->patient_id]) }}">{{ $patients->last_name }}, {{ $patients->first_name }}</a>
                          <span class="users-list-date">{{ date("M-d-y", strtotime($patients->created_at)) }}</span>

                        </li>
                    @endforeach
                  @endif
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="{{ url('/patients') }}" class="uppercase">View All Patients</a>
                </div>
                <!-- /.box-footer -->
            </div>
            <!--/.box -->
        </div>
    </div>
    {!! csrf_field() !!}
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Facility Recap Report</h3>
            <div class="box-tools pull-right">
              <!--<span>Filter by:</span>
              <select class="btn" id="filterBy">
                <option value="age">Age</option>
                <option value="visits">Visits</option>
              </select>-->
              <button class="btn btn-primary btn-sm rangeonly-daterange hidden" data-toggle="tooltip" title="" data-original-title="Date range"><i class="fa fa-calendar"></i></button>
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-12">
                <p class="text-center">
                  <strong>Top Healthcare Services Provided : 6 months</strong>
                </p>
                <div class="chart">
                  <!-- Sales Chart Canvas -->
                  <canvas id="servicesChart" height="60"></canvas>
                </div><!-- /.chart-responsive -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- ./box-body -->

          <div class="box-footer">
            <div class="row">
              <div class="col-sm-4 col-xs-6">
                <div class="description-block border-right">
                  <h5 class="description-header">{{ $count_by_gender_sex }}</h5>
                  <span class="description-text">Count by sex, age, barangay</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
              <div class="col-sm-4 col-xs-6">
                <div class="description-block border-right">
                  <h5 class="description-header">{{ $count_by_services_rendered }}</h5>
                  <span class="description-text">Count by services rendered</span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
              <div class="col-sm-4 col-xs-6">
                <div class="description-block border-right">
                  <h5 class="description-header">{{ $count_by_disease }}</h5>
                  <span class="description-text">Count by disease </span>
                </div><!-- /.description-block -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="row">

    </div><!-- /.row -->
@stop

@section('scripts')
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script src="{{ asset('public/dist/plugins/chain/jquery.chained.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/dist/plugins/chain/jquery.chained.remote.min.js') }}" type="text/javascript"></script>

     <!-- Morris.js charts -->
    <script src="{{ asset('public/dist/plugins/morris/raphael-min.js') }}"></script>
    <script src="{{ asset('public/dist/plugins/morris/morris.min.js') }}" type="text/javascript"></script>

    <!-- DATA TABES SCRIPT -->
    <script src="{{ asset('public/dist/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/dist/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="{{ asset('public/dist/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="{{ asset('public/dist/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/dist/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('public/dist/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('public/dist/plugins/daterangepicker/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/dist/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="{{ asset('public/dist/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('public/dist/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>

    <!-- Chart /dashboard-page-->
    <script src="{{ asset('public/dist/plugins/chartjs/Chart.min.js') }}" type="text/javascript"></script>
     <!-- /dashboard-page  -->
    <script src="{{ asset('public/dist/js/pages/dashboard.js') }}" type="text/javascript"></script>
    <!-- Bootstrap Switch JS -->
    <script src="{{ asset('public/dist/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <!-- fullCalendar 2.2.5-->
    <script src="{{ asset('public/dist/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

    <script>
        var patpie_data = [
            @foreach ($total_patients_by_sex as $sex)
            <?php
                if ($sex->gender == 'M' )
                  {
                      $ccolor = "#F7464A";
                      $ctag = "Male";
                  } elseif ($sex->gender == 'F' )
                  {
                      $ccolor = "#FCD200";
                      $ctag = "Female";
                  } else {
                      $ccolor = "rgb(60, 141, 188)";
                      $ctag = "Unknown";
                  }
                $cpercent = $sex->total;
            ?>
            {
                value: {{ $cpercent }},
                color:"{{ $ccolor }}",
                highlight: "{{ $ccolor }}",
                label: "{{ $ctag }}"
            },
            @endforeach
        ]

        var patpie = document.getElementById("patpie").getContext("2d");
        var myDoughnutChart = new Chart(patpie).Doughnut(patpie_data, {
            animateRotate : false,
            segmentShowStroke : false
        });

        <?php
    if($services) { ?>
      // Get context with jQuery - using jQuery's .get() method.
      var servicesChartCanvas = $("#servicesChart").get(0).getContext("2d");
      // This will get the first returned node in the jQuery collection.
      var servicesChart = new Chart(servicesChartCanvas);

      var servicesChartData = {
        labels: [
            <?php
                foreach($ranges as $range) {
                    $dd = date("M/y", strtotime($range));
                    echo "'".$dd."', ";
                }
            ?>
        ],
        datasets: [
        <?php
            $colors = array('255,0,0','255,172,0','195,255,0','0,255,255','206,220,0','0,129,198');
            $bil = 1;

            if (!empty($cs_stats)):
            foreach($cs_stats as $cs=>$range) { ?>
                    <?php if($bil < 5) { ?>
                    {
                    label: "{{ $cs }}",
                    fillColor: "rgba(<?php echo $colors[$bil-1]; ?>,0.5)",
                    strokeColor: "rgba(<?php echo $colors[$bil-1]; ?>,0)",
                    pointColor: "rgba(<?php echo $colors[$bil-1]; ?>,1)",
                    pointStrokeColor: "rgba(<?php echo $colors[$bil-1]; ?>,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(<?php echo $colors[$bil-1]; ?>,1)",
                    data: [
                        <?php foreach($range as $s=>$bilang) {
                                echo $bilang.", ";
                        } ?>
                    ]
                    },
                    <?php $bil++; } ?>
          <?php
            }
             endif; ?>
        ]
      };

      var servicesChartOptions = {
        //Boolean - If we should show the scale at all
        showScale: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.1)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - Whether the line is curved between points
        bezierCurve: true,
        //Number - Tension of the bezier curve between points
        bezierCurveTension: 0.4,
        //Boolean - Whether to show a dot for each point
        pointDot: false,
        //Number - Radius of each point dot in pixels
        pointDotRadius: 0,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth: 0,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius: 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke: false,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth: 0,
        //Boolean - Whether to fill the dataset with a color
        datasetFill: true,
        //String - A legend template
        legendTemplate: "<ul class='<%=name.toLowerCase()%>-legend'><% for (var i=0; i<datasets.length; i++){%><li><span style='background-color:<%=datasets[i].lineColor%>'></span><%=datasets[i].label%></li><%}%></ul>",
        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: true,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        multiTooltipTemplate: " <%=datasetLabel%>: <%= value %>"
      };

      //Create the line chart
      servicesChart.Line(servicesChartData, servicesChartOptions);

      $("#servicesChart").css('width', '100%');

    <?php } ?>
    </script>
@stop
