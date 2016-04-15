<div class="box box-primary"><!--Consultations-->
    <div class="box-header">
        <i class="fa fa-stethoscope"></i><h3 class="box-title text-shine-blue">Visits</h3>
    </div><!-- /.box-header -->

    <div class="box-body no-padding">
        @if(!empty($visit_list))
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <th>Visit Date</th>
                        <th>Patient</th>
                        <th>Seen by</th>
                        <th>Healthcare Service</th>
                    </tr>
                        <?php //dd($visit_list); ?>
                        @foreach($visit_list as $key => $value)
                            <tr class="row-clicker" onclick="location.href='{{ url('healthcareservices/edit/'.$value->patient_id.'/'.$value->healthcareservice_id) }}'">
                                <td>{{ date('M. d, Y', strtotime($value->encounter_datetime)) }}</td>
                                <td>{{ $value->last_name }}, {{ $value->first_name }}</td>
                                <td>@if($value->seen_by) Dr. {{ $value->seen_by->first_name }} {{ $value->seen_by->last_name }} @endif</td>
                                <td>{{ $value->healthcareservicetype_id }}</td>
                            </tr>
                        @endforeach

                </tbody>
            </table>
            @if(!empty($visit_list))
            <div class="box-footer text-center">
                <a href="{{ url('/records#visit_list') }}" class="uppercase">View All Visits</a>
            </div><!--/.box-footer-->
            @endif
        @else
            <div class="box-footer text-center">
                No records found
            </div><!--/.box-footer-->
        @endif

    </div><!-- /.box-body -->

</div><!--/. end consultations-->

