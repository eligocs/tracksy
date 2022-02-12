<?php if( !empty($itinerary[0] ) ){ 			
	$iti = $itinerary[0]; ?>
		<?php $terms = get_hotel_terms_condition();
			if( $terms ){
				$terms = $terms[0];
				$hotel_exc = unserialize($terms->hotel_exclusion);
				$hotel_notes = unserialize($terms->hotel_notes);
				$rates_dates_notes = unserialize($terms->rates_dates_notes);
			}else{
				$hotel_exc = "";
				$hotel_notes = "";
				$rates_dates_notes = "";
			}
		?>

		<style>
		.inner_hotel_repeater{background: pink !important; border: 1px solid blue !important;}
		.help-block.help-block-error {color: red !important}
		.acc_rate_section .form-group {
			margin-left: 0px !important;
			margin-right: 0px !important;
		}
		</style>
	
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Edit Accommodation Package <?php echo $iti->iti_id; ?></div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("itinerary"); ?>" title="Back">Back</a>
					</div>
				</div>
				<div class="portlet light bordered" id="form_wizard_1">
			
				<div class="portlet-body form">
					<form id="acc_frm">
						<div class="form-horizontal" id="itiForm_form">
						<h3 class="package-details-heading">Package details</h3>
						<!--Customer info Section-->
							<?php $get_customer_info = get_customer( $iti->customer_id ); 
							$cust = $get_customer_info[0];
							if( !empty( $get_customer_info ) ){  ?>
								<section class="well">
								<p class="package-details-sub-heading">Customer Details</p>
								<label class="col-md-2">Customer Name:</label>
								<div class="col-md-2">
									<strong><?php if(isset($cust->customer_name)){ echo $cust->customer_name; }?></strong>
								</div>
								<label class="col-md-2">Contact:</label>
								<div class="col-md-2">
									<strong><?php if(isset($cust->customer_contact)){ echo $cust->customer_contact; }?></strong>
								</div>
								<label class="col-md-2">Customer Email:</label>
								<div class="col-md-2">
									<strong><?php if(isset($cust->customer_email)){ echo $cust->customer_email; }?> </strong>
								</div>
								<div class="clearfix"></div>
								<label class="col-md-2">Travel Date:</label>
								<div class="col-md-2">
									<strong><?php if(isset($cust->travel_date)){ echo $cust->travel_date; }?></strong>
								</div>
								<label class="col-md-2">Package Type:</label>
								<?php 
									$pkBy =	$cust->package_type;
									$pack_T = $pkBy == "Other" ? $cust->package_type_other : $pkBy; ?>
								<div class="col-md-6 col-lg-2">
									<strong><?php echo $pack_T;?></strong>
								</div>
								<label class="col-md-2">Destination:</label>
								<div class="col-md-2">
									<strong><?php if(isset($cust->destination)){ echo $cust->destination; }?> </strong>
								</div>
								<div class="clearfix"></div>
								<label class="col-md-2">Meal Plan:</label>
								<div class="col-md-2">
									<strong><?php if(isset($cust->meal_plan)){ echo $cust->meal_plan; }?></strong>
								</div>
								<label class="col-md-2">Hotel Category:</label>
								<div class="col-md-2">
									<strong><?php if(isset($cust->hotel_category)){ echo $cust->hotel_category; }?></strong>
								</div>
								<label class="col-md-2">Budget Approx:</label>
								<div class="col-md-2">
									<strong><?php if(isset($cust->budget)){ echo $cust->budget; }?> </strong>
								</div>
								<div class="clearfix"></div>
								<label class="col-md-2">Total Travellers:</label>
								<div class="col-md-2">
									<strong>Adults: <?php if(isset($cust->adults)){ echo $cust->adults; }?></strong>
									<strong><?php if(isset($cust->child)){ echo "Child: " . $cust->child . "( " . $cust->child_age . " )"; } ?></strong>
								</div>
							</section>
							<?php } ?>
						<!--end Section Customer Section-->
						<!--end Section Customer Section-->
						<?php $get_pub_status = $iti->publish_status; 
							$add_pub_class = $get_pub_status == "publish" ? "clickable_steps" : "";
						?>
						<div class="form-wizard">
							<div class="form-body">
								<ul id="clickable_steps" class="nav nav-pills nav-justified  steps <?php echo $add_pub_class; ?>">
									<li>
										<a href="#tab1" data-toggle="tab" class="step">
											<span class="number"> 1 </span>
											<span class="desc">
												<i class="fa fa-check"></i> Package Overview </span>
										</a>
									</li>
									<li>
										<a href="#tab2" data-toggle="tab" class="step">
											<span class="number"> 2 </span>
											<span class="desc">
												<i class="fa fa-check"></i> Hotel Details </span>
										</a>
									</li>
									<li>
										<a href="#tab3" data-toggle="tab" class="step active">
											<span class="number"> 3 </span>
											<span class="desc">
												<i class="fa fa-check"></i> Inclusion & Exclusion / Rates </span>
										</a>
									</li>
									<li>
										<a href="#tab4" data-toggle="tab" class="step">
											<span class="number"> 4 </span>
											<span class="desc">
												<i class="fa fa-check"></i> Submit Package </span>
										</a>
									</li>
								</ul>
								<div id="bar" class="progress progress-striped" role="progressbar">
									<div class="progress-bar progress-bar-success"> </div>
								</div>
								<div class="tab-content">
									<div class="alert alert-danger display-none">
										<button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
									<!--div class="alert alert-success display-none">
										<button class="close" data-dismiss="alert"></button> Your form validation is successful! </div-->
									<div class="tab-pane active" id="tab1">
										<h3 class="block">Provide Package details</h3>
										
										<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Accommodation Package Name
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="package_name" placeholder="Enter Package Name." value="<?php if(isset($iti->package_name)){ echo $iti->package_name; }?>"/>
											</div>
										</div>
										</div>
										
										<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Hotel At
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<input type="text" title="Hotel Locations" value= "<?php if(isset($iti->package_routing)){ echo $iti->package_routing; }?>" class="form-control" name="package_routing" placeholder="Hotel At." />
											</div>
										</div>
										</div>
										<div class="clearfix"></div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">No. Persons
													<span class="required"> * </span>
												</label>
												<div class="col-md-2">
													<input type="text" required title="Total Adults" class="form-control" name="adults" value="<?php if(isset($iti->adults)){ echo $iti->adults; } ?>" placeholder="Total no. of  adults eg: 2" />
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" title="Total Child" name="child" value="<?php if(isset($iti->child)){ echo $iti->child; } ?>" placeholder="Total child" />
												</div>
												<div class="col-md-4">
												<input type="text" title="Child age Seprated by comma" class="form-control" name="child_age" value="<?php if(isset($iti->child_age)){ echo $iti->child_age; } ?>" placeholder="child age: eg. 12,15,18." />
												</div>
												
											</div>
										</div>
										
										<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Package Type
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<select required name="iti_package_type" class="form-control">
													<option value="">Choose Package Type</option>
													<option <?php echo isset($iti->iti_package_type) && $iti->iti_package_type == "Honeymoon Package" ? 'selected' : '' ?> value="Honeymoon Package">Honeymoon Package</option>
													<option <?php echo isset($iti->iti_package_type) && $iti->iti_package_type == "Fixed Departure" ? 'selected' : '' ?> value="Fixed Departure">Fixed Departure</option>
													<option <?php echo isset($iti->iti_package_type) && $iti->iti_package_type == "Group Package" ? 'selected' : '' ?> value="Group Package">Group Package</option>
													<option <?php echo isset($iti->iti_package_type) && $iti->iti_package_type == "Other" ? 'selected' : '' ?> value="Other">Other</option>
												</select>
											</div>
										</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="tab-pane removeMargin" id="tab2">
										<h3 class="block">Hotel Details</h3>
										<div class="row">
										<div class="col-md-4 form-group">
											<div class="form-group">
												<label class="control-label">Package Start Date*</label>
												<input readonly required type="text" data-date="" data-date-format="dd/mm/yyyy" class="form-control" id="hotel_startdate" name="hotel_startdate" value="<?php if(isset($iti->t_start_date)){ echo $iti->t_start_date; } ?>">
											</div>
										</div>
										
										<div class="col-md-4 form-group">
											<div class="form-group">
												<label class="control-label">Package End Date*</label>
												<input readonly required  data-date="" data-date-format="dd/mm/yyyy" type="text" class="form-control" id="hotel_enddate" name="hotel_enddate" value="<?php if(isset($iti->t_end_date)){ echo $iti->t_end_date; } ?>"> 
											</div>
										</div>
										<div  class="col-md-4 form-group"><label class="control-label">Total Nights* </label>
											<input readonly type="text" class="form-control" id = "package_duration" name="package_duration" placeholder="Total Nights" value="<?php if(isset($iti->total_nights)){ echo $iti->total_nights; } ?>"/>
										</div>
										</div>
										<div class="clearfix"></div>
										<div class="mt-repeater-hotel tour_hotel_repeater">
											<div data-repeater-list="hotel_meta" class="hotel_repeater">
											<?php $hotel_meta = unserialize( $iti->hotel_meta ); 
												$count_hotel = count( $hotel_meta );
												//print_r( $hotel_meta );
												if( !empty( $hotel_meta ) ){ ?>
													<input type="hidden" id="edit_type" value="edit">
													<?php for ( $i = 0; $i < $count_hotel; $i++ ) { ?>
													<div data-repeater-item class="mt-repeater-hotel-item">
														<div class="row">
															<div class='mt-repeater-hotel-input  col-md-3'>
																<label><strong>Hotel City:</strong></label>
																<input required type="text" name='hotel_location' value="<?php if( isset( $hotel_meta[$i]['hotel_location'] ) ) { echo $hotel_meta[$i]['hotel_location']; } ?>" class='form-control' placeholder="Eg. Shimla/Manali">
															</div>
															<div class="mt-repeater-hotel-input col-md-3">
																<label class="control-label">Check in Date*</label>
																<input readonly required type="text" class="form-control check_in" name="check_in" value="<?php if( isset( $hotel_meta[$i]['check_in'] ) ) { echo $hotel_meta[$i]['check_in']; } ?>">
															</div>
															<div class="mt-repeater-hotel-input col-md-3">
																<label class="control-label">Checkout Date*</label>
																<input readonly required data-date="" data-date-format="dd/mm/yyyy" type="text" class="form-control ckinout check_out" name="check_out" value="<?php if( isset( $hotel_meta[$i]['check_out'] ) ) { echo $hotel_meta[$i]['check_out']; } ?>">
															</div>	
															
															<div class='mt-repeater-hotel-input col-md-3' >
																<label><strong>Total Rooms:</strong></label>
																<select required name="total_room" class="form-control">
																	<option value="">Select Rooms</option>
																	<?php for( $ii=1 ; $ii <=20 ; $ii++ ){ ?>
																		<option <?php if ( $hotel_meta[$i]['total_room'] == $ii  ) { ?> selected="selected" <?php } ?> value="<?php echo $ii; ?>"><?php echo $ii; ?></option>
																	<?php } ?>	
																</select>
															</div>
															
															<?php $check_extraBed = isset( $hotel_meta[$i]['extra_bed'] ) && !empty( $hotel_meta[$i]['extra_bed'] ) ? $hotel_meta[$i]['extra_bed'] : ""; ?>
															<?php $ostyle = !empty( $check_extraBed ) ? "block" : "none"; ?>
															<div class='mt-repeater-hotel-input col-md-2' >
																<label>Extra Bed: </label><br>
																<label><input type="checkbox" class="extraCheck" <?php echo !empty( $check_extraBed ) ? "checked='checked'" : ""; ?> value="Yes">Click Here to Add extra bed.</label>
																<select required name="extra_bed" class="form-control extra_bed" style="display: <?php echo $ostyle; ?>;">
																	<option value="">Select Extra Bed</option>
																	<?php for( $eb=1 ; $eb <=20 ; $eb++ ){ ?>
																		<option <?php if( $check_extraBed == $eb ){ echo "selected='selected'"; } ?> value="<?php echo $eb; ?>"><?php echo $eb; ?></option>
																	<?php } ?>	
																</select>
															</div>
															
															<div class='mt-repeater-hotel-input  col-md-1' >
																<label><strong>Nights:</strong></label>
																<input required readonly type="number" name='total_nights' class='form-control total_nights' placeholder="" value="<?php if( isset( $hotel_meta[$i]['total_nights'] ) ) { echo $hotel_meta[$i]['total_nights']; } ?>" >
															</div>
															
															<?php 
															$hotel_inner_meta = $hotel_meta[$i]["hotel_inner_meta"];
																//Fetch hotel inner meta
																$count_innermeta = count( $hotel_inner_meta );
																//print_r($hotel_inner_meta); ?>
															<div class="mt-innerrepeater-hotel inner_hotel_repeater">
																<div data-repeater-list="hotel_inner_meta" class="clearfix hotel_inner">
																	<?php if( !empty( $count_innermeta ) ){ ?>
																		<?php for( $ii = 0 ; $ii < $count_innermeta ; $ii++ ){ 
																			$hotl_cat	= isset($hotel_inner_meta[$ii]["hotel_category"] ) && !empty( $hotel_inner_meta[$ii]['hotel_category'] ) ? $hotel_inner_meta[$ii]["hotel_category"] : "";
																			
																			$room_category 	= isset($hotel_inner_meta[$ii]["room_category"] )&& !empty( $hotel_inner_meta[$ii]['room_category'] ) ? $hotel_inner_meta[$ii]["room_category"] : "";
																			
																			$hotel_name 	= isset($hotel_inner_meta[$ii]["hotel_name"] )&& !empty( $hotel_inner_meta[$ii]['hotel_name'] ) ? $hotel_inner_meta[$ii]["hotel_name"] : "";
																			
																			$meal_plan 		= isset($hotel_inner_meta[$ii]["meal_plan"] )&& !empty( $hotel_inner_meta[$ii]['meal_plan'] ) ? $hotel_inner_meta[$ii]["meal_plan"] : "";
																		?>	
																		<div data-repeater-item class="mt-innerrepeater-hotel-item" >
																			<div class='mt-innerrepeater-hotel-input col-md-3' >
																				<label><strong>Hotel Category:</strong></label>
																				<select required name="hotel_category" class="form-control">
																					<option value="">Choose Package Category</option>
																					<option <?php if ( $hotl_cat == "Standard")  { ?> selected="selected" <?php } ?> value="Standard">Deluxe</option>
																					<option <?php if ( $hotl_cat == "Deluxe") { ?> selected="selected" <?php } ?> value="Deluxe">Super Deluxe</option>
																					<option <?php if ( $hotl_cat == "Super Deluxe")  { ?> selected="selected" <?php } ?> value="Super Deluxe">Luxury</option>
																					<option <?php if ( $hotl_cat == "Luxury") { ?> selected="selected" <?php } ?> value="Luxury">Super Luxury</option>
																				</select>
																			</div>
																			
																			<div class='mt-innerrepeater-hotel-input super_deluxe   col-md-3' >
																				<label><strong>Hotel:</strong></label>
																				<textarea name="hotel_name" required class='form-control'><?php echo $hotel_name; ?></textarea>
																			</div>
																			
																			<div class='mt-innerrepeater-hotel-input col-md-2' >
																				<label><strong>Room Category:</strong></label>
																				<select required name="room_category" class="form-control">
																					<option value="">Choose Room Category</option>
																					<option <?php if ( $room_category == "Standard") { ?> selected="selected" <?php } ?> value="Standard">Standard</option>
																					<option <?php if ( $room_category == "Deluxe") { ?> selected="selected" <?php } ?> value="Deluxe">Deluxe</option>
																					<option <?php if ( $room_category == "Super Deluxe") { ?> selected="selected" <?php } ?> value="Super Deluxe">Super Deluxe</option>
																					<option <?php if ( $room_category == "Luxury") { ?> selected="selected" <?php } ?> value="Luxury">Luxury</option>
																					<option <?php if ( $room_category == "Family Sweet") { ?> selected="selected" <?php } ?> value="Family Sweet">Family Sweet</option>
																				</select>
																			</div>
																			<div class='mt-innerrepeater-hotel-input col-md-2' >
																				<label><strong>Choose Meal Plan:</strong></label>
																				<select required name="meal_plan" class="form-control">
																					<option value="">Choose Meal Plan</option>
																					<option <?php if ( $meal_plan == "MAP") { ?> selected="selected" <?php } ?> value="MAP">MAP</option>
																					<option <?php if ( $meal_plan == "CP") { ?> selected="selected" <?php } ?> value="CP">CP</option>
																					<option <?php if ( $meal_plan == "EP") { ?> selected="selected" <?php } ?> value="EP">EP</option>
																					<option <?php if ( $meal_plan == "API") { ?> selected="selected" <?php } ?> value="API">API</option>
																					<option <?php if ( $meal_plan == "No Meals") { ?> selected="selected" <?php } ?> value="No Meals">No Meals</option>
																				</select>
																			</div>
																			<div class="mt-innerrepeater-hotel-input col-md-2">
																				<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-innerrepeater-delete">
																					<i class="fa fa-close"></i> Delete</a>
																			</div>
																				<div class="clearfix"></div>
																		</div>
																		<?php } ?><!--Inner for loop-->
																</div>
																	<div class="clearfix"></div>
																	<a href="javascript:;" data-repeater-create class="clearfix btn btn-success">
																	<i class="fa fa-plus"></i>Add New</a>
																</div>
															<?php } ?>	<!--inner meta-->
															<div class="clearfix"></div>
															<div class="mt-repeater-hotel-input col-md-1">
																<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																	<i class="fa fa-close"></i> Delete</a>
															</div>
														</div> 
														<hr>
													</div>
														
													<?php } ?> <!--outer for loop -->
												<?php }else{ ?>	
													<input type="hidden" id="edit_type" value="add">
													<div data-repeater-item class="mt-repeater-hotel-item">
														<div class="row">
															<div class='mt-repeater-hotel-input  col-md-3' >
																<label><strong>Hotel City:</strong></label>
																<input required type="text" name='hotel_location' class='form-control' placeholder="Eg. Shimla/Manali">
															</div>
															<div class="mt-repeater-hotel-input col-md-2">
																<label class="control-label">Check in Date*</label>
																<input readonly required type="text" class="form-control check_in" name="check_in" value="">
															</div>
															<div class="mt-repeater-hotel-input col-md-2">
																<label class="control-label">Checkout Date*</label>
																<input readonly required data-date="" data-date-format="dd/mm/yyyy" type="text" class="form-control ckinout check_out" name="check_out" value="">
															</div>	
															<div class='mt-repeater-hotel-input col-md-2' >
																<label><strong>Total Rooms:</strong></label>
																<select required name="total_room" class="form-control">
																	<option value="">Select Rooms</option>
																	<?php for( $i=1 ; $i <=20 ; $i++ ){ ?>
																		<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
																	<?php } ?>	
																</select>
															</div>
															<div class='mt-repeater-hotel-input  col-md-1' >
																<label><strong>Extra Bed:</strong></label><br>
																<label><input type="checkbox" class="extraCheck" value="Yes">Click Here to Add extra bed.</label>
																<select required name="extra_bed" class="form-control extra_bed" style="display: none;">
																	<option value="">Select Extra Bed</option>
																	<?php for( $eb=1 ; $eb <=20 ; $eb++ ){ ?>
																		<option value="<?php echo $eb; ?>"><?php echo $eb; ?></option>
																	<?php } ?>	
																</select>
															</div>
															<div class='mt-repeater-hotel-input  col-md-1' >
																<label><strong>Nights:</strong></label>
																<input required readonly type="number" name='total_nights' class='form-control total_nights' placeholder="">
															</div>
															<div class="mt-innerrepeater-hotel inner_hotel_repeater">
																<div data-repeater-list="hotel_inner_meta" class="clearfix hotel_inner">
																	<div data-repeater-item class="mt-innerrepeater-hotel-item" >
																		<div class='mt-innerrepeater-hotel-input col-md-3' >
																			<label><strong>Hotel Category:</strong></label>
																			<select required name="hotel_category" class="form-control hotel_rate_cat">
																				<option value="">Choose Package Category</option>
																				<option value="Standard">Deluxe</option>
																				<option value="Deluxe">Super Deluxe</option>
																				<option value="Super Deluxe">Luxury</option>
																				<option value="Luxury">Super Luxury</option>
																			</select>
																		</div>
																		<div class='mt-innerrepeater-hotel-input col-md-3' >
																			<label><strong>Hotel:</strong></label>
																			<textarea name="hotel_name" required class='form-control'></textarea>
																		</div>
																		<div class='mt-innerrepeater-hotel-input col-md-2' >
																			<label><strong>Room Category:</strong></label>
																			<select required name="room_category" class="form-control">
																				<option value="">Choose Room Category</option>
																				<option value="Standard">Standard</option>
																				<option value="Deluxe">Deluxe</option>
																				<option value="Super Deluxe">Super Deluxe</option>
																				<option value="Luxury">Luxury</option>
																			</select>
																		</div>
																		<div class='mt-innerrepeater-hotel-input col-md-2' >
																			<label><strong>Choose Meal Plan:</strong></label>
																			<select required name="meal_plan" class="form-control">
																				<option value="">Choose Meal Plan</option>
																				<option value="MAP">MAP</option>
																				<option value="CP">CP</option>
																				<option value="EP">EP</option>
																				<option value="API">API</option>
																				<option value="No Meals">No Meals</option>
																			</select>
																		</div>
																		<div class="mt-innerrepeater-hotel-input col-md-2">
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-innerrepeater-delete">
																				<i class="fa fa-close"></i> Delete</a>
																		</div>
																		<div class="clearfix"></div>
																	</div>
																</div>
																<div class="clearfix"></div>
																<a href="javascript:;" data-repeater-create class="clearfix btn btn-success">
																<i class="fa fa-plus"></i>Add New</a>
															</div><!--End inner repeater-->
															
															<div class="mt-repeater-hotel-input col-md-1">
																<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																	<i class="fa fa-close"></i> Delete</a>
															</div>
														</div> <!-- row -->
													<hr>
													</div>
												<?php } ?>	
											</div>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-hotel-add">
											<i class="fa fa-plus"></i> Add Hotel</a>
											<hr>
										</div>
										<div class="mt-repeater-hotel-note tour_field_repeater">
											<div data-repeater-list="hotel_note_meta">
												<div class="col-md-12"><label class="control-label">Add Hotel Note: </label></div>
												<?php  $hotel_note_meta = unserialize($iti->hotel_note_meta); 
												$count_hotel_meta = count( $hotel_note_meta );
												if( !empty($hotel_note_meta) ){
													for ( $i = 0; $i < $count_hotel_meta; $i++ ) { ?>
														<div data-repeater-item class="mt-repeater-hotel-note-item form-group">
															<!-- jQuery Repeater Container -->
															<div class="mt-repeater-hotel-note-input col-md-9">
																<div class="mt-repeater-hotel-note-input">
																	<input required type="text" name="hotel_note" class="form-control" value="<?php echo $hotel_note_meta[$i]["hotel_note"] ?>" /> 
																</div>
															</div>
															<div class="clearfix"></div>
															<div class="mt-repeater-hotel-note-input col-md-3">
																<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																<i class="fa fa-close"></i> Delete</a>
															</div>
														</div>
													<?php } 
												}else{ ?>		
												<?php $count_hotel_notes = count( $hotel_notes );
													if( !empty( $hotel_notes ) ){ ?>
														<?php for ( $i = 0; $i < $count_hotel_notes; $i++ ) { ?>
															<div data-repeater-item class="mt-repeater-hotel-note-item form-group">
																<!-- jQuery Repeater Container -->
																<div class="mt-repeater-hotel-note-input col-md-9">
																	<div class="mt-repeater-hotel-note-input">
																		<input required type="text" name="hotel_note_meta[<?php echo $i; ?>][hotel_note]" class="form-control" value="<?php echo $hotel_notes[$i]["hotel_notes"] ;?>" /> 
																	</div>
																</div>
																<div class="clearfix"></div>
																<div class="mt-repeater-hotel-note-input col-md-3">
																	<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																	<i class="fa fa-close"></i> Delete</a>
																</div>
															</div>
														<?php } ?>	
													<?php }else{ ?>
														<div data-repeater-item class="mt-repeater-hotel-note-item form-group">
															<!-- jQuery Repeater Container -->
															<div class="mt-repeater-hotel-note-input col-md-9">
																<div class="mt-repeater-hotel-note-input">
																	<input required type="text" name="hotel_note" class="form-control" value="" /> 
																</div>
															</div>
															<div class="clearfix"></div>
															<div class="mt-repeater-hotel-note-input col-md-3">
																<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																<i class="fa fa-close"></i> Delete</a>
															</div>
														</div>
													<?php } ?>	
												<?php } ?>	
											</div>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-hotel-note">
											<i class="fa fa-plus"></i> Add Note</a>
										</div>
									</div>
									<div class="tab-pane" id="tab3">
										<h3 class="block">Inclusion & Exclusion</h3>
										<div class="col-md-6">
											<div class="mt-repeater-inc tour_field_repeater">
												<h4>Inclusion</h4>
												<div data-repeater-list="inc_meta">
													<?php
													$inclusion = unserialize($iti->inc_meta); 
													$count_inc = count( $inclusion );
													if( !empty($inclusion) ){ 
														for ( $i = 0; $i < $count_inc; $i++ ) {		?>
																<div data-repeater-item class="mt-repeater-inc-item form-group">
																	<div class="mt-repeater-inc-cell">
																		<div class="mt-repeater-inc-input col-md-9">
																			<input required type="text" name="tour_inc" class="form-control" value="<?php echo $inclusion[$i]["tour_inc"]; ?>" /> 
																		</div>
																		<div class="mt-repeater-inc-input col-md-3">
																			<a href="javascript:;" title="delete" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																				<i class="fa fa-close"></i></a>
																		</div>
																	</div>
																</div>
															
														<?php } ?>
													<?php }else{ ?>	
														<div data-repeater-item class="mt-repeater-inc-item form-group">
															<div class="mt-repeater-inc-cell">
																<div class="mt-repeater-inc-input col-md-9">
																	<input required type="text" name="tour_inc" class="form-control" value="" /> 
																</div>
																<div class="mt-repeater-inc-input col-md-3">
																	<a href="javascript:;" title="delete" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																		<i class="fa fa-close"></i></a>
																</div>
															</div>
														</div>
														
													<?php }?>	
												</div>	
												<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-inc-add">
												<i class="fa fa-plus"></i> Add</a>
											</div>
											<div class="clearfix"></div>
											<div class="col-md-12">
												<!--Special Inclusion Section-->
												<div class="col-md-12">
													<div class="mt-repeater-spinc tour_field_repeater_sp">
														<h3 class="block">Special Inclusions</h3>
														<div data-repeater-list="special_inc_meta">
															<?php 
																$sp_inc = unserialize( $iti->special_inc_meta ); 
																$count_sp_inc = count( $sp_inc );
																if( !empty($sp_inc) ){ 
																	for ( $i = 0; $i < $count_sp_inc; $i++ ) {		?>
																		<div data-repeater-item class="mt-repeater-spinc-item form-group">
																			<div class="mt-repeater-spinc-cell">
																				<div class="mt-repeater-spinc-input col-md-9">
																					<input required type="text" name="special_inc_meta[<?php echo $i; ?>][tour_special_inc]" class="form-control" value="<?php if( isset($sp_inc[$i]["tour_special_inc"]) ) { echo $sp_inc[$i]["tour_special_inc"] ; } ?>" /> 
																				</div>
																				<div class="mt-repeater-spinc-input col-md-3">
																					<a href="javascript:;" title="delete" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																						<i class="fa fa-close"></i></a>
																				</div>
																			</div>
																		</div>
																	<?php } ?>
																<?php }else{ ?>
																	<div data-repeater-item class="mt-repeater-spinc-item form-group">
																		<div class="mt-repeater-spinc-cell">
																			<div class="mt-repeater-spinc-input col-md-9">
																				<input required type="text" name="tour_special_inc" class="form-control" value="" /> 
																			</div>
																			<div class="mt-repeater-spinc-input col-md-3">
																				<a href="javascript:;" title="delete" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																					<i class="fa fa-close"></i></a>
																			</div>
																		</div>
																	</div>
																<?php } ?>
														</div><br>
														<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-spinc-add">
														<i class="fa fa-plus"></i> Add</a>
													</div>
												</div><!--END Special Inclusion-->
												<div class="clearfix"></div>
												<hr>
												<!--BENEFITES OF BOOK WITH SY-->
												<div class="col-md-12">
													<div class="mt-repeater-spinc tour_field_repeater_sp">
														<h3 class="block">Benefits of Booking With Us </h3>
														<div data-repeater-list="booking_benefits_meta">
															<?php 
																$benefits_inc = unserialize( $iti->booking_benefits_meta ); 
																$count_benefit_inc = count( $benefits_inc );
																if( !empty($benefits_inc) ){ 
																	for ( $i = 0; $i < $count_benefit_inc; $i++ ) {		?>
																		<div data-repeater-item class="mt-repeater-spinc-item form-group">
																			<div class="mt-repeater-spinc-cell">
																				<div class="mt-repeater-spinc-input col-md-9">
																					<input required type="text" name="booking_benefits_meta[<?php echo $i; ?>][benefit_inc]" class="form-control" value="<?php if( isset($benefits_inc[$i]["benefit_inc"]) ) { echo $benefits_inc[$i]["benefit_inc"] ; } ?>" /> 
																				</div>
																				<div class="mt-repeater-spinc-input col-md-3">
																					<a href="javascript:;" title="delete" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																						<i class="fa fa-close"></i></a>
																				</div>
																			</div>
																		</div>
																	<?php } ?>
																<?php }else{
																	$get_booking_benefits = get_booking_benefits();
																	$count_ben_m = count( $get_booking_benefits );
																	if( $count_ben_m > 0 ){ ?>
																		<?php for ( $i = 0; $i < $count_ben_m; $i++ ) { ?>
																			<div data-repeater-item class="mt-repeater-exc-item form-group">
																				<!-- jQuery Repeater Container -->
																				<div class="mt-repeater-exc-input col-md-9">
																					<input required type="text" name="booking_benefits_meta[<?php echo $i; ?>][benefit_inc]" class="form-control" value="<?php echo $get_booking_benefits[$i]["benefit_inc"] ;?>" /> 
																				</div>
																				
																				<div class="mt-repeater-exc-input col-md-3">
																					<a title="delete" href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																						<i class="fa fa-close"></i> </a>
																				</div>
																			</div>
																		<?php } ?>
																	<?php }else{ ?>	
																	<div data-repeater-item class="mt-repeater-spinc-item form-group">
																		<div class="mt-repeater-spinc-cell">
																			<div class="mt-repeater-spinc-input col-md-9">
																				<input required type="text" name="benefit_inc" class="form-control" value="" /> 
																			</div>
																			<div class="mt-repeater-spinc-input col-md-3">
																				<a href="javascript:;" title="delete" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																					<i class="fa fa-close"></i></a>
																			</div>
																		</div>
																	</div>
																<?php } ?>
															<?php } ?>
														</div><br>
														<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-spinc-add">
														<i class="fa fa-plus"></i> Add</a>
													</div>
												</div><!-- END BENEFITES OF BOOK WITH SY-->
											</div>	
										</div>	
										<div class="col-md-6">
											<div class="mt-repeater-exc tour_field_repeater">
												<h4>Exclusion</h4>
												<div data-repeater-list="exc_meta">  
												<?php 
													$exclusion = unserialize($iti->exc_meta); 
													$count_exc = count( $exclusion );
													if( !empty($exclusion) ){ 
														for ( $i = 0; $i < $count_exc; $i++ ) {		?>
															<div data-repeater-item class="mt-repeater-exc-item form-group">
																<!-- jQuery Repeater Container -->
																<div class="mt-repeater-exc-input col-md-9">
																	<input required type="text" name="exc_meta[<?php echo $i; ?>][tour_exc]" class="form-control" value="<?php echo $exclusion[$i]["tour_exc"] ;?>" /> 
																</div>
																
																<div class="mt-repeater-exc-input col-md-3">
																	<a title="delete" href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																		<i class="fa fa-close"></i> </a>
																</div>
															</div>
														<?php } ?>	
													<?php }else{ ?>	
														<?php $count_hotel_exc	= count( $hotel_exc );
														if( !empty( $hotel_exc ) ){ ?>
															<?php for ( $i = 0; $i < $count_hotel_exc; $i++ ) { ?>
																<div data-repeater-item class="mt-repeater-exc-item form-group">
																	<!-- jQuery Repeater Container -->
																	<div class="mt-repeater-exc-input col-md-9">
																		<input required type="text" name="exc_meta[<?php echo $i; ?>][tour_exc]" class="form-control" value="<?php echo $hotel_exc[$i]["hotel_exc"] ;?>" /> 
																	</div>
																	<div class="clearfix"></div>
																	<div class="mt-repeater-exc-input col-md-3">
																		<a title="delete" href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																			<i class="fa fa-close"></i> </a>
																	</div>
																</div>
															<?php } ?>
														<?php }else{ ?>	
															<div data-repeater-item class="mt-repeater-exc-item form-group">
																<!-- jQuery Repeater Container -->
																<div class="mt-repeater-exc-input col-md-9">
																	<input required type="text" name="tour_exc" class="form-control" value="" /> 
																</div>
																<div class="clearfix"></div>
																<div class="mt-repeater-exc-input col-md-3">
																	<a title="delete" href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete"><i class="fa fa-close"></i> </a></div>
															</div>
														<?php } ?>	
													<?php } ?>	
												</div>
												<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
												<i class="fa fa-plus"></i> Add</a>
											</div>
										</div>
										<div class="clearfix"></div>
										<hr>
										<?php 
										//if ( is_admin_or_manager() && $iti->publish_status == "publish"  ){
										if ( ( $user_role == 99 || is_cost_manager() || is_super_manager() || is_sales_manager() ) && $iti->publish_status == "publish"  ){
											$rates_meta = unserialize($iti->rates_meta);
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
											<!--Rate Meta-->
											<div class="row acc_rate_section">
												<div class='mt-repeater-hotel-input form-group col-md-12' >
													<p class="text-center"><strong style="font-size: 22px;">Rates: </strong></p>
												</div>
												<div class='mt-repeater-hotel-input standard  form-group col-md-3' >
													<label><strong>Deluxe:</strong></label>
													<input <?php echo $st_req; ?> name="rate_meta[standard_rates]" type="number" class='form-control' value="<?php if(isset( $rates_meta["standard_rates"] )) echo $rates_meta["standard_rates"]; ?>" ></input>
												</div>
												
												<div class='mt-repeater-hotel-input deluxe form-group col-md-3' >
													<label><strong>Super Deluxe:</strong></label>
													<input value="<?php if(isset( $rates_meta["deluxe_rates"] )) echo $rates_meta["deluxe_rates"]; ?>" <?php echo $d_req; ?> name="rate_meta[deluxe_rates]" type="number" class='form-control'></input>
												</div>
												<div class='mt-repeater-hotel-input super_deluxe form-group col-md-3' >
													<label><strong>Luxury:</strong></label>
													<input <?php echo $sd_req; ?> value="<?php if(isset( $rates_meta["super_deluxe_rates"] )) echo $rates_meta["super_deluxe_rates"]; ?>" name="rate_meta[super_deluxe_rates]" type="number" class='form-control'></input>
												</div>
												<div class='mt-repeater-hotel-input luxury form-group col-md-3' >
													<label><strong>Super Luxury:</strong></label>
													<input <?php echo $l_req; ?> value="<?php if(isset( $rates_meta["luxury_rates"] )) echo $rates_meta["luxury_rates"]; ?>" name="rate_meta[luxury_rates]" type="number" class='form-control'></input>
												</div>
												<?php 	
												//get per person price
												$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
												$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ?$per_person_ratemeta["standard_rates"] : "";
												$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? $per_person_ratemeta["deluxe_rates"] : "";
												$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? $per_person_ratemeta["super_deluxe_rates"] : "";
												$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? $per_person_ratemeta["luxury_rates"] : ""; 
												
												//child rates
												$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ?$per_person_ratemeta["child_standard_rates"] : "";
												$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? $per_person_ratemeta["child_deluxe_rates"] : "";
												$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? $per_person_ratemeta["child_super_deluxe_rates"] : "";
												$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? $per_person_ratemeta["child_luxury_rates"] : ""; 
												
												//check if per/person rate exists
												$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? 1 : 0;
												$check_perperson = !empty( $s_pp ) ||  !empty( $d_pp ) ||  !empty( $sd_pp ) ||  !empty( $l_pp ) ? 1 : 0; 
												$below_base_price = isset( $per_person_ratemeta["below_base_price"] ) && $per_person_ratemeta["below_base_price"] == 1 ? 1 : 0;
												?>
												
												<div class='mt-repeater-hotel-input luxury form-group col-md-6' >
													<label><strong>Rate Comment*:</strong></label>
													<textarea required name="rate_comment"class='form-control'><?php if(isset( $iti->rate_comment )) echo $iti->rate_comment; ?></textarea>
												</div>
												
												<!--div class='form-group col-md-2' >
													<label><strong>GST Inc.:</strong></label>
													<input type="checkbox" value="<?php //echo $inc_gst; ?>" class='form-control' <?php //echo !empty($inc_gst) ? "checked='checked'" : "" ; ?> id="incgst"></input>
												</div-->
												<div class='form-group col-md-2' >
															<label><strong>Below Base Price.:</strong></label>
															<input type="checkbox" <?php echo !empty($below_base_price) ? "checked='checked'" : "" ; ?> value="<?php echo $below_base_price; ?>" title="Check if price is below Base Price" class='form-control' id="below_bp"></input>
															
															<input name="per_person_ratemeta[below_base_price]" type="hidden" value="<?php echo $below_base_price; ?>" class='form-control below_bp'></input>
															</div>
												<input name="per_person_ratemeta[inc_gst]" type="hidden" value="1" class='form-control incgst'></input>
												
												<div class='form-group col-md-2' >
													<label><strong>Add Per/Person Rate:</strong></label> <!--inc_gst 1 = true -->
													<input type="checkbox" class='form-control' <?php echo !empty($check_perperson) ? "checked='checked'" : ""; ?> id="per_person_rate" ></input>
												</div>
													
												<div class="clearfix"></div>
												<!--perperson rate meta -->
												<div class="col-md-12 perperson_section" style="display: <?php echo !empty( $check_perperson ) ? "block" : "none"; ?>">
													<div class='standard  form-group col-md-3' >
														<label><strong>Deluxe (Per/Person):</strong></label>
														<input <?php echo $st_req; ?> name="per_person_ratemeta[standard_rates]" type="number" class='form-control' value="<?php echo $s_pp; ?>" placeholder="Deluxe Per/Person Cost"></input>
													</div>
													<div class='deluxe form-group col-md-3' >
														<label><strong>Super Deluxe (Per/Person):</strong></label>
														<input <?php echo $d_req; ?> name="per_person_ratemeta[deluxe_rates]" type="number"  value="<?php echo $d_pp; ?>" class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
													</div>
													<div class='super_deluxe form-group col-md-3' >
														<label><strong>Luxury (Per/Person):</strong></label>
														<input <?php echo $sd_req; ?> name="per_person_ratemeta[super_deluxe_rates]" type="number"  value="<?php echo $sd_pp; ?>" class='form-control' placeholder="Luxury Per/Person Cost"></input>
													</div>
													<div class='luxury form-group col-md-3' >
														<label><strong>Super Luxury (Per/Person):</strong></label>
														<input <?php echo $l_req; ?> name="per_person_ratemeta[luxury_rates]" type="number"  value="<?php echo $l_pp; ?>" class='form-control' placeholder="Super Deluxe Per/Person Cost"></input>
													</div>
													
													<!--child rate-->
													<div class='standard  form-group col-md-3' >
														<label><strong  class="red">Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
														<input <?php echo $st_req; ?> value="<?php echo $child_s_pp; ?>" name="per_person_ratemeta[child_standard_rates]" type="number"  class='form-control' placeholder="Deluxe Per/child Cost"></input>
													</div>
													
													<div class='deluxe form-group col-md-3' >
														<label><strong class="red">Super Deluxe (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
														<input <?php echo $d_req; ?> value="<?php echo $child_d_pp; ?>" name="per_person_ratemeta[child_deluxe_rates]" type="number"  class='form-control' placeholder="Super Deluxe Per/child Cost"></input>
													</div>
													<div class='super_deluxe form-group col-md-3' >
														<label><strong  class="red">Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
														<input <?php echo $sd_req; ?> value="<?php echo $child_sd_pp; ?>" name="per_person_ratemeta[child_super_deluxe_rates]" type="number" class='form-control' placeholder="Luxury Per/child Cost"></input>
													</div>
													<div class='luxury form-group col-md-3' >
														<label><strong  class="red">Super Luxury (Per/child):</strong><span style="font-size:10px; color: red;"> ( Leave empty if not exists)</span></label>
														<input <?php echo $l_req; ?> value="<?php echo $child_l_pp; ?>" name="per_person_ratemeta[child_luxury_rates]" type="number" class='form-control' placeholder="Super Deluxe Per/child Cost"></input>
													</div>
												</div>
												<!--end perperson rate meta -->
											</div> <!-- row rate section-->
										<?php } ?>
									</div>

									<div class="tab-pane" id="tab4">
										<div class="verify_msg">
											<p>You can review your inputs by clicking on Back Button. To save this Package Click on Submit Button.</p>
										</div>
									</div>
									
									</div>
									
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9 text-right">
										<a href="javascript:;" class="btn default button-previous">
											<i class="fa fa-angle-left"></i> Back </a>
										<a href="javascript:;" class="btn btn-outline green button-next"> Save & Continue
											<i class="fa fa-angle-right"></i>
										</a>
										<a href="javascript:;" id="SubmitForm" class="btn green button-submit">Submit</a>
									<!--input type="submit" class="btn green button-submit" value="Submit"-->
										
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" value="<?php echo $iti->agent_id ?>" name="agent_id">
						<input type="hidden" value="<?php echo $iti->customer_id ?>" name="customer_id">
						<input id="unique_key" type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
						<input id="iti_id" type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
						<!--Itinerary type 1=holidayz package, 2= accommondation package-->
						<input id="iti_type" type="hidden" value="2" name="iti_type">
					</form>	
					<div id="res"></div>
			</div>
			</div>
 
	</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($){
	<!--show rate perperson section -->
	$(document).on("click", "#per_person_rate", function(e){
		if($(this).is(":checked"))   
			$(".perperson_section").show();
		else
			$(".perperson_section").hide();
	});
	$(document).on("click", "#incgst", function(e){
		if($(this).is(":checked"))   
			$(".incgst").val(1);
		else
			$(".incgst").val(0);
	});
	//Extra bed
	$('.extraCheck').each(function() {
		$(document).on("click",".extraCheck",function(){
			if ($(this).is(":checked")) {
				$(this).closest("div").find(".extra_bed").show();
			}else{
				$(this).closest("div").find(".extra_bed").val("").hide();
			}
		});	
	});
	//submit form
	$("#SubmitForm").click(function(){
		var formData = $('#acc_frm').serializeArray();
		var resp = $("#res");
		var ajaxReq;
		if (ajaxReq) {
			ajaxReq.abort();
		}
		ajaxReq = $.ajax({
			type: "POST",
			url: "<?php echo base_url('itineraries/addItinerary'); ?>",
		   data: formData,
		   dataType: "json",
			beforeSend: function(){
				resp.html('<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
			},
			success: function(res) {
				if (res.status == true){
					resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
					console.log("done");
					$('#acc_frm')[0].reset();
					//console.log(res.msg);
					window.location.href = "<?php echo site_url('itineraries/view/');?>" + res.iti_id + "/" + res.temp_key; 
					
				}else{
					resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
					//console.log("error");
				}
			},
			error: function(e){
				console.log(e);
				resp.html('<div class="alert alert-danger"><strong>Error!</strong> Please Try again later! </div>');
			}
		});
		//add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
	});
	FormWizard.init();	
}); 
var FormWizard = function () {
    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }
            var form = $('#acc_frm');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);
			var ajaxReq;
            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    //package
                    package_name: {required: true},
                },
                errorPlacement: function (error, element) { // render error placement for each input type
                    error.insertAfter(element); // for other inputs, just perform default behavior
                },
                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },
                highlight: function (element) { // hightlight error inputs
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },
                unhighlight: function (element) { // revert the change done by hightlight
                    $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label.addClass('valid').closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                },
            });
			var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                   
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.steps'), -50);
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    //Check if clickable class added to step
					if( $("ul#clickable_steps" ).hasClass("clickable_steps") ){
						console.log("d");
						return true;
					}else{
						return false;
					}
					//return false;
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
					var ajaxReq;
					var response = $("#res");
					success.hide();
                    error.hide();
					if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, index);
					
					 //Custom jquery
					var total = navigation.find('li').length;
					var currentIndex = index;
					var formData 	= $('#acc_frm').serializeArray();
					//Push step to form data
					var step = { name: "step",  value: currentIndex };
					formData.push(step);
					
					//check for ajax request
					if (ajaxReq) {
						ajaxReq.abort();
					}
					ajaxReq = $.ajax({
						type: "POST",
						url: "<?php echo base_url('itineraries/ajax_acc_savedata_stepwise'); ?>",
						data: formData,
						dataType: "json",
						beforeSend: function(){
							//response.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
						},
						success: function(res) {
							if (res.status == true){
								//$('#form_wizard_1').find('.button-next').show();
								console.log("save");
								//response.html("");
							}else{
								//response.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
								console.log("error"+ res.msg);
							}
						},
						error: function(e){
							//response.html('<div class="alert alert-danger"><strong>Error! </strong>Please try again.</div>');
							console.log("error");
						}
					});   
				},
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();
                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
					//check if step is 2
					var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }, 
				
            });
            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').hide(); 
        }
    };
}();
</script>
<script type="text/javascript">
var FormRepeater = function () {
    return {
        //main function to initiate the module
        init: function () {
			/*Day wise Hotel details */
			jQuery('.tour_hotel_repeater').each(function(){
				$(this).find(".mt-repeater-delete:eq( 0 )").hide();
				$(this).repeater({
					show: function () {
						var prevDiv = $(this).prev(".mt-repeater-hotel-item");
						//remove all other div from nested exclude first
						var innerRepeater = $(this).find(".mt-innerrepeater-hotel-item");
						var selectExtraBed = $(this).find("select.extra_bed");
						innerRepeater.not( ".mt-innerrepeater-hotel-item:first" ).remove();
						selectExtraBed.hide();
						$(this).find(".extraCheck").removeAttr("checked");
						
						var lastDate = prevDiv.find(".check_out").datepicker('getDate');
						//console.log( "Last Date: " +  lastDate);
						var ld = prevDiv.find(".check_out").val();
						//var CheckIn = $(this).datepicker('getDate');
						var nextDayMin = moment(lastDate).add(1, 'day').toDate();
						var endDate = $("#hotel_enddate").val();
						$(this).find(".mt-repeater-delete:eq( 0 )").show();
						$(this).find('.check_out').datepicker('setStartDate', nextDayMin);
						$(this).find('.check_out').datepicker('setEndDate', endDate);
						$(this).find('.check_in').val(ld);
						
						//var hotel_data	= $(this).prev(".mt-repeater-hotel-item").repeaterVal();
						//var check_out 	= prevDiv.find(".check_out").val();
						$(this).show();
					},
		            hide: function (deleteElement) {
		                if(confirm('Are you sure you want to delete this element?')) {
							$(this).slideUp(deleteElement);
							var nextDiv = $(this).nextAll(".mt-repeater-hotel-item");
							var prevDiv = $(this).prev(".mt-repeater-hotel-item");
							var lastDate = prevDiv.find(".check_out").val();
							//getnextday
							var lstDa = prevDiv.find(".check_out").datepicker('getDate');
							var nextDayMin = moment(lstDa).add(1, 'day').toDate();
							
							nextDiv.each(function(i, e){
								/* substract day */
								var nexD = $(this).find("input.check_out").datepicker("clearDates");
								var endDate = $("#hotel_enddate").val();
								$(this).find('.check_out').datepicker('setStartDate', nextDayMin);
								$(this).find('.check_out').datepicker('setEndDate', endDate);
								
								//if first element
								if ( i === 0) {
									$(this).find('.check_in').val(lastDate);
								}else{
									$(this).find('.check_in').val('');
								}	
							});
						}
		            },
		            ready: function (setIndexes) {
						
		            },
					repeaters: [{
						// (Required)
						// Specify the jQuery selector for this nested repeater
						selector: '.inner_hotel_repeater',
						show: function () {
							$(this).find(".mt-innerrepeater-delete").show();
							/* Check if pakage category already selected */
							/* $('select.hotel_rate_cat').find('option').prop('disabled', false);
							$('select.hotel_rate_cat').each(function() {
								$('select.hotel_rate_cat').not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 
								$("select.hotel_rate_cat:selected").attr('disabled','disabled');
							}); */
							/* Check if pakage category already selected */
							$(this).show();
						},	
						ready: function (setIndexes) {
							$(".inner_hotel_repeater").find(".mt-innerrepeater-delete:eq( 0 )").hide();
						},
						/* $(".hotel_inner").each(function(){
							$(this).find(".mt-innerrepeater-delete:eq( 0 )").hide();
							
						}); */
						
					}]
				});
			});
			
			/* Tour field repeater */
			jQuery('.tour_field_repeater').each(function(){
				$(this).find(".mt-repeater-delete:eq( 0 )").hide();
				$(this).repeater({
					show: function () {
						$(this).find(".mt-repeater-delete:eq( 0 )").show();
	                	$(this).show();
                	},
		            hide: function (deleteElement) {
		                if(confirm('Are you sure you want to delete this element?')) {
		                    $(this).slideUp(deleteElement);
		                }
		            },
		            ready: function (setIndexes) {

		            }

        		});
        	});
			
			/* Special inc Tour field repeater */
			jQuery('.tour_field_repeater_sp').each(function(){
				$(this).repeater({
					show: function () {
						$(this).show();
                	},
		            hide: function (deleteElement) {
		                if(confirm('Are you sure you want to delete this element?')) {
		                    $(this).slideUp(deleteElement);
		                }
		            },

		            ready: function (setIndexes) {

		            }

        		});
        	});
        }
    };
}();

jQuery(document).ready(function($) {
	FormRepeater.init();
});
</script>   

<script type="text/javascript">
	jQuery(document).ready(function($){
		//below base price
	$(document).on("click", "#below_bp", function(e){
		if($(this).is(":checked"))   
			$(".below_bp").val(1);
		else
			$(".below_bp").val(0);
	});
		//if hotel Details Empty 
		if( $("#edit_type").val() == "edit" ){
			//console.log("Edit");
			//on checkout date	
			$(".mt-repeater-hotel-item").each(function(index, ee){
				//console.log( index );
				if( index == 0 ){
					//console.log("find");
					var hotel_enddate = $("#hotel_enddate").datepicker('getDate');
					var hotel_sd = $("#hotel_startdate").datepicker('getDate');
					var nextDayMin = moment(hotel_sd).add(1, 'day').toDate();
					$(this).find(".check_out").datepicker('setStartDate', nextDayMin);
					$(this).find(".check_out").datepicker('setEndDate', hotel_enddate);
				}else{
					var hotel_enddate = $("#hotel_enddate").datepicker('getDate');
					var hotel_sd = $(this).prev().find(".check_out").datepicker('getDate');
					//console.log("prev Index " + index + " = " + hotel_sd );
					var nextDayMin = moment(hotel_sd).add(1, 'day').toDate();
					$(this).find(".check_out").datepicker('setStartDate', nextDayMin);
					$(this).find(".check_out").datepicker('setEndDate', hotel_enddate);
				}
			});	
			
			//On checkout datepicker
			$(document).on("click", 'input.check_out', function(){ 
				//on datepicker change 
				$(".check_out").datepicker().on('changeDate', function (selected) {
					//Add one day to last checkout
					var _thisVal = $(this).val();
					var _thisDate = $(this).datepicker('getDate');
					var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
						
					var cinDate 	= $(this).parent().parent().find("input.check_in").val();
					var t_nights 	= $(this).parent().parent().find("input.total_nights");
						//console.log("cin"  + cinDate  );
					if( cinDate != "" ){
						var check_in = cinDate.split("/");
						var check_out = $(this).val().split("/");
						var nights = calculateNights(check_in, check_out);
						t_nights.val(nights);
					}
					
					//Empty nextAll date
					var nextDiv = $(this).parent().parent().parent().nextAll(".mt-repeater-hotel-item");
					if( nextDiv ){
						nextDiv.each(function(i, e){
							var nexD = $(this).find("input.check_out").datepicker("clearDates");
							var endDate = $("#hotel_enddate").val();
							$(this).find('.check_out').datepicker('setStartDate', nextDayMin);
							$(this).find('.check_out').datepicker('setEndDate', endDate);
							
							//if first element
							if ( i === 0) {
								$(this).find('.check_in').val( _thisVal );
							}else{
								$(this).find('.check_in').val('');
							}	
						});
					}
					//console.log( cinDate );
				});
			}); 
			
		//hotel tour start date
		var CIn = $("#hotel_startdate").datepicker('getDate');
		var nDM = moment(CIn).add(1, 'day').toDate();
		$('#hotel_enddate').datepicker('setStartDate', nDM);
		
		var coD = $("#hotel_enddate").datepicker('getDate');
		var sEndDate = moment(coD).subtract(1, 'day').toDate();
		$('#hotel_startdate').datepicker('setEndDate', sEndDate);
	}else{
		//on checkout date click	
		$(document).on("click", '.check_out', function(){
			var hotel_startdate	 = $('#hotel_startdate').val();
			var hotel_enddate	 =  $('#hotel_enddate').val();
			if( hotel_startdate == "" ){
				alert("Please Select Start and End Date");
				$('#hotel_startdate').focus();
				return false;
			}else if( hotel_enddate == "" ){
				$('#hotel_enddate').focus();
				return false;
			}else{
				var nd =  $('#hotel_startdate').val().split("/");
				var nxtDate = getNextDate(nd);
				//console.log(nxtDate);
				//on datepicker change 
				$(this).datepicker().on('changeDate', function (selected) {
					//Add one day to last checkout
					var _thisVal = $(this).val();
					var _thisDate = $(this).datepicker('getDate');
					var nextDayMin = moment(_thisDate).add(1, 'day').toDate();
						
					var cinDate = $(this).parent().parent().find("input.check_in").val();
					var t_nights = $(this).parent().parent().find("input.total_nights");
					if( cinDate != "" ){
						var check_in = cinDate.split("/");
						var check_out = $(this).val().split("/");
						var nights = calculateNights(check_in, check_out);
						t_nights.val(nights);
					}
					
					//Empty nextAll date
					var nextDiv = $(this).parent().parent().parent().nextAll(".mt-repeater-hotel-item");
					if( nextDiv ){
						nextDiv.each(function(i, e){
							var nexD = $(this).find("input.check_out").datepicker("clearDates");
							var endDate = $("#hotel_enddate").val();
							$(this).find('.check_out').datepicker('setStartDate', nextDayMin);
							$(this).find('.check_out').datepicker('setEndDate', endDate);
							
							//if first element
							if ( i === 0) {
								$(this).find('.check_in').val( _thisVal );
							}else{
								$(this).find('.check_in').val('');
							}	
						});
					}
					//console.log( cinDate );
				});
			}	
		});
	}
	
	//start date
	$("#hotel_startdate").datepicker({
        startDate:  "2d",
        autoclose: true,
    }).on('changeDate', function (selected) {
        //var minDate = new Date(selected.date.valueOf());
		$('.check_out').datepicker("clearDates");
		var CheckIn = $(this).datepicker('getDate');
		var nextDayMin = moment(CheckIn).add(1, 'day').toDate();
        $('#hotel_enddate').datepicker('setStartDate', nextDayMin);
		$('.check_out').datepicker('setStartDate', nextDayMin);
		
		//Calculate Total Nights
		var h_end_date = $('#hotel_enddate').val();
		if( h_end_date !== "" ){
			var check_in = $('#hotel_startdate').val().split("/");
			var check_out = $('#hotel_enddate').val().split("/");
			var nights = calculateNights(check_in, check_out);
			$("#package_duration").val(nights);
		}
		//Set CheckIn Date
		$('.hotel_repeater').find("input.check_in").val( "" ); 
		$('.hotel_repeater').find("input[name='hotel_meta[0][check_in]']").val( $(this).val() ); 
    });
    
	//hotel tour End date
    $("#hotel_enddate").datepicker({  startDate:  "10d", })
        .on('changeDate', function (selected) {
            //var minDate = new Date(selected.date.valueOf());
			$('.check_out').datepicker("clearDates");
			var CheckIn = $(this).datepicker('getDate');
			var stDate = moment(CheckIn).subtract(1, 'day').toDate();
			$('#hotel_startdate').datepicker('setEndDate', stDate);
			$('.check_out').datepicker('setEndDate', CheckIn);
			
			//Calculate Total Nights
			var h_start_date = $('#hotel_enddate').val();
			if( h_start_date !== "" ){
				var check_in = $('#hotel_startdate').val().split("/");
				var check_out = $('#hotel_enddate').val().split("/");
				var nights = calculateNights(check_in, check_out);
				$("#package_duration").val(nights);
			}
    });
	
	
	//calculate total nights
	function calculateNights(startDate , EndDate){
		if(jQuery.type(startDate) === "undefined" && jQuery.type(EndDate) === "undefined"){
			return false;
		}else{
			var cin = new Date(startDate[2], startDate[1] - 1, startDate[0]);
			var cout = new Date(EndDate[2], EndDate[1] - 1, EndDate[0]);
			var days = (cout- cin) / (1000 * 60 * 60 * 24);
			var nights = days;
			return nights;
		}	
	}
	
	//Get Next day format should be dd/mm/yyyy
	function getNextDate( lastDate ){
		if(jQuery.type(lastDate) === "undefined" || lastDate === ""){
			return false;
		}else{
			var f = new Date(lastDate[2], lastDate[1] - 1, lastDate[0]);
			var next = moment(f).add(1,'days');
			var	nextDate  = moment(next).format('DD/MM/YYYY');
			return nextDate;
		}
	}	
});	
</script>
<?php }else{
	redirect("accommodation");
} ?>