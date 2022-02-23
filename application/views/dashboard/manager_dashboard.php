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
<!-- BEGIN CONTENT User Role: 96 -->
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
                  <li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
                  <li class="color-darkblue tooltips" data-style="theme_dark" data-container="body" data-original-title="Theme Dark"> </li>
                  <li class="color-blue tooltips" data-style="theme_light" data-container="body" data-original-title="Theme Light"> </li>
               </ul>
            </div>
            <div class="th_response"></div>
         </div>
      </div>
      <!--div class="more-info-right-sidebar">
         <button class="btn blue sidebar-button btn-side-1" data-toggle="modal" data-target="#myModal1"><i class="fa fa-users"></i> Lead Follow Up</button>
         <button class="btn blue sidebar-button btn-side-2" data-toggle="modal" data-target="#myModal2"><i class="fa fa-map"></i> Holiday Follow Up</button>
         </div-->	
      <nav class="quick-nav">
         <a class="quick-nav-trigger" href="javascript: void(0)">
         <span aria-hidden="true"></span>
         </a>
         <ul class="sidebar-buttons">
            <li><button class="btn sidebar-button btn-side-1 cal_toggle_btn" data-target="myModal1"><i class="fa fa-users"></i> Lead Follow Up</button></li>
            <!--li><button class="btn sidebar-button btn-side-2 cal_toggle_btn" data-target="myModal2"><i class="fa fa-map"></i> Holiday Follow Up</button></li-->
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
      <h1 class="page-title"> Manager Dashboard</h1>
      <div class="portlet box blue">
         <div class="portlet-title">
            <div class="caption"><i class="fa fa-calendar"></i>Today's Status</div>
         </div>
         <!-- Todays status-->
         <div class="todayssection">
            <div class="col-md-20">
               <div class="callCountBlock">
                  <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}"; ?>">
                     <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                     </div>
                     <div class="details">
                        <div class="number">
                           <span data-counter="counterup" data-value="<?php echo isset($totalContLeadsToday) ? $totalContLeadsToday : 0; ?>">0</span> 
                        </div>
                        <div class="desc"> Total Leads  </div>
                     </div>
                  </a>
               </div>
            </div>
            <div class="col-md-20">
               <div class="callCountBlock">
                  <a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=callpicked"; ?>">
                     <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                     </div>
                     <div class="details">
                        <div class="number">
                           <span data-counter="counterup" data-value="<?php echo isset($totalPickCallsToday) ? $totalPickCallsToday : 0 ; ?>">0</span> 
                        </div>
                        <div class="desc"> Total Call <br>Picked  </div>
                     </div>
                  </a>
               </div>
            </div>
            <div class="col-md-20">
               <div class="callCountBlock">
                  <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=callnotpicked"; ?>">
                     <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                     </div>
                     <div class="details">
                        <div class="number">
                           <span data-counter="counterup" data-value="<?php echo isset($totalNotPickCallsToday) ?  $totalNotPickCallsToday : 0; ?>">0</span> 
                        </div>
                        <div class="desc"> Total Call <br>Not Picked  </div>
                     </div>
                  </a>
               </div>
            </div>
            <div class="col-md-20">
               <div class="callCountBlock">
                  <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=8"; ?>">
                     <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                     </div>
                     <div class="details">
                        <div class="number">
                           <span data-counter="counterup" data-value="<?php echo isset($totalDecLeadsToday) ? $totalDecLeadsToday : 0; ?>">0</span> 
                        </div>
                        <div class="desc"> Total Declined <br>Leads  </div>
                     </div>
                  </a>
               </div>
            </div>
            <div class="col-md-20">
               <div class="callCountBlock">
                  <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("customers"). "/?todayStatus={$todAy}&leadStatus=unwork"; ?>">
                     <div class="visual">
                        <i class="fa fa-bar-chart-o"></i>
                     </div>
                     <div class="details">
                        <div class="number">
                           <span data-counter="counterup" data-value="<?php echo isset($totalUnworkLeadsToday) ? $totalUnworkLeadsToday : 0; ?>">0</span> 
                        </div>
                        <div class="desc"> Unwork<br> Leads  </div>
                     </div>
                  </a>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="load-more-dashboard text-center">
               <button type="button" data-target_id="todays_full_stats" class="btn_blue_outline btn  pulse view_all_stat_btn"><i class="fa fa-angle-down"></i> View All Stats</button>
            </div>
            <div id="todays_full_stats" style="display: none;">
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=Qsent&quotation=true"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalQuotSentToday) ? $totalQuotSentToday : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Quotations<br> Sent  </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=pending"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalWorkingItiToday) ? $totalWorkingItiToday : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Total Working <br>Itineraries  </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=9"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalApprovedItiToday) ? $totalApprovedItiToday : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Total Approved <br>Itineraries  </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=7"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalDecItiToday) ? $totalDecItiToday : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Total Declined <br>Itineraries  </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=QsentRevised&quotation=true"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalRevQuotSentToday) ? $totalRevQuotSentToday : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Revised Quotations <br> Sent  </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="clearfix"></div>
               <hr>
               <!---------------------------------Revised section ---------------------------->
               <div class="today_revised_section">
                  <div class="col-md-3">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=QsentPast&quotation=true"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($pastQuotSentToday) ? $pastQuotSentToday : 0; ?>">0</span> 
                              </div>
                              <div class="desc"> Revised Quotations <br> Sent  </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=revApproved"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($pastApprovedItiToday) ? $pastApprovedItiToday : 0; ?>">0</span> 
                              </div>
                              <div class="desc">Revised Approved <br>Itineraries  </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=revDecline"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($pastDeclineItiToday) ? $pastDeclineItiToday : 0; ?>">0</span> 
                              </div>
                              <div class="desc">Revised Declined <br>Itineraries  </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=revDeclineLeads"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($pastDecLeadsToday) ? $pastDecLeadsToday : 0; ?>">0</span> 
                              </div>
                              <div class="desc">Declined <br>Revised Leads  </div>
                           </div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <!--Todays full stat -->	
            <!---------------------------------End Todays Revised section ---------------------------->
            <div class="clearfix"></div>
         </div>
         <!-- End Today section -->
      </div>
      <!--portlet close -->
      <div class="clearfix"></div>
      <?php /*
         <!--AMENDMENT PRICE SECTION-->
         <div class="portlet box blue">
         	<div class="portlet-title">
         		<div class="caption"><i class="fa fa-handshake-o" aria-hidden="true"></i> ON HOLD ITINERARIES SECTION</div>
         	</div>
         	<div class="portlet-body">
         	<div class="row dashboard-tables-all-info">
         		<div class="col-lg-6 col-xs-12 col-sm-12">
         			<div class="portlet light bordered">
         				<div class="portlet-title" style="background: red;">
         					<div class="caption">
         						<i class="icon-equalizer font-dark hide"></i>
         						<span class="caption-subject font-dark bold uppercase">ON HOLD ITINERARIES</span>
         					</div>
         				</div>
         				<div class="portlet-body">
         					<div class="tab-content">
         						<div class="tab-pane active" id="tab_actions_pending pending-rate1">
         							<?php //print_r( $itiPendingRates ); ?>
      <div class="dashboard-scroll">
         <table class="table table-hover d-table table-fixed">
            <tr>
               <th>Name</th>
               <th>Package</th>
               <th>Agent</th>
               <th>Action</th>
            </tr>
            <?php if( isset($on_hold_itineraries) && !empty($on_hold_itineraries) ) { 
               foreach( $on_hold_itineraries as $onhold ){ 
               	$iti_type =  "<span class='lead_app arrow_bottom red_row' title='Iti Type'>".check_iti_type($onhold->iti_id )."</span>";
               	$view_link = site_url("itineraries/view/{$onhold->iti_id}/{$onhold->temp_key}#update_iti_hold_status");
               	?>
            <tr>
               <td colspan="4"><span class="lead_app arrow_bottom"><?php echo $onhold->package_name; ?></span><?php echo $iti_type; ?></td>
            </tr>
            <tr>
               <td><?php echo $onhold->customer_name; ?></td>
               <td><?php echo $onhold->package_name; ?></td>
               <td><?php echo get_user_name( $onhold->agent_id ); ?></td>
               <td><a class="btn btn-custom" target="_blank" href="<?php echo $view_link; ?>">View</a></td>
            </tr>
            <?php } 
               }else{ ?>	
            <tr>
               <td colspan="4" class="text-center">
                  <div class="mt-comment-text"> No Data found. </div>
               </td>
            </tr>
            <?php } ?> 
         </table>
      </div>
   </div>
   <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div> */ ?>
<!--end on hold iti section-->
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->
<!--AMENDMENT PRICE SECTION-->
<div class="portlet box blue">
   <div class="portlet-title">
      <div class="caption"><i class="fa fa-handshake-o" aria-hidden="true"></i> AMENDMENT SECTION</div>
   </div>
   <div class="portlet-body">
      <div class="row dashboard-tables-all-info">
         <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-equalizer font-dark hide"></i>
                     <span class="caption-subject font-dark bold uppercase">AMENDMENT PENDING RATES</span>
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="tab-content">
                     <div class="tab-pane active" id="tab_actions_pending pending-rate1">
                        <?php //print_r( $itiPendingRates ); ?>
                        <div class="dashboard-scroll">
                           <table class="table table-hover d-table table-fixed">
                              <tr>
                                 <th>Name</th>
                                 <th>Package</th>
                                 <th>Agent</th>
                                 <th>Action</th>
                              </tr>
                              <?php if( isset($amendmentPendingRates) && !empty($amendmentPendingRates) ) { 
                                 foreach( $amendmentPendingRates as $aRates ){ 
                                 	$iti_type =  "<span class='lead_app arrow_bottom red_row' title='Iti Type'>".check_iti_type($aRates->iti_id)."</span>";
                                 
                                 ?>
                              <tr>
                                 <td colspan="4"><span class="lead_app arrow_bottom"><?php echo $aRates->package_name; ?></span><?php echo $iti_type; ?></td>
                              </tr>
                              <tr>
                                 <td><?php echo $aRates->customer_name; ?></td>
                                 <td><?php echo $aRates->package_name; ?></td>
                                 <td><?php echo get_user_name($aRates->agent_id); ?></td>
                                 <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view_amendment/{$aRates->id}"); ?>">View</a></td>
                              </tr>
                              <?php } 
                                 }else{ ?>	
                              <tr>
                                 <td colspan="4" class="text-center">
                                    <div class="mt-comment-text"> No Data found. </div>
                                 </td>
                              </tr>
                              <?php } ?> 
                           </table>
                        </div>
                     </div>
                     <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="icon-equalizer font-dark hide"></i>
                     <span class="caption-subject font-dark bold uppercase">AMENDMENT APPROVED RATES</span>
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="tab-content">
                     <div class="tab-pane active" id="tab_actions_pending approved-rate1">
                        <div class="dashboard-scroll">
                           <table class="table table-bordered table-striped d-table table-fixed">
                              <thead>
                                 <tr>
                                    <th>Name</th>
                                    <th>Package</th>
                                    <th>Agent</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php if( isset($amendmentAprRates) && !empty($amendmentAprRates) ) { 
                                    foreach( $amendmentAprRates as $apRates ){ 	?>
                                 <tr>
                                    <td colspan="4"><span class="lead_app arrow_bottom"><?php echo $apRates->package_name; ?></span></td>
                                 </tr>
                                 <tr>
                                    <td><?php echo $apRates->customer_name; ?></td>
                                    <td><?php echo $apRates->package_name; ?></td>
                                    <td><?php echo get_user_name($apRates->agent_id); ?></td>
                                    <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view_amendment/{$apRates->id}"); ?>">View</a></td>
                                 </tr>
                                 <?php } 
                                    }else{ ?>	
                                 <tr>
                                    <td colspan="4" class="text-center">
                                       <div class="mt-comment-text"> No Data found. </div>
                                    </td>
                                 </tr>
                                 <?php } ?> 
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>									
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="clearfix"></div>
<!--END AMENDMENT PRICE SECTION-->
<div class="portlet box blue">
   <div class="portlet-title">
      <div class="caption"><i class="fa fa-handshake-o" aria-hidden="true"></i> Follow Up Section</div>
   </div>
   <div class="portlet-body">
      <div class="row dashboard-tables-all-info">
         <?php /*
            <!-- Total Leads of the Day -->
            <div class="col-lg-6 col-xs-12 col-sm-12">
            	<div class="portlet light bordered">
            		<div class="portlet-title">
            			<div class="caption">
            				<i class="icon-equalizer font-dark hide"></i>
            				<span class="caption-subject font-dark bold uppercase">Total Leads Of The Day</span>
            			</div>
            			<!--div class="tools title-cover">
            				<a href="" class="expand "><i class="fa a-arrow-circle-down"></i> </a>
            			</div-->
            		</div>
            
            
            		<!--div class="portlet-title tabbable-line">
            			<div class="caption">
            				<i class="icon-bubbles font-dark hide"></i>
            				<span class="caption-subject font-dark bold uppercase">Total Leads Of The Day</span>
            			</div>
            		</div-->
            		<div class="portlet-body"  >
            		<div class="dashboard-scroll">
            			<div class="tab-content">
            				<div class="tab-pane active" id="portlet_comments_1">
            				<table class="table table-hover d-table">
            					<tr>
            						<th>Sr.</th>
            						<th>Name</th>
            						<th>Contact No</th>
            						<th>Agent</th>
            						<th>Action</th>
            					
            					</tr>
            					<?php if( isset($totalLeadsToday) && !empty($totalLeadsToday) ) { 
               $il = 1;	
               foreach( $totalLeadsToday as $t_leads ){ ?>	
         <tr>
            <td><?php echo $il;?></td>
            <td><?php echo $t_leads->customer_name;?></td>
            <!--td><?php //echo $t_leads->customer_email;?></td-->
            <td><?php echo $t_leads->customer_contact;?></td>
            <td><?php echo get_user_name( $t_leads->agent_id);?></td>
            <td><a class="btn btn-custom" href="<?php echo site_url("customers/view/{$t_leads->customer_id}/{$t_leads->temp_key}"); ?>"> View</a></td>
         </tr>
         <?php $il++; } 
            }else{ ?>	
         <tr>
            <td colspan="5" class="text-center">
               <div class="mt-comment-text"> No Data found. </div>
            </td>
         </tr>
         <?php } ?>
         <!-- END: Picked call section -->
         </table>
      </div>
      <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
   </div>
</div>
</div>
</div>
</div>
<div class="col-lg-6 col-xs-12 col-sm-12">
   <div class="portlet light bordered">
      <div class="portlet-title">
         <div class="caption">
            <i class="icon-equalizer font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Follow up of the day</span>
         </div>
      </div>
      <div class="portlet-body">
         <div class="tab-content">
            <div class="tab-pane active" id="portlet_comments_1">
               <div class="dashboard-scroll">
                  <table class="table table-hover d-table">
                     <tr>
                        <th>Sr.</th>
                        <th>Name</th>
                        <th>Contact No</th>
                        <th>Call Date</th>
                        <th>Call Time</th>
                        <th>Agent</th>
                        <th>Action</th>
                     </tr>
                     <?php if( isset($leadsFollowupToday) && !empty($leadsFollowupToday) ) { 
                        //dump( $leadsFollowupToday );
                        	$ic = 1;	
                        	foreach( $leadsFollowupToday as $followToday ){ ?>	
                     <?php if( $followToday->callType == "9" ){
                        $cc = "<span class='lead_app arrow_bottom'>Leads Approved</span>";
                        }elseif( $followToday->callType == 8 ){
                        	$cc = "<span class='lead_declined arrow_bottom'>Leads Declined</span>";
                        }elseif( $followToday->callType == "Picked call" ){
                        	$cc = "<span class='c_picked arrow_bottom'> ". $followToday->callType . "</span>";
                        }else{
                        	$cc = "<span class='c_npicked arrow_bottom'>" . $followToday->callType . "</span>";
                        } 
                        
                        //check if multi followToday
                        $checkFollow = repeat_followup_today_by_customer_id( $followToday->customer_id );
                        $red_class = !empty( $checkFollow ) && $checkFollow > 1 ? "repeat_follow" : "";
                        
                        $get_customer_info = get_customer( $followToday->customer_id ); 
                        $cust = $get_customer_info[0];
                        if( !empty( $get_customer_info ) ){
                        	
                        	$c_name = $cust->customer_name;											
                        	$c_number= $cust->customer_contact;
                        } 
                        $d = explode(' ',$followToday->nextCallDate);
                        ?>
                     <tr>
                        <td colspan="7"><?php echo $cc; ?></td>
                     </tr>
                     <tr class="<?php echo $red_class; ?>">
                        <td><?php echo $ic;?>.</td>
                        <td><?php echo $c_name;?></td>
                        <td><?php echo $c_number;?></td>
                        <td><?php echo $d[0];?></td>
                        <td><?php echo $d[1]. ' '.$d[2];?></td>
                        <td><?php echo get_user_name($followToday->agent_id);?></td>
                        <td><a target="_blank" class="btn btn-custom" href="<?php echo site_url("customers/view/{$followToday->customer_id}/{$followToday->temp_key}"); ?>"> View</a></td>
                     </tr>
                     <?php $ic++; } 
                        }else{ ?>	
                     <tr>
                        <td colspan="7">
                           <div class="mt-comment-text"> No Data found. </div>
                        </td>
                     </tr>
                     <?php } ?>
                     <!-- END: Picked call section -->
                  </table>
               </div>
            </div>
            <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
         </div>
      </div>
   </div>
</div>
<div class="clearfix"></div>
*/ ?>
<?php /*
   <!-- Itineraries FollowUP Today -->
   <div class="col-lg-12 col-xs-12 col-sm-12">
   	<div class="portlet light bordered">
   		<!--div class="portlet-title tabbable-line">
   			<div class="caption">
   				<i class="icon-bubbles font-dark hide"></i>
   				<span class="caption-subject font-dark bold uppercase">Today Itineraries Follow up</span>
   			</div>
   		</div-->
   		
   		<div class="portlet-title">
   			<div class="caption">
   				<i class="icon-equalizer font-dark hide"></i>
   				<span class="caption-subject font-dark bold uppercase">Today Itineraries Follow up</span>
   			</div>
   			<div class="tools">
   				<a href="" class="expand"> </a>
   			</div>
   		</div>
   		<div class="portlet-body" style="display: none;">
   			<div class="dashboard-scroll">
   			<div class="tab-content">
   				<div class="tab-pane active" id="portlet_comments_1">
   				<table class="table table-bordered table-striped d-table">
   				<tr>
   					<th>Sr.No</th>
   					<th>Package Name</th>
   					<th>Name</th>
   					<th>Email</th>
   					<th>Contact No</th>
   					<th>Next Call Date</th>
   					<th>Next Call Time</th>
   					<th>Action</th>
   				
   				</tr>
   					<?php if( isset( $todayFollowup_iti ) && !empty($todayFollowup_iti) ) { 
      $i = 1;	
      foreach( $todayFollowup_iti as $iti_follow ){ ?>	
<?php
   $package_name = get_itinerary_field( $iti_follow->iti_id, "package_name" );
   $d = explode(' ',$iti_follow->nextCallDate);
   
   $cus_id = get_itinerary_field( $iti_follow->iti_id, "customer_id" );
   $get_customer_info = get_customer( $cus_id ); 
   $cust = $get_customer_info[0];
   
   $c_iti_name= !empty( $cust ) ? $cust->customer_name : "";
   $c_iti_email= !empty( $cust ) ? $cust->customer_email : "";
   $c_iti_number= !empty( $cust ) ? $cust->customer_contact : "";
   
   ?>
<tr>
   <td><?php echo $i;?></td>
   <td><?php echo $package_name; ?></td>
   <td><?php echo $c_iti_name; ?></td>
   <td><?php echo $c_iti_email; ?></td>
   <td><?php echo $c_iti_number; ?></td>
   <td><?php echo $d[0];?></td>
   <td><?php echo $d[1];?></td>
   <td><a class="btn btn-custom" href="<?php echo site_url("itineraries/view_iti/{$iti_follow->iti_id}/{$iti_follow->temp_key}"); ?>"> View</a></td>
</tr>
<?php
   $i++;	
   } 
   }else{ ?>	
<tr>
   <td colspan="8" class="text-center">
      <div class="mt-comment-text"> No Data found. </div>
   </td>
</tr>
<?php } ?>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<hr>
*/ ?>
<!--Rates section-->
<!--show pending request by manager to supermanager-->
<?php if( is_super_manager() ){ ?>
<div class="col-lg-6 col-xs-12 col-sm-12">
   <div class="portlet light bordered">
      <div class="portlet-title red_background">
         <div class="caption">
            <i class="icon-equalizer font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Rates Request By Manager</span>
         </div>
      </div>
      <div class="portlet-body">
         <div class="tab-content">
            <div class="tab-pane active" id="tab_actions_pending pending-rate1">
               <?php //print_r( $itiPendingRates ); ?>
               <div class="dashboard-scroll">
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
                        <td colspan="5"><span class="lead_app arrow_bottom"><?php echo $pendingRates_m->package_name;?></span> <?php echo $reject_btn;?> <?php echo $iti_type; ?></td>
                     </tr>
                     <tr class="">
                        <td><?php echo $p_count;?>.</td>
                        <td><?php echo $cust_name;?></td>
                        <td><?php echo $cust_no;?></td>
                        <td><?php echo $a_name;?></td>
                        <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view/{$pendingRates_m->iti_id}/{$pendingRates_m->temp_key}"); ?>"> View</a> </td>
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
                           <a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view/{$c_iti->iti_id}/{$c_iti->temp_key}"); ?>">View Parent <strong><?php echo $c_iti->iti_id; ?></strong></a>
                           <?php }else{ ?>
                           <a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view/{$c_iti->iti_id}/{$c_iti->temp_key}"); ?>">View Child <strong><?php echo $c_iti->iti_id; ?></strong></a>
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
                        <td colspan="4" class="text-center">
                           <div class="mt-comment-text"> No Data found. </div>
                        </td>
                     </tr>
                     <?php } ?> 
                  </table>
               </div>
            </div>
            <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
         </div>
      </div>
   </div>
</div>
<?php }else{ ?>
<div class="col-lg-6 col-xs-12 col-sm-12">
   <div class="portlet light bordered">
      <div class="portlet-title">
         <div class="caption">
            <i class="icon-equalizer font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Pending Rates</span>
         </div>
      </div>
      <div class="portlet-body">
         <div class="tab-content">
            <div class="tab-pane active" id="tab_actions_pending pending-rate1">
               <?php //print_r( $itiPendingRates ); ?>
               <div class="dashboard-scroll">
                  <table class="table table-hover d-table table-fixed">
                     <tr>
                        <th>Sr.</th>
                        <th>Name</th>
                        <th>Contact No</th>
                        <th>Agent</th>
                        <th>Action</th>
                     </tr>
                     <?php if( isset($itiPendingRates) && !empty($itiPendingRates) ) { 
                        $p_count = 1;
                        foreach( $itiPendingRates as $pendingRates ){ 
                        	$reject_btn = $pendingRates->iti_status == 6 ? "<span class='lead_app arrow_bottom red_row' title='Rejected Itinerary'>Rejected</span>" : "";
                        	
                        	$iti_type =  "<span class='lead_app arrow_bottom red_row' title='Iti Type'>".check_iti_type($pendingRates->iti_id)."</span>";
                        	
                        		$get_customer_info = get_customer( $pendingRates->customer_id ); 
                        		$cust = $get_customer_info[0];
                        		
                        		$cust_name = !empty($cust) ? $cust->customer_name : "";
                        		$cust_no = !empty($cust) ? $cust->customer_contact : "";
                        		
                        		$agent_id = $pendingRates->agent_id;
                        		$user_info = get_user_info($agent_id);
                        		if($user_info){
                        			$agent = $user_info[0];
                        			$a_name = $agent->first_name . " " . $agent->last_name;
                        		}	
                        	?>
                     <tr>
                        <td colspan="5"><span class="lead_app arrow_bottom"><?php echo $pendingRates->package_name;?></span> <?php echo $reject_btn . $iti_type; ?></td>
                     </tr>
                     <tr class="">
                        <td><?php echo $p_count;?>.</td>
                        <td><?php echo $cust_name;?></td>
                        <td><?php echo $cust_no;?></td>
                        <td><?php echo $a_name;?></td>
                        <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view/{$pendingRates->iti_id}/{$pendingRates->temp_key}"); ?>"> View</a> </td>
                     </tr>
                     <?php //check for child itinerary
                        $child_iti = check_child_iti( $pendingRates->iti_id );
                        $count_records = count( $child_iti ) ; 
                        //if child iti exists
                        if( !empty( $child_iti ) && $count_records > 1 ){
                        	$cl = 1; 
                        	
                        		?>
                     <tr>
                        <td colspan="4">
                           <?php foreach( $child_iti as $c_iti ){ ?>
                           <?php if( $cl == 1 ){ ?>
                           <a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view/{$c_iti->iti_id}/{$c_iti->temp_key}"); ?>">View Parent <strong><?php echo $c_iti->iti_id; ?></strong></a>
                           <?php }else{ ?>
                           <a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view/{$c_iti->iti_id}/{$c_iti->temp_key}"); ?>">View Child <strong><?php echo $c_iti->iti_id; ?></strong></a>
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
                        <td colspan="4" class="text-center">
                           <div class="mt-comment-text"> No Data found. </div>
                        </td>
                     </tr>
                     <?php } ?> 
                  </table>
               </div>
            </div>
            <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
         </div>
      </div>
   </div>
</div>
<?php } ?>
<div class="col-lg-6 col-xs-12 col-sm-12">
   <div class="portlet light bordered">
      <!--div class="portlet-title tabbable-line">
         <div class="caption">
         	<i class=" icon-social-twitter font-dark hide"></i>
         	<span class="caption-subject font-dark bold uppercase">Approved Rates</span>
         </div>
         </div-->
      <div class="portlet-title">
         <div class="caption">
            <i class="icon-equalizer font-dark hide"></i>
            <span class="caption-subject font-dark bold uppercase">Approved Rates</span>
         </div>
      </div>
      <div class="portlet-body">
         <div class="tab-content">
            <div class="tab-pane active" id="tab_actions_pending approved-rate1">
               <div class="dashboard-scroll">
                  <table class="table table-bordered table-striped d-table table-fixed">
                     <thead>
                        <tr>
                           <th>Sr.</th>
                           <th>Name</th>
                           <th>Contact No</th>
                           <th>Agent</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if( isset($itiAppRates) && !empty($itiAppRates) ) { 
                           $apCount = 1;
                           	foreach( $itiAppRates as $itirates ){ 	
                           		$iti_type =  "<span class='lead_app arrow_bottom red_row' title='Iti Type'>".check_iti_type($itirates->iti_id)."</span>";
                           		
                           	 //Get customer info
                           			$get_customer_info = get_customer( $itirates->customer_id ); 
                           			$cust = $get_customer_info[0];
                           			if( !empty( $get_customer_info ) ){  
                           				$cust_name = $cust->customer_name;
                           				$cust_no = $cust->customer_contact;
                           			} 
                           			
                           			$agent_id = $itirates->agent_id;
                           			$user_info = get_user_info($agent_id);
                           			if($user_info){
                           				$agent = $user_info[0];
                           				$a_name = $agent->first_name . " " . $agent->last_name;
                           			}	
                           			?>
                        <tr>
                           <td colspan="5"><span class="lead_app arrow_bottom"><?php echo $itirates->package_name; ?></span> <?php echo $iti_type; ?></td>
                        </tr>
                        <tr>
                           <td><?php echo $apCount;?>.</td>
                           <td><?php echo $cust_name;?></td>
                           <td><?php echo $cust_no;?></td>
                           <td><?php echo $a_name;?></td>
                           <td><a class="btn btn-custom" href="<?php echo site_url("itineraries/view/{$itirates->iti_id}/{$itirates->temp_key}"); ?>" target="_blank" > View</a></td>
                        </tr>
                        <?php 
                           $apCount++;
                           }
                           }else{ ?>	
                        <tr>
                           <td colspan="5" class="text-center">
                              <div class="mt-comment-text"> No Data found. </div>
                           </td>
                        </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
         </div>
      </div>
   </div>
</div>
</div>
</div>
</div>
<div class="clearfix"></div>
<div class="portlet box blue">
   <div class="portlet-title">
      <div class="caption"><i class="fa fa-handshake-o" aria-hidden="true"></i> Today's CHECKOUT </div>
   </div>
   <div class="portlet-body">
      <div class="row dashboard-tables-all-info">
         <!--TODAYS CHECKOUT-->
         <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
               <div class="portlet-title" style="background: green;">
                  <div class="caption">
                     <i class="icon-equalizer font-dark hide"></i>
                     <span class="caption-subject font-dark bold uppercase">TODAY'S CHECKOUT</span>
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="tab-content">
                     <div class="tab-pane active" id="tab_actions_pending pending-rate1">
                        <?php //print_r( $itiPendingRates ); ?>
                        <div class="dashboard-scroll">
                           <table class="table table-hover d-table table-fixed">
                              <tr>
                                 <th>Sr.</th>
                                 <th>Lead Id</th>
                                 <th>Package</th>
                                 <th>Agent</th>
                                 <th>Action</th>
                              </tr>
                              <?php if( isset($todays_checkout) && !empty($todays_checkout) ) { 
                                 $td_c = 1;
                                 foreach( $todays_checkout as $today_checkout ){ 
                                 	$iti_type =  "<span class='lead_app arrow_bottom red_row' title='Iti Type'>".check_iti_type($today_checkout->iti_id )."</span>";
                                 	$view_link = site_url("itineraries/view/{$today_checkout->iti_id}/{$today_checkout->temp_key}");
                                 	?>
                              <tr>
                                 <td><?php echo $td_c; ?>.</td>
                                 <td><?php echo $today_checkout->customer_id; ?></td>
                                 <td><?php echo $today_checkout->package_name; ?></td>
                                 <td><?php echo get_user_name($today_checkout->agent_id); ?></td>
                                 <td><a class="btn btn-custom" target="_blank" href="<?php echo $view_link; ?>">View</a></td>
                              </tr>
                              <?php $td_c++; ?>
                              <?php } 
                                 }else{ ?>	
                              <tr>
                                 <td colspan="4" class="text-center">
                                    <div class="mt-comment-text"> No checkout today. </div>
                                 </td>
                              </tr>
                              <?php } ?> 
                           </table>
                        </div>
                     </div>
                     <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="clearfix"></div>
<?php /* if( is_gm() ){  ?>
<!--ABOVE 40K PACKAGES PRICE SECTION-->
<div class="portlet box blue">
   <div class="portlet-title">
      <div class="caption">Hotel/Cab Booking Pending Quoations</div>
   </div>
   <div class="portlet-body">
      <div class="row dashboard-tables-all-info">
         <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
               <div class="portlet-title" style="background: red;">
                  <div class="caption">
                     <i class="icon-equalizer font-dark hide"></i>
                     <span class="caption-subject font-dark bold uppercase">Hotels Pending Bookings Quoations</span>
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="tab-content">
                     <div class="tab-pane active" id="tab_actions_pending pending-rate1">
                        <div class="dashboard-scroll">
                           <table class="table table-hover d-table table-fixed">
                              <tr>
                                 <th>Sr.</th>
                                 <th> Lead ID </th>
                                 <th> G/Name </th>
                                 <th> Booking Date </th>
                                 <th> Total Cost </th>
                                 <th> Action </th>
                              </tr>
                              <?php if( isset( $hotel_pending_booking ) && !empty($hotel_pending_booking) ) { 
                                 $p_count1 = 1;
                                 $view_all_link = site_url("hotelbooking/pending_confirmation_request");
                                 foreach( $hotel_pending_booking as $booking ){ 
                                 	$booking_date = date("d/m/Y", strtotime($booking->check_in)) . " - " . date("d/m/Y", strtotime($booking->check_out));
                                 	$customer_name = get_customer_name($booking->customer_id);
                                 	?>
                              <tr class="">
                                 <td><?php echo $p_count1; ?></td>
                                 <td><?php echo $booking->customer_id;?>.</td>
                                 <td><?php echo $customer_name; ?></td>
                                 <td><?php echo $booking_date;?></td>
                                 <td><?php echo $booking->total_cost; ?> /-</td>
                                 <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("hotelbooking/view/{$booking->id}/{$booking->iti_id}"); ?>"> View</a> </td>
                              </tr>
                              <?php 
                                 $p_count1++;
                                 } ?>
                              <tr>
                                 <td colspan="6" class="text-center">
                                    <div class="mt-comment-text"> <a class="btn btn-custom" target="_blank" href="<?php echo $view_all_link; ?>"> View All</a> </div>
                                 </td>
                              </tr>
                              <?php }else{ ?>	
                              <tr>
                                 <td colspan="6" class="text-center">
                                    <div class="mt-comment-text"> No Data found. </div>
                                 </td>
                              </tr>
                              <?php } ?> 
                           </table>
                        </div>
                     </div>
                     <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
               <div class="portlet-title red_background">
                  <div class="caption">
                     <i class="icon-equalizer font-dark hide"></i>
                     <span class="caption-subject font-dark bold uppercase">Cab Pending Bookings Quoations</span>
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="tab-content">
                     <div class="tab-pane active" id="tab_actions_pending pending-rate1">
                        <?php //print_r( $itiPendingRates ); ?>
                        <div class="dashboard-scroll">
                           <table class="table table-hover d-table table-fixed">
                              <tr>
                                 <th>Sr.</th>
                                 <th> Lead ID </th>
                                 <th> G/Name </th>
                                 <th> Booking Date </th>
                                 <th> Total Cost </th>
                                 <th> Action </th>
                              </tr>
                              <?php if( isset( $cab_pending_booking ) && !empty($cab_pending_booking) ) { 
                                 $p_count1 = 1;
                                 $view_all_link = site_url("vehiclesbooking/pending_confirmation_request");
                                 foreach( $cab_pending_booking as $booking ){ 
                                 	$booking_date = !empty($booking->picking_date) ? date("d/m/Y", strtotime($booking->picking_date)) . " - " . date("d/m/Y", strtotime($booking->droping_date) ) : "";
                                 	$customer_name = get_customer_name($booking->customer_id);
                                 	?>
                              <tr class="">
                                 <td><?php echo $p_count1; ?></td>
                                 <td><?php echo $booking->customer_id;?>.</td>
                                 <td><?php echo $customer_name; ?></td>
                                 <td><?php echo $booking_date;?></td>
                                 <td><?php echo $booking->total_cost; ?> /-</td>
                                 <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("vehiclesbooking/viewbooking/{$booking->id}"); ?>"> View</a> </td>
                              </tr>
                              <?php 
                                 $p_count1++;
                                 } ?>
                              <tr>
                                 <td colspan="6" class="text-center">
                                    <div class="mt-comment-text"> <a class="btn btn-custom" target="_blank" href="<?php echo $view_all_link; ?>"> View All</a> </div>
                                 </td>
                              </tr>
                              <?php }else{ ?>	
                              <tr>
                                 <td colspan="6" class="text-center">
                                    <div class="mt-comment-text"> No Data found. </div>
                                 </td>
                              </tr>
                              <?php } ?> 
                           </table>
                        </div>
                     </div>
                     <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
         <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
               <div class="portlet-title red_background">
                  <div class="caption">
                     <i class="icon-equalizer font-dark hide"></i>
                     <span class="caption-subject font-dark bold uppercase">Volvo/Train Pending Bookings Quoations</span>
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="tab-content">
                     <div class="tab-pane active" id="tab_actions_pending pending-rate1">
                        <?php //print_r( $itiPendingRates ); ?>
                        <div class="dashboard-scroll">
                           <table class="table table-hover d-table table-fixed">
                              <tr>
                                 <th>Sr.</th>
                                 <th> Lead ID </th>
                                 <th> Type </th>
                                 <th> G/Name </th>
                                 <th> Booking Date </th>
                                 <th> Action </th>
                              </tr>
                              <?php if( isset( $vtf_pending_booking ) && !empty($vtf_pending_booking) ) { 
                                 $p_count1 = 1;
                                 $view_all_link = site_url("vehiclesbooking/pending_vtf_confirmation_request");
                                 foreach( $vtf_pending_booking as $booking ){ 
                                 	$booking_date = !empty($booking->dep_date) ? date("d/m/Y", strtotime($booking->dep_date)) . " - " . date("d/m/Y", strtotime($booking->arr_date) ) : "";
                                 	$customer_name = get_customer_name($booking->customer_id);
                                 	?>
                              <tr class="">
                                 <td><?php echo $p_count1; ?></td>
                                 <td><?php echo $booking->customer_id;?>.</td>
                                 <td><?php echo ucfirst($booking->booking_type);?></td>
                                 <td><?php echo $customer_name; ?></td>
                                 <td><?php echo $booking_date;?></td>
                                 <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("vehiclesbooking/viewvehiclebooking/{$booking->id}/{$booking->iti_id}"); ?>"> View</a> </td>
                              </tr>
                              <?php 
                                 $p_count1++;
                                 } ?>
                              <tr>
                                 <td colspan="5" class="text-center">
                                    <div class="mt-comment-text"> <a class="btn btn-custom" target="_blank" href="<?php echo $view_all_link; ?>"> View All</a> </div>
                                 </td>
                              </tr>
                              <?php }else{ ?>	
                              <tr>
                                 <td colspan="5" class="text-center">
                                    <div class="mt-comment-text"> No Data found. </div>
                                 </td>
                              </tr>
                              <?php } ?> 
                           </table>
                        </div>
                     </div>
                     <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--END PENDING PRICE SECTION-->
<div class="clearfix"></div>
<?php } */ ?>
<?php if( is_sales_manager() ){  ?>
<!--ABOVE 40K PACKAGES PRICE SECTION-->
<div class="portlet box blue">
   <div class="portlet-title">
      <div class="caption">ABOVE 40K PACKAGES SECTION</div>
   </div>
   <div class="portlet-body">
      <div class="row dashboard-tables-all-info">
         <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
               <div class="portlet-title" style="background: green;">
                  <div class="caption">
                     <i class="icon-equalizer font-dark hide"></i>
                     <span class="caption-subject font-dark bold uppercase">BETWEEN <i class="fa fa-inr"></i>40k AND <i class="fa fa-inr"></i>100k Packages (On Working)</span>
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="tab-content">
                     <div class="tab-pane active" id="tab_actions_pending pending-rate1">
                        <?php //print_r( $itiPendingRates ); ?>
                        <div class="dashboard-scroll">
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
                                 <td colspan="5"><span class="lead_app arrow_bottom"><?php echo $a_forty_pkg->package_name;?></span> <?php echo $iti_type; ?></td>
                              </tr>
                              <tr class="">
                                 <td><?php echo $p_count1;?>.</td>
                                 <td><?php echo $cust_name;?></td>
                                 <td><?php echo $cust_no;?></td>
                                 <td><?php echo $a_forty_pkg->MAXP; ?> /-</td>
                                 <td><?php echo $a_user_name;?></td>
                                 <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view/{$a_forty_pkg->iti_id}/{$a_forty_pkg->temp_key}"); ?>"> View</a> </td>
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
                        </div>
                     </div>
                     <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-6 col-xs-12 col-sm-12">
            <div class="portlet light bordered">
               <div class="portlet-title red_background">
                  <div class="caption">
                     <i class="icon-equalizer font-dark hide"></i>
                     <span class="caption-subject font-dark bold uppercase">above <i class="fa fa-inr"></i>100k Packages (On Working)</span>
                  </div>
               </div>
               <div class="portlet-body">
                  <div class="tab-content">
                     <div class="tab-pane active" id="tab_actions_pending pending-rate1">
                        <?php //print_r( $itiPendingRates ); ?>
                        <div class="dashboard-scroll">
                           <table class="table table-hover d-table table-fixed">
                              <tr>
                                 <th>Sr.</th>
                                 <th>Name</th>
                                 <th>Contact No</th>
                                 <th>Rate</th>
                                 <th>Agent</th>
                                 <th>Action</th>
                              </tr>
                              <?php if( isset( $above_one_lac_wrk_pkg ) && !empty($above_one_lac_wrk_pkg) ) { 
                                 $p_count1 = 1;
                                 foreach( $above_one_lac_wrk_pkg as $a_Bet_forty_pkg ){ 
                                 	$iti_type =  "<span class='lead_app arrow_bottom red_row' title='Iti Type'>".check_iti_type($a_Bet_forty_pkg->iti_id)."</span>";
                                 	$get_customer_info = get_customer( $a_Bet_forty_pkg->customer_id ); 
                                 	$cust = $get_customer_info[0];
                                 	$cust_name = !empty($cust) ? $cust->customer_name : "";
                                 	$cust_no = !empty($cust) ? $cust->customer_contact : "";
                                 	$agent_id = $a_Bet_forty_pkg->agent_id;
                                 	$a_user_name = get_user_name($agent_id);
                                 	
                                 	?>
                              <tr>
                                 <td colspan="5"><span class="lead_app arrow_bottom"><?php echo $a_Bet_forty_pkg->package_name;?></span> <?php echo $iti_type; ?></td>
                              </tr>
                              <tr class="">
                                 <td><?php echo $p_count1;?>.</td>
                                 <td><?php echo $cust_name;?></td>
                                 <td><?php echo $cust_no;?></td>
                                 <td><?php echo $a_Bet_forty_pkg->MAXP; ?> /-</td>
                                 <td><?php echo $a_user_name;?></td>
                                 <td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view/{$a_Bet_forty_pkg->iti_id}/{$a_Bet_forty_pkg->temp_key}"); ?>"> View</a> </td>
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
                        </div>
                     </div>
                     <button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--END PENDING PRICE SECTION-->
<div class="clearfix"></div>
<?php } ?>
<hr>
<div class="total-leads-for-month">
   <div class="month_section">
      <div class="portlet box blue">
         <div class="portlet-title">
            <div class="caption"><i class="fa fa-handshake-o" aria-hidden="true"></i> Month's Status</div>
         </div>
         <div class="portlet-body">
            <div class="row">
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("customers") . "/?leadfrom={$from}&leadto={$to}"; ?>">
                        <div class="visual">
                           <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalLeadsMonth) ? $totalLeadsMonth : 0; ?>">0</span>
                           </div>
                           <div class="desc"> Total Leads<br> </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=callpicked"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalPickCallsMonth) ? $totalPickCallsMonth : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Total Call <br>Picked </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=callnotpicked"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalNotPickCallsMonth) ? $totalNotPickCallsMonth : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Total Call <br>Not Picked </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=8"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalDecLeadsMonth) ? $totalDecLeadsMonth : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Total Declined <br>Leads </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="col-md-20">
                  <div class="callCountBlock">
                     <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("customers"). "/?todayStatus={$this_month}&leadStatus=unwork"; ?>">
                        <div class="visual">
                           <i class="fa fa-bar-chart-o"></i>
                        </div>
                        <div class="details">
                           <div class="number">
                              <span data-counter="counterup" data-value="<?php echo isset($totalUnworkLeadsMonth) ? $totalUnworkLeadsMonth : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Total Unwork<br> Leads </div>
                        </div>
                     </a>
                  </div>
               </div>
               <div class="clearfix"></div>
               <div class="load-more-dashboard text-center">
                  <button type="button" data-target_id="month_full_stat" class="btn pulse btn_blue_outline view_all_stat_btn"><i class="fa fa-angle-down"></i> View All Stats</button>
               </div>
               <div id="month_full_stat" style="display: none;">
                  <div class="col-md-20">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries"). "/?todayStatus={$this_month}&leadStatus=Qsent&quotation=true"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($totalQuotSentMonth) ? $totalQuotSentMonth : 0; ?>">0</span> 
                              </div>
                              <div class="desc"> Quotations<br> Sent </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-20">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=pending"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($totalWorkingItiMonth) ? $totalWorkingItiMonth : 0; ?>">0</span> 
                              </div>
                              <div class="desc"> Total Working <br>Itineraries </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-20">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=9"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($totalApprovedItiMonth) ? $totalApprovedItiMonth : 0; ?>">0</span> 
                              </div>
                              <div class="desc"> Total Approved <br>Itineraries This</div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-20">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=7"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($totalDecItiMonth) ? $totalDecItiMonth : 0; ?>">0</span> 
                              </div>
                              <div class="desc"> Total Declined <br>Itineraries This</div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="col-md-20">
                     <div class="callCountBlock">
                        <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries"). "/?todayStatus={$this_month}&leadStatus=QsentRevised&quotation=true"; ?>">
                           <div class="visual">
                              <i class="fa fa-bar-chart-o"></i>
                           </div>
                           <div class="details">
                              <div class="number">
                                 <span data-counter="counterup" data-value="<?php echo isset($totalRevQuotSentMonth) ? $totalRevQuotSentMonth : 0; ?>">0</span> 
                              </div>
                              <div class="desc"> Revised Quotations <br> Sent  </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <hr>
                  <!---------------------------------Revised section Month---------------------------->
                  <div class="month_revised_section">
                     <div class="col-md-3">
                        <div class="callCountBlock">
                           <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries"). "/?leadfrom={$from}&leadto={$to}&leadStatus=QsentPastMonth&quotation=true"; ?>">
                              <div class="visual">
                                 <i class="fa fa-bar-chart-o"></i>
                              </div>
                              <div class="details">
                                 <div class="number">
                                    <span data-counter="counterup" data-value="<?php echo isset($pastQuotSentMonth) ? $pastQuotSentMonth : 0; ?>">0</span> 
                                 </div>
                                 <div class="desc"> Revised Quotations <br> Sent </div>
                              </div>
                           </a>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="callCountBlock">
                           <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?leadfrom={$from}&leadto={$to}&leadStatus=revApprovedMonth"; ?>">
                              <div class="visual">
                                 <i class="fa fa-bar-chart-o"></i>
                              </div>
                              <div class="details">
                                 <div class="number">
                                    <span data-counter="counterup" data-value="<?php echo isset($pastApprovedItiMonth) ? $pastApprovedItiMonth : 0; ?>">0</span> 
                                 </div>
                                 <div class="desc"> Total Revised Approved <br>Itineraries </div>
                              </div>
                           </a>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="callCountBlock">
                           <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries") . "/?leadfrom={$from}&leadto={$to}&leadStatus=revDeclineMonth"; ?>">
                              <div class="visual">
                                 <i class="fa fa-bar-chart-o"></i>
                              </div>
                              <div class="details">
                                 <div class="number">
                                    <span data-counter="counterup" data-value="<?php echo isset($pastDeclineItiMonth) ? $pastDeclineItiMonth : 0; ?>">0</span> 
                                 </div>
                                 <div class="desc"> Total Revised Declined <br>Itineraries </div>
                              </div>
                           </a>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="callCountBlock">
                           <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?leadfrom={$from}&leadto={$to}&leadStatus=revDeclineLeadsMonth"; ?>">
                              <div class="visual">
                                 <i class="fa fa-bar-chart-o"></i>
                              </div>
                              <div class="details">
                                 <div class="number">
                                    <span data-counter="counterup" data-value="<?php echo isset($pastDecLeadsMonth) ? $pastDecLeadsMonth : 0; ?>">0</span> 
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
<!--Chart Section-->
<?php $get_agents = get_all_sales_team_agents(); ?>
<div class="portlet box blue">
   <div class="portlet-title">
      <div class="caption"><i class="icon-equalizer font-light" aria-hidden="true"></i> Statistics Section</div>
   </div>
   <div class="portlet-body">
      <div class="row dashboard-tables-all-info2">
         <div class="col-lg-12 col-xs-12 col-sm-12">
            <div class="portlet light ">
               <div class="portlet-body">
                  <div class="tab-content">
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
                           <div class="loader_iti processer"><img class="img-responsive" src="<?php echo base_url();?>site/images/loader.gif" /></div>
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
                           <div class="loader_lead processer"><img class="img-responsive" src="<?php echo base_url();?>site/images/loader.gif" /></div>
                           <div id="leads_echarts_bar" style="height:400px;"></div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="clearfix"></div>
</div>
<br>
<br>
<br>	
<!--End Chart Section-->
<div class="clearfix"></div>
</div><!-- END CONTENT -->
</div>
</div><!-- END CONTAINER -->
<!-- CUSTOMER FOLLOW UP -->
<div class="modal right fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel2">CUSTOMER FOLLOW UP</h4>
         </div>
         <div class="modal-body">
            <div class="col-md-12 column calander-section" id="customer_folloup_cal_section">
               <div id='calendar_customer_followup' class='calender_dashboard'></div>
            </div>
         </div>
      </div>
      <!-- modal-content -->
   </div>
   <!-- modal-dialog -->
</div>
<!-- modal -->
<!-- ITINERARIES FOLLOW UP -->
<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel2">ITINERARIES FOLLOW UP</h4>
         </div>
         <div class="col-md-12 column" id="iti_folloup_cal_section">
            <div id='calendar_iti_followup' class='calender_dashboard'></div>
         </div>
      </div>
      <!-- modal-content -->
   </div>
   <!-- modal-dialog -->
</div>
<!-- modal -->
<script type="text/javascript">
   jQuery(document).ready(function($){
   	//Append view all follow up btn
   	$(document).on("click", ".fc-more", function(e){
   		var calType = $(this).parents(".calender_dashboard").attr("id");
   		var e_date = $(this).closest("td.fc-more-cell").prev(".fc-limited").find(".fc-event:first-child").attr("date-num");
   		//console.log("dT " + e_date);
   		var followLinkCus = "<?php echo base_url("customers/?todayStatus="); ?>" + e_date + "&leadStatus=getFollowUp";
   		var followLinkIti = "<?php echo base_url("itineraries/?todayStatus="); ?>" + e_date + "&leadStatus=getFollowUp";
   		var link_f = calType == "calendar_iti_followup" ?  followLinkIti : followLinkCus;
   		var viewBtn = '<a class="all_event_link" target="_blank" href="' + link_f + '"><span class="event-count">' + '<i class="fa fa-eye"></i> View All' + '</span></a>';
   		//append view button
   		$(".fc-widget-header .fc-title").append(" " + viewBtn);
   	});
   });
   /**************** CUSTOMER FOLLOW UP CALENDAR iti_id ****************/
   jQuery(document).ready(function($){
   	var base_url='<?php echo base_url(); ?>'; // Here i define the base_url
       // Fullcalendar
       $('#calendar_customer_followup').fullCalendar({
           header: {
               left: 'prev, next, today',
               center: 'title',
               right: 'month, basicWeek, basicDay'
           },
   		displayEventTime: false,
   		// Get all events stored in database
           eventLimit: true, // allow "more" link when too many events
           //events: base_url+'dashboard/getAllCustomerFollowup',
           events: base_url+'dashboard/getAllCustomerFollowup_merge',
           selectable: true,
           selectHelper: false,
           editable: false, // Make the event resizable true  
   	   // resourceGroupField: 'c_id',
   	   eventRender: function (event, element, view) { 
   			//console.log(event.id);
   			$(element).each(function () { 
   				$(this).attr('date-num', event.start.format('YYYY-MM-DD'));
   				$(this).attr('date-event_id', event.id);
   			});
   			
   			element.find(".fc-event-title").remove();
   			element.find(".fc-event-time").remove();  
   			var new_description = 
   				'<span data-event_id ="event_'+ event.id +'">' + event.nextCall + ' </span><strong>'+ event.agent  +' </strong> <span> ( Lid: '+ event.cus_id  + ') </span><br/>' 
   			;
   			element.append(new_description);
   		},
   		eventAfterAllRender: function(view){
   			for( cDay = view.start.clone(); cDay.isBefore(view.end) ; cDay.add(1, 'day') ){
   				var dateNum = cDay.format('YYYY-MM-DD');
   				var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
   				var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
   				var DCount = $('.fc-event[date-event_id="' + dateNum + '"]').length;
   				/* if(eventCount){
   					var html = '<a  class="event_link" href="#"><span class="event-count">' + 
   								'<i>' +
   								eventCount + 
   								'</i>' +
   								' Calls' +
   								'</span></a>';
   					dayEl.append(html);
   				}  */
   			}
   		},
   	});
   /**************** END CUSTOMER FOLLOW UP CALENDAR ****************/
   /**************** ItinerariesFOLLOW UP CALENDAR ****************/
       // Fullcalendar
      /* $('#calendar_iti_followup').fullCalendar({
           header: {
               left: 'prev, next, today',
               center: 'title',
               right: 'month, basicWeek, basicDay'
           },
   		displayEventTime: false,
   		// Get all events stored in database
           eventLimit: true, // allow "more" link when too many events
           events: base_url+'dashboard/getAllItiFollowup',
           selectable: true,
           selectHelper: false,
           editable: false, // Make the event resizable true  
   	   // resourceGroupField: 'c_id',
   	   eventRender: function (event, element, view) { 
   			//console.log(event.id);
   			$(element).each(function () { 
   				$(this).attr('date-num', event.start.format('YYYY-MM-DD'));
   				$(this).attr('date-event_id', event.id);
   			});
   			
   			element.find(".fc-event-title").remove();
   			element.find(".fc-event-time").remove();  
   			var new_description = 
   				'<span data-event_id ="event_'+ event.id +'">' + event.nextCall + ' </span><strong>'+ event.agent  +' </strong><br/>' 
   			;
   			element.append(new_description);
   		},
   		eventAfterAllRender: function(view){
   			for( cDay = view.start.clone(); cDay.isBefore(view.end) ; cDay.add(1, 'day') ){
   				var dateNum = cDay.format('YYYY-MM-DD');
   				var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
   				var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
   				var DCount = $('.fc-event[date-event_id="' + dateNum + '"]').length;
   			}
   		},
   	});
   	*/
   	//open event in new tab
   	jQuery('.calender_dashboard').on( 'click', '.fc-event', function(e){
   		e.preventDefault();
   		window.open( jQuery(this).attr('href'), '_blank' );
   	});
   });	
   /**************** End ItinerariesFOLLOW UP CALENDAR ****************/
</script>