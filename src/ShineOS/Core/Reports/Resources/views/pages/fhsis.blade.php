<div class="row">
    <div class="col-md-12">
        <h4>DOH FHSIS Reporting</h4>
        <p class="box-content-para">To generate your FHSIS Report by setting the date range you want and clicking on the Generate button.</p>
    </div>

    <div class="col-md-4">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><?php echo link_to_route('fhsis.m1', 'Program Report M1'); ?></li>
                <li><?php echo link_to_route('fhsis.m2', 'Morbidity Report M2'); ?></li>
              </ul>
            </div><!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Quarterly</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><?php echo link_to_route('fhsis.q1', 'Program Report Q1'); ?></li>
                <li><?php echo link_to_route('fhsis.q2', 'Morbidity Report Q2'); ?></li>
              </ul>
            </div><!-- /.box-body -->
        </div>
    </div>

    <div class="col-md-4">
        <div class="box box-success box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Annual</h3>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><?php echo link_to_route('fhsis.abrgy', 'Annual Brgy'); ?></li>
                <li><?php echo link_to_route('fhsis.a1', 'Program Report A1'); ?></li>
                <li><?php echo link_to_route('fhsis.a2', 'Morbidity Report A2'); ?></li>
                <li><?php echo link_to_route('fhsis.a3', 'Mortality Report A3'); ?></li>
              </ul>
            </div><!-- /.box-body -->
        </div>
    </div>
</div>
