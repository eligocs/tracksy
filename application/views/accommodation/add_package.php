<div class="page-container">
	<?php if( $customer ){ 	$cus = $customer[0]; ?>
	<style>
	/*.inner_hotel_repeater{background: pink !important; border: 1px solid blue !important;}*/
	.help-block.help-block-error {color: red !important}
	</style>
	<div class="page-content-wrapper">
		<div class="page-content">
		<div class="portlet box blue">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Create Accommodation Package</div>
				<a class="btn btn-success pull-right" href="<?php echo site_url("accommodation"); ?>" title="Back">Back</a>
			</div>
		</div>
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
		<div class="portlet light bordered" id="form_wizard_1">
			<div class="portlet-body form">
				<form id="acc_frm">
				<div class="form-horizontal2" id="itiForm_form">
					<!--Customer info Section-->
						<?php $get_customer_info = get_customer( $cus->customer_id ); 
						$cust = $get_customer_info[0];
						if( !empty( $get_customer_info ) ){  ?>
							<section class="well details-package">
							<h3 class="text-center">Package details</h3>
								<p class="text-center "><strong><u>Customer Details </u></strong></p>
								<label class="col-md-6 col-lg-2">Customer Name:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->customer_name)){ echo $cust->customer_name; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Contact:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->customer_contact)){ echo $cust->customer_contact; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Customer Email:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->customer_email)){ echo $cust->customer_email; }?> </strong>
								</div>
							 
								<label class="col-md-6 col-lg-2">Travel Date:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->travel_date)){ echo $cust->travel_date; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Package Type:</label>
								<?php 
									$pkBy =	$cust->package_type;
									$pack_T = $pkBy == "Other" ? $cust->package_type_other : $pkBy; ?>
								<div class="col-md-6 col-lg-2">
									<strong><?php echo $pack_T;?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Destination:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->destination)){ echo $cust->destination; }?> </strong>
								</div>
								 
								<label class="col-md-6 col-lg-2">Meal Plan:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->meal_plan)){ echo $cust->meal_plan; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Hotel Category:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->hotel_category)){ echo $cust->hotel_category; }?></strong>
								</div>
								<label class="col-md-6 col-lg-2">Budget Approx:</label>
								<div class="col-md-6 col-lg-2">
									<strong><?php if(isset($cust->budget)){ echo $cust->budget; }?> </strong>
								</div>
								 
								<label class="col-md-6 col-lg-2">Total Travellers:</label>
								<div class="col-md-6 col-lg-2">
									<strong>Adults: <?php if(isset($cust->adults)){ echo $cust->adults; }?></strong>
									<strong><?php if(isset($cust->child)){ echo "Child: " . $cust->child . "( " . $cust->child_age . " )"; } ?></strong>
								</div>
								 
							</section>
						<?php } ?>
					<!--end Section Customer Section-->
					<div class="form-wizard">
						<div class="form-body">
							<ul class="nav nav-pills nav-justified steps">
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
											<i class="fa fa-check"></i> Inclusion & Exclusion </span>
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
							<div id="bar" class="progress progress-striped  active" role="progressbar">
								<div class="progress-bar progress-bar-success"> </div>
							</div>
							<div class="tab-content">
								<div class="alert alert-danger display-none">
									<button class="close" data-dismiss="alert"></button> You have some form errors. Please check below. </div>
								<div class="tab-pane active" id="tab1">
									<h3 class="block">Provide Package details</h3>
									<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Package Name
											<span class="required"> * </span>
										</label>
										<div class="col-md-8">
											<input type="text" class="form-control" name="package_name" placeholder="Enter Package Name."/>
										</div>
									</div>
									</div>
									
									<div  class="col-md-6">
									<div class="form-group">
										<label class="control-label col-md-4">Hotel At
											<span class="required"> * </span>
										</label>
										<div class="col-md-8">
											<input type="text" required value= "" title="Hotel Locations" class="form-control" name="package_routing" placeholder="Enter Hotel location." />
										</div>
									</div>
									</div>
									
									<div class="clearfix"></div>
									<div class="col-md-6">
										<div class="form-group margin-top-10">
											<label class="control-label col-md-4">No. of Persons
												<span class="required"> * </span>
											</label>
											<div class="col-md-2">
												<input type="number" required class="form-control" name="adults" value="" placeholder="Adults" />
											</div>
											<div class="col-md-2 padding-0">
												<input type="number" class="form-control" title="Total Child" name="child" value="" placeholder="Children" />
											</div>
											<div class="col-md-4">
											<input type="text" class="form-control" title="Child age Seprated by comma" name="child_age" value="" placeholder="Child Age: eg. 12,15,18." />
											</div>
											
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Package Type
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<select required name="iti_package_type" class="form-control">
													<option value="">Choose Package Type</option>
													<option value="Honeymoon Package">Honeymoon Package</option>
													<option value="Fixed Departure">Fixed Departure</option>
													<option value="Group Package">Group Package</option>
													<option value="Other">Other</option>
												</select>
											</div>
										</div>
									</div>
									
									<div class="clearfix"></div>
								</div>
								<div class="tab-pane " id="tab2">
									<h3 class="block color-title text-center">Hotel Details</h3>
									<h4 class="clearboth">Choose Hotel By Categories:</h4>
									<div class="portlet light portlet-fit bordered"><br>
									<div class="col-md-4 form-group">
										<div class="form-group">
											<label class="control-label">Package Start Date*</label>
											<input readonly required type="text" data-date="" data-date-format="dd/mm/yyyy" class="form-control" id="hotel_startdate" name="hotel_startdate" value="">
										</div>
									</div>
									
									<div class="col-md-4 form-group">
										<div class="form-group">
											<label class="control-label">Package End Date*</label>
											<input readonly required  data-date="" data-date-format="dd/mm/yyyy" type="text" class="form-control" id="hotel_enddate" name="hotel_enddate" value=""> 
										</div>
									</div>
									<div  class="col-md-4">
									<div class="form-group">
										<label class="control-label">Total Nights
											<span class="required"> * </span>
										</label>
										<div class="">
											<input readonly type="text" class="form-control" id = "package_duration" name="package_duration" placeholder="Total Nights" value=""/>
										</div>
									</div>
									</div>
									<div class="clearfix"></div>
									
									<div class="mt-repeater-hotel tour_hotel_repeater">
										<div data-repeater-list="hotel_meta" class="hotel_repeater">
											<div data-repeater-item class="mt-repeater-hotel-item">
												<div class="clearfix">
													<div class='mt-repeater-hotel-input  col-md-3' >
														<label><strong>Hotel City:</strong></label>
														<input required type="text" name='hotel_location' class='form-control' placeholder="Eg. Shimla/Manali">
													</div>
													<div class="mt-repeater-hotel-input col-md-2">
														<label class="control-label"><strong>Check in</strong>*</label>
														<input readonly required type="text" class="form-control check_in" name="check_in" value="">
													</div>
													<div class="mt-repeater-hotel-input col-md-2">
														<label class="control-label"><strong>Checkout</strong>*</label>
														<input readonly required data-date="" data-date-format="dd/mm/yyyy" type="text" class="form-control ckinout check_out" name="check_out" value="">
													</div>	
													<div class='mt-repeater-hotel-input col-md-2' >
														<label><strong>Total Rooms:</strong></label>
														<select required name="total_room" class="form-control">
															<option value="">Select Rooms</option>
															<?php for( $i=1 ; $i <=100 ; $i++ ){ ?>
																<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
															<?php } ?>	
														</select>
													</div>
													
													<div class='mt-repeater-hotel-input  col-md-3' >
														<label><strong>Nights:</strong></label>
														<input required readonly type="number" name='total_nights' class='form-control total_nights' placeholder="">
														
														<div class='mt-repeater-hotel-input' >
														<label><strong>Extra Bed:</strong></label><br>
														<label><input type="checkbox" class="extraCheck" value="Yes"> Add extra bed.</label>
														<select required name="extra_bed" class="form-control extra_bed">
															<option value="">Select Extra Bed</option>
															<?php for( $eb=1 ; $eb <=100 ; $eb++ ){ ?>
																<option value="<?php echo $eb; ?>"><?php echo $eb; ?></option>
															<?php } ?>	
														</select>
													</div>
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
																
																<div class='mt-innerrepeater-hotel-input col-md-2' >
																	<label><strong>Room Category:</strong></label>
																	<select required name="room_category" class="form-control">
																		<option value="">Choose Room Category</option>
																		<option value="Standard">Standard</option>
																		<option value="Deluxe">Deluxe</option>
																		<option value="Super Deluxe">Super Deluxe</option>
																		<option value="Luxury">Luxury</option>
																		<option value="Family Sweet">Family Sweet</option>
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
																<div class='mt-innerrepeater-hotel-input col-md-3' >
																	<label><strong>Hotel:</strong></label>
																	<textarea name="hotel_name" required class='form-control'></textarea>
																</div>
																
																<div class="mt-innerrepeater-hotel-input col-md-2">
																<label class="center-block"><strong>&nbsp;</strong></label>
																	<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-innerrepeater-delete">
																		<i class="fa fa-close"></i> Delete</a>
																</div>
																<div class="clearfix"></div>
															</div>
														</div>
														<div class="clearfix"></div>
														<div class="col-md-12"><a href="javascript:;" data-repeater-create class="clearfix btn btn-success">
														<i class="fa fa-plus"></i> Add New Category</a>
														</div>
													</div><!--End inner repeater-->
													
													<div class="mt-repeater-hotel-input col-md-12">
														<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
															<i class="fa fa-close"></i> Delete 2</a>
													</div>
												</div> <!-- row -->
											 
											</div>
										</div>
										<div class="col-md-12">
										<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-hotel-add">
										<i class="fa fa-plus"></i> Add Hotel</a>
										</div>
									</div>
									
									<hr>
									<div class="mt-repeater-hotel-note tour_field_repeater">
										<div data-repeater-list="hotel_note_meta">
											<label class="control-label col-md-12"> Add Hotel Note: </label>
										<?php $count_hotel_notes = count( $hotel_notes );
											if( $count_hotel_notes > 0 && !empty( $hotel_notes ) ){ ?>
												<?php for ( $i = 0; $i < $count_hotel_notes; $i++ ) { ?>
													<div data-repeater-item class="mt-repeater-hotel-note-item form-group">
														<!-- jQuery Repeater Container -->
														<div class="mt-repeater-hotel-note-input col-md-9">
															<div class="mt-repeater-hotel-note-input">
																<input required type="text" name="hotel_note_meta[<?php echo $i; ?>][hotel_note]" class="form-control" value="<?php echo $hotel_notes[$i]["hotel_notes"] ;?>" /> 
															</div>
														</div>
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
													<div class="mt-repeater-hotel-note-input col-md-3">
														<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
														<i class="fa fa-close"></i> Delete</a>
													</div>
												</div>
											<?php } ?>	
										</div>
										<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-hotel-note">
										<i class="fa fa-plus"></i> Add Note</a>
									</div>
								</div>
								</div> <!-- tab2 -->
								<div class="tab-pane" id="tab3">
									<h3 class="block color-title text-center">Inclusion & Exclusion</h3>
									<div class="clearfix"></div>
									<div class="col-md-6">
										<div class="mt-repeater-inc tour_field_repeater">
											<h4>Inclusion</h4>
											<div data-repeater-list="inc_meta">
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
											</div><br>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-inc-add">
											<i class="fa fa-plus"></i> Add</a>
										</div>
										
										<div class="clearfix"></div>
										<div class="col-md-12">
											<div class="col-md-12"><!--Special Inclusion Section-->
												<div class="mt-repeater-spinc tour_field_repeater_sp">
													<h3 class="block">Special Inclusions</h3>
													<div data-repeater-list="special_inc_meta">
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
													</div><br>
													<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-spinc-add">
													<i class="fa fa-plus"></i> Add</a>
												</div>
											</div><!--end Special Inclusion Section-->	
											
											<div class="col-md-12"><!--Benefits-->
												<div class="mt-repeater-spinc tour_field_repeater_sp">
													<h3 class="block">Benefits of Booking With Us </h3>
													<div data-repeater-list="booking_benefits_meta">
														<?php 
														$get_booking_benefits = get_booking_benefits();
														if( $get_booking_benefits ){ 
															$count_ben_m = count( $get_booking_benefits ); ?>
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
													</div><br>
													<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-spinc-add">
													<i class="fa fa-plus"></i> Add</a>
												</div>
											</div><!--end Special Inclusion Section-->	
										</div>	
									</div>	
									<div class="col-md-6">
										<div class="mt-repeater-exc tour_field_repeater">
											<h4>Exclusion</h4>
											<div data-repeater-list="exc_meta">  
											<?php $count_hotel_exc	= count( $hotel_exc );
												if( $count_hotel_exc > 0 && !empty( $hotel_exc) ){ ?>
													<?php for ( $i = 0; $i < $count_hotel_exc; $i++ ) { ?>
														<div data-repeater-item class="mt-repeater-exc-item form-group">
															<!-- jQuery Repeater Container -->
															<div class="mt-repeater-exc-input col-md-9">
																<input required type="text" name="exc_meta[<?php echo $i; ?>][tour_exc]" class="form-control" value="<?php echo $hotel_exc[$i]["hotel_exc"] ;?>" /> 
															</div>
															
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
														<div class="mt-repeater-exc-input col-md-3">
															<a title="delete" href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																<i class="fa fa-close"></i> </a>
														</div>
													</div>
												<?php } ?>	
											</div>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
											<i class="fa fa-plus"></i> Add</a>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="tab-pane" id="tab4">
									<div class="verify_msg">
										<p>You can review your inputs by clicking on Back Button. To save this itinerary Click on Submit Button.</p>
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
					<?php 
						$rand = getTokenKey(8); 
						$date = date("Ymd"); 
						$time = time(); 
						$unique_key = $rand . "_" . $date . "_" . $time; 
					?>
					<input id="unique_key" type="hidden" name="temp_key" value="<?php echo $unique_key; ?>">
					<input id="agent_id" type="hidden" name="agent_id" value="<?php echo isset($get_customer_info[0]->agent_id) ? $get_customer_info[0]->agent_id : $user_id; ?>">
					<input id="customer_id" type="hidden" name="customer_id" value="<?php echo $cus->customer_id; ?>">
					<input id="lead_created" type="hidden" value="<?php echo $cus->created; ?>" name="lead_created">
					<!--Itinerary type 1=holidayz package, 2= accommondation package-->
					<input id="iti_type" type="hidden" value="2" name="iti_type">
				</form>	
				<div id="res"></div>
		</div>
		</div>
	<!-- END CONTENT BODY -->
	</div>
<!-- Modal -->
 </div>
</div>
<style>.extra_bed{display:none;}</style>
<script type="text/javascript">
jQuery(document).ready(function($){
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
				resp.html('<div class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>');
			},
			success: function(res) {
				if (res.status == true){
					resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
					console.log("done");
					$('#acc_frm')[0].reset();
					//console.log(res.msg);
					window.location.href = "<?php echo site_url('itineraries/view/'); ?>" + res.iti_id + "/" + res.temp_key; 
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
                    return false;
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
						var lastDate = prevDiv.find(".check_out").datepicker('getDate');
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
							/* Check if pakage category already selected */
							/* $("select.hotel_rate_cat").find('option').prop('disabled', false);
							$("select.hotel_rate_cat").each(function() {
								$("select.hotel_rate_cat").not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 
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
		$('.extraCheck').each(function() {
			$(document).on("click",".extraCheck",function(){
				if ($(this).is(":checked")) {
					$(this).closest("div").find(".extra_bed").show();
				}else{
					$(this).closest("div").find(".extra_bed").val("").hide();
				}
			});	
		});
		
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
		
	//hotel tour start date
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
    $("#hotel_enddate").datepicker({  startDate:  "2d", })
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
	<?php } else{
		redirect("customers");
	} ?>