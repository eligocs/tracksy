<div class="page-container itinerary-view view_call_info">
	<div class="page-content-wrapper">
		<div class="page-content">
		
			<?php if( !empty($itinerary[0] ) ){ 
				$lFollow = "";			
				$amdment_btn = "";
				$iti = $itinerary[0];
				$iti_status = $iti->iti_status;
				$iti_note = $iti->followup_status;
				
				$is_amendment = $amendment_note = "";
				//show amendment note if revised itinerary
				if( $iti->is_amendment == 2 ){ 
					$is_amendment = "<h3 class='text-center red'>REVISED ITINERARY</h3>";
					$amendment_cmt = $this->global_model->getdata( "iti_amendment_temp", array( "iti_id" => $iti->iti_id ) );
					$amendment_note = !empty( $amendment_cmt ) ? "<p class='red'>Amendment: {$amendment_cmt[0]->review_comment}</p>" : "";
				} 
				
				if( $iti_status == 9 ){
					$lead_status = "Booked";
					$lead_note = $iti_note;
				}elseif( $iti_status == 7 ){
					$lead_status = "Closed";
					$lead_note = $iti_note;
				}else{
					$lead_status = "Working";
					$lead_note = "";
				}
				
				//Get customer info
				$get_customer_info = get_customer( $iti->customer_id ); 
				$customer_name = $customer_contact = $customer_email = $ref_name = $ref_contact = $cus_type ="";
				
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
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i> <strong>Customer Id: </strong><span class="mehroon"><?php echo $iti->customer_id; ?></span> &nbsp; &nbsp; &nbsp; 
						{ Package Type: <strong class="red"> <?php echo check_iti_type( $iti->iti_id ); ?></strong> } <strong class=''>Customer Type: </strong> <span class='mehroon'><?php echo $cus_type; ?></span> <?php echo $ref_name . $ref_contact; ?></div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("itineraries"); ?>" title="Back">Back</a>
					</div>
				</div>
				
				<?php if( $iti->iti_status == 9 ){
					echo $is_amendment . $amendment_note; ?>
					<h4 class="text-center">Booked Itinerary</h4>
						<div class="mt-element-step">
							<div class="row step-background-thin ">
								<div class="col-md-4 bg-grey-steel mt-step-col error ">
									<div class="mt-step-number">1</div>
									<div class="mt-step-title uppercase font-grey-cascade"><strong>INR <?php echo $iti->final_amount; ?>/-</strong></div>
									<div class="mt-step-content font-grey-cascade">Package Final Cost:</div>
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
				<?php }
				//Declined Reason -->
				else if($iti->iti_status == 7 ){ ?>
					<div class="well well-sm text-center">
						<p class="red">Declined Reason: <strong><?php echo $iti->followup_status; ?></strong></p>
						<p class="red">Declined Comment: <strong><?php echo $iti->decline_comment; ?></strong></p>
					</div>
				<?php } 
				else if($iti->iti_status == 6 ){ ?>
				<!-- Rejected Reason -->
					<div class="well well-sm text-center">
						<h2 class="red">Rejected Itinerary</h2>
						<p class="red">Reason: <strong><?php echo $iti->iti_reject_comment; ?></strong></p>
					</div>
				<?php } ?>
				
				<div class="row2">
					<?php // echo $greeting; ?>
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
							</tbody>
						</table>
					</div>
					<div class="clearfix"></div>
					<hr>
					<div class="well well-sm"><h3>Hotel Details</h3></div>
					<table class="table table-bordered">
				<?php //Insert Rate meta if price is empty
				
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
					
					
					$standard_html = "";
					$deluxe_html = "";
					$super_deluxe_html = "";
					$luxury_html = "";
					//print_r( $hotel_meta );
					if( !empty( $hotel_meta ) ){
						$count_hotel = count( $hotel_meta ); 
							/* print_r( $hotel_meta ); */
							if( $count_hotel > 0 ){
								for ( $i = 0; $i < $count_hotel; $i++ ) {
									
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
											$hotel_category	= $hotel_inner_meta[$ii]["hotel_category"];
											$room_category 	= $hotel_inner_meta[$ii]["room_category"];
											$hotel_name 	= $hotel_inner_meta[$ii]["hotel_name"];
											$meal_plan 		= $hotel_inner_meta[$ii]["meal_plan"];
											
											//hotel details html category wise
											switch( $hotel_category ){
												case "Standard":
													$standard_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>{$hotel_category}</td>
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
														<td>{$hotel_category}</td>
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
														<td>{$hotel_category}</td>
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
														<td>{$hotel_category}</td>
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
								if( $is_standard ) {
									echo "<div class='well well-sm'><h3>Standard</h3></div>";
									echo "<table class='table table-bordered'><tr>
										<th>City</th>
										<th>Hotel Category</th>
										<th>Check In</th>
										<th>Check Out</th>
										<th>Hotel</th>
										<th>Room Category</th>
										<th>Plan</th>
										<th>Room</th>
										<th>N/T</th>
									</tr>";
									echo $standard_html . "</table>";
								}
								if( $is_deluxe ){
									echo "<div class='well well-sm'><h3>Deluxe</h3></div>";
									echo "<table class='table table-bordered'><tr>
										<th>City</th>
										<th>Hotel Category</th>
										<th>Check In</th>
										<th>Check Out</th>
										<th>Hotel</th>
										<th>Room Category</th>
										<th>Plan</th>
										<th>Room</th>
										<th>N/T</th>
									</tr>";
									echo $deluxe_html . "</table>";
								}
								if( $is_s_deluxe ){
									echo "<div class='well well-sm'><h3>Super Deluxe</h3></div>";
									echo "<table class='table table-bordered'><tr>
										<th>City</th>
										<th>Hotel Category</th>
										<th>Check In</th>
										<th>Check Out</th>
										<th>Hotel</th>
										<th>Room Category</th>
										<th>Plan</th>
										<th>Room</th>
										<th>N/T</th>
									</tr>";
									echo $super_deluxe_html . "</table>";
								}
								if( $is_luxury ){
									echo "<div class='well well-sm'><h3>Luxury</h3></div>";
									echo "<table class='table table-bordered'><tr>
										<th>City</th>
										<th>Hotel Category</th>
										<th>Check In</th>
										<th>Check Out</th>
										<th>Hotel</th>
										<th>Room Category</th>
										<th>Plan</th>
										<th>Room</th>
										<th>N/T</th>
									</tr>";
									echo $luxury_html . "</table>";
								}
							} ?>
						
						<?php } ?>	
					<hr>
				</div>
				<div class="well well-sm"><h3>Rates</h3></div>
					<!-- Rate Meta -->
					<table class='table table-bordered'><tr>
						<th>Hotel Category</th>
						<th>Standard</th>
						<th>Deluxe</th>
						<th>Super Deluxe</th>
						<th>Luxury</th>
					</tr>
					
					<?php
					//Rate meta
					$rate_meta = unserialize($iti->rates_meta);
					$strike_class = !empty( $discountPriceData ) ? "strikeLine" : " ";
					//print_r( $rate_meta );
					if( !empty( $rate_meta ) ){
						if( $iti->pending_price == 4 ){
							echo "<tr><td  colspan=5 class='red'>Awaiting price verfication from super manager.</td></tr>"; 
						}else{	
							$s_rates = isset( $rate_meta["standard_rates"] ) && !empty( $rate_meta["standard_rates"]) ? $rate_meta["standard_rates"] : 0;
							$d_rates = isset( $rate_meta["deluxe_rates"] ) && !empty( $rate_meta["deluxe_rates"]) ? $rate_meta["deluxe_rates"] : 0;
							$sd_rates = isset( $rate_meta["super_deluxe_rates"] ) && !empty( $rate_meta["super_deluxe_rates"]) ? $rate_meta["super_deluxe_rates"] : 0;
							$l_rates = isset( $rate_meta["luxury_rates"] ) && !empty( $rate_meta["luxury_rates"]) ? $rate_meta["luxury_rates"] : 0;
							
							$standard_rates = !empty( $s_rates ) ? number_format($s_rates) . "/-" : "--";
							$deluxe_rates = !empty( $d_rates ) ? number_format($d_rates) . "/-" : "--";
							$super_deluxe_rates = !empty( $sd_rates ) ? number_format($sd_rates) . "/-" : "--";
							$rate_luxry = !empty( $l_rates ) ? number_format($l_rates) . "/-" : "--";
							
							echo "<tr class='$strike_class'><td>Price</td>
									<td>
										<strong>" . $standard_rates . "</strong>
									</td>
									<td>
										<strong>" . $deluxe_rates . "</strong>
									</td>
									<td>
										<strong>" . $super_deluxe_rates . "</strong>
									</td>
									<td>
										<strong>" . $rate_luxry . "</strong>
									</td>
									</tr>";
									if( !empty( $discountPriceData ) ){
										foreach( $discountPriceData as $price ){
											$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates) . "/-" : "<strong class='red'>N/A</strong>";
											$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates) . "/-" : "<strong class='red'>N/A</strong>";
											$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates) . "/-"  : "<strong class='red'>N/A</strong>";
											$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates) . "/-"  : "<strong class='red'>N/A</strong>";
											
											$sr = isset( $price->standard_rates ) && !empty( $price->standard_rates ) ? $price->standard_rates : 0;
											$dr = isset( $price->deluxe_rates ) && !empty( $price->deluxe_rates ) ? $price->deluxe_rates : 0;
											$sdr = isset( $price->super_deluxe_rates ) && !empty( $price->super_deluxe_rates ) ? $price->super_deluxe_rates : 0;
											$lr = isset( $price->luxury_rates ) && !empty( $price->luxury_rates ) ? $price->luxury_rates : 0;
									
											$count_price = count( $discountPriceData );
											$strike_class = ($price !== end($discountPriceData) && $count_price > 1 ) ? "strikeLine" : "";
											echo "<tr class='$strike_class'><td>Price</td><td><strong>" . $s_price . "</strong></td>";
											echo "<td><strong>" . $d_price . "</strong></td>";
											echo "<td><strong>" . $sd_price . "</strong></td>";
											echo "<td><strong>" . $l_price . "</strong></td></tr>";
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
								</td>
								<td>
									<strong class='red'> Coming Soon </strong>
								</td></tr>";
					} ?>
					</table>
				<div class="tour_des">
					
					<ul class="list-group">
						<li class="col-md-4"><div class=" list-group-item"><strong> Itinerary Id: </strong><span class="badge badge-success"> <?php echo $iti->iti_id; ?></p> </span></div></li>
						<li class="col-md-4"><div class=" list-group-item"><strong> Name:</strong>	 <span class="badge badge-success"> <?php echo $customer_name; ?> </span></div></li>
						<li class="col-md-4"><div class=" list-group-item"><strong> Phone: </strong><span class="badge badge-success"> <?php echo $customer_contact; ?> </span></div></li>
						<li class="col-md-4"><div class=" list-group-item"><strong> Agent: </strong><span class="badge badge-success"> <?php echo get_user_name($iti->agent_id); ?> </span></div></li>
						<li class="col-md-4"><div class=" list-group-item"><strong> Prospect: </strong><span class="badge badge-success"> <?php echo !empty($followUpData) ? $followUpData[0]->itiProspect : "" ; ?> </span></div></li>
						
						<?php if(  $iti_status ==7 ){ ?>
							<li class="col-md-4 list-group-item"><div class=" list-group-item"><strong>Decline Reason: </strong> <?php echo $lead_note; ?></div></li>
							<li class="col-md-4 list-group-item"><strong>Decline Comment: </strong> <?php echo $iti->decline_comment; ?></li>
						<?php } ?>
						
						<?php if(  $iti_status == 9 ){ ?>
								<li class="col-md-4"><div class=" list-group-item"><strong>Final Amount: </strong> <span class="badge badge-success"><?php echo number_format($iti->final_amount) . " /-"; ?></span></div></li>
								<li class="col-md-4"><div class=" list-group-item"><strong>Package Category: </strong> <span class="badge badge-success"><?php echo $iti->approved_package_category; ?></span></div></li>
								<li class="col-md-4"><div class=" list-group-item"><strong>Comment: </strong> <span class="badge badge-success"><?php echo $lead_note; ?></span></div></li>
							<?php } ?>	
							
					</ul>
					
					<div class="clearfix"></div>
					</div>
					<!--Payment Detais section-->
					<?php 
					if( isset( $paymentDetails  ) && !empty( $paymentDetails ) &&  $iti->iti_status == 9 ){ 
						$payment = $paymentDetails[0]; ?>
						
						<h4>Advance Received Details</h4>
						<div class="tour_des">
							<div class="col-md-3"><p><strong>Total Cost: </strong> <?php echo number_format($payment->total_package_cost); ?></p></div>
							<div class="col-md-3"><p><strong>Advance Received: </strong> <?php echo number_format($payment->advance_recieved); ?></p></div>
							<div class="col-md-3"><p><strong>Booking Date: </strong> <?php echo !empty( $payment->booking_date ) ? display_month_name( $payment->booking_date ) : ""; ?></p></div>
							<div class="col-md-3"><p><strong>Balance: </strong> <?php echo number_format($payment->total_balance_amount) . " /-"; ?></p>
							</div>
						</div>
						
					 	
					<?php } ?>
					<!--End Payment Details section-->
					
					<!--service team section if user_role == 97 and iti is booked -->
					<!--Show hotel booking if any-->
					<?php if( $user_role == 97 && $iti->iti_status == 9 ){
							//Check hotel / volvo booking status
								$hotel_booking_status 		= is_hotel_booking_done( $iti->iti_id );
								$vtf_booking_status			= is_vtf_booking_done( $iti->iti_id );
								$total_payment_recieved_percentage = get_iti_pay_receive_percentage( $iti->iti_id );
								$is_voucher_confirm			 = is_voucher_confirm( $iti->iti_id );
					?>
					<?php $add_hotel_booking_link = base_url("hotelbooking/add/{$iti->iti_id}"); ?> 
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-calendar"></i>Hotel Booking Details</div>
							<?php if( !$hotel_booking_status ){ ?>
								<a href="<?php echo $add_hotel_booking_link; ?>" class="btn btn-success pull-right" title="Book Hotel"><i class="fa fa-plus"></i> Book New Hotel</a>
							<?php } ?>
						</div>
				
					 <div class="portlet-body ">
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="thead-default">
								<tr>
									<th> City </th>
									<th> Hotel Name </th>
									<th> Sent Status </th>
									<th> Status </th>
									<th> Action </th>
								</tr>
							</thead>
							<tbody>
								<?php if( $hotel_bookings ){ 
									foreach( $hotel_bookings as $h_book ){
										//Get hotel booking status-->
										if( $h_book->booking_status == 9 ){
											$status = "<span class='green'>BOOKED</span>";
										}else if($h_book->booking_status == 8){
											$status = "<span class='red'>Declined</span>";
										}else if( $h_book->booking_status == 7 ){
											$status = "<strong class='red'><i class='fa fa-window-close' aria-hidden='true'></i> &nbsp;Canceled</strong>";
										}else{
											$status = "<span class='blue'>Processing</span>";
										}
										?>
										<tr>
											<td><?php echo get_city_name($h_book->city_id); ?></td>
											<td><?php echo get_hotel_name($h_book->hotel_id); ?></td>
											<td><?php echo $h_book->email_count . " Time Sent"; ?></td>
											<td><?php echo $status; ?></td>
											<td><a title='View' href="<?php echo site_url("hotelbooking/view/{$h_book->id}/{$h_book->iti_id}"); ?>" class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a></td>
										</tr>
									<?php } ?>
								<?php }else{ ?>
									<tr>
										<td>
										<td colspan="4">No hotel booking create against this itinerary. 
										<?php if( !$hotel_booking_status ){ ?>
											<a href="<?php echo $add_hotel_booking_link; ?>" class="" title="Book Hotel">Click here to book hotel</a>
										<?php } ?>	
									</tr>	
								<?php } ?>
							</tbody>
						</table>
						
						<!--all Hotel booking confirmation button -->
						<?php if( $hotel_booking_status ){
							echo "<p class='text-center green'><strong>All Hotel Booking has been Confirmed.</strong></p>";
						}else{ ?>
							<button type="submit" data-iti_id="<?php echo $iti->iti_id; ?>" data-booking_type="hotel_booking_status" class="btn green uppercase confirm_booking_btn" title="All Hotel booking Done" >Confirm All Hotel Booking Done</button>
							<p style="font-size:12px; color: red;"><strong>Note: </strong>If you confirm hotel booking you can't able to create new booking against this itinerary.</p>
						<?php } ?>	
						
					</div>	
					</div>
					</div>
					
					<!--End hotel booking if any-->
					<!--step line start-->
					<hr>
					<?php $pay_class 	=  $total_payment_recieved_percentage >= 50 ? "done" : "error"; ?>
					<?php $hotel_class	 =  !empty( $hotel_booking_status ) ? "done" : "error"; ?>
					<?php $vtf_class	 =  !empty($vtf_booking_status) ? "done" : "error"; ?>
					<div class="mt-element-step">
						<div class="row step-line">
							<div class="mt-step-desc">
								<div class="font-dark bold uppercase text-center"><h2>BOOKING STATUS</h2></div>
								<div class="caption-desc font-grey-cascade"></div>
								<br/> 
							</div>
							<div class="col-md-6 mt-step-col <?php echo $hotel_class; ?>">
								<div class="mt-step-number bg-white">
									<i class="fa fa-bed"></i>
								</div>
								<div class="mt-step-title uppercase font-grey-cascade">Hotel Booking</div>
							</div>
							<div class="col-md-6 mt-step-col <?php echo $pay_class; ?>">
								<div class="mt-step-number bg-white">
									<i class="fa fa-inr"></i>
								</div>
								<div class="mt-step-title uppercase font-grey-cascade">Payments</div>
								<div class="mt-step-content font-grey-cascade">Min. Fifty Percentage Amount
								( Received Amount: <?php echo $total_payment_recieved_percentage; ?>% )</div>
							</div>
						</div>
						
						<!--show confirm voucher button if hotel and volovo/train/flight booking confirmed-->
						<?php if( $is_voucher_confirm ){
							echo "<p class='text-center green'><strong>Voucher has been Confirmed.</strong></p>";
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
					
					
					<?php } ?> <!--end hotl booking section-->
					<!--show child itineraries if exists -->
					<?php 
					$dupBtn ="";
					$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti->iti_id, "del_status" => 0) );
					
					//Get if Itinerary is parent or childIt
					$p_iti = empty( $parent_iti ) ? "Parent" : "Child";
					//Count All Child Itineraries
					//clone button
					if( $countChildIti < 6  && $iti->iti_status == 0 && $iti->email_count > 0 && $iti->publish_status == "publish" ){
						$dupBtn = "<a title='Duplicate Itinerary' href=" . site_url("itineraries/duplicate/{$iti->iti_id}") . " class='btn btn-success' ><i class='fa fa-files-o' aria-hidden='true'></i></a>"; 
					}	
					//get last followup
					$last_followUp_iti = isset( $lastFollow ) && !empty( $lastFollow ) ? trim($lastFollow) : 0;
					//current followup iti id
					$lFollow = $last_followUp_iti == $iti->iti_id ? "<strong class='green'>Last Followup On Current Itinerary</strong>" : "";
					$i=1;
					//Count All Child Itineraries
					$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti->iti_id, "del_status" => 0) );
					$dupChildBtn = "";
					if( !empty( $childItinerary ) ){
						echo "<h2 class='text-center'><strong>CHILD ITINERARIES</strong></h2>";
						foreach( $childItinerary as $c_iti ){
						//get iti_status
						$row_delete = "";
						$btncmt = "";
						$iti_status = $c_iti->iti_status;
						$parent_iti = $c_iti->parent_iti_id;
						$iti_id = $c_iti->iti_id;
						$key = $c_iti->temp_key;
						$pub_status = $c_iti->publish_status;
						//current followup iti id
						$curFollow = $last_followUp_iti == $iti_id ? "last_follow" : "";
						
						//get discount rate request
						$discount_request = $c_iti->discount_rate_request;
						$discReq = $discount_request == 1 ? "<strong class='red'> (Price Discount Request) </stron>" : " ";
						//Get Pulish status
						if( $pub_status == "publish" ){
							$p_status = "<div class='btn btn-success green'>" . ucfirst($pub_status) . "</div>";
							$p_status .= $discReq;
						}elseif( $pub_status == "price pending" ){
							$p_status = "<div class='btn btn-danger blue'>" . ucfirst($pub_status) . "</div>";
							$p_status .= $discReq;
						}else{
							$p_status = "<div class='btn btn-danger red'>" . ucfirst($pub_status) . "</div>";
						}
						
						/* count iti sent status */
						$iti_sent = $c_iti->email_count;
						$sent_status = $iti_sent > 0 ? "$iti_sent Time Sent" : "Not Sent";
						
						//Show duplicate button for child itinerary
					 	if( !empty( $parent_iti ) && $countChildIti < 6 ){
							$dupChildBtn = "<a title='Duplicate Current Itinerary' href=" . site_url("itineraries/duplicate_child_iti/?iti_id={$iti_id}&parent_iti_id={$parent_iti}" ) ." class='btn btn-success child_clone'><i class='fa fa-files-o' aria-hidden='true'></i></a>";
						}	 
						
						//if price is updated remove edit for agent
						if( ($c_iti->pending_price == 2 || $c_iti->pending_price == 4) && $user_role == 96 ){
							$btn_edit = "<a title='Edit' href='javascript: void(0)' class='btn btn-success editPop' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
						}else{
							$btn_edit = "<a title='Edit' href=" . site_url("itineraries/edit/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i></a>";
						}
						
						$btn_view = "<a title='View' target='_blank' href=" . site_url("itineraries/view_iti/{$iti_id}/{$key}") . " class='btn btn-success' ><i class='fa fa-eye' aria-hidden='true'></i></a>";
						$btn_view .= "<a title='View' target='_blank' href=" . site_url("promotion/package/{$iti_id}/{$key}") . " class='btn btn-success' >Client view</a>";
						$btn_view .= "<a title='View' target='_blank' href=" . site_url("promotion/itinerary/{$iti_id}/{$key}") . " class='btn btn-success' >Client view New</a>";

						if( !empty( $c_iti->client_comment_status ) && $c_iti->client_comment_status == 1 ){
							$btncmt = "<a data-id={$iti_id} data-key={$key} title='Client Comment' href='javascript:void(0)' class='btn btn-success ajax_iti_status red'><span class='blink'><i class='fa fa fa-comment-o' aria-hidden='true'></i>  New Comment</span></a>";
						}
						
						//if itinerary status is publish
						if( $pub_status == "publish" || $pub_status == "price pending" ){
							//delete itinerary button only for admin
							if( ( is_admin() || is_manager() ) && !empty( $parent_iti ) && ( $last_followUp_iti != $iti_id ) ){ 
								$row_delete = "<a data-id={$iti_id} title='Delete Itinerary' href='javascript:void(0)' class='btn btn-danger delete_iti_permanent'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
							}
							//echo "<td>{$btn_edit} {$btn_view} {$row_delete} {$it_status}{$dupBtn}</td>";
						}
						//echo "</tr>";
						echo "<div class='col-md-4'>
							<div class='itinerary-blocks {$curFollow}'>
							<div class='package_name'><div>{$btncmt}</div>{$c_iti->package_name}<div style='font-size:13px;'>{$c_iti->added}</div></div>
							<div class='hover_section'>
								{$btn_edit}
								{$btn_view}
								{$p_status}
								{$row_delete}
								{$dupChildBtn}
							</div>
							</div>
						</div>";
						
						$i++;
					}
				} ?><div class="clearfix"></div>
				 
				<div class="inquery_section">
						<!--show amendment button for sales team and manager-->
						<?php 
						//Check if final installment received or not
						//dump( $amendment_itineraries  );
						$total_amendments = !empty( $amendment_itineraries ) ? sizeof($amendment_itineraries) : 0;
						if( $iti_status == 9 && ( $user_role == 96 || is_admin_or_manager() ) ){
							echo '<p style="font-size:12px; color: red;" class="alert alert-danger"><strong>Note: </strong>You can create only three amendments of each itinerary.When amendment is approved you can\'t create new amendment.</p>';
							
							if( !empty( $amendment_itineraries )  ){
								$cnt = 1;
								foreach( $amendment_itineraries as $amend ){
									$view_btn= "<a target='_blank' href='". base_url("itineraries/view_amendment/{$amend->id}") ."' class='btn btn-success' title='click to amendment View Itinerary'>Click Here To View Amendment {$cnt}</a>";
									
									$client_view = "<a target='_blank' href='". base_url("promotion/amendment_view/{$amend->id}/{$amend->iti_id}/{$amend->temp_key}") ."' class='btn btn-danger' title='Client View'>Client View {$cnt}</a>";
									
									echo "<div class='col-md-4'>{$view_btn} {$client_view}</div>";
									$cnt++;
								}
							}
							
							//show create amendment button if amendment less than 2
							if( $total_amendments < 3 && $iti->is_amendment != 2 ) {
								echo "<div class='clearfix'></div>";
								echo "<div class='row amendment_clone_btn' style='margin-top: 10px;'><a href='". base_url("itineraries/clone_iti_to_amendment/{$iti->iti_id}") ."' class='btn btn-success amdment_btn' title='click to amendment in itinerary'>Click Here To Clone And Amendment In Itinerary</a></div>";
							}	
						}
						?>
						<div class='clearfix'></div>
						<!--View Parent Itinerary Button -->
						<?php
							$view_parent_btn = $dupChildBtn = "";
							if( !empty( $iti->parent_iti_id  ) ){
								//Count All Child Itineraries
								$countChildIti = $this->global_model->count_all( 'itinerary', array("parent_iti_id" => $iti->parent_iti_id, "del_status" => 0) );
								
								$parent_view_link = iti_view_link($iti->parent_iti_id);
								$view_parent_btn = "<a class='btn btn-success' target='_blank' href='{$parent_view_link}' title='View Parent Quotation'><i class='fa fa-eye' aria-hidden='true'></i> View Parent Itinerary</a>";
								
								if( $countChildIti < 6 ){
									$dupChildBtn = "<a title='Duplicate Current Itinerary' href=" . site_url("itineraries/duplicate_child_iti/?iti_id={$iti->iti_id}&parent_iti_id={$iti->parent_iti_id}" ) ." class='btn btn-success' ><i class='fa fa-files-o' aria-hidden='true'></i></a>";
								}	
							}
						?>
						<hr>
						<!--if amendment is done show old itinerary-->
						<?php if( $iti->is_amendment == 2 ){ ?>
							<a title='View Old Quotation' target="_blank" href=" <?php echo site_url("itineraries/view_old_iti/{$iti->iti_id}") ; ?> " class='btn btn-danger' ><i class='fa fa-eye' aria-hidden='true'></i> View Old Quotation</a>
						<?php } ?>
						
						<a class="btn btn-success" target="_blank" href="<?php echo site_url("itineraries/view/{$iti->iti_id}/{$iti->temp_key}"); ?>" title="View Quotation"><i class='fa fa-eye' aria-hidden='true'></i> View Quotation</a>
						
						<?php if( empty($iti_status) && $iti->email_count > 0 && $iti->publish_status == "publish" ){ ?>
							<a class="btn btn-danger" href="#" id="add_call_btn" title="Back">Add Call Info</a>
						<?php } ?>	
						
						<strong class="btn btn-danger"><?php echo $lead_status ?></strong>
						<!--show duplicate button if parent iti -->
						<?php echo $dupBtn; ?>
						<?php echo $lFollow; ?>
						<?php echo $view_parent_btn; ?>
						<?php echo $dupChildBtn; ?>
						
						<p style="margin-bottom:0;" class="alert alert-danger"><strong>Note: </strong>You can only take the itinerary follow up if itinerary sent to customer And itinerary in working stage.</p>
					</div>
				<!-- Call log section appears if itinerary sent to client And status is publish And not booked or declined -->
					<?php if( $iti->iti_status == 0 && $iti->email_count > 0 && $iti->publish_status == "publish" && $user_role != 97 ){ ?>
						<!-- Call log section -->
						<div class="call_log" id="call_log_section">
							<form id="call_detais_form">
								<div class="call_type_seciton">
									<label class="radio-inline">
										<input data-id="picked_call_panel" required id="picked_call" class="radio_toggle" type="radio" name="callType" value="Picked call">Picked call
									</label>
									<label class="radio-inline">
										<input class="radio_toggle" data-id="call_not_picked_panel" required id="call_not_picked" type="radio" name="callType" value="Call not picked">Call not picked</label>
									<label class="radio-inline">
										<input class="radio_toggle" data-id="close_lead_panel" required id="close_lead" type="radio" name="callType" value="Close lead">Decline Itinerary</label>
									<label class="radio-inline">
										<input class="radio_toggle" data-id="booked_lead_panel" required id="booked_lead" type="radio" name="callType" value="Booked lead">Booked Itinerary</label>
								</div>
								<div id="panel_detail_section">
									<div class="call_type_res" id="picked_call_panel"><!--picked call panel-->
										<div class="col-md-6">
											<div class="form-group">
											  <label for="comment">Call summary<span style="color:red;">*</span>:</label>
											  <textarea required class="form-control" rows="3" name="callSummary" id="callSummary"></textarea>
											</div> 
										</div>
										<div class="col-md-3">
											<div class="checkbox">
												<label><input id="nxtCallCk" type="checkbox" value="">Next call time</label>
											</div>
											<div id="next_call_cal">
												<label>Next calling time and date<span style="color:red;">*</span>:</label> 
												<input size="16" required type="text" value="" name="nextCallTime" readonly class="form-control form_datetime">  
											</div>	
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label>Lead prospect<span style="color:red;">*</span></label>
												<select required class="form-control" name="txtProspect">
													<option value="Hot">Hot</option>
													<option value="Warm">Warm</option>
													<option value="Cold">Cold</option>
												</select>
											</div>
										</div>
									</div><!--end picked call panel-->
									<div class="call_type_res" id="call_not_picked_panel"><!--call_not_picked panel-->
										<div class="col-md-12">
											<label class="radio-inline">
												<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Switched off">Switched off
											</label>
											<label class="radio-inline">
												<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Not reachable">Not reachable
											</label>
											<label class="radio-inline">
												<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Not answering">Not answering
											</label>
											<div class="nxt_call">
												<div class="col-md-6">
													<label>Next calling time and date<span style="color:red;">*</span>:</label> 
													<input size="16" required type="text" value="" readonly name="nextCallTimeNotpicked" class="form-control form_datetime"> 
												</div>
												
												<div class="col-md-6">
													<div class="form-group">
														<label>Lead prospect<span style="color:red;">*</span></label>
														<select required class="form-control" name="txtProspectNotpicked">
															<option value="Hot">Hot</option>
															<option value="Warm">Warm</option>
															<option value="Cold">Cold</option>
														</select>
													</div>
												</div>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-">
														<div class="form-group">
														  <label for="comment">Comment<span style="color:red;">*</span>:</label>
														  <textarea required class="form-control" rows="3" name="comment" id="comment"></textarea>
														</div> 
													</div>
												</div>	
											</div>	
										
										</div>
									</div><!--end call not picked panel-->	
									<!--booked_lead_panel panel If itinerary booked-->
									<div class="call_type_res" id="booked_lead_panel">
										<div class="form-group col-md-3">
											<label for="usr">Package Category<span style="color:red;"> *</span>:</label>
											<select required class="form-control" name="approved_package_category">
												<option value="">Select package category</option>
												<option value="Deluxe">Deluxe</option>
												<option value="Super Deluxe">Super Deluxe</option>
												<option value="Luxury">Luxury</option>
												<option value="Super Luxury">Super Luxury</option>
											</select>
										</div>
										<div class="form-group col-md-3">
											<label class=""><strong>Booking Date:</strong></label>
											<input required readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control" id="booking_date" type="text" value="" name="booking_date"  />
										</div>
										<?php $get_tax = get_tax();
										$tax = !empty( $get_tax ) ? trim($get_tax) : 0;	?>
										
										<div class="form-group col-md-3">
											<label for="usr">Total Package Cost<span style="color:red;"> *</span>:</label>
											<input type="number" required class="form-control" data-tax="<?php echo $tax; ?>" id="fnl_amount" placeholder="Total Package Cost" />
										</div>
										
										<div class="form-group col-md-3">
											<label for="usr">Total Package Cost Inc. ( <?php echo $tax; ?>% ) Tax<span style="color:red;"> *</span>:</label>
											<input type="number" readonly required class="form-control" id="fnl_amount_tax" title="Total package cost after inc. tax" placeholder="Total package cost after inc. tax" name="final_amount" >
										</div>
										
										<div class="clearfix"></div>
										<div class="form-group col-md-6">
											<label class=""><strong>Advance Received:</strong>* <span id="fiftyPer"></span></label>
											<input required type="number" id="pack_advance_recieve" name="advance_recieve" placeholder="Advance Received. eg: 5000" class="form-control" value="">
										</div>
										
										
										<div class="form-group col-md-6">
											<label class=""><strong>Transaction Date(1st installment):</strong> *</label>
											<input required readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control transaction_date" id="transaction_date" type="text" value="" name="transaction_date"  />
										</div>
										<div class="clearfix"></div>
										
										<!--Payment Details -->
										<div id="due_payment_section">
											<div class="form-group col-md-6">
												<label class=""><strong>Second Installment Amount:</strong></label>
												<input type="text" readonly id="next_pay_balance" data-date-format="yyyy-mm-dd" name="next_payment_bal" placeholder="Second Payment Balance" class="form-control" value="">
											</div>
											
											<div class="form-group col-md-6">
												<label class=""><strong>Second Installment Due Date:</strong></label>
												<input readonly="readonly"  data-date-format="yyyy-mm-dd" class="input-group form-control date_picker" id="next_payment_date" type="text" value="" name="next_payment_date"  />
											</div>
											
											<div class="form-group col-md-6">
												<label class=""><strong>3rd Installment Amount:</strong><span id="pendingBal"></span></label>
												<input type="number" readonly id="third_payment_bal" name="third_payment_bal" placeholder="Third Payment Amount" class="form-control" value="">
											</div>
											
											<div class="form-group col-md-6">
												<label class=""><strong>3rd Installment Due Date:</strong></label>
												<input readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control date_picker_validation date_picker" id="third_payment_date" type="text" value="" name="third_payment_date"  />
											</div>
											
											<div class="form-group col-md-6">
												<label class=""><strong>Final Installment:</strong></label>
												<input type="number" readonly id="final_payment_bal" name="final_payment_bal" placeholder="Final Installment Amount" class="form-control" value="">
											</div>
											
											<div class="form-group col-md-6">
												<label class=""><strong>Final Installment Due Date:</strong></label>
												<input readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control date_picker_validation date_picker" id="final_payment_date" type="text" value="" name="final_payment_date"  />
											</div>
										</div>	
										<div class="form-group col-md-6">
											<label class=""><strong>Total Balance Remaining:</strong></label>
											<input type="text" required readonly id="balance_pay" name="total_balance" placeholder="" class="form-control" value="">
										</div>
										<div class="form-group col-md-6">
											<label class=""><strong>Travel Date*:</strong></label>
											<input readonly="readonly" data-date-format="yyyy-mm-dd" class="input-group form-control date_picker" id="travel_date" type="text" value="" name="travel_date"  />
										</div>
										<div class="form-group col-md-6">
											<div class="form-group2">
												<label class=" "><strong>Bank Name*:</strong></label>
												<input required class="form-control" id="bank_name" type="text" placeholder="eg: HDFC, ICIC" name="bank_name" value="">
											</div>	 
										</div>
										<div class="form-group col-md-6">
											<label for="usr">Please Enter Approval Note:<span style="color:red;"> *</span>:</label>
											<textarea required class="form-control" placeholder="Please Enter Approval Note" name="iti_note_booked" ></textarea>
										</div>
										<!--End Payment Details -->
									</div><!--end booked_lead panel-->	
									<div class="call_type_res" id="close_lead_panel"><!--close_lead_panel panel-->
										<div class="form-group col-md-6">
											<select required class="form-control" name="iti_note_decline">
												<option value="">Select Reason</option>
												<option value="Booked with someone else">Booked with someone else</option>
												<option value="Not interested">Not interested</option>
												<option value="Price is high">Price is high</option>
												<option value="Not answering call from 1 week">Not answering call from 1 week</option>
												<option value="Plan cancelled">Plan cancelled</option>
												<option value="Wrong number">Wrong number</option>
												<option value="Denied to post lead">Denied to post lead</option>
												<option value="Other">Other</option>
											</select>
										</div>
										<div class="clearfix"></div>
										<div class="form-group col-md-6">
											<div class="form-group">
												<label for="comment">Decline Comment:</label>
												<textarea class="form-control" rows="3" name="decline_comment" id="decline_comment"></textarea>
											</div> 
										</div>
									</div><!--end close_lead_panel-->	
								</div><!--panel_section end-->
								<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
								<input type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
								<input type="hidden" name="customer_id" value="<?php echo $iti->customer_id; ?>">
								<input type="hidden" name="parent_iti_id" value="<?php echo $iti->parent_iti_id; ?>">
								<input type="hidden" name="agent_id" value="<?php echo $iti->agent_id; ?>">
								<input type="hidden" name="iti_type" value="2">
								<div class="margiv-top-10">
									<button type="submit" id="submit_frm" class="btn green uppercase submit_frm">Submit</button>
									<button class="btn red uppercase cancle_bnt">Cancel</button>
								</div>
								<div class="clearfix"></div>
								<div class="resPonse"></div>
							</form>
						</div>
					<?php  }   ?>	
					
					<div class="clearfix"></div>
					<?php if( !empty( $followUpData ) ){ ?>
						<div class="panel-group accordion" id="accordion3">
							<?php
							$count = 1;
							foreach( $followUpData as $callDetails ){ ?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_<?php echo $count;?>"><?php echo $callDetails->currentCallTime;?></a>
										</h4>
									</div>
									<div id="collapse_3_<?php echo $count;?>" class="panel-collapse collapse">
										<div class="panel-body">
											<p><strong>Acc Id: <?php echo $callDetails->iti_id;?></strong></p>
											<p><strong><?php echo $callDetails->callType;?></strong></p>
											<p><strong>Call summary:</strong> <?php echo $callDetails->callSummary;?></p>
											<p><strong>Next Call Time:</strong> <?php echo $callDetails->nextCallDate;?></p>
											<p><strong><?php echo $callDetails->itiProspect;?></strong></p>
										</div>
									</div>
								</div>
								<?php $count++; ?>
							<?php } ?>
						</div>	
					<?php } ?>	
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<div class="loader"></div>
<style>.mt-element-step .step-line .mt-step-number>i{top: 78%; }</style>
<style>
#call_log_section{display: none;} 
#close_lead_panel,#booked_lead_panel,#call_not_picked_panel,#picked_call_panel, .nxt_call{display: none}
#next_call_cal{display: none;}
.tour_des {
	background: #faebcc;
	padding-top: 20px;
	padding-bottom: 40px;
}
</style>
<!-- Booking Payment Script -->
<script type="text/javascript">
jQuery(document).ready(function($){
	//On click amdment_btn
	$(document).on("click", ".amdment_btn", function(e){
		e.preventDefault();
		var _this_url = $(this).attr("href");
		if (confirm("Are you sure to amendment in this itinerary?")) {
			window.location.href = _this_url;
		}   
	});
	
	//Empty date picker if second installment empty
	$(".date_picker_validation").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			var nextPayDate = $("#next_payment_date").datepicker("getDate");
			//console.log( "nextPayDate " + nextPayDate );
			if( nextPayDate == null ){
				alert("Please Enter Second Installment Date First");
				//$(this).val("");
				$(".date_picker_validation").datepicker("hide");
				$('#next_payment_date').focus();
				return false;
			}
		});
	});
	//Set Min Date 
	var Ad_pay = $("#pack_advance_recieve").val(), fifPer = $("#fiftyPer").val();
	var end_date = Ad_pay >= fifPer ? "+30d" : "+10d";
	$('#next_payment_date').datepicker({
        format: "yyyy-mm-dd",
		startDate: "now",
	//	endDate: end_date
    }).on('changeDate', function(ev){
		$('.date_picker_validation').val("");
		var _thisDate = ev.date;
		var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
		$('.date_picker_validation').datepicker('setStartDate', nextDayMin);
	});
	
	$('#third_payment_date').datepicker({
        format: "yyyy-mm-dd",
    }).on('changeDate', function(ev){
		$('#final_payment_date').val("");
		var _thisDate = ev.date;
		var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
		$('#final_payment_date').datepicker('setStartDate', nextDayMin);
	});
	
	
	$(document).on("click", ".date_picker", function(){
		$(this).datepicker({startDate: "now", todayHighlight: true, todayHighlight: true}).datepicker('show');
	}); 
	
	//$(".date_picker").datepicker({startDate: "now", todayHighlight: true});
	$(".transaction_date").datepicker({startDate: "-10d", todayHighlight: true});
	$("#booking_date").datepicker({startDate: "-10d", todayHighlight: true});
	
	
	
	//Prevent Dot from number field
	$("input[type='number']").on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if( keyCode == 8 ) return true;
		if( this.value.length==8 ) return false;
		
		if ( keyCode != 8 ) {
            if (keyCode < 48 || keyCode > 57) {
				return false;
			}else {
                return true;
            }
        }else {
            return true;
        }
		
	});
	
	/* On Final Amount blur */
	$('#fnl_amount').keypress(function(e){ 
	   if (this.value.length == 0 && e.which == 48 ){
		  return false;
	   }
	});
	$(document).on("blur", "#fnl_amount", function(){
		if ($(this).attr("readonly")) return false;
		//Empty field
		$("#fnl_amount_tax").val('');
		$("#due_payment_section").find('input').val('');
		$("#due_payment_section").find('.date_picker').datepicker('clearDates');
		$("#due_payment_section").find('input').removeAttr('required');
		$("#next_pay_balance, #third_payment_bal").attr("readonly", "readonly");
		var value = parseFloat($(this).val());
		if( value < 0 || $.isNumeric( $(this).val() ) == false ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive Final Amount value</div>');
			$(this).val("");
			return false;
		}else{
			$(".resPonse").html("");
		}	
		
		//Calculate tax
		var sub = 0;
		var rate = parseInt($(this).val());
        var tax_rate = parseInt($(this).attr("data-tax"));
        var tax_amount = rate * tax_rate / 100;
		sub = rate+tax_amount;
		var amount_after_tax = Math.round(sub);
        $("#fnl_amount_tax").val( amount_after_tax );
		
		//calculate 50% of total amount after tax
		var calcFiftyPercentage  = (amount_after_tax - ( amount_after_tax * 50 / 100 )).toFixed(0);
		$("#fiftyPer").text("Fifty Percentage: " + calcFiftyPercentage);
		$("#balance_pay").val("");
		$("#pack_advance_recieve").val("");
	});
	
	/* On advance payment blur */
	$(document).on("blur", "#pack_advance_recieve", function(){
		if ($(this).attr("readonly")) return false;
		$("#due_payment_section").find('input').val('');
		$("#due_payment_section").find('.date_picker').datepicker('clearDates');
		$("#due_payment_section").find('input').removeAttr('required');
		$("#third_payment_bal").attr("readonly", "readonly");
		var _this = $(this);
		var _this_val = parseFloat($(this).val());
		var total_cost		= $("#fnl_amount_tax").val();
		//var total_cost		= $("#fnl_amount").val();
		var balance_pay 	= $("#balance_pay");
		var next_pay_balance = $("#next_pay_balance");
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			return false;
		}else{
			$(".resPonse").html('');
		}
		//if advance is greater than final amount
		if( _this_val > total_cost ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Advance should be less than final amount</div>');
			_this.val("");
			return false;			
		}else{
			$(".resPonse").html('');
		}
		//check if advance payment is less than 50% calculate next payment balance
		var calcFiftyPercentage  = (total_cost - ( total_cost * 50 / 100 )).toFixed(0);
		var nxtPay = (calcFiftyPercentage - _this_val).toFixed(0);
		if( _this_val <  calcFiftyPercentage ){
			next_pay_balance.val(nxtPay);
			next_pay_balance.attr("readonly", "readonly");
			$("#third_payment_bal").removeAttr("readonly");
			$("#third_payment_bal, #third_payment_date").attr("required", "required");
			next_pay_balance.removeAttr("readonly");
			$('#next_payment_date').datepicker('setEndDate', "+10d");
		}else{
			$('#next_payment_date').datepicker('setEndDate', "+90d");
			next_pay_balance.val("");
			next_pay_balance.attr("required", "required");
			next_pay_balance.removeAttr("readonly");
		}
		
		
		//calculate Total Balance
		var calTotalBal  = (total_cost - _this_val).toFixed(0);
		balance_pay.val(calTotalBal);
		
		//remove required attribute if Balance is null
		if( $("#balance_pay").val() < 1 ){
			$("#next_payment_date,#next_pay_balance").removeAttr("required");
			//next_pay_balance.val("");
			$("#next_pay_balance, #third_payment_bal").attr("readonly", "readonly");
			//$("#third_payment_bal, #third_payment_date").removeAttr("required", "required");
		}else{
			$("#next_payment_date, #next_pay_balance").attr("required", "required");
		}
		
	});
	
	/* On Next payment blur */
	$(document).on("blur", "#next_pay_balance", function(){
		if ($(this).attr("readonly")) return false;
		
		$("#final_payment_bal, #third_payment_bal").val("");
		$("#final_payment_date").removeAttr("required");
		$(".date_picker_validation").datepicker("clearDates");
		var _this = $(this);
		var _this_val		= parseFloat($(this).val());
		var total_cost		= $("#fnl_amount_tax").val();
		//var total_cost		= $("#fnl_amount").val();
		var advance			= $("#pack_advance_recieve").val();
		var balance_pay 	= $("#balance_pay");
		var thrPay 			= $("#third_payment_bal");
		
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			return false;
		}else{
			$(".resPonse").html('');
		}
		
		//Check Pending Balace 
		var pending = (total_cost - advance).toFixed(0);
		
		//Check Second installment
		var calcFiftyPercentage  = (total_cost - ( total_cost * 50 / 100 )).toFixed(0);
		var second_ins = calcFiftyPercentage - advance;
		if( _this_val < second_ins ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be Greater than or equal amount = '+ second_ins +'</div>');
			_this.val("");
			return false;
		}	
		
		//if advance is greater than final amount
		if( _this_val > pending ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be less than or equal Pending amount = '+ pending +'</div>');
			_this.val("");
			return false;			
		}else{
			$(".resPonse").html('');
		}
		var removeAt = _this_val >= pending ? thrPay.attr("readonly", "readonly") : thrPay.removeAttr("readonly");
		var addAttr = _this_val < pending ? $("#third_payment_bal, #third_payment_date").attr("required", "required") : $("#third_payment_bal, #third_payment_date").removeAttr("required");
	});
	
	/* On Third payment blur */
	$(document).on("blur", "#third_payment_bal", function(){
		if ($(this).attr("readonly")) return false;
		
		var _this = $(this);
		var _this_val		= parseFloat($(this).val());
		$("#final_payment_date").datepicker("clearDates");
		var total_cost		= parseFloat($("#fnl_amount_tax").val());
		//var total_cost		= parseFloat($("#fnl_amount").val());
		var advance			= parseFloat($("#pack_advance_recieve").val());
		var nextPay		 	= parseFloat($("#next_pay_balance").val());
		$("#final_payment_bal").val("");
		var fDat = $("#final_payment_date");
		fDat.removeAttr("required");
		
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			return false;
		}else{
			$(".resPonse").html('');
		}
		
		//Check Pending Balace 
		var totalF = advance + nextPay;
		var pending = (total_cost - totalF ).toFixed(0);
		console.log( totalF );
		//if advance is greater than final amount
		if( _this_val > pending ){
			$(".resPonse").html('<div class="alert alert-danger"><strong>Error! </strong>Next Payment should be less than Pending amount = '+ pending +'</div>');
			_this.val("");
			return false;			
		}else{
			$(".resPonse").html('');
		}
		
		//check for final amount 
		var r = advance + nextPay + _this_val ;
		var finalAmount  = (total_cost - r  ).toFixed(0);
		$("#final_payment_bal").val(finalAmount);
		var addAtt = finalAmount >= 1 ? fDat.attr("required", "required") : fDat.removeAttr("required");
		
	});
});
</script>
<!-- End Booking Payment Script -->
<script type="text/javascript">
jQuery(document).ready(function($){
	//reset all fields
	function resetForm(){
		$("#call_detais_form").find("input[type=text],input[type=number], textarea,select").val("");
		$("#call_detais_form").find('input:checkbox').removeAttr('checked');
		$("#call_detais_form").find('.call_type_not_answer').removeAttr('checked');
		$(".nxt_call").hide();
	}
	//radio button calltype on change function
	$(document).on("change", ".radio_toggle", function(e){
		e.preventDefault();
		var _this = $(this);
		var section_id = _this.attr("data-id");
		$("#panel_detail_section").show().find("#"+section_id).slideDown();
		$('.call_type_res').not('#' + section_id).hide();
		//reset form
		resetForm();
	});
	
	$(document).on("click", "#add_call_btn", function(e){
		e.preventDefault();
		$("#call_log_section").slideDown();
		$(this).fadeOut();
	});
	
	//on cancle btn click
	$(document).on("click", ".cancle_bnt", function(e){
		e.preventDefault();
		$("#call_log_section").slideUp();
		$("#add_call_btn").fadeIn();
		$("#panel_detail_section").hide();
		$("#submit_frm").removeAttr("disabled");
		//reset form
		$("#call_detais_form").find('.radio_toggle').removeAttr('checked');
		resetForm();
	});
	
	//on picked call select
	var date = new Date();
	date.setDate(date.getDate());
	$(".form_datetime").datetimepicker({
		format: "yyyy-mm-dd hh:ii:ss",
		showMeridian: true,
		startDate: date,
	});
	//show date picker
	$(document).on('click','#nxtCallCk', function() {
		if (!$(this).is(':checked')) {
			$("#next_call_cal").slideUp();
			$(".form_datetime").val("");
		}else{
			$("#next_call_cal").slideDown();
		}	
    });
	
	//show next call section if call not picked
	$(".call_type_not_answer").click(function(){
		if($(this).is(':checked')) { 
			$(".nxt_call").show();
		}else{
			$(".nxt_call").hide();
		}
	});
	//End on picked call selection
	$('input.pck_cost').change(function() {
		var _this = $(this);
		var car_cat = _this.parent().parent().find(".car_cat_v").val();
		var m_plan = _this.parent().parent().find(".m_plan_v").val();
		var pack_cost = _this.parent().parent().find(".pack_cost_v").val();
		$(".car_cat").val(car_cat);
		$(".m_plan").val(m_plan);
		$(".pack_cost").val(pack_cost);
	});
	//validate form
	var ajaxReq;
	var resp = $(".resPonse");
	$("#call_detais_form").validate({
		submitHandler: function(form, event) {
			event.preventDefault();
			$("#submit_frm").attr("disabled", "disabled");
			var formData = $("#call_detais_form").serializeArray();
			console.log(formData);
			//Get call type value
			var callType = $('input[name=callType]:checked').val();
			console.log(callType);
				if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/updateItiStatus'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					$("#call_detais_form")[0].reset();
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log("done");
						location.reload(); 
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						$("#submit_frm").removeAttr("disabled");
						alert("error");
						console.log("error");
					}
				},
				error: function(e){
					resp.html('<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>');
					console.log(e);
				}
			});
			return false;
		} 
	});	
	
	//Show Modal if itinerary price updated for agent
	$(document).on("click",".editPop",function(){
		$("#editModal").show();
	});
	$(document).on("click",".editPopClose",function(){
		$("#editModal").hide();
	});
	
});
</script>


<script type="text/javascript">
jQuery(document).ready(function($){
	$('.confirm_booking_btn').on('click', function () {
		var _this_title = $(this).attr("title");
		if( confirm('Are you sure to ' + _this_title + ' ?') ){
			//Update status send ajax request
			console.log("done");
			var iti_id 			= $(this).attr("data-iti_id");
			var booking_type 	= $(this).attr("data-booking_type");
			console.log( iti_id  + " " + booking_type );
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/ajax_update_booking_status'); ?>" ,
				dataType: 'json',
				data: {iti_id: iti_id, type: booking_type },
				beforeSend: function(){
					$(".loader").show();
					console.log("sending...");
				},
				success: function(res) {
					$(".loader").hide();
					alert( res.msg );
					location.reload();
				},
				error: function(e){
					$(".loader").hide();
					alert("Error: Please reload the page and try again.");
					location.reload();
					console.log(e);
					//response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
		}
	});
	
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

});	
</script>
<?php }else{
		redirect("itineraries");
	} ?>