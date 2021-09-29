@extends('admin.layouts.app')
@section('title', 'Schedule')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/libs/fullcalendar/fullcalendar.min.css') }}">
<style>
    .btn-schedule {
        background-color: #ffffff!important;
        border-color: #ced4da!important;
    }
    .schedule-time {
		border:none!important;
		font-size:1.2rem!important;
		background-color:#f3f5f7!important;
		
	}
    .page-title-schedule {
        padding-top: 0px;
    }
</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-xl-9">
            <div class="card mt-4 mt-xl-0 mb-0">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="page-title-schedule">
                                <h4 id="head_time"></h4>
                                <p id="head_date"></p>
                            </div>
                        </div>
                        <div class="mt-2 col-md-6">
                            <div class="justify-content-end d-flex">
                                <div id="customschedule"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">               
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-xl-3">
            <div class="row mb-3">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal needs-validation" id="ScheduleForm" novalidate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="page-title-custom">
                                        <h4>Schedule</h4>
                                    </div>
                                </div>
                                <div class="mb-3 mt-1 col-md-6">
                                    <div class="justify-content-end d-flex">
                                        <a href="javascript:void(0);" class="btn btn-secondary btn-sm me-2"> Cancel</a>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_scheduleadd"> Add</a>
                                    </div>
                                </div>
                            </div>
                        
                            <hr class="flex-grow-1 mt-1 mb-3" style="height:1px;">
                        
                            <div class="row mt-2 mb-3">
                                <div class="col-sm-9">
                                    <input class="form-control" placeholder="Pleae enter a title" type="text" name="stitle" id="stitle" required>
                                </div>
                                <div class="col-sm-3">
                                    <div class="justify-content-end d-flex">
                                        <div class="dropdown d-inline-block">
                                            <a class="btn btn-schedule text-primary dropdown-toggle" href="#" role="button" id="schdule-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-checkbox-blank-circle font-size-13 me-2"></i>
                                                <i class="mdi mdi-chevron-down font-size-13"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="schedule-dropdown" style="">
                                                <a class="dropdown-item color_select" data-color="#7a6fbe" href="#"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2 text-primary" ></i> Plan</a>
                                                <a class="dropdown-item color_select" data-color="#58db83" href="#"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2 text-success" ></i> Meeting</a>
                                                <a class="dropdown-item color_select" data-color="#ec536c" href="#"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2 text-danger"></i> Report</a>
                                                <a class="dropdown-item color_select" data-color="#f5b225" href="#"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2 text-warning"></i> New</a>
                                                <a class="dropdown-item color_select" data-color="#6c757d" href="#"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2 text-secondary"></i> 1</a>
                                                <a class="dropdown-item color_select" data-color="#0dcaf0" href="#"><i class="mdi mdi-checkbox-blank-circle font-size-13 me-2 text-info"></i> 1</a>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="schedule_item_color" value="#7a6fbe" />
                                
                            </div>
                            <div class="row p-2 me-1 ms-1 mb-3" id="sche_time" style="background-color:#f3f5f7;border-radius: 3px;">
                                <div class="col-sm-5">
                                    <div class="form-group mt-2">
                                        <label class="form-control-label"><span class="tx-dark" id="start"></span></label>
                                        <input class="form-control timepicker schedule-time" type="text" id="starttime" name="starttime">
                                    </div>
                                </div>
                                <div class="col-sm-1" style="margin:auto;">
                                    <i class="fas fa-chevron-right" style="font-size:30px;"></i>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group mt-2">
                                        <label class="form-control-label"><span class="tx-dark" id="end"></span></label>
                                        <input class="form-control timepicker schedule-time" type="text" id="endtime" name="endtime">
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2 me-1 ms-1 mb-3" id="sche_all" style="background-color:#f3f5f7;border-radius: 3px;">
                                <div class="col-sm-5">
                                    <div class="form-group mt-2">
                                        <label class="form-control-label"><span class="tx-dark" id="allstart"></span></label>
                                    </div>
                                </div>
                                <div class="col-sm-1" style="margin:auto;">
                                    <i class="fas fa-chevron-right" style="font-size:30px;"></i>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group mt-2">
                                        <label class="form-control-label"><span class="tx-dark" id="allend"></span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="me-1 ms-1 mb-3">
                                <div class="row">
                                    <div class="col-sm-6 d-grid">
                                        <button class="btn btn-secondary btn-block" id="btn_time" type="button"> Time </button>
                                    </div>
                                    <div class="col-sm-6 d-grid">
                                        <button class="btn btn-primary btn-block" id="btn_all_day" type="button"> All day </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1">
                                    <i class="mdi mdi-account-multiple-plus" style="font-size:24px;"></i>
                                </div>
                                <div class="col-sm-11">
                                    <div class="justify-content-end d-flex">
                                        <select class="form-control select2 wd-100p" style="height: calc(1.8rem + 2px);padding: 0.15rem 0.75rem;" id="usersearch" name="usersearch" required>
                                            <option value="">Search a User</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endforeach
                                        </select>	
                                    </div>					
                                </div>
                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-11">
                                    <div class="justify-content-end d-flex">
                                        <input class="form-control" style="height: calc(2.3rem + 2px);padding: 0.15rem 0.75rem;" placeholder="Customer Name" type="text" name="customer_name" id="customer_name">
                                    </div>					
                                </div>
                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-11">
                                    <div class="justify-content-end d-flex">
                                        <input class="form-control" style="height: calc(2.3rem + 2px);padding: 0.15rem 0.75rem;" placeholder="Customer Name" type="text" name="customer_name1" id="customer_name1">
                                    </div>					
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <i class="mdi mdi-note" style="font-size:25px;"></i>
                                </div>
                                <div class="col-sm-11">
                                    <div class="justify-content-end d-flex">
                                        <input class="form-control" type="text" style="height: calc(2.3rem + 2px);padding: 0.15rem 0.75rem;" placeholder="note" id="schedulenote" name="schedulenote">
                                    </div>
                                                                            
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="page-title-custom">
                                    <h5>Pinned message</h5>
                                </div>
                            </div>
                            <div class="mb-3 mt-1 col-md-6">
                                <div class="justify-content-end d-flex">
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-sm me-2"> Cancel</a>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_pinadd"> Add</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" id="pintext" name="pintext" placeholder="There will be some text by admin" rows="8" spellcheck="false"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
@stop
@section('javascript')
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<!-- plugin js -->
<script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/libs/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/libs/fullcalendar/locale-all.js') }}"></script>
<script>
    $(window).resize(function(){
        minimizeMenu();
    });
    minimizeMenu();
    
    function minimizeMenu() {
        var $window = $(window);
        if(window.matchMedia('(min-width: 1000px)').matches && window.matchMedia('(max-width: 2100px)').matches) {
            $("body").toggleClass("sidebar-enable vertical-collpsed");
        };
    }
    
    
    $(".select2").select2();
    $("#sche_all").hide();
    
    var today = new Date();
	var dayname = currentDate();
    function currentDate() {
        var currentd = new Date();
        var weekdays = new Array(7);
        weekdays[0] = "일";
        weekdays[1] = "월";
        weekdays[2] = "화";
        weekdays[3] = "수";
        weekdays[4] = "목";
        weekdays[5] = "금";
        weekdays[6] = "토";
        var r = weekdays[currentd.getDay()];
        return r;
    };
	//$("#today").html(mm+ '.' + dd);
    $("#btn_time").on('click', function(e){
        $("#starttime").val('07:30 AM');
        $("#endtime").val('01:30 PM');
        $("#start").html(moment(today).format("YYYY.MM.DD") +' (' + dayname + ')');
        $("#end").html(moment(today).format("YYYY.MM.DD")  +' (' + dayname + ')');
        $("#sche_all").hide();
        $("#sche_time").show();
    });

    $("#btn_all_day").on('click', function(e){
        $("#starttime").val('07:30 AM');
        $("#endtime").val('07:30 PM');
        $("#allstart").html(moment(today).format("YYYY.MM.DD") +' (' + dayname + ')');
        $("#allend").html(moment(today).format("YYYY.MM.DD")  +' (' + dayname + ')');
        $("#sche_all").show();
        $("#sche_time").hide();
    });

    $("#starttime").val('07:30 AM');
    $("#endtime").val('01:30 PM');
	$("#start").html(moment(today).format("YYYY.MM.DD") +' (' + dayname + ')');
	$("#end").html(moment(today).format("YYYY.MM.DD")  +' (' + dayname + ')');
    function getFormattedString(d){
		return d.getFullYear() + "-"+(d.getMonth()+1) +"-"+d.getDate() + ' '+d.toString().split(' ')[4];
	}
    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return strTime;
    }
    var crrent_time = formatAMPM(new Date);

    $("#head_date").html(moment(today).format("YYYY.MM.DD"));
    $("#head_time").html(crrent_time);
    var date = new Date()
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear()
    $('#calendar').fullCalendar({
        locale: 'ko',
        header: {
            left: '',
            center: 'title, today',
            right: 'allButton,prev,next'
        },
        editable: true,
        droppable: true,
        eventLimit: 2,
        defaultView: 'month',
        events: '/admin/schedule',
        eventRender: function (event, element, view) {
            if (view.name == 'month') {
                element.find(".fc-content").append("<span class='ms-3 close schedule_btn'>&times;</span>");
            } else if(view.name =='listDay') {
                element.find(".fc-list-item").append("<td class='fc-list-item-title fc-widget-content'>"+"<span class='ms-3 close schedule_btn'>&times;</span>"+"</td>");
            }
            element.find(".schedule_btn").on('click', function() {
                $('#calendar').fullCalendar('removeEvents',event._id);
                console.log('delete', event.schedule_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: `/admin/scheduledelete`,
                    data: {
                        schedule_id: event.schedule_id
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.status == "Success") {
                            
                        } 
                    },
                    error: function(data){
                        console.log(data);
                    }
                });

            });
        },
        dayClick:function( date, jsEvent, view ) {
            console.log("-----")
        },
        customButtons: {
            allButton: {
                text:'Display All',
                click:function(event, jsEvent, view){
                    $('#calendar').fullCalendar('changeView', 'listYear');
                }
            }
        },
        

    });
    addButtons();

    bindButtonActions();
    function addButtons() {
        // create buttons
        var month = $("<span/>")
            .addClass("fc-month-button fc-button fc-state-default fc-corner-left fc-state-active")
            .attr({
                unselectable: "on"
            })
            .text("월");

        var listday = $("<span/>")
            .addClass("fc-listDay-button fc-button fc-state-default fc-corner-right")
            .attr({
                unselectable: "on"
            })
            .text("일정목록");
        var tr = $("<tr/>").append(
            $("<td/>")
                .append(month)
                .append(listday)
        );

        // insert row before title.
        $("#customschedule").before(tr);
    }

    function bindButtonActions(){
        $(".fc-month-button").on('click', function() {
            if ($(this).hasClass("fc-state-active")) {
            } else {
                $(this).addClass("fc-state-active");
            }
            $(".fc-listDay-button").removeClass("fc-state-active");
            var view = "month";
            $('#calendar').fullCalendar('changeView', view);
        });
        $(".fc-listDay-button").on('click', function() {
            if ($(this).hasClass("fc-state-active")) {  
            } else {
                $(this).addClass('fc-state-active');
            }
            $(".fc-month-button").removeClass("fc-state-active");
            view = "listDay";
            $('#calendar').fullCalendar('changeView', view);
        });
    }
    $(".color_select").on("click", function(e) {
        $('.btn-schedule').removeClass('text-primary');
        $('.btn-schedule').css({'color': $(this).data('color'), 'border-color': $(this).data('color')});
        $("#schedule_item_color").val($(this).data('color'));
    });
    $('.timepicker').timepicker({
        showInputs: false
    });
    $(".btn_scheduleadd").on('click', function(e){
        var form = $("#ScheduleForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        } 
        var currentdate = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
		var starttempdate = new Date(currentdate + " " + $("#starttime").val());
		var endtempdate = new Date(currentdate + " " + $("#endtime").val());
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/scheduleadd`,
            data: {
                'title': $('#stitle').val(),
				'starttime': getFormattedString(starttempdate),
				'endtime': getFormattedString(endtempdate),
				'backgroundColor': $("#schedule_item_color").val(),
				'borderColor': $("#schedule_item_color").val(),
				'userId': $("#usersearch").val(),
				'note': $("#schedulenote").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    // $(".fc-month-button").on('click', function(e){
    //     $(".fc-listMonth-button").click();
    //     console.log("====================")
    // })
</script>
@endsection