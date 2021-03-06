<style>
    #servicesChart {
        height:200px !important;
        width:100% !important;
    }
</style>
<div class="box box-primary"><!--Consultations-->
    <div class="box-header">
        <i class="fa fa-area-chart"></i>
        <h3 class="box-title">Analytics Overview</h3>
        <div class="box-tools pull-right">
            <a class="btn bg-teal btn-sm" href="{{ url('reports') }}"><i class="fa fa-pie-chart"></i> View Analytics</a>
        </div>
    </div>
    <div class="box-body border-radius-none">
        <?php if($mon) {
            $color[0] = '#FF2E2E';
            $color[1] = '#FFC45F';
            $color[2] = '#00CF18';
            $color[3] = '#39CCCC';
        ?>
        <h4 class="black">Top 4 Diagnosis <span class="small">last 6 months</span></h4>
        <div class="row">
            @foreach($mon as $k=>$m)
            <?php if(isset($m)) { ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 text-center" style="border-right: 1px solid #f4f4f4">
                <input type="text" class="knob" data-max="<?php echo $total; ?>" data-readonly="true" value="<?php echo $m->bilang; ?>" data-width="90" data-height="90" data-fgColor="{{ $color[$k] }}"/>
                <div class="knob-label"><?php echo $m->diagnosislist_id ? $m->diagnosislist_id : "Not given"; ?></div>
            </div><!-- ./col -->
            <?php } ?>
            @endforeach

        </div><!-- /.row -->
        <?php } ?>

        <?php if($services) { ?>
            <h4>Top 4 Services <span class="small">last 6 months</span></h4>
            <canvas id="servicesChart"></canvas>
        <?php } else { ?>
            <h4>Not Records Yet</h4>
        <?php } ?>
    </div><!-- /.box-body -->


    <div class="box-footer no-border">

    </div><!-- /.box-footer -->

</div><!--/. end consultations-->



{!! HTML::script('public/dist/plugins/knob/jquery.knob.js') !!}
{!! HTML::script('public/dist/plugins/chartjs/Chart.js') !!}

<script>
    <?php
    if($services) { ?>

      Chart.types.Line.extend({
            name: "LineAlt",
            initialize: function () {
                Chart.types.Line.prototype.initialize.apply(this, arguments);

                var ctx = this.chart.ctx;
                var originalStroke = ctx.stroke;
                ctx.stroke = function () {
                    ctx.save();
                    ctx.shadowColor = '#000';
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = -2;
                    ctx.shadowOffsetY = -2;
                    originalStroke.apply(this, arguments)
                    ctx.restore();
                }
            }
        });
      // Get context with jQuery - using jQuery's .get() method.
      var ctx = $("#servicesChart").get(0).getContext("2d");
      // This will get the first returned node in the jQuery collection.
      var servicesChart = new Chart(ctx);

      var ctx = {
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
            $colors = array('233,28,28','255,172,0','195,255,0','0,255,255','206,220,0','255,0,234','0,129,198','0,159,298','0,229,100','200,129,198');
            $bil = 1;

            if (!empty($cs_stats)):
                foreach($cs_stats as $cs=>$range) { ?>
                        <?php if($bil < $scount) { ?>
                        {
                            label: "<?php echo $cs; ?>",
                            fillColor: "rgba(<?php echo $colors[$bil-1]; ?>,.6)",
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
      servicesChart.LineAlt(ctx, servicesChartOptions);
      $("#servicesChart").css('width', 490);
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

