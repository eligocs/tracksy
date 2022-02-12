<?php if( !empty($itinerary[0] ) ){ 			
	$iti = $itinerary[0]; ?>
		<div class="page-content-wrapper">
			<div class="page-content">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Edit Package <?php echo $iti->package_id; ?></div>
						<a class="btn btn-success pull-right" href="<?php echo site_url("packages"); ?>" title="Back">Back</a>
					</div>
				</div>
				<div class="portlet light bordered" id="form_wizard_1">
				<div class="portlet-body form">
				<!--end Section Customer Section-->
						<?php $get_pub_status = $iti->publish_status; 
							$add_pub_class = $get_pub_status == "publish" ? "clickable_steps" : "";
						?>
						
					<form id="itiForm_form">
					<div class="form-horizontal" id="itiForm_form">
						<h3 class="package-details-heading">Package details</h3>
						<!--end Section Customer Section-->
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
												<i class="fa fa-check"></i> Day Wise Itinerary </span>
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
												<i class="fa fa-check"></i> Hotel Details </span>
										</a>
									</li>
									<li>
										<a href="#tab7" data-toggle="tab" class="step">
											<span class="number"> 5 </span>
											<span class="desc">
												<i class="fa fa-check"></i> Submit Itinerary </span>
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
											<label class="control-label col-md-4">State
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<?php $state_list = get_indian_state_list(); 
												if( $state_list ){
													echo "<select name='state' class='form-control' id='state'>";
														echo '<option value="">Select State</option>';
														foreach($state_list as $state){
															$selected = $iti->state_id == $state->id ? "selected='selected'" : "";
															echo '<option '.$selected.' value="'.$state->id.'">'.$state->name.'</option>';
														}
													echo "</select>";
												}else{ ?>
													<input type="text" placeholder="State Name" name="state" class="form-control" value="" /> 
												<?php } ?>
											</div>
										</div>
									</div>
										
										<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Package Category
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<select required name="p_cat_id" class="form-control">
													<option value="">Choose Package Category</option>
													<?php $cats = get_package_categories(); 
														if( $cats ){
															foreach($cats as $cat){ ?>
																<option <?php if ( $iti->p_cat_id == $cat->p_cat_id ) { ?> selected="selected" <?php } ?>  value = "<?php echo $cat->p_cat_id ?>" ><?php echo $cat->package_cat_name; ?></option>;
															<?php }
														}
													?>
												</select>
											</div>
										</div>
										</div>
										
										<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Package Name
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="package_name" placeholder="Enter Package Name." value="<?php if(isset($iti->package_name)){ echo $iti->package_name; }?>"/>
											</div>
										</div>
										</div>
										
										<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Routing
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<input type="text" value= "<?php if(isset($iti->package_routing)){ echo $iti->package_routing; }?>" class="form-control" name="package_routing" placeholder="Enter Package Routing." />
											</div>
										</div>
										</div>
										<div  class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-4">No. Persons
													<span class="required"> * </span>
												</label>
												<div class="col-md-2">
													<input type="text" required class="form-control" name="adults" value="<?php if(isset($iti->adults)){ echo $iti->adults; } ?>" placeholder="Total no. of  adults eg: 2" />
												</div>
												<div class="col-md-2">
													<input type="text" class="form-control" name="child" value="<?php if(isset($iti->child)){ echo $iti->child; } ?>" placeholder="Total child" />
												</div>
												<div class="col-md-4">
												<input type="text" class="form-control" name="child_age" value="<?php if(isset($iti->child_age)){ echo $iti->child_age; } ?>" placeholder="child age: eg. 12,15,18." />
												</div>
												
											</div>
										</div>
										 
										<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Cab
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<select required name="cab_category" class="form-control">
													<option value="">Choose Car Category</option>
													<?php $cars = get_car_categories(); 
														if( $cars ){
															foreach($cars as $car){ ?>
																<option <?php if ( $iti->cab_category == $car->id ) { ?> selected="selected" <?php } ?>  value = "<?php echo $car->id ?>" ><?php echo $car->car_name; ?></option>;
															<?php }
														}
													?>
												</select>
											</div>
										</div>
										</div>
										<div  class="col-md-6">
										<div class="form-group">
											<label class="control-label col-md-4">Duration
												<span class="required"> * </span>
											</label>
											<div class="col-md-8">
												<input type="text" class="form-control" id = "package_duration" name="package_duration" placeholder="Enter Package Duration eg. 3 Nights and 4 days." value="<?php if(isset($iti->duration)){ echo $iti->duration; }?>"/>
											</div>
										</div>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="tab-pane" id="tab2">
										<h3 class="block">Day Wise Itineray</h3>
										<div class="col-md-12">
											<div class="mt-repeater">
												<div data-repeater-list="tour_meta">
												<?php $day_wise = $iti->daywise_meta; 
													$tourData = unserialize( $day_wise );
													$count_day = count( $tourData );
													$nxt = "false";
													if( !empty($day_wise) ){
														//print_r( $tourData );
														for ( $i = 0; $i < $count_day; $i++ ) { ?>
															<div data-repeater-item class="mt-repeater-item daywise_section">
																<!--strong>Day: </strong><strong class="sta_d"><?php //echo $i+1; ?></strong-->
																<div class="clearfix"></div>
																<div class="row">
																<div class="col-md-8">
																<div class="row">
																<div class="col-md-2">
																<div class="mt-repeater-input form-group">
																	<label class="control-label">Day</label><span class="required"> * </span>
																	<br/>
																	<input required  placeholder="Day 1" type="text" name="tour_day" class="form-control" value="<?php echo $tourData[$i]['tour_day']?>" /> 
																</div>
																	<input class="input-group form-control" size="16" type="hidden" value="<?php echo $tourData[$i]['tour_date']; ?>" name="tour_date"  />
																</div>
																<div class="mt-repeater-input  t_title">
																	<label class="control-label">Tour Title</label><span class="required"> * </span>
																	<br/>
																	<input required  placeholder="Shimla local sight" type="text" name="tour_name" class="form-control" value="<?php echo $tourData[$i]['tour_name']?>" /> 
																</div>
																</div>
																</div>
																<div class="col-md-4">
																	<div class="mt-repeater-input  ">
																	<label class="control-label">Meal Plan</label><span class="required"> * </span>
																	<br/>
																	<select required name="meal_plan" class="form-control">
																		<option value="">Choose Meal Plan</option>
																		<option value="Breakfast Only" <?php if ( $tourData[$i]['meal_plan'] == "Breakfast Only" ) { ?> selected="selected" <?php } ?> >Breakfast Only</option>
																		<option <?php if ( $tourData[$i]['meal_plan'] == "Breakfast & Dinner" ) { ?> selected="selected" <?php } ?> value="Breakfast & Dinner"> Breakfast & Dinner</option>
																		<option <?php if ( $tourData[$i]['meal_plan'] == "Breakfast, Lunch & Dinner" ) { ?> selected="selected"  <?php } ?> value="Breakfast, Lunch & Dinner">Breakfast, Lunch & Dinner</option>
																		<option <?php if ( $tourData[$i]['meal_plan'] == "Dinner Only" ) { ?> selected="selected" <?php } ?> value="Dinner Only">Dinner Only</option>
																		<option <?php if ( $tourData[$i]['meal_plan'] == "No" ) { ?> selected="selected" <?php } ?> value="No">No Meal Plan</option>
																	</select>
																</div>
																<div class="mt-repeater-input  ">
																	<label class="control-label">Distance</label><span class="required"> * </span>
																	<br/>
																	<input required  placeholder="100 Km" type="number" name="tour_distance" class="form-control tour_distant" value="<?php echo $tourData[$i]['tour_distance'] ?>" /> 
																</div>
																</div>
															</div> <!-- row close-->		
																<div class="clearfix"></div>	
																<div class="row">
																<div class="col-md-9">
																<div class="mt-repeater-input mt-repeater-textarea t_des">
																	<label class="control-label">Tour Description</label><span class="required"> * </span>
																	<br/>
																	<textarea required name="tour_des" class="form-control" rows="3"><?php echo $tourData[$i]['tour_des']; ?></textarea>
																</div>
																</div>
																
																<div class="col-md-3">	
																<div class="mt-repeater-input">	
																	<label class="control-label">Attraction</label>
																	<div class="hot_des" style="float:none;">
																		<input type="hidden" value="<?php echo $tourData[$i]['hot_des'] ?>" class="tags_values" name="hot_des">
																		<?php
																			
																			if( isset($tourData[$i]['hot_des'] ) && !empty( $tourData[$i]['hot_des'] )  ){
																				$hot_dest = '';
																				$htd = explode(",", $tourData[$i]['hot_des']);
																				foreach($htd as $t) {
																					$t = trim($t);
																					 $hot_dest .= "<span>" . $t . "</span>";
																				}
																				echo $hot_dest;
																			}	
																	
																		?>
																		
																		
																		<input type="text" value="" class="form-control" placeholder="Add a Hot destination" />
																	</div>
																</div> 
																</div> 
																</div> 
																
																
																<div class="mt-repeater-input del_rep" >
																	<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete" style="position:relative;">
																	<i class="fa fa-close"></i> Delete</a>
																</div>
															</div>
														<?php 
														
														} ?>
													<?php } else{ ?>	
															<div data-repeater-item class="mt-repeater-item daywise_section">
																<!--strong>Day: </strong><strong class="sta_d">1</strong--> 
																<div class="clearfix"></div>
																<div class="row">
																<div class="col-md-8">
																<div class="row">
																<div class="col-md-2">
																	<div class="mt-repeater-input form-group">
																			<label class="control-label">Day</label><span class="required"> * </span>
																			<br/>
																			<input required  placeholder="Day 1" type="text" name="tour_day" class="form-control" value="" /> 
																		</div>
																			<input class="input-group form-control" size="16" type="hidden" value="" name="tour_date"  />
																</div>
																<div class="mt-repeater-input form-group t_title">
																			<label class="control-label">Tour Title</label><span class="required"> * </span>
																			<br/>
																			<input required  placeholder="Shimla local sight" type="text" name="tour_name" class="form-control" value="" /> 
																</div>
																</div>
																</div>
																<div class="col-md-4">
																<div class="mt-repeater-input form-group">
																			<label class="control-label">Meal Plan</label><span class="required"> * </span>
																			<br/>
																			<select required name="meal_plan" class="form-control">
																				<option value="">Choose Meal Plan</option>
																				<option value="Breakfast Only">Breakfast Only</option>
																				<option value="Breakfast & Dinner">Breakfast & Dinner</option>
																				<option value="Breakfast, Lunch & Dinner">Breakfast, Lunch & Dinner</option>
																				<option value="Dinner Only">Dinner Only</option>
																				<option value="No">No Meal Plan</option>
																			</select>
																		</div>
																		<div class="mt-repeater-input form-group">
																			<label class="control-label">Distance</label><span class="required"> * </span>
																			<br/>
																			<input required  placeholder="100 Km" type="number" name="tour_distance" class="form-control tour_distant" value="" /> 
																		</div>
																</div>		
																</div> <!-- row close-->		
																<div class="clearfix"></div>											
																<div class="mt-repeater-input mt-repeater-textarea t_des" style="padding-left:0; padding-right:0;">
																			<label class="control-label">Tour Description</label><span class="required"> * </span>
																		 
																			<textarea required="required" name="tour_des" class="form-control" rows="2"></textarea>
																			
																		</div>
																		<div class="mt-repeater-input form-group">
																		<label class="control-label">Hot Destinations</label>
																		<div class="hot_des">
																			<input type="hidden" value="" class="tags_values" name="hot_des">
																			<input type="text" value="" placeholder="Add a Hot destination" />
																		</div>
																	</div>
																		
																<div class="clearfix"></div>
																
																		
																		<!-- jQuery Repeater Container -->
																		
																
																		
																	
																		<div class="mt-repeater-input del_rep">
																			<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete" style="position:relative;">
																			<i class="fa fa-close"></i> Delete</a>
																		</div>
														</div>
														
													<?php } ?>	
												</div>
												<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add addrep">
												<i class="fa fa-plus"></i> Add</a>
											</div>
										</div>
											<!-- Tour data preview -->
										<!--div class="col-md-3">
											<div id="tour_data_preview"></div>										
										</div-->		
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
															<br>
														<?php } ?>
													<?php } else{ ?>	
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
														<br>
													<?php }?>	
												</div>	
												<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-inc-add">
												<i class="fa fa-plus"></i> Add</a>
											</div>
										</div>	
										<div class="col-md-6">
											<?php $terms = get_terms_condition();
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
														if( $count_hotel_exc > 0 ){ ?>
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
										<div class="col-md-12">
										<!--Special Inclusion Section-->
										<div class="mt-repeater-spinc tour_field_repeater_sp">
											<h3 class="block">Special Inclusions</h3>
											<div data-repeater-list="special_inc_meta">
												<?php 
													$sp_inc = unserialize($iti->special_inc_meta); 
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
									</div>	
									</div>
									<div class="tab-pane removeMargin" id="tab4">
										<h3 class="block">Hotel Details</h3>
										<div class="mt-repeater-hotel tour_field_repeater">
											<div data-repeater-list="hotel_meta">
											<?php $hotel_meta = unserialize($iti->hotel_meta); 
												$count_hotel = count( $hotel_meta ); 
												if( !empty( $hotel_meta ) ){
													for ( $i = 0; $i < $count_hotel; $i++ ) { ?>
														<div data-repeater-item class="mt-repeater-hotel-item">
															<!-- jQuery Repeater Container -->
															<h4 class="clearboth">Choose Hotel By Categories:</h4>
															<div class="row">
																<div class='mt-repeater-hotel-input form-group col-md-3' >
																	<label><strong>Hotel Location:</strong></label>
																	<input required type="text" name='hotel_location' value="<?php if(isset($hotel_meta[$i]["hotel_location"]) ) echo $hotel_meta[$i]["hotel_location"]; ?>" class='form-control' placeholder="Eg. Shimla/Manali">
																</div>
																<div class='mt-repeater-hotel-input standard  form-group col-md-2' >
																	<label><strong>Standard:</strong></label>
																	<textarea name="hotel_standard" required class='form-control'><?php if(isset($hotel_meta[$i]["hotel_standard"]) ) echo $hotel_meta[$i]["hotel_standard"]; ?>
																	</textarea>
																</div>
																
																<div class='mt-repeater-hotel-input deluxe form-group col-md-2' >
																	<label><strong>Deluxe:</strong></label>
																	<textarea name="hotel_deluxe" required class='form-control'><?php if(isset($hotel_meta[$i]["hotel_deluxe"]) ) echo $hotel_meta[$i]["hotel_deluxe"]; ?>
																	</textarea>
																</div>
																<div class='mt-repeater-hotel-input super_deluxe form-group col-md-2' >
																	<label><strong>Super Deluxe:</strong></label>
																	<textarea name="hotel_super_deluxe" required class='form-control'><?php if(isset($hotel_meta[$i]["hotel_super_deluxe"]) ) echo $hotel_meta[$i]["hotel_super_deluxe"]; ?>
																	</textarea>
																</div>
																<div class='mt-repeater-hotel-input luxury form-group col-md-2' >
																	<label><strong>Luxury:</strong></label>
																	<textarea name="hotel_luxury" required class='form-control'><?php if(isset($hotel_meta[$i]["hotel_luxury"]) ) echo $hotel_meta[$i]["hotel_luxury"]; ?>
																	</textarea>
																</div>
																<div class="mt-repeater-hotel-input col-md-1">
																	<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																		<i class="fa fa-close"></i> Delete</a>
																</div>
															</div>	
														</div>
													<?php } ?>
												<?php }else{ ?>	
													<div data-repeater-item class="mt-repeater-hotel-item">
														<div class="row">
															<div class='mt-repeater-hotel-input  col-md-3' >
																<label><strong>Hotel Location:</strong></label>
																<input required type="text" name='hotel_location' class='form-control' placeholder="Eg. Shimla/Manali">
															</div>
															<div class='mt-repeater-hotel-input standard   col-md-2' >
																<label><strong>Standard:</strong></label>
																<textarea name="hotel_standard" required class='form-control'></textarea>
															</div>
															
															<div class='mt-repeater-hotel-input deluxe   col-md-2' >
																<label><strong>Deluxe:</strong></label>
																<textarea name="hotel_deluxe" required class='form-control'></textarea>
															</div>
															<div class='mt-repeater-hotel-input super_deluxe   col-md-2' >
																<label><strong>Super Deluxe:</strong></label>
																<textarea name="hotel_super_deluxe" required class='form-control'></textarea>
															</div>
															<div class='mt-repeater-hotel-input luxury   col-md-2' >
																<label><strong>Luxury:</strong></label>
																<textarea name="hotel_luxury" required class='form-control'></textarea>
															</div>
															<div class="mt-repeater-hotel-input col-md-1">
																<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																	<i class="fa fa-close"></i> Delete</a>
															</div>
														</div> <!-- row -->
													</div>
												<?php } ?>	
											</div>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-hotel-add">
											<i class="fa fa-plus"></i> Add Hotel</a>
											<hr>
										</div>
										
										
										<div class="mt-repeater-hotel-note tour_field_repeater">
											<div data-repeater-list="hotel_note_meta">
												<label class="control-label">Add Hotel Note: </label>
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
															<div class="mt-repeater-hotel-note-input col-md-3">
																<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete">
																<i class="fa fa-close"></i> Delete</a>
															</div>
														</div>
													<?php } 
												}else{ ?>		
												<?php $count_hotel_notes = count( $hotel_notes );
													if( $count_hotel_notes > 0 ){ ?>
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
												<?php } ?>	
											</div>
											<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-hotel-note">
											<i class="fa fa-plus"></i> Add Note</a>
										</div>
									</div>
									<div class="tab-pane" id="tab7">
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
						<input type="hidden" value="<?php echo $iti->agent_id ?>" name="agent_id">
						<input id="unique_key" type="hidden" name="temp_key" value="<?php echo $iti->temp_key; ?>">
						<input id="package_id" type="hidden" name="package_id" value="<?php echo $iti->package_id; ?>">
					</form>	
					<div id="res"></div>
			</div>
			</div>
 
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		//submit form
	$("#SubmitForm").click(function(){
		var formData = $('#itiForm_form').serializeArray();
		var resp = $("#res");
		var ajaxReq;
		if (ajaxReq) {
			ajaxReq.abort();
		}
		ajaxReq = $.ajax({
			type: "POST",
			url: "<?php echo base_url('packages/addPackage'); ?>",
		   data: formData,
		   dataType: "json",
			beforeSend: function(){
				resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			},
			success: function(res) {
				if (res.status == true){
					resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
					//console.log("done");
					$('#itiForm_form')[0].reset();
					//console.log(res.msg);
					window.location.href = "<?php echo site_url('packages/view/');?>" + res.package_id + "/" + res.temp_key;
					
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
				var form = $('#itiForm_form');
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
						tour_name: {required: true},
						package_routing: {required: true},
						package_duration: {required: true},
						total_travellers: {required: true},
						meal_plan: {required: true},
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
					App.scrollTo($('.page-title'));
				}

				// default form wizard
				$('#form_wizard_1').bootstrapWizard({
					'nextSelector': '.button-next',
					'previousSelector': '.button-previous',
					onTabClick: function (tab, navigation, index, clickedIndex) {
						if( $("ul#clickable_steps" ).hasClass("clickable_steps") ){
							//console.log("d");
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
						
						//add hot destination on daywise iti
						if( currentIndex == 2 ){
							$(".hot_des").each(function(){
								var t_values = $(this).find(".tags_values");
								var spans = $(this).find("span");
								var tag_text_arr = $.map(spans, function(elem, index){
									return $( elem ).text();
								}).join(",");
								t_values.val( tag_text_arr );
								console.log(tag_text_arr);
								
							});
						}
						//get value for second step
						var formData 	= $('#itiForm_form').serializeArray();
						//Push step to form data
						var step = { name: "step",  value: currentIndex };
						formData.push(step);
						
						
						//check for ajax request
						if (ajaxReq) {
							ajaxReq.abort();
						}
						ajaxReq = $.ajax({
							type: "POST",
							url: "<?php echo base_url('packages/ajax_savedata_stepwise'); ?>",
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
			/*Day wise itinerary */
			jQuery('.mt-repeater').each(function(){
				var nexti = 1;
				//$(this).find(".del_rep").hide();
				$(this).find(".del_rep:eq( 0 )").hide();
				$(this).repeater({
					show: function () {
						//set day wise itinerary preview
						//	console.log($(this).prev(".mt-repeater-item").repeaterVal()); //to retrieve the latest list 
						$(this).find(".hot_des span").remove();
						var tour_data = $(this).prev(".mt-repeater-item").repeaterVal();
						var count_daywise_div	 = $('.daywise_section').length;
						var c_day = count_daywise_div-1;
			
						//console.log("day " + c_day);
						//console.log(tour_data);
						var resultData	  = $("#tour_data_preview");
						var tour_day 	  = tour_data["tour_meta"][0]["tour_day"];
						var tour_name 	  = tour_data["tour_meta"][0]["tour_name"];
						var tour_des 	  = tour_data["tour_meta"][0]["tour_des"];
						var tour_date 	  = tour_data["tour_meta"][0]["tour_date"];
						var tour_distant  = $(this).prev(".mt-repeater-item").find(".tour_distant").val();
						var meal_plan  	  = tour_data["tour_meta"][0]["meal_plan"];
						//console.log("Tour: " + tour_name);
						resultData.append("<div class='day_wise_preview' id=day_" + c_day  + "><strong class='day_pr'> Day: <span class='dd'>" + tour_day + "</span> </strong><h2>" + tour_name + "</h2><br>Tour Description: " + tour_des + "</div><br>Tour Date: " + tour_date + "</div><br>Meal Plan: " + meal_plan + "</div><br>Tour Distant: " + tour_distant + " Kilometer </div>" );
						
						//end set preview
						
						var ddd = $(this).prev(".mt-repeater-item").find(".sta_d").text();
						$(this).find(".sta_d").text(+ddd + +1);
						$(this).find(".del_rep").show();
	                	$(this).show();
						nexti++;
					},
		            hide: function (deleteElement) {
		                if(confirm('Are you sure you want to delete this element?')) {
							var get_current_div = $(this).find(".sta_d").text();
							//remove day from preview
							var rem_div = $("#tour_data_preview").find("#day_" + get_current_div );
							var nextDayDiv = rem_div.nextAll( ".day_wise_preview" );
							nextDayDiv.each(function(){
								var z=1;
								/*substract day*/
								var nexD = $(this).find(".dd").text(), ss = 1;
								var dSub = nexD - ss;
								$(this).find(".dd").text(dSub);
								$(this).attr("id", "day_" + dSub);
								ss++;
								console.log(nexD);
							});
							rem_div.remove();
							//console.log( get_current_div );
							nexti--;
						    $(this).slideUp(deleteElement);
							var nextDiv = $(this).nextAll(".mt-repeater-item");
							nextDiv.each(function(){
								var z=1;
								/*substract day*/
								var nexD = $(this).find(".sta_d").text(), ss = 1;
								var dSub = nexD - ss;
								$(this).find(".sta_d").text(dSub);
								ss++;
							});
							
						}
		            },
		            ready: function (setIndexes) {
						
		            },
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
			/* special inclusion Tour field repeater */
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
	$(function(){ 
		// ::: TAGS BOX
		$(document).on("focusout", ".hot_des input",function() {
			//var txt = this.value.replace(/[^a-z0-9\+\-\.\#]/ig,''); // allowed characters
			var txt = this.value;
			if(txt){
				$("<span/>", {text:txt.toLowerCase(), insertBefore:this});
			}	
			this.value = "";
		});
		$(document).on("keyup", ".hot_des input",function(ev) {
			// if: comma|enter (delimit more keyCodes with | pipe)
			if(/(188|13)/.test(ev.which)) $(this).focusout(); 
		});
		$(document).on("click", ".hot_des span", function() {
			$(this).remove(); 
		});
	});
</script>
	
<?php }else{
	redirect("packages");
} ?>	