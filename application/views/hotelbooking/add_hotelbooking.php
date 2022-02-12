<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<?php if( $itinerary ){
			$iti = $itinerary[0];	
			
			$approved_hotel_cat = $iti->approved_package_category;	
			$total_tra = $iti->adults . " Adults"; 
			$total_tra = "Adults: " . $iti->adults; 
			$total_tra .= !empty($iti->child) ? " Child: {$iti->child} ( Age: {$iti->child_age} )" : ""; ?>
			
			<div class="portlet box blue mb0">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-hotel"></i>Book Hotel &nbsp; [ Iti ID: <?php echo $iti->iti_id; ?> ]</div>
					<a class="btn btn-success" href="<?php echo site_url("hotelbooking"); ?>" title="Back">Back</a>
				</div>
			</div>	
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>			
			
			<div class="tour_info text-left clearfix">
				<h4 class="text-center">Tour Info</h4>
				<div class="col-md-4 "><div class="note note-success"><?php echo "<strong>Book Hotel Category: </strong> " . $approved_hotel_cat ; ?></div></div> 
				<div class="col-md-4 "><div class="note note-success"><?php echo "<strong>Itinerary ID: </strong> " . $iti->iti_id; ?></div> </div>
				<div class="col-md-4 "><div class="note note-success"><?php echo "<strong>Customer Name: </strong> " . get_customer_name($iti->customer_id); ?></div> </div>
				<div class="col-md-4 "><div class="note note-success"><?php echo "<strong>Total Travellers:</strong> " . $total_tra ; ?></div> </div>
				<div class="col-md-4 "><div class="note note-success"><?php echo "<strong>Package Routing: </strong> " . $iti->package_routing ; ?></div></div>
				<div class="col-md-4 "><div class="note note-success"><?php //echo "<strong>Tour Date:</strong>  " . $iti->travel_date . " - " . $iti->travel_end_date; ?></div></div>
			</div>
			
			<!--Show hotel booking if any-->
			<?php if( $existing_bookings ){  ?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-calendar"></i>Existing Hotel Booking Against This Itinerary</div>
				</div>
			</div>
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
						<?php foreach( $existing_bookings as $h_book ){
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
					</tbody>
				</table>
			</div>	
			<?php } ?>
			<!--End hotel booking if any-->
					
	
		
		
		<form class="form-horizontal" role="form" id="addHotelRoomRate">
				
			<hr>
			<!--HOTEL Details SECTION-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-calendar"></i>Hotel Details</div>
				</div>
			</div>
			<?php $hotel_meta = unserialize($iti->hotel_meta); 
			if( !empty( $hotel_meta ) && $iti->iti_status == 1 ){
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
							?>
						</tbody>
					</table>
				</div>	
			<?php }else if( $iti->iti_type == 2 && !empty( $hotel_meta ) ){ ?>
						<?php
					$hotel_meta = unserialize($iti->hotel_meta); 
					$check_hotel_cat = array();
					$check_hotel_cat = !empty($hotel_meta) ? array_column($hotel_meta, "hotel_inner_meta" ) : "";
					
					//Get all category
					$all_hotel_cats = [];
					foreach( $check_hotel_cat as $date => $array ) {
						$all_hotel_cats = array_merge($all_hotel_cats, array_column($array, "hotel_category"));
					}
					$standard_html = "";
					$deluxe_html = "";
					$super_deluxe_html = "";
					$luxury_html = "";
				/* echo "<pre>";
					print_r( $all_hotel_cats );
				echo "</pre>"; */
				
				$is_standard	= !empty($all_hotel_cats) && in_array("Standard", $all_hotel_cats) ? TRUE : FALSE;
				$is_deluxe		= !empty($all_hotel_cats) && in_array("Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
				$is_s_deluxe 	= !empty($all_hotel_cats) && in_array("Super Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
				$is_luxury 		= !empty($all_hotel_cats) && in_array("Luxury", $all_hotel_cats ) ? TRUE : FALSE;
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
													continue2;
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
			<!--END HOTEL Details SECTION-->
			<div class="clearfix"></div>
			<!--div class="col-md-3">
				<div class="form-group2 select_city_err">
					<label class="">Select City*</label>
					<input type="text" required id="hotelcity" class="form-control"  name="hotelcity" value="">
				</div>
			</div-->
			<h3 class="text-center"> Hotel Booking Form </h3>
			<div class="col-md-3">
			<div class="form-group2">
				<label>Select State*</label> 
				<select required name="state_id" class="form-control state" id='state'>
					<option value="">Select state</option>
					<?php $state_list = get_indian_state_list(); 
					if( $state_list ){
						foreach($state_list as $state){
							echo '<option value="'.$state->id.'">'.$state->name.'</option>';
						}
					} ?>
				</select>
			</div>
			</div>
			<div class="col-md-3">
			<div class="form-group2">
				<label>Select City*</label> 
				<select required name="hotelcity" class="form-control city">
					<option value="">Select City</option>
				</select>
			</div>
			</div>
			<div class="col-md-3">
			<div class="form-group2">
				<label>Select Hotel*</label> 
				<select required name="hotel" class="form-control" id="hotels_list">
					<option value="">Select Hotel</option>
				</select>
			</div>
			</div>
			
			<div class="col-md-3">
			<div class="form-group2">
				<label>Room Category*</label> 
				<select required name="room_type" class="form-control">
					<option value="">Select Category</option>
					<?php $roomcat = get_room_categories();
					if($roomcat){
						foreach( $roomcat as $rcat ){
							echo '<option value="'. $rcat->room_cat_id . '">' . $rcat->room_cat_name . '</option>';
						}
					}else{
						echo '<option value="">No category found! Contact your admin.</option>';
					}
					?>
				</select>
			</div>
			</div>
			<div class="clearfix"></div>
			
			<div class="col-md-2">
				<div class="form-group2">
					<label class="" title="Mention Your Invoice Id">Invoice Id*: </label> 
					<div class="clearfix"></div>
					<input type="text" class="form-control"  required name="invoice_id" value="" >
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="">
					<label class="">Total Guest*: </label> 
					<div class="clearfix"></div>
					<input type="text" id="total_tral" class="form-control"  required name="total_travellers" value="<?php echo $total_tra; ?>">
				</div>
			</div>	
				
			<div class="col-md-3">
				<div class="form-group2">
					<label class="">Booking Date*: </label> 
					<div class="clearfix"></div>
					<div class="input-group input-daterange">
						<input readonly required type="text" class="form-control" name="check_in" value="" id="check_in" >
						<span class="input-group-addon hotel_addon"> to </span>
						<input readonly required type="text" class="form-control" name="check_out" value="" id="check_out" > 
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<label class=""><strong>Total Nights:</strong></label>
				<input readonly type="text" id="total_nights" class="form-control" value="">
			</div>
			<div class="col-md-2">
				<div class="form-group2">
				<label class="">Meal Plan *</label> 
				<?php $mealPlans = get_all_mealplans();
				if($mealPlans){ ?>
					<select name="meal_plan" required class="form-control">
						<option value="">Choose Meal Plan</option>
							<?php foreach( $mealPlans as $mp ){
								echo '<option value="'. $mp->id . '">' . $mp->name . '</option>';
							} ?>
					</select>
				<?php }else{ ?>
					<input type="text" required readonly class="form-control" placeholder="You need to add meal plan to proceed." value="">
					<a href="<?php echo base_url("hotels/addmealplan"); ?>" title="Add Meal Plan">Click here to add Meal Plan</a>
				<?php } ?>
			</div>
			</div>
				<div class="col-md-4">
					<div class="form-group2">
						<label  >Inclusion: </label>
						<textarea type="text" name="inclusion" placeholder="Inclusion" class="form-control"></textarea>	
					</div>
				</div>
				
				
				
				<div class="col-md-3">
				<div class="form-group2">
					<label class=" ">Room Rate(Per/room)*: </label>
					<input type="number" required placeholder="Room Rate" name="room_rates" class="form-control room_rates clearfield price_input" value=""/>
				</div> 
				</div>

		 
				<div class="col-md-2">
				<div class="form-group2">
					<label >Total Rooms*: </label>
						<select required name="total_rooms" class="form-control total_rooms clearfield">
							<option value=''>Select Rooms</option>
						<?php for( $i=1 ; $i<=15; $i++ ){
							echo '<option value=' . $i . '> '. $i . '</option>';
						} ?>
						</select>
					<div class="mt-checkbox-list">
						<label for="extra_bed_check" class="mt-checkbox mt-checkbox-outline">
							<input type="checkbox" id="extra_bed_check" name="extra_bed_check" value="Yes">Click Here to Add extra bed.
						<span></span>
						</label>
					
						<label for="without_extra_bed_check"  class="mt-checkbox mt-checkbox-outline">
							<input type="checkbox" id="without_extra_bed_check" value="Yes"> Click Here to Without extra bed.
							<span></span>
						</label>		
					</div>	
				
				</div>
				</div>
				<div class="col-md-3">
					<label >Total Room Cost for 1 Night*: </label>
					<div class="form-group2">	
					<input class="form-control total_room_rates clearfield" readonly required type="text" name="total_room_rates" value="0" id="total_room_rates">	
					</div>	
				</div>	
				
				<!--Extra bed cost section-->
				<div class="clearfix"></div>
				<div class="extra_bed_section">
					<div class="col-md-4">
					<label class=" " >Extra Bed Rate (Per/bed)*: </label> 
						<input required type="number" id="extra_bed_rate" name="extra_bed_rate" placeholder="Extra Bed Charges" class="form-control extra_bed_rate clearfield price_input" value=""/>
					</div>
				
					<div class="col-md-4">
					<label class=" " >Extra Bed*: </label> 
					<select required name="extra_bed" class="form-control extra_bed clearfield">
						<option value="">Select Rooms First</option>
					</select>
					</div>
					
					
					<div class="col-md-4">
					<label >Total Bed Cost for 1 Night*: </label>
					<div class="form-group2">	
					<input class="form-control clearfield" type="text" name="total_ex_bed_rate" value="0" id="total_ex_bed_rate" readonly />	
					</div>	
					</div>
				</div><!--End Extra bed cost section-->
				<div class="clearfix"></div>
				
				<!--Without Extra bed cost section-->
				<div class="without_extra_bed_section">
				
					<div class="col-md-4">
					<label class=" ">Without Extra Bed Cost (Per/without extra bed)*: </label> 
						<input required type="number" id="without_extra_bed_rate" name="without_extra_bed_cost" placeholder="Without Extra Bed Charges" class="form-control without_extra_bed_rate clearfield price_input" value="0"/>
					</div>
				
					<div class="col-md-4">
						<label class=" " >Without Extra Bed*: </label> 
						<select required name="without_extra_bed" class="form-control withour_extra_bed clearfield">
							<option value="">Select</option>
							<?php for( $we = 1 ; $we <= 20 ; $we++ ){
								echo "<option value={$we}> {$we} </option>";
							}	
							?>
						</select>
					</div>
					
					<div class="col-md-4">
						<label >Total Without Extra Bed Cost per/night*: </label>
						<div class="form-group2">	
						<input class="form-control clearfield" type="text" name="total_without_ex_bed_rate" value="0" id="total_without_ex_bed_rate" readonly />	
						</div>	
					</div>
					
				</div><!--End Without Extra bed cost section-->
				
				<div class="clearfix"></div>
				
				<div class="col-md-3">
					<div class="form-group2">
						<label class=" "><strong>Inclusion Charges:</strong></label>
						<input class="form-control price_input" id="extra_charges" type="number" placeholder="eg: 100" name="extra_charges" value="" />
					</div>	 
				</div>	 
				
				
					
				
				<div class="col-md-3">
					<div class="form-group2">
						<label class=" "><strong>Hotel Tax:</strong></label>
						<input class="form-control price_input" id="hotel_tax" type="number" placeholder="eg: 100" name="hotel_tax" value="0" />
					</div>	 
				</div>	 
					<div class="col-md-3">
						<label class=""><strong>Total Cost:</strong></label>
						<a href="javascript: void(0)" id="calculate_cost">Calculate</a>
						<input readonly class="form-control clearfield price_input" id="total_cost" type="number" name="total_cost" value="">
					</div>
					<div class="clearfix"></div>	
				
			  
				<input type="hidden" name="customer_id" value="<?php echo $iti->customer_id; ?>">
				<input type="hidden" name="iti_id" id="iti_id" value="<?php echo $iti->iti_id; ?>">
				<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>">
				<input type="hidden" id="submit_type" value="9">
				<div class="margiv-top-10 col-md-12 text-right">
					<button type="submit" data-click_val="9" class="btn green uppercase add_hotel bookbtn">Save and Exit</button>
					<button type="submit" data-click_val="8" class="btn green uppercase save_and_continue bookbtn">Save and Continue</button>
				</div>
				
				<div class="clearfix"></div>
				<div id="addresEd"></div>	
			
			</form>
			</div>
		<?php } ?>
	<!-- END CONTENT BODY -->
	</div>
</div>
<script type="text/javascript">
/* Calculate Total Cost for Hotel Booking */
jQuery(document).ready(function($){
	//Prevent Dot from number field
	$(".price_input").on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
		if (keyCode === 46) { 
			e.preventDefault();
			return false;
		}
	});
	
	function resetAllfields() {
		$('.clearfield').val('');
		$(".total_rooms").attr("disabled", "disabled");
		$("#extra_bed_check").attr("disabled", "disabled");	
		$(".extra_bed").attr("disabled", "disabled");	
		$("#check_in").val("");
		$("#check_out").val("");
	}
	
	//Get Total Nights on datepicker change
	var today = new Date();
	$('.input-daterange').daterangepicker({
		locale: {
		  format: 'YYYY-MM-DD'
		},
		startDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
		minDate:today
	}, 
	function(start, end, label) {
		var starD = start.format('YYYY-MM-DD');
		var endD = end.format('YYYY-MM-DD');
		$('#check_in').val(starD);
		$('#check_out').val(endD);
		
		var nights = calculateNights(starD, endD);
		//console.log(nights);
		$("#total_nights").val(nights);
		$("#total_cost").val("");
		//alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
	
	
	//calculate total nights
	function calculateNights(start_Date , End_Date){
		if(jQuery.type(start_Date) === "undefined" && jQuery.type(End_Date) === "undefined"){
			return false;
		}else{
			var startDate = Date.parse(start_Date);
            var endDate = Date.parse(End_Date);
            var timeDiff = endDate - startDate;
            daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
			return daysDiff;
		}	
	}
	/*calculate total cost*/
	$(document).on("click", "#calculate_cost", function(){
		var _total = $("#total_cost"), tc = 0, tt=0, total=0,
			tn = $("#total_nights").val(),
			inc_charge = $("#extra_charges").val(),
			rc = $("#total_room_rates").val(),
			exbed = $("#total_ex_bed_rate").val();
		var total_nights = tn < 1 ? 1 : tn;	
		var inclu_charges = inc_charge < 1 ? 0 : inc_charge;	
		var total_room_cost = rc < 1 ? 0 : rc;	
		var extra_bed_cost = exbed < 1 ? 0 : exbed;	
		
		var total_nights = parseInt(total_nights),
			inclu_charges = parseFloat(inclu_charges),
			total_room_cost = parseFloat(total_room_cost),
			extra_bed_cost = parseFloat(extra_bed_cost),
			hotel_tax = parseFloat($("#hotel_tax").val()),
			without_extra_bed = parseFloat($("#total_without_ex_bed_rate").val());
			
		
		if( tn == 0 || tn == "" ){
			alert("Please Select valid check_in and check_out dates");
			$("#check_in").focus();
			return false;
		}
		
		/*calculate total cost*/
		tc = total_room_cost + extra_bed_cost + without_extra_bed;
		tt = tc * total_nights;
		total = inclu_charges + tt + hotel_tax;
		_total.val( total.toFixed(0) );
	});
	/* total rooms cost */
	$(document).on("change", ".total_rooms", function(){
		var roomRate = $(".room_rates").val();
		if( roomRate == "" || roomRate == 0 ){
			alert("Please Add room rate first!");
			$(".room_rates").focus();
			$(this).val("");
			return false;
		}	
		var room_rate = parseFloat($(".room_rates").val());
		var _this = $(this),
		total = _this.val()*room_rate;
		$("#total_room_rates").val(total.toFixed(0) );
		$("#total_cost").val("");
	});
	$(document).on("change", ".room_rates", function(){ $(".total_rooms").val("") });
	$(document).on("change", "#extra_bed_rate", function(){ $(".extra_bed").val("") });
	$(document).on("change", "#without_extra_bed_rate", function(){ $(".withour_extra_bed, #total_without_ex_bed_rate").val("") });
	/* .extra_bed cost */
	$(document).on("change", ".extra_bed", function(){
		var _this = $(this),
		eRate = $("#extra_bed_rate").val(),
		extra_bed_rate = parseFloat(eRate);
		if( eRate == "" || eRate == 0 ){
			alert("Please Add extra bed rate rate first!");
			$("#extra_bed_rate").focus();
			$(this).val("");
			return false;
		}
		var total = _this.val()*extra_bed_rate;
		$("#total_ex_bed_rate").val(total.toFixed(0));
		$("#total_ex_bed_rate").attr("value", total.toFixed(0));
		$("#total_cost").val("");
	});
	
	/* without extra_bed cost */
	$(document).on("change", ".withour_extra_bed", function(){
		var _this = $(this),
		eRate = $("#without_extra_bed_rate").val(),
		wextra_bed_rate = parseFloat(eRate);
		if( eRate == "" || eRate == 0 ){
			alert("Please Add without extra bed rate rate first!");
			$("#without_extra_bed_rate").focus();
			$(this).val("");
			return false;
		}
		var wtotal = _this.val()*wextra_bed_rate;
		$("#total_without_ex_bed_rate").val(wtotal.toFixed(0));
		$("#total_without_ex_bed_rate").attr("value", wtotal.toFixed(0));
		$("#total_cost").val("");
	});
	
	/* Inclusion Charges */
	$(document).on("blur", ".price_input", function(){
		$("#total_cost").val("");
		var _this = $(this).val();
		var value = parseFloat($(this).val());
		if( value < 0 || $.isNumeric( $(this).val() ) == false ){
			alert("Please enter positive numeric value");
			$(this).val(0);
			$(this).attr('value', 0);
			$(this).attr('value', value);
		}else{
			if( _this != '' ){
				$(this).attr('value', value);
			}else{
				$(this).val(0);
				$(this).attr('value', 0);
			}
		}
	});
}); 
</script>

<script type="text/javascript">
jQuery(document).ready(function($){
	//Get click val
	$(document).on("click", ".bookbtn", function(){
		var data_click = $(this).attr("data-click_val");
		$("#submit_type").val( data_click );
	});
	
	$(document).on("change", ".total_rooms", function(){ 
		$("#total_ex_bed_rate").val("");
		var total_rooms = $(this).val();
		var ext_beds = $(".extra_bed");
		ext_beds.html("<option value=''>Select extra beds</option>");
		for( var i=1; i<= total_rooms; i++){
			ext_beds.append( "<option value=" + i + ">"+ i + "</option>");
		} 
	});
	/* Check for extra bed */
	$(document).on('click', '#extra_bed_check', function(e){
		$("#total_ex_bed_rate, #total_cost,.extra_bed, #extra_bed_rate ").val("");
		if ($('#extra_bed_check').is(':checked')) {
      	   $(".extra_bed_section").show();
		   $(".extra_bed_rate").addClass("ex_rate");
		} else {
			$(".extra_bed_rate").removeClass("ex_rate");
			$(".extra_bed_section").hide();
      	}
    });
	$(".extra_bed_section, .without_extra_bed_section").hide();
	/* Check for without extra bed */
	$(document).on('click', '#without_extra_bed_check', function(e){
		$("#total_cost").val("");
		if ($('#without_extra_bed_check').is(':checked')) {
      	   $(".without_extra_bed_section").show();
		}else {
			$("#without_extra_bed_rate,.withour_extra_bed,#total_without_ex_bed_rate").val(0);
			$(".without_extra_bed_section").hide();
      	}
    });
	
	//Submit form
	var ajaxReq;
	$("#addHotelRoomRate").validate({
		rules: {
			total_cost: {required: true, number: true },
		},
		submitHandler: function(form) {
		var resp = $("#addresEd"),
		submit_type = $("#submit_type").val();
		iti_id = $("#iti_id").val();
		formData = $("#addHotelRoomRate").serializeArray();
		//console.log( formData );
			if (ajaxReq) {
				ajaxReq.abort();
			}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('hotelbooking/ajax_book_hotel'); ?>" ,
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					$(".fullpage_loader").show();
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					$(".fullpage_loader").hide();
					if (res.status == true){
						resp.html('<div class="alert alert-success"><strong>Success !</strong> ' + res.msg + '</div>');
						//console.log("done");
						$("#addHotelRoomRate")[0].reset();
						$(".price_input").val(0);
						if( submit_type == 9 )
							window.location.href = "<?php echo site_url("hotelbooking/view/");?>" + res.booking_id + "/" + iti_id;
						else
							location.reload();	
						
					}else{
						
						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						//console.log("error");
					}
				},
				error: function(e){
					$(".fullpage_loader").hide();
						//console.log(e);
					resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
				}
			});
			return false;
		}
	});
}); 
</script>

<script type="text/javascript">
 jQuery(document).ready(function($){
	function resetAllValues() {
		$('.clearfield').val('');
		$(".total_rooms").attr("disabled", "disabled");
		$("#extra_bed_check").attr("disabled", "disabled");	
		$(".extra_bed").attr("disabled", "disabled");	
	}
	jQuery.validator.addMethod("multiemail", function (value, element) {
        if (this.optional(element)) {
            return true;
        }
        var emails = value.split(','),
            valid = true;
        for (var i = 0, limit = emails.length; i < limit; i++) {
            value = emails[i];
            valid = valid && jQuery.validator.methods.email.call(this, value, element);
        }
        return valid;
    }, "Please separate valid email addresses with a comma and do not use spaces.");
	/* get Hotels from City */
	$(document).on('change', 'select.hotel', function() {
		$(".roomcat").removeAttr("disabled");
		$(".roomcat").val("");
		resetAllValues();
	});	
	
	/*get Hotels Rate By Hotel ID from City*/
	$(document).on('change', 'select.roomcat', function() {
		/* $("#total_cost").val("");
		$(".total_rooms").val(""); */
		resetAllValues();
        var room_cat = $(".roomcat option:selected").val();
        var hotel_id = $(".hotel").val();
		if( room_cat == "" ){
			alert("Please Select Room Category!");
			$("input[name='room_rates']").val("");
			$("input[name='extra_bed_rate']").val("");
			$(".total_rooms").attr("disabled", "disabled");
			$("#extra_bed_check").attr("disabled", "disabled");	
			$(".extra_bed").attr("disabled", "disabled");	
		}else{
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo base_url('AjaxRequest/get_rooms_rates'); ?>",
				data: { room_cat : room_cat, hotel_id : hotel_id },
				beforeSend: function(){
					
				},
				success: function(res){
					if(res.status = true){
						var rr = res.room_rate;
						var ex = res.extra_bed;
						if( typeof(rr) === "undefined" && typeof(ex) === "undefined" ){
							alert("Select other hotel/room category or Contact Administrator/Manager.Because Room Rate Not Found!.");
							$(".total_rooms").attr("disabled", "disabled");
							$("#extra_bed_check").attr("disabled", "disabled");	
							$(".extra_bed").attr("disabled", "disabled");	
							$("input[name='room_rates']").val("");
							$("input[name='extra_bed_rate']").val("");
						}else{
							$(".total_rooms").removeAttr("disabled");
							$("#extra_bed_check").removeAttr("disabled");
							$(".extra_bed").removeAttr("disabled");
							$("input[name='room_rates']").val(rr);
							$("input[name='extra_bed_rate']").val(ex);
						}	
						//console.log(rr);
						//console.log(ex);
					}else{
						//console.log( "error" );
						alert("Select other hotel/room category or Contact Administrator/Manager.");
					}
				},
				error: function(){
					//console.log( "error 1 " );
					alert("Before you proceed please add room rate! or Contact Administrator/Manager.");
				}
			});
		}	
    }); 
	
}); 
 
</script>
<script>
	/*get cities from state*/
	jQuery(document).ready(function($){
		$(document).on('change', 'select.state', function() {
			var selectState = $(".state option:selected").val();
			var _this = $(this);
			$("#hotels_list").val("");
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/hotelCityData'); ?>",
				data: { state: selectState } 
			}).done(function(data){
				$(".bef_send").hide();
				$(".city").html(data);
				$("#hotels_list").html("<option vlaue=''>select hotel</option>");
			}).error(function(){
				$("#city_list").html("Error! Please try again later!");
			});
		});
		/*get cities from state*/
		$(document).on('change', 'select.city', function() {
			var selectcity = $(".city option:selected").val();
			var _this = $(this);
			_this.parent().append('<p class="bef_send"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('AjaxRequest/hotellistByCityId'); ?>",
				data: { hotel: selectcity } 
			}).done(function(data){
				$(".bef_send").hide();
				$("#hotels_list").html(data);
			}).error(function(){
				$("#hotels_list").html("Error! Please try again later!");
			});
		});
	});	
</script>
