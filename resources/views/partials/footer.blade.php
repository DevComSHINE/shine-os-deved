<!--Global JQuery plugins-->
{!! HTML::script('public/dist/plugins/jQuery/jQuery-2.1.4.min.js') !!}
{!! HTML::script('public/dist/js/bootstrap.min.js') !!}
{!! HTML::script('public/dist/plugins/jQueryUI/jquery-ui.min.js') !!}
{!! HTML::script('public/dist/js/app.js') !!}
{!! HTML::script('public/dist/plugins/daterangepicker/moment.min.js') !!}
{!! HTML::script('public/dist/plugins/daterangepicker/daterangepicker.js') !!}
{!! HTML::script('public/dist/plugins/timepicker/bootstrap-timepicker.min.js') !!}
{!! HTML::script('public/dist/plugins/slimScroll/jquery.slimscroll.min.js') !!}
{!! HTML::script('public/dist/plugins/iCheck/icheck.js') !!}
{!! HTML::script('public/dist/js/pages/helper/helper.js') !!}
{!! HTML::script('public/dist/plugins/datatables/jquery.dataTables.min.js') !!}
{!! HTML::script('public/dist/plugins/datatables/dataTables.bootstrap.min.js') !!}
{!! HTML::script('public/dist/plugins/select2/select2.full.min.js') !!}

{!! HTML::script('public/dist/js/jquery.form.js') !!}
{!! HTML::script('public/dist/js/jquery.form.wizard.js') !!}
{!! HTML::script('public/dist/js/jquery.validate.js') !!}

{!! HTML::script('public/dist/plugins/bootstrapvalidator/bootstrapValidator.min.js') !!}
{!! HTML::script('public/dist/plugins/input-mask/inputmask.js') !!}
{!! HTML::script('public/dist/plugins/input-mask/inputmask.date.extensions.js') !!}
{!! HTML::script('public/dist/plugins/input-mask/inputmask.extensions.js') !!}
{!! HTML::script('public/dist/plugins/input-mask/jquery.inputmask.js') !!}

{!! HTML::script('public/dist/plugins/chain/jquery.chained.min.js') !!}
{!! HTML::script('public/dist/plugins/chain/jquery.chained.remote.min.js') !!}

@yield('linked_scripts')

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
            showDropdowns: true,
            "minDate": "01/01/1900",
            "maxDate": "<?php echo date("m/d/Y"); ?>"
        });
        $("input[id^=datepicker_future]").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            "minDate": "<?php echo date("m/d/Y"); ?>"
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

{!! HTML::script('public/dist/js/validate.js') !!}

@yield('scripts')

@yield('plugin_jsscripts')
