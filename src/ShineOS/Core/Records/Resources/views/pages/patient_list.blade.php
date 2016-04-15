<div class="box no-border">
    @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-warning alert-dismissible') }}">{{ Session::get('message') }}</p>
    @endif

    <div class="box-body table-responsive no-padding overflowx-hidden">
        <table class="table table-hover" id="dataTable_patients">
            <thead>
            <tr>
                <th class="nosort">&nbsp;</th>
                <th>Patient Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Birthdate</th>
                <th>Family Folder</th>
                <th>Barangay</th>
                <th class="nosort" width="247">&nbsp;</th>
            </tr>
            </thead>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

@section('scripts')
    @include('patients::pages.forms.modal_death')

    <script>
          var T1 = $('table#dataTable_patients').DataTable({
            "Paginate": true,
            "LengthChange": true,
            "Filter": true,
            "Sort": true,
            "Info": true,
            "AutoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('records/getpatients') }}",
                "type": "POST",
                "headers": {'X-CSRF-Token': $('meta[name="_token"]').attr('content')}
            },
            "columns": [
                { "data": "pid" },
                { "data": "name" },
                { "data": "gender" },
                { "data": "age" },
                { "data": "birthdate" },
                { "data": "family_folder_name" },
                { "data": "barangay" },
                { "data": "action" }
            ],
            "columnDefs": [
                { "orderable": false, "targets": 'nosort' }
            ]
          });

          var T2 = $('table#dataTable_healthcare').DataTable({
            "Paginate": true,
            "LengthChange": true,
            "Filter": true,
            "Sort": true,
            "Info": true,
            "AutoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('records/gethealthcare') }}",
                "type": "POST",
                "headers": {'X-CSRF-Token': $('meta[name="_token"]').attr('content')}
            },
            "columns": [
                { "data": "pid" },
                { "data": "name" },
                { "data": "service_type" },
                { "data": "encounter_type" },
                { "data": "seen_by" },
                { "data": "encounter_datetime" },
                { "data": "action" }
            ],
            "columnDefs": [
                { "orderable": false, "targets": 'nosort' }
            ],
            "order": [[ 5, "desc" ]]
          });
    </script>
@stop
