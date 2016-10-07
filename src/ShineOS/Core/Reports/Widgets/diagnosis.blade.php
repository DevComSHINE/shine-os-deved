
<div class="box box-primary">
    <?php
        $color = array();
        if($diagnosis) {
            $color[0] = '#FF2E2E';
            $color[1] = '#FFC45F';
            $color[2] = '#00CF18';
            $color[3] = '#39CCCC';
            $color[4] = '#b93bdc';
            $color[5] = '#59b846';
        ?>
        <div class="box-header with-border">
            <h3 class="box-title">Top 6 Diagnosis <span class="small">last 6 months</span></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-primary btn-sm rangeonly-daterange hidden" data-toggle="tooltip" title="" data-original-title="Date range"><i class="fa fa-calendar"></i></button>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                @foreach($diagnosis as $k=>$m)
                <?php if(isset($m)) { ?>
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 text-center" style="border-right: 1px solid #f4f4f4">
                    <input type="text" class="knob" data-max="<?php echo $total; ?>" data-readonly="true" value="<?php echo $m->bilang; ?>" data-width="90" data-height="90" data-fgColor="{{ $color[$k] }}"/>
                    <div class="knob-label"><?php echo $m->diagnosislist_id ? $m->diagnosislist_id : "Not given"; ?></div>
                </div><!-- ./col -->
                <?php } ?>
                @endforeach

            </div><!-- /.row -->
        </div><!-- /.box-footer -->
    <?php } else { ?>
        <div class="box-header with-border">

        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <h4>No records yet.</h4>
            </div><!-- /.row -->
        </div><!-- /.box-footer -->
    <?php } ?>
</div>

<script src="{{ asset('public/dist/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>
<script type="text/javascript">
<?php if($diagnosis) { ?>
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
