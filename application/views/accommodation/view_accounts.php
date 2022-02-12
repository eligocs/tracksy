<!--link href="<?php echo base_url();?>site/assets/css/lightbox.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>site/assets/js/lightbox-plus-jquery.min.js" type="text/javascript"></script-->
<style>.showonPchange, .new_pricesend{display: none;}</style>
<style>.mt-element-step .step-line .mt-step-number>i{top: 78%; }</style>
<div class="page-container itinerary-view">
	<div class="page-content-wrapper">
		<div class="page-content">
		<!-- BEGIN SAMPLE TABLE PORTLET-->
		<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>';}
		?>
			<?php if( !empty($itinerary[0] ) ){
				$iti = $itinerary[0];
				$doc_path =  base_url() .'site/assets/client_docs/';
				$is_amendment = $amendment_note = "";
				//show amendment note if revised itinerary
				if( $iti->is_amendment == 2 ){ 
					$is_amendment = "<h3 class='text-center red'>REVISED ITINERARY</h3>";
					$amendment_cmt = $this->global_model->getdata( "iti_amendment_temp", array( "iti_id" => $iti->iti_id ) );
					$amendment_note = !empty( $amendment_cmt ) ? "<p class='red'>Amendment: {$amendment_cmt[0]->review_comment}</p>" : "";
				} 
				
				//print_r( $iti );
				//get terms	
				$terms = get_hotel_terms_condition();
				$online_payment_terms	 	= isset($terms[0]) && !empty($terms[0]->bank_payment_terms_content) ? unserialize($terms[0]->bank_payment_terms_content) : "";
				$advance_payment_terms		= isset($terms[0]) && !empty($terms[0]->advance_payment_terms) ? unserialize($terms[0]->advance_payment_terms	) : "";
				$cancel_tour_by_client 		= isset($terms[0]) && !empty($terms[0]->cancel_content) ? unserialize( $terms[0]->cancel_content) : "";
				$terms_condition			= isset($terms[0]) && !empty($terms[0]->terms_content) ? unserialize($terms[0]->terms_content) : "";
				$disclaimer 				= isset($terms[0]) && !empty($terms[0]->disclaimer_content) ? htmlspecialchars_decode($terms[0]->disclaimer_content) : "";
				$greeting 					= isset($terms[0]) && !empty($terms[0]->greeting_message) ? $terms[0]->greeting_message : "";
				$amendment_policy			= isset($terms[0]) && !empty($terms[0]->amendment_policy) ? unserialize( $terms[0]->amendment_policy) : "";
				$book_package_terms			= isset($terms[0]) && !empty($terms[0]->book_package) ? unserialize( $terms[0]->book_package) : "";
				$signature					= isset($terms[0]) && !empty($terms[0]->promotion_signature) ?  htmlspecialchars_decode($terms[0]->promotion_signature) : "";
				$payment_policy				= isset($terms[0]) && !empty($terms[0]->payment_policy) ? unserialize($terms[0]->payment_policy) : "";
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$cust = $get_customer_info[0];
				$customer_name 		= !empty($get_customer_info) ? $cust->customer_name : "";
				$customer_contact 	= !empty($get_customer_info) ? $cust->customer_contact : "";
				$customer_email 	= !empty($get_customer_info) ? $cust->customer_email : "";
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$customer_name = $customer_contact = $customer_email = $ref_name = $ref_contact = $cus_type = "";
				$country_name 	= isset($get_customer_info[0]) ? get_country_name($get_customer_info[0]->country_id) : "";
				$state_name 	= isset($get_customer_info[0]) ? get_state_name($get_customer_info[0]->state_id) : "";
				if( $get_customer_info ){
					$cust = $get_customer_info[0];
					$customer_name 		= $cust->customer_name;
					$customer_contact 	= $cust->customer_contact;
					$customer_email		= $cust->customer_email;
					$cus_type 			= get_customer_type_name($cust->customer_type);
					if( $cust->customer_type == 2 ){
						$ref_name = "< Ref. Name: " . $cust->reference_name;
						$ref_contact = " Ref. Contact: " . $cust->reference_contact_number . " >";
					}
				}
				?>
				<div class="portlet box blue mb0">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i> 
							<strong>Customer Id: </strong><span class="mehroon"> <?php echo $iti->customer_id; ?></span> &nbsp; &nbsp;
							<?php if( is_admin_or_manager() ){ ?>
								<strong>Customer Type: </strong><span class="mehroon"><?php echo $cus_type; ?>&nbsp; &nbsp;
								</span> <?php echo $ref_name . $ref_contact; ?>
							<?php } ?>
							Q. Type: <strong class="red"> <?php echo check_iti_type( $iti->iti_id ) . ' ( ' . $iti->iti_package_type . ')'; ?></strong>
							
							<?php echo !empty($country_name) ? " From: <span class='red'>" . $country_name . " ( $state_name ) </span>" : ""; ?>
						</div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("itineraries"); ?>" title="Back">Back</a>
						<a class="btn btn-info pull-right" style='margin: 5px;' onclick="Print_iti();" href="javscript:void(0)" title="Back">Print</a>
					</div>
				</div>
				<!--if final_amount exits-->
					<?php  /* if( isset( $paymentDetails[0] ) && !empty( $paymentDetails[0] ) && $iti->iti_status == 9 ){
						$pay_detail = $paymentDetails[0];
						$is_gst_final = $pay_detail->is_gst == 1 ? "GST Inc." : "GST Extra";
						
						if( $iti->iti_close_status == 1 ){
							$close_status = "<strong class='red'>ITINERARY CLOSED</strong>";
							$invoice_btn = "";
						}else{
							$close_status = "<strong class='green'>ITINERARY OPEN</strong>";
							$invoice_btn = "<a target='_blank' href='" . site_url("/accounts/create_invoice/{$iti->customer_id}") . "' title='Click here to generate invoice' class='btn btn-success'>Click Here To Generate Invoice</a>";
						}
						echo "<h1 class='text-center'>" . $close_status. "</h1>";
						?>
						
						<div class="mt-element-step">
							<div class="row step-background-thin ">
								<div class="col-md-4 bg-grey-steel mt-step-col error ">
									<div class="mt-step-number">1</div>
									<div class="mt-step-title uppercase font-grey-cascade"><strong>INR <?php echo $iti->final_amount; ?>/- </strong></div>
									
									<div class="mt-step-content font-grey-cascade">Package Final Cost: <span style="color: #fff;">(<?php echo $is_gst_final;  ?>)</span></div>
								</div>
								<div class="col-md-4 bg-grey-steel mt-step-col active">
									<div class="mt-step-number">2</div>
									<div class="mt-step-title uppercase font-grey-cascade"><strong><?php echo $iti->approved_package_category; ?></strong></div>
									<div class="mt-step-content font-grey-cascade">Package Category</div>
								</div>
								<div class="col-md-4 bg-grey-steel mt-step-col done">
									<?php $t_date = get_travel_date($iti->iti_id); ?>
									<div class="mt-step-number">3</div>
									<div class="mt-step-title uppercase font-grey-cascade"><?php echo !empty($t_date) ? $t_date : "--/--/----"; ?></strong></div>
									<div class="mt-step-content font-grey-cascade">Travel Date</div>
								</div>
							</div>
						</div>
					<?php }  */?>
				
				<?php 
				//Insert Rate meta if price is empty
				$get_rate_meta = unserialize( $iti->rates_meta );
				$hotel_meta = unserialize($iti->hotel_meta); 
				$check_hotel_cat = array();
				$check_hotel_cat = !empty($hotel_meta) ? array_column($hotel_meta, "hotel_inner_meta" ) : "";
				
				//Get all category
				$all_hotel_cats = [];
				foreach( $check_hotel_cat as $date => $array ) {
					$all_hotel_cats = array_merge($all_hotel_cats, array_column($array, "hotel_category"));
				}
				
				/* echo "<pre>";
					print_r( $all_hotel_cats );
				echo "</pre>"; */
				
				$is_standard	= !empty($all_hotel_cats) && in_array("Standard", $all_hotel_cats) ? TRUE : FALSE;
				$is_deluxe		= !empty($all_hotel_cats) && in_array("Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
				$is_s_deluxe 	= !empty($all_hotel_cats) && in_array("Super Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
				$is_luxury 		= !empty($all_hotel_cats) && in_array("Luxury", $all_hotel_cats ) ? TRUE : FALSE;
				
				//add required if category exists
				$st_req = !empty( $is_standard ) ? "required='required'" : "readonly='readonly'";
				$d_req = !empty( $is_deluxe ) ? "required='required'" : "readonly='readonly'";
				$sd_req = !empty( $is_s_deluxe ) ? "required='required'" : "readonly='readonly'";
				$l_req = !empty( $is_luxury ) ? "required='required'" : "readonly='readonly'";
				?>
				
				<!--GENERATE INVOICE AND PROCEED TO SERVICE TEAM SECTION-->
				<?php if( isset( $paymentDetails[0] ) && !empty( $paymentDetails[0] ) && $iti->iti_status == 9 ){ 
				
					$pay_detail = $paymentDetails[0];
					//$is_gst_final = $pay_detail->is_gst == 1 ? "GST Inc." : "GST Extra";
					$is_gst_final = "";
					
					if( $iti->iti_close_status == 1 ){
						$close_status = "<strong class='red'>ITINERARY CLOSED</strong>";
						$invoice_btn = "";
					}else{
						$close_status = "<strong class='green'>ITINERARY OPEN</strong>";
						$invoice_btn = "<a target='_blank' href='" . site_url("/accounts/create_receipt/{$iti->customer_id}") . "' title='Click here to generate invoice' class='btn btn-success'>Click Here To Generate Receipt</a>";
					}
					echo "<h1 class='text-center'>" . $close_status. "</h1>";
						
					//$pay_detail = $paymentDetails[0];
					$doc_path =  base_url() .'site/assets/client_docs/';
					//$is_gst_final = $paymentDetails[0]->is_gst == 1 ? "GST Inc." : "GST Extra";
					$is_gst_final = "";
					//$close_status = !empty($iti->iti_close_status) ? "<strong class='red'>ITINERARY CLOSED</strong>" : "<strong class='green'>ITINERARY OPEN</strong>";
					//echo "<h1 class='text-center'>" . $close_status. "</h1>"; 
					?>
				
					<div class="mt-element-step">
						<div class="row step-background-thin ">
							<div class="col-md-4 bg-grey-steel mt-step-col error ">
								<div class="mt-step-number">1</div>
								<div class="mt-step-title uppercase font-grey-cascade"><strong>INR <?php echo $iti->final_amount; ?>/- </strong></div>
								
								<div class="mt-step-content font-grey-cascade">Package Final Cost: <span style="color: #fff;">(<?php echo $is_gst_final;  ?>)</span></div>
							</div>
							<div class="col-md-4 bg-grey-steel mt-step-col active">
								<div class="mt-step-number">2</div>
								<div class="mt-step-title uppercase font-grey-cascade"><strong><?php echo $iti->approved_package_category; ?></strong></div>
								<div class="mt-step-content font-grey-cascade">Package Category</div>
							</div>
							<div class="col-md-4 bg-grey-steel mt-step-col done">
								<?php $t_date = get_travel_date($iti->iti_id); ?>
								<div class="mt-step-number">3</div>
								<div class="mt-step-title uppercase font-grey-cascade"><?php echo !empty($t_date) ? $t_date : "--/--/----"; ?></strong></div>
								<div class="mt-step-content font-grey-cascade">Travel Date</div>
							</div>
						</div>
					</div>
					
					<div class="clearfix"></div>
					<div class="mt-element-step">
						<div class="row step-background-thin ">
							<div class="col-md-4 bg-grey-steel mt-step-col done ">
								<div class="mt-step-number">1</div>
								<div class="mt-step-title uppercase font-grey-cascade"><strong>INR <?php echo $paymentDetails[0]->advance_recieved; ?>/- </strong></div>
								<div class="mt-step-content font-grey-cascade">Advance Recieved </div>
							</div>
							<div class="col-md-4 bg-grey-steel mt-step-col error">
								<div class="mt-step-number">2</div>
								<div class="mt-step-title uppercase font-grey-cascade"><strong><?php echo $paymentDetails[0]->total_balance_amount; ?>/-</strong></div>
								<div class="mt-step-content font-grey-cascade">Balance Pending</div>
							</div>
							<div class="col-md-4 bg-grey-steel mt-step-col active">
								<?php $booking_d = $paymentDetails[0]->booking_date; ?>
								<div class="mt-step-number">3</div>
								<div class="mt-step-title uppercase font-grey-cascade"><?php echo !empty($booking_d) ? display_month_name($booking_d ) : "--/--/----"; ?></strong></div>
								<div class="mt-step-content font-grey-cascade">Booking Date</div>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<!--show payment screenshot details-->
						<hr>
						<div id="update_iti_hold_status">
							<!-- client_aadhar_card payment_screenshot -->
							<?php
								$aadhar_card_img = !empty( $pay_detail->client_aadhar_card ) ? $pay_detail->client_aadhar_card : "";
								$payment_screenshot = !empty( $pay_detail->payment_screenshot ) ? $pay_detail->payment_screenshot : "";
							?>
							<div class="col-md-4">
								<h4 class="uppercase">Aadhar Card Screenshot</h4>
								<?php if($aadhar_card_img){ ?>
									<a target="_blank" href="<?php echo $doc_path . $aadhar_card_img; ?>" class="example-image-link" data-lightbox="example-set"  data-title="Adhar card Screenshot.">
										<img src="<?php echo $doc_path . $aadhar_card_img; ?>" width="150" height="150" class="image-responsive">
									</a>
								<?php }else{
									echo "<strong class='red'>Aadhar card Not Updated</strong>";
									//echo '<img src=" ' . $doc_path . 'dummy.jpg" width="150" height="150" class="image-responsive">';
								} ?>
							</div>
							<div class="col-md-4">
								<h4 class="uppercase">Payment Screenshot</h4>
								<?php if($payment_screenshot){ ?>
									<a target="_blank" href="<?php echo $doc_path . $payment_screenshot; ?>" class="example-image-link" data-lightbox="example-set"  data-title="Client Payment Screenshot.">
										<img src="<?php echo $doc_path . $payment_screenshot; ?>" width="150" height="150" class="image-responsive">
									</a>
								<?php }else{
									echo "<strong class='red'>Payment Screenshot Not Updated</strong>";
									//echo '<img src=" ' . $doc_path . 'dummy.jpg" width="150" height="150" class="image-responsive">';
								} ?>
							</div>
							<div class="col-md-4">
								<h4 class="uppercase">Iti Status</h4>
								<?php 
								if( $pay_detail->iti_booking_status == 0 ){
									echo "<strong class='green'>APPROVED</strong>";
								}else if( $pay_detail->iti_booking_status == 1 ){ 
									echo '<strong class="red">ON HOLD</strong>';
								}else{ 
									echo '<strong class="red">REJECTED BY SALES MANAGER</strong>';
								} ?>
								<p><span class="red">Comment: </span><?php echo $pay_detail->approved_note; ?></p>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-12 other_docs">
								<?php if (isset( $iti_clients_docs ) && !empty( $iti_clients_docs ) ){
									echo '<hr><h4 class="uppercase">Other Documents</h4>'; ?>
									<div class="table-responsive">
										<table class="table table-striped table-hover">
											<thead class="thead-default">
												<tr>
													<th> Sr. </th>
													<th> Title</th>
													<th> Comment</th>
													<th> Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$docindex = 1; 
												foreach( $iti_clients_docs as $ind => $doc ){
													echo "<tr>";
														echo "<td>" . $docindex . "</td>";
														echo "<td>" . $doc->file_url . "</td>";
														echo "<td>" . $doc->comment . "</td>";
														echo "<td>"; ?>
															<a href="<?php echo $doc_path . $doc->file_url; ?>" target="_blank" class="btn btn-success" style="position:relative;">
															<i class="fa fa-eye"></i> View</a>
															</td>
														<?php 	
													echo "</tr>";	
													$docindex++;
												} ?>
											</tbody>	
										</table>	
									</div>	
								<?php } ?>
							</div>
				<?php } ?>
				<!--END GENERATE INVOICE AND PROCEED TO SERVICE TEAM -->
				
				<?php if( $iti->iti_close_status == 0 ){ ?>
					<!--VOUCHER GENERATION SECTION IF ITINERARY OPEN-->
					<hr>
					<?php 
						$hotel_booking_status 		= is_hotel_booking_done( $iti->iti_id );
						$vtf_booking_status			= is_vtf_booking_done( $iti->iti_id );
						$cab_booking_status			= is_cab_booking_done( $iti->iti_id );
						$total_payment_recieved_percentage = get_iti_pay_receive_percentage( $iti->iti_id );
						$is_voucher_confirm			 = is_voucher_confirm( $iti->iti_id );
						
						$pay_class 	=  $total_payment_recieved_percentage >= 50 ? "done" : "error"; 
						$hotel_class	 =  !empty( $hotel_booking_status ) ? "done" : "error";
						$vtf_class	 =  !empty($vtf_booking_status) ? "done" : "error"; 
						$cab_class	 =  !empty($cab_booking_status) ? "done" : "error"; ?>
					<div class="mt-element-step">
						<div class="row step-line">
							<div class="mt-step-desc">
								<div class="font-dark bold uppercase text-center"><h2>BOOKING STATUS</h2></div>
								<div class="caption-desc font-grey-cascade"></div>
								<br/> 
							</div>
							
							<!--Show hotel booking if any-->
									<div class="portlet box blue">
										<div class="portlet-title">
											<div class="caption"><i class="fa fa-calendar"></i>Hotel Booking Details</div>
										</div>
									 <div class="portlet-body ">
									<div class="table-responsive">
										<table class="table table-bordered">
											<thead class="thead-default">
												<tr>
													<th>Sr.</th>
													<th> City </th>
													<th> Hotel Name </th>
													<th> Sent Status </th>
													<th> Status </th>
													<th> Action </th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$continue_hotel = true;
												if( $hotel_bookings ){ 
													$ch = 1;
													foreach( $hotel_bookings as $h_book ){
														//Get hotel booking status-->
														if( $h_book->booking_status == 9 ){
															$status = "<span class='green'>BOOKED</span>";
														}else if($h_book->booking_status == 8){
															$status = "<span class='red'>Declined</span>";
														}else if( $h_book->booking_status == 7 ){
															$status = "<strong class='red'><i class='fa fa-window-close' aria-hidden='true'></i> &nbsp;Canceled</strong>";
														}else{
															$continue_hotel = false;
															$status = "<span class='blue'><i class='fa fa-refresh'></i> Processing</span>";
														}
														?>
														
														<tr>
															<td><?php echo $ch; ?></td>
															<td><?php echo get_city_name($h_book->city_id); ?></td>
															<td><?php echo get_hotel_name($h_book->hotel_id); ?></td>
															<td><?php echo $h_book->email_count . " Time Sent"; ?></td>
															<td><?php echo $status; ?></td>
															<td><a title='View' href="<?php echo site_url("hotelbooking/view/{$h_book->id}/{$h_book->iti_id}"); ?>" class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a></td>
														</tr>
													<?php 
														$ch++;
													} ?>
												<?php }else{ ?>
													<tr>
														<td colspan="6">No hotel booking create against this itinerary.</td>
													</tr>	
												<?php } ?>
											</tbody>
										</table>
									</div>	
									</div>
									</div>
									
									<!--End hotel booking if any-->
									
							<div class="col-md-6 mt-step-col <?php echo $hotel_class; ?>" title="Hotel Booking Status. Green = done, Red = Pending" data-toggle="tooltip">
								<div class="mt-step-number bg-white">
									<i class="fa fa-bed"></i>
								</div>
								<div class="mt-step-title uppercase font-grey-cascade">Hotel Booking</div>
							</div>
							
							<div class="col-md-6 mt-step-col <?php echo $pay_class; ?>" title="Cab Booking Status. (Green >= 50 %, Red < 50%) Amount received" data-toggle="tooltip">
								<div class="mt-step-number bg-white">
									<i class="fa fa-inr"></i>
								</div>
								<div class="mt-step-title uppercase font-grey-cascade">Payments</div>
								<div class="mt-step-content font-grey-cascade">Min. Fifty Percentage Amount
								( Received Amount: <?php echo $total_payment_recieved_percentage; ?>% )</div>
							</div>
						</div>
						
						<!--show confirm voucher button if hotel and volovo/train/flight booking confirmed-->
						<p class="text-center" style="font-size:12px; color: red;"><strong>Note: </strong>To confirm voucher make sure that the all booking has been done.</p>
						<?php if( $is_voucher_confirm ){
							echo "<p class='alert alert-success text-center green'><strong>Voucher has been Confirmed.</strong></p>";
						}else if( $hotel_booking_status ){ ?>
							<div class="text-center confirm_voucher">
								<button type="submit" data-iti_id="<?php echo $iti->iti_id; ?>" class="btn green uppercase cnfrim_voucher" title="Confirm Voucher" >Confirm Voucher</button>
								<p style="font-size:12px; color: red;"><strong>Note: </strong>To confirm voucher make sure that the payment is received greater than <strong>50%</strong>.</p>
							</div>
							<div id="confirmVoucherModal" class="modal" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">Close</button>
											<h4 class="modal-title">Confirm Voucher</h4>
										</div>
										<div class="modal-body"> 
											<form id="frm_confirm_voucher">
												<div class="form-group">
													<label for="comment">Comment<span style="color:red;">*</span>:</label>
													<textarea required class="form-control" rows="3" name="agent_comment"></textarea>
												</div> 
												<hr>
												<div class="form-group">
													<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>" >
													<input type="submit" class='btn btn-green' id="clone_current_iti" title='Confirm Voucher' value="Confirm Voucher" />
												</div>
												<div class="cnf_res"></div>	
											</form>	
										</div>
										<div class="modal-footer"></div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<!--End step line start-->
				<?php } ?>
				
				<!--INVOICE BUTTON -->
				<hr>
				<div class="invoice_btn text-center margin-top-10 margin-bottom-10"><?php echo $invoice_btn; ?></div>
				<div class="clearfix"></div>
				<div class="row2">
					<?php // echo $greeting; ?>
						<?php // echo $greeting; ?>
					<div class="printable" id="printable"> <!--START PRINTABLE SECTION -->
				
					<?php if( isset( $paymentDetails[0] ) && !empty( $paymentDetails[0] ) && $iti->iti_status == 9 ){ 
						$pay_detail = $paymentDetails[0]; ?>
						<h3 style="background: #3d3d3d; color: #fff; padding: 5px;">PAYMENT DETAILS</h3>
						<div class="clearfix"></div>
						<div class="table-responsive">
							<table class="table table-bordered ">
								<tbody>
									<tr class="thead-inverse" >
										<td width="33%"><strong>FINAL COST</strong></td>
										<td width="33%"><strong>Package Category</strong></td>
										<td width="33%"><strong>Travel Date</strong></td>
									</tr>
									
									
									<tr class="" >
										<td width="33%"><strong>INR <?php echo $paymentDetails[0]->total_package_cost; ?>/-</strong></td>
										<td width="33%"><strong><?php echo $iti->approved_package_category; ?></strong></td>
										<td width="33%"><strong><?php echo !empty($t_date) ? $t_date : "--/--/----"; ?></strong></td>
									</tr>
									
									
									<tr class="thead-inverse" >
										<td width="33%"><strong>Advance Recieved</strong></td>
										<td width="33%"><strong>Balance Pending</strong></td>
										<td width="33%"><strong>Booking Date</strong></td>
									</tr>
									<?php $booking_d = $paymentDetails[0]->booking_date; ?>
									<tr class="" >
										<td width="33%"><strong>INR <?php echo $paymentDetails[0]->advance_recieved; ?>/-</strong></td>
										<td width="33%"><strong><?php echo $paymentDetails[0]->total_balance_amount; ?>/-</strong></td>
										<td width="33%"><strong><?php echo !empty($booking_d) ? display_month_name($booking_d ) : "--/--/----"; ?></strong></td>
									</tr>
									
									
									
								</tbody>
							</table>
						</div>
				<?php } ?>
				
					<div class="well well-sm"><h3>Package Overview</h3></div>
					<div class="table-responsive">
						<table class="table table-bordered ">
							<tbody>
								<tr class="thead-inverse" >
									<td width="33%"><strong>Name of Package</strong></td>
									<td width="33%"><strong>Routing</strong></td>
									<td width="33%"><strong>No of Travelers</strong></td>
								</tr>
								<tr>
									<td><?php echo $iti->package_name; ?></td>
									<td><?php echo $iti->package_routing; ?></td>
									<td><div class="traveller-info">
										<?php
										echo "<strong> Adults: </strong> " . $iti->adults; 
										if( !empty( $iti->child ) ){
											echo "  <strong> No. of Child: </strong> " . $iti->child; 
											echo " (" . $iti->child_age .")"; 
										}
										?>
										</div>
									</td>
								</tr>
								
								<tr class="thead-inverse">
									<td><strong>Tour Start Date</strong></td>
									<td><strong>Tour End Date</strong></td>
									<td><strong>Total Nights</strong></td>
								</tr>
								<tr>
									<td><?php echo $iti->t_start_date; ?></td>
									<td><?php echo $iti->t_end_date; ?></td>
									<td><?php echo $iti->total_nights . " Nights"; ?></td>
									
								</tr>
								<tr class="thead-inverse">
									<td><strong>Customer Name</strong></td>
									<td><strong>Contact</strong></td>
									<td><strong>Customer Email</strong></td>
								</tr>
								<tr>
									<td><?php echo $customer_name; ?></td>
									<td><?php echo $customer_contact; ?></td>
									<td><?php echo $customer_email; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div class="well well-sm"><h3>Hotel Details</h3></div>
					<?php $hotel_meta = unserialize($iti->hotel_meta); 
					$standard_html = "";
					$deluxe_html = "";
					$super_deluxe_html = "";
					$luxury_html = "";
					$table_start = "<table class='table table-bordered'><tr><th>City</th><th>Hotel Category</th><th>Check In</th>				<th>Check Out</th><th>Hotel</th><th>Room Category</th><th>Plan</th><th>Room</th><th>N/T</th></tr>";
					//print_r( $hotel_meta );
					if( !empty( $hotel_meta ) ){
						$count_hotel = count( $hotel_meta ); 
							/* print_r( $hotel_meta ); */
							if( $count_hotel > 0 ){
								for ( $i = 0; $i < $count_hotel; $i++ ){
									
									$hotel_location = $hotel_meta[$i]["hotel_location"];
									$check_in 		= $hotel_meta[$i]["check_in"];
									$check_out 		= $hotel_meta[$i]["check_out"];
									$total_room 	= $hotel_meta[$i]["total_room"];
									$total_nights 	= $hotel_meta[$i]["total_nights"];
									$extra_bed 		= !empty( $hotel_meta[$i]['extra_bed'] ) ? " + <strong>" . $hotel_meta[$i]['extra_bed'] . " </strong> Extra Bed" : "";
									
									$hotel_inner_meta = $hotel_meta[$i]["hotel_inner_meta"];
									//Fetch hotel inner meta
									$count_innermeta = count( $hotel_inner_meta );
									//print_r($hotel_inner_meta);
									
									if( !empty( $count_innermeta ) ){
										for( $ii = 0 ; $ii < $count_innermeta ; $ii++ ){
											$hotel_category	= strtolower($hotel_inner_meta[$ii]["hotel_category"]);
											$room_category 	= $hotel_inner_meta[$ii]["room_category"];
											$hotel_name 	= $hotel_inner_meta[$ii]["hotel_name"];
											$meal_plan 		= $hotel_inner_meta[$ii]["meal_plan"];
											
											//hotel details html category wise
											switch( $hotel_category ){
												case "Standard":
													$standard_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>Deluxe</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Deluxe":
													$deluxe_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>Super Deluxe</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Super Deluxe":
													$super_deluxe_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>Luxury</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Luxury":
													$luxury_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>Super Luxury</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												default:
													continue;
												break;
											}
										}
									}
									
									
								} 	
								
								//print_r( array_column($hotel_meta, 'hotel_category') ); 
								//Check hotel category if exists
								/* $is_standard	= in_array("Standard", array_column($hotel_meta, 'hotel_category')) ? TRUE : FALSE;
								$is_deluxe		= in_array("Deluxe", array_column($hotel_meta, 'hotel_category')) ? TRUE : FALSE;
								$is_s_deluxe 	= in_array("Super Deluxe", array_column($hotel_meta, 'hotel_category')) ? TRUE : FALSE;
								$is_luxury 		= in_array("Luxury", array_column($hotel_meta, 'hotel_category')) ? TRUE : FALSE; */
								
								if( $is_standard ) {
									echo "<div class='well well-sm'><h3>Deluxe</h3></div>";
									echo $table_start . $standard_html . "</table>";
								}
								if( $is_deluxe ){
									echo "<div class='well well-sm'><h3>Super Deluxe</h3></div>";
									echo $table_start . $deluxe_html . "</table>";
								}
								if( $is_s_deluxe ){
									echo "<div class='well well-sm'><h3>Luxury</h3></div>";
									echo $table_start . $super_deluxe_html . "</table>";
								}
								if( $is_luxury ){
									echo "<div class='well well-sm'><h3>Super Luxury</h3></div>";
									echo $table_start . $luxury_html . "</table>";
								}
							} ?>
						
						<?php } ?>	
					<hr>
					<div class="well well-sm"><h3>Rates</h3></div>
					<!-- Rate Meta -->
					<table class='table table-bordered'><tr>
						<th>Hotel Category</th>
						<th>Deluxe</th>
						<th>Super Deluxe</th>
						<th>Luxury</th>
						<th>Super Luxury</th>
					</tr>
					<?php
					//Rate meta
					$rate_meta = unserialize($iti->rates_meta);
					$strike_class = !empty( $discountPriceData ) ? "strikeLine" : " ";
					//$strike_class_final = !empty( $iti->final_amount ) ? "strikeLine" : "";
					$strike_class_final = !empty( $iti->final_amount ) && $iti->iti_status == 9 ? "strikeLine" : "";
					//print_r( $rate_meta );
					$iti_close_status = $iti->iti_close_status;
					//print_r( $rate_meta );
					if( empty($iti_close_status) ){
					if( !empty( $rate_meta ) ){
						if( $iti->pending_price == 4 ){
							echo "<tr><td  colspan=5 class='red'>Awaiting price verfication from super manager.</td></tr>"; 
						}else{
							$agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
							//get per person price
							$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
							//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
							$inc_gst = "";
							
							$agent_sp = $agent_dp = $agent_sdp = $agent_lp = "";
							//if percentage exists
							if( $agent_price_percentage ){
								$as_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? " Rs." . ($per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ). " Per/Person" : "";
								$ad_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? " Rs." . ($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 ). " Per/Person" : "";
								$asd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? " Rs." . ($per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100 ). " Per/Person" : "";
								$al_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? " Rs." . ($per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100)  . " Per/Person" : "";

								//child rates
								$achild_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " .  number_format( $per_person_ratemeta["child_standard_rates"]  + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100  ) . "/- Per Child" : "";
								
								$achild_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
								
								$achild_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
								
								$achild_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " .   number_format( $per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";													
								
								$astandard_rates = !empty( $rate_meta["standard_rates"]) ? number_format($rate_meta["standard_rates"] + $rate_meta["standard_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
								
								$adeluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? number_format($rate_meta["deluxe_rates"] + $rate_meta["deluxe_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
								
								$asuper_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? number_format($rate_meta["super_deluxe_rates"] + $rate_meta["super_deluxe_rates"] * $agent_price_percentage / 100  ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
								$arate_luxry = !empty( $rate_meta["luxury_rates"]) ? number_format($rate_meta["luxury_rates"] + $rate_meta["luxury_rates"] * $agent_price_percentage / 100 ) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
								
								$agent_sp = "<br><strong class='aprice'> AP( " . $astandard_rates . "</strong> <br> {$as_pp} <br> {$achild_s_pp} )";
								$agent_dp = "<br><strong class='aprice'> AP( " . $adeluxe_rates . "</strong> <br> {$ad_pp} <br> {$achild_d_pp} )";
								$agent_sdp = "<br><strong class='aprice'> AP( " . $asuper_deluxe_rates . "</strong> <br> {$asd_pp} <br> {$achild_sd_pp} )";
								$agent_lp = "<br><strong class='aprice'> AP( " . $arate_luxry . "</strong> <br> {$al_pp} <br> {$achild_l_pp} )";
							}
							
							$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["standard_rates"]) . "/- Per Person" : "";
							$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"]) . "/- Per Person" : "";
							$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"]) . "/- Per Person" : "";
							$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"]) . "/- Per Person" : "";
							
							//child rates
							$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . $per_person_ratemeta["child_standard_rates"] . "/- Per Child" : "";
							$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_deluxe_rates"] . "/- Per Child" : "";
							$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_super_deluxe_rates"] . "/- Per Child" : "";
							$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . $per_person_ratemeta["child_luxury_rates"] . "/- Per Child" : "";
							
							$s_rates = isset( $rate_meta["standard_rates"] ) && !empty( $rate_meta["standard_rates"]) ? $rate_meta["standard_rates"] : 0;
							$d_rates = isset( $rate_meta["deluxe_rates"] ) && !empty( $rate_meta["deluxe_rates"]) ? $rate_meta["deluxe_rates"] : 0;
							$sd_rates = isset( $rate_meta["super_deluxe_rates"] ) && !empty( $rate_meta["super_deluxe_rates"]) ? $rate_meta["super_deluxe_rates"] : 0;
							$l_rates = isset( $rate_meta["luxury_rates"] ) && !empty( $rate_meta["luxury_rates"]) ? $rate_meta["luxury_rates"] : 0;
							
							$standard_rates = !empty( $s_rates ) ? number_format($s_rates) . "/- {$inc_gst}" : "--";
							$deluxe_rates = !empty( $d_rates ) ? number_format($d_rates) . "/- {$inc_gst}" : "--";
							$super_deluxe_rates = !empty( $sd_rates ) ? number_format($sd_rates) . "/- {$inc_gst}" : "--";
							$rate_luxry = !empty( $l_rates ) ? number_format($l_rates) . "/- {$inc_gst}" : "--";
							
							echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td>
								<td>		
									<strong> BP( " . $standard_rates . "</strong> <br> {$s_pp} <br> {$child_s_pp} )
									{$agent_sp}
								</td>
								<td>
									<strong>BP( " . $deluxe_rates . "</strong> <br> {$d_pp}<br> {$child_d_pp} )
									{$agent_dp}
								</td>
								<td>
									<strong>BP( " . $super_deluxe_rates . "</strong> <br> {$sd_pp}<br> {$child_sd_pp} )
									{$agent_sdp}
								</td>
								<td>
									<strong>BP(  " . $rate_luxry . "</strong> <br> {$l_pp}<br> {$child_l_pp} )
									{$agent_lp}
								</td></tr>";
									
									if( !empty( $discountPriceData ) ){
										foreach( $discountPriceData as $price ){
											$agent_price_percentage = !empty($price->agent_price) ? $price->agent_price : 0;
											$sent_status = $price->sent_status;
											//get per person price
											$per_person_ratemeta 	= unserialize($price->per_person_ratemeta);
											//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
											$inc_gst = "";
											
											$agent_sp = $agent_dp = $agent_sdp = $agent_lp = "";
											//if percentage exists
											if( $agent_price_percentage ){
												$ad_s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format( $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
												$ad_d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
												$ad_sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
												$ad_l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
												
												//child rates
												$ad_child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_standard_rates"] +  $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
												$ad_child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
												$ad_child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
												$ad_child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";			
												
												//get rates
												$ad_s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage/100 ) . "/- {$inc_gst} <br> {$ad_s_pp} <br> {$ad_child_s_pp}" : "<strong class='red'>On Request</strong>";
												
												$ad_d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$ad_d_pp} <br> {$ad_child_d_pp}" : "<strong class='red'>On Request</strong>";
												
												$ad_sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$ad_sd_pp} <br> {$ad_child_sd_pp}"  : "<strong class='red'>On Request</strong>";
												
												$ad_l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$ad_l_pp} <br> {$ad_child_l_pp}"  : "<strong class='red'>On Request</strong>";
												
												$agent_sp = "<br><strong class='aprice'> AP( " . $ad_s_price . "</strong>)";
												$agent_dp = "<br><strong class='aprice'>  AP( " . $ad_d_price . "</strong>)";
												$agent_sdp = "<br><strong class='aprice'> AP( " . $ad_sd_price . "</strong>)";
												$agent_lp = "<br><strong class='aprice'>  AP( " . $ad_l_price . "</strong>)";
											}
											
											$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format($per_person_ratemeta["standard_rates"]) . "/- Per Person" : "";
											$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"]) . "/- Per Person" : "";
											$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"]) . "/- Per Person" : "";
											$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"]) . "/- Per Person" : "";
												
											//child rates
											$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . $per_person_ratemeta["child_standard_rates"] . "/- Per Child" : "";
											$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_deluxe_rates"] . "/- Per Child" : "";
											$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_super_deluxe_rates"] . "/- Per Child" : "";
											$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . $per_person_ratemeta["child_luxury_rates"] . "/- Per Child" : "";
											
											$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates) . "/- {$inc_gst} <br> {$s_pp} <br> {$child_s_pp}" : "<strong class='red'>N/A</strong>";
											$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates) . "/- {$inc_gst} <br> {$d_pp} <br> {$child_d_pp}" : "<strong class='red'>N/A</strong>";
											$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates) . "/- {$inc_gst} <br> {$sd_pp} <br> {$child_sd_pp}"  : "<strong class='red'>N/A</strong>";
											$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates) . "/- {$inc_gst} <br> {$l_pp} <br> {$child_l_pp}"  : "<strong class='red'>N/A</strong>";
											
											$sr = isset( $price->standard_rates ) && !empty( $price->standard_rates ) ? $price->standard_rates : 0;
											$dr = isset( $price->deluxe_rates ) && !empty( $price->deluxe_rates ) ? $price->deluxe_rates : 0;
											$sdr = isset( $price->super_deluxe_rates ) && !empty( $price->super_deluxe_rates ) ? $price->super_deluxe_rates : 0;
											$lr = isset( $price->luxury_rates ) && !empty( $price->luxury_rates ) ? $price->luxury_rates : 0;
									
											//Calculate Total Cost
											$total_cost_after_dis = $sr + $dr + $sdr + $lr;
											
											$count_price = count( $discountPriceData );
											$strike_class = ($price !== end($discountPriceData) && $count_price > 1 ) ? "strikeLine" : "";
											//echo "<tr class='$strike_class'><td>Price</td><td><strong>" . $s_price . "</strong></td>";
											//echo "<td><strong>" . $d_price . "</strong></td>";
											//echo "<td><strong>" . $sd_price . "</strong></td>";
											//echo "<td><strong>" . $l_price . "</strong></td></tr>";
											echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td>
											<td>BP( <strong>" . $s_price . "</strong>) {$agent_sp} </td>";
											echo "<td>BP(<strong>" . $d_price . "</strong>) {$agent_dp} </td>";
											echo "<td>BP(<strong>" . $sd_price . "</strong>) {$agent_sdp} </td>";
											echo "<td>BP(<strong>" . $l_price . "</strong>) {$agent_lp} </td></tr>";
										}
									}
						}			
					}else{
						echo "<tr><td><strong class='red'>Price</strong></td>
								<td>
									<strong class='red'> Coming Soon </strong>
								</td>
								<td>
									<strong class='red'> Coming Soon</strong>
								</td>
								<td>
									<strong class='red'> Coming Soon </strong>
								</td>
								<td>
									<strong class='red'> Coming Soon </strong>
								</td></tr>";
					}
					}

					?>
					</table>
					</div><!--END PRINTABLE-->
					<div class="well well-sm"><h3>Notes:</h3></div>
					<ul>
					<?php $hotel_note_meta = unserialize($iti->hotel_note_meta); 
					$count_hotel_meta = count( $hotel_note_meta );
					
					if( !empty($hotel_note_meta) ){
						for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
							echo "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
						}	
					} ?>
					</ul>
					<hr>
					<div class="well well-sm"><h3>Inclusion & Exclusion</h3></div>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="thead-default">
								<tr class="thead-inverse">
									<th  width="50%"> Inclusion</th>
									<th  width="50%"> Exclusion</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$inclusion = unserialize($iti->inc_meta); 
								$count_inc = count( $inclusion );
								$exclusion = unserialize($iti->exc_meta); 
								$count_exc = count( $exclusion );
								echo "<tr><td><ul>";
								if( !empty($inclusion) ){
									for ( $i = 0; $i < $count_inc; $i++ ) {
										echo "<li>" . $inclusion[$i]["tour_inc"] . "</li>";
									}	
								}
								echo "</ul></td><td><ul>";
								if( !empty($exclusion) ){
									for ( $i = 0; $i < $count_exc; $i++ ) {
										echo "<li>" . $exclusion[$i]["tour_exc"] . "</li>";
									}	
								}
								echo "</ul></td></tr>";
								?>
							</tbody>
						</table>
					</div>	
					
					<hr>	
					<?php 
					//check if special inclusion exists
					$sp_inc = unserialize($iti->special_inc_meta); 
					$count_sp_inc = count( $sp_inc );
					
					if( !empty($sp_inc) ){
						echo '<div class="well well-sm"><h3>Special Inclusions</h3></div>';
						echo "   <ul class='inclusion'>";
						if( $count_sp_inc > 0 ){
							for ( $i = 0; $i < $count_sp_inc; $i++ ) {	
								echo "<li>" . $sp_inc[$i]["tour_special_inc"] . "</li>";
							}	
						}
						echo "</ul>";
					}
					?>

					<?php 
					//check if benefits
					$benefits_m = unserialize($iti->booking_benefits_meta); 
					$count_bn_inc = count( $benefits_m );
					if( !empty($benefits_m) ){
						echo '<div class="well well-sm"><h3>Benefits of Booking With Us</h3></div>';
						echo "   <ul class='inclusion'>";
						if( $count_bn_inc > 0 ){
							for ( $i = 0; $i < $count_bn_inc; $i++ ) {	
								echo isset($benefits_m[$i]["benefit_inc"]) ? "<li>" . $benefits_m[$i]["benefit_inc"] . "</li>" : "";
							}	
						}
						echo "</ul>";
					}
					?>						
					
					<div class="well well-sm"><h3>Bank Details: Cash/Cheque at Bank or Net Transfer</h3></div>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="thead-default">
								<tr class="thead-inverse">
									<th> Bank Name</th>
									<th> Payee Name</th>
									<th> Account Type</th>
									<th> Account Number</th>
									<th> Branch Address</th>
									<th> IFSC Code</th>
								</tr>
							</thead>
							<tbody>
								<?php $banks = get_all_banks(); 
									if( $banks ){
										foreach( $banks as $bank ){ 
											echo "<tr>";
												echo "<td>" . $bank->bank_name . "</td>";
												echo "<td>" . $bank->payee_name . "</td>";
												echo "<td>" . $bank->account_type . "</td>";
												echo "<td>" . $bank->account_number . "</td>";
												echo "<td>" . $bank->branch_address . "</td>";
												echo "<td>" . $bank->ifsc_code . "</td>";
											echo "</tr>";
										 }
									}
									?>
							</tbody>
						</table>
					</div>
					<?php
					/*
						//bank payment terms
						$count_bank_payment_terms	= count( $online_payment_terms ); 
						$count_bankTerms			= $count_bank_payment_terms-1; 
						if(isset($online_payment_terms["heading"]) ) { 
							echo "<div class='well well-sm'><h3>" . $online_payment_terms["heading"] . "</h3></div>"; 
						}
						if( $count_bankTerms > 0 ){
							echo "<ul class='client_listing'>";
								for ( $i = 0; $i < $count_bankTerms; $i++ ) { 
									echo "<li>" . $online_payment_terms[$i]["terms"] . "</li>";
								}
							echo "</ul>";
						}
							//how to book section
							$count_book_package	= count( $book_package_terms );
							if(isset($book_package_terms["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $book_package_terms["heading"]  ."</h3></div>";
							}
							if(isset($book_package_terms["sub_heading"]) ) { 
								echo "<h5>". $book_package_terms["sub_heading"]  ."</h5>";
							}							
							if( $count_book_package > 0 ){
								echo '<div class="table-responsive">
											<table class="table table-bordered tbl_policy_view">
												<thead class="thead-default">
													<tr>
														<th colspan=3> Booking Policy </th>
													</tr>
												</thead>
												<tbody>';
												$counter = 1;
									for ( $i = 0; $i < $count_book_package-2; $i++ ) { 
										$book_title = isset($book_package_terms[$i]["hotel_book_terms"]) ? $book_package_terms[$i]["hotel_book_terms"] : "";
										$book_val = isset($book_package_terms[$i]["hotel_book_terms_right"]) ? $book_package_terms[$i]["hotel_book_terms_right"] : "";
										echo "<tr>
											<td>" . $counter . "</td>
											<td>" . $book_title . "</td>
											<td>" . $book_val . "</td>
										</tr>";
										$counter++;
									}
								echo "</tbody></table></div>";
							}	
							
							// advance payment section 
							$count_ad_pay	= count( $advance_payment_terms );
							if(isset($advance_payment_terms["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $advance_payment_terms["heading"]  ."</h3></div>";
							}						
							if( $count_book_package > 0 ){
								echo "<ul class='client_listing'>";
									for ( $i = 0; $i < $count_ad_pay-1; $i++ ) { 
										echo "<li>" . $advance_payment_terms[$i]["terms"] . "</li>";
									}
								echo "</ul>";
							}
							
							//PAYMENT POLICY
							if(isset($payment_policy["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $payment_policy["heading"]  ."</h3></div>";
							}	
							$count_payment_policy	= count( $payment_policy );
							if( $count_payment_policy > 0 ){
								echo '<div class="table-responsive">
											<table class="table table-bordered tbl_policy_view">
												<thead class="thead-default">
													<tr>
														<th colspan=3> Payment Policy </th>
													</tr>
												</thead>
												<tbody>';
									$counter_pay = 1;
									for ( $i = 0; $i < $count_payment_policy-1; $i++ ) { 
										$book_title = isset($payment_policy[$i]["pay_policy"]) ? $payment_policy[$i]["pay_policy"] : "";
										$book_val = isset($payment_policy[$i]["pay_policy_right"]) ? $payment_policy[$i]["pay_policy_right"] : "";
										echo "<tr>
											<td>" . $counter_pay . "</td>
											<td>" . $book_title . "</td>
											<td>" . $book_val . "</td>
										</tr>";
										$counter_pay++;
									}
								echo "</tbody></table></div>";
							}								
							//end payment policy
							
							//AMENDMENT POLICY section	
							if(isset($amendment_policy["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $amendment_policy["heading"]  ."</h3></div>";
							}	
							$count_amendment_policy	= count( $amendment_policy );
							
							if( $count_amendment_policy > 0 ){
								echo '<div class="table-responsive">
											<table class="table table-bordered tbl_policy_view">
												<thead class="thead-default">
													<tr>
														<th colspan=3> Amendment Policy </th>
													</tr>
												</thead>
												<tbody>';
									$counter_a = 1;
									for ( $i = 0; $i < $count_amendment_policy-1; $i++ ) { 
										$book_title = isset($amendment_policy[$i]["amend_policy"]) ? $amendment_policy[$i]["amend_policy"] : "";
										$book_val = isset($amendment_policy[$i]["amend_policy_right"]) ? $amendment_policy[$i]["amend_policy_right"] : "";
										echo "<tr>
											<td>" . $counter_a . "</td>
											<td>" . $book_title . "</td>
											<td>" . $book_val . "</td>
										</tr>";
										$counter_a++;
									}
								echo "</tbody></table></div>";
							}
							
							//refund policy
							if(isset($amendment_policy["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $cancel_tour_by_client["heading"]  ."</h3></div>";
							}
							
							$count_cancel_content	= count( $cancel_tour_by_client );
							
							if( $count_cancel_content > 0 ){
								echo '<div class="table-responsive">
											<table class="table table-bordered tbl_policy_view">
												<thead class="thead-default">
													<tr>
														<th colspan=3> Cancellation and Refund Policy </th>
													</tr>
												</thead>
												<tbody>';
									$counter_ra = 1;
									for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
										$book_title = isset($cancel_tour_by_client[$i]["cancel_terms"]) ? $cancel_tour_by_client[$i]["cancel_terms"] : "";
										$book_val = isset($cancel_tour_by_client[$i]["cancel_terms_right"]) ? $cancel_tour_by_client[$i]["cancel_terms_right"] : "";
										echo "<tr>
											<td>" . $counter_ra . "</td>
											<td>" . $book_title . "</td>
											<td>" . $book_val . "</td>
										</tr>";
										$counter_ra++;
									}
								echo "</tbody></table></div>";
							}
							
							//terms and condition
							if(isset($terms_condition["heading"]) ) { 
								echo "<div class='well well-sm'><h3>". $terms_condition["heading"]  ."</h3></div>";
							}
							$count_cancel_content	= count( $terms_condition );
							if( $count_cancel_content > 0 ){
								echo "<ul class='client_listing'>";
									for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
										echo "<li>" . $terms_condition[$i]["terms"] . "</li>";
									}
								echo "</ul>";
							}
							*/
						?>	
						<hr>
						
						<?php
						$agent_id = $iti->agent_id;
						$user_info = get_user_info($agent_id);
						if($user_info){
							$agent = $user_info[0];
							echo "<strong>Regards</strong><br>";
							echo "<strong> " . $agent->first_name . " " . $agent->last_name . "</strong><br>";
							echo "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
							echo "<strong>Email : </strong> " . $agent->email . "<br>";
							echo "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
							echo "<strong>Website : </strong> " . $agent->website;
						}	
						?>
					<hr>
					<div class="signature"><?php echo $signature; ?></div>
					<hr>
					</div>
					
					<!--Comments Section -->
	</div>
	<!-- END CONTENT BODY -->
</div>

<!-- Booking Payment Script -->
	<script type="text/javascript">
	jQuery(document).ready(function($){
		
		//Confirm voucher click
		$(document).on("click", ".cnfrim_voucher", function(e){
			e.preventDefault();
			$("#confirmVoucherModal").show();
		});
		
		$(document).on("click", ".close", function(e){
			$("#confirmVoucherModal").hide();
		});	
		
		//update status voucher
		$("#frm_confirm_voucher").validate({
			submitHandler: function(){
				var formData = $("#frm_confirm_voucher").serializeArray();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url('itineraries/ajax_confirm_voucher_status'); ?>" ,
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						$(".cnf_res").html("updating.....");
						console.log("sending...");
					},
					success: function(res) {
						$(".cnf_res").html("");
						alert( res.msg );
						location.reload();
					},
					error: function(e){
						$(".cnf_res").html("");
						alert("Error: Please reload the page and try again.");
						console.log(e);
						//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
					}
				});
			}
		});	
		
		//checkbox change
		/*
		$("#generate_invoice_frm").validate({
			submitHandler: function(form) {
				var ajaxReq;
				var resp = $(".response");
				var fullpage_loader = $(".fullpage_loader");
				var formData = $("#generate_invoice_frm").serializeArray();				
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({				
					type: "POST",
					url: "<?php echo base_url('payments/ajax_generate_bank_receipt'); ?>",
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						fullpage_loader.show();
						resp.html("<div class='alert alert-info'><strong>Please wait</strong> sending mail.....</div>");
					},
					success: function(res) {
						fullpage_loader.hide();
						if (res.status == true){
							resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							//console.log(res.msg);
							location.reload();
						}else{
							resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							console.log("error");
						}
					},
					error: function(e){
						fullpage_loader.hide();
						//console.log(e);
						resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
					}
				});
			}	
		}); */
	});	
	</script>
	<?php }else{
		redirect("itineraries");
	} ?>