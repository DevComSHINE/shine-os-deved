<div class="box box-primary"><!--Consultations-->
    <div class="box-header">
        <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button>
        </div>
        <i class="fa fa-stethoscope"></i><h3 class="box-title text-shine-blue boxTitle">Visit Queue</h3>
    </div><!-- /.box-header -->

    <div class="box-body no-padding">
        <?php //dd(date('Y-m-d 00:00:00'), $visit_list); ?>
            <table id="visitlisting" class="table table-condensed">
                <thead>
                    <tr><td colspan="4"><h4 class="boxTitle">Consultations Today - {{ date("F d, Y") }}</h4></td></tr>
                    <tr>
                        <th>Visit Date</th>
                        <th>Patient</th>
                        <th>Healthcare Service</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($visit_list) > 0)
                        <?php //dd($visit_list); ?>
                        @foreach($visit_list as $key => $value)
                            @if($value->sent_status == 'SENT' OR $value->sent_status == NULL)
                                @if(isset($value->appointment_datetime))
                                <tr class="row-clicker" onclick="location.href='{{ url('healthcareservices/add/'.$value->patient_id.'/'.$value->healthcareservice_id) }}'">
                                @else
                                <tr class="row-clicker" onclick="location.href='{{ url('healthcareservices/edit/'.$value->patient_id.'/'.$value->healthcareservice_id) }}'">
                                @endif
                                    @if(isset($value->appointment_datetime))
                                    <td><span class="fa fa-calendar-check-o text-danger"></span> {{ date('h:i A', strtotime($value->visit_date)) }}</td>
                                    @else
                                    <td><span class="fa fa-blind text-danger"></span> {{ date('h:i A', strtotime($value->visit_date)) }}</td>
                                    @endif
                                    <td>{{ $value->last_name }}, {{ $value->first_name }}</td>
                                    <td>{{ $value->healthcareservicetype_id }}</td>
                                </tr>
                            @endif
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
                beforeSend: function( xhr ) {
                    if(label != 'Today') {
                        $('h4.boxTitle').text("Retrieving records from "+label);
                    } else {
                        $('h4.boxTitle').text("Retrieving records for Today - "+start.format('MMM DD, YYYY'));
                    }
                    $('#visitlisting tbody').html("<tr><td colspan='4'><i class='fa fa-spinner fa-pulse fa-fw'></i> Loading queue. Please wait...</td></tr>");
                }
            })
            .done(function( msg ) {
                if(msg == "<tr><td colspan=4'>No Consultations</td></tr>") {
                    msg = "<tr><td colspan='4'>No consultations for dates you choose.</td></tr>";
                }

                //alert( msg );
                $('#visitlisting tbody').removeClass('provider_lister_box_loading');
                if(label != 'Today') {
                    $('h4.boxTitle').text("Consultations from "+label);
                } else {
                    $('h4.boxTitle').text("Consultations Today - "+start.format('MMM DD, YYYY'));
                }
                $('#visitlisting tbody').html(msg);

            });
    });
});
</script>
