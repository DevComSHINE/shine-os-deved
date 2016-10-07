<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Patients by Age</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    @if($count_by_age)
      @foreach ($count_by_age as $ages)
      <?php
          switch($ages->age_range){
            case "A": $color = "progress-bar-default"; $label = "Under 10 years old"; $para = "0-10"; break;
            case "B": $color = "progress-bar-info"; $label = "10 - 24 years old"; $para = "10-24"; break;
            case "C": $color = "progress-bar-primary"; $label = "25 - 39 years old"; $para = "25-39"; break;
            case "D": $color = "progress-bar-success"; $label = "40 - 59 years old"; $para = "40-59"; break;
            case "E": $color = "progress-bar-warning"; $label = "60 - 79 years old"; $para = "60-79"; break;
            case "F": $color = "progress-bar-danger"; $label = "Over 80 years old"; $para = "80-200"; break;
            case "G": $color = "progress-striped progress-bar-danger"; $label = "Unknown"; $para = "NA"; break;
          }
        ?>
      <div class="progress-group">
        <span class="progress-text"><a href="{{ url('records/agerange/'.$para) }}" class="btn btn-xs bg-black white">View</a> {{ $label }}</span>
        <span class="progress-number"><b>{{ $ages->count }}</b>/{{ $patient_count }}</span>
        <div class="progress sm">
          @if($patient_count > 1)
          <div class="progress-bar {{ $color }}" style="width: {{ ($ages->count/$patient_count)*100 }}%"></div>
          @endif
        </div>
      </div>
    @endforeach
    @else
      <h4>No records yet.</h4>
    @endif
      <!-- /.users-list -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer text-center">
      <a href="{{ url('/patients') }}" class="uppercase hidden">View All Patients</a>
    </div>
    <!-- /.box-footer -->
</div>
