
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Facility Data Report</h3>
        <div class="box-tools pull-right">
          <button class="btn btn-primary btn-sm rangeonly-daterange hidden" data-toggle="tooltip" title="" data-original-title="Date range"><i class="fa fa-calendar"></i></button>
        </div>
      </div><!-- /.box-header -->
      @if($services)
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
              <h5 class="description-header">{{ $patient_count }}</h5>
              <span class="description-text">Total patients served</span>
            </div><!-- /.description-block -->
          </div><!-- /.col -->
          <div class="col-sm-4 col-xs-6">
            <div class="description-block border-right">
              <h5 class="description-header">{{ count($count_by_services_rendered) }}</h5>
              <span class="description-text">Total services rendered</span>
            </div><!-- /.description-block -->
          </div><!-- /.col -->
          <div class="col-sm-4 col-xs-6">
            <div class="description-block border-right">
              <h5 class="description-header">{{ count($count_by_disease) }}</h5>
              <span class="description-text">Total number of diseases recorded</span>
            </div><!-- /.description-block -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.box-footer -->
      @else
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <h4>No records yet.</h4>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- ./box-body -->
      @endif
</div>

<!-- Chart /dashboard-page-->
<script type="text/javascript">
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
            $colors = array('255,0,0','255,172,0','195,255,0','0,255,255','206,220,0','0,129,198','0,159,298','0,229,100','110,19,198','200,129,198');
            $bil = 1;

            if (!empty($cs_stats)):
                foreach($cs_stats as $cs=>$range) { ?>
                    <?php if($bil < $scount) { ?>
                    {
                    label: "{{ $cs }}",
                    fillColor: "rgba(<?php echo $colors[$bil-1]; ?>,0.35)",
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

    $(function () {
      //Create the line chart
      servicesChart.Line(servicesChartData, servicesChartOptions);
      $("#servicesChart").css('width', '100%');
    });

    <?php } ?>
</script>
