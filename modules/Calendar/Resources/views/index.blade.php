@extends('calendar::layouts.master')

@section('heads')
<!-- fullCalendar 2.2.5-->
{!! HTML::style('modules/Calendar/Assets/js/fullcalendar/fullcalendar.min.css') !!}
{!! HTML::style('modules/Calendar/Assets/js/datetime/DateTimePicker.min.css') !!}
@stop

@section('calendar-content')
<!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body no-padding">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div><!-- /.box-body -->
              </div><!-- /. box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
@stop

@section('scripts')

<!-- this is the modal window for editing calendar events -->
<div class="modal fade" id="modalbox" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>
<!-- end of modal window -->

{!! HTML::script('modules/Calendar/Assets/js/datetime/DateTimePicker.min.js') !!}
{!! HTML::script('modules/Calendar/Assets/js/fullcalendar/fullcalendar.min.js') !!}
{!! HTML::script('modules/Calendar/Assets/js/calendar.js') !!}

    <script type="text/javascript">
      var base_url = "{{url('/')}}";
      $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- Page specific script -->
    <script type="text/javascript">
        savColor = "";
        function mysqldate(dater)
        {
            var myDate = new Date(dater),
            year = myDate.getUTCFullYear(),
            month = ('0' + (myDate.getUTCMonth() + 1)).slice(-2),
            day = ('0' + myDate.getUTCDate()).slice(-2),
            hour  = ('0' + myDate.getUTCHours()).slice(-2),
            minute = ('0' + myDate.getUTCMinutes()).slice(-2),
            seconds = ('0' + myDate.getUTCSeconds()).slice(-2),
            mysqlDateTime = [year, month, day].join('-') + ' ' + [hour, minute, seconds].join(':');

            return mysqlDateTime;
        }

        function changecolor()
        {
            /* ADDING EVENTS */
            var currColor = "#6aa6d6"; //Red by default
            //Color chooser button
            var colorChooser = $(".color-chooser-btn");
            $(".color-chooser > li > a").click(function(e) {
                e.preventDefault();
                //Save color
                currColor = $(this).css("color");
                //convert to Hex
                rgb = currColor.substr(4, (currColor.length - 5) );
                c = rgb.split(", ");
                savColor = rgbToHex(c[0], c[1], c[2]);
                //Add color effect to button
                colorChooser
                        .css({"background-color": currColor, "border-color": currColor})
                        .html($(this).text()+' <span class="caret"></span>');
            });
        }

        function rgbToHex(R,G,B) {return "#"+toHex(R)+toHex(G)+toHex(B)}
        function toHex(n) {
            n = parseInt(n,10);
            if (isNaN(n)) return "00";
            n = Math.max(0,Math.min(n,255));
            return "0123456789ABCDEF".charAt((n-n%16)/16)
              + "0123456789ABCDEF".charAt(n%16);
        }

        function datetime()
        {
            $("#dtBox").DateTimePicker({
                dateTimeFormat: "yyyy-MM-dd hh:mm:ss AA"
            });
        }

        $(document).ready(function() {

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date();
            var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();
            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next, today',
                    center: '',
                    right: 'title' //month,agendaWeek,agendaDay'
                },
                buttonIcons: {
                    prev: 'left-single-arrow',
                    next: 'right-single-arrow',
                    prevYear: 'left-double-arrow',
                    nextYear: 'right-double-arrow'
                },
                buttonText: { //This is to add icons to the visible buttons
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var form = $('<form id="event_form">'+
                        '<div class="form-group has-success">'+
                        '<label>Event name</label>'+
                        '<div>'+
                        '<input type="text" id="newevent_name" class="form-control" placeholder="Name of event">'+
                        '</div>'+
                        '<label>Description</label>'+
                        '<div>'+
                        '<textarea rows="3" id="newevent_desc" class="form-control" placeholder="Description"></textarea>'+
                        '</div>'+

                        '<div style="width: 20%;float:left; margin-left:0px; z-index:3000;">'+
                        '<label">Event Color</label><br>'+
                        '<div class="btn-group" style="width: 100%; margin-bottom: 10px;">'+
                        '<button type="button" class="color-chooser-btn btn btn-danger btn-block btn-sm dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>'+
                        '<ul class="dropdown-menu color-chooser">'+
                        '<li><a class="text-green" href="#"><i class="fa fa-square"></i> Green</a></li>'+
                        '<li><a class="text-blue" href="#"><i class="fa fa-square"></i> Blue</a></li>'+
                        '<li><a class="text-navy" href="#"><i class="fa fa-square"></i> Navy</a></li>'+
                        '<li><a class="text-yellow" href="#"><i class="fa fa-square"></i> Yellow</a></li>'+
                        '<li><a class="text-orange" href="#"><i class="fa fa-square"></i> Orange</a></li>'+
                        '<li><a class="text-aqua" href="#"><i class="fa fa-square"></i> Aqua</a></li>'+
                        '<li><a class="text-red" href="#"><i class="fa fa-square"></i> Red</a></li>'+
                        '<li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i> Fuchsia</a></li>'+
                        '<li><a class="text-purple" href="#"><i class="fa fa-square"></i> Purple</a></li>'+
                        '</ul>'+
                        '</div>'+
                        '</div>'+

                        '<div style="width: 30%;float:left; margin-left:10px;">'+
                        '<label">Start Date/Time</label><br>'+
                        '<div>'+
                        '<input type="text" data-field="datetime" readonly id="start_date" value="'+ mysqldate(start) +'" class="form-control" placeholder="Start of event">'+
                        '</div>'+
                        '</div>'+

                        '<div style="width: 30%;float:left; margin-left:10px;">'+
                        '<label">End Date/Time</label><br>'+
                        '<div>'+
                        '<input type="text" data-field="datetime" readonly id="end_date" value="'+ mysqldate(end) +'" class="form-control" placeholder="End of event">'+
                        '</div>'+
                        '</div>'+

                        '<div style="width: 10%;float:left; margin-left:10px;">'+
                        '<label">All Day</label><br>'+
                        '<div>'+
                        '<input type="checkbox" id="all_day" class="" />'+
                        '</div>'+
                        '</div>'+

                        '</div>'+
                        '</form><br clear="all" /><div id="dtBox"></div>');
                    var buttons = $('<button id="event_cancel" type="cancel" class="btn btn-default btn-label-left">'+
                                    '<span><i class="fa fa-clock-o txt-danger"></i></span>'+
                                    'Cancel'+
                                    '</button>'+
                                    '<button type="submit" id="event_submit" class="btn btn-primary btn-label-left pull-right">'+
                                    '<span><i class="fa fa-clock-o"></i></span>'+
                                    'Add'+
                                    '</button>');
                    OpenModalBox('Add event', form, buttons);

                    $('#event_cancel').on('click', function(){
                        CloseModalBox();
                    });
                    $('#all_day').on('click', function(){
                        if($(this).is(':checked')) {
                            var sd = $('#start_date').val().substr(0, 10) + " 00:00:00";
                            var ed = $('#end_date').val().substr(0, 10) + " 11:59:59";
                            $('#start_date').val(sd);
                            $('#end_date').val(ed);
                            $('#start_date').attr('disabled','disabled');
                            $('#end_date').attr('disabled','disabled');
                        } else {
                            $('#start_date').removeAttr('disabled');
                            $('#end_date').removeAttr('disabled');
                        }
                    });
                    $('#event_submit').on('click', function(){
                        var new_event_name = $('#newevent_name').val();
                        if (new_event_name != '')
                        {
                            var ad = "";
                            if($('#all_day').is( ":checked" )) {
                                ad = "true";
                            }
                            $.ajax({
                                type: "POST",
                                url: "<?php site_url(); ?>calendar/events/insert",
                                data: {
                                    "title": new_event_name,
                                    "start": $('#start_date').val(),
                                    "end": $('#end_date').val(),
                                    "description": $('#newevent_desc').val(),
                                    "allday": ad,
                                    "color": savColor, //dblue
                                    "textcolor": "#ffffff",
                                    "user_id": <?php echo $user->user_id; ?>,
                                    "facility_id": <?php echo $facilityInfo->facility_id; ?>,
                                    "url": $('#newevent_url').val()
                                },
                                headers: {
                                  'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                }
                            })
                            .done(function( msg ) {
                                calendar.fullCalendar( 'refetchEvents' );
                            });

                        }
                        CloseModalBox();
                    });
                    changecolor();
                    datetime();
                    calendar.fullCalendar('unselect');
                },
                events: '<?php site_url(); ?>calendar/events',
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) { // this function is called when something is dropped
                    alert('dropped');
                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data('eventObject');

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allday = allDay;
                    copiedEventObject.backgroundColor = $(this).css("background-color");
                    copiedEventObject.borderColor = $(this).css("border-color");

                    // render the event on the calendar
                    // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }

                },
                eventRender: function (event, element, icon) {
                    if (event.description != "") {
                        element.attr('title', event.description);
                    }
                },
                eventClick: function(calEvent, jsEvent, view) {
                    alld = "";
                    if(calEvent.allday == 1) {
                        alld = "checked";
                    }
                    var form = $('<form id="event_form">'+
                        '<div class="form-group has-success">'+
                        '<label>Event name</label>'+
                        '<div>'+
                        '<input type="text" id="newevent_name" value="'+ calEvent.title +'" class="form-control" placeholder="Name of event">'+
                        '</div>'+
                        '<label>Description</label>'+
                        '<div>'+
                        '<textarea rows="3" id="newevent_desc" class="form-control" placeholder="Description">'+ calEvent.description +'</textarea>'+
                        '</div>'+

                        '<div style="width: 15%;float:left; margin-left:0px; z-index:3000;">'+
                        '<label">Event Color</label><br>'+
                        '<div class="btn-group" style="width: 100%; margin-bottom: 10px;">'+
                        '<button type="button" class="color-chooser-btn btn btn-danger btn-block btn-sm dropdown-toggle" data-toggle="dropdown" style="background-color:'+calEvent.color+'">Color <span class="caret"></span></button>'+
                        '<ul class="dropdown-menu color-chooser">'+
                        '<li><a class="text-green" href="#"><i class="fa fa-square"></i> Green</a></li>'+
                        '<li><a class="text-blue" href="#"><i class="fa fa-square"></i> Blue</a></li>'+
                        '<li><a class="text-navy" href="#"><i class="fa fa-square"></i> Navy</a></li>'+
                        '<li><a class="text-yellow" href="#"><i class="fa fa-square"></i> Yellow</a></li>'+
                        '<li><a class="text-orange" href="#"><i class="fa fa-square"></i> Orange</a></li>'+
                        '<li><a class="text-aqua" href="#"><i class="fa fa-square"></i> Aqua</a></li>'+
                        '<li><a class="text-red" href="#"><i class="fa fa-square"></i> Red</a></li>'+
                        '<li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i> Fuchsia</a></li>'+
                        '<li><a class="text-purple" href="#"><i class="fa fa-square"></i> Purple</a></li>'+
                        '</ul>'+
                        '</div>'+
                        '</div>'+

                        '<div style="width: 30%;float:left; margin-left:10px;">'+
                        '<label">Start Date/Time</label><br>'+
                        '<div>'+
                        '<input type="text" data-field="datetime" readonly id="start_date" value="'+ mysqldate(calEvent.start) +'" class="form-control" placeholder="Start of event">'+
                        '</div>'+
                        '</div>'+

                        '<div style="width: 30%;float:left; margin-left:10px;">'+
                        '<label">End Date/Time</label><br>'+
                        '<div>'+
                        '<input type="text" data-field="datetime" readonly id="end_date" value="'+ mysqldate(calEvent.end) +'" class="form-control" placeholder="End of event">'+
                        '</div>'+
                        '</div>'+

                        '<div style="width: 10%;float:left; margin-left:10px;">'+
                        '<label">All Day</label><br>'+
                        '<div>'+
                        '<input type="checkbox" id="all_day" class="" '+alld+' />'+
                        '</div>'+
                        '</div>'+

                        '</div>'+
                        '</form><br clear="all" /><div id="dtBox"></div>');
                    var buttons = $('<button id="event_cancel" type="cancel" class="btn btn-default btn-label-left">'+
                                    '<span><i class="fa fa-clock-o txt-danger"></i></span>'+
                                    'Cancel'+
                                    '</button>'+
                                    '<button id="event_delete" type="cancel" class="btn btn-danger btn-label-left">'+
                                    '<span><i class="fa fa-clock-o txt-danger"></i></span>'+
                                    'Delete'+
                                    '</button>'+
                                    '<button type="submit" id="event_change" class="btn btn-primary btn-label-left pull-right">'+
                                    '<span><i class="fa fa-clock-o"></i></span>'+
                                    'Save changes'+
                                    '</button>');
                    OpenModalBox('Change event', form, buttons);

                    $('#event_cancel').on('click', function(){
                        CloseModalBox();
                    });
                    $('#all_day').on('click', function(){
                        if($(this).is(':checked')) {
                            var sd = $('#start_date').val().substr(0, 10) + " 00:00:00";
                            var ed = $('#end_date').val().substr(0, 10) + " 11:59:59";
                            $('#start_date').val(sd);
                            $('#end_date').val(ed);
                            $('#start_date').attr('disabled','disabled');
                            $('#end_date').attr('disabled','disabled');
                        } else {
                            $('#start_date').removeAttr('disabled');
                            $('#end_date').removeAttr('disabled');
                        }
                    });
                    $('#event_delete').on('click', function(){
                        calendar.fullCalendar('removeEvents' , function(ev){
                            return (ev.calendar_id == calEvent.calendar_id);
                        });
                        $.ajax({
                            type: "POST",
                            url: "<?php site_url(); ?>calendar/events/delete",
                            data: {
                                "calendar_id" : calEvent.calendar_id
                            },
                            headers: {
                              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                            }
                        }).done(function( msg )
                        {
                            calendar.fullCalendar( 'refetchEvents' )

                            CloseModalBox();
                        });
                    });
                    $('#event_change').on('click', function(){
                        if(savColor != "") {
                            thisColor = savColor;
                        } else {
                            thisColor = calEvent.color;
                        }
                        var ad = "";
                        if($('#all_day').is( ":checked" )) {
                            ad = "true";
                        }
                        $.ajax({
                            type: "POST",
                            url: "<?php site_url(); ?>calendar/events/update",
                            data: {
                                "calendar_id" : calEvent.calendar_id,
                                "title": $('#newevent_name').val(),
                                "start": $('#start_date').val(),
                                "end": $('#end_date').val(),
                                "description": $('#newevent_desc').val(),
                                "allday": ad,
                                "color": thisColor,
                                "textcolor": "#ffffff",
                                "user_id": <?php echo $user->user_id; ?>,
                                "facility_id": <?php echo $facilityInfo->facility_id; ?>
                            },
                            headers: {
                              'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                            }
                        }).done(function( msg )
                        {
                            calendar.fullCalendar( 'refetchEvents' )
                            CloseModalBox();
                        });

                    });
                    changecolor();
                    datetime();
                },
                eventDrop: function(event, dayDelta, revertFunc) {
                    //alert(event.calendar_id + " was changed to " + mysqldate(event.start.format()) + " " + event.end.format());
                    $.ajax({
                        type: "POST",
                        url: "<?php site_url(); ?>calendar/events/moved",
                        data: {
                            "calendar_id" : event.calendar_id,
                            "start": mysqldate(event.start.format()),
                            "end": mysqldate(event.end.format()),
                            "user_id": <?php echo $user->user_id; ?>,
                            "facility_id": <?php echo $facilityInfo->facility_id; ?>
                        },
                        headers: {
                          'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                        }
                    })
                }
            });

            /* ADDING EVENTS */
            var currColor = "#f56954"; //Red by default
            //Color chooser button
            var colorChooser = $(".color-chooser-btn");
            $(".color-chooser > li > a").click(function(e) {
                e.preventDefault();
                //Save color
                currColor = $(this).css("color");
                //Add color effect to button
                colorChooser
                        .css({"background-color": currColor, "border-color": currColor})
                        .html($(this).text()+' <span class="caret"></span>');
            });

        });
    </script>
@stop
