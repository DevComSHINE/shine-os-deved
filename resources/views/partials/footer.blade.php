<!--Major JS Scripts -->
{!! HTML::script('public/dist/plugins/jQuery/jQuery-2.1.4.min.js') !!}
{!! HTML::script('public/dist/js/bootstrap.min.js') !!}
{!! HTML::script('public/dist/plugins/jQueryUI/jquery-ui.min.js') !!}

<!--Global JS Scripts plugins-->

{!! HTML::script('public/dist/js/app.js') !!}
{!! HTML::script('public/dist/plugins/daterangepicker/moment.min.js') !!}
{!! HTML::script('public/dist/plugins/daterangepicker/daterangepicker.js') !!}
{!! HTML::script('public/dist/plugins/timepicker/bootstrap-timepicker.min.js') !!}
{!! HTML::script('public/dist/plugins/slimScroll/jquery.slimscroll.min.js') !!}
{!! HTML::script('public/dist/plugins/iCheck/icheck.js') !!}
{!! HTML::script('public/dist/plugins/bootbox.min.js') !!}
{!! HTML::script('public/dist/js/pages/helper/helper.js') !!}
{!! HTML::script('public/dist/plugins/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('public/dist/plugins/datatables/dataTables.buttons.min.js') !!}
{!! HTML::script('public/dist/plugins/datatables/dataTables.bootstrap.min.js') !!}
{!! HTML::script('public/dist/plugins/select2/select2.full.min.js') !!}
{!! HTML::script('public/dist/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js') !!}
{!! HTML::script('public/dist/plugins/bootstrapvalidator/bootstrapValidator.min.js') !!}
{!! HTML::script('public/dist/plugins/input-mask/inputmask.js') !!}
{!! HTML::script('public/dist/plugins/input-mask/inputmask.date.extensions.js') !!}
{!! HTML::script('public/dist/plugins/input-mask/inputmask.extensions.js') !!}
{!! HTML::script('public/dist/plugins/input-mask/jquery.inputmask.js') !!}
{!! HTML::script('public/dist/plugins/jquery.cookie.js') !!}
{!! HTML::script('public/dist/js/prettify.js') !!}
{!! HTML::script('public/dist/plugins/chain/jquery.chained.min.js') !!}
{!! HTML::script('public/dist/plugins/chain/jquery.chained.remote.min.js') !!}

<!-- add 3rd party plugins and scripts here from extensions before validation -->
@yield('before_validation_scripts')

<!-- base ShineOS+ Validation script -->
{!! HTML::script('public/dist/js/validate.js') !!}
{!! HTML::script('public/dist/js/shineos.js') !!}
<!--Put page related scripts here-->
<script type="text/javascript">

    var baseurl = "{{ url() }}/";

    //reusable dataTable
    $(document).ready(function() {
        $("input[id^=timepicker]").timepicker({
            showInputs: false,
        });
        $("input[id^=datepicker]").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            "minDate": "01/01/1900",
            "maxDate": "<?php echo date("m/d/Y"); ?>"
        });
        $('input[id^=datepicker]').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });
        $("input[id^=datepicker_null]").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            "minDate": "01/01/1900",
            "maxDate": "<?php echo date("m/d/Y"); ?>"
        });
        $('input[id^=datepicker_null]').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });
        $("input[id^=datepicker_future]").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "minDate": "<?php echo date("m/d/Y"); ?>"
        });
        $('input[id^=datepicker_future]').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });
        $("input[id^=daterangepicker]").daterangepicker();

        $("input[id^=datetimepicker]").daterangepicker({
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            },
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement: 30,
            showDropdowns: true
        });
        $('input[id^=datetimepicker]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY'));
        });

        //using class names for UI
        $("input.timepicker").timepicker({
            showInputs: false,
        });
        $("input.datepicker").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            "minDate": "01/01/1900",
            "maxDate": "<?php echo date("m/d/Y"); ?>"
        });
        $('input.datepicker').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });
        $("input.datepicker_null").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
            showDropdowns: true,
            "minDate": "01/01/1900",
            "maxDate": "<?php echo date("m/d/Y"); ?>"
        });
        $('input.datepicker_null').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });
        $("input.datepicker_future").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "minDate": "<?php echo date("m/d/Y"); ?>"
        });
        $('input.datepicker_future').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });

        $("input.datepicker_future_null").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            "minDate": "<?php echo date("m/d/Y"); ?>"
        });
        $('input.datepicker_future_null').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });

        $("input.datetimepicker").daterangepicker({
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            },
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement: 30,
            showDropdowns: true
        });
         $('input.datetimepicker').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });

        $("input.datetimepicker_past").daterangepicker({
            locale: {
                format: 'MM/DD/YYYY h:mm A'
            },
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement: 30,
            showDropdowns: true,
            "minDate": "01/01/1900",
            "maxDate": "<?php echo date("m/d/Y"); ?>"
        });
         $('input.datetimepicker_past').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('MM/DD/YYYY'));
          });

    });

    //open tab if given
    if (window.location.hash) {
        var tab = window.location.hash.substr(1);
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    }
    //reusable dataTable
    $(document).ready(function() {

        //apply icheck for radios and checkboxes
        $('.icheck input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green'
        });
        //apply input masks
        $(".masked").inputmask();
        $(".email").inputmask("email");
        $(".select2").select2();

        $('table.datatable').DataTable({
            "Paginate": true,
            "LengthChange": true,
            "Filter": true,
            "Sort": true,
            "Info": true,
            "AutoWidth": true,
            "columnDefs": [
                { "orderable": false, "targets": 'nosort' }
            ]
        });

        //Date range as a button
        if(($('#daterange-btn')).length > 0){
            $('#daterange-btn').daterangepicker(
            {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                  },
                  startDate: moment(),
                  endDate: moment()
                },
                function (start, end) {
                  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            );
        }
        $("#province").remoteChained({
        parents : "#region",
        url : baseurl+"lov/api/province",
         loading : "Loading . . ."
        });

        $("#city").remoteChained({
        parents : "#province",
        url : baseurl+"lov/api/city",
         loading : "Loading . . ."
        });

        $("#brgy").remoteChained({
        parents : "#city",
        url : baseurl+"lov/api/brgy",
         loading : "Loading . . ."
        });

        //let us remove all alert boxes on the page
        window.setTimeout(function() {
            $(".alert-dismissible").fadeTo(1000, 0).slideUp(500, function(){
                $(this).remove();
            });
        }, 2000);

  });

</script>

<!-- scripts that can alter UI from extensions -->
<?php sh_persistent(); ?>

<!-- additional scripts from pages -->
@yield('scripts')
@yield('page_scripts')

<!-- additional scripts from extensions -->
@yield('plugin_jsscripts')

<span name="_token" content="{{ csrf_token() }}"></span>
{!! HTML::script('public/dist/js/tracker.js') !!}
<script type="text/javascript">
    $('submit').removeAttr('disabled');
    $('button').removeAttr('disabled');
</script>
