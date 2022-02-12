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
		<div class="more-info-right-sidebar">
			<button class="btn blue sidebar-button btn-side-1" data-toggle="modal" data-target="#myModal1"><i class="fa fa-users"></i> Lead Follow Up</button>
			<button class="btn blue sidebar-button btn-side-2" data-toggle="modal" data-target="#myModal2"><i class="fa fa-map"></i> Holiday Follow Up</button>
		</div>	
	 	
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
		 	<?php $todAy = date("Y-m-d"); ?>
				<div class="todayssection">
					<div class="col-md-20">
						<div class="callCountBlock">
							<a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}"; ?>">
								<div class="visual">
									<i class="fa fa-bar-chart-o"></i>
								</div>
								<div class="details">
									<div class="number">
										<span data-counter="counterup" data-value="<?php echo $totalContLeadsToday; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalPickCallsToday; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalNotPickCallsToday; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalDecLeadsToday; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalUnworkLeadsToday; ?>">0</span> </div>
									<div class="desc"> Unwork<br> Leads  </div>
								</div>
							</a>
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
											<span data-counter="counterup" data-value="<?php echo $totalQuotSentToday; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalWorkingItiToday; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalApprovedItiToday; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalDecItiToday; ?>">0</span> </div>
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
											<span data-counter="counterup" data-value="<?php echo $totalRevQuotSentToday; ?>">0</span> </div>
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
												<span data-counter="counterup" data-value="<?php echo $pastQuotSentToday; ?>">0</span> </div>
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
											<span data-counter="counterup" data-value="<?php echo $pastApprovedItiToday; ?>">0</span> </div>
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
											<span data-counter="counterup" data-value="<?php echo $pastDeclineItiToday; ?>">0</span> </div>
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
												<span data-counter="counterup" data-value="<?php echo $pastDecLeadsToday; ?>">0</span> </div>
											<div class="desc">Declined <br>Revised Leads  </div>
											
										</div>
									</a>
								</div>
							</div>	
						</div>
					</div><!--Todays full stat -->	
					
					
				<!---------------------------------End Todays Revised section ---------------------------->
				
				<?php /*
				<div class="col-md-2">
					<div class="callCountBlock">
						<a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=callpicked"; ?>">
							<div class="visual">
								<i class="fa fa-bar-chart-o"></i>
							</div>
							<div class="details">
								<div class="number">
									<span data-counter="counterup" data-value="<?php echo $totalPickCallsToday; ?>">0</span> </div>
								<div class="desc"> Total Call <br>Picked Today </div>
							</div>
						</a>
					</div>	
					
				</div>
				<div class="col-md-2">
					<div class="callCountBlock">
						<a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=8"; ?>">
							<div class="visual">
								<i class="fa fa-bar-chart-o"></i>
							</div>
							<div class="details">
								<div class="number">
									<span data-counter="counterup" data-value="<?php echo $totalDecLeadsToday; ?>">0</span> </div>
								<div class="desc"> Total Declined <br>Leads Today </div>
							</div>
						</a>
					</div>
				</div>	
				<div class="col-md-2">
					<a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=7"; ?>">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								<span data-counter="counterup" data-value="<?php echo $totalDecItiToday; ?>">0</span> </div>
							<div class="desc"> Total Declined <br>Itineraries Today </div>
						</div>
					</a>
				</div>
				<div class="col-md-2">
					<div class="callCountBlock">
						<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=Qsent&quotation=true"; ?>">
							<div class="visual">
								<i class="fa fa-bar-chart-o"></i>
							</div>
							<div class="details">
								<div class="number">
									<span data-counter="counterup" data-value="<?php echo $totalQuotSentToday; ?>">0</span> </div>
								<div class="desc"> Quotations<br> Sent Today </div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-md-2">
					<div class="callCountBlock">
						<a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries"). "/?todayStatus={$todAy}&leadStatus=QsentRevised&quotation=true"; ?>">
							<div class="visual">
								<i class="fa fa-bar-chart-o"></i>
							</div>
							<div class="details">
								<div class="number">
									<span data-counter="counterup" data-value="<?php echo $totalRevQuotSentToday; ?>">0</span> </div>
								<div class="desc"> Revised Quotations <br> Sent Today </div>
							</div>
						</a>
					</div>
					
				</div>
				<div class="col-md-2">
				<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=callnotpicked"; ?>">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								<span data-counter="counterup" data-value="<?php echo $totalNotPickCallsToday; ?>">0</span> </div>
							<div class="desc"> Total Call <br>Not Picked Today </div>
						</div>
					</a>
				</div>	
				
			</div> */ ?>
			<div class="clearfix"></div>
			
		</div>
		<!-- End Today section -->
		</div> <!--portlet close -->
		
		<div class="clearfix"></div>
		<!-- END DASHBOARD STATS 1-->
		
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
									<th>Name</th>
									<th>Contact No</th>
									<th>Agent</th>
									<th>Action</th>
								
								</tr>
								<?php if( $totalLeadsToday ) { 
									$i = 1;	
									foreach( $totalLeadsToday as $t_leads ){ ?>	
									
									<tr>
										<td><?php echo $t_leads->customer_name;?></td>
										<!--td><?php //echo $t_leads->customer_email;?></td-->
										<td><?php echo $t_leads->customer_contact;?></td>
										<td><?php echo get_user_name( $t_leads->agent_id);?></td>
										
										<td><a class="btn btn-custom" href="<?php echo site_url("customers/view/{$t_leads->customer_id}/{$t_leads->temp_key}"); ?>"> View</a></td>
									</tr>
									
									<?php } 
								}else{ ?>	
									<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
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
								<th>Name</th>
								<th>Contact No</th>
								<th>Call Date</th>
								<th>Call Time</th>
								<th>Action</th>
							
							</tr>
								<?php if( $leadsFollowupToday ) { 
									$i = 1;	
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
										<tr><td colspan="5"><?php echo $cc; ?></td></tr>
										<tr class="<?php echo $red_class; ?>">
											<td><?php echo $c_name;?></td>
											<td><?php echo $c_number;?></td>
											<td><?php echo $d[0];?></td>
											<td><?php echo $d[1]. ' '.$d[2];?></td>
											
											<td><a class="btn btn-custom" href="<?php echo site_url("customers/view/{$followToday->customer_id}/{$followToday->temp_key}"); ?>"> View</a></td>
										</tr>					
										
									<?php } 
								}else{ ?>	
									<tr><td colspan="5"><div class="mt-comment-text"> No Data found. </div></td></tr>
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
									<tr><td colspan="8" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
								<?php } ?>
								</table>
							</div>
						</div>
						</div>
						
					</div>
				</div>
			</div>
			<hr>  */?>
			<!--Rates section-->
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
										<th>Name</th>
										<th>Contact No</th>
										<th>Agent</th>
										<th>Action</th>
									
									</tr>
									<?php if( $itiPendingRates ) { 
										foreach( $itiPendingRates as $pendingRates ){ 	?>
										
										<?php //Get customer info
												$get_customer_info = get_customer( $pendingRates->customer_id ); 
												$cust = $get_customer_info[0];
												if( !empty( $get_customer_info ) ){  
													$cust_name = $cust->customer_name;
													$cust_no = $cust->customer_contact;
												} 
												$agent_id = $pendingRates->agent_id;
												$user_info = get_user_info($agent_id);
												if($user_info){
													$agent = $user_info[0];
													$a_name = $agent->first_name . " " . $agent->last_name;
												}	
											?>
											<tr><td colspan="4"><span class="lead_app arrow_bottom"><?php echo $pendingRates->package_name;?></span></td></tr>
											<tr>
												<td><?php echo $cust_name;?></td>
												<td><?php echo $cust_no;?></td>
												<td><?php echo $a_name;?></td>
												<td><a class="btn btn-custom" href="<?php echo site_url("itineraries/view/{$pendingRates->iti_id}/{$pendingRates->temp_key}"); ?>"> View</a></td>
											</tr>
											
											<?php //check for child itinerary
												$child_iti = check_child_iti( $pendingRates->iti_id );
												$count_records = count( $child_iti ) ; 
												//if child iti exists
												if( !empty( $child_iti ) && $count_records > 1 ){
													$cl = 1; 
													
														?>
														<tr><td colspan="4">
													<?php foreach( $child_iti as $c_iti ){ ?>
													
														<?php if( $cl == 1 ){ ?>
															<a class="btn btn-custom" href="<?php echo site_url("itineraries/view/{$c_iti->iti_id}/{$c_iti->temp_key}"); ?>">View Parent <strong><?php echo $c_iti->iti_id; ?></strong></a>
														<?php }else{ ?>
															<a class="btn btn-custom" href="<?php echo site_url("itineraries/view/{$c_iti->iti_id}/{$c_iti->temp_key}"); ?>">View Child <strong><?php echo $c_iti->iti_id; ?></strong></a>
														<?php } ?>
															
																		
													<?php 
														$cl++;
													} ?>
													</td>	</tr>
												<?php } ?> 
										<?php } 
									}else{ ?>	
										<tr><td colspan="4" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
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
								<table class="table table-bordered table-striped d-table table-fixed">
										<thead>
										<tr>
											<th>Name</th>
											<th>Contact No</th>
											<th>Agent</th>
											<th>Action</th>
										
										</tr>
										</thead>
										<tbody>
									<?php if( $itiAppRates ) { 
										foreach( $itiAppRates as $itirates ){ 	
										
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
						
													<tr><td colspan="4"><span class="lead_app arrow_bottom"><?php echo $itirates->package_name;?><span></td></tr>
													
													
													<tr>
														<td><?php echo $cust_name;?></td>
														<td><?php echo $cust_no;?></td>
														<td><?php echo $a_name;?></td>
														<td><a class="btn btn-custom" href="<?php echo site_url("itineraries/view/{$itirates->iti_id}/{$itirates->temp_key}"); ?>"> View</a></td>
													</tr>
										<?php } 
									}else{ ?>	
										<tr><td colspan="4" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
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
 
			
			
			<div class="total-leads-for-month">
				<div class="month_section">
			 		<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-handshake-o" aria-hidden="true"></i> Month's Status</div>
						</div>
				
				<div class="portlet-body">
				<div class="row">
					<div class="col-md-20">
						<a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("customers") . "/?leadfrom={$from}&leadto={$to}"; ?>">
							<div class="visual">
								<i class="fa fa-shopping-cart"></i>
							</div>
							<div class="details">
								<div class="number">
									<span data-counter="counterup" data-value="<?php echo $totalLeadsMonth; ?>">0</span>
								</div>
								<div class="desc"> Total Leads<br> </div>
							</div>
						</a>
					</div>
					<div class="col-md-20">
						<div class="callCountBlock">
							<a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=callpicked"; ?>">
								<div class="visual">
									<i class="fa fa-bar-chart-o"></i>
								</div>
								<div class="details">
									<div class="number">
										<span data-counter="counterup" data-value="<?php echo $totalPickCallsMonth; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalNotPickCallsMonth; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalDecLeadsMonth; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalUnworkLeadsMonth; ?>">0</span> </div>
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
											<span data-counter="counterup" data-value="<?php echo $totalQuotSentMonth; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalWorkingItiMonth; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalApprovedItiMonth; ?>">0</span> </div>
									<div class="desc"> Total Approved <br>Itineraries This </div>
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
										<span data-counter="counterup" data-value="<?php echo $totalDecItiMonth; ?>">0</span> </div>
									<div class="desc"> Total Declined <br>Itineraries This </div>
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
											<span data-counter="counterup" data-value="<?php echo $totalRevQuotSentMonth; ?>">0</span> </div>
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
											<span data-counter="counterup" data-value="<?php echo $pastQuotSentMonth; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $pastApprovedItiMonth; ?>">0</span> </div>
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
										<span data-counter="counterup" data-value="<?php echo $pastDeclineItiMonth; ?>">0</span> </div>
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
											<span data-counter="counterup" data-value="<?php echo $pastDecLeadsMonth; ?>">0</span> </div>
										<div class="desc"> Total Revised Declined <br>Leads </div>
									</div>
								</a>
							</div>
						</div>	
					</div>
				</div><!--End month full stats-->
				</div> <!-- row -->		
				</div> <!-- portlet-body -->		
			</div>	
			</div>
			</div>	
				<!---------------------------------End Todays Revised section ---------------------------->
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
						<div id='calendar_customer_followup'></div>
					</div>
				</div>
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->
	
	

	<!-- ITINERARIES FOLLOW UP -->
	<div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel2">ITINERARIES FOLLOW UP</h4>
				</div>
				<div class="col-md-12 column" id="iti_folloup_cal_section">
				 	<div id='calendar_iti_followup'></div>
				</div>
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->
	
	
 



<script type="text/javascript">
/**************** CUSTOMER FOLLOW UP CALENDAR ****************/
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
        events: base_url+'dashboard/getAllCustomerFollowup',
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
				'<span data-event_id ="event_'+ event.id +'">' + event.nextCall + '</span><br/>' 
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
					var html = '<a class="event_link" href="#"><span class="event-count">' + 
								'<i>' +
								eventCount + 
								'</i>' +
								' Calls' +
								'</span></a>';
					dayEl.append(html);
				} */
			}
		},
	});
/**************** END CUSTOMER FOLLOW UP CALENDAR ****************/
/**************** ItinerariesFOLLOW UP CALENDAR ****************/
    // Fullcalendar
    $('#calendar_iti_followup').fullCalendar({
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
				'<span data-event_id ="event_'+ event.id +'">' + event.nextCall + '</span><br/>' 
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
});	
/**************** End ItinerariesFOLLOW UP CALENDAR ****************/




</script>
