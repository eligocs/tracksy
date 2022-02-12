<?php $customer = $customer[0];  ?>
<div class="page-container customer_view_section view_call_info">
<?php  if($customer){ ?>
	<div class="page-content-wrapper">
		<div class="page-content">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Customer Detail</div>
						<a class="btn btn-success" href="<?php echo site_url("customers/declinedleads"); ?>" title="add hotel">Back</a>
					</div>
				</div>
				<!--Get New Data if lead approved -->
				<?php if( !empty( $approved_cus ) ){ ?> 
					<?php $cus = $approved_cus[0]; ?>
					<div class="customer-details">	
					<h3 class="text-center">Approved Customer Info</h3>
					<div class=" ">
					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Customer Id:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $cus->customer_id; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Customer Name:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $cus->customer_name; ?></div>
					</div>

					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Customer Email:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $cus->customer_email; ?></div>
					</div>

					<div class="col-md-6 col-lg-4">	
						<div class="col-md-6 form_vl"><strong>Customer Contact:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $cus->customer_contact; ?></div>
					</div>		
					<!--if Customer Info exists-->
					<?php if( !empty( $cus->adults ) && !empty($cus->hotel_category) ){ ?>
					<div class="col-md-6 col-lg-4">			
						<div class="col-md-6 form_vl"><strong>Whatsapp Number:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $cus->whatsapp_number; ?></div>
					</div>
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Adults:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->adults; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">
									<div class="col-md-6 form_vl"><strong>Child:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo !empty( $cus->child ) ? $cus->child : "N/A" ; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Child Age:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo !empty( $cus->child_age ) ? $cus->child_age : "N/A" ; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
						<div class="col-md-6 form_vl"><strong>Package Type:</strong></div>	
						<?php 
						$pkBy =	$cus->package_type;
						$pack_T = $pkBy == "Other" ? $cus->package_type_other : $pkBy; ?>
						<div class="col-md-6 form_vr"><?php echo $pack_T; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Total Rooms:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->total_rooms; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Travel Date:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->travel_date; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Destination:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->destination; ?></div>
					</div>
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Pick Up Point:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->pickup_point; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
						<div class="col-md-6 form_vl"><strong>Dropping Point:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $cus->droping_point; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">				
									<div class="col-md-6 form_vl"><strong>Package By:</strong></div>
									<?php 
									$cp_type =	$cus->package_car_type;
									$pack_car_type = $cp_type == "Other" ? $cus->package_car_type_other : $cp_type; ?>
									<div class="col-md-6 form_vr"><?php echo $pack_car_type; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Meal Plan:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->meal_plan; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Honeymoon Kit:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->honeymoon_kit; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Car Type for sightseeing:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo get_car_name($cus->car_type_sightseen); ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Hotel Category:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->hotel_category; ?></div>
					</div>
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Budget Approx:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $cus->budget; ?></div>
					</div>
						<?php } ?>
					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Customer Assign To:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo get_user_name($cus->agent_id); ?></div>
					</div>
					</div> <!-- row -->
					</div>
				<?php } ?>
				<hr>
				<!-- End new data -->
				<div class="portlet-body">
					<div class="customer-details">
						<h3 class="text-center">Customer Info</h3>
						<p class="text-center red">Declined Reason: <strong><?php echo $customer->decline_reason; ?></strong></p>
						<p class="text-center red">Declined Comment: <strong><?php echo $customer->decline_comment; ?></strong></p>
					<div class=" ">
					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Customer Id:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $customer->customer_id; ?></div>
					</div>
					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Customer Type:</strong></div>	
						<?php 
							$cus_type  = get_customer_type_name($customer->customer_type);
						?>
						<div class="col-md-6 form_vr"><?php echo $cus_type; ?></div>
					</div>
					<?php if( $customer->customer_type == 2 ){ ?>
					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Reference Name:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $customer->reference_name; ?></div>
					</div>
					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Reference Contact:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $customer->reference_contact_number; ?></div>
					</div>
					<?php } ?>
					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Customer Name:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $customer->customer_name; ?></div>
					</div>

					<div class="col-md-6 col-lg-4">
						<div class="col-md-6 form_vl"><strong>Customer Email:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $customer->customer_email; ?></div>
					</div>

					<div class="col-md-6 col-lg-4">	
						<div class="col-md-6 form_vl"><strong>Customer Contact:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $customer->customer_contact; ?></div>
					</div>		
					<!--if Customer Info exists-->
					<?php if( !empty( $customer->adults ) && !empty($customer->hotel_category) ){ ?>
					<div class="col-md-6 col-lg-4">			
						<div class="col-md-6 form_vl"><strong>Whatsapp Number:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $customer->whatsapp_number; ?></div>
					</div>
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Adults:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->adults; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">
									<div class="col-md-6 form_vl"><strong>Child:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo !empty( $customer->child ) ? $customer->child : "N/A" ; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Child Age:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo !empty( $customer->child_age ) ? $customer->child_age : "N/A" ; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Package Type:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->package_type; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Total Rooms:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->total_rooms; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Travel Date:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->travel_date; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Destination:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->destination; ?></div>
					</div>
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Pick Up Point:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->pickup_point; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
						<div class="col-md-6 form_vl"><strong>Dropping Point:</strong></div>	
						<div class="col-md-6 form_vr"><?php echo $customer->droping_point; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">				
									<div class="col-md-6 form_vl"><strong>Package By:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->package_car_type; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Meal Plan:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->meal_plan; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Honeymoon Kit:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->honeymoon_kit; ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Car Type for sightseeing:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo get_car_name( $customer->car_type_sightseen ); ?></div>
					</div>
					
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Hotel Category:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->hotel_category; ?></div>
					</div>
					<div class="col-md-6 col-lg-4">			
									<div class="col-md-6 form_vl"><strong>Budget Approx:</strong></div>	
									<div class="col-md-6 form_vr"><?php echo $customer->budget; ?></div>
					</div>
						<?php } ?>
					<div class="col-md-6 col-lg-4">			
						
								<div class="col-md-6 form_vl"><strong>Customer Added By:</strong></div>	
								<div class="col-md-6 form_vr"><?php echo get_user_name($customer->agent_id); ?></div>
							
					</div>
					</div> <!-- row -->
					</div>		
				</div>
					<div class="clearfix"></div>
				<hr>
				<!--status 7 for working-->
				<!-- if customer approved query -->
				<?php if(  $customer->reopen_status == 9 ){  ?>
					<h3 class="uppercase red"><strong> <?php echo $customer->quotation_type; ?> Package </strong></h3>
					<div class="note note-info">
						<p style="font-size: 16px;">Lead Approved By Customer.</p>
                    </div>
				<?php }elseif( $customer->reopen_status == 8 ){ ?><!-- if customer decline query  -->
					<h3 class="uppercase red"><strong> <?php echo $customer->quotation_type; ?> Package </strong></h3>
					<div class="well well-sm">
						<h3>Lead declined by customer.</h3>
						<!-- Reopen Lead -->
						<?php /*<a class="btn btn-success" href="#" data-customer_id = "<?php echo $customer->customer_id; ?>" data-temp_key = "<?php echo $customer->temp_key; ?>" id="reopenLead" title="Reopen"><i class="fa fa-refresh" aria-hidden="true"></i> Reopen Lead</a> 
						<div id="rr"></div> */ ?>
					</div>
					<p><strong>Reason: </strong> <?php echo $customer->decline_reason; ?> </p>
				<?php }else if( $customer->reopen_status == 7 ){ ?>
				<!-- Process for customer followup  -->
					<a class="btn btn-danger" href="#" id="add_call_btn" title="Back">Add Call Info</a>
					<div class="call_log" id="call_log_section">
						<form id="call_detais_form">
							<div class="call_type_seciton">
								<label class="radio-inline">
									<input data-id="picked_call_panel" required id="picked_call" class="radio_toggle" type="radio" name="callType" value="Picked call">Picked call
								</label>
								<label class="radio-inline"><input class="radio_toggle" data-id="call_not_picked_panel" required id="call_not_picked" type="radio" name="callType" value="Call not picked">Call not picked</label>
								<label class="radio-inline"><input class="radio_toggle" data-id="close_lead_panel" required id="close_lead" type="radio" name="callType" value="8">Decline</label>
							</div>	
							
							<div id="panel_detail_section">
								<div class="call_type_res col-md-4" id="picked_call_panel"><!--picked call panel-->
									<div class="col-md-">
										<div class="form-group">
										  <label for="comment">Call summary<span style="color:red;">*</span>:</label>
										  <textarea required class="form-control" rows="3" name="callSummary" id="callSummary"></textarea>
										</div> 
									</div>
									<div class="col-md-">
										<div class="checkbox1">
											<label><input id="nxtCallCk" type="radio" class="book_query" name="book_query" required value=""> Next call time</label>
										</div>
										<div id="next_call_cal">
											<label>Next calling time and date<span style="color:red;">*</span>:</label> 
											<input size="16" required type="text" value="" name="nextCallTime" readonly class="form-control form_datetime">  
										</div>	
									</div>
									<div class="col-md-">
										<label for="readyQuotation"><input id="readyQuotation" class="book_query" name="book_query" required type="radio" value="9"> Ready for quotation</label>
									</div>
									<div class="col-md-">
										<div class="form-group">
											<label>Lead prospect<span style="color:red;">*</span></label>
											<select required class="form-control" name="txtProspect">
												<option value="Hot">Hot</option>
												<option value="Warm">Warm</option>
												<option value="Cold">Cold</option>
											</select>
										</div>
									</div>
									<!--Quotation Type Holidays/Accommodation/Cab-->
									<div id="quotation_type_section">
										<label class="radio-inline" for="holidays"><input id="holidays" class="quotation_type" name="quotation_type" required type="radio" value="holidays"> Holidays </label>
										<label class="radio-inline" for="accommodation"><input id="accommodation" class="quotation_type" name="quotation_type" required type="radio" value="accommodation"> Accommodation </label>
										<!--label class="radio-inline" for="cab_b"><input id="cab_b" class="quotation_type" name="quotation_type" required type="radio" value="cab"> Cab Booking </label-->
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
										<label class="radio-inline">
											<input required type="radio" name="callSummaryNotpicked" class="call_type_not_answer" value="Number does not exists">Number does not exists
										</label>
										<div class="clearfix"></div>
										<div class="col-md-6">
										<div class="row">
										<div class="nxt_call">
											<div class="form-group">
												<label>Next calling time and date<span style="color:red;">*</span>:</label> 
												<input size="16" required type="text" value="" readonly name="nextCallTimeNotpicked" class="form-control form_datetime"> 
											</div>
											
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
										</div>	
									
									</div>
								</div>
								<!--end call not picked panel-->	
								<!--close_lead_panel panel-->
								<div class="call_type_res" id="close_lead_panel">
									<p class="red"><strong>Note: </strong>If you decline this lead you can't reopen this lead again.</p>
									<div class="form-group col-md-6">
										<select required class="form-control" name="decline_reason">
											<option value="">Select Reason</option>
											<option value="Booked with someone else">Booked with someone else</option>
											<option value="Not interested">Not interested</option>
											<option value="Not answering call from 1 week">Not answering call from 1 week</option>
											<option value="Plan cancelled">Plan cancelled</option>
											<option value="Wrong number">Wrong number</option>
											<option value="Denied to post lead">Denied to post lead</option>
											<option value="Other">Other</option>
										</select>
									</div>
									<div class="clearfix"></div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="comment">Decline Comment:</label>
											<textarea class="form-control" rows="3" name="decline_comment" id="decline_comment"></textarea>
										</div> 
									</div>
								</div><!--end close_lead_panel-->	
							</div><!--panel_section end-->
							<div class="clearfix"></div>
							<div id="customer_info_panel">
							<div class="col-md-12">
								<label><strong>How Many Persons you Are:</strong></label>
							</div>	
							<div class="clearfix"></div>
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Whatsapp Number:</label>
									<input type="text" class="form-control" placeholder="Whatsapp Number" name="whatsapp_number" value="">
								</div>
								</div>
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Adults *:</label>
								  <input required type="text" class="form-control" placeholder="No. of Adults" name="adults" value="">
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Child:</label>
									<input type="text" class="form-control" placeholder="No. of child" name="child" value="">
								</div>
								</div>
								
								
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Age of the child:</label>
									<input type="text" class="form-control" placeholder="Child age. eg: 13,12" name="child_age" value="">
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group row">
								<div class="col-sm-6">
									<label for="">Your Package Type *:</label>
									<select required name="package_type" class="form-control">
										<option value="">Choose Package Type</option>
										<option value="Honeymoon Package">Honeymoon Package</option>
										<option value="Fixed Departure">Fixed Departure</option>
										<option value="Group Package">Group Package</option>
										<option value="Other">Other</option>
									</select>
								</div>
								<div class="col-sm-6">
								<label for="">&nbsp;</label>
									<input type="text" required class="form-control" name="package_type_other" id="pack_type_other">
								</div>
								
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">No. of rooms *:</label>
									<select required name="total_rooms" class="form-control">
										<option value="">Select Rooms</option>
										<?php 
											for( $i=1 ; $i <=20 ; $i++ ){
												echo "<option value='{$i}'>{$i}</option>";
											}
										?>
									</select>
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Travel Date *:</label>
									<input required type="text" class="form-control" readonly id="travel_date" name="travel_date" value="">
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Destination *:</label>
									<input required type="text" class="form-control" name="destination" value="">
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6 hide_accommodation">
								<div class="form-group">
									<label for="">Pick Up Point *:</label>
									<input required type="text" class="form-control" name="pick_point" value="">
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6 hide_accommodation">
								<div class="form-group">
									<label for="">Dropping Point *:</label>
									<input required type="text" class="form-control" name="drop_point" value="">
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6 hide_accommodation">
								<div class="form-group row">
									<div class="col-sm-6">
									<label for="">Package By *:</label>
									<select required name="package_by" class="form-control">
										<option value="">Choose Package By</option>
										<option value="Car">Car</option>
										<option value="Volvo">Volvo</option>
										<option value="Other">Other</option>
									</select>
									</div>
									<div class="col-sm-6">
										<label for="">&nbsp;</label>
										<input type="text" required class="form-control" name="package_by_other" id="other_pack">
									</div>	
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Meal Plan *:</label>
									<select required name="meal_plan" class="form-control">
										<option value="">Choose Meal Plan</option>
										<option value="Breakfast Only">Breakfast Only</option>
										<option value="Breakfast & Dinner">Breakfast & Dinner</option>
										<option value="Breakfast, Lunch & Dinner">Breakfast, Lunch & Dinner</option>
										<option value="Dinner Only">Dinner Only</option>
										<option value="No Meal Plan">No Meal Plan</option>
									</select>
								</div>
								</div>
								
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Honeymoon Kit *:</label>
									<input type="text" class="form-control" placeholder="" name="honeymoon_kit" value="">
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6 hide_accommodation">
								<div class="form-group">
									<label for="">Car type for sightseeing *:</label>
									<select required name="car_type_sightseen" class="form-control">
										<option value="">Choose Car Category</option>
										<?php $cars = get_car_categories(); 
											if( $cars ){
												foreach($cars as $car){
													echo '<option value = "'.$car->id .'" >'.$car->car_name.'</option>';
												}
											}
										?>
									</select>
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Hotel type *:</label>
									<select required name="hotel_type" class="form-control">
										<option value="">Choose Hotel Category</option>
										<option value="Standard">Standard</option>
										<option value="Deluxe">Deluxe</option>
										<option value="Super Deluxe">Super Deluxe</option>
										<option value="Luxury">Luxury</option>
									</select>
								</div>
								</div>
								
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Budget Approx *:</label>
									<select required name="budget" class="form-control">
										<option value="">Choose Budget</option>
										<option value="0-5000">0-5000</option>
										<option value="5001-15000">5001 - 15000</option>
										<option value="15001-30000">15001 - 30000</option>
										<option value="30001-50000">30001 - 50000</option>
										<option value="50001-100000">50001 - 100000</option>
										<option value="100001-150000">100001 - 150000</option>
										<option value=">150000">>150000</option>
									</select>
								</div>
								</div>
								<?php 
								//get all sales team user
								$get_salesteam = get_all_sales_team_agents();
								
								?>
								<div class="col-lg-4 col-md-6">
								<div class="form-group">
									<label for="">Assign Lead To *:</label>
									<select required name="assign_to" class="form-control">
										<option value="">Choose User</option>
										<?php if( !empty( $get_salesteam ) ){
											foreach( $get_salesteam as $user ){ 
												//get all user exclude current agent assign to lead
												if( $user->user_id != $customer->agent_id ){
													echo "<option value='{$user->user_id}'>" . get_user_name( $user->user_id ) . "</option>";
												}	
											} 
										} ?>
										
									</select>
								</div>
								</div>
							</div><!--End customer info Section-->
							<input type="hidden" name="customer_id" value="<?php echo $customer->customer_id; ?>">
							<input type="hidden" name="temp_key" value="<?php echo $customer->temp_key; ?>">
							<input type="hidden" name="agent_id" value="<?php echo $user_id; ?>">
							<div class="margiv-top-10">
								<button type="submit" id="submit_frm" class="btn green uppercase submit_frm">Submit</button>
								<button class="btn red uppercase cancle_bnt">Cancel</button>
							</div>
							<div class="clearfix"></div>
							<div id="resp"></div>
						</form>
					</div>
				<?php }else{ ?>
					<a class="btn btn-success" href="#" data-customer_id = "<?php echo $customer->customer_id; ?>" data-temp_key = "<?php echo $customer->temp_key; ?>" id="reopenLead" title="Reopen"><i class="fa fa-refresh" aria-hidden="true"></i> Reopen Lead</a> 
					<div id="rr"></div> 
				<?php } ?>		
				<?php if( !empty( $followUpData ) ){ ?>
					<!--div class="panel-group accordion call-time" id="accordion3"--->
						<?php
						$count = 1;
						foreach( $followUpData as $callDetails ){ ?>
							<?php $c_type = $callDetails->callType; 
								if( $c_type == 9 ){
									$callType_status = "Approved";
								}elseif( $c_type == 8 ){
									$callType_status = "Decline";
								}else{
									$callType_status = $c_type;
								}
							?>
						<p></p>
						<div class="col-md-6 col-lg-4">
								<div class="mt-element-list">			 
									<div class="mt-list-container list-todo" id="accordion1" role="tablist" aria-multiselectable="true">
										<div class="list-todo-line"></div>
										<ul>
											<li class="mt-list-item">
												<div class="list-todo-icon bg-white font-green-meadow">
													<i class="fa fa-clock-o"></i>
												</div>
												<div class="list-todo-item green-meadow">
													<a class="list-toggle-container" data-toggle="collapse" data-parent="#accordion1" onclick=" " href="#task-<?php echo $count;?>" aria-expanded="false">
														<div class="list-toggle done uppercase">
															<div class="list-toggle-title bold">Call Time: <?php echo $callDetails->currentCallTime;?></div>
															 
														</div>
													</a>
													<div class="task-list panel-collapse collapse" id="task-<?php echo $count;?>">
														<ul>
															<li class="task-list-item done">
																<div class="task-icon"><a href="javascript:;"><i class="fa fa-phone"></i></a></div>

																<div class="task-content">
																	<h4 class="uppercase bold">
																		<a href="javascript:;"><?php echo $callType_status;?></a>
																	</h4>
															<p><strong>Call summary:</strong> <?php echo $callDetails->callSummary;?></p>
															<p><strong>Next Call Time:</strong> <?php echo $callDetails->nextCallDate;?></p>
															<p><strong><?php echo $callDetails->customer_prospect;?></strong></p>
																</div>
															</li>
														</ul>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								</div>		<!--/div>
					</div>
				</div-->
				<?php $count++; ?>
			<?php } ?>
		<!--/div-->	
	<?php } ?>
		</div>
	</div>
</div>

<style>
#customer_info_panel, #quotation_type_section{display: none;} 
#call_log_section{display: none;} 
#close_lead_panel,#booked_lead_panel,#call_not_picked_panel,#picked_call_panel, .nxt_call{display: none}
#next_call_cal{display: none;}
.tour_des {
    background: #faebcc;
    padding-top: 20px;
    padding-bottom: 40px;
}
#other_pack{display: none;}
#pack_type_other{display: none;}
</style>

<script type="text/javascript">
	/* Add customer information */
	jQuery(document).ready(function($){
		//Show text box if other package_by choose
	$(document).on("change", "select[name='package_by']", function(e){
		e.preventDefault();
		var _this = $(this);
		var _thisValue = _this.val();
		console.log( _thisValue );
		if( _thisValue == "Other" ){
			$("#other_pack").show();
		}else{
			$("#other_pack").hide();
			$("#other_pack").val("");
		}
	});
	//Show text box if other Package Type choose
	$(document).on("change", "select[name='package_type']", function(e){
		e.preventDefault();
		var _this = $(this);
		var _thisValue = _this.val();
		console.log( _thisValue );
		if( _thisValue == "Other" ){
			$("#pack_type_other").show();
		}else{
			$("#pack_type_other").hide();
			$("#pack_type_other").val("");
		}
		
	});
		
});	
</script>
<script type="text/javascript">
	/* Reopen Lead */
	jQuery(document).ready(function($){
		$("#reopenLead").click(function(e){
			e.preventDefault();
			var ajaxRst;
			var cus_id = $(this).attr("data-customer_id");
			var temp_key = $(this).attr("data-temp_key");
			var response = $("#rr");
			
			if (confirm("Are you sure to reopen lead ?")) {
				if (ajaxRst) {
					ajaxRst.abort();
				}
				ajaxRst =	jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>" + "customers/ajax_reopenLead",
					dataType: 'json',
					data: {customer_id: cus_id, temp_key: temp_key},
					beforeSend: function(){
						response.show().html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
						
					},
					success: function(res) {
						if (res.status == true){
							response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
							location.reload();
						}else{
							response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
							//console.log("error");
						}
					},
					error: function(){
						response.html('<div class="alert alert-danger"><strong>Error! </strong>Please Try again later! </div>');
					}
				});
			}		
		});
	});	
</script>
<script type="text/javascript">
jQuery(document).ready(function($){
	$("#travel_date").datepicker({ startDate: "-2d" });
	//reset all fields
	function resetForm(){
		$("#call_detais_form").find("input[type=text],input[type=number], textarea,select").val("");
		$("#call_detais_form").find('input:checkbox').removeAttr('checked');
		$("#call_detais_form").find('.call_type_not_answer').removeAttr('checked');
		$("#call_detais_form").find('#readyQuotation').removeAttr('checked');
		$("#call_detais_form").find('.quotation_type').removeAttr('checked');
		$("#call_detais_form").find('#nxtCallCk').removeAttr('checked');
		$(".nxt_call").hide();
		
	}
	
	//radio button calltype on change function
	$(document).on("change", ".radio_toggle", function(e){
		e.preventDefault();
		var _this = $(this);
		var section_id = _this.attr("data-id");
		$("#panel_detail_section").show().find("#"+section_id).slideDown();
		$('.call_type_res').not('#' + section_id).hide();
		$("#customer_info_panel").hide();
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
		$("#customer_info_panel").hide();
		//reset form
		$("#call_detais_form").find('.radio_toggle').removeAttr('checked');
		resetForm();
	});
	
	//on picked call select
	var date = new Date();
	date.setDate(date.getDate());
	$(".form_datetime").datetimepicker({
		format: "yyyy-mm-dd HH:ii P",
		showMeridian: true,
		startDate: date,
	});
	
	//show date picker
	$(document).on("change", ".book_query", function(e){
		e.preventDefault();
		var _this = $(this);
		if( _this.val() == 9 ){
			$("#next_call_cal").hide();
			$(".form_datetime").val("");
			$("#quotation_type_section").slideDown();
		}else{
			$("#next_call_cal").show();
			$("#quotation_type_section").hide();
			$("#customer_info_panel").hide();
			$("#call_detais_form").find('.quotation_type').removeAttr('checked');
		}
		
	});	
	
	//show book Query
	$(document).on("change", ".quotation_type", function(e){
		e.preventDefault();
		var _this = $(this);
		if( _this.val() == "holidays" ){
			$(".hide_accommodation").show();
			$("#customer_info_panel").slideDown();
		}else if( _this.val() == "accommodation" ){
			$(".hide_accommodation input, .hide_accommodation select").val("");
			$(".hide_accommodation").hide();
			$("#customer_info_panel").slideDown();
		}else{
			$("#customer_info_panel").slideDown();
		}
	});
	/* $(document).on('click','#nxtCallCk', function() {
		var isChecked = $('#nxtCallCk').prop('checked');
		if ( isChecked ) {
			$("#next_call_cal").show();
		}else{
			$("#next_call_cal").hide();
			$(".form_datetime").val("");
		}	
    }); */
	
	//show next call section if call not picked and number does not exists
	$(".call_type_not_answer").click(function(){
		var _this_val = $(".call_type_not_answer:checked").val();			
		
		if( $(this).is(':checked') && _this_val != "Number does not exists" ) { 
			$(".nxt_call").show();
		}else{
			$(".nxt_call").hide();
		}
	});
	//validate form
	var ajaxReq;
	$("#call_detais_form").validate({
		submitHandler: function(form, event) {
			event.preventDefault();
			$("#submit_frm").attr("disabled", "disabled");
			var formData = $("#call_detais_form").serializeArray();
			var resp = $("#resp");
			console.log(formData);
			//Get call type value
			var callType = $('input[name=callType]:checked').val();
			console.log(callType);
			if (ajaxReq) {
					ajaxReq.abort();
				}
				ajaxReq = $.ajax({
				type: "POST",
				url: "<?php echo base_url('customers/updateCustomerFollowupDeclinedLeads'); ?>",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
				},
				success: function(res) {
					if (res.status == true){
						//resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
						console.log(res);
						location.reload(); 
						
					}else{
						//resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
						console.log("error");
					}
				},
				error: function(e){
					console.log(e);
				}
			});
			return false;
		} 
	});	
	
});
</script>
 <?php }else{
	redirect(404);
 } ?> 