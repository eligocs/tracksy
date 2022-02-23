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
<?php $todAy = date("Y-m-d"); ?>
<div class="page-content-wrapper sales_team_dashboard">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
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
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="<?php echo base_url(); ?>">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>

            <?php $user_data = get_user_info(); 
         $h_user_role = isset( $user_data[0]->user_type ) ? $user_data[0]->user_type : "";
         $h_user_id = isset( $user_data[0]->user_id ) ? $user_data[0]->user_id : "";
          
		  //if saleteam user show monthly target
               if( $h_user_role == 99 || $h_user_role == 98   ){
               	$mtarget = (int)get_total_target_by_month(); 
               	$mbooked = (int)get_agents_booked_packages();
               	//$mtarget = 10; 
               	//$mbooked = 10;
               	$percentage =  !empty( $mtarget ) ?  floor(($mbooked / $mtarget) * 100) : 0; ?>
            <div class='header_target_section'>
                <a href="<?php echo base_url("incentive"); ?>" title="Go to incentive page">
                    <div class="progress" style="max-width:100%; min-width:250px;">
                        <span class="target"><span style="color:#6200ff;">Booked: <?php echo $mbooked; ?></span> / <span
                                style="color:red;">Target: <?php echo $mtarget; ?> </span></span>
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                            aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"
                            style="width:<?php echo $percentage; ?>%">
                        </div>
                    </div>
                </a>
            </div>
            <?php }else if( $h_user_role == 96 ){ ?>
            <!--check teamleader-->
            <?php if( !empty( get_teamleader() ) ){
               $team_leader = get_teamleader();
               echo "<div class='header_team-leader-name'>TEAM : <span title='Team Name ( Leader )'>{$team_leader}</span></div>";
               } ?>
            <!--end check teamleader-->
            <?php
               if( is_teamleader() ){ 
               	$agent_in = is_teamleader();
               	$mtarget = (int)get_total_target_by_month( $agent_in ); 
               	$mbooked = (int)get_agents_booked_packages( NULL, NULL, $agent_in );
               	//$mtarget = 10; 
               	//$mbooked = 10;
               	$percentage = !empty( $mtarget ) ? floor( ( $mbooked / $mtarget ) * 100) : 0;
               }else{ 
               	$mtarget = (int)get_agent_monthly_target(); 
               	$mbooked = (int)get_agents_booked_packages();
               	//$mtarget = 10; 
               	//$mbooked = 10;
               	$percentage =  !empty( $mtarget ) ?  floor(($mbooked / $mtarget) * 100) : 0;
               } ?>
            <div class='header_target_section'>
                <a href="<?php echo base_url("incentive"); ?>" title="Go to incentive page">
                    <div class="progress" style="max-width:100%; min-width:250px;">
                        <span class="target"><span style="color:#6200ff;">Booked: <?php echo $mbooked; ?></span> / <span
                                style="color:red;">Target: <?php echo $mtarget; ?> </span></span>
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                            aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100"
                            style="width:<?php echo $percentage; ?>%">
                        </div>
                    </div>
                </a>
            </div>
            <?php }	?>


        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Admin Dashboard
            <small>Users, recent customers and vouchers</small>
        </h1>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS 1-->



        <div class="row">
            <div class="portlet box blue">
                <div class="">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                href="<?php echo site_url("agents?ustatus=active"); ?>">
                                <div class="visual">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($total_agents) ? $total_agents : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Active Users </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 red"
                                href="<?php echo site_url("customers"); ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($total_customers) ? $total_customers : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Total Customers </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 green"
                                href="<?php echo site_url("itineraries"); ?>">
                                <div class="visual">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($total_iti) ? $total_iti : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Total Itineraries </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="callCountBlock">
                            <a class="dashboard-stat dashboard-stat-v2 purple"
                                href="<?php echo site_url("vouchers"); ?>">
                                <div class="visual">
                                    <i class="fa fa-globe"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($total_vouchers) ? $total_vouchers : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Total Vouchers </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- END DASHBOARD STATS 1-->
        </div>
        <div class="clearfix"></div>
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-calendar"></i>Today's Section</div>
            </div>
            <!-- Todays status-->
            <div class="todayssection row">
                <div class="col-lg-4 col-md-4">
                    <div class="callCountBlock">
                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                            href="<?php echo site_url("customers") . "/?todayStatus={$todAy}"; ?>">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup"
                                        data-value="<?php echo isset($totalContLeadsToday) ? $totalContLeadsToday : 0; ?>">0</span>
                                </div>
                                <div class="desc"> Total Leads </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="callCountBlock">
                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 green"
                            href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=callpicked"; ?>">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup"
                                        data-value="<?php echo isset($totalPickCallsToday) ? $totalPickCallsToday : 0 ; ?>">0</span>
                                </div>
                                <div class="desc"> Total Call <br>Picked </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="callCountBlock">
                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                            href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=callnotpicked"; ?>">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup"
                                        data-value="<?php echo isset($totalNotPickCallsToday) ?  $totalNotPickCallsToday : 0; ?>">0</span>
                                </div>
                                <div class="desc"> Total Call <br>Not Picked </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="callCountBlock">
                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                            href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=8"; ?>">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup"
                                        data-value="<?php echo isset($totalDecLeadsToday) ? $totalDecLeadsToday : 0; ?>">0</span>
                                </div>
                                <div class="desc"> Total Declined <br>Leads </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="callCountBlock">
                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                            href="<?php echo site_url("customers"). "/?todayStatus={$todAy}&leadStatus=unwork"; ?>">
                            <div class="visual">
                                <i class="fa fa-bar-chart-o"></i>
                            </div>
                            <div class="details">
                                <div class="number">
                                    <span data-counter="counterup"
                                        data-value="<?php echo isset($totalUnworkLeadsToday) ? $totalUnworkLeadsToday : 0; ?>">0</span>
                                </div>
                                <div class="desc"> Unwork<br> Leads </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- <div class="clearfix"></div> -->
                <div id="todays_full_stats" style="display: block;">
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                href="<?php echo site_url("indiatourizm"). "/?todayStatus={$todAy}"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($today_ind_tour_query) ? $today_ind_tour_query : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Leads </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 green"
                                href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=Qsent&quotation=true"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($totalQuotSentToday) ? $totalQuotSentToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Quotations<br> Sent </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=pending"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($totalWorkingItiToday) ? $totalWorkingItiToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Total Working <br>Itineraries </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 green"
                                href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=9"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($totalApprovedItiToday) ? $totalApprovedItiToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Total Approved <br>Itineraries </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                                href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=7"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($totalDecItiToday) ? $totalDecItiToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Total Declined <br>Itineraries </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- <div class="clearfix"></div> -->
                </div>
                <!--Todays full stat -->
                <!-- <div class="clearfix"></div> -->
                <!---------------------------------Revised section ---------------------------->
                <div class="today_revised_section">
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                                href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=QsentPast&quotation=true"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($pastQuotSentToday) ? $pastQuotSentToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc"> Revised Quotations <br> Sent </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=revApproved"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($pastApprovedItiToday) ? $pastApprovedItiToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc">Revised Approved <br>Itineraries </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                                href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=revDecline"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($pastDeclineItiToday) ? $pastDeclineItiToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc">Revised Declined <br>Itineraries </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="callCountBlock">
                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=revDeclineLeads"; ?>">
                                <div class="visual">
                                    <i class="fa fa-bar-chart-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="<?php echo isset($pastDecLeadsToday) ? $pastDecLeadsToday : 0; ?>">0</span>
                                    </div>
                                    <div class="desc">Declined <br>Revised Leads </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!---------------------------------End Todays Revised section ---------------------------->
                <div class="clearfix"></div>
            </div>
            <!-- End Today section -->
        </div>
        <!--portlet close -->
        <!--PENDING PRICE SECTION-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption"><i class="fa fa-inr"></i>RATES SECTION</div>
            </div>
            <div class="portlet-body">
                <div class="row dashboard-tables-all-info">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading2">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#ratestab1" data-toggle="tab">ABOVE 40000.00/- PACKAGES (ON WORKING)</a></li>
                                    <li><a href="#ratestab2" data-toggle="tab">RATES REQUEST BY MANAGER</a></li>
                                </ul>
                            </div>
                            <div class="panel-body padding-0">
                                 <div class="dashboard-scroll">
                                    <div class="tab-content">
                                          <div class="tab-pane fade in active" id="ratestab1">
                                             <table class="table table-hover d-table table-fixed">
                                                <tr>
                                                      <th>Sr.</th>
                                                      <th>Name</th>
                                                      <th>Contact No</th>
                                                      <th>Rate</th>
                                                      <th>Agent</th>
                                                      <th>Action</th>
                                                </tr>
                                                <?php if( isset( $above_fourty_thousand_wrk_pkg ) && !empty($above_fourty_thousand_wrk_pkg) ) { 
                                                   $p_count1 = 1;
                                                   foreach( $above_fourty_thousand_wrk_pkg as $a_forty_pkg ){ 
                                                      $iti_type =  "<span class='lead_app arrow_bottom red_row' title='Iti Type'>".check_iti_type($a_forty_pkg->iti_id)."</span>";
                                                      $get_customer_info = get_customer( $a_forty_pkg->customer_id ); 
                                                      $cust = $get_customer_info[0];
                                                      $cust_name = !empty($cust) ? $cust->customer_name : "";
                                                      $cust_no = !empty($cust) ? $cust->customer_contact : "";
                                                      $agent_id = $a_forty_pkg->agent_id;
                                                      $a_user_name = get_user_name($agent_id);
                                          
                                                   ?>
                                                <tr>
                                                      <td colspan="5"><span
                                                            class="lead_app arrow_bottom"><?php echo $a_forty_pkg->package_name;?></span>
                                                         <?php echo $iti_type; ?></td>
                                                </tr>
                                                <tr class="">
                                                      <td><?php echo $p_count1;?>.</td>
                                                      <td><?php echo $cust_name;?></td>
                                                      <td><?php echo $cust_no;?></td>
                                                      <td><?php echo $a_forty_pkg->MAXP; ?> /-</td>
                                                      <td><?php echo $a_user_name;?></td>
                                                      <td><a class="btn btn-custom" target="_blank"
                                                            href="<?php echo site_url("itineraries/view/{$a_forty_pkg->iti_id}/{$a_forty_pkg->temp_key}"); ?>">
                                                            View</a> </td>
                                                </tr>
                                                <?php 
                                                   $p_count1++;
                                                   } 
                                                   }else{ ?>
                                                   <tr>
                                                      <td colspan="5" class="text-center">
                                                         <div class="mt-comment-text"> No Data found. </div>
                                                      </td>
                                                   </tr>
                                                   <?php } ?>
                                             </table>
                                             <button type="button" class="btn btn_blue_outline view_table_data"><i
                                                class="fa fa-angle-down"></i> View All</button>
                                          </div>
                                          <div class="tab-pane fade" id="ratestab2">
                                          <table class="table table-hover d-table table-fixed">
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th>Name</th>
                                                    <th>Contact No</th>
                                                    <th>Agent</th>
                                                    <th>Action</th>
                                                </tr>
                                                <?php if( isset($itiPendingRates_Manager) && !empty($itiPendingRates_Manager) ) { 
                                                   $p_count = 1;
                                                   foreach( $itiPendingRates_Manager as $pendingRates_m ){ 
                                                      $iti_type =  "<span class='lead_app arrow_bottom red_row' title='Iti Type'>".check_iti_type($pendingRates_m->iti_id)."</span>";
                                                      $reject_btn = $pendingRates_m->iti_status == 6 ? "<span class='lead_app arrow_bottom red_row' title='Rejected Itinerary'>Rejected</span>" : "";
                                                         $get_customer_info = get_customer( $pendingRates_m->customer_id ); 
                                                         $cust = $get_customer_info[0];
                                                      
                                                         $cust_name = !empty($cust) ? $cust->customer_name : "";
                                                         $cust_no = !empty($cust) ? $cust->customer_contact : "";
                                                   
                                                         $agent_id = $pendingRates_m->agent_id;
                                                         $user_info = get_user_info($agent_id);
                                                         if($user_info){
                                                            $agent = $user_info[0];
                                                            $a_name = $agent->first_name . " " . $agent->last_name;
                                                         }	
                                                      ?>
                                                      <tr>
                                                         <td colspan="5"><span
                                                                  class="lead_app arrow_bottom"><?php echo $pendingRates_m->package_name;?></span>
                                                            <?php echo $reject_btn;?> <?php echo $iti_type; ?></td>
                                                      </tr>
                                                      <tr class="">
                                                         <td><?php echo $p_count;?>.</td>
                                                         <td><?php echo $cust_name;?></td>
                                                         <td><?php echo $cust_no;?></td>
                                                         <td><?php echo $a_name;?></td>
                                                         <td><a class="btn btn-custom" target="_blank"
                                                                  href="<?php echo site_url("itineraries/view/{$pendingRates_m->iti_id}/{$pendingRates_m->temp_key}"); ?>">
                                                                  View</a> </td>
                                                      </tr>
                                                      <?php //check for child itinerary
                                                      $child_iti = check_child_iti( $pendingRates_m->iti_id );
                                                      $count_records = count( $child_iti ) ; 
                                                      //if child iti exists
                                                      if( !empty( $child_iti ) && $count_records > 1 ){
                                                         $cl = 1;
                                                            ?>
                                                   <tr>
                                                      <td colspan="4">
                                                         <?php foreach( $child_iti as $c_iti ){ ?>
                                                         <?php if( $cl == 1 ){ ?>
                                                         <a class="btn btn-custom" target="_blank"
                                                               href="<?php echo site_url("itineraries/view/{$c_iti->iti_id}/{$c_iti->temp_key}"); ?>">View
                                                               Parent <strong><?php echo $c_iti->iti_id; ?></strong></a>
                                                         <?php }else{ ?>
                                                         <a class="btn btn-custom" target="_blank"
                                                               href="<?php echo site_url("itineraries/view/{$c_iti->iti_id}/{$c_iti->temp_key}"); ?>">View
                                                               Child <strong><?php echo $c_iti->iti_id; ?></strong></a>
                                                         <?php } ?>
                                                         <?php 
                                                         $cl++;
                                                         } ?>
                                                      </td>
                                                   </tr>
                                                <?php } ?>
                                                <?php 
                                                   $p_count++;
                                                   } 
                                                   }else{ ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <div class="mt-comment-text"> No Data found. </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </table>
                                            <button type="button" class="btn btn_blue_outline view_table_data"><i
                                            class="fa fa-angle-down"></i> View All</button>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--END PENDING PRICE SECTION-->
        <div class="clearfix"></div>
        <hr>
        <!--MONTH SECTION-->
        <div class="total-leads-for-month">
            <div class="month_section">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-handshake-o" aria-hidden="true"></i> Month's Status</div>
                        <button type="button" data-target_id="month_full_stat"
                            class="btn btn_blue_outline purple view_all_stat_btn pull-right" style="margin-top: 3px;">
                            <i class="fa fa-angle-down"></i> View All Stats
                        </button>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4">
                                <div class="callCountBlock">
                                    <a target="_blank" class="dashboard-stat dashboard-stat-v2 green"
                                        href="<?php echo site_url("customers") . "/?leadfrom={$from}&leadto={$to}"; ?>">
                                        <div class="visual">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup"
                                                    data-value="<?php echo isset($totalLeadsMonth) ? $totalLeadsMonth : 0; ?>">0</span>
                                            </div>
                                            <div class="desc"> Total Leads<br> </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="callCountBlock">
                                    <a target="_blank" class="dashboard-stat dashboard-stat-v2 green"
                                        href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=callpicked"; ?>">
                                        <div class="visual">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup"
                                                    data-value="<?php echo isset($totalPickCallsMonth) ? $totalPickCallsMonth : 0; ?>">0</span>
                                            </div>
                                            <div class="desc"> Total Call <br>Picked </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="callCountBlock">
                                    <a target="_blank" class="dashboard-stat dashboard-stat-v2 green"
                                        href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=callnotpicked"; ?>">
                                        <div class="visual">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup"
                                                    data-value="<?php echo isset($totalNotPickCallsMonth) ? $totalNotPickCallsMonth : 0; ?>">0</span>
                                            </div>
                                            <div class="desc"> Total Call <br>Not Picked </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="callCountBlock">
                                    <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                        href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=8"; ?>">
                                        <div class="visual">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup"
                                                    data-value="<?php echo isset($totalDecLeadsMonth) ? $totalDecLeadsMonth : 0; ?>">0</span>
                                            </div>
                                            <div class="desc"> Total Declined <br>Leads </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="callCountBlock">
                                    <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                                        href="<?php echo site_url("customers"). "/?todayStatus={$this_month}&leadStatus=unwork"; ?>">
                                        <div class="visual">
                                            <i class="fa fa-bar-chart-o"></i>
                                        </div>
                                        <div class="details">
                                            <div class="number">
                                                <span data-counter="counterup"
                                                    data-value="<?php echo isset($totalUnworkLeadsMonth) ? $totalUnworkLeadsMonth : 0; ?>">0</span>
                                            </div>
                                            <div class="desc"> Total Unwork<br> Leads </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!-- <div class="clearfix"></div> -->
                            <!-- <div class="load-more-dashboard text-center">
                        <button type="button" data-target_id="month_full_stat" class="btn pulse purple view_all_stat_btn"><i class="fa fa-angle-down"></i> View All Stats</button>
                     </div> -->
                            <div id="month_full_stat" style="display: none;">
                                <div class="col-lg-4 col-md-4">
                                    <div class="callCountBlock">
                                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                                            href="<?php echo site_url("itineraries"). "/?todayStatus={$this_month}&leadStatus=Qsent&quotation=true"; ?>">
                                            <div class="visual">
                                                <i class="fa fa-bar-chart-o"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    <span data-counter="counterup"
                                                        data-value="<?php echo isset($totalQuotSentMonth) ? $totalQuotSentMonth : 0; ?>">0</span>
                                                </div>
                                                <div class="desc"> Quotations<br> Sent </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="callCountBlock">
                                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                            href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=pending"; ?>">
                                            <div class="visual">
                                                <i class="fa fa-bar-chart-o"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    <span data-counter="counterup"
                                                        data-value="<?php echo isset($totalWorkingItiMonth) ? $totalWorkingItiMonth : 0; ?>">0</span>
                                                </div>
                                                <div class="desc"> Total Working <br>Itineraries </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="callCountBlock">
                                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                            href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=9"; ?>">
                                            <div class="visual">
                                                <i class="fa fa-bar-chart-o"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    <span data-counter="counterup"
                                                        data-value="<?php echo isset($totalApprovedItiMonth) ? $totalApprovedItiMonth : 0; ?>">0</span>
                                                </div>
                                                <div class="desc"> Total Approved <br>Itineraries</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="callCountBlock">
                                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                            href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=7"; ?>">
                                            <div class="visual">
                                                <i class="fa fa-bar-chart-o"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    <span data-counter="counterup"
                                                        data-value="<?php echo isset($totalDecItiMonth) ? $totalDecItiMonth : 0; ?>">0</span>
                                                </div>
                                                <div class="desc"> Total Declined <br>Itineraries</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="callCountBlock">
                                        <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                            href="<?php echo site_url("itineraries"). "/?todayStatus={$this_month}&leadStatus=QsentRevised&quotation=true"; ?>">
                                            <div class="visual">
                                                <i class="fa fa-bar-chart-o"></i>
                                            </div>
                                            <div class="details">
                                                <div class="number">
                                                    <span data-counter="counterup"
                                                        data-value="<?php echo isset($totalRevQuotSentMonth) ? $totalRevQuotSentMonth : 0; ?>">0</span>
                                                </div>
                                                <div class="desc"> Revised Quotations <br> Sent </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!-- <div class="clearfix"></div> -->
                                <!---------------------------------Revised section Month---------------------------->
                                <div class="month_revised_section">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="callCountBlock">
                                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                                                href="<?php echo site_url("itineraries"). "/?leadfrom={$from}&leadto={$to}&leadStatus=QsentPastMonth&quotation=true"; ?>">
                                                <div class="visual">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                                <div class="details">
                                                    <div class="number">
                                                        <span data-counter="counterup"
                                                            data-value="<?php echo isset($pastQuotSentMonth) ? $pastQuotSentMonth : 0; ?>">0</span>
                                                    </div>
                                                    <div class="desc"> Revised Quotations <br> Sent </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="callCountBlock">
                                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 blue"
                                                href="<?php echo site_url("itineraries") . "/?leadfrom={$from}&leadto={$to}&leadStatus=revApprovedMonth"; ?>">
                                                <div class="visual">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                                <div class="details">
                                                    <div class="number">
                                                        <span data-counter="counterup"
                                                            data-value="<?php echo isset($pastApprovedItiMonth) ? $pastApprovedItiMonth : 0; ?>">0</span>
                                                    </div>
                                                    <div class="desc"> Total Revised Approved <br>Itineraries </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="callCountBlock">
                                            <a target="_blank" class="dashboard-stat dashboard-stat-v2 purple"
                                                href="<?php echo site_url("itineraries") . "/?leadfrom={$from}&leadto={$to}&leadStatus=revDeclineMonth"; ?>">
                                                <div class="visual">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                                <div class="details">
                                                    <div class="number">
                                                        <span data-counter="counterup"
                                                            data-value="<?php echo isset($pastDeclineItiMonth) ? $pastDeclineItiMonth : 0; ?>">0</span>
                                                    </div>
                                                    <div class="desc"> Total Revised Declined <br>Itineraries </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="callCountBlock">
                                            <a class="dashboard-stat dashboard-stat-v2 blue"
                                                href="<?php echo site_url("customers") . "/?leadfrom={$from}&leadto={$to}&leadStatus=revDeclineLeadsMonth"; ?>">
                                                <div class="visual">
                                                    <i class="fa fa-bar-chart-o"></i>
                                                </div>
                                                <div class="details">
                                                    <div class="number">
                                                        <span data-counter="counterup"
                                                            data-value="<?php echo isset($pastDecLeadsMonth) ? $pastDecLeadsMonth : 0; ?>">0</span>
                                                    </div>
                                                    <div class="desc"> Total Revised Declined <br>Leads </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End month full stats-->
                        </div>
                        <!-- row -->
                    </div>
                    <!-- portlet-body -->
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- END CONTENT BODY -->
        <?php $get_agents = get_all_sales_team_agents(); ?>
        <!--Chart Section-->
        <div class="col-md-12 padding_zero">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-bar-chart" style="font-size:18px;"></i>
                        <span class="caption-subject bold uppercase">Statistics</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="titile_section">
                        <h3 class="col-lg-12">ITINERARIES GRAPH</h3>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Agent:</label>
                            <select class="form-control" id="agent_graph">
                                <option value="">All Agents</option>
                                <?php 			
                           if( $get_agents ){
                           foreach( $get_agents as $agent) {
                           	echo "<option value={$agent->user_id} >{$agent->user_name}</option>";
                           }
                           }
                           ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 pull-right">
                            <label for="sel1">Select Year:</label>
                            <select class="form-control" id="year_iti">
                                <?php 			
                        $current_year = date('Y');
                        	for( $year = 2017; $year <=  $current_year; $year++ ) {
                        		$selected = $year == $current_year ? 'selected = selected' : '';
                        		echo "<option value={$year} {$selected} >{$year}</option>";
                        	}
                        ?>
                            </select>
                        </div>
                    </div>
                    <div class="portlet-body card-padding">
                        <div class="loader_iti processer"><img class="img-responsive"
                                src="<?php echo base_url();?>site/images/loader.gif" /></div>
                        <div id="iti_echarts_bar" style="height:400px;"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="titile_section">
                        <h3 class="col-lg-12">LEADS GRAPH</h3>
                        <div class="form-group col-lg-6">
                            <label for="sel1">Select Agent:</label>
                            <select class="form-control" id="agent_graph">
                                <option value="">All Agents</option>
                                <?php
                           if( $get_agents ){
                           foreach( $get_agents as $agent) {
                           	echo "<option value={$agent->user_id} >{$agent->user_name}</option>";
                           }
                           }
                           ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 pull-right">
                            <label for="seld1">Select Year:</label>
                            <select class="form-control" id="year_leads">
                                <?php 			
                        $current_year = date('Y');
                        	for( $year1 = 2017; $year1 <=  $current_year; $year1++ ) {
                        		$selected = $year1 == $current_year ? 'selected = selected' : '';
                        		echo "<option value={$year1} {$selected} >{$year1}</option>";
                        	}
                        ?>
                            </select>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="loader_lead processer"><img class="img-responsive"
                                src="<?php echo base_url();?>site/images/loader.gif" /></div>
                        <div id="leads_echarts_bar" style="height:400px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <br>
        <br>
        <br>
        <br>
    </div>
    <!--End Chart Section-->
</div>
<!-- END CONTENT -->
<!-- END QUICK SIDEBAR -->
</div>
</div>
<!-- END CONTAINER -->
<!--angular js-->
<script>
/* var url = "<?php echo base_url("angular/admin_dashboard"); ?>";
   var app = angular.module('myApp', []);
   app.controller('dashboardCtrl', function($scope, $http) {
   	    console.info('error'); 
   
   	$http.get(url)
   	.then(function(response) {
   		console.log( response.data.total_agents );
   		$scope.total_agents = response.data.total_agents;
   	});
   }); */
</script>