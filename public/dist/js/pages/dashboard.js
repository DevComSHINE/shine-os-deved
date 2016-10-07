/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/
"use strict";

$(function () {

  //Make the dashboard widgets sortable Using jquery UI
  $(".connectedSortable").sortable({
    placeholder: "sort-highlight",
    connectWith: ".connectedSortable",
    handle: ".box-header, .nav-tabs",
    forcePlaceholderSize: true,
    zIndex: 999999
  });
  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");

  //jQuery UI sortable for the todo list
  $(".todo-list").sortable({
    placeholder: "sort-highlight",
    handle: ".handle",
    forcePlaceholderSize: true,
    zIndex: 999999
  });

  //bootstrap WYSIHTML5 - text editor
  $(".textarea").wysihtml5();

  $('.analytics-daterange').daterangepicker(
          {
            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              'Last 7 Days': [moment().subtract(6, 'days'), moment()],
              'Last 30 Days': [moment().subtract(29, 'days'), moment()],
              'This Month': [moment().startOf('month'), moment().endOf('month')],
              'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
              'This Year': [moment().startOf('year'), moment().endOf('year')],
              'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
          },
  function (start, end) {
    // console.log("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    var url = 'analytics/'+ start + '/' + end;
    //console.log("You chose: " + start + ' - ' + end);
    Helper.ajaxGet(url, [], function(result) {
      console.log(result);
    });
  });

  /* jQueryKnob */
  $(".knob").knob();

  //Sparkline charts
  var myvalues = [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021];
  $('#sparkline-1').sparkline(myvalues, {
    type: 'line',
    lineColor: '#92c1dc',
    fillColor: "#ebf4f9",
    height: '50',
    width: '80'
  });
  myvalues = [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921];
  $('#sparkline-2').sparkline(myvalues, {
    type: 'line',
    lineColor: '#92c1dc',
    fillColor: "#ebf4f9",
    height: '50',
    width: '80'
  });
  myvalues = [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21];
  $('#sparkline-3').sparkline(myvalues, {
    type: 'line',
    lineColor: '#92c1dc',
    fillColor: "#ebf4f9",
    height: '50',
    width: '80'
  });

  //The Calender
  $("#calendar").datepicker();

  //SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').slimScroll({
    height: '250px'
  });

  //Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function (e) {
    area.redraw();
    donut.redraw();
  });


  /* BOX REFRESH PLUGIN EXAMPLE (usage with morris charts) */
  $("#loading-example").boxRefresh({
    source: "ajax/dashboard-boxrefresh-demo.php",
    onLoadDone: function (box) {
      bar = new Morris.Bar({
        element: 'bar-chart',
        resize: true,
        data: [
          {y: '2006', a: 100, b: 90},
          {y: '2007', a: 75, b: 65},
          {y: '2008', a: 50, b: 40},
          {y: '2009', a: 75, b: 65},
          {y: '2010', a: 50, b: 40},
          {y: '2011', a: 75, b: 65},
          {y: '2012', a: 100, b: 90}
        ],
        barColors: ['#00a65a', '#f56954'],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['CPU', 'DISK'],
        hideHover: 'auto'
      });
    }
  });

  /* The todo list plugin */
  $(".todo-list").todolist({
    onCheck: function (ele) {
      console.log("The element has been checked")
    },
    onUncheck: function (ele) {
      console.log("The element has been unchecked")
    }
  });

    /* --- REPORTS HERE --- */

    $('.ranges li')
    .filter(function(){
        return (/^((?!Custom Range).)*$/gm).test($(this).text())
    })
    .on('click.rangesLi', function () {
        $('.applyBtn').click();
    });


    // set report data
    function setReportData( result ) {
        $('#count_by_gender_sex').html(result.count_by_gender_sex);
        $('#count_by_services_rendered').html(result.count_by_services_rendered);
        $('#count_by_disease').html(result.count_by_disease);

        // patients
        var top_patients_cont = '';
        for ( var i=0; i<result.top_patients.length; i++ ) {
            top_patients_cont += '<div class="progress-group">';
            top_patients_cont += '<span class="progress-text">';
            top_patients_cont += result.top_patients[i].last_name;
            top_patients_cont += ', ';
            top_patients_cont += result.top_patients[i].first_name + ' ';
            top_patients_cont += result.top_patients[i].middle_name;
            top_patients_cont += '</span>';
            top_patients_cont += '</div>';
        }

        $('#top_patients_cont').html(top_patients_cont);
    }

    var applyBtn = $('.applyBtn');
    applyBtn.click('applyBtn.applyBtn', function () {
        var daterangepicker_start = $('input[name="daterangepicker_start"]');
        var daterangepicker_end = $('input[name="daterangepicker_end"]');
        var token = $('input[name=_token]');

        $.ajax({
            url: 'reports/getpatientinfo',
            type: "post",
            data: {
                'from': daterangepicker_start.val(),
                'to': daterangepicker_end.val(),
                '_token': token.val()
            },
            success: function(data){
                var result = jQuery.parseJSON(data);
                setReportData(result);
            }
        });

        setFacilityRecapChart();
    });



  /* Reports Charts
   * -------
   * Here we will create a few charts using ChartJS
   */

   function setFacilityRecapChart ()
   {
        var daterangepicker_start = $('input[name="daterangepicker_start"]');
        var daterangepicker_end = $('input[name="daterangepicker_end"]');
        var token = $('input[name=_token]');

        $.ajax({
            url: 'reports/graph',
            type: "post",
            data: {
                'from': daterangepicker_start.val(),
                'to': daterangepicker_end.val(),
                '_token': token.val()
            },
            success: function(data){
                var result = jQuery.parseJSON(data);


                // Get context with jQuery - using jQuery's .get() method.
                var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
                // This will get the first returned node in the jQuery collection.
                var salesChart = new Chart(salesChartCanvas);

                var salesChartData = {
                labels: result.labels,
                datasets: result.patientData
                };

                var salesChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%=datasets[i].label%></li><%}%></ul>",
                //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: false,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true
                };

                //Create the line chart
                salesChart.Line(salesChartData, salesChartOptions);

            }
        });

   }

   setFacilityRecapChart();


  //---------------------------
  //- END MONTHLY SALES CHART -
  //---------------------------

});
