<div class="page-container itinerary-view customer_content">
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php if( !empty($itinerary[0] ) ){ 			
				$iti = $itinerary[0];
				$terms = get_terms_condition();
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
				
				$customer_name 		= !empty($get_customer_info) ? $cust->customer_name  : "";;
				$customer_contact 	= !empty($get_customer_info) ? $cust->customer_contact : "";
				$customer_email		= !empty($get_customer_info) ? $cust->customer_email : "";
				$is_gst_final = "";
				?>
				
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Customer Name: <?php echo $customer_name; ?>
						{ Package Type: <strong class="red"> <?php echo check_iti_type( $iti->iti_id ); ?></strong> }
						</div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("itineraries"); ?>" title="Back">Back</a>
					</div>
				</div>
				<div class="row2">
					<div class="well well-sm text-center">
						<p class="red">OLD PACKAGE COST: <strong><?php echo $iti->old_package_cost; ?></strong></p>
						<?php if( !empty( $iti->new_package_cost ) )
							//$is_gst_final = $iti->is_gst == 1 ? " (GST Inc. )" : " (GST Extra)";						
							$is_gst_final = "";						
							echo "<p class='green'>New PACKAGE COST: <strong>{$iti->new_package_cost} {$is_gst_final}</strong></p>";
						?>
						<p class="green">PACKAGE CATEGORY: <strong><?php echo $iti->approved_package_category; ?></strong></p>
					</div>
					<!--Amendment price request-->
					<?php
					
					if( $iti->sent_for_review == 1 && is_admin_or_manager() ){ ?>
						<?php
							//calculate the base price of iti
							$agent_margin = agent_margin_on_final_cost( $iti->iti_id );
							//$old_final_cost_with_ap = $iti->old_package_cost;
							//$old_base_price = $iti->old_package_cost - $iti->old_package_cost * $agent_margin / 100;
							
							$reverse_margin = $agent_margin / 100;
							$reverse_margin	 = $reverse_margin + 1 ;
							$old_base_price = round($iti->old_package_cost / $reverse_margin );
						
						?>
						<div class="row" id="update_rates_section">
							<form id="submitRates">
								<div class='form-group col-md-12 text-center' >
									<p><strong style="font-size: 22px;">Please Review Itinerary And Update Package Cost: </strong></p>
									<p><strong>Agent Comment: </strong> <?php echo $iti->review_comment; ?></p>
								</div>
								<div class='form-group col-md-4' >
									<label><strong>Old Base Price:</strong></label>
									<input type="text" readonly class='form-control' value="<?php echo $old_base_price; ?>">
								</div>
								<div class='form-group col-md-4' >
									<label><strong>Old Package Cost </strong><strong class='red'> ( Agent Margin: <?php echo $agent_margin; ?> %):</strong></label>
									<input type="text" readonly class='form-control' value="<?php echo $iti->old_package_cost; ?>">
								</div>
								<div class="clearfix"></div>
								
								<div class='form-group col-md-4' >
									<label><strong>New Package Base Price*:</strong></label>
									<input required name="new_package_bp" id="new_package_bp" type="number" data-agent_margin="<?php echo $agent_margin; ?>" class='form-control'></input>
								</div>
								
								<div class='form-group col-md-4' >
									<label><strong>New Package Cost*:<strong class='red'> (BP + AM) </strong> </strong></label>
									<input required readonly name="new_package_cost" id="new_package_cost" type="number" class='form-control'></input>
								</div>
								
								<!--div class='form-group col-md-3' >
									<label><strong>GST Inc.:</strong><span style="color: red; font-size: 12px;">Note: Check if GST included.</span></label>
								</div-->
								<input type="hidden" value="1" name="is_gst" class='form-control' id="incgst"></input>
								
								
								<div class='form-group col-md-2' >
									<input type="hidden" value="<?php echo $iti->iti_id; ?>" name="iti_id">
									<input type="hidden" value="<?php echo $iti->id; ?>" name="id">
									<input type="hidden" value="<?php echo $iti->agent_id; ?>" name="agent_id">
									<input type="submit" class="btn green button-submit" value="Update">
								</div>
								<div class="clearfix"></div>
								<div id="response_div"></div>
							</form>	
						</div> <!-- row -->
				<?php }	?>
				<!--price update request-->
				<!--view and edit button-->
					<div class="text-center btns_section">
						<p>Amendment of Iti Id: <strong><?php echo $iti->iti_id; ?></p>
						<?php if( is_admin() ){ ?>
							<a title='Edit' href=" <?php echo site_url("itineraries/edit_amendment_iti/{$iti->id}/{$iti->temp_key}") ; ?> " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a>
						<?php }else if( empty($iti->sent_for_review) || $iti->sent_for_review == 1 ){  ?>
							<a title='Edit' href=" <?php echo site_url("itineraries/edit_amendment_iti/{$iti->id}/{$iti->temp_key}") ; ?> " class='btn btn-success' ><i class='fa fa-pencil' aria-hidden='true'></i> Edit</a>
						<?php } ?>
						

						<?php if( !empty( $old_itineraries ) ){ 
							$old_count = 1;
							foreach( $old_itineraries as $old_iti ){ ?>
								<a title='View Old Quotation' target="_blank" href=" <?php echo site_url("itineraries/view_old_iti/{$old_iti->id}") ; ?> " class='btn btn-danger' ><i class='fa fa-eye' aria-hidden='true'></i> View Old Quotation <?php echo $old_count; ?></a>
							<?php $old_count++; } 
						} ?>
						
					</div>
					<!--End view and edit button-->
					<div class="well well-sm"><h3>Package Overview</h3></div>
					<div class="table-responsive">
						<table class="table table-bordered ">
							<tbody>
								<tr class="thead-inverse" >
									<td width="33%"><strong>Name of Package</strong></td>
									<td width="33%"><strong>Routing</strong></td>
									<td width="33%"><strong>Duration</strong></td>
								</tr>
								<tr>
									<td><?php echo $iti->package_name; ?></td>
									<td><?php echo $iti->package_routing; ?></td>
									<td><?php echo $iti->duration; ?></td>
								</tr>
								
								<tr class="thead-inverse">
									<td><strong>No of Travellers</strong></td>
									<td><strong>Cab</strong></td>
									<td><strong>Agent</strong></td>
								</tr>
								<tr>
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
									<td><?php echo get_car_name($iti->cab_category); ?></td>
									<td><?php echo get_user_name($iti->agent_id); ?></td>
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
									<td><strong>Amendment Created</strong></td>
									<td></td>
								</tr>
								<tr>
									<td><strong><?php echo $without_extra_bed; ?></strong></td>
									<td><?php echo date("d F,Y", strtotime($iti->created)); ?></td>
									<td></td>
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
					<div class="well well-sm"><h3>Day Wise Itinerary</h3></div>
					<div class="table-responsive2">
						<table class="table table-bordered">
							<tbody>
								<?php //$day_wise = $iti->daywise_meta; 
								$tourData = unserialize($iti->daywise_meta);
								$count_day = count( $tourData );
								if( $count_day > 0 ){
									//print_r( $tourData );
									for ( $i = 0; $i < $count_day; $i++ ) {
									echo "<tr><td width='10%'>";
										$day = $i+1;
										echo "<span class=''><strong>Day: ".$tourData[$i]['tour_day']."</strong> </span>";
										echo "</td><td width='80%'>";
										echo "<!--<div class='some-space'></div>--><strong>" . $tourData[$i]['tour_name'] . "</strong><br>"; 
										echo "<strong>Tour Date:</strong><em> " .display_date_month($tourData[$i]['tour_date']) . "</em><br>"; 
										echo "<strong>Meal Plan:</strong><em> " .$tourData[$i]['meal_plan'] . "</em><br>"; 
										echo "<strong>Tour Description:</strong><em> " .$tourData[$i]['tour_des'] . "</em><br>"; 
										echo "<strong>Distance:</strong><em> " .$tourData[$i]['tour_distance'] . " KMS</em><br>";
										//hot destination
										if( isset($tourData[$i]['hot_des'] ) && !empty( $tourData[$i]['hot_des'] ) ){
											$hot_dest = '';
											$htd = explode(",", $tourData[$i]['hot_des']);
											foreach($htd as $t) {
												$t = trim($t);
												$hot_dest .= "<span>" . $t . "</span>";
											}
											echo '<div class="hot_des_view "><strong>Attraction: </strong>' . $hot_dest . '</div>';
										}	
										echo "</td>";
									echo "</tr>";
									}
								}	?>
							</tbody>
						</table>
					</div>	
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
								if( $count_inc > 0 ){
									for ( $i = 0; $i < $count_inc; $i++ ) {
										echo "<li>" . $inclusion[$i]["tour_inc"] . "</li>";
									}	
								}
								echo "</ul></td><td><ul>";
								if( $count_exc > 0 ){
									for ( $i = 0; $i < $count_exc; $i++ ) {
										echo "<li>" . $exclusion[$i]["tour_exc"] . "</li>";
									}	
								}
								echo "</ul></td></tr>";
								?>
							</tbody>
						</table>
					</div>	
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
					<hr>					
					<div class="well well-sm"><h3>Hotel Details</h3></div>
					<?php $hotel_meta = unserialize($iti->hotel_meta); 
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
									} ?>
								</tbody>
							</table>
						</div>
					<?php } ?>	
	<hr>					
					<div class="well well-sm"><h3>Notes:</h3></div>
					<ul>
					<?php $hotel_note_meta = unserialize($iti->hotel_note_meta); 
					$count_hotel_meta = count( $hotel_note_meta );
					
					if( $count_hotel_meta > 0 ){
						for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
							echo "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
						}	
					} ?>
					</ul>
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
					<!--Request manager to add price to itinerary -->
					
					<div class="text-center">
					<?php if( $iti->sent_for_review == 0 ){ ?>
						<span class="btn btn-green reqPrice_update" title="Request For Update Price">Sent Request To Manager For Review</span>
						<!-- Modal Discount Price itinerary-->
						<!-- The Modal -->
						<div class="modal fade" id="update_priceModal" role="dialog">
							<div class="modal-dialog modal-lg2">
							  <div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Request for amendment in  price for admin/manager</h4>
								</div>
								<div class="modal-body">
									<form id="reqPriceForm">
										<div class="form-group">
										<div class="checkbox">
											<label for="">Please Enter Comment For Admin/Manager</label><br>
											<textarea required name="review_comment" class="form-control" rows="3"></textarea>
										</div>
										</div>
										<input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
										<input type="hidden" name="id" value="<?php echo $iti->id; ?>">
										<button type="submit" id="reqDis_btn" class="btn btn-default">Sent</button>
										<div id="priceRes"></div>
									</form>
								</div>
								<div class="modal-footer">
								  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							  </div>
							</div>
						</div>	
					<?php }else if( $iti->sent_for_review == 1 ){
						echo '<p class="text-center btn btn-success"> Request Already sent to manager!</p>';
					}else if( $iti->sent_for_review == 2 ){ ?>
						<!--If manager reviewed amendment and update price-->
						<p class="text-center btn btn-success"> New Price Updated By Admin/Manager!</p>
						<hr>
						
						<div id="update_payment_details">
						<h3 class='text-center'>UPDATE PAYMENT DETAILS</h3>
						<?php if( isset( $payment_details ) ){
							$payment = $payment_details[0];
							$travel_date = $payment->travel_date;
							//define variables
							$in_number = $ins_number = $pay_date =$error="";
							$amendment_amount = $in_amount = $in_amount = $new_ins_amount = $refund_amount= $new_balance_amount=0;
							
							$new_package_cost = !empty($iti->new_package_cost) ? $iti->new_package_cost : 0;
							$old_package_cost = !empty($payment->total_package_cost) ? $payment->total_package_cost : 0;
							$balance_pending  = !empty( $payment->total_balance_amount ) ? $payment->total_balance_amount : 0;
							$total_recieved   = $old_package_cost - $balance_pending;
							//$is_gst_final 		= $iti->is_gst == 1 ? " (GST Inc. )" : " (GST Extra)";		
							$is_gst_final 		= "";		
							echo "<br>New Price: " . $new_package_cost . $is_gst_final . "<br>";
							echo "Old Price: " . $old_package_cost . "<br>";
							echo "Total Received: " . $total_recieved. "<br>";
							echo "Total Balance Pending: " . $balance_pending . "<br>";
							
							//if old price is less than new price
							if( $new_package_cost >=  $old_package_cost ){
								//Get total amount added
								$amendment_amount = $new_package_cost - $old_package_cost;
								$new_balance_amount = $balance_pending + $amendment_amount;
								
								if( $balance_pending > 0 ){
									//Check Paid/Unpaid Payment status
									$second_ins_unpaid = !empty( $payment->second_payment_bal ) &&  ( $payment->second_pay_status == "unpaid" ) ? TRUE : FALSE;
									$third_ins_unpaid = !empty( $payment->third_payment_bal ) && ($payment->third_pay_status == "unpaid") ? TRUE : FALSE;
									$final_ins_unpaid = !empty( $payment->final_payment_bal ) && ($payment->final_pay_status == "unpaid") ? TRUE : FALSE;		
									
									//Check for next unpaid installment
									if( $second_ins_unpaid ){
										$in_number 	= "Second Installment";
										$ins_number = 1;
										$in_amount 	= $payment->second_payment_bal;
										$pay_date 	= $payment->second_payment_date;
									}else if( $third_ins_unpaid ){
										$in_number 	= "Third Installment";
										$ins_number = 2;
										$in_amount 	= $payment->third_payment_bal;
										$pay_date 	= $payment->third_payment_date;
									}elseif( $final_ins_unpaid ){
										$in_number 	= "Final Installment";
										$ins_number = 3;
										$in_amount 	= $payment->final_payment_bal;
										$pay_date 	= $payment->final_payment_date;
									}else{
										$error = "You can't update payment status because you already update all installments.Please contact your administrator";
									} 
									//New installment Amount
									$new_ins_amount = $in_amount + $amendment_amount;
								}else{
									//Check Paid/Unpaid Payment status
									$second_ins_unpaid = empty( $payment->second_payment_bal ) ? TRUE : FALSE;
									$third_ins_unpaid =	 empty( $payment->third_payment_bal ) ? TRUE : FALSE;
									$final_ins_unpaid =  empty( $payment->final_payment_bal ) ? TRUE : FALSE;		
									
									//Check for next unpaid installment
									if( $second_ins_unpaid ){
										$in_number 	= "Second Installment";
										$ins_number = 1;
										$pay_date 	= $payment->second_payment_date;
									}else if( $third_ins_unpaid ){
										$in_number 	= "Third Installment";
										$ins_number = 2;
										$pay_date 	= $payment->third_payment_date;
									}elseif( $final_ins_unpaid ){
										$in_number 	= "Final Installment";
										$ins_number = 3;
										$pay_date 	= $payment->final_payment_date;
									}else{
										$error = "You can't update payment status because you already update all installments.Please contact your administrator";
									}
									
									//New installment Amount
									$new_ins_amount = $in_amount + $amendment_amount;
								}	
								?>
								<?php if ( $error ){
									echo $error;
								}else{ ?>
									<?php $date_piker_class = empty( $in_amount ) ? "date_picker_ins" : "";  ?>
									<form id="amendment_payment">	
										<div id="due_payment_section">
											<div class="col-md-12 red">
												<span>Before Amendment Installment Amount : </span> <?php echo $in_amount; ?><br>
												Amendment Amount : <?php echo  $amendment_amount; ?><br>
												After Amendment Installment Amount : <?php echo $in_amount . ' + ' . $amendment_amount . ' = ' . $new_ins_amount; ?>
											</div>
											
											<div class="form-group col-md-3">
												<label class=""><strong>Amendment In <?php echo $in_number; ?> Amount:</strong></label>
												<input type="number" readonly="readonly"  name="amendment_payment_bal" placeholder="Final Installment Amount" class="form-control" value="<?php echo $new_ins_amount; ?>">
											</div>
											
											
											<div class="form-group col-md-3">
												<label class=""><strong>Installment Due Date:</strong></label>
												<input readonly="readonly" required name='installment_date' class="input-group form-control <?php echo $date_piker_class; ?>" type="text" value="<?php echo $pay_date; ?>" />
											</div>
											
											<div class="form-group col-md-3">
												<label class=""><strong>Travel Date*:</strong></label>
												<input readonly="readonly" required name='travel_date' class="input-group form-control date_picker_ins" type="text" value="<?php echo $travel_date; ?>" />
											</div>
											
											<div class="form-group col-md-3">
												<label class=""><strong>Amendment Note*:</strong></label>
												<textarea required class="input-group form-control" name="amendment_note"></textarea>
											</div>
											<input type="hidden" name="iti_id" id="iti_id" value="<?php echo $payment->iti_id; ?>">
											<input type="hidden" name="customer_id" value="<?php echo $payment->customer_id; ?>">
											<input type="hidden" name="id" value="<?php echo $payment->id; ?>">
											<input type="hidden" id="temp_key" value="<?php echo get_iti_temp_key($payment->iti_id); ?>">
											<input type="hidden" name="ins_number" value="<?php echo $ins_number; ?>">
											<input type="hidden" name="total_balance_amount" value="<?php echo $new_balance_amount; ?>">
											<input type="hidden" name="total_package_cost" value="<?php echo $new_package_cost; ?>">
											<input type="hidden" name="amendment_id" value="<?php echo $iti->id; ?>">
											<input type="hidden" name="is_gst" value="<?php echo $iti->is_gst; ?>">
											<div class="clearfix"></div>
											<hr>
											<div class="margiv-top-10">
												<button type="submit" class="btn green uppercase submit_frm" id="submit_frm">Update Details</button>
											</div>
											<div class="clearfix"></div>
											<div class="ajax_resPonse"></div>
										</div>
									</form>
								<?php } ?>	
							<!--if package new package cost is less than old package cost-->	
							<?php }else{
								
								$clear_all_unpaid = false;
								//Get total amount Reduced
								$reduce_amount = $old_package_cost - $new_package_cost;
								echo "<h1 class='red'>Reduced Amount: " . $reduce_amount . "</h1></br>";
								
								if( $balance_pending > 0 ){
									//Check Paid/Unpaid Payment status
									$second_ins_unpaid = !empty( $payment->second_payment_bal ) && ( $payment->second_pay_status == "unpaid" ) ? $payment->second_payment_bal : 0;
									$third_ins_unpaid = !empty( $payment->third_payment_bal ) && ($payment->third_pay_status == "unpaid") ? $payment->third_payment_bal : 0;
									$final_ins_unpaid = !empty( $payment->final_payment_bal ) && ($payment->final_pay_status == "unpaid") ? $payment->final_payment_bal : 0;	
									
									//reduce amount is greater than balance than make adjustment
									if( $reduce_amount >  $balance_pending ){
										//calculate Refund amount
										$refund_amount = $reduce_amount - $balance_pending;
										$clear_all_unpaid = TRUE;
										
										//Check for next unpaid installment
										/* if( $second_ins_unpaid ){
											$in_number 	= "Second Installment";
											$ins_number = 1;
											$in_amount 	= $payment->second_payment_bal;
											$pay_date 	= $payment->second_payment_date;
										}else if( $third_ins_unpaid ){
											$in_number 	= "Third Installment";
											$ins_number = 2;
											$in_amount 	= $payment->third_payment_bal;
											$pay_date 	= $payment->third_payment_date;
										}elseif( $final_ins_unpaid ){
											$in_number 	= "Final Installment";
											$ins_number = 3;
											$in_amount 	= $payment->final_payment_bal;
											$pay_date 	= $payment->final_payment_date;
										}else{
											$error = "You can't update payment status because you already update all installments.Please contact your administrator";
										} */ 
										
										//Check for next unpaid installment
										echo "<br/>";
										echo "Clear All Unpaid Payments And Refund: " . $refund_amount;
										
									}else if( $reduce_amount <  $balance_pending ){
										echo "Need Reduce Amount From Next Installments: " . $reduce_amount . "<br>";
										$new_balance_amount = $balance_pending - $reduce_amount;
										
										//Check for next unpaid installment
										if( $second_ins_unpaid ){
											$in_number 	= "Second Installment";
											$ins_number = 1;
											$in_amount 	= $payment->second_payment_bal;
											$pay_date 	= $payment->second_payment_date;
										}else if( $third_ins_unpaid ){
											$in_number 	= "Third Installment";
											$ins_number = 2;
											$in_amount 	= $payment->third_payment_bal;
											$pay_date 	= $payment->third_payment_date;
										}elseif( $final_ins_unpaid ){
											$in_number 	= "Final Installment";
											$ins_number = 3;
											$in_amount 	= $payment->final_payment_bal;
											$pay_date 	= $payment->final_payment_date;
										}else{
											$error = "You can't update payment status because you already update all installments.Please contact your administrator";
										}
										
										//Check for next unpaid installment
										echo "<br/>";
										echo "$in_number is: " . $new_balance_amount . "<br> Installment Date : " . $pay_date;
									}else{
										$clear_all_unpaid = TRUE;
										echo "You Need to clear next installments";
									}
								}else{
									$refund_amount = $old_package_cost - $new_package_cost;
									echo "You Need to refund : " . $refund_amount;
								}
								?>
								<!--Payment Update form Form-->
								<?php if ( $error ){
									echo $error;
								}else{ ?>
									<?php $date_piker_class = empty( $in_amount ) ? "date_picker_ins" : "";  ?>
									<form id="frm_refund_reduce_payment">	
										<div id="due_payment_section">
											<div class="col-md-12 red">
												<span>Before Amendment Pending Amount : </span> <?php echo $balance_pending; ?><br>
												New Pending Amount : <?php echo  $new_balance_amount; ?><br>
												Refund Amount : <?php echo $refund_amount; ?>
											</div>
											
											<?php if( $new_balance_amount ){ ?>
												<div class="form-group col-md-3">
													<label class=""><strong>Next Payment Amount:</strong></label>
													<input type="number" readonly="readonly"  name="amendment_payment_bal" placeholder="Final Installment Amount" class="form-control" value="<?php echo $new_balance_amount; ?>">
												</div>
												<div class="form-group col-md-3">
													<label class=""><strong>Installment Due Date:</strong></label>
													<input readonly="readonly" required name='installment_date' class="input-group form-control <?php echo $date_piker_class; ?>" type="text" value="<?php echo $pay_date; ?>" />
												</div>
											<?php } ?>	
											<!--If Refund amount is not empty -->
											<?php if( $refund_amount ){ ?>
												<div class="clearfix"></div>
												<div class="form-group col-md-3">
													<label class=""><strong>Refund Amount:</strong></label>
													<input type="number" readonly="readonly"  placeholder="Total Refund Amount" class="form-control" value="<?php echo $refund_amount; ?>">
												</div>
												<div class="form-group col-md-3">
													<label class=""><strong>Refund Date*:</strong></label>
													<input readonly="readonly" required name='refund_due_date' class="input-group form-control date_picker_ins" type="text" value="" />
												</div>
											<?php } ?>
											
											<div class="form-group col-md-3">
												<label class=""><strong>Travel Date*:</strong></label>
												<input readonly="readonly" required name='travel_date' class="input-group form-control date_picker_ins" type="text" value="<?php echo $travel_date; ?>"" />
											</div>
											
											<!--End Refund amount is not empty -->
											<div class="form-group col-md-3">
												<label class=""><strong>Amendment Note*:</strong></label>
												<textarea required class="input-group form-control" name="amendment_note"></textarea>
											</div>
											
											<input type="hidden" name="iti_id" id="iti_id" value="<?php echo $payment->iti_id; ?>">
											<input type="hidden" name="customer_id" value="<?php echo $payment->customer_id; ?>">
											<input type="hidden" name="id" value="<?php echo $payment->id; ?>">
											<input type="hidden" id="temp_key" value="<?php echo get_iti_temp_key($payment->iti_id); ?>">
											<input type="hidden" name="ins_number" value="<?php echo $ins_number; ?>">
											<input type="hidden" name="total_balance_amount" value="<?php echo $new_balance_amount; ?>">
											<input type="hidden" name="total_package_cost" value="<?php echo $new_package_cost; ?>">
											<input type="hidden" name="clear_unpaid" value="<?php echo $clear_all_unpaid; ?>">
											<input type="hidden" name="refund_amount" value="<?php echo $refund_amount; ?>">
											<input type="hidden" name="amendment_id" value="<?php echo $iti->id; ?>">
											<input type="hidden" name="is_gst" value="<?php echo $iti->is_gst; ?>">
											<div class="clearfix"></div>
											<hr>
											<div class="margiv-top-10">
												<button type="submit" class="btn green uppercase submit_frm" id="submit_frm">Update Details</button>
											</div>
											<div class="clearfix"></div>
											<div class="ajax_resPonse"></div>
										</div>
									</form>
								<?php } ?>	
								<!--End Payment Update form Form-->
								
							<?php }	?>
						<?php } ?>
					<?php }else{
						echo '<p class="text-center btn btn-success"> New Price Updated!</p>';
					} ?>	
				</div>
			</div>
		<!--End Request manager to add price to itinerary -->
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!--Reduce Price/Refund-->
<script type="text/javascript">
jQuery( document ).ready(function($){
	var ITI_ID = $("#iti_id").val();
	var TEMP_KEY = $("#temp_key").val();
	$(".date_picker_ins").datepicker({"format": "yyyy-mm-dd", "startDate": "1d"});
	//VALIDATE AND SUBMIT POSTPONE_DATES FORM
	$("#frm_refund_reduce_payment").validate({
		submitHandler: function(form, event) {
			event.preventDefault();
			if (confirm("Are you sure to Update Payments?")){
				update_payments();
			}	
			
			//update payment
			function update_payments() {
				var ajaxReq;
				var resp = $(".ajax_resPonse");
				$("#submit_pfrm").attr("disabled", "disabled");
				var formData = $("#frm_refund_reduce_payment").serializeArray();
				//console.log(formData);
			
				//Abort ajax request
				if (ajaxReq) {
					ajaxReq.abort();
				}			
			
				ajaxReq = $.ajax({
					type: "POST",
					url: "<?php echo base_url('payments/ajax_reduce_payment_installements'); ?>" ,
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
					},
					success: function(res) {
						//$("#form_postpone_dates")[0].reset();
						if (res.status == true){
							resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							console.log("done");
							alert( res.msg );
							window.location.href = "<?php echo site_url('itineraries/view/'); ?>" + ITI_ID + "/" + TEMP_KEY ; 
							//location.reload(); 
						}else{
							resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							$("#submit_pfrm").removeAttr("disabled");
							console.log("error");
							//location.reload();
						}
					},
					error: function(e){
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>');
						console.log(e);
					}
				});
				return false;
			}
		} 
	});	
});
</script>
<!-- Amendment in price -->
<script type="text/javascript">
jQuery( document ).ready(function($){
	var ITI_ID = $("#iti_id").val();
	var TEMP_KEY = $("#temp_key").val();
	$(".date_picker_ins").datepicker({"format": "yyyy-mm-dd", "startDate": "1d"});
	//VALIDATE AND SUBMIT POSTPONE_DATES FORM
	$("#amendment_payment").validate({
		submitHandler: function(form, event) {
			event.preventDefault();
			if (confirm("Are you sure to Update Payments?")){
				update_payments();
			}	
			
			//update payment
			function update_payments() {
				var ajaxReq;
				var resp = $(".ajax_resPonse");
				$("#submit_pfrm").attr("disabled", "disabled");
				var formData = $("#amendment_payment").serializeArray();
				//console.log(formData);
			
				//Abort ajax request
				if (ajaxReq) {
					ajaxReq.abort();
				}			
			
				ajaxReq = $.ajax({
					type: "POST",
					url: "<?php echo base_url('payments/amendment_payment_details'); ?>" ,
					dataType: 'json',
					data: formData,
					beforeSend: function(){
						resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
					},
					success: function(res) {
						//$("#form_postpone_dates")[0].reset();
						if (res.status == true){
							resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							console.log("done");
							alert( res.msg );
							window.location.href = "<?php echo site_url('itineraries/view/'); ?>" + ITI_ID + "/" + TEMP_KEY ; 
							//location.reload(); 
						}else{
							resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							$("#submit_pfrm").removeAttr("disabled");
							console.log("error");
							//location.reload();
						}
					},
					error: function(e){
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>Try again later.</div>');
						console.log(e);
					}
				});
				return false;
			}
		} 
	});	
});
</script>
<script>
jQuery( document ).ready(function($){
	//open price modal reqPriceForm
	$(".reqPrice_update").click(function(){
		$("#update_priceModal").modal('show');
	});
	
	//add new package cost
	$(document).on("blur", "#new_package_bp", function(){
		$("#new_package_cost").val("");
		var _this = $(this);
		var agent_margin = parseInt( $(this).attr("data-agent_margin") );
		var _this_val = parseFloat($(this).val());
		//if not valid input
		if( _this_val == '' || !$.isNumeric(_this_val) || _this_val < 0 ){
			$("#priceRes").html('<div class="alert alert-danger"><strong>Error! </strong>Please enter positive value</div>');
			_this.val("");
			$("#new_package_cost").val("");
			return false;
		}else{
			var agent_m = _this_val * agent_margin / 100;
			var new_package_cost  = ( _this_val + parseFloat(agent_m) ).toFixed(0);
			$("#new_package_cost").val( new_package_cost );
			$("#priceRes").html('');
		}
	});
	
	/*Amendment price request to manager*/
	$("#reqPriceForm").validate({
		submitHandler: function(form) {
		var formData = $('#reqPriceForm').serializeArray();
		var resp = $("#priceRes");
		$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/amendment_price_request_to_manager'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Redirecting.....</strong></div>');
						//console.log("done");
						$("#reqPriceForm")[0].reset();
						location.reload();
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
					console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});
	
	/*Update price by Manager */
	$("#submitRates").validate({
		submitHandler: function(form) {
		var formData = $('#submitRates').serializeArray();
		var resp = $("#response_div");
		$.ajax({
				type: "POST",
				url: "<?php echo base_url('itineraries/update_amendment_price_by_manager'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<div class="alert alert-success"><strong><i class="fa fa-spinner fa-spin"></i>Please wait.....</strong></div>');
				},
				success: function(res) {
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Redirecting.....</strong></div>');
						//console.log("done");
						$("#submitRates")[0].reset();
						location.reload();
					}else{
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});
});

//Prevent Dot from number field
	$("input[type='number']").on('keyup keypress', function(e) {
		if(this.value.length==8) return false;
		
		var keyCode = e.keyCode || e.which;
		if (keyCode != 8) {
            //if not a number
            if (keyCode < 48 || keyCode > 57) {
                     //disable key press
                     return false;
                 } //end if
                 else {
                     // enable keypress
                     return true;
                 } //end else
             } //end if
             else {
                // enable keypress
                 return true;
             } //end else
				 
	});
</script>
<?php }else{
		redirect("itineraries");
	} ?>