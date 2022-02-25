<div class="page-container itinerary-view view_call_info">
    test
    <div class="page-content-wrapper">
        <div class="page-content">
            <!--Show success message if hotel edit/add -->
            <?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
            <?php if( !empty($itinerary ) ){ 
				$iti = $itinerary[0];
				$lFollow = "";			
				
				//Check hotel / volvo booking status
				$hotel_booking_status 		= is_hotel_booking_done( $iti->iti_id );
				$vtf_booking_status			= is_vtf_booking_done( $iti->iti_id );
				$cab_booking_status			= is_cab_booking_done( $iti->iti_id );
				$total_payment_recieved_percentage = get_iti_pay_receive_percentage( $iti->iti_id );
				$is_voucher_confirm			 = is_voucher_confirm( $iti->iti_id );
				
				//check if amendment done against this itinerary
				$is_amendment = $amendment_note = "";
				//show amendment note if revised itinerary
				if( $iti->is_amendment == 2 ){ 
					// $is_amendment = "<h3 class='text-center red'>REVISED ITINERARY</h3>";
					$amendment_cmt = $this->global_model->getdata( "iti_amendment_temp", array( "iti_id" => $iti->iti_id ) );
					$amendment_note = !empty( $amendment_cmt ) ? "<p class='alert alert-danger  '> <strong><i class='fas fa-hand-point-right'></i> REVISED ITINERARY</strong><br> Amendment: {$amendment_cmt[0]->review_comment}</p>" : "";
				}  
				
				$iti_status = $iti->iti_status;	
				$iti_note = $iti->followup_status;
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
				$cust = $get_customer_info[0];
				if( !empty( $get_customer_info ) ){  
					$customer_name = $cust->customer_name;
					$customer_contact = $cust->customer_contact;
					$customer_email = $cust->customer_email;
				}else{
					$customer_name = "";
					$customer_contact = "";
					$customer_email = "";
				} ?>



            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-users"></i>Customer Id: <span
                            class=''><?php echo $iti->customer_id; ?></span> Customer Name: <span
                            class=''><?php echo $customer_name; ?></span></div>
                    <a class="btn btn-success pull-right" href="<?php echo site_url("itineraries"); ?>"
                        title="Back">Back</a>
                </div>


                <?php if( $iti->final_amount ){ ?>
                <!-- Declined Reason -->

                <!--					<div class="portlet-body">
						<div class=""><?php echo $is_amendment . $amendment_note; ?></div>
						<p class="green">Package Final Cost: <strong><?php echo $iti->final_amount; ?></strong></p>
						<p class="green">Package Category: <strong><?php echo $iti->approved_package_category; ?></strong></p>
						<p class="green">Travel Date: <strong><?php echo get_travel_date($iti->iti_id); ?></strong></p>
					</div> -->

                <div class="portlet-body">
                    <div class=""><?php echo $is_amendment . $amendment_note; ?></div>
                    <table class="table table-bordered table-striped">
                        <tr class=thead-inverse">
                            <td>Package Final Cost: </td>
                            <td><strong><?php echo $iti->final_amount; ?></strong></td>
                        </tr>

                        <tr>
                            <td>Package Category: </td>
                            <td><strong><?php echo $iti->approved_package_category; ?></strong></td>
                        </tr>
                        <tr>
                            <td>Travel Date: </td>
                            <td><strong><?php echo get_travel_date($iti->iti_id); ?></strong></td>
                        </tr>
                    </table>
                </div>


                <?php } ?>
            </div>
            <div class="row2">
                <?php echo $is_amendment; ?>
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption"><i class="far fa-calendar-alt"></i> Package Overview</div>
                    </div>

                    <div class="portlet-body">
                        <div class="table-responsive">
                            <table class="table table table-striped table-hover table-bordered">
                                <tbody>
                                    <tr class="thead-inverse">
                                        <td><strong>Name of Package</strong></td>
                                        <td><strong>Routing</strong></td>
                                        <td><strong>Duration</strong></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $iti->package_name; ?></td>
                                        <td><?php echo $iti->package_routing; ?></td>
                                        <td><?php echo $iti->duration; ?></td>
                                    </tr>

                                    <tr>
                                        <td><strong>Total Travellers</strong></td>
                                        <td><strong>Cab</strong></td>
                                        <td><strong>Quotation Date</strong></td>

                                    </tr>
                                    <tr>
                                        <td>
                                            <?php
										echo "<strong> Adults: </strong> " . $iti->adults; 
										if( !empty( $iti->child ) ){
											echo "<strong> No. of Child: </strong> " . $iti->child; 
											echo "<strong> Child age: </strong> " . $iti->child_age; 
										}
										?>
                                        </td>
                                        <td><?php echo get_car_name($iti->cab_category); ?></td>
                                        <td><?php echo display_date_month_name($iti->quatation_date); ?>
                                        </td>

                                    </tr>
                                    <!--rooms meta section -->
                                    <?php
									$room_category = $total_rooms = $with_extra_bed  = $without_extra_bed = "-";
									if( isset( $iti->rooms_meta) && !empty( $iti->rooms_meta ) ){
										$rooms_meta 	= unserialize( $iti->rooms_meta );
										$room_category 	= isset($rooms_meta["room_category"]) && !empty( $rooms_meta["room_category"] ) ? get_roomcat_name($rooms_meta["room_category"]) : "-";
										$total_rooms 		= isset($rooms_meta["total_rooms"]) && !empty( $rooms_meta["total_rooms"] ) ? $rooms_meta["total_rooms"] : "-";
										$with_extra_bed 	= isset($rooms_meta["with_extra_bed"]) && !empty( $rooms_meta["with_extra_bed"] ) ? $rooms_meta["with_extra_bed"] : "-";
										$without_extra_bed 	= isset($rooms_meta["without_extra_bed"]) && !empty( $rooms_meta["without_extra_bed"] )  ? $rooms_meta["without_extra_bed"] : "-";
									}  ?>
                                    <tr>
                                        <td><strong>Room Category</strong></td>
                                        <td><strong>No. Of Rooms</strong></td>
                                        <td><strong>With Extra Bed</strong></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $room_category; ?></td>
                                        <td><?php echo $total_rooms; ?></td>
                                        <td><?php echo $with_extra_bed; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Without Extra Bed</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td><strong><?php echo $without_extra_bed; ?></strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- portlet body -->
                </div> <!-- portlet -->

                <div class="clearfix"></div>
            </div>

            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption"><i class="far fa-building"></i> Hotel Details</div>
                </div>


                <div class="portlet-body">
                    <?php $hotel_meta = unserialize($iti->hotel_meta); 
					$strike_class_final = !empty( $iti->final_amount ) && $iti->iti_status == 9 ? "strikeLine" : "";
					$f_cost =  !empty( $iti->final_amount )  && $iti->iti_status == 9  && get_iti_booking_status($iti->iti_id) == 0  ? "<strong class='green'> " . number_format($iti->final_amount) . " /-</strong> " : "";
					
					if( !empty( $hotel_meta ) ){
						$count_hotel = count( $hotel_meta ); ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-default">
                                <tr class="thead-inverse">
                                    <th> Hotel Category</th>
                                    <th> Deluxe</th>
                                    <th> Super Deluxe</th>
                                    <th> Luxury</th>
                                    <th> Super Luxury</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
									/* print_r( $hotel_meta ); */
									if( $count_hotel > 0 ){
										for ( $i = 0; $i < $count_hotel; $i++ ) {
											echo "<tr><td><strong>" .$hotel_meta[$i]["hotel_location"] . "</strong></td><td>";
												$hotel_standard =  $hotel_meta[$i]["hotel_standard"];
												echo $hotel_standard;
											echo "</td><td>";
												$hotel_deluxe =  $hotel_meta[$i]["hotel_deluxe"];
												echo $hotel_deluxe;
											echo "</td><td>";
												$hotel_super_deluxe =  $hotel_meta[$i]["hotel_super_deluxe"];
												echo $hotel_super_deluxe;
											echo "</td><td>";
												$hotel_luxury =  $hotel_meta[$i]["hotel_luxury"];
												echo $hotel_luxury;
											echo "</td></tr>";
										} 	
										//Rate meta
										$rate_meta 	  = unserialize($iti->rates_meta);
										$strike_class = !empty( $discountPriceData ) ? "strikeLine" : " ";
										//print_r( $rate_meta );
										$iti_close_status = $iti->iti_close_status;
										//print_r( $rate_meta );
										if( empty($iti_close_status) ){
										if( !empty( $rate_meta ) ){
											if( $iti->pending_price == 4 ){
												echo "<tr><td  colspan=5 class='red'>Awaiting price verfication from super manager.</td></tr>"; 
											}else{
												$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
												//$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
												$inc_gst = "";
												//get percentage added by agent
												$agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
												$agent_sp = $agent_dp = $agent_sdp = $agent_lp = "";
												//if percentage exists
												if( $agent_price_percentage ){
													$as_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? " Rs." . $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
													$ad_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? " Rs." . $per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
													$asd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? " Rs." . $per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
													$al_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? " Rs." . $per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100  . " Per/Person" : "";

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
												
												//get per person price
												$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["standard_rates"]) . "/- Per Person" : "";
												
												$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"]) . "/- Per Person" : "";
												
												$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"]) . "/- Per Person" : "";
												
												$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"]) . "/- Per Person" : "";
												
												//child rates
												$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . $per_person_ratemeta["child_standard_rates"] . "/- Per Child" : "";
												$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_deluxe_rates"] . "/- Per Child" : "";
												
												$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . $per_person_ratemeta["child_super_deluxe_rates"] . "/- Per Child" : "";
												
												$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . $per_person_ratemeta["child_luxury_rates"] . "/- Per Child" : "";
												
											
												$standard_rates = !empty( $rate_meta["standard_rates"]) ? "RS. " . number_format($rate_meta["standard_rates"]) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
												
												$deluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? "RS. " . number_format($rate_meta["deluxe_rates"]) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
												
												$super_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? "RS. " . number_format($rate_meta["super_deluxe_rates"]) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
												
												$rate_luxry = !empty( $rate_meta["luxury_rates"]) ? "RS. " . number_format($rate_meta["luxury_rates"]) . "/- {$inc_gst}" : "<strong class='red'>On Request</strong>";
												
												echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td>
														<td>		
															<strong> BP( " . $standard_rates . "</strong>  {$s_pp} {$child_s_pp} )
															{$agent_sp}
														</td>
														<td>
															<strong>BP( " . $deluxe_rates . "</strong>  {$d_pp} {$child_d_pp} )
															{$agent_dp}
														</td>
														<td>
															<strong>BP( " . $super_deluxe_rates . "</strong>  {$sd_pp}{$child_sd_pp} )
															{$agent_sdp}
														</td>
														<td>
															<strong>BP(  " . $rate_luxry . "</strong>  {$l_pp}{$child_l_pp} )
															{$agent_lp}
														</td></tr>";
														
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
										//discount data
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
													$ad_s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage/100 ) . "/- {$inc_gst}  {$ad_s_pp}  {$ad_child_s_pp}" : "<strong class='red'>On Request</strong>";
													
													$ad_d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst}  {$ad_d_pp}  {$ad_child_d_pp}" : "<strong class='red'>On Request</strong>";
													
													$ad_sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst}  {$ad_sd_pp}  {$ad_child_sd_pp}"  : "<strong class='red'>On Request</strong>";
													
													$ad_l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage/100) . "/- {$inc_gst}  {$ad_l_pp}  {$ad_child_l_pp}"  : "<strong class='red'>On Request</strong>";
													
													$agent_sp = "<strong class='aprice'> AP( " . $ad_s_price . "</strong>)";
													$agent_dp = "<strong class='aprice'>  AP( " . $ad_d_price . "</strong>)";
													$agent_sdp = "<strong class='aprice'> AP( " . $ad_sd_price . "</strong>)";
													$agent_lp = "<strong class='aprice'>  AP( " . $ad_l_price . "</strong>)";
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
												
												$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates) . "/- {$inc_gst}  {$s_pp}  {$child_s_pp}" : "<strong class='red'>N/A</strong>";
												
												$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates) . "/- {$inc_gst} {$d_pp}  {$child_d_pp}" : "<strong class='red'>N/A</strong>";
												
												$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates) . "/- {$inc_gst} {$sd_pp} {$child_sd_pp}"  : "<strong class='red'>N/A</strong>";
												
												$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates) . "/- {$inc_gst} {$l_pp}  {$child_l_pp}"  : "<strong class='red'>N/A</strong>";
												
												$count_price = count( $discountPriceData );
												$strike_class = ($price !== end($discountPriceData) && $count_price > 1 ) ? "strikeLine" : "";
												
												echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td>
												<td>BP( <strong>" . $s_price . "</strong>) {$agent_sp} </td>";
												echo "<td>BP(<strong>" . $d_price . "</strong>) {$agent_dp} </td>";
												echo "<td>BP(<strong>" . $sd_price . "</strong>) {$agent_sdp} </td>";
												echo "<td>BP(<strong>" . $l_price . "</strong>) {$agent_lp} </td></tr>";
											}
										} 
										} 

										$rate_comment = isset( $iti->rate_comment ) && $iti->pending_price == 2 && $iti->discount_rate_request == 0 ? $iti->rate_comment : "";
										echo "<tr><td colspan=5><p class='red margin_zero'><strong>Note: </strong>{$rate_comment} </td></tr>";
										echo "<tr><td colspan=5><p class='red margin_zero'><strong>Final Package Cost: </strong>{$f_cost} </td></tr>";
									} ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>

                    <div class="tour_des bg_white outline_none">
                        <ul class="list-group">
                            <li class="col-md-4">
                                <div class=" list-group-item"><strong> Itinerary Id: </strong><span
                                        class="badge badge-success"> <?php echo $iti->iti_id; ?></p> </span></div>
                            </li>
                            <li class="col-md-4">
                                <div class=" list-group-item"><strong> Name:</strong> <span class="badge badge-success">
                                        <?php echo $customer_name; ?> </span></div>
                            </li>
                            <li class="col-md-4">
                                <div class=" list-group-item"><strong> Phone: </strong><span
                                        class="badge badge-success"> <?php echo $customer_contact; ?> </span></div>
                            </li>
                            <li class="col-md-4">
                                <div class=" list-group-item"><strong> Agent: </strong><span
                                        class="badge badge-success"> <?php echo get_user_name($iti->agent_id); ?>
                                    </span></div>
                            </li>
                            <li class="col-md-4">
                                <div class=" list-group-item"><strong> Prospect: </strong><span
                                        class="badge badge-success">
                                        <?php echo !empty($followUpData) ? $followUpData[0]->itiProspect : "" ; ?>
                                    </span></div>
                            </li>

                            <?php if(  $iti_status ==7 ){ ?>
                            <li class="col-md-4 list-group-item">
                                <div class=" list-group-item"><strong>Decline Reason: </strong>
                                    <?php echo $lead_note; ?></div>
                            </li>
                            <li class="col-md-4 list-group-item"><strong>Decline Comment: </strong>
                                <?php echo $iti->decline_comment; ?></li>
                            <?php } ?>

                            <?php if(  $iti_status == 9 ){ ?>
                            <li class="col-md-4">
                                <div class=" list-group-item"><strong>Final Amount: </strong> <span
                                        class="badge badge-success"><?php echo number_format($iti->final_amount) . " /-"; ?></span>
                                </div>
                            </li>
                            <li class="col-md-4">
                                <div class=" list-group-item"><strong>Package Category: </strong> <span
                                        class="badge badge-success"><?php echo $iti->approved_package_category; ?></span>
                                </div>
                            </li>
                            <li class="col-md-4">
                                <div class=" list-group-item"><strong>Comment: </strong> <span
                                        class="badge badge-success"><?php echo $lead_note; ?></span></div>
                            </li>
                            <?php } ?>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div> <!-- portlet body -->
            </div> <!-- portlet -->

            <hr>
            <!--Payment Detais section-->
            <?php if( isset( $paymentDetails  ) && !empty( $paymentDetails ) &&  $iti->iti_status == 9 ){ ?>
            <?php $payment = $paymentDetails[0]; ?>
            <div class="portlet box blue margin-top-40">
                <div class="portlet-title">
                    <div class="caption"><i class="far fa-money-bill-alt"></i> Advance Received Details</div>
                </div>
                <div class="portlet-body ">
                    <div class="tour_des">
                        <div class="col-md-3">
                            <p><strong>Total Cost: </strong> <?php echo number_format($payment->total_package_cost); ?>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Advance Received: </strong>
                                <?php echo number_format($payment->advance_recieved); ?></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Booking Date: </strong>
                                <?php echo !empty( $payment->booking_date ) ? display_month_name( $payment->booking_date ) : ""; ?>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Balance: </strong>
                                <?php echo number_format($payment->total_balance_amount) . " /-"; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!--End Payment Details section-->

            <!--Show cab booking if any-->
            <hr>
            <?php $add_cab_booking_link = base_url("vehiclesbooking/bookcab/{$iti->iti_id}"); ?>
            <div class="portlet box blue margin-top-40">
                <div class="portlet-title">
                    <div class="caption"><i class="fa fa-cab"></i>Cab Booking Details</div>
                    <?php if( !$cab_booking_status ){ ?>
                    <a href="<?php echo $add_cab_booking_link; ?>" class="btn btn-success pull-right"
                        title="Book Cab"><i class="fa fa-plus"></i> Book New Cab</a>
                    <?php } ?>
                </div>
            </div>

            <div class="table-responsive">
                <div class="table-responsive custom_card margin-bottom-40">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-default">
                            <tr>
                                <th>Sr.</th>
                                <th> Cab </th>
                                <th> Transporter Name </th>
                                <th> Routing </th>
                                <th> Sent Status </th>
                                <th> Status </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
									$continue_cab = TRUE;
									if( $cab_bookings ){	
									$cc = 1;
										foreach( $cab_bookings as $c_book ){
											//Get hotel booking status-->
											if( $c_book->booking_status == 9 ){
												$status = "<span class='green'>BOOKED</span>";
											}else if($c_book->booking_status == 8){
												$status = "<span class='red'>Declined</span>";
											}else if( $c_book->booking_status == 7 ){
												$status = "<strong class='red'><i class='fa fa-close' aria-hidden='true'></i> &nbsp;Canceled</strong>";
											}else{
												$continue_cab = false;
												$status = "<span class='blue'><i class='fa fa-refresh'></i> Processing</span>";
											}
											?>
                            <tr>
                                <td><?php echo $cc; ?>.</td>
                                <td><?php echo get_car_name($c_book->cab_id); ?></td>
                                <td><?php echo get_transporter_name($c_book->transporter_id); ?></td>
                                <td><?php echo $c_book->pic_location . " - " . $c_book->drop_location; ?></td>
                                <td><?php echo $c_book->email_count . " Time Sent"; ?></td>
                                <td><?php echo $status; ?></td>
                                <td><a title='View'
                                        href="<?php echo site_url("vehiclesbooking/viewbooking/{$c_book->id}"); ?>"
                                        class='btn_eye'><i class='fa fa-eye' aria-hidden='true'></i></a></td>
                            </tr>
                            <?php $cc++; ?>
                            <?php }
									}else{ ?>
                            <tr>
                                <td colspan="4">No Cab booking create against this itinerary.
                                    <a href="<?php echo $add_cab_booking_link; ?>" class="" title="Book cab">Click here
                                        to book</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <!--all vtf booking confirmation button -->
                    <?php if( $cab_booking_status ){
								echo "<p class='alert alert-success text-center green'><strong>All Cab Booking has been Confirmed.</strong></p>";
							}else{ 
							?>
                    <button type="submit" <?php echo empty($continue_cab) ? "disabled" : ""; ?>
                        data-iti_id="<?php echo $iti->iti_id; ?>" data-b_type="cab"
                        data-booking_type="cab_booking_status" class="btn green uppercase confirm_booking_btn"
                        title="All Volvo/Train/Flight Booking Done">Confirm All Cab Booking Done</button>
                    <div class='alert alert-danger margin-top-20'><strong>Note: </strong>If you confirm Cab booking you
                        can't able to
                        create new booking against this itinerary. You can't confirm booking if booking is on processing
                        stage.</div>
                    </p>
                    <?php } ?>

                </div>

                <!--End hotel booking if any-->
                <!--hr -->
                <!--Show Volvo/Train/Flight booking if any-->
                <?php $add_vft_booking_link = base_url("vehiclesbooking/addbookingdetails/{$iti->iti_id}?type=volvo"); ?>
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-plane"></i>Volvo/Train/Flight Booking Details</div>
                        <?php if( !$vtf_booking_status ){ ?>
                        <a href="<?php echo $add_vft_booking_link; ?>" class="btn btn-success pull-right"
                            title="Book Hotel"><i class="fa fa-plus"></i> Book New</a>
                        <?php } ?>
                    </div>
                    <div class="portlet-body ">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-default">
                                    <tr>
                                        <th> Sr. </th>
                                        <th> Type </th>
                                        <th> Iti Id </th>
                                        <th> Departure Date </th>
                                        <th> Status </th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
								$continue_vtf = TRUE;
								if( $vtf_bookings ){ 
									$cv = 1;
									foreach( $vtf_bookings as $vtf_book ){
										//Get hotel booking status-->
										if( $vtf_book->booking_status == 9 ){
											$status = "<span class='green'>BOOKED</span>";
										}else if($vtf_book->booking_status == 8){
											$status = "<span class='red'>Declined</span>";
										}else{
											$continue_vtf = false;
											$status = "<span class='blue'><i class='fa fa-refresh'></i> Processing</span>";
										}
										?>
                                    <tr>
                                        <td><?php echo $cv; ?></td>
                                        <td><?php echo $vtf_book->booking_type; ?></td>
                                        <td><?php echo $vtf_book->iti_id; ?></td>
                                        <td><?php echo $vtf_book->dep_date; ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td><a title='View'
                                                href="<?php echo site_url("vehiclesbooking/viewvehiclebooking/{$vtf_book->id}/{$vtf_book->iti_id}"); ?>"
                                                class='btn btn-success'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                        </td>
                                    </tr>
                                    <?php 
										$cv++;
									} ?>
                                    <?php }else{ ?>
                                    <tr>
                                        <td colspan="4">No Volvo/Train/Flight booking create against this itinerary.
                                            <?php if( !$vtf_booking_status ){ ?>
                                            <a href="<?php echo $add_vft_booking_link; ?>" class="badge badge-success"
                                                title="Book VTF">Click here to book</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!--all vtf booking confirmation button -->
                            <?php if( $vtf_booking_status ){
							echo "<p class='alert alert-success text-center green'><strong>All Volvo/Train/Flight Booking has been Confirmed.</strong></p>";
						}else{ ?>
                            <button <?php echo empty($continue_vtf) ? "disabled" : ""; ?> type="submit"
                                data-iti_id="<?php echo $iti->iti_id; ?>" data-b_type="vtf"
                                data-booking_type="vtf_booking_status" class="btn green uppercase confirm_booking_btn"
                                title="All Volvo/Train/Flight Booking Done">Confirm All VTF Booking Done</button>
                            <div class='alert alert-danger margin-top-20'><strong>Note: </strong>If you confirm vft
                                booking you can't
                                able to create new booking against this itinerary.You can't confirm booking if booking
                                is on processing stage. </div>
                            </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!--End Volvo/Train/Flight booking if any-->

                <!--Show hotel booking if any-->
                <?php $add_hotel_booking_link = base_url("hotelbooking/add/{$iti->iti_id}"); ?>
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-calendar"></i>Hotel Booking Details</div>
                        <?php if( !$hotel_booking_status ){ ?>
                        <a href="<?php echo $add_hotel_booking_link; ?>" class="btn btn-success pull-right"
                            title="Book Hotel"><i class="fa fa-plus"></i> Book New Hotel</a>
                        <?php } ?>
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
                                        <td><a title='View'
                                                href="<?php echo site_url("hotelbooking/view/{$h_book->id}/{$h_book->iti_id}"); ?>"
                                                class='btn_eye'><i class='fa fa-eye' aria-hidden='true'></i></a>
                                        </td>
                                    </tr>
                                    <?php 
										$ch++;
									} ?>
                                    <?php }else{ ?>
                                    <tr>

                                        <td colspan="5">No hotel booking create against this itinerary.
                                            <?php if( !$hotel_booking_status ){ ?>
                                            <a href="<?php echo $add_hotel_booking_link; ?>" class=""
                                                title="Book Hotel">Click here to book hotel</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <!--all Hotel booking confirmation button -->
                            <?php if( $hotel_booking_status ){
							echo "<p class='alert alert-success text-center green'><strong>All Hotel Booking has been Confirmed.</strong></p>";
						}else{ ?>
                            <button <?php echo empty($continue_hotel) ? "disabled" : ""; ?> type="submit"
                                data-iti_id="<?php echo $iti->iti_id; ?>" data-b_type="hotel"
                                data-booking_type="hotel_booking_status" class="btn green uppercase confirm_booking_btn"
                                title="All Hotel booking Done">Confirm All Hotel Booking Done</button>
                            <p style="font-size:12px; color: red;"><strong>Note: </strong>If you confirm hotel booking
                                you can't able to create new booking against this itinerary.You can't confirm booking if
                                booking is on processing stage.</p>
                            <?php } ?>

                        </div>
                    </div>
                </div>                            
                <!--End hotel booking if any-->
                <!--step line start-->
                
					<hr>
					<?php $pay_class 	=  $total_payment_recieved_percentage >= 50 ? "done" : "error"; 
						$hotel_class	 =  !empty( $hotel_booking_status ) ? "done" : "error";
						$vtf_class	 =  !empty($vtf_booking_status) ? "done" : "error"; 
						$cab_class	 =  !empty($cab_booking_status) ? "done" : "error"; ?>
                <div class="mt-element-step">
                    <div class="row step-line">
                        <div class="mt-step-desc">
                            <div class="font-dark bold uppercase text-center">
                                <h2>BOOKING STATUS</h2>
                            </div>
                            <div class="caption-desc font-grey-cascade"></div>
                            <br />
                        </div>

                        <div class="col-md-3 mt-step-col <?php echo $vtf_class; ?>"
                            title="Volvo/Train/Flight Booking Status. Green = done, Red = Pending"
                            data-toggle="tooltip">
                            <div class="mt-step-number bg-white">
                                <i class="fa fa-plane"></i>
                            </div>
                            <div class="mt-step-title uppercase font-grey-cascade">Fight/Train/volvo</div>
                        </div>

                        <div class="col-md-3 mt-step-col <?php echo $hotel_class; ?>"
                            title="Hotel Booking Status. Green = done, Red = Pending" data-toggle="tooltip">
                            <div class="mt-step-number bg-white">
                                <i class="fa fa-bed"></i>
                            </div>
                            <div class="mt-step-title uppercase font-grey-cascade">Hotel Booking</div>
                        </div>

                        <div class="col-md-3 mt-step-col <?php echo $cab_class; ?>"
                            title="Cab Booking Status. Green = done, Red = Pending" data-toggle="tooltip">
                            <div class="mt-step-number bg-white">
                                <i class="fa fa-bus"></i>
                            </div>
                            <div class="mt-step-title uppercase font-grey-cascade">Cab Booking</div>
                        </div>

                        <div class="col-md-3 mt-step-col <?php echo $pay_class; ?>"
                            title="Cab Booking Status. (Green >= 50 %, Red < 50%) Amount received"
                            data-toggle="tooltip">
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
						}else if( $hotel_booking_status && $vtf_booking_status && $cab_booking_status && $total_payment_recieved_percentage >= 40 ){ ?>
                    <div class="text-center confirm_voucher">
                        <button type="submit" data-iti_id="<?php echo $iti->iti_id; ?>"
                            class="btn green uppercase cnfrim_voucher" title="Confirm Voucher">Confirm Voucher</button>
                        <p style="font-size:12px; color: red;"><strong>Note: </strong>To confirm voucher make sure that
                            the payment is received greater than <strong>50%</strong>.</p>
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
                                            <textarea required class="form-control" rows="3"
                                                name="agent_comment"></textarea>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
                                            <input type="submit" class='btn btn-green' id="clone_current_iti"
                                                title='Confirm Voucher' value="Confirm Voucher" />
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
                 ?>
                <div class="clearfix"></div>
                <div class="custom_card">
                    <div class="inquery_section margin-bottom-25">
                        <a class="btn btn-success" target="_blank"
                            href="<?php echo site_url("itineraries/view/{$iti->iti_id}/{$iti->temp_key}"); ?>"
                            title="View Quotation"><i class='fa fa-eye' aria-hidden='true'></i> View Quotation</a>
                        <strong class="btn btn-danger"><?php echo $lead_status ?></strong>
                        <!--if amendment is done show old itinerary-->
                        <!--if amendment is done show old itinerary-->
                        <?php if( !empty( $old_itineraries ) && $iti->is_amendment != 0 ){  ?>
                        <p class="text-center">
                            <?php $old_count = 1;
								foreach( $old_itineraries as $old_iti ){ ?>
                            <a title='View Old Quotation' target="_blank"
                                href=" <?php echo site_url("itineraries/view_old_iti/{$old_iti->id}") ; ?> "
                                class='btn btn-danger'><i class='fa fa-eye' aria-hidden='true'></i> View Old Quotation
                                <?php echo $old_count; ?></a>
                            <?php $old_count++; } ?>
                        </p>
                        <?php } ?>
                        <?php /*if( $iti->is_amendment == 2 ){ ?>
                        <a title='View Old Quotation' target="_blank"
                            href=" <?php echo site_url("itineraries/view_old_iti/{$iti->iti_id}") ; ?> "
                            class='btn btn-danger'><i class='fa fa-eye' aria-hidden='true'></i> View Old Quotation</a>
                        <?php }*/ ?>

                    </div>
                    <!-- Call log section appears if itinerary sent to client And status is publish And not booked or declined -->
                    <?php if( !empty( $followUpData ) ){ ?>
                    <div class="panel-group accordion" id="accordion3">
                        <?php
							$count = 1;
							foreach( $followUpData as $callDetails ){ ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse"
                                        data-parent="#accordion3"
                                        href="#collapse_3_<?php echo $count;?>"><?php echo $callDetails->currentCallTime;?></a>
                                </h4>
                            </div>
                            <div id="collapse_3_<?php echo $count;?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div><strong>Itinerary Id:</strong> <?php echo $callDetails->iti_id;?></div>
                                    <div><strong><?php echo $callDetails->callType;?></strong></div>
                                    <div><strong>Call summary:</strong> <?php echo $callDetails->callSummary;?></div>
                                    <div><strong>Next Call Time:</strong> <?php echo $callDetails->nextCallDate;?></div>
                                    <div><strong><?php echo $callDetails->itiProspect;?></strong></div>
                                </div>
                            </div>
                        </div>
                        <?php $count++; ?>
                        <?php } ?>
                    </div>
                </div>

                <?php } ?>



                <?php }else{
				redirect("404");
			} ?>
            </div>
        </div>
    </div>
</div>
<div class="loader"></div>
<style>
.mt-element-step .step-line .mt-step-number>i {
    top: 78%;
}
</style>
<!-- Booking Payment Script -->
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('.confirm_booking_btn').on('click', function() {
        var _this_title = $(this).attr("title");
        if (confirm('Are you sure to ' + _this_title +
                ' ? If you confirm hotel booking you cant able to create new booking against this itinerary'
            )) {
            //Update status send ajax request
            console.log("done");
            var iti_id = $(this).attr("data-iti_id");
            var booking_type = $(this).attr("data-booking_type");
            var b_type = $(this).attr("data-b_type");
            //console.log( iti_id  + " " + booking_type );
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('itineraries/ajax_update_booking_status'); ?>",
                dataType: 'json',
                data: {
                    iti_id: iti_id,
                    type: booking_type,
                    b_type: b_type
                },
                beforeSend: function() {
                    LOADER.show();
                    console.log("sending...");
                },
                success: function(res) {
                    LOADER.hide();
                    alert(res.msg);
                    location.reload();
                },
                error: function(e) {
                    LOADER.hide();
                    alert("Error: Please reload the page and try again.");
                    location.reload();
                    console.log(e);
                    //response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
                }
            });
        }
    });

    //Confirm voucher click
    $(document).on("click", ".cnfrim_voucher", function(e) {
        e.preventDefault();
        $("#confirmVoucherModal").show();
    });

    $(document).on("click", ".close", function(e) {
        $("#confirmVoucherModal").hide();
    });

    //update status voucher
    $("#frm_confirm_voucher").validate({
        submitHandler: function() {
            var formData = $("#frm_confirm_voucher").serializeArray();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('itineraries/ajax_confirm_voucher_status'); ?>",
                dataType: 'json',
                data: formData,
                beforeSend: function() {
                    $(".cnf_res").html("updating.....");
                    console.log("sending...");
                },
                success: function(res) {
                    $(".cnf_res").html("");
                    alert(res.msg);
                    location.reload();
                },
                error: function(e) {
                    $(".cnf_res").html("");
                    alert("Error: Please reload the page and try again.");
                    console.log(e);
                    //response.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
                }
            });
        }
    });

    $('[data-toggle="tooltip"]').tooltip({
        placement: 'top'
    });
});
</script>