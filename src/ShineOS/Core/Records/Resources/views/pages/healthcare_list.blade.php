@section('heads')
    <style>
        table#dataTable_healthcare th { vertical-align: bottom; }
        table#dataTable_healthcare td { vertical-align: top; }
    </style>
@stop

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
                <th>AttendedBy</th>
                <th>EncounterDate</th>
                <th class="nosort">&nbsp;</th>
            </tr>
            </thead>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->
