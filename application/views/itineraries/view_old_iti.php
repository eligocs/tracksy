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
				
				
				
				
				<div class="row2">
				
					<!--End view and edit button-->
					<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fas fa-book"></i> Package Overview</div>
					</div>	
				
					<div class="portlet-body ">
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
					</div>	
					</div>	

					<div class="clearfix"></div>
					<hr>
					
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"> <i class="far fa-file-alt"></i> Day Wise Itinerary</div>
						</div>

					<div class="portlet-body ">
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
					</div>	
					</div>	
						<hr>
						
						
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"><i class="fal fa-info-square"></i>Inclusion & Exclusion</div>
						</div>	
					
					<div class="portlet-body ">	
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
					</div>	
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
					
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<?php }else{
		redirect("itineraries");
	} ?>