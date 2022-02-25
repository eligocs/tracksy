<?php
	//date use to filter
	$from = date('Y-m-01');
	$to = date('Y-m-t');
	//from date from app start
	$from_start = "2017-11-01";
	$today_date = date('Y-m-d');
	//This Month
	$this_month = date("Y-m");
?>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper sales_team_dashboard">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE HEADER-->
        <div class="theme-panel hidden-xs hidden-sm">
            <div class="toggler"> </div>
            <div class="toggler-close"> </div>
            <div class="theme-options">
                <div class="theme-option theme-colors clearfix">
                    <span> THEME COLOR </span>
                    <ul id="theme_color_listing">
                        <li class="color-default current tooltips" data-style="default" data-container="body"
                            data-original-title="Default"> </li>
                        <li class="color-darkblue tooltips" data-style="theme_dark" data-container="body"
                            data-original-title="Theme Dark"> </li>
                        <li class="color-blue tooltips" data-style="theme_light" data-container="body"
                            data-original-title="Theme Light"> </li>
                    </ul>
                </div>
                <div class="th_response"></div>
            </div>
        </div>


        <nav class="quick-nav">
            <a class="quick-nav-trigger" href="javascript: void(0)">
                <span aria-hidden="true"></span>
            </a>
            <ul class="sidebar-buttons">

                <li><button class="btn" id="btn_load_travel_followup"><i class="fa fa-clock-o"></i> Travel Dates
                        Follow</button></li>
            </ul>
            <span aria-hidden="true" class="quick-nav-bg"></span>

        </nav>
        <div class="quick-nav-overlay"></div>

        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?php echo site_url(); ?>">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->

        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Service Team Dashboard
            <small>recent payments received, payments pending etc.</small>
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS 1-->

        <div class="portlet box blue margin-top-40">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-calendar"></i>Today's Status</div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="callCountBlock">
                            <a class="dashboard-stat dashboard-stat-v2 blue"
                                href="<?php echo site_url("itineraries") . "/?todayStatus={$today_date}&leadStatus=approved"; ?>">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($totalApprovedItiToday) ? $totalApprovedItiToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Iti Booked <br> Today </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="callCountBlock">
                            <a class="dashboard-stat dashboard-stat-v2 blue"
                                href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=approved"; ?>">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($totalApprovedItiMonth) ? $totalApprovedItiMonth : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Iti Booked <br> This Month </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS 1-->
        <div class="row2">
            <div class="clearfix clearboth"></div>
            <!--AMENDMENT SECTION-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-calendar"></i>LATEST AMENDMENT</div>
                </div>
                <div class="row dashboard-tables-all-info">
                    <div class="col-lg-12 col-xs-12 col-sm-12 margin-bottom-30">
                        <div class="portlet light">
                            <div class="portlet-title tabbable-line">
                                <div class="caption">
                                    <i class="icon-bubbles font-dark hide"></i>
                                    <span class="caption-subject font-dark bold uppercase">Last 20 Amendments</span>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_comments_21">
                                        <div class="dashboard-scroll">
                                            <table class="table table-hover d-table table-fixed">
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th>Name</th>
                                                    <th>Package</th>
                                                    <th>agent</th>
                                                    <th>Action</th>
                                                </tr>
                                                <?php if( isset($amendmentItineraries) && !empty( $amendmentItineraries )) { 
                                            $ii = 1;	
                                            foreach( $amendmentItineraries as $am_iti ){ ?>

                                                <tr>
                                                    <td><?php echo $ii;?>.</td>
                                                    <td><?php echo $am_iti->customer_name;?></td>
                                                    <td><?php echo $am_iti->package_name;?></td>
                                                    <td><?php echo get_user_name($am_iti->agent_id);?></td>

                                                    <td><a class="btn btn-custom" target="_blank"
                                                            href="<?php echo site_url("itineraries/view_iti/{$am_iti->iti_id}/{$am_iti->temp_key}"); ?>">
                                                            View</a></td>
                                                </tr>
                                                <?php 
                                            $ii++;
                                            } 
                                        }else{ ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <div class="mt-comment-text"> No Data found. </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <!-- END: Pending Payments section -->
                                            </table>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn_blue_outline view_table_data"><i
                                            class="fa fa-angle-down"></i> View All</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!--END AMENDMENT SECTION-->
            <!-- Pending Vouchers  -->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-calendar"></i>LATEST VOUCHERS</div>
                </div>

                <div class="row dashboard-tables-all-info">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading2">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#latest_pending" data-toggle="tab">Latest Pending Vouchers</a>
                                    </li>
                                    <li><a href="#last_20_confirmed" data-toggle="tab">Last 20 Confirmed Vouchers</a></li>
                                </ul>
                            </div>
                            <div class="panel-body padding-0">
                                <div class="dashboard-scroll">
                                    <div class="tab-content">
                                        <div class="tab-pane fade in active" id="latest_pending">
                                            <table class="table table-hover d-table table-fixed">
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th>Name</th>
                                                    <th>Package</th>
                                                    <th>agent</th>
                                                    <th>Action</th>
                                                </tr>
                                                <?php if( isset($pending_vouchers) && !empty($pending_vouchers) ) {
                                                    $dcnt = 1;	
                                                    foreach( $pending_vouchers as $pen_voucher ){ ?>
                                                <tr>
                                                    <td><?php echo $dcnt; ?>.</td>
                                                    <td><?php echo $pen_voucher->customer_name;?></td>
                                                    <td><?php echo $pen_voucher->package_name;?></td>
                                                    <td><?php echo get_user_name($pen_voucher->agent_id);?></td>
                                                    <td><a class="btn btn-custom" target="_blank"
                                                            href="<?php echo site_url("itineraries/view_iti/{$pen_voucher->iti_id}/{$pen_voucher->temp_key}"); ?>">
                                                            View</a></td>
                                                </tr>
                                                <?php 
                                                        $dcnt++;
                                                    } 
                                                }else{ ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <div class="mt-comment-text"> No Data found. </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <!-- END: Pending Payments section -->
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="last_20_confirmed">
                                            <table class="table table-hover d-table table-fixed">
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th>Name</th>
                                                    <th>Package</th>
                                                    <th>agent</th>
                                                    <th>Action</th>
                                                </tr>
                                                <?php if( isset($confirmed_vouchers) && !empty($confirmed_vouchers) ) {
                                                $cnt = 1;	
                                                foreach( $confirmed_vouchers as $cnfrm_voucher ){ ?>
                                                <tr>
                                                    <td><?php echo $cnt; ?>.</td>
                                                    <td><?php echo $cnfrm_voucher->customer_name;?></td>
                                                    <td><?php echo $cnfrm_voucher->package_name;?></td>
                                                    <td><?php echo get_user_name($cnfrm_voucher->agent_id);?></td>
                                                    <td><a class="btn btn-custom" target="_blank"
                                                            href="<?php echo site_url("itineraries/view_iti/{$cnfrm_voucher->iti_id}/{$cnfrm_voucher->temp_key}"); ?>">
                                                            View</a></td>
                                                </tr>
                                                <?php 
                                                        $cnt++;
                                                        } 
                                                        }else{ ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <div class="mt-comment-text"> No Data found. </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <!-- END: Pending Payments section -->
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Pending Vouchers  -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    <!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->

<!-- ITINERARIES FOLLOW UP -->
<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel2">PAYMENT FOLLOW UP</h4>
            </div>
            <div class="col-md-12 column" id="iti_folloup_cal_section">
                <div id='calendar_payment_followup' class='calender_dashboard'></div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- Pending advance payment ITINERARIES FOLLOW UP -->
<div class="modal right fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel4">ADVANCE PAYMENT PENDING FOLLOW UP</h4>
            </div>
            <div class="col-md-12 column">
                <div id='calendar_advance_payment_followup' class='calender_dashboard'></div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- Pending payment ITINERARIES FOLLOW UP -->
<div class="modal right fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel5">PAYMENT PENDING FOLLOW UP AFTER ADVANCE RECIEVED</h4>
            </div>
            <div class="col-md-12 column">
                <div id='calendar_bal_payment_followup' class='calender_dashboard'></div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!-- Travel Dates -->
<div class="modal right fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel3">Travel Dates</h4>
            </div>
            <div class="col-md-12 column" id="travel_cal_section">
                <div id='calendar_travel_dates' class='calender_dashboard'></div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<script type="text/javascript">
/**************** Payment FOLLOW UP CALENDAR ****************/
jQuery(document).ready(function($) {
    //payment follow up btn
    $("#btn_load_payment_followup").on("click", function(e) {
        e.preventDefault();
        $(".modal").modal("hide");
        $("#myModal2").modal("show");
        payment_followup();
        //$(".calender_dashboard").fullCalendar("render");
        setTimeout(function() {
            $(".calender_dashboard").fullCalendar("render");
        }, 300); // Set enough time to wait until animation finishes;
    });

    //Advance payment follow up btn
    $("#btn_load_ad_payment_followup").on("click", function(e) {
        e.preventDefault();
        $(".modal").modal("hide");
        $("#myModal4").modal("show");
        advance_payment_followup();
        setTimeout(function() {
            $(".calender_dashboard").fullCalendar("render");
        }, 300); // Set enough time to wait until animation finishes;
    });

    //Balance payment follow up btn
    $("#btn_load_balance_payment_followup").on("click", function(e) {
        e.preventDefault();
        $(".modal").modal("hide");
        $("#myModal5").modal("show");
        balance_payment_followup();
        setTimeout(function() {
            $(".calender_dashboard").fullCalendar("render");
        }, 300); // Set enough time to wait until animation finishes;
    });

    //Travel button
    $("#btn_load_travel_followup").on("click", function(e) {
        e.preventDefault();
        $(".modal").modal("hide");
        $("#myModal3").modal("show");
        travel_dates_followup();
        setTimeout(function() {
            $(".calender_dashboard").fullCalendar("render");
        }, 300); // Set enough time to wait until animation finishes;
    });


    //payment follow up calendar
    function payment_followup() {
        var base_url = '<?php echo base_url(); ?>'; // Here i define the base_url
        // Fullcalendar
        $('#calendar_payment_followup').fullCalendar({
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            // Get all events stored in database
            displayEventTime: false,
            eventLimit: true, // allow "more" link when too many events
            events: base_url + 'dashboard/getAllPaymentFollowupCalendar',
            selectable: true,
            selectHelper: false,
            editable: false, // Make the event resizable true  
            // resourceGroupField: 'c_id',
            eventRender: function(event, element, view) {
                //console.log(event.id);
                $(element).each(function() {
                    $(this).attr('date-num', event.start.format('YYYY-MM-DD'));
                    $(this).attr('date-event_id', event.id);
                });

                element.find(".fc-event-title").remove();
                element.find(".fc-event-time").remove();
                var new_description =
                    '<span data-event_id ="event_' + event.id + '"> Amount: ' + event.amount +
                    '/-</span><br/>';
                element.append(new_description);
            },
            eventAfterAllRender: function(view) {
                for (cDay = view.start.clone(); cDay.isBefore(view.end); cDay.add(1, 'day')) {
                    var dateNum = cDay.format('YYYY-MM-DD');
                    var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
                    var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
                    var DCount = $('.fc-event[date-event_id="' + dateNum + '"]').length;
                }
            },
        });
    }

    //advance_payment_followup follow up calendar
    function advance_payment_followup() {
        var base_url = '<?php echo base_url(); ?>'; // Here i define the base_url
        // Fullcalendar
        $('#calendar_advance_payment_followup').fullCalendar({
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            // Get all events stored in database
            displayEventTime: false,
            eventLimit: true, // allow "more" link when too many events
            events: base_url +
                'dashboard/advance_payment_pending_followup?type=1', // Type 1 = pay received less than 50%
            selectable: true,
            selectHelper: false,
            editable: false, // Make the event resizable true  
            // resourceGroupField: 'c_id',
            eventRender: function(event, element, view) {
                //console.log(event.id);
                $(element).each(function() {
                    $(this).attr('date-num', event.start.format('YYYY-MM-DD'));
                    $(this).attr('date-event_id', event.id);
                });

                element.find(".fc-event-title").remove();
                element.find(".fc-event-time").remove();
                var new_description =
                    '<span data-event_id ="event_' + event.id + '"> Amount: ' + event.amount +
                    '/-</span><br/>';
                element.append(new_description);
            },
            eventAfterAllRender: function(view) {
                for (cDay = view.start.clone(); cDay.isBefore(view.end); cDay.add(1, 'day')) {
                    var dateNum = cDay.format('YYYY-MM-DD');
                    var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
                    var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
                    var DCount = $('.fc-event[date-event_id="' + dateNum + '"]').length;
                }
            },
        });
    }

    //balance_payment_followup follow up calendar
    function balance_payment_followup() {
        var base_url = '<?php echo base_url(); ?>'; // Here i define the base_url
        // Fullcalendar
        $('#calendar_bal_payment_followup').fullCalendar({
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            // Get all events stored in database
            displayEventTime: false,
            eventLimit: true, // allow "more" link when too many events
            events: base_url +
                'dashboard/advance_payment_pending_followup?type=2', // Type 2 = pay pending less than 50%
            selectable: true,
            selectHelper: false,
            editable: false, // Make the event resizable true  
            // resourceGroupField: 'c_id',
            eventRender: function(event, element, view) {
                //console.log(event.id);
                $(element).each(function() {
                    $(this).attr('date-num', event.start.format('YYYY-MM-DD'));
                    $(this).attr('date-event_id', event.id);
                });

                element.find(".fc-event-title").remove();
                element.find(".fc-event-time").remove();
                var new_description =
                    '<span data-event_id ="event_' + event.id + '"> Amount: ' + event.amount +
                    '/-</span><br/>';
                element.append(new_description);
            },
            eventAfterAllRender: function(view) {
                for (cDay = view.start.clone(); cDay.isBefore(view.end); cDay.add(1, 'day')) {
                    var dateNum = cDay.format('YYYY-MM-DD');
                    var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
                    var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
                    var DCount = $('.fc-event[date-event_id="' + dateNum + '"]').length;
                }
            },
        });
    }

    //Travel Follow Up 
    function travel_dates_followup() {
        var base_url = '<?php echo base_url(); ?>'; // Here i define the base_url
        // Fullcalendar
        $('#calendar_travel_dates').fullCalendar({
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'month, basicWeek, basicDay'
            },
            // Get all events stored in database
            displayEventTime: false,
            eventLimit: true, // allow "more" link when too many events
            events: base_url + 'dashboard/getAllTravelDatesCalendar',
            selectable: true,
            selectHelper: false,
            editable: false, // Make the event resizable true  
            // resourceGroupField: 'c_id',
            eventRender: function(event, element, view) {
                //console.log(event.id);
                $(element).each(function() {
                    $(this).attr('date-num', event.start.format('YYYY-MM-DD'));
                    $(this).attr('date-event_id', event.id);
                });

                element.find(".fc-event-title").remove();
                element.find(".fc-event-time").remove();
                /* var new_description = 
                	'<span data-event_id ="event_'+ event.id +'"> Amount: ' + event.amount + '/-</span><br/>' 
                ;
                element.append(new_description); */
            },
            eventAfterAllRender: function(view) {
                for (cDay = view.start.clone(); cDay.isBefore(view.end); cDay.add(1, 'day')) {
                    var dateNum = cDay.format('YYYY-MM-DD');
                    var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
                    var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
                    var DCount = $('.fc-event[date-event_id="' + dateNum + '"]').length;
                }
            },
        });
    }

});
</script>