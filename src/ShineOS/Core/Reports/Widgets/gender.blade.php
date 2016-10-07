<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Patients by Gender</h3>
    </div>
    @if($total_patients_by_sex)
    <div class="box-body">
        <canvas id="patpie" height="214"></canvas>
        @foreach ($total_patients_by_sex as $sex)
          <div class="progress-group">
            <?php if ($sex->genderu == 'M' )
              {
                  $color = "bg-red";
                  $tag = "Male";
              }
              else if ($sex->genderu == 'F' )
              {
                  $color = "bg-yellow";
                  $tag = "Female";
              } else {
                  $color = "bg-blue";
                  $tag = "Unknown";
                  $sex->genderu = 'U';
              }
                $percent = ($sex->total/$patient_count)*100;
            ?>
            <span class="progress-text"><a href="{{ url('records/sex/'.$sex->genderu) }}" class="btn btn-xs bg-black white">View</a> {{ $tag }}</span>
            <span class="progress-number"><b>{{ $sex->total }}</b></span>
            <div class="progress sm">
              <div class="progress-bar {{ $color }}" style="width: {{ $percent }}%"></div>
            </div>
          </div>
        @endforeach
    </div>
    <div class="box-footer text-center">
      <a href="{{ url('/patients') }}" class="uppercase hidden">View All Patients</a>
    </div>
    @else
    <div class="box-body">
        <h4>No records yet.</h4>
    </div>
    <div class="box-footer text-center">
      <a href="{{ url('/records') }}" class="uppercase hidden">Create a record</a>
    </div>
    @endif
</div>

<!-- Chart /dashboard-page-->

<script type="text/javascript">

        var patpie = $("#patpie").get(0).getContext("2d");
        var genderChart = new Chart(patpie);
        var patpieData = [
                <?php foreach ($total_patients_by_sex as $sex) {
                      if ($sex->genderu == 'M' ) {
                          $ccolor = "#F7464A";
                          $ctag = "Male";
                      } elseif ($sex->genderu == 'F' ) {
                          $ccolor = "#FCD200";
                          $ctag = "Female";
                      } else {
                          $ccolor = "rgb(60, 141, 188)";
                          $ctag = "Unknown";
                      }
                    $cpercent = $sex->total;
                ?>
                {
                    value:<?php echo $cpercent; ?>,
                    color:"<?php echo $ccolor; ?>",
                    highlight:"<?php echo $ccolor; ?>",
                    label:"<?php echo $ctag; ?>"
                }
                <?php if($ctag != "Unknown") { ?>
                ,
                <?php } } ?>
            ];
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };

        $(function () {
            genderChart.Pie(patpieData, pieOptions);
        });
</script>
