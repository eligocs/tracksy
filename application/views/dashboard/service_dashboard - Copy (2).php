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
<div class="page-content-wrapper">
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
						<li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
						<li class="color-darkblue tooltips" data-style="theme_dark" data-container="body" data-original-title="Theme Dark"> </li>
						<li class="color-blue tooltips" data-style="theme_light" data-container="body" data-original-title="Theme Light"> </li>
					</ul>
				</div>
				<div class="th_response"></div>
			</div>
		</div>
		
		<!--div class="more-info-right-sidebar">
			<button class="btn blue sidebar-button btn-side-1" data-toggle="modal" data-target="#myModal2"><i class="fa fa-money"></i> Payment Follow Up</button>
			<button class="btn blue sidebar-button btn-side-2" data-toggle="modal" data-target="#myModal3"><i class="fa fa-money"></i> Travel Dates</button>
		</div-->
		
		<nav class="quick-nav">
            <a class="quick-nav-trigger" href="javascript: void(0)">
                <span aria-hidden="true"></span>
            </a>
            <ul class="sidebar-buttons">
                <li><button class="btn" id="btn_load_payment_followup"><i class="fa fa-money"></i> Payment Follow Up</button></li>
				<li><button class="btn" id="btn_load_ad_payment_followup"><i class="fa fa-money"></i> Advance Payment Follow Up</button></li>
				<li><button class="btn" id="btn_load_balance_payment_followup"><i class="fa fa-money"></i> Balance Payment Follow Up</button></li>
				<li><button class="btn" id="btn_load_travel_followup"><i class="fa fa-clock-o"></i> Travel Dates Follow</button></li>
            </ul>
            <span aria-hidden="true" class="quick-nav-bg"></span>
			
        </nav>
		<div class="quick-nav-overlay"></div>
		<!--div class="more-info-right-sidebar">
			<button class="btn blue sidebar-button btn-side-1" id="btn_load_payment_followup"><i class="fa fa-money"></i> Payment Follow Up</button>
			<button class="btn blue sidebar-button btn-side-1" id="btn_load_ad_payment_followup"><i class="fa fa-money"></i> Advance Payment Follow Up</button>
			<button class="btn blue sidebar-button btn-side-2" id="btn_load_balance_payment_followup"><i class="fa fa-money"></i> Balance Payment Follow Up</button>
			<button class="btn blue sidebar-button btn-side-2" id="btn_load_travel_followup"><i class="fa fa-clock-o"></i> Travel Dates Follow</button>
		</div-->
		
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
		
		<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-calendar"></i>Today's Status</div>
				</div>
		</div>		
				
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="callCountBlock">
				<a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("payments"). "/?todayStatus={$today_date}&payStatus=pending"; ?>">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="<?php echo isset($pendingPaymentsToday) ? $pendingPaymentsToday : 0; ?>">0</span>
						</div>
						<div class="desc"> Payments Pending Today </div>
					</div>
				</a>
			</div>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="callCountBlock">
				<a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("payments"). "/?todayStatus={$today_date}&payStatus=pay_received"; ?>">
					<div class="visual">
						<i class="fa fa-comments"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="<?php echo isset($receivedPaymentsToday) ? $receivedPaymentsToday : 0; ?>">0</span>
						</div>
						<div class="desc"> Payments Received Today </div>
					</div>
				</a>
			</div>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="callCountBlock">
				<a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("payments"). "/?todayStatus={$this_month}&payStatus=pending"; ?>">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="<?php echo isset($pendingPaymentsMonth) ? $pendingPaymentsMonth : 0; ?>">0</span>
						</div>
						<div class="desc"> Payments Pending This Month </div>
					</div>
				</a>
			</div>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
			<div class="callCountBlock">
				<a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("payments"). "/?todayStatus={$this_month}&payStatus=pay_received"; ?>">
					<div class="visual">
						<i class="fa fa-comments"></i>
					</div>
					<div class="details">
						<div class="number">
							<span data-counter="counterup" data-value="<?php echo isset($receivedPaymentsMonth) ? $receivedPaymentsMonth : 0; ?>">0</span>
						</div>
						<div class="desc"> Payments Received This Month </div>
					</div>
				</a>
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
					<div class="caption"><i class="fa fa-calendar"></i>Today's Payment</div>
				</div>
			</div>
		
			<div class="col-lg-6 col-xs-12 col-sm-12">
				<div class="portlet light bordered">
					<div class="portlet-title tabbable-line">
						<div class="caption">
							<i class="icon-bubbles font-dark hide"></i>
							<span class="caption-subject font-dark bold uppercase">Pending Payments</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<div class="tab-pane active" id="portlet_comments_1">
								<table class="table table-hover d-table">
									<tr>
										<th>Sr.</th>
										<th>Name</th>
										<th>Contact No</th>
										<th>Payment</th>
										<th>Action</th>
									</tr>
									<?php if( isset($pendingPaymentsFollow) ) { 
										$icount = 1;	
										foreach( $pendingPaymentsFollow as $pen_pay ){ ?>	
										
										<tr>
											<td><?php echo $icount;?>.</td>
											<td><?php echo $pen_pay->customer_name;?></td>
											<!--td><?php //echo $t_leads->customer_email;?></td-->
											<td><?php echo $pen_pay->customer_contact;?></td>
											<td><?php echo $pen_pay->next_payment;?></td>
											
											<td><a class="btn btn-custom" href="<?php echo site_url("payments/update_payment/{$pen_pay->id}/{$pen_pay->iti_id}"); ?>"> View</a></td>
										</tr>
										<?php 
										$icount++;
										} 
									}else{ ?>	
										<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
									<?php } ?>
									<!-- END: Pending Payments section -->
								</table>
							</div>
							<button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
						</div>
					</div>
				</div>
			</div>
			<!--vouchers section -->
			<div class="col-lg-6 col-xs-12 col-sm-12">
				<div class="portlet light bordered">
					<div class="portlet-title tabbable-line">
						<div class="caption">
							<i class=" icon-social-twitter font-dark hide"></i>
							<span class="caption-subject font-dark bold uppercase">Received Payments</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_actions_pending">
								
								<!-- END: Vouchers -->
							</div>
							
					
				</div>			
				</div>			
				</div>	<hr>		
			</div>			
			<div class="clearfix clearboth"></div>
				
				<!--AMENDMENT SECTION-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-calendar"></i>LATEST AMENDMENT</div>
				</div>
			</div>	
			<div class="col-lg-6 col-xs-12 col-sm-12">
				<div class="portlet light bordered">
					<div class="portlet-title tabbable-line">
						<div class="caption">
							<i class="icon-bubbles font-dark hide"></i>
							<span class="caption-subject font-dark bold uppercase">Last 20 Amendments</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<div class="tab-pane active" id="portlet_comments_1">
								<table class="table table-hover d-table">
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
											
											<td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view_iti/{$am_iti->iti_id}/{$am_iti->temp_key}"); ?>"> View</a></td>
										</tr>
										<?php 
										$ii++;
										} 
									}else{ ?>	
										<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
									<?php } ?>
									<!-- END: Pending Payments section -->
								</table>
							</div>
							<button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
						</div>
					</div>
				</div>
			</div>
			<!--REFUND PaymentS-->
			<div class="col-lg-6 col-xs-12 col-sm-12">
				<div class="portlet light bordered">
					<div class="portlet-title tabbable-line">
						<div class="caption">
							<i class="icon-bubbles font-dark hide"></i>
							<span class="caption-subject font-dark bold uppercase">Refund Pending</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<div class="tab-pane active" id="portlet_comments_1">
								<table class="table table-hover d-table">
									<tr>
										<th>Sr.</th>
										<th>Name</th>
										<th>Amount</th>
										<th>Contact</th>
										<th>Action</th>
									</tr>
									<?php if( isset($get_refund_payments) && !empty( $get_refund_payments ) ) { 
										$ir = 1;	
										foreach( $get_refund_payments as $rf_iti ){ ?>	
										
										<tr>
											<td><?php echo $ir;?>.</td>
											<td><?php echo $rf_iti->customer_name;?></td>
											<td><?php echo $rf_iti->refund_amount;?></td>
											<td><?php echo $rf_iti->customer_contact;?></td>
											
											<td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("payments/update_payment/{$rf_iti->id}/{$rf_iti->iti_id}"); ?>"> View</a></td>
										</tr>
										<?php 
										$ir++;
										} 
									}else{ ?>	
										<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
									<?php } ?>
									<!-- END: Pending Payments section -->
								</table>
							</div>
							<button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
						</div>
					</div>
				</div>
			</div>
			<!--End REFUND PaymentS-->
		<div class="clearfix"></div>		
				<!--END AMENDMENT SECTION-->
				<!-- Pending Vouchers  -->
				<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-calendar"></i>LATEST VOUCHERS</div>
				</div>
			</div>	
				<div class="col-lg-6 col-xs-12 col-sm-12">
				<div class="portlet light bordered">
					<div class="portlet-title tabbable-line">
						<div class="caption">
							<i class="icon-bubbles font-dark hide"></i>
							<span class="caption-subject font-dark bold uppercase">Pending Vouchers</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content ">
					                <div class="portlet-body tabbable-line">
                                        <ul class="nav nav-tabs">
                                            <!--li>
                                                <a href="#pending_voucher_cab_booking" data-toggle="tab"> Cab </a>
                                            </li-->

                                            <li class="active">
                                                <a href="#pending_voucher_flight_booking" data-toggle="tab"> Flight/Train </a>
                                            </li>
											<li>
                                                <a href="#pending_voucher_volvo_booking" data-toggle="tab"> Volvo </a>
                                            </li>
                                     
											<li>
                                                <a href="#pending_voucher_hotel_booking" data-toggle="tab"> Hotel </a>
                                            </li>
                                        </ul>
                                <div class="tab-content">
								<!--Pending voucher Hotel Bookings-->
									<div class="tab-pane fade" id="pending_voucher_hotel_booking">
									  <div class="tab-pane active" id="portlet_comments_1">
										<table class="table table-hover d-table">
											<tr>
												<th>Sr.</th>
												<th>Iti id</th>
												<th>Hotel</th>
												<th>Contact No</th>
												<th>Payment</th>
												<th>status</th>
												<th>Action</th>
											</tr>
											<?php if( isset($hotel_booking) && !empty( $hotel_booking ) ){ 
												$i = 1;
												foreach( $hotel_booking as $h_book ){
													//Hotel Contact
													$h_details = get_hotel_details($h_book->hotel_id);
													$h_contact = !empty( $h_details ) ? $h_details[0]->hotel_contact : "";
													$pay_received = get_iti_pay_receive_percentage($h_book->iti_id);
													
													//if payment received 50% and booking approved or above continue loop
													//if( $h_book->booking_status == 9 && $pay_received >= 50 ) continue;
													
													//Get hotel booking status-->
													$status = "<span class='blue'>Processing</span>";
													
													echo "<tr>
														<td>{$i}.</td>
														<td>{$h_book->iti_id}</td>
														<td> " . get_hotel_name($h_book->hotel_id) . " </td>
														<td>{$h_contact}</td>
														<td>".number_format($h_book->total_cost, "2") ."</td>
														<td>{$status}</td>
														<td><a title='View' target='_blank' href='".site_url("hotelbooking/view/{$h_book->id}/{$h_book->iti_id}") . "' class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a></td>
													</tr>";
												
													$i++;
												} 
											}else{ ?>
												<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
											<?php } ?>
											<!-- END: Pending Payments section -->
										</table>
									</div>
									<button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
									</div>
							<!--End Pending voucher Hotel Bookings-->
							<!--Pending voucher Cab Bookings-->
							<?php /*<div class="tab-pane fade" id="pending_voucher_cab_booking">
							   <div class="tab-pane active" id="portlet_comments_1">
								<table class="table table-hover d-table">
									<tr>
										<th>Sr.</th>
										<th>Iti id</th>
										<th>Transporter</th>
										<th>Contact No</th>
										<th>Payment</th>
										<th>status</th>
										<th>Action</th>
									</tr>
									
									<?php if( !empty( $cab_booking ) ){ 
										$i = 1;
										foreach( $cab_booking as $c_book ){
											//Transporter Contact
											$t_contact = get_transporter_contact($c_book->transporter_id);
											$pay_received = get_iti_pay_receive_percentage($c_book->iti_id);
											
											//if payment received 50% and booking approved or above continue loop
											if( $c_book->booking_status == 9 && $pay_received >= 50 ) continue;
											
											//Get cab booking status-->
											if( $c_book->booking_status == 9)
												$status = "<span class='green'>BOOKED</span>";
											else if($c_book->booking_status == 8)
												$status = "<span class='red'>Declined</span>";
											else if($c_book->booking_status == 7)
												$status = "<span class='red'>Cancel</span>";
											else
												$status = "<span class='blue'>Processing</span>";
											
											echo "<tr>
												<td>{$i}.</td>
												<td>{$c_book->iti_id}</td>
												<td> " . get_transporter_name($c_book->transporter_id) . " </td>
												<td>{$t_contact}</td>
												<td>".number_format($c_book->total_cost, "2") ."</td>
												<td>{$status}</td>
												<td><a target='_blank' title='View' href='".site_url("vehiclesbooking/viewbooking/{$c_book->id}") . "' class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a></td>
											</tr>";
										
											$i++;
										} 
									}else{ ?>
										<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
									<?php } ?>
									<!-- END: Pending Payments section -->
								</table>
							</div>
							<button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
                            </div><!--Pending voucher Cab Bookings--> */ ?>
							
							<!--Pending voucher Vovlo Bookings-->
							<div class="tab-pane fade" id="pending_voucher_volvo_booking">
							   <div class="tab-pane active" id="portlet_comments_1">
								<table class="table table-hover d-table">
									<tr>
										<th>Sr.</th>
										<th>Iti id</th>
										<th>Dep. Date</th>
										<th>status</th>
										<th>Action</th>
									</tr>
									<?php if( isset($volvo_booking) && !empty( $volvo_booking ) ){ 
										$i = 1;
										foreach( $volvo_booking as $v_book ){
											//Payment Received
											$pay_received = get_iti_pay_receive_percentage($v_book->iti_id);
											$dep_date = display_month_name($v_book->dep_date);
											//if payment received 50% and booking approved or above continue loop
											if( $v_book->booking_status == 9 && $pay_received >= 50 ) continue;
											
											//Get hotel booking status-->
											if( $v_book->booking_status == 9)
												$status = "<span class='green'>BOOKED</span>";
											else if($v_book->booking_status == 8)
												$status = "<span class='red'>Cancel</span>";
											else
												$status = "<span class='blue'>Processing</span>";
											
											echo "<tr>
												<td>{$i}.</td>
												<td>{$v_book->iti_id}</td>
												<td>{$dep_date}</td>
												<td>{$status}</td>
												<td><a title='View' target='_blank' href='".site_url("vehiclesbooking/viewvehiclebooking/{$v_book->id}/{$v_book->iti_id}") . "' class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a></td>
											</tr>";
											$i++;
										} 
									}else{ ?>
										<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
									<?php } ?>
									<!-- END: Pending Payments section -->
								</table>
								</div>
							<button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
							</div><!--End voucher Vovlo Bookings-->


							<!--Pending voucher train/flight Bookings-->
							<div class="tab-pane active in" id="pending_voucher_flight_booking">
							   <div class="tab-pane active" id="portlet_comments_1">
								<table class="table table-hover d-table">
									<tr>
										<th>Sr.</th>
										<th>Type</th>
										<th>Iti id</th>
										<th>Dep. Date</th>
										<th>status</th>
										<th>Action</th>
									</tr>
									<?php if( isset($train_flight_booking) && !empty( $train_flight_booking ) ){ 
										$i = 1;
										foreach( $train_flight_booking as $tf_book ){
											//Payment Received
											$pay_received = get_iti_pay_receive_percentage($tf_book->iti_id);
											$dep_date = display_month_name($tf_book->dep_date);
											//if payment received 50% and booking approved or above continue loop
											if( $tf_book->booking_status == 9 && $pay_received >= 50 ) continue;
											
											//Get hotel booking status-->
											if( $tf_book->booking_status == 9)
												$status = "<span class='green'>BOOKED</span>";
											else if($tf_book->booking_status == 8)
												$status = "<span class='red'>Cancel</span>";
											else
												$status = "<span class='blue'>Processing</span>";
											
											echo "<tr>
												<td>{$i}.</td>
												<td>{$tf_book->booking_type}</td>
												<td>{$tf_book->iti_id}</td>
												<td>{$dep_date}</td>
												<td>{$status}</td>
												<td><a title='View' target='_blank' href='".site_url("vehiclesbooking/viewvehiclebooking/{$tf_book->id}/{$tf_book->iti_id}") . "' class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a></td>
											</tr>";
											$i++;
										} 
									}else{ ?>
										<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
									<?php } ?>
									<!-- END: Pending Payments section -->
								</table>
							</div>
							<button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
						</div>
                    </div>
						
						<!--End Pending voucher -->
						</div>
					</div>
				</div>
			</div>
			</div>
			<!-- Confirmed Vouchers -->
			<div class="col-lg-6 col-xs-12 col-sm-12">
				<div class="portlet light bordered">
					<div class="portlet-title tabbable-line">
						<div class="caption">
							<i class="icon-bubbles font-dark hide"></i>
							<span class="caption-subject font-dark bold uppercase">Last 20 Confirmed Vouchers</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<div class="tab-pane active" id="portlet_comments_1">
								<table class="table table-hover d-table">
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
											<td><a class="btn btn-custom" target="_blank" href="<?php echo site_url("itineraries/view_iti/{$cnfrm_voucher->iti_id}/{$cnfrm_voucher->temp_key}"); ?>"> View</a></td>
										</tr>
										<?php 
											$cnt++;
										} 
									}else{ ?>	
										<tr><td colspan="5" class="text-center"><div class="mt-comment-text"> No Data found. </div></td></tr>
									<?php } ?>
									<!-- END: Pending Payments section -->
								</table>
							</div>
							<button type="button" class="btn purple view_table_data"><i class="fa fa-angle-down"></i> View All</button>
						</div>
					</div>
				</div>
			</div>
			<!--div class="col-md-12 column calander-section" id="customer_folloup_cal_section">
				<h3 class="text-center page-title">PAYMENT FOLLOW UP </h3>
				<div id='calendar_payment_followup'></div>
			</div-->
			 
		</div>
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel3">Travel Dates</h4>
			</div>
			<div class="col-md-12 column" id="travel_cal_section">
				<div id='calendar_travel_dates'  class='calender_dashboard'></div>
			</div>
		</div><!-- modal-content -->
	</div><!-- modal-dialog -->
</div><!-- modal -->

<script type="text/javascript">
/**************** Payment FOLLOW UP CALENDAR ****************/
jQuery(document).ready(function($){
	//payment follow up btn
	$("#btn_load_payment_followup").on("click", function(e){
		e.preventDefault();
		$(".modal").modal("hide");
		$("#myModal2").modal("show");
		payment_followup();
		//$(".calender_dashboard").fullCalendar("render");
		setTimeout(function () {
			$(".calender_dashboard").fullCalendar("render");
		}, 300); // Set enough time to wait until animation finishes;
	});
	
	//Advance payment follow up btn
	$("#btn_load_ad_payment_followup").on("click", function(e){
		e.preventDefault();
		$(".modal").modal("hide");
		$("#myModal4").modal("show");
		advance_payment_followup();
		setTimeout(function () {
			$(".calender_dashboard").fullCalendar("render");
		}, 300); // Set enough time to wait until animation finishes;
	});
	
	//Balance payment follow up btn
	$("#btn_load_balance_payment_followup").on("click", function(e){
		e.preventDefault();
		$(".modal").modal("hide");
		$("#myModal5").modal("show");
		balance_payment_followup();
		setTimeout(function () {
			$(".calender_dashboard").fullCalendar("render");
		}, 300); // Set enough time to wait until animation finishes;
	});
	
	//Travel button
	$("#btn_load_travel_followup").on("click", function(e){
		e.preventDefault();
		$(".modal").modal("hide");
		$("#myModal3").modal("show");
		travel_dates_followup();
		setTimeout(function () {
			$(".calender_dashboard").fullCalendar("render");
		}, 300); // Set enough time to wait until animation finishes;
	});
	
	
	//payment follow up calendar
	function payment_followup(){
		var base_url='<?php echo base_url(); ?>'; // Here i define the base_url
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
			events: base_url+'dashboard/getAllPaymentFollowupCalendar',
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
					'<span data-event_id ="event_'+ event.id +'"> Amount: ' + event.amount + '/-</span><br/>' 
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
	} 
	
	//advance_payment_followup follow up calendar
	function advance_payment_followup(){
		var base_url='<?php echo base_url(); ?>'; // Here i define the base_url
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
			events: base_url+'dashboard/advance_payment_pending_followup?type=1', // Type 1 = pay received less than 50%
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
					'<span data-event_id ="event_'+ event.id +'"> Amount: ' + event.amount + '/-</span><br/>' 
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
	}
	
	//balance_payment_followup follow up calendar
	function balance_payment_followup(){
		var base_url='<?php echo base_url(); ?>'; // Here i define the base_url
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
			events: base_url+'dashboard/advance_payment_pending_followup?type=2', // Type 2 = pay pending less than 50%
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
					'<span data-event_id ="event_'+ event.id +'"> Amount: ' + event.amount + '/-</span><br/>' 
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
	}
	
	//Travel Follow Up 
	function travel_dates_followup(){
		var base_url='<?php echo base_url(); ?>'; // Here i define the base_url
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
			events: base_url+'dashboard/getAllTravelDatesCalendar',
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
				/* var new_description = 
					'<span data-event_id ="event_'+ event.id +'"> Amount: ' + event.amount + '/-</span><br/>' 
				;
				element.append(new_description); */
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
	}

});
</script>	
