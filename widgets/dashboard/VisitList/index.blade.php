<div class="box box-primary"><!--Consultations-->
    <div class="box-header">
        <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
        </div>
        <i class="fa fa-stethoscope"></i><h3 class="box-title text-shine-blue boxTitle">Consultations Today - {{ date("F d, Y") }}</h3>
    </div><!-- /.box-header -->

    <div class="box-body no-padding">
        <?php //dd(date('Y-m-d 00:00:00'), $visit_list); ?>
            <table id="visitlisting" class="table table-condensed">
                <thead>
                    <tr>
                        <th>Visit Date</th>
                        <th>Patient</th>
                        <th>Seen by</th>
                        <th>Healthcare Service</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($visit_list) > 0)

                        <?php //dd($visit_list); ?>
                        @foreach($visit_list as $key => $value)
                            <tr class="row-clicker" onclick="location.href='{{ url('healthcareservices/edit/'.$value->patient_id.'/'.$value->healthcareservice_id) }}'">
                                <td>{{ date('m/d/Y', strtotime($value->encounter_datetime)) }}</td>
                                <td>{{ $value->last_name }}, {{ $value->first_name }}</td>
                                <td>@if($value->seen_by) {{ $value->seen_by->first_name }} {{ $value->seen_by->last_name }} @endif</td>
                                <td>{{ $value->healthcareservicetype_id }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>No consultations found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if(!empty($visit_list))
            <div class="box-footer text-center">
                <a href="{{ url('/records#visit_list') }}" class="uppercase">View All Visits</a>
            </div><!--/.box-footer-->
            @endif
    </div><!-- /.box-body -->

</div><!--/. end consultations-->

<script>
$(document).ready(function() {
    $('.daterange').daterangepicker(
        {
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            startDate: moment(),
            endDate: moment()
        },
        function(start, end, label) {
            $.ajax({
                type: "GET",
                url: "{{ url('healthcareservices/getVisits') }}/"+start.format('YYYY-MM-DD')+"/"+end.format('YYYY-MM-DD'),
            })
                .done(function( msg ) {
                    if(msg == "None") {
                        msg = "No consultations for dates you choose.";
                    }
                    $('#visitlisting tbody').html("");
                    $('h3.boxTitle').text("");
                    $('#visitlisting tbody').addClass('provider_lister_box_loading');
                    //alert( msg );
                    $('#visitlisting tbody').removeClass('provider_lister_box_loading');
                    $('h3.boxTitle').text("Consultations "+label);
                    $('#visitlisting tbody').html(msg);

                });
    });
});
</script>
