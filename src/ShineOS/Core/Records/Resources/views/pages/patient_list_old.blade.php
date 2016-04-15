<div class="box no-border">
    @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info alert-dismissible') }}">{{ Session::get('message') }}</p>
    @endif

    <div class="box-body table-responsive no-padding overflowx-hidden">
        <table class="table table-hover" id="dataTable_patients">
            <thead>
            <tr>
                <th>Patient Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Birthdate</th>
                <th>Family Folder</th>
                <th>Barangay</th>
                <th class="nosort" width="247">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
              @if(isset($patients))
                @foreach ($patients as $patient)
                    @if ($patient->patientDeathInfo != null)
                    <?php
                        $status = 'disabled';
                    ?>
                    @else
                    <?php
                        $status = 'active';
                    ?>
                    @endif
                    <?php
                        $dateNow = new DateTime();
                        $patientBday = new DateTime(($patient->birthdate));
                        $interval = $dateNow->diff($patientBday);
                    ?>
                    <tr>
                        <td><a href="{{ url('patients', [$patient->patient_id]) }}" class="" title="View Patient Dashboard">{{ $patient->last_name }}, {{ $patient->first_name }} {{ $patient->middle_name }}</a></td>
                        <td>{{ $patient->gender }}</td>
                        <td>{{ $interval->format('%Y years') }}</td>
                        <td>{{ dateFormat($patient->birthdate, "M. d, Y") }}</d>
                        <td>{{ $patient->last_name }}</td>
                        <td>{{ getBrgyName($patient->patientContact->barangay) }}</td>
                        <td class="nosort">
                             <div class="btn-group">
                                <div class="btn-group">
                                    <a href="#" type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown" {{ $status }}> Actions <span class="caret"></span></a>
                                    <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents">
                                      <li><a href="{{ url('healthcareservices/add', [$patient->patient_id]) }}">Add Healthcare Visit</a></li>
                                      <li role="separator" class="divider"></li>
                                      <li><a href="#" data-toggle="modal" data-id="{{ $patient->patient_id }}" data-target="#deathModal" class="red deathModal">Declare Dead</a></li>
                                    </ul>
                                </div>
                                <a href="{{ url('patients/view', [$patient->patient_id]) }}" type="button" class="btn btn-success btn-flat" title="Edit Patient" {{ $status }}><i class="fa fa-pencil"></i> Edit</a>
                                <a href="{{ route('patients.delete', [$patient->patient_id]) }}" type="button" class="btn btn-danger btn-flat" title="Delete Role"><i class="fa fa-trash-o"></i> Delete</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
              @endif
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

@section('scripts')
    @include('patients::pages.forms.modal_death')
    <script>
        $('table#dataTable_patients').DataTable({
            "Paginate": true,
            "LengthChange": true,
            "Filter": true,
            "Sort": true,
            "Info": true,
            "AutoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('records/loadpatients') }}",
                "type": "POST",
                "headers": {'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            },
            "columnDefs": [
              { "orderable": false, "targets": 'nosort' }
            ]
          });
    </script>
@stop
