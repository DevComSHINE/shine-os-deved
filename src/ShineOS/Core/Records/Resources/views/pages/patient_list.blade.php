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
                <th class="forhide">Family Folder</th>
                <th class="nosort forhide">Barangay</th>
                <th class="nosort">&nbsp;</th>
            </tr>
            </thead>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

@section('scripts')

    <div class="modal fade" id="deathInfoModal" tabindex="-1" role="dialog" aria-labelledby="deathInfoModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myInfoModalLabel"> Healthcare Record Preview </h4>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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
            ],
            "order": [[ 0, "desc" ]],
            dom: "<'row'<'col-sm-5'l><'col-sm-5 row'f><'col-sm-2'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    text: '<i class="fa fa-search"></i> | Advanced Search',
                    action: function ( e, dt, node, config ) {
                        location="{{ url('records/search') }}";
                    },
                    className: 'btn btn-sm btn-warning btn-block'
                }
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
            "order": [[ 5, "desc" ]],
            dom: "<'row'<'col-sm-5'l><'col-sm-5 row'f><'col-sm-2'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    text: '<i class="fa fa-search"></i> | Advanced Search',
                    action: function ( e, dt, node, config ) {
                        location="{{ url('records/search') }}";
                    },
                    className: 'btn btn-sm btn-warning btn-block'
                }
            ]
          });

        $("#deathInfoModal").on("show.bs.modal", function(e) {
            $(this).find(".modal-content").html("");
            var link = $(e.relatedTarget);
            $(this).find(".modal-content").load(link.attr("href"));
        });

    </script>
@stop
