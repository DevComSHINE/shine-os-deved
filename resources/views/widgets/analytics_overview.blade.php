<div class="box box-primary"><!--Consultations-->
    <div class="box-header">
        <i class="fa fa-area-chart"></i>
        <h3 class="box-title">Analytics Overview</h3>
        <div class="box-tools pull-right hidden">
            <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body border-radius-none">
        <?php if($services) { ?>
        <h4>Top 4 Services <span class="small">last 6 months</span></h4>
        <canvas id="servicesChart" height="180"></canvas>
        <?php } else { ?>
        <h4>Not Records Yet</h4>
        <?php } ?>
    </div><!-- /.box-body -->

    <?php if($mon) { ?>
    <div class="box-footer no-border">
        <h4 class="black">Top 4 Diagnosis <span class="small">last 6 months</span></h4>
        <div class="row">
            <?php if(isset($mon[0])) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center" style="border-right: 1px solid #f4f4f4">
                <input type="text" class="knob" data-max="<?php echo $total; ?>" data-readonly="true" value="<?php echo $mon[0]->bilang; ?>" data-width="90" data-height="90" data-fgColor="#FF2E2E"/>
                <div class="knob-label"><?php echo $mon[0]->diagnosis_type ? $mon[0]->diagnosis_type : "Not given"; ?></div>
            </div><!-- ./col -->
            <?php } ?>
            <?php if(isset($mon[1])) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center" style="border-right: 1px solid #f4f4f4">
                <input type="text" class="knob" data-max="<?php echo $total; ?>" data-readonly="true" value="<?php echo $mon[1]->bilang; ?>" data-width="90" data-height="90" data-fgColor="#FFC45F"/>
                <div class="knob-label"><?php echo $mon[1]->diagnosis_type ? $mon[1]->diagnosis_type : "Not given"; ?></div>
            </div><!-- ./col -->
            <?php } ?>
            <?php if(isset($mon[2])) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center" style="border-right: 1px solid #f4f4f4">
                <input type="text" class="knob" data-max="<?php echo $total; ?>" data-readonly="true" value="<?php echo $mon[2]->bilang; ?>" data-width="90" data-height="90" data-fgColor="#00CF18"/>
                <div class="knob-label"><?php echo $mon[2]->diagnosis_type ? $mon[2]->diagnosis_type : "Not given"; ?></div>
            </div><!-- ./col -->
            <?php } ?>
            <?php if(isset($mon[3])) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center">
                <input type="text" class="knob" data-max="<?php echo $total; ?>" data-readonly="true" value="<?php echo $mon[3]->bilang; ?>" data-width="90" data-height="90" data-fgColor="#39CCCC"/>
                <div class="knob-label"><?php echo $mon[3]->diagnosis_type ? $mon[3]->diagnosis_type : "Not given"; ?></div>
            </div><!-- ./col -->
            <?php } ?>
        </div><!-- /.row -->
    </div><!-- /.box-footer -->
    <?php } ?>
</div><!--/. end consultations-->

@section('scripts')

{!! HTML::script('public/dist/plugins/knob/jquery.knob.js') !!}
{!! HTML::script('public/dist/plugins/chartjs/Chart.js') !!}

<script>
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
                            label: "<?php echo $cs; ?>",
                            fillColor: "rgba(<?php echo $colors[$bil-1]; ?>,0.5)",
                            strokeColor: "rgba(<?php echo $colors[$bil-1]; ?>,0.8)",
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
        scaleGridLineColor: "rgba(0,0,0,.05)",
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
        pointDot: true,
        //Number - Radius of each point dot in pixels
        pointDotRadius: 0,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth: 0,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius: 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke: true,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth: 2,
        //Boolean - Whether to fill the dataset with a color
        datasetFill: true,
        //String - A legend template
        legendTemplate: "<ul class='<%=name.toLowerCase()%>-legend'><% for (var i=0; i<datasets.length; i++){%><li><span style='background-color:<%=datasets[i].lineColor%>'></span><%=datasets[i].label%></li><%}%></ul>",
        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio: false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive: true,
        multiTooltipTemplate: " <%=datasetLabel%>: <%= value %>"
      };

      //Create the line chart
      servicesChart.Line(servicesChartData, servicesChartOptions);

    <?php } ?>

    <?php if($mon) { ?>
    $(".knob").knob({
            draw: function() {

            // "tron" case
            if (this.$.data('skin') == 'tron') {

                var a = this.angle(this.cv)  // Angle
                        , sa = this.startAngle          // Previous start angle
                        , sat = this.startAngle         // Start angle
                        , ea                            // Previous end angle
                        , eat = sat + a                 // End angle
                        , r = true;

                this.g.lineWidth = this.lineWidth;

                this.o.cursor
                        && (sat = eat - 0.3)
                        && (eat = eat + 0.3);

                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.value);
                    this.o.cursor
                            && (sa = ea - 0.3)
                            && (ea = ea + 0.3);
                    this.g.beginPath();
                    this.g.strokeStyle = this.previousColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
    });
    <?php } ?>
</script>
@stop
