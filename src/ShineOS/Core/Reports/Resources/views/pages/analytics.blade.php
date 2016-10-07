<!-- Info boxes -->
<div class="row">
    <div class="col-md-12">
        {!! AsyncWidget::run('\ShineOS\Core\Reports\Widgets\diagnosisWidget') !!}
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        {!! AsyncWidget::run('\ShineOS\Core\Reports\Widgets\genderWidget') !!}
    </div>
    <div class="col-md-4">
        {!! AsyncWidget::run('\ShineOS\Core\Reports\Widgets\ageWidget') !!}
    </div>
    <div class="col-md-4">
        Patients by Gender
    </div>
</div>
<div class="row">
  <div class="col-md-12">
    {!! AsyncWidget::run('\ShineOS\Core\Reports\Widgets\recapWidget') !!}
  </div><!-- /.col -->
</div>
