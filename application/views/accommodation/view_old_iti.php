<div class="page-container itinerary-view">
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php if( !empty($itinerary[0] ) ){
				$iti = $itinerary[0];
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
				
				?>
				
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Customer Name: <?php echo $customer_name; ?>
						{ Package Type: <strong class="red"> <?php echo check_iti_type( $iti->iti_id ); ?></strong> }
						</div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("itineraries"); ?>" title="Back">Back</a>
					</div>
					
					 <div class="portlet-body ">
					 <div class="row">
					 <div class="col-md-6">
					 <div class="alert alert-danger strong"><i class="fas fa-hand-point-right"></i> OLD ITINERARY</div>
						<table class="table">	
							<tr>
								<td>OLD PACKAGE COST:</td>
								<td><strong><?php echo $iti->old_package_cost; ?></strong></td>
							<tr>
							<tr>
								<td>PACKAGE CATEGORY:</td>
								<td><strong><?php echo $iti->approved_package_category; ?></strong></td>
							<tr>
						</table>
					</div>	
					<div class="clearfix"></div>
					</div>	
					</div>	
				</div>
				<?php 
				//Insert Rate meta if price is empty
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
									echo "<div class='well well-sm'><h3>Standard</h3></div>";
									echo $table_start . $standard_html . "</table>";
								}
								if( $is_deluxe ){
									echo "<div class='well well-sm'><h3>Deluxe</h3></div>";
									echo $table_start . $deluxe_html . "</table>";
								}
								if( $is_s_deluxe ){
									echo "<div class='well well-sm'><h3>Super Deluxe</h3></div>";
									echo $table_start . $super_deluxe_html . "</table>";
								}
								if( $is_luxury ){
									echo "<div class='well well-sm'><h3>Luxury</h3></div>";
									echo $table_start . $luxury_html . "</table>";
								}
							} ?>
						
						<?php } ?>	
					<hr>
					
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
					
					
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>

<?php }else{
		redirect("itineraries");
	} ?>