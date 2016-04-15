
<div class="box no-border">
    @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-warning alert-dismissible') }}">{{ Session::get('message') }}</p>
    @endif

    <div class="box-body table-responsive no-padding overflowx-hidden">
        <table class="table table-hover" id="dataTable_healthcare">
            <thead>
            <tr>
                <th class="nosort">&nbsp;</th>
                <th nowrap>Patient Name</th>
                <th>Service</th>
                <th>Encounter</th>
                <th>Seen by</th>
                <th>Encounter Date</th>
                <th class="nosort">&nbsp;</th>
            </tr>
            </thead>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
