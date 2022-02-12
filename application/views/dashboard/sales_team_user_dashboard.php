<?php
   //date use to filter
   $from = date('Y-m-01');
   $to = date('Y-m-t');
   //from date from app start
   $from_start = "2017-11-01";
   $today_date = date('Y-m-d');
   //This Month
   $this_month = date("Y-m");
   
   //Get date for get dashboard
   $get_date = isset($_GET['date']) && !empty( $_GET['date'] ) ? $_GET['date'] : date("Y-m-d");
   ?>
<!-- BEGIN CONTENT User Role: 96 -->
<div class="page-content-wrapper sales_team_dashboard">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- END PAGE BAR -->
      <?php if( isset( $sales_user_id ) ){
         $agent_id = $sales_user_id;
         $user_info = get_user_info($agent_id);
         $u_name = "";
         $user_fname = "";
         if($user_info){
         	$agent = $user_info[0];
         	$user_fname = ucfirst($agent->first_name) . " " . ucfirst($agent->last_name) . "</strong>";
         	$u_name = $agent->user_name;
         }	
         ?>
      <?php if( !empty( $users_data ) && is_admin_or_manager() ){ ?>
      <div class="page-bar text-center switchUser">
         <form id="switchDashboard" class="form-inline">
            <div class="form-group">
               <label for="sales_user_id">Select Date:</label>
               <input type="text" required class="form-control" id="date_pick" value="<?php echo $get_date; ?>" />
            </div>
            <div class="form-group">
               <label for="sales_user_id">Select Sales Team User*:</label>
               <select required class="form-control" id='sales_user_id' name="user_id">
                  <option value="">Select User</option>
                  <?php foreach( $users_data as $user ){ ?>
                  <option <?php if( $user->user_id == $sales_user_id){ echo "selected"; } ?> value="<?php echo $user->user_id; ?>"><?php echo $user->user_name . " ( " . ucfirst( $user->first_name ) . " "  . ucfirst( $user->last_name) . " )"; ?></option>
                  <?php } ?>
               </select>
            </div>
            <button id="sbmt" type="submit" class="btn btn-success"><i class="fa fa-search"></i> Submit</button>
         </form>
      </div>
      <?php }else if( $teammem = is_teamleader() ){ ?>
      <div class="page-bar text-center switchUser">
         <form id="switchDashboard" class="form-inline">
            <div class="form-group">
               <label for="sales_user_id">Select Date:</label>
               <input type="text" required class="form-control" id="date_pick" value="<?php echo $get_date; ?>" />
            </div>
            <div class="form-group">
               <label for="sales_user_id">Select Team Member*:</label>
               <select required class="form-control" id='sales_user_id' name="user_id">
                  <option value="">Select Teammeber</option>
                  <?php foreach( $teammem as $user ){ ?>
                  <option <?php if( $user == $sales_user_id){ echo "selected"; } ?> value="<?php echo $user; ?>"><?php echo get_user_name($user); ?></option>
                  <?php } ?>
               </select>
            </div>
            <button id="sbmt" type="submit" class="btn btn-success"><i class="fa fa-search"></i> Submit</button>
         </form>
      </div>
      <div class="portlet box blue">
         <div class="portlet-title">
            <div class="caption">User Name: <?php echo $u_name; ?> Full Name: <?php echo $user_fname; ?> Dashboard ( Sales Team User )</div>
            <a class="btn btn-success pull-right" href="<?php echo site_url("agents/myteammembers"); ?>" title="Back">Back</a>
         </div>
      </div>
      <?php } ?>
      <?php if( is_admin_or_manager()){ ?>	
      <div class="portlet box blue">
         <div class="portlet-title">
            <div class="caption">User Name: <?php echo $u_name; ?> Full Name: <?php echo $user_fname; ?> Dashboard ( Sales Team User )</div>
            <a class="btn btn-success pull-right" href="<?php echo site_url("dashboard/user_dashboard"); ?>" title="Back">Back</a>
         </div>
      </div>
      <?php } ?>
      <?php }else{ ?>
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
      </div>
      <!-- BEGIN PAGE TITLE-->
      <h1 class="page-title"> Sales Team Dashboard
         <small>recent itineraries,today's leads,today's followup</small>
      </h1>
      <?php } ?>
      <!-- End ManyChat Button Booster -->
      <div class="clearfix"></div>
      <!-- Todays status-->
      <div class="portlet box blue">
         <div class="portlet-title">
            <div class="caption"><i class="fa fa-calendar"></i>Today's Status <strong class="red"><?php echo display_month_name($get_date); ?></strong></div>
         </div>
         <?php $todAy = date("Y-m-d"); ?>
         <div class="todayssection">
            <div class="portlet-body">
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
                           <div class="desc"> Total Leads </div>
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
                              <span data-counter="counterup" data-value="<?php echo isset($totalPickCallsToday)? $totalPickCallsToday : 0; ?>">0</span> 
                           </div>
                           <div class="desc"> Total Call <br>Picked </div>
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
                              <span data-counter="counterup" data-value="<?php echo isset($totalNotPickCallsToday) ? $totalNotPickCallsToday : 0; ?>">0</span> 
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
            </div>
            <div class="clearfix"></div>
            <div class="load-more-dashboard text-center">
               <button type="button" data-target_id="todays_full_stats" class="btn purple pulse view_all_stat_btn"><i class="fa fa-angle-down"></i> View All Stats</button>
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
                           <div class="desc"> Total Working <br>Itineraries </div>
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
                           <div class="desc"> Total Approved <br>Itineraries </div>
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
                           <div class="desc"> Total Declined <br>Itineraries </div>
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
                           <div class="desc"> Revised Quotations <br> Sent </div>
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
                              <div class="desc"> Revised Quotations <br> Sent </div>
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
                              <div class="desc"> Total Revised Approved <br>Itineraries </div>
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
                              <div class="desc"> Total Revised Declined <br>Itineraries </div>
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
                              <div class="desc"> Total Declined <br>Revised Leads  </div>
                           </div>
                        </a>
                     </div>
                  </div>
                  <div class="clearfix"></div>
               </div>
            </div>
            <!--Todays full stat -->	
         </div>
      </div>
      <!---------------------------------End Todays Revised section ---------------------------->
      <div class="clearfix"></div>
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
                                       <th>Contact</th>
                                       <th>Action</th>
                                    </tr>
                                    <?php if( isset($amendmentPendingRates) && !empty($amendmentPendingRates) ) { 
                                       foreach( $amendmentPendingRates as $aRates ){ 	?>
                                    <tr>
                                       <td colspan="4"><span class="lead_app arrow_bottom"><?php echo $aRates->package_name; ?></span></td>
                                    </tr>
                                    <tr>
                                       <td><?php echo $aRates->customer_name; ?></td>
                                       <td><?php echo $aRates->package_name; ?></td>
                                       <td><?php echo $aRates->customer_contact; ?></td>
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
                                          <th>Contact</th>
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
                                          <td><?php echo $apRates->customer_contact; ?></td>
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
      <!-- End Today section -->
      <div class="r2ow">
         <!-- Total Leads of the Day -->
         <div class="portlet box blue">
            <div class="portlet-title">
               <div class="caption"><i class="fa fa-handshake-o" aria-hidden="true"></i> Follow Up Section</div>
            </div>
            <div class="portlet-body">
               <div class="row dashboard-tables-all-info">
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
                        <div class="portlet-body"  >
                           <div class="dashboard-scroll">
                              <div class="tab-content">
                                 <div class="tab-pane active" id="portlet_comments_1">
                                    <table class="table table-bordered table-striped d-table">
                                       <tr>
                                          <th>Name</th>
                                          <th>Email</th>
                                          <th>Contact No</th>
                                          <th>Action</th>
                                       </tr>
                                       <?php if( isset($totalLeadsToday) && !empty($totalLeadsToday) ) { 
                                          $i = 1;	
                                          foreach( $totalLeadsToday as $t_leads ){ ?>	
                                       <tr>
                                          <td><?php echo $t_leads->customer_name; ?></span></td>
                                          <td><?php	echo $t_leads->customer_email; ?></td>
                                          <td><?php echo $t_leads->customer_contact; ?></td>
                                          <td><a class="btn btn-custom" href="<?php echo site_url("customers/view/{$t_leads->customer_id}/{$t_leads->temp_key}"); ?>">View</a></td>
                                       </tr>
                                       <?php } 
                                          }else{ ?>	
                                       <tr>
                                          <td colspan="4">
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
                        <!--div class="portlet-title tabbable-line">
                           <div class="caption">
                           	<i class="icon-bubbles font-dark hide"></i>
                           	<span class="caption-subject font-dark bold uppercase">Follow up of the day</span>
                           </div>
                           </div-->
                        <div class="portlet-title">
                           <div class="caption">
                              <i class="icon-equalizer font-dark hide"></i>
                              <span class="caption-subject font-dark bold uppercase">Follow up of the day</span>
                           </div>
                        </div>
                        <div class="portlet-body">
                           <div class="dashboard-scroll">
                              <div class="tab-content">
                                 <div class="tab-pane active" id="portlet_comments_1">
                                    <table class="table table-bordered table-striped d-table">
                                       <tr>
                                          <th>Name</th>
                                          <th>Contact No</th>
                                          <th>Call Date</th>
                                          <th>Call Time</th>
                                          <th>Action</th>
                                       </tr>
                                       <?php if( isset($leadsFollowupToday) && !empty($leadsFollowupToday) ) { 
                                          $i = 1;	
                                          foreach( $leadsFollowupToday as $followToday ){ ?>	
                                       <?php
                                          if( $followToday->callType == "9" ){
                                          $cc = "<span class='lead_app arrow_bottom'>Leads Approved</span>";
                                          }elseif( $followToday->callType == 8 ){
                                          	$cc = "<span class='lead_declined arrow_bottom'>Leads Declined</span>";
                                          }elseif( $followToday->callType == "Picked call" ){
                                          	$cc = "<span class='c_picked arrow_bottom'> ". $followToday->callType . "</span>";
                                          }else{
                                          	$cc = "<span class='c_npicked arrow_bottom'>" . $followToday->callType . "</span>";
                                          }
                                          $d = explode(' ',$followToday->nextCallDate);
                                          
                                          //check if multi followToday
                                          $checkFollow = repeat_followup_today_by_customer_id( $followToday->customer_id );
                                          $red_class = !empty( $checkFollow ) && $checkFollow > 1 ? "repeat_follow" : "";
                                          
                                          $get_customer_info = get_customer( $followToday->customer_id ); 
                                          $cust = $get_customer_info[0];
                                          if( !empty( $get_customer_info ) ){  
                                          $c_name =  $cust->customer_name;
                                          $c_number =  $cust->customer_contact;
                                          } 
                                          
                                          ?>
                                       <tr>
                                          <td colspan="5"><?php echo $cc; ?></td>
                                       </tr>
                                       <tr class="<?php echo $red_class; ?>">
                                          <td><?php echo $c_name;?></td>
                                          <td><?php echo $c_number;?></td>
                                          <td><?php echo $d[0];?></td>
                                          <td><?php echo $d[1]. ' '.$d[2];?></td>
                                          <td><a class="btn btn-custom" href="<?php echo site_url("customers/view/{$followToday->customer_id}/{$followToday->temp_key}"); ?>"> View</a></td>
                                       </tr>
                                       <?php } 
                                          }else{ ?>	
                                       <tr>
                                          <td colspan="5">
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
                  <div class="clearfix"></div>
                  <!--Rates section-->
                  <div class="col-lg-6 col-xs-12 col-sm-12">
                     <div class="portlet light bordered">
                        <!--div class="portlet-title tabbable-line">
                           <div class="caption">
                           	<i class=" icon-social-twitter font-dark hide"></i>
                           	<span class="caption-subject font-dark bold uppercase">Pending Rates</span>
                           </div>
                           </div-->
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
                                    <table class="table table-bordered table-striped d-table">
                                       <tr>
                                          <th>Package Name</th>
                                          <th>Name</th>
                                          <th>Contact No</th>
                                          <th>Action</th>
                                       </tr>
                                       <?php if( isset($itiPendingRates) && !empty($itiPendingRates) ) { 
                                          foreach( $itiPendingRates as $pendingRates ){ ?>	
                                       <?php //Get customer info
                                          $get_customer_info = get_customer( $pendingRates->customer_id ); 
                                          $cust 		= $get_customer_info[0];
                                          $cust_name 	= !empty($cust) ? $cust->customer_name : "";
                                          $cust_no 	= !empty($cust) ? $cust->customer_contact : "";
                                          ?>
                                       <tr>
                                          <td><?php echo $pendingRates->package_name;?></td>
                                          <td><?php echo $cust_name;?></td>
                                          <td><?php echo $cust_no;?></td>
                                          <td><a class="btn btn-custom" href="<?php echo site_url("itineraries/view/{$pendingRates->iti_id}/{$pendingRates->temp_key}"); ?>"> View</a></td>
                                       </tr>
                                       <?php } /*end foreach*/
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
                                    <table class="table table-bordered table-striped d-table">
                                       <tr>
                                          <th>Package Name</th>
                                          <th>Name</th>
                                          <th>Contact No</th>
                                          <th>Action</th>
                                       </tr>
                                       <?php if( isset($itiAppRates) && !empty($itiAppRates) ) { 
                                          foreach( $itiAppRates as $itirates ){ ?>	
                                       <?php //Get customer info
                                          $get_customer_info = get_customer( $itirates->customer_id ); 
                                          $cust = $get_customer_info[0];
                                          if( !empty( $get_customer_info ) ){  
                                          	$cust_name = $cust->customer_name;
                                          	$cust_no = $cust->customer_contact;
                                          } 
                                          ?>
                                       <tr>
                                          <td><?php echo $itirates->package_name;?></td>
                                          <td><?php echo $cust_name;?></td>
                                          <td><?php echo $cust_no;?></td>
                                          <td><a class="btn btn-custom" href="<?php echo site_url("itineraries/view/{$itirates->iti_id}/{$itirates->temp_key}"); ?>"> View</a></td>
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
         </div>
         <div class="clearfix"></div>
         <div class="total-leads-for-month">
            <div class="month_section">
               <div class="portlet box blue">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-file-text-o" aria-hidden="true"></i> Month's Status</div>
                  </div>
                  <div class="portlet-body row">
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
                                 <div class="desc"> Total Leads </div>
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
                        <button type="button" data-target_id="month_full_stat" class="btn pulse purple view_all_stat_btn"><i class="fa fa-angle-down"></i> View All Stats</button>
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
                                    <div class="desc"> Total Approved <br>Itineraries </div>
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
                                    <div class="desc"> Total Declined <br>Itineraries  </div>
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
                                 <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries"). "/?todayStatus={$this_month}&leadStatus=QsentPast&quotation=true"; ?>">
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
                                 <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=revApproved"; ?>">
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
                                 <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=revDecline"; ?>">
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
                                 <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=revDeclineLeads"; ?>">
                                    <div class="visual">
                                       <i class="fa fa-bar-chart-o"></i>
                                    </div>
                                    <div class="details">
                                       <div class="number">
                                          <span data-counter="counterup" data-value="<?php echo isset($pastDecLeadsMonth) ? $pastDecLeadsMonth : 0; ?>">0</span> 
                                       </div>
                                       <div class="desc"> Total Revised Declined <br>Leads  </div>
                                    </div>
                                 </a>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!--End month full stats-->
                  </div>
                  <!-- portlet-body -->		
               </div>
            </div>
            <!---------------------------------End Todays Revised section ---------------------------->
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
   <!-- portlet  close -->
   <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- END QUICK SIDEBAR -->
</div>
<script type="text/javascript">
   jQuery(document).ready(function($){
   	//Datepicker
   	$('#date_pick').datepicker({
   		format: 'yyyy-mm-dd',
   		endDate: '1d'
   	});
   
   	$(document).on("click", "#sbmt", function(e){
   		e.preventDefault();
   		var user_id = $("#sales_user_id").val();
   		var date = $("#date_pick").val();
   		if( user_id == '' ){
   			alert( "Please select user" );
   			return false;
   		}
   		//alert("user: " + user_id);
   		var redirect_url = "<?php echo site_url('dashboard/user_dashboard'); ?>?user_id=" + user_id + "&date=" + date;
   		//alert( redirect_url );
   		window.location.href = redirect_url ;
   	});
   });
</script>